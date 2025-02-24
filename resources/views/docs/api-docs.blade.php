<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">API Documentation</h1>

        <div class="alert alert-info">
            <strong>Note:</strong> All API requests must include the following header:
            <pre><code>Accept: application/json</code></pre>
        </div>

        <div id="contents" class="my-4">
            <h3>Contents</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="#google-auth">Google Authentication API Endpoint</a></li>
                <li class="list-group-item"><a href="#carousel-endpoints">Carousel API Endpoints</a></li>
            </ul>
        </div>

        <!-- Google Authentication API Endpoint -->
        <h2 class="mt-5" id="google-auth" class="section">Google Authentication API Endpoint</h2>
        <div class="accordion" id="googleAuthApiAccordion">

            <!-- Google Authentication -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGoogleAuth">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGoogleAuth" aria-expanded="false" aria-controls="collapseGoogleAuth">
                        Login with Google
                    </button>
                </h2>
                <div id="collapseGoogleAuth" class="accordion-collapse collapse" aria-labelledby="headingGoogleAuth"
                    data-bs-parent="#googleAuthApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/auth/google</h5>
                        <p>Authenticate a user using Google OAuth2 token.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "token": "required|string"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "User logged in successfully!",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "johndoe@example.com",
        "google_id": "1234567890",
        "avatar": "https://example.com/avatar.jpg",
        "email_verified_at": "2025-01-30 08:42:47",
        ...
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "Bearer"
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["The token field is required."]
}</code></pre>
                        <h6>Response (Error Logging in with Google):</h6>
                        <pre><code>{
    "status": false,
    "message": "Error logging in with Google. Please try again later.",
    "error": "Error: Detailed error message goes here."
}</code></pre>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel API Endpoints -->
        <h2 class="mt-5" id="carousel-endpoints" class="section">Carousel API Endpoints</h2>
        <div class="accordion" id="carouselApiAccordion">

            <!-- Get All Carousels -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetCarousels">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetCarousels" aria-expanded="false"
                        aria-controls="collapseGetCarousels">
                        Get All Carousels
                    </button>
                </h2>
                <div id="collapseGetCarousels" class="accordion-collapse collapse" aria-labelledby="headingGetCarousels"
                    data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousels</h5>
                        <p>Retrieve all carousels associated with the authenticated user.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "carousels": [
        {
            "id": 1,
            "title": "Carousel 1",
            "options": {...},
            "created_at": "2025-02-11T06:45:56.000000Z",
            "updated_at": "2025-02-11T06:45:56.000000Z"
        },
        {
            "id": 2,
            "title": "Carousel 2",
            "options": {...},
            "created_at": "2025-02-11T06:45:56.000000Z",
            "updated_at": "2025-02-11T06:45:56.000000Z"
        }
    ]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Get Carousel -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetCarousel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetCarousel" aria-expanded="false" aria-controls="collapseGetCarousel">
                        Get Carousel
                    </button>
                </h2>
                <div id="collapseGetCarousel" class="accordion-collapse collapse" aria-labelledby="headingGetCarousel"
                    data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousel/{carousel}</h5>
                        <p>Retrieve a specific carousel by ID.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "carousel": {
        "id": 1,
        "title": "Carousel 1",
        "options": {...},
        "created_at": "2025-02-11T06:45:56.000000Z",
        "updated_at": "2025-02-11T06:45:56.000000Z"
    }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Store or Update Carousel -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStoreCarousel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseStoreCarousel" aria-expanded="false"
                        aria-controls="collapseStoreCarousel">
                        Create or Update Carousel
                    </button>
                </h2>
                <div id="collapseStoreCarousel" class="accordion-collapse collapse"
                    aria-labelledby="headingStoreCarousel" data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/carousel</h5>
                        <p>Create or update a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "nullable|exists:carousels,id",
    "title": "required|string",
    "options": "nullable|array",
    "image": "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:30720"
}</code></pre>
                        <h6>Response (Carousel Created):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel created successfully",
    "carousel": {
        "id": 3,
        "title": "New Carousel",
        "options": {...},
        "created_at": "2025-02-11T06:45:56.000000Z",
        "updated_at": "2025-02-11T06:45:56.000000Z"
    }
}</code></pre>
                        <h6>Response (Carousel Updated):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel updated successfully",
    "carousel": {
        "id": 1,
        "title": "Updated Carousel",
        "options": {...},
        "created_at": "2025-02-11T06:45:56.000000Z",
        "updated_at": "2025-02-11T06:45:56.000000Z"
    }
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["Error message"]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Delete Carousel -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDeleteCarousel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDeleteCarousel" aria-expanded="false"
                        aria-controls="collapseDeleteCarousel">
                        Delete Carousel
                    </button>
                </h2>
                <div id="collapseDeleteCarousel" class="accordion-collapse collapse"
                    aria-labelledby="headingDeleteCarousel" data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>DELETE /api/carousel/delete</h5>
                        <p>Delete a carousel by ID.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel deleted successfully"
}</code></pre>
                        <h6>Response (Carousel Not Found):</h6>
                        <pre><code>{
    "status": false,
    "message": "Carousel not found"
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["Error message"]
}</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5" id="purchase-endpoints" class="section">Purchase API Endpoints</h2>
        <div class="accordion" id="purchaseApiAccordion">

            <!-- Active Purchase -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingActivePurchase">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseActivePurchase" aria-expanded="false"
                        aria-controls="collapseActivePurchase">
                        Active Purchase
                    </button>
                </h2>
                <div id="collapseActivePurchase" class="accordion-collapse collapse"
                    aria-labelledby="headingActivePurchase" data-bs-parent="#purchaseApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/purchase/active</h5>
                        <p>Retrieve the active purchase of the authenticated user.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "Active plan found.",
    "plan": {
        // Active plan details
    }
}</code></pre>
                        <h6>Response (Not Found):</h6>
                        <pre><code>{
    "status": false,
    "message": "No active plan found."
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Purchase History -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPurchaseHistory">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePurchaseHistory" aria-expanded="false"
                        aria-controls="collapsePurchaseHistory">
                        Purchase History
                    </button>
                </h2>
                <div id="collapsePurchaseHistory" class="accordion-collapse collapse"
                    aria-labelledby="headingPurchaseHistory" data-bs-parent="#purchaseApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/purchase/history</h5>
                        <p>Retrieve the purchase history of the authenticated user.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "purchases": [
        // List of purchases
    ]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Add Purchase -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAddPurchase">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseAddPurchase" aria-expanded="false"
                        aria-controls="collapseAddPurchase">
                        Add Purchase
                    </button>
                </h2>
                <div id="collapseAddPurchase" class="accordion-collapse collapse"
                    aria-labelledby="headingAddPurchase" data-bs-parent="#purchaseApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/purchase/add</h5>
                        <p>Add a new purchase or extend an existing one for the authenticated user.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "plan_id": "required|exists:plans,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "Purchase created successfully!",
    "purchase": {
        // Purchase details
    }
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["Error message"]
}</code></pre>
                    </div>
                </div>
            </div>

        </div>

        <h2 class="mt-5" id="plans-endpoint" class="section">Plans API Endpoint</h2>
        <div class="accordion" id="plansApiAccordion">

            <!-- Plans -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPlans">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePlans" aria-expanded="false" aria-controls="collapsePlans">
                        Plans
                    </button>
                </h2>
                <div id="collapsePlans" class="accordion-collapse collapse" aria-labelledby="headingPlans"
                    data-bs-parent="#plansApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/plans</h5>
                        <p>Retrieve a list of all available plans.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "plans": [
        // List of plans
    ]
}</code></pre>
                    </div>
                </div>
            </div>

        </div>

        <!-- Image Upload API Endpoint -->
        <h2 class="mt-5" id="image-upload-endpoint" class="section">Image Upload API Endpoint</h2>
        <div class="accordion" id="imageUploadApiAccordion">

            <!-- Upload Image -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUploadImage">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseUploadImage" aria-expanded="false"
                        aria-controls="collapseUploadImage">
                        Upload Image
                    </button>
                </h2>
                <div id="collapseUploadImage" class="accordion-collapse collapse"
                    aria-labelledby="headingUploadImage" data-bs-parent="#imageUploadApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/image/upload</h5>
                        <p>Upload an image file to the server. Returns the URL of the uploaded image. Provide Url to
                            delete old image</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "image": "required|image|mimes:jpeg,png,jpg,gif,svg|max:30720", // max 30MB
    "old_url" => "nullable|url",
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "url": "https://your-storage-url/path/to/uploaded/image.jpg"
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["Error message"]
}</code></pre>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script>
        // Smooth scrolling behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

</body>

</html>
