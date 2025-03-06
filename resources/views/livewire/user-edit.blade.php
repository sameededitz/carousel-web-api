<div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Users</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">User</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Update User</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="py-2">
                            @foreach ($errors->all() as $error)
                                <x-alert type="danger" :message="$error" />
                            @endforeach
                        </div>
                    @endif
                    <form wire:submit.prevent="submit">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input type="text" wire:model.live="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" wire:model.live="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Role</label>
                                <select class="form-select" wire:model="role">
                                    <option selected>Select Status</option>
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                    <option value="affiliate">Affiliate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary-600">Update</button>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
</div>
