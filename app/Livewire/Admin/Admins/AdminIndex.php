<?php

namespace App\Livewire\Admin\Admins;

use App\Models\Admin;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'ADMIN';
    public bool $is_active = true;

    public ?string $editId = null;
    public bool $showForm = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    protected function rules(): array
    {
        $unique = $this->editId ? '|unique:admins,email,' . $this->editId : '|unique:admins,email';
        $passRule = $this->editId ? 'nullable|min:6' : 'required|min:6';

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255' . $unique,
            'password' => $passRule,
            'role' => 'required|in:SUPER_ADMIN,ADMIN,EDITOR',
            'is_active' => 'boolean',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $id): void
    {
        $admin = Admin::findOrFail($id);
        $this->editId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->role = $admin->role;
        $this->is_active = $admin->is_active;
        $this->password = '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password_hash'] = Hash::make($this->password);
        }

        if ($this->editId) {
            $admin = Admin::findOrFail($this->editId);
            $admin->update($data);
            $action = 'ADMIN_UPDATED';
        } else {
            $admin = Admin::create($data);
            $action = 'ADMIN_CREATED';
        }

        ActivityLog::logActivity($action, "Admin account: {$admin->email} ({$admin->role})", auth()->user(), request()->ip());
        $this->resetForm();
    }

    public function confirmDelete(string $id): void
    {
        if ($id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId && $this->deleteId !== auth()->id()) {
            $admin = Admin::findOrFail($this->deleteId);
            $admin->delete();
            ActivityLog::logActivity('ADMIN_DELETED', "Admin account deleted: {$admin->email}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'ADMIN';
        $this->is_active = true;
        $this->editId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.admins.index', [
            'admins' => Admin::orderBy('name')->paginate(15),
        ])->layout('layouts.admin', ['title' => 'Admin Users', 'subtitle' => 'Manage system administrator accounts & permissions']);
    }
}
