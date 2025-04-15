<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class AllPosts extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function publishPost($postId)
    {
        $post = Post::find($postId);
        if ($post && !$post->is_published) {
            $post->update([
                'is_published' => true,
                'published_at' => now(),
            ]);

            $this->dispatch('sweetAlert', type: 'success', message: 'Post published successfully.', title: 'Published');
        }
    }

    public function unpublishPost($postId)
    {
        $post = Post::find($postId);
        if ($post && $post->is_published) {
            $post->update([
                'is_published' => false,
                'published_at' => null,
            ]);

            $this->dispatch('sweetAlert', type: 'success', message: 'Post unpublished successfully.', title: 'Unpublished');
        }
    }

    public function deletePost($postId)
    {
        $post = Post::find($postId);
        if ($post) {
            $post->delete();
            $this->dispatch('sweetAlert', type: 'success', message: 'Post deleted successfully.', title: 'Deleted');
        }
    }

    public function render()
    {
        $query = Post::with('user', 'category')
            ->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhereHas(
                        'user',
                        fn($userQuery) =>
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                    )
                    ->orWhereHas(
                        'category',
                        fn($categoryQuery) =>
                        $categoryQuery->where('name', 'like', '%' . $this->search . '%')
                    );
            });

        if ($this->statusFilter !== '') {
            $query->where('is_published', $this->statusFilter);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.all-posts', ['posts' => $posts]);
    }
}
