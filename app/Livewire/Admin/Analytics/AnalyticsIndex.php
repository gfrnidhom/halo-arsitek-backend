<?php

namespace App\Livewire\Admin\Analytics;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AnalyticsIndex extends Component
{
    public $totalViews = 0;
    public $uniqueVisitors = 0;
    public $topPages = [];
    public $topReferrers = [];
    public $chartData = [];
    public $deviceStats = [];

    public function mount()
    {
        $this->loadAnalyticsData();
    }

    public function loadAnalyticsData()
    {
        // Total Views
        $this->totalViews = DB::table('page_views')->count();

        // Unique Visitors (by IP)
        $this->uniqueVisitors = DB::table('page_views')->distinct('ip')->count('ip');

        // Top 10 Pages
        $this->topPages = DB::table('page_views')
            ->select('path', DB::raw('count(*) as views'))
            ->groupBy('path')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        // Top 10 Referrers
        $this->topReferrers = DB::table('page_views')
            ->select('referrer', DB::raw('count(*) as views'))
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->groupBy('referrer')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        // Chart Data: Views per day for last 30 days
        $thirtyDaysAgo = now()->subDays(30);
        $viewsPerDay = DB::table('page_views')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        // Fill missing days with 0
        $dates = [];
        $views = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $views[] = isset($viewsPerDay[$date]) ? $viewsPerDay[$date]->views : 0;
        }

        $this->chartData = [
            'labels' => $dates,
            'data' => $views,
        ];

        // Device Statistics
        $allAgents = DB::table('page_views')->whereNotNull('userAgent')->pluck('userAgent');
        $mobile = 0;
        $desktop = 0;
        $tablet = 0;

        foreach ($allAgents as $ua) {
            $ua = strtolower($ua);
            if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad') || (str_contains($ua, 'android') && !str_contains($ua, 'mobile'))) {
                $tablet++;
            } elseif (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android') || str_contains($ua, 'windows phone')) {
                $mobile++;
            } else {
                $desktop++;
            }
        }

        $this->deviceStats = [
            'desktop' => $desktop,
            'mobile' => $mobile,
            'tablet' => $tablet,
        ];
    }

    public function render()
    {
        return view('livewire.admin.analytics.index')
            ->layout('layouts.admin', [
                'title' => 'Website Analytics', 
                'subtitle' => 'Traffic and visitor statistics'
            ]);
    }
}
