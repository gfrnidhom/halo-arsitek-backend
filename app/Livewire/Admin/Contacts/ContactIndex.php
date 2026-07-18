<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\ContactSubmission;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ContactIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public ?string $selectedId = null;
    public ?ContactSubmission $selectedSubmission = null;
    public bool $showDetailModal = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected $queryString = ['search' => ['except' => ''], 'statusFilter' => ['except' => '']];

    public function updatingSearch(): void { $this->resetPage(); }

    public function viewDetail(string $id): void
    {
        $this->selectedSubmission = ContactSubmission::findOrFail($id);
        if ($this->selectedSubmission->status === 'UNREAD') {
            $this->selectedSubmission->markAsRead();
        }
        $this->showDetailModal = true;
    }

    public function updateStatus(string $id, string $status): void
    {
        $sub = ContactSubmission::findOrFail($id);
        $sub->update(['status' => $status]);
        if ($this->selectedSubmission && $this->selectedSubmission->id === $id) {
            $this->selectedSubmission = $sub;
        }
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $sub = ContactSubmission::findOrFail($this->deleteId);
            $sub->delete();
            ActivityLog::logActivity('CONTACT_DELETED', "Contact from: {$sub->name}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->showDetailModal = false;
    }

    public function render()
    {
        $query = ContactSubmission::when($this->search, fn($q) => $q->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('message', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->orderByDesc('created_at');

        return view('livewire.admin.contacts.index', [
            'submissions' => $query->paginate(15),
            'unreadCount' => ContactSubmission::where('status', 'UNREAD')->count(),
        ])->layout('layouts.admin', ['title' => 'Contact Submissions', 'subtitle' => 'Manage client inquiries and messages']);
    }
}
