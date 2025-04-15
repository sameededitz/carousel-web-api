<div>
    @if (session('message'))
        <div class="row py-3">
            <div class="col-6">
                <x-alert type="success" :message="session('message', 'Operation completed successfully.')" />
            </div>
        </div>
    @endif

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0"></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Posts</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Categories</h5>
                    <a href="{{ route('add-post') }}">
                        <button type="button" class="btn rounded-pill btn-outline-info-600 radius-8 px-20 py-11">Add
                            Post</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <select class="form-select form-select-sm w-auto ps-12 py-9 radius-12 h-40-px"
                                wire:model.live="perPage">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <select wire:model.live="statusFilter"
                                class="form-select form-select-sm w-auto ps-12 py-9 radius-12 h-40-px">
                                <option value="">All Status</option>
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>
                        <div class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" wire:model.live="search"
                                placeholder="Search...">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </div>
                    </div>
                    <div class="table-responsive" id="paginated-table-withdrawals">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td class="fw-semibold">{{ $post->id }}</td>
                                        <td>
                                            <img src="{{ $post->getFirstMediaUrl('image') }}" alt="Placeholder"
                                                class="w-120-px radius-8 object-fit-cover">
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td> {{ $post->category->name ?? 'N/A' }} </td>
                                        <td>{{ $post->user->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($post->is_published)
                                                <span
                                                    class="badge bg-success-100 text-success-600 px-20 py-9 radius-4 text-white">Published</span>
                                            @else
                                                <span
                                                    class="badge bg-warning-100 text-warning-600 px-20 py-9 radius-4 text-white">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if (!$post->is_published)
                                                    <button wire:click="$js.confirmPublish({{ $post->id }})"
                                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="ic:baseline-check"></iconify-icon>
                                                    </button>
                                                @else
                                                    <button wire:click="$js.confirmUnpublish({{ $post->id }})"
                                                        class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="fluent:eye-off-16-filled"></iconify-icon>
                                                    </button>
                                                @endif

                                                <a href="{{ route('edit-post', $post->slug) }}"
                                                    class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="mdi:pencil-outline"></iconify-icon>
                                                </a>

                                                <a href="{{ route('view-post', $post->slug) }}"
                                                    class="w-32-px h-32-px btn-lilac-100 text-lilac-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="mdi:eye-outline"></iconify-icon>
                                                </a>

                                                <button wire:click="$js.confirmDelete({{ $post->id }})"
                                                    class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Posts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $posts->links('components.pagination', data: ['scrollTo' => '#paginated-table-withdrawals']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $js('confirmPublish', (id) => {
            Swal.fire({
                title: 'Publish Post?',
                text: "Are you sure you want to publish this post?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ab55',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, publish!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.publishPost(id);
                }
            });
        });

        $js('confirmUnpublish', (id) => {
            Swal.fire({
                title: 'Unpublish Post?',
                text: "This will remove it from public view.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffa000',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, unpublish!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.unpublishPost(id);
                }
            });
        });

        $js('confirmDelete', (id) => {
            Swal.fire({
                title: 'Delete Post?',
                text: "This action cannot be undone!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deletePost(id);
                }
            });
        });

        $wire.on('sweetAlert', (event) => {
            let type = event.type;
            let message = event.message;
            let title = event.title;
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                timer: 2000,
                showCancelButton: false,
            });
        });
    </script>
@endscript
