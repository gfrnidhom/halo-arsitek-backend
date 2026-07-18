<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\ActivityLog;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ];
    }

    public function login()
    {
        $this->validate();

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.");
            return;
        }

        if (Auth::guard('admin')->attempt(
            ['email' => $this->email, 'password' => $this->password, 'is_active' => true],
            $this->remember
        )) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $admin->update(['last_login_at' => now()]);

            ActivityLog::logActivity(
                'LOGIN',
                "Admin {$admin->name} logged in",
                $admin,
                request()->ip()
            );

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 900); // 15 minutes

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest', ['title' => 'Login — Halo Arsitek']);
    }
}
