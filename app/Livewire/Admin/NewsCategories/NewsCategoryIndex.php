<?php

namespace App\Livewire\Admin\NewsCategories;

use App\Models\NewsCategory;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Livewire\Component;

class NewsCategoryIndex extends Component
{
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected function rules(): array
    {
        $unique = $this->editId ? '|unique:news_categories,slug,' . $this->editId : '|unique:news_categories,slug';
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9-]+$/' . $unique,
            'description' => 'nullable|string',
        ];
    }

    public function updatedName(): void
    {
        if (!$this->editId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $id): void
    {
        $category = NewsCategory::findOrFail($id);
        $this->editId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editId) {
            $category = NewsCategory::findOrFail($this->editId);
            $category->update(['name' => $this->name, 'slug' => $this->slug, 'description' => $this->description ?: null]);
            $action = 'NEWS_CATEGORY_UPDATED';
        } else {
            $category = NewsCategory::create(['name' => $this->name, 'slug' => $this->slug, 'description' => $this->description ?: null]);
            $action = 'NEWS_CATEGORY_CREATED';
        }

        ActivityLog::logActivity($action, "Category: {$category->name}", auth()->user(), request()->ip());
        $this->resetForm();
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $cat = NewsCategory::findOrFail($this->deleteId);
            if ($cat->news()->count() > 0) {
                session()->flash('error', 'Cannot delete category with articles.');
            } else {
                $cat->delete();
                ActivityLog::logActivity('NEWS_CATEGORY_DELETED', "Category: {$cat->name}", auth()->user(), request()->ip());
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->editId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.news-categories.index', [
            'categories' => NewsCategory::withCount('news')->orderBy('name')->get(),
        ])->layout('layouts.admin', ['title' => 'News Categories', 'subtitle' => 'Manage news categories']);
    }
}
