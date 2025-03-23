<div class="dropdown" wire:poll.10s> <!-- Auto refresh every 10s -->
    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
        @if($withdrawals->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
        @endif
    </button>
    
    <div class="dropdown-menu to-top dropdown-menu-lg p-0">
        <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
            <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
            <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">
                {{ $withdrawals->count() }}
            </span>
        </div>

        <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
            @forelse ($withdrawals as $withdrawal)
                <a href="{{ route('affiliate-manage', $withdrawal->user) }}" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                    <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                        <span class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                            {{ strtoupper(substr($withdrawal->user->name, 0, 2)) }}
                        </span> 
                        <div>
                            <h6 class="text-md fw-semibold mb-4">{{ $withdrawal->user->name }}</h6>
                            <p class="mb-0 text-sm text-secondary-light text-w-200-px">
                                Requested withdrawal of ${{ $withdrawal->amount }} - <span class="fw-semibold text-{{ $withdrawal->status == 'pending' ? 'warning' : ($withdrawal->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <span class="text-sm text-secondary-light flex-shrink-0">
                        {{ $withdrawal->created_at->diffForHumans() }}
                    </span>
                </a>
            @empty
                <p class="text-center text-secondary py-3">No new notifications</p>
            @endforelse
        </div>

        <div class="text-center py-12 px-16">
            <a href="{{ route('all-withdrawals') }}" class="text-primary-600 fw-semibold text-md">See All Withdrawals</a>
        </div>
    </div>
</div>