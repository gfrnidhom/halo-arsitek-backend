<?php

namespace App\Livewire\Admin\ProjectCategories;

use App\Models\ProjectCategory;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Livewire\Component;

class ProjectCategoryIndex extends Component
{
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    public array $selectedIds = [];
    public bool $selectAll = false;
    public bool $showBulkDeleteModal = false;

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedIds = ProjectCategory::pluck('id')->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    protected function rules(): array
    {
        $unique = $this->editId ? '|unique:project_categories,slug,' . $this->editId : '|unique:project_categories,slug';
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
        $category = ProjectCategory::findOrFail($id);
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
            $category = ProjectCategory::findOrFail($this->editId);
            $category->update(['name' => $this->name, 'slug' => $this->slug, 'description' => $this->description ?: null]);
            $action = 'PROJECT_CATEGORY_UPDATED';
        } else {
            $category = ProjectCategory::create(['name' => $this->name, 'slug' => $this->slug, 'description' => $this->description ?: null]);
            $action = 'PROJECT_CATEGORY_CREATED';
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
            $cat = ProjectCategory::findOrFail($this->deleteId);
            if ($cat->projects()->count() > 0) {
                session()->flash('error', 'Cannot delete category with projects.');
            } else {
                $cat->delete();
                ActivityLog::logActivity('PROJECT_CATEGORY_DELETED', "Category: {$cat->name}", auth()->user(), request()->ip());
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function confirmBulkDelete(): void
    {
        if (empty($this->selectedIds)) return;
        $this->showBulkDeleteModal = true;
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedIds)) return;

        $categoriesToDelete = ProjectCategory::withCount('projects')->whereIn('id', $this->selectedIds)->get();
        $deletedCount = 0;
        
        foreach ($categoriesToDelete as $cat) {
            if ($cat->projects_count === 0) {
                $cat->delete();
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            ActivityLog::logActivity('BULK_DELETED_PROJECT_CATEGORIES', "Bulk deleted {$deletedCount} project categories", auth()->user(), request()->ip());
        }
        
        if ($deletedCount < count($this->selectedIds)) {
            session()->flash('error', 'Some categories could not be deleted because they contain projects.');
        }

        $this->selectedIds = [];
        $this->selectAll = false;
        $this->showBulkDeleteModal = false;
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
        return view('livewire.admin.project-categories.index', [
            'categories' => ProjectCategory::withCount('projects')->orderBy('name')->get(),
        ])->layout('layouts.admin', ['title' => 'Project Categories', 'subtitle' => 'Manage project categories']);
    }
}
