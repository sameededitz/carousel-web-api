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

        <h2>Carousel API Endpoints</h2>
        <div class="accordion" id="carouselApiAccordion">

            <!-- Fetch All Carousels -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCarousels">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCarousels" aria-expanded="true" aria-controls="collapseCarousels">
                        Fetch All Carousels
                    </button>
                </h2>
                <div id="collapseCarousels" class="accordion-collapse collapse show" aria-labelledby="headingCarousels"
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
        <h2 class="mt-5">Content Text API Endpoints</h2>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
