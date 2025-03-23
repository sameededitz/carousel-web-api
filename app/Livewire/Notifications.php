<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Withdrawal;

class Notifications extends Component
{
    public function render()
    {
        $withdrawals = Withdrawal::with('user')
            ->where('status', 'pending') // Only pending withdrawals
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.notifications', compact('withdrawals'));
    }
}
