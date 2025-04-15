<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class AllTags extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $name;
    public $tagId;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function resetForm()
    {
        $this->name = '';
        $this->tagId = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function saveTag()
    {
        $this->validate();

        Tag::create([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModel');
        $this->dispatch('sweetAlert', type: 'success', message: 'Tag created successfully.', title: 'Created');
        $this->resetForm();
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->isEdit = true;
    }

    public function updateTag()
    {
        $this->validate();

        $tag = Tag::findOrFail($this->tagId);
        $tag->update([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModel');
        $this->dispatch('sweetAlert', type: 'success', message: 'Tag updated successfully.', title: 'Updated');
        $this->resetForm();
    }

    public function deleteTag($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            $this->dispatch('sweetAlert', type: 'success', message: 'Tag deleted successfully.', title: 'Deleted');
        }
    }

    public function render()
    {
        return view('livewire.all-tags', [
            'tags' => Tag::orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }
}
