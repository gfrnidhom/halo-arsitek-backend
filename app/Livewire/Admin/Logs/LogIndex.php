<?php

namespace App\Livewire\Admin\Logs;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class LogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $actionFilter = '';

    protected $queryString = ['search' => ['except' => ''], 'actionFilter' => ['except' => '']];

    public function updatingSearch(): void { $this->resetPage(); }

    public function render()
    {
        $query = ActivityLog::when($this->search, fn($q) => $q->where(function($q) {
                $q->where('admin_name', 'like', "%{$this->search}%")
                  ->orWhere('details', 'like', "%{$this->search}%")
                  ->orWhere('action', 'like', "%{$this->search}%");
            }))
            ->when($this->actionFilter, fn($q) => $q->where('action', $this->actionFilter))
            ->orderByDesc('created_at');

        return view('livewire.admin.logs.index', [
            'logs' => $query->paginate(20),
            'actions' => ActivityLog::distinct()->pluck('action')->sort(),
        ])->layout('layouts.admin', ['title' => 'Activity Logs', 'subtitle' => 'Audit trail of administrative actions']);
    }
}
