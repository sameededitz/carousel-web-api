<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserEdit extends Component
{
    public User $user;

    #[Validate]
    public $name;

    #[Validate]
    public $email;

    #[Validate]
    public $role;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'role' => 'required|in:admin,user,affiliate',
        ];
    }

    public function submit()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        return redirect()->route('all-users')->with([
            'status' => 'success',
            'message' => 'User Updated Successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.user-edit');
    }
}
