<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';
    public string $publishedFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Delete modal
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;
    public string $deleteTitle = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'publishedFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function togglePublish(string $id): void
    {
        $project = Project::findOrFail($id);
        $project->update(['is_published' => !$project->is_published]);

        ActivityLog::logActivity(
            $project->is_published ? 'PROJECT_PUBLISHED' : 'PROJECT_UNPUBLISHED',
            "Project: {$project->title}",
            auth()->user(),
            request()->ip()
        );
    }

    public function toggleHeadliner(string $id): void
    {
        $project = Project::findOrFail($id);
        $project->update(['is_headliner' => !$project->is_headliner]);
    }

    public function confirmDelete(string $id, string $title): void
    {
        $this->deleteId = $id;
        $this->deleteTitle = $title;
        $this->showDeleteModal = true;
    }

    public function deleteProject(): void
    {
        if ($this->deleteId) {
            $project = Project::findOrFail($this->deleteId);
            $title = $project->title;
            $project->delete();

            ActivityLog::logActivity(
                'PROJECT_DELETED',
                "Project: {$title}",
                auth()->user(),
                request()->ip()
            );
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteTitle = '';
    }

    public function render()
    {
        $query = Project::with('category')
            ->when($this->search, fn($q) => $q->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('location', 'like', "%{$this->search}%");
            }))
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->publishedFilter !== '', fn($q) => $q->where('is_published', $this->publishedFilter === '1'))
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.projects.index', [
            'projects' => $query->paginate(15),
            'categories' => ProjectCategory::orderBy('name')->get(),
        ])->layout('layouts.admin', ['title' => 'Projects', 'subtitle' => 'Manage portfolio projects']);
    }
}
