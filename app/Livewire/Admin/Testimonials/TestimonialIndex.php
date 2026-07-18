<?php

namespace App\Livewire\Admin\Testimonials;

use App\Models\Testimonial;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TestimonialIndex extends Component
{
    use WithFileUploads, WithPagination;

    public string $quote = '';
    public string $name = '';
    public string $role = '';
    public string $project = '';
    public $avatar_file = null;
    public string $avatar_url = '';
    public bool $is_published = true;
    public int $sort_order = 0;

    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected function rules(): array
    {
        return [
            'quote' => 'required|string',
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'project' => 'nullable|string|max:255',
            'avatar_url' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function updatedAvatarFile(): void
    {
        $this->validate(['avatar_file' => 'image|max:2048']);
        $path = $this->avatar_file->store('uploads/testimonials', 'public');
        $this->avatar_url = '/storage/' . $path;
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $id): void
    {
        $t = Testimonial::findOrFail($id);
        $this->editId = $t->id;
        $this->quote = $t->quote;
        $this->name = $t->name;
        $this->role = $t->role ?? '';
        $this->project = $t->project ?? '';
        $this->avatar_url = $t->avatar_url ?? '';
        $this->is_published = $t->is_published;
        $this->sort_order = $t->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'quote' => $this->quote,
            'name' => $this->name,
            'role' => $this->role ?: null,
            'project' => $this->project ?: null,
            'avatar_url' => $this->avatar_url ?: null,
            'is_published' => $this->is_published,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editId) {
            $t = Testimonial::findOrFail($this->editId);
            $t->update($data);
            $action = 'TESTIMONIAL_UPDATED';
        } else {
            $t = Testimonial::create($data);
            $action = 'TESTIMONIAL_CREATED';
        }

        ActivityLog::logActivity($action, "Testimonial: {$t->name}", auth()->user(), request()->ip());
        $this->resetForm();
    }

    public function togglePublish(string $id): void
    {
        $t = Testimonial::findOrFail($id);
        $t->update(['is_published' => !$t->is_published]);
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $t = Testimonial::findOrFail($this->deleteId);
            $t->delete();
            ActivityLog::logActivity('TESTIMONIAL_DELETED', "Testimonial: {$t->name}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm(): void
    {
        $this->quote = '';
        $this->name = '';
        $this->role = '';
        $this->project = '';
        $this->avatar_file = null;
        $this->avatar_url = '';
        $this->is_published = true;
        $this->sort_order = 0;
        $this->editId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.testimonials.index', [
            'testimonials' => Testimonial::orderBy('sort_order')->orderByDesc('created_at')->paginate(15),
        ])->layout('layouts.admin', ['title' => 'Testimonials', 'subtitle' => 'Manage client testimonials and reviews']);
    }
}
