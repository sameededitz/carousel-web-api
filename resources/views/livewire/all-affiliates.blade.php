<div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Affiliates</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Affiliates</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Affiliates <span
                            class="text-muted">({{ $affiliateUsers->count() }})</span></h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                        <div>
                            <select name="per_page" id="filter" class="form-select" wire:model.live="perPage">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="ion:search-outline"></iconify-icon>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search..." wire:model.live="search">
                        </div>
                    </div>
                    <div class="table-responsive" id="paginated-table">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Referral Code</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($affiliateUsers as $user)
                                    <tr>
                                        <td class="fw-semibold">{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->referral_code }}</td>
                                        <td>{{ '$' . number_format($user->balance, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('affiliate-manage', $user->id) }}"
                                                    class="w-32-px me-4 h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="ic:round-manage-accounts"></iconify-icon>
                                                </a>
                                                {{-- <a href="{{ route('edit-affiliate', $user->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <iconify-icon data-icon="lucide:edit" class="icon"></iconify-icon>
                                                </a>
                                                <form action="{{ route('delete-affiliate', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <iconify-icon data-icon="mingcute:delete-2-line"
                                                            class="icon"></iconify-icon>
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No affiliates found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $affiliateUsers->links('components.pagination', data: ['scrollTo' => '#paginated-table']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
