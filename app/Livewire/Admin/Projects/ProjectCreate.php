<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectCreate extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $category_id = '';
    public int $year;
    public string $location = '';
    public string $area = '';
    public string $description = '';
    public $cover_image_file = null;
    public string $cover_image = '';
    public array $images = [];
    public bool $is_published = false;
    public bool $is_headliner = false;
    public int $sort_order = 0;

    public function mount(): void
    {
        $this->year = (int) date('Y');
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9-]+$/|unique:projects,slug',
            'category_id' => 'required|exists:project_categories,id',
            'year' => 'required|integer|min:1900|max:2100',
            'location' => 'required|string|max:255',
            'area' => 'required|string|max:100',
            'description' => 'required|string',
            'cover_image' => 'required|string|max:500',
            'is_published' => 'boolean',
            'is_headliner' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function updatedCoverImageFile(): void
    {
        $this->validate(['cover_image_file' => 'image|max:5120']);

        $path = $this->cover_image_file->store('uploads/' . date('Y/m'), 'public');
        $this->cover_image = '/storage/' . $path;
    }

    public function save()
    {
        $this->validate();

        $project = Project::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'year' => $this->year,
            'location' => $this->location,
            'area' => $this->area,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'images' => $this->images,
            'is_published' => $this->is_published,
            'is_headliner' => $this->is_headliner,
            'sort_order' => $this->sort_order,
        ]);

        ActivityLog::logActivity(
            'PROJECT_CREATED',
            "Project: {$project->title}",
            auth()->user(),
            request()->ip()
        );

        session()->flash('success', 'Project berhasil dibuat!');
        return redirect()->route('admin.projects.index');
    }

    public function render()
    {
        return view('livewire.admin.projects.form', [
            'categories' => ProjectCategory::orderBy('name')->get(),
            'isEdit' => false,
        ])->layout('layouts.admin', ['title' => 'Create Project', 'subtitle' => 'Add a new portfolio project']);
    }
}
