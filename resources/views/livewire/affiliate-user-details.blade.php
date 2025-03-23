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
            <li class="fw-medium">Affiliates</li>
            <li>-</li>
            <li class="fw-medium">Manage</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Info</h5>
                </div>
                <div class="card-body">
                    <div class="mt-16">
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->name }} </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->email }} </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Role</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ Str::title($user->role) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Referral Code </span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->referral_code }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Balance:</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    {{ '$' . number_format($user->balance, 2) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Last Login</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    {{ $user->last_login ? $user->last_login->diffForHumans() : 'Never' }} </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Registered</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    {{ $user->created_at->toDayDateTimeString() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    <div class="mt-16">
                        <ul>
                            @if ($paymentdetails)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Payment Method</span>
                                    <span class="w-70 text-secondary-light fw-medium">: PayPal
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Account Username</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $paymentdetails->paypal_username }} </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">PayPal Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $paymentdetails->paypal_email }}
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">PayPal Phone</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $paymentdetails->paypal_phone }}
                                    </span>
                                </li>
                            @else
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Payment Method</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Not Set
                                    </span>
                                </li>
                                <button type="button" wire:click="notifyUser"
                                    class="btn btn-outline-primary-600 radius-8 px-20 py-11 text-sm">
                                    Notify User to Set Payment Method
                                </button>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Invited Users <span
                            class="text-sm">({{ $invitedUsers->total() }})</span></h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <select class="form-select form-select-sm w-auto ps-12 py-9 radius-12 h-40-px"
                            wire:model.live="invitedPerPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search"
                                wire:model.live="invitedSearch" placeholder="Search...">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </div>
                    </div>
                    <div class="table-responsive" id="paginated-table">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Total Earned</th>
                                    <th scope="col">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invitedUsers as $user)
                                    <tr>
                                        <td class="fw-semibold">{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>${{ number_format($user->earnings_from_referrals_sum_amount ?? 0, 2) }}
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Invited Users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $invitedUsers->links('components.pagination', data: ['scrollTo' => '#paginated-table']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Earning History <span
                            class="fs-6">({{ $earnings->total() }})</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <select class="form-select form-select-sm w-auto ps-12 py-9 radius-12 h-40-px"
                            wire:model.live="earningsPerPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search"
                                wire:model.live="earningsSearch" placeholder="Search...">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </div>
                    </div>
                    <div class="table-responsive" id="paginated-table-earnings">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Referred User</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Purchase ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($earnings as $earning)
                                    <tr>
                                        <td class="fw-semibold">{{ $earning->id }}</td>
                                        <td>{{ $earning->created_at->diffForHumans() }}</td>
                                        <td>{{ Str::title($earning->referredUser->name) }}</td>
                                        <td>${{ number_format($earning->amount, 2) }}</td>
                                        <td>{{ $earning->purchase_id }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Earnings found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $earnings->links('components.pagination', data: ['scrollTo' => '#paginated-table-earnings']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Withdrawals <span class="fs-6">({{ $withdrawals->total() }})</span>
                    </h5>
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
                            <select class="form-select form-select-sm w-auto ps-12 py-9 radius-12 h-40-px"
                                wire:model.live="statusFilter">
                                <option value="" selected>All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search"
                                wire:model.live="withdrawalsSearch" placeholder="Search...">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </div>
                    </div>
                    <div class="table-responsive" id="paginated-table-withdrawals">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">PayPal Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdrawals as $withdrawal)
                                    <tr>
                                        <td class="fw-semibold">{{ $withdrawal->id }}</td>
                                        <td>{{ $withdrawal->created_at->diffForHumans() }}</td>
                                        <td>${{ number_format($withdrawal->amount, 2) }}</td>
                                        <td>{{ $withdrawal->paypal_email }}</td>
                                        <td>
                                            @if ($withdrawal->status == 'pending')
                                                <span
                                                    class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">Pending</span>
                                            @elseif ($withdrawal->status == 'approved')
                                                <span
                                                    class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">Approved</span>
                                            @else
                                                <span
                                                    class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4 text-white">Declined</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($withdrawal->status == 'pending')
                                                    <button type="button"
                                                        class="w-32-px me-4 h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                        wire:click="$js.confirmApprove({{ $withdrawal->id }})">
                                                        <iconify-icon icon="ic:baseline-check"></iconify-icon>
                                                    </button>
                                                    <button type="button"
                                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                        wire:click="$js.confirmReject({{ $withdrawal->id }})">
                                                        <iconify-icon icon="heroicons:x-mark"></iconify-icon>
                                                    </button>
                                                @else
                                                    <span
                                                        class="badge text
                                                    @if ($withdrawal->status == 'approved') bg-success-100 text-success-600
                                                    @else
                                                        bg-danger-100 text-danger-600 @endif
                                                    px-20 py-9 radius-4 text-white">{{ $withdrawal->status == 'approved' ? 'Completed' : 'Declined' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Withdrawals found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $withdrawals->links('components.pagination', data: ['scrollTo' => '#paginated-table-withdrawals']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $js('confirmApprove', (id) => {
            Swal.fire({
                title: 'Approve Withdrawal?',
                text: "Are you sure you want to approve this withdrawal?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ab55',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.approveWithdrawal(id);
                }
            });
        });

        $js('confirmReject', (id) => {
            Swal.fire({
                title: 'Reject Withdrawal?',
                text: "Enter the reason for rejection:",
                icon: 'warning',
                input: 'text',
                inputPlaceholder: 'Enter reason...',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, reject!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.rejectWithdrawal(id, result.value);
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
