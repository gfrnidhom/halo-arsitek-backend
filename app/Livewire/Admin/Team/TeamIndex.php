<?php

namespace App\Livewire\Admin\Team;

use App\Models\TeamMember;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TeamIndex extends Component
{
    use WithFileUploads, WithPagination;

    public string $name = '';
    public string $role = '';
    public $image_file = null;
    public string $image = '';
    public bool $is_published = true;
    public int $sort_order = 0;

    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function updatedImageFile(): void
    {
        $this->validate(['image_file' => 'image|max:3072']);
        $path = $this->image_file->store('uploads/team', 'public');
        $this->image = '/storage/' . $path;
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $id): void
    {
        $tm = TeamMember::findOrFail($id);
        $this->editId = $tm->id;
        $this->name = $tm->name;
        $this->role = $tm->role;
        $this->image = $tm->image ?? '';
        $this->is_published = $tm->is_published;
        $this->sort_order = $tm->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'role' => $this->role,
            'image' => $this->image ?: null,
            'is_published' => $this->is_published,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editId) {
            $tm = TeamMember::findOrFail($this->editId);
            $tm->update($data);
            $action = 'TEAM_MEMBER_UPDATED';
        } else {
            $tm = TeamMember::create($data);
            $action = 'TEAM_MEMBER_CREATED';
        }

        ActivityLog::logActivity($action, "Team Member: {$tm->name}", auth()->user(), request()->ip());
        $this->resetForm();
    }

    public function togglePublish(string $id): void
    {
        $tm = TeamMember::findOrFail($id);
        $tm->update(['is_published' => !$tm->is_published]);
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $tm = TeamMember::findOrFail($this->deleteId);
            $tm->delete();
            ActivityLog::logActivity('TEAM_MEMBER_DELETED', "Team Member: {$tm->name}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->role = '';
        $this->image_file = null;
        $this->image = '';
        $this->is_published = true;
        $this->sort_order = 0;
        $this->editId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.team.index', [
            'teamMembers' => TeamMember::orderBy('sort_order')->orderByDesc('created_at')->paginate(15),
        ])->layout('layouts.admin', ['title' => 'Team Members', 'subtitle' => 'Manage architecture & design team profiles']);
    }
}
