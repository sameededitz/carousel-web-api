<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Withdrawal;
use Livewire\WithPagination;
use App\Jobs\SendUserNotification;

class AllWithdrawals extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search query changes
    }

    public function updatedStatusFilter()
    {
        $this->resetPage(); // Reset pagination when filter changes
    }

    public function approveWithdrawal($withdrawalId)
    {
        $withdrawal = Withdrawal::find($withdrawalId);
        if ($withdrawal && $withdrawal->status === 'pending') {
            // Check if the user has payment details set
            $user = $withdrawal->user;
            if (!$user->paymentDetails) {
                $this->dispatch('sweetAlert', type: 'error', message: 'User has not set their payment details.', title: 'Approval Failed');
                return;
            }

            $withdrawal->update(['status' => 'approved']);

            SendUserNotification::dispatch(
                $withdrawal->user->email,
                $withdrawal->user->name,
                'Withdrawal Approved',
                "Your withdrawal of \${$withdrawal->amount} has been approved. You will receive the funds shortly.",
            );

            $this->dispatch('sweetAlert', type: 'success', message: 'Withdrawal approved successfully.', title: 'Approved');
        }
    }

    public function rejectWithdrawal($withdrawalId, $reason)
    {
        $withdrawal = Withdrawal::find($withdrawalId);
        if ($withdrawal && $withdrawal->status === 'pending') {
            $withdrawal->user->increment('balance', $withdrawal->amount);

            $withdrawal->update(['status' => 'rejected']);

            SendUserNotification::dispatch(
                $withdrawal->user->email,
                $withdrawal->user->name,
                'Withdrawal Rejected',
                "Your withdrawal of \${$withdrawal->amount} has been rejected. The amount has been refunded to your balance. \nReason: {$reason}",
            );

            $this->dispatch('sweetAlert', type: 'success', message: 'Withdrawal rejected successfully.', title: 'Rejected');
        }
    }

    public function render()
    {
        $query = Withdrawal::with('user')
            ->where(function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('paypal_email', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('amount', 'like', '%' . $this->search . '%')
                    ->orWhereDate('created_at', $this->search);
            });

        // Apply Status Filter if Selected
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $withdrawals = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.all-withdrawals', compact('withdrawals'));
    }
}
