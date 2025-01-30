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
                <li class="list-group-item"><a href="#content-text-endpoints">Content Text API Endpoints</a></li>
                <li class="list-group-item"><a href="#color-endpoints">Color API Endpoints</a></li>
                <li class="list-group-item"><a href="#brand-endpoints">Brand API Endpoints</a></li>
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

        <h2 class="mt-5" id="carousel-endpoints" class="section">Carousel API Endpoints</h2>
        <div class="accordion" id="carouselApiAccordion">

            <!-- Fetch All Carousels -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCarousels">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCarousels" aria-expanded="false" aria-controls="collapseCarousels">
                        Fetch All Carousels
                    </button>
                </h2>
                <div id="collapseCarousels" class="accordion-collapse collapse" aria-labelledby="headingCarousels"
                    data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousels</h5>
                        <p>Retrieve a list of all carousels associated with the authenticated user.</p>
                        <h6>Response:</h6>
                        <pre><code>{
    "status": true,
    "carousels": [...]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Get Carousel by ID -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetCarousel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetCarousel" aria-expanded="false" aria-controls="collapseGetCarousel">
                        Get Carousel by ID
                    </button>
                </h2>
                <div id="collapseGetCarousel" class="accordion-collapse collapse" aria-labelledby="headingGetCarousel"
                    data-bs-parent="#carouselApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousel/{carousel}</h5>
                        <p>Retrieve the details of a specific carousel by its ID.</p>
                        <h6>Response:</h6>
                        <pre><code>{
    "status": true,
    "carousel": {...}
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Create or Update Carousel -->
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
                        <p>Create a new carousel or update an existing one.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "nullable|exists:carousels,id",
    "locale": "required|string",
    "current_index": "required|integer",
    "zoom_value": "required|numeric",
    "slide_ratio_id": "required|integer",
    "slide_ratio_width": "required|numeric",
    "slide_ratio_height": "required|numeric"
}</code></pre>
                        <h6>Response (Success - New Carousel Created):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel created successfully",
    "carousel": {...}
}</code></pre>
                        <h6>Response (Success - Carousel Updated):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel updated successfully",
    "carousel": {...}
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
                        <p>Delete a specific carousel by its ID.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "Carousel deleted successfully"
}</code></pre>
                        <h6>Response (Not Found):</h6>
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

        <!-- Content Text API Endpoints -->
        <h2 class="mt-5" id="content-text-endpoints" class="section">Content Text API Endpoints</h2>
        <div class="accordion" id="contentTextApiAccordion">

            <!-- Get Content Text -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetContentText">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetContentText" aria-expanded="false"
                        aria-controls="collapseGetContentText">
                        Get Content Text for Carousel
                    </button>
                </h2>
                <div id="collapseGetContentText" class="accordion-collapse collapse"
                    aria-labelledby="headingGetContentText" data-bs-parent="#contentTextApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousel/{carousel}/content-text</h5>
                        <p>Retrieve the content text associated with a carousel.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "contentText": {...}
}</code></pre>
                        <h6>Response (Not Found):</h6>
                        <pre><code>{
    "status": false,
    "contentText": null
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Store or Update Content Text -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStoreContentText">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseStoreContentText" aria-expanded="false"
                        aria-controls="collapseStoreContentText">
                        Create or Update Content Text
                    </button>
                </h2>
                <div id="collapseStoreContentText" class="accordion-collapse collapse"
                    aria-labelledby="headingStoreContentText" data-bs-parent="#contentTextApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/carousel/content-text</h5>
                        <p>Create or update content text for a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id",
    "is_custom_fonts_enabled": "required|boolean",
    "primary_font_name": "required|string",
    "primary_font_href": "required|string",
    "secondary_font_name": "required|string",
    "secondary_font_href": "required|string",
    "font_size": "required|numeric",
    "font_text_alignment": "required|in:center,left,right"
}</code></pre>
                        <h6>Response (Content Text Created):</h6>
                        <pre><code>{
    "status": true,
    "message": "ContentText created successfully",
    "contentText": {...}
}</code></pre>
                        <h6>Response (Content Text Updated):</h6>
                        <pre><code>{
    "status": true,
    "message": "ContentText updated successfully",
    "contentText": {...}
}</code></pre>
                        <h6>Response (Validation Errors):</h6>
                        <pre><code>{
    "status": false,
    "message": ["Error message"]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Delete Content Text -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDeleteContentText">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDeleteContentText" aria-expanded="false"
                        aria-controls="collapseDeleteContentText">
                        Delete Content Text
                    </button>
                </h2>
                <div id="collapseDeleteContentText" class="accordion-collapse collapse"
                    aria-labelledby="headingDeleteContentText" data-bs-parent="#contentTextApiAccordion">
                    <div class="accordion-body">
                        <h5>DELETE /api/carousel/content-text</h5>
                        <p>Delete content text associated with a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "ContentText deleted successfully"
}</code></pre>
                        <h6>Response (No Content Found):</h6>
                        <pre><code>{
    "status": false,
    "message": "No content text found for this carousel."
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

        <!-- Color API Endpoints -->
        <h2 class="mt-5" id="color-endpoints" class="section">Color API Endpoints</h2>
        <div class="accordion" id="colorApiAccordion">

            <!-- Get Color -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetColor">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetColor" aria-expanded="false" aria-controls="collapseGetColor">
                        Get Colors for Carousel
                    </button>
                </h2>
                <div id="collapseGetColor" class="accordion-collapse collapse" aria-labelledby="headingGetColor"
                    data-bs-parent="#colorApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousel/{carousel}/color</h5>
                        <p>Retrieve the colors associated with a carousel.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "color": {
        "is_use_custom_colors": true,
        "is_alternate_slide_colors": false,
        "background_color": "#ffffff",
        "text_color": "#000000",
        "accent_color": "#ff0000"
    }
}</code></pre>
                        <h6>Response (Not Found):</h6>
                        <pre><code>{
    "status": false,
    "color": null
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Store or Update Color -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStoreColor">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseStoreColor" aria-expanded="false"
                        aria-controls="collapseStoreColor">
                        Create or Update Colors
                    </button>
                </h2>
                <div id="collapseStoreColor" class="accordion-collapse collapse" aria-labelledby="headingStoreColor"
                    data-bs-parent="#colorApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/carousel/color</h5>
                        <p>Create or update colors for a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id",
    "is_use_custom_colors": "required|boolean",
    "is_alternate_slide_colors": "required|boolean",
    "background_color": "required|string",
    "text_color": "required|string",
    "accent_color": "required|string"
}</code></pre>
                        <h6>Response (Color Created):</h6>
                        <pre><code>{
    "status": true,
    "message": "Color settings created successfully",
    "color": {
        "is_use_custom_colors": true,
        "is_alternate_slide_colors": false,
        "background_color": "#ffffff",
        "text_color": "#000000",
        "accent_color": "#ff0000"
    }
}</code></pre>
                        <h6>Response (Color Updated):</h6>
                        <pre><code>{
    "status": true,
    "message": "Color settings updated successfully",
    "color": {
        "is_use_custom_colors": true,
        "is_alternate_slide_colors": false,
        "background_color": "#ffffff",
        "text_color": "#000000",
        "accent_color": "#ff0000"
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

            <!-- Delete Color -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDeleteColor">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDeleteColor" aria-expanded="false"
                        aria-controls="collapseDeleteColor">
                        Delete Colors
                    </button>
                </h2>
                <div id="collapseDeleteColor" class="accordion-collapse collapse"
                    aria-labelledby="headingDeleteColor" data-bs-parent="#colorApiAccordion">
                    <div class="accordion-body">
                        <h5>DELETE /api/carousel/color</h5>
                        <p>Delete colors associated with a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "ContentText deleted successfully"
}</code></pre>
                        <h6>Response (No Colors Found):</h6>
                        <pre><code>{
    "status": false,
    "message": "No colors found for this carousel."
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

        <!-- Brand API Endpoints -->
        <h2 class="mt-5"  id="brand-endpoints" class="section">Brand API Endpoints</h2>
        <div class="accordion" id="brandApiAccordion">

            <!-- Get Brand -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGetBrand">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseGetBrand" aria-expanded="false" aria-controls="collapseGetBrand">
                        Get Brand for Carousel
                    </button>
                </h2>
                <div id="collapseGetBrand" class="accordion-collapse collapse" aria-labelledby="headingGetBrand"
                    data-bs-parent="#brandApiAccordion">
                    <div class="accordion-body">
                        <h5>GET /api/carousel/{carousel}/brand</h5>
                        <p>Retrieve the brand associated with a carousel.</p>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "brand": {
        "is_show_in_intro_slide": true,
        "is_show_in_outro_slide": false,
        "is_show_in_regular_slide": true,
        "name_text": "Brand Name",
        "name_is_enabled": true,
        "handle_text": "@brandhandle",
        "handle_is_enabled": true,
        "profile_image_src": "path/to/image.jpg",
        "profile_image_is_enabled": true
    }
}</code></pre>
                        <h6>Response (Not Found):</h6>
                        <pre><code>{
    "status": false,
    "brand": null
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Store or Update Brand -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingStoreBrand">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseStoreBrand" aria-expanded="false"
                        aria-controls="collapseStoreBrand">
                        Create or Update Brand
                    </button>
                </h2>
                <div id="collapseStoreBrand" class="accordion-collapse collapse" aria-labelledby="headingStoreBrand"
                    data-bs-parent="#brandApiAccordion">
                    <div class="accordion-body">
                        <h5>POST /api/carousel/brand</h5>
                        <p>Create or update brand for a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id",
    "is_show_in_intro_slide": "required|boolean",
    "is_show_in_outro_slide": "required|boolean",
    "is_show_in_regular_slide": "required|boolean",
    "name_text": "required|string",
    "name_is_enabled": "required|boolean",
    "handle_text": "required|string",
    "handle_is_enabled": "required|boolean",
    "profile_image_src": "nullable|image|mimes:jpeg,png,jpg,gif|max:20420",
    "profile_image_is_enabled": "required|boolean"
}</code></pre>
                        <h6>Response (Brand Created):</h6>
                        <pre><code>{
    "status": true,
    "message": "Brand settings created successfully",
    "brand": {
        "is_show_in_intro_slide": true,
        "is_show_in_outro_slide": false,
        "is_show_in_regular_slide": true,
        "name_text": "Brand Name",
        "name_is_enabled": true,
        "handle_text": "@brandhandle",
        "handle_is_enabled": true,
        "profile_image_src": "path/to/image.jpg",
        "profile_image_is_enabled": true
    }
}</code></pre>
                        <h6>Response (Brand Updated):</h6>
                        <pre><code>{
    "status": true,
    "message": "Brand settings updated successfully",
    "brand": {
        "is_show_in_intro_slide": true,
        "is_show_in_outro_slide": false,
        "is_show_in_regular_slide": true,
        "name_text": "Brand Name",
        "name_is_enabled": true,
        "handle_text": "@brandhandle",
        "handle_is_enabled": true,
        "profile_image_src": "path/to/image.jpg",
        "profile_image_is_enabled": true
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

            <!-- Delete Brand -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDeleteBrand">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDeleteBrand" aria-expanded="false"
                        aria-controls="collapseDeleteBrand">
                        Delete Brand
                    </button>
                </h2>
                <div id="collapseDeleteBrand" class="accordion-collapse collapse"
                    aria-labelledby="headingDeleteBrand" data-bs-parent="#brandApiAccordion">
                    <div class="accordion-body">
                        <h5>DELETE /api/carousel/brand</h5>
                        <p>Delete brand associated with a carousel.</p>
                        <h6>Request Body:</h6>
                        <pre><code>{
    "carousel_id": "required|exists:carousels,id"
}</code></pre>
                        <h6>Response (Success):</h6>
                        <pre><code>{
    "status": true,
    "message": "Brand deleted successfully"
}</code></pre>
                        <h6>Response (No Brand Found):</h6>
                        <pre><code>{
    "status": false,
    "message": "No brand found for this carousel."
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
