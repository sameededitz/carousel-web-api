<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class AllCategories extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $name;
    public $categoryId;
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
        $this->categoryId = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function saveCategory()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModel');
        $this->dispatch('sweetAlert', type: 'success', message: 'Category created successfully.', title: 'Created');
        $this->resetForm();
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModel');
        $this->dispatch('sweetAlert', type: 'success', message: 'Category updated successfully.', title: 'Updated');
        $this->resetForm();
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            $this->dispatch('sweetAlert', type: 'success', message: 'Category deleted successfully.', title: 'Deleted');
            $this->resetForm();
        }
    }

    public function render()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.all-categories', [
            'categories' => $categories,
        ]);
    }
}
