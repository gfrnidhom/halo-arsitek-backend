<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceIndex extends Component
{
    use WithPagination;

    public string $title = '';
    public string $description = '';
    public string $icon = '';
    public bool $is_published = true;
    public int $sort_order = 0;

    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $id): void
    {
        $s = Service::findOrFail($id);
        $this->editId = $s->id;
        $this->title = $s->title;
        $this->description = $s->description;
        $this->icon = $s->icon ?? '';
        $this->is_published = $s->is_published;
        $this->sort_order = $s->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon ?: null,
            'is_published' => $this->is_published,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editId) {
            $s = Service::findOrFail($this->editId);
            $s->update($data);
            $action = 'SERVICE_UPDATED';
        } else {
            $s = Service::create($data);
            $action = 'SERVICE_CREATED';
        }

        ActivityLog::logActivity($action, "Service: {$s->title}", auth()->user(), request()->ip());
        $this->resetForm();
    }

    public function togglePublish(string $id): void
    {
        $s = Service::findOrFail($id);
        $s->update(['is_published' => !$s->is_published]);
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $s = Service::findOrFail($this->deleteId);
            $s->delete();
            ActivityLog::logActivity('SERVICE_DELETED', "Service: {$s->title}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm(): void
    {
        $this->title = '';
        $this->description = '';
        $this->icon = '';
        $this->is_published = true;
        $this->sort_order = 0;
        $this->editId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.services.index', [
            'services' => Service::orderBy('sort_order')->orderByDesc('created_at')->paginate(15),
        ])->layout('layouts.admin', ['title' => 'Services', 'subtitle' => 'Manage architecture & interior services offered']);
    }
}
