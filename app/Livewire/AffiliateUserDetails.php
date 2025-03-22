<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Earning;
use Livewire\Component;

class AffiliateUserDetails extends Component
{
    public $userId;
    public User $user;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);
    }

    public function render()
    {
        $invitedUsers = $this->user->referredUsers()
            ->get()
            ->map(function ($invitedUser) {
                // Calculate total earnings from this referred user
                $totalEarnings = Earning::where('user_id', $this->user->id)
                    ->where('referred_user_id', $invitedUser->id)
                    ->sum('amount');

                $invitedUser->total_earned = $totalEarnings; // Attach earnings to the user object
                return $invitedUser;
            });

        return view('livewire.affiliate-user-details', compact('invitedUsers'));
    }
}
