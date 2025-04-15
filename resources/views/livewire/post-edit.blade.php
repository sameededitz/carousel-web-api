@section('admin_styles')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/lib/custom-filepond.css') }}">
@endsection
@section('title', 'Add Blog')
<div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Blog</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Blogs</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Update Blog</h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store" enctype="multipart/form-data">
                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label for="file" class="form-label">Thumbnail Image</label>
                                <div class="upload-image-wrapper">
                                    <div class="uploaded-img position-relative h-160-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                        @if ($image)
                                            <button type="button" wire:click="removeImage" class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex bg-danger-600 w-40-px h-40-px justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="radix-icons:cross-2" class="text-2xl text-white"></iconify-icon>
                                            </button>
                                        @endif
                                        <img id="uploaded-img__preview" class="w-100 h-100 object-fit-cover" src="{{ $image ? $image->temporaryUrl() : $post->getFirstMediaUrl('image') }}" alt="image">
                                    </div>
                                    <label class="upload-file h-160-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1" for="upload-file">
                                        <iconify-icon icon="solar:camera-outline" class="text-xl text-secondary-light"></iconify-icon>
                                        <span class="fw-semibold text-secondary-light">Upload</span>
                                        <input id="upload-file" type="file" wire:model="image" hidden>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" wire:model.lazy="title" class="form-control" id="title"
                                    placeholder="Enter title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select wire:model.lazy="category" class="form-select" id="category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tags" class="form-label">Tags</label>
                                <div wire:ignore>
                                    <select wire:model.lazy="tags" class="form-select select2 w-100" name="tags[]"
                                        id="tags" style="width: 100%" multiple>
                                        <option value="">Select Tags</option>
                                        @foreach ($tagsList as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('tags')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea wire:model.lazy="excerpt" class="form-control" id="excerpt" placeholder="Enter excerpt"></textarea>
                                @error('excerpt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12" wire:ignore>
                                <label for="description" class="form-label">Description</label>
                                <textarea id="myeditorinstance" wire:model="content" class="form-control"></textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-switch switch-success d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch3" wire:model="is_published">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch3">Publish?</label>
                                </div>
                                @error('is_published')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
</div>

@assets
    <script src="https://cdn.tiny.cloud/1/{{ env('TINY_CLOUD_API_KEY') }}/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
@endassets

@script
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Tags",
                width: '100%'
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('tags', data);
            });
        });

        tinymce.init({
            selector: 'textarea#myeditorinstance',
            relative_urls: false,
            remove_script_host: false,
            plugins: [
                "advlist", "anchor", "autolink", "charmap", "code", "fullscreen",
                "help", "insertdatetime", "link", "lists", "media",
                "preview", "searchreplace", "table", "visualblocks", "accordion",
                "emoticons", "codesample",
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            skin: (document.querySelector('html')?.getAttribute('data-theme') === "dark" ? "oxide-dark" : "oxide"),
            content_css: (document.querySelector('html')?.getAttribute('data-theme') === "dark" ? "dark" : ""),
            setup: function(editor) {
                editor.on('init change', function() {
                    editor.save();
                });

                editor.on('BeforeSetContent', function(e) {
                    const content = e.content;
                    e.content = content;
                });

                editor.on('change', function(e) {
                    let content = editor.getContent();
                    @this.set('content', content);
                });
            }
        });
    </script>
@endscript

@section('admin_scripts')
    @filepondScripts
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('admin_assets/css/lib/custom-select2.css') }}">
@endsection
