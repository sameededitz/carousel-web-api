<?php

namespace App\Livewire;

use App\Models\Carousel;
use App\Models\User;
use Livewire\Component;

class DashboardStats extends Component
{
    public $userCount;
    public $carouselCount;

    public function mount()
    {
        $this->userCount = User::where('role', '!=', 'admin')->count();
        $this->carouselCount = Carousel::count();
    }
    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
