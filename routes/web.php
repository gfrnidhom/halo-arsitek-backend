<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Projects\ProjectIndex;
use App\Livewire\Admin\Projects\ProjectCreate;
use App\Livewire\Admin\Projects\ProjectEdit;
use App\Livewire\Admin\ProjectCategories\ProjectCategoryIndex;
use App\Livewire\Admin\News\NewsIndex;
use App\Livewire\Admin\News\NewsCreate;
use App\Livewire\Admin\News\NewsEdit;
use App\Livewire\Admin\NewsCategories\NewsCategoryIndex;
use App\Livewire\Admin\Testimonials\TestimonialIndex;
use App\Livewire\Admin\Services\ServiceIndex;
use App\Livewire\Admin\Team\TeamIndex;
use App\Livewire\Admin\Contacts\ContactIndex;
use App\Livewire\Admin\Settings\SettingIndex;
use App\Livewire\Admin\Admins\AdminIndex;
use App\Livewire\Admin\Logs\LogIndex;
use App\Livewire\Admin\Profile\AdminProfile;

// ─── Guest Routes ─────────────────────────────────────────────────────────────

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', Login::class)->name('admin.login');
});

// ─── Admin Routes (Protected) ────────────────────────────────────────────────

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', Dashboard::class)->name('dashboard');

    // Logout
    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');

    // Projects
    Route::get('/projects', ProjectIndex::class)->name('projects.index');
    Route::get('/projects/create', ProjectCreate::class)->name('projects.create');
    Route::get('/projects/{id}/edit', ProjectEdit::class)->name('projects.edit');

    // Project Categories
    Route::get('/project-categories', ProjectCategoryIndex::class)->name('project-categories.index');

    // News
    Route::get('/news', NewsIndex::class)->name('news.index');
    Route::get('/news/create', NewsCreate::class)->name('news.create');
    Route::get('/news/{id}/edit', NewsEdit::class)->name('news.edit');

    // News Categories
    Route::get('/news-categories', NewsCategoryIndex::class)->name('news-categories.index');

    // Testimonials
    Route::get('/testimonials', TestimonialIndex::class)->name('testimonials.index');

    // Services
    Route::get('/services', ServiceIndex::class)->name('services.index');

    // Team
    Route::get('/team', TeamIndex::class)->name('team.index');

    // Contacts
    Route::get('/contacts', ContactIndex::class)->name('contacts.index');

    // Settings
    Route::get('/settings', SettingIndex::class)->name('settings.index');

    // Admin Users
    Route::get('/admins', AdminIndex::class)->name('admins.index');

    // Activity Logs
    Route::get('/logs', LogIndex::class)->name('logs.index');

    // Profile
    Route::get('/profile', AdminProfile::class)->name('profile');
});

// ─── Redirect root to admin ──────────────────────────────────────────────────

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
