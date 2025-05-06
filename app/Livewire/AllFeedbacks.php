<?php

namespace App\Livewire;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class AllFeedbacks extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    public $feedbackId;
    public $name;
    public $email;
    public $message;

    public function viewFeedback($feedbackId)
    {
        $this->feedbackId = $feedbackId;

        $feedback = Faq::findOrFail($feedbackId);
        $this->name = $feedback->name;
        $this->email = $feedback->email;
        $this->message = $feedback->message;
    }

    public function closeModel()
    {
        $this->reset([
            'feedbackId',
            'name',
            'email',
            'message',
        ]);

        $this->dispatch('closeModel');
    }

    public function deleteFeedback($feedbackId)
    {
        $feedback = Faq::findOrFail($feedbackId);
        $feedback->delete();

        $this->dispatch('sweetAlert', title: 'Success!', message: 'Feedback deleted successfully.', type: 'success');
        $this->resetPage();
    }

    public function render()
    {
        $feedbacks = Faq::query()
            ->when($this->search, fn($query) => $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            }))
            ->latest()
            ->paginate($this->perPage);

        /** @disregard @phpstan-ignore-line */
        return view('livewire.all-feedbacks', compact('feedbacks'))
            ->extends('layout.admin-layout')
            ->section('admin_content');
    }
}
