<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AllUsers extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::with('activePlan')->where('role', '!=', 'admin')->get();
    }

    public function render()
    {
        return view('livewire.all-users');
    }
}