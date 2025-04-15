<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Category;
use App\Models\Post;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;

class PostEdit extends Component
{
    use WithFileUploads, WithFilePond;

    public Post $post;
    public $image, $title, $content, $category, $tags = [], $excerpt, $is_published = false;
    public $categories, $tagsList;

    protected function rules()
    {
        return [
            'image' => 'nullable|image|max:20420|mimes:jpg,jpeg,png',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|integer|exists:categories,id',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];
    }

    public function removeImage()
    {
        $this->image = null;
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->category = $post->category_id;
        $this->tags = $post->tags->pluck('id')->toArray();
        $this->excerpt = $post->excerpt;
        $this->is_published = $post->is_published;

        $this->categories = Category::all();
        $this->tagsList = Tag::all();
    }

    public function store()
    {
        $this->validate();

        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category,
            'excerpt' => $this->excerpt,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ]);

        $this->post->tags()->sync($this->tags);

        if ($this->image) {
            $this->post->clearMediaCollection('image');
            $this->post->addMedia($this->image)
                ->usingFileName(time() . '_' . 'post_thumbnail_' . $this->post->id . '.' . $this->image->getClientOriginalExtension())
                ->toMediaCollection('image');
        }

        $this->post->tags()->sync($this->tags);

        return redirect()->intended(route('all-posts'))
            ->with('message', 'Post updated successfully.');
    }

    public function render()
    {
        /** @disregard @phpstan-ignore-line */
        return view('livewire.post-edit')
            ->extends('layout.admin-layout')
            ->section('admin_content');
    }
}
