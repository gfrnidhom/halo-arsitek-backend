<?php

namespace App\Livewire\Admin\Profile;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminProfile extends Component
{
    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        ActivityLog::logActivity('PROFILE_UPDATED', 'Updated profile information', $user, request()->ip());
        session()->flash('profile_success', 'Profile updated successfully!');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password_hash)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password_hash' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        ActivityLog::logActivity('PASSWORD_UPDATED', 'Updated account password', $user, request()->ip());
        session()->flash('password_success', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.profile.index')
            ->layout('layouts.admin', ['title' => 'My Profile', 'subtitle' => 'Manage account details and credentials']);
    }
}
