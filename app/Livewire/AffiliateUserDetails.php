<?php

namespace App\Livewire;

use App\Models\User;
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
        $invitedUsers = $this->user->referredUsers()->paginate(5);

        return view('livewire.affiliate-user-details', compact('invitedUsers'));
    }
}
