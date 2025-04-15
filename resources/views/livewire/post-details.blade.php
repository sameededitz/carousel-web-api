@section('admin_styles')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/lib/custom-filepond.css') }}">
@endsection
@section('title', 'Add Blog')
<div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Blog Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Blogs</li>
            <li>-</li>
            <li class="fw-medium"> {{ Str::limit($post->title, 10) }} </li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-8">
            <div class="card p-0 radius-12 overflow-hidden">
                <div class="card-body p-0">
                    <img src="{{ $post->getFirstMediaUrl('image') }}" alt=""
                        class="w-100 h-100 object-fit-cover">
                    <div class="p-32">
                        <div class="d-flex align-items-center gap-16 justify-content-between flex-wrap mb-24">
                            <div class="d-flex align-items-center gap-md-3 gap-2 flex-wrap">
                                <div class="d-flex align-items-center gap-8 text-neutral-500 text-lg fw-medium">
                                    <iconify-icon icon="iconamoon:category-light"></iconify-icon>
                                    <span class="text-info">{{ $post->category->name }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-8 text-neutral-500 text-lg fw-medium">
                                    <i class="ri-calendar-2-line"></i>
                                    <span class="text-info">{{ $post->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="mb-16"> {{ $post->title }} </h3>
                        <div class="content">
                            <p class="text-neutral-500 mb-16">
                                {!! $post->content !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-24">
                <!-- Tags -->
                <div class="card">
                    <div class="card-header border-bottom">
                        <h6 class="text-xl mb-0">Tags</h6>
                    </div>
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-8">
                            @foreach ($post->tags as $tag)
                                <span
                                    class="btn btn-sm btn-primary-600 bg-primary-50 bg-hover-primary-600 text-primary-600 border-0 d-inline-flex align-items-center gap-1 text-sm px-16 py-6">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
    <script src="https://cdn.tiny.cloud/1/{{ env('TINY_CLOUD_API_KEY') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin">
    </script>
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
