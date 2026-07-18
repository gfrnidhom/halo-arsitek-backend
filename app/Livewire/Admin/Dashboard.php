<?php

namespace App\Livewire\Admin;

use App\Models\ContactSubmission;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PageView;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $viewsChart = [];
    public array $topPages = [];
    public array $recentContacts = [];
    public array $recentProjects = [];
    public array $recentNews = [];

    public function mount(): void
    {
        $this->loadStats();
    }

    public function loadStats(): void
    {
        $this->stats = [
            'projects' => [
                'total' => Project::count(),
                'published' => Project::where('is_published', true)->count(),
            ],
            'news' => [
                'total' => News::count(),
                'published' => News::where('is_published', true)->count(),
            ],
            'testimonials' => Testimonial::count(),
            'services' => Service::count(),
            'team' => TeamMember::count(),
            'contacts' => [
                'total' => ContactSubmission::count(),
                'unread' => ContactSubmission::where('status', 'UNREAD')->count(),
            ],
            'categories' => [
                'projects' => ProjectCategory::count(),
                'news' => NewsCategory::count(),
            ],
            'pageViews' => [
                'total' => PageView::count(),
                'today' => PageView::where('created_at', '>=', today())->count(),
            ],
        ];

        // Views chart (last 7 days)
        $this->viewsChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label' => $date->translatedFormat('j M'),
                'count' => PageView::whereDate('created_at', $date->toDateString())->count(),
            ];
        })->toArray();

        // Top pages
        $sevenDaysAgo = now()->subDays(6)->startOfDay();
        $this->topPages = PageView::where('created_at', '>=', $sevenDaysAgo)
            ->selectRaw('path, COUNT(*) as count')
            ->groupBy('path')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(fn($v) => ['path' => $v->path, 'count' => $v->count])
            ->toArray();

        // Recent contacts
        $this->recentContacts = ContactSubmission::orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'message' => $c->message,
                'status' => $c->status,
                'created_at' => $c->created_at->translatedFormat('j M'),
            ])
            ->toArray();

        // Recent projects
        $this->recentProjects = Project::with('category:id,name')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'is_published' => $p->is_published,
                'created_at' => $p->created_at->translatedFormat('j M'),
                'category_name' => $p->category->name ?? '-',
            ])
            ->toArray();

        // Recent news
        $this->recentNews = News::with('category:id,name')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($n) => [
                'id' => $n->id,
                'title' => $n->title,
                'is_published' => $n->is_published,
                'created_at' => $n->created_at->translatedFormat('j M'),
                'category_name' => $n->category->name ?? '-',
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin', ['title' => 'Dashboard', 'subtitle' => 'Website content & activity overview']);
    }
}
