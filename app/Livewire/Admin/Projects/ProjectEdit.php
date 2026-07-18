<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectEdit extends Component
{
    use WithFileUploads;

    public string $projectId;
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
    public $image_files = [];
    public bool $is_published = false;
    public bool $is_headliner = false;
    public int $sort_order = 0;

    public function mount(string $id): void
    {
        $project = Project::findOrFail($id);
        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->slug = $project->slug;
        $this->category_id = $project->category_id;
        $this->year = $project->year;
        $this->location = $project->location;
        $this->area = $project->area;
        $this->description = $project->description;
        $this->cover_image = $project->cover_image;
        $this->images = $project->images ?? [];
        $this->is_published = $project->is_published;
        $this->is_headliner = $project->is_headliner;
        $this->sort_order = $project->sort_order;
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9-]+$/|unique:projects,slug,' . $this->projectId,
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

    public function updatedCoverImageFile(): void
    {
        $this->validate(['cover_image_file' => 'image|max:5120']);

        $path = $this->cover_image_file->store('uploads/' . date('Y/m'), 'public');
        $this->cover_image = '/storage/' . $path;
    }

    public function updatedImageFiles(): void
    {
        $this->validate([
            'image_files.*' => 'image|max:5120',
        ]);

        foreach ($this->image_files as $file) {
            $path = $file->store('uploads/' . date('Y/m'), 'public');
            $this->images[] = '/storage/' . $path;
        }

        $this->image_files = [];
    }

    public function removeImage($index): void
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function moveImageUp($index): void
    {
        if ($index > 0 && isset($this->images[$index])) {
            $temp = $this->images[$index - 1];
            $this->images[$index - 1] = $this->images[$index];
            $this->images[$index] = $temp;
        }
    }

    public function moveImageDown($index): void
    {
        if ($index < count($this->images) - 1 && isset($this->images[$index])) {
            $temp = $this->images[$index + 1];
            $this->images[$index + 1] = $this->images[$index];
            $this->images[$index] = $temp;
        }
    }

    public function save()
    {
        $this->validate();

        $project = Project::findOrFail($this->projectId);
        $project->update([
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
            'PROJECT_UPDATED',
            "Project: {$project->title}",
            auth()->user(),
            request()->ip()
        );

        session()->flash('success', 'Project berhasil diupdate!');
        return redirect()->route('admin.projects.index');
    }

    public function render()
    {
        return view('livewire.admin.projects.form', [
            'categories' => ProjectCategory::orderBy('name')->get(),
            'isEdit' => true,
        ])->layout('layouts.admin', ['title' => 'Edit Project', 'subtitle' => 'Update project details']);
    }
}
