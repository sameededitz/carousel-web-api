<div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Plans</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Plan</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Edit Plan</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="py-2">
                            @foreach ($errors->all() as $error)
                                <x-alert type="danger" :message="$error" />
                            @endforeach
                        </div>
                    @endif
                    <form wire:submit.prevent="update">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input type="text" wire:model.blur="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <input type="text" wire:model.blur="description" class="form-control"
                                    placeholder="Description">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Price</label>
                                <input type="number" wire:model.blur="price" step="0.01" class="form-control" placeholder="Price">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Duration</label>
                                <input type="number" wire:model.blur="duration" class="form-control"
                                    placeholder="Duration">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Duration Unit</label>
                                <select name="duration_unit" wire:model.blur="duration_unit" class="form-select">
                                    <option value="" selected>Select Duration Unit</option>
                                    <option value="day">Day</option>
                                    <option value="week">Week</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
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