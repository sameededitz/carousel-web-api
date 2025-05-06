@section('title', 'All Feedbacks')
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
            <li class="fw-medium">Feedbacks</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card basic-data-table">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Feedbacks</h5>
                </div>
                <div class="card-body scroll-sm" style="overflow-x: scroll">
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
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0" id="paginated-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Sent At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedback->id }}</td>
                                        <td>{{ $feedback->name }}</td>
                                        <td>{{ $feedback->email }}</td>
                                        <td>{{ $feedback->created_at->toFormattedDateString() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" wire:click="viewFeedback({{ $feedback->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#feedbackModel"
                                                    class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="material-symbols:visibility" width="20"
                                                        height="20"></iconify-icon>
                                                </button>
                                                <button wire:click="$js.confirmDelete({{ $feedback->id }})"
                                                    class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No feedbacks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $feedbacks->links('components.pagination', data: ['scrollTo' => '#paginated-table']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedbackModel" tabindex="-1" wire:ignore.self aria-labelledby="feedbackModel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        View Feedback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModel"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h6>Name</h6>
                            <p>{{ $name }}</p>
                        </div>
                        <div class="col-12">
                            <h6>Email</h6>
                            <p>{{ $email }}</p>
                        </div>
                        <div class="col-12">
                            <h6>Message</h6>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info d-flex align-items-center justify-content-center"
                        wire:click="closeModel" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@script
    <script>
        $js('confirmDelete', (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteFeedback(id);
                }
            });
        });

        $wire.on('closeModel', (event) => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('feedbackModel'));
            modal.hide();
        });

        $wire.on('sweetAlert', (event) => {
            Swal.fire({
                title: event.title,
                text: event.message,
                icon: event.type,
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endscript
