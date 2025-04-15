<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;

class PostAdd extends Component
{
    use WithFileUploads, WithFilePond;

    public $image, $title, $content, $category, $tags = [], $excerpt, $is_published = false;
    public $categories, $tagsList;

    protected function rules()
    {
        return [
            'image' => 'required|image|max:20420|mimes:jpg,jpeg,png',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|integer|exists:categories,id',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->tagsList = Tag::all();
    }

    public function store()
    {
        $this->validate();

        /** @var \App\Models\Post $post **/
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => (int) $this->category,
            'excerpt' => $this->excerpt,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ]);

        if ($this->image) {
            $post->clearMediaCollection('image');
            $post->addMedia($this->image)
                ->usingFileName(time() . '_' . 'post_thumbnail_' . $post->id . '.' . $this->image->getClientOriginalExtension())
                ->toMediaCollection('image');
        }

        $post->tags()->sync($this->tags);

        return redirect()->intended(route('all-posts'))
            ->with('message', 'Post created successfully.');
    }

    public function render()
    {
        /** @disregard @phpstan-ignore-line */
        return view('livewire.post-add')
            ->extends('layout.admin-layout')
            ->section('admin_content');
    }
}
