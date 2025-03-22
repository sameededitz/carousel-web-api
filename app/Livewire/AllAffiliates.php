<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AllAffiliates extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 5;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $affiliateUsers = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhereDate('created_at', $this->search);
        })->where('role', 'affiliate')
            ->paginate($this->perPage);;

        return view('livewire.all-affiliates', compact('affiliateUsers'));
    }
}
