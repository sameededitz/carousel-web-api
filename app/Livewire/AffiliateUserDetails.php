<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Earning;
use Livewire\Component;
use App\Models\Withdrawal;
use Livewire\WithPagination;
use App\Jobs\SendUserNotification;
use App\Mail\UserNotificationMail;
use Illuminate\Support\Facades\Mail;

class AffiliateUserDetails extends Component
{
    use WithPagination;

    public $userId;
    public User $user;

    public $invitedPerPage = 5;
    public $earningsPerPage = 5;
    public $withdrawalsPerPage = 5;

    public $invitedSearch = '';
    public $earningsSearch = '';
    public $withdrawalsSearch = '';

    public $statusFilter = '';

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);
    }

    public function updatingInvitedSearch()
    {
        $this->resetPage('invitedPage');
    }

    public function updatingEarningsSearch()
    {
        $this->resetPage('earningsPage');
    }

    public function updatingWithdrawalsSearch()
    {
        $this->resetPage('withdrawalsPage');
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function notifyUser()
    {
        $user = $this->user; // Assuming you're setting the user in mount()

        if ($user) {
            SendUserNotification::dispatch(
                $user->email,
                $user->name,
                'Payment Method Not Set',
                "Please set up your PayPal details to enable withdrawals."
            );

            $this->dispatch('sweetAlert', type: 'success', message: 'User notified successfully.', title: 'Notification Sent');
        }
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
        $paymentdetails = $this->user->paymentdetails;

        $invitedUsers = $this->user->referredUsers()
            ->select('id', 'name', 'email', 'referred_by', 'created_at')
            ->withSum('earningsFromReferrals', 'amount')
            ->when($this->invitedSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->invitedSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->invitedSearch . '%');
            })
            ->paginate($this->invitedPerPage, ['*'], 'invitedPage');

        $earnings = Earning::where('user_id', $this->user->id)
            ->with('referredUser:id,name,email')
            ->latest()
            ->when($this->earningsSearch, function ($query) {
                $query->whereHas('referredUser', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->earningsSearch . '%')
                        ->orWhere('email', 'like', '%' . $this->earningsSearch . '%');
                })->orWhere('amount', 'like', '%' . $this->earningsSearch . '%');
            })
            ->paginate($this->earningsPerPage, ['*'], 'earningsPage');

        $withdrawals = $this->user->withdrawals()
            ->when($this->withdrawalsSearch, function ($query) {
                $query->where('paypal_email', 'like', '%' . $this->withdrawalsSearch . '%')
                    ->orWhere('status', 'like', '%' . $this->withdrawalsSearch . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate($this->withdrawalsPerPage, ['*'], 'withdrawalsPage');

        return view('livewire.affiliate-user-details', compact('paymentdetails', 'invitedUsers', 'earnings', 'withdrawals'));
    }
}
