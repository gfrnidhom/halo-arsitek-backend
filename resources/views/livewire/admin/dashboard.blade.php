<div class="p-4 md:p-8 space-y-8">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Projects', 'value' => $stats['projects']['total'], 'sub' => $stats['projects']['published'] . ' published', 'color' => 'blue', 'icon' => 'building'],
                ['label' => 'Total News', 'value' => $stats['news']['total'], 'sub' => $stats['news']['published'] . ' published', 'color' => 'indigo', 'icon' => 'file-text'],
                ['label' => 'Contacts', 'value' => $stats['contacts']['total'], 'sub' => $stats['contacts']['unread'] . ' unread', 'color' => 'violet', 'icon' => 'mail'],
                ['label' => 'Page Views', 'value' => $stats['pageViews']['total'], 'sub' => $stats['pageViews']['today'] . ' today', 'color' => 'sky', 'icon' => 'eye'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/40 flex items-center justify-center mb-4 text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400">
                    @if($card['icon'] === 'building')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    @elseif($card['icon'] === 'file-text')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @elseif($card['icon'] === 'mail')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @elseif($card['icon'] === 'eye')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    @endif
                </div>
                <p class="text-3xl font-bold text-[var(--admin-text-primary)]">{{ number_format($card['value']) }}</p>
                <div class="flex items-center justify-between mt-1">
                    <p class="text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-widest font-semibold">{{ $card['label'] }}</p>
                    <p class="text-xs text-[var(--admin-text-secondary)]">{{ $card['sub'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Visitor Chart --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-[var(--admin-text-primary)] flex items-center gap-2 mb-6">
            <svg class="w-4 h-4 text-[var(--admin-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            Visitor Traffic (Last 7 Days)
        </h2>
        <div class="h-64" x-data="chartComponent(@js($viewsChart))" x-init="initChart()">
            <canvas x-ref="chart"></canvas>
        </div>
    </div>

    {{-- Two Column: Top Pages + Recent Contacts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Pages --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--admin-border)] bg-slate-50 dark:bg-slate-900/50">
                <h2 class="text-sm font-semibold text-[var(--admin-text-primary)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[var(--admin-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Popular Pages
                </h2>
            </div>
            @forelse($topPages as $index => $page)
                <div class="px-6 py-3.5 flex items-center justify-between hover:bg-[var(--admin-hover-bg)] transition-colors {{ !$loop->last ? 'border-b border-[var(--admin-border)]' : '' }}">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-6 h-6 rounded bg-[var(--admin-primary)] text-[var(--admin-text-primary)] text-[11px] font-bold flex items-center justify-center shrink-0 shadow-sm">{{ $index + 1 }}</span>
                        <span class="text-sm font-medium text-[var(--admin-text-primary)] truncate">{{ $page['path'] }}</span>
                    </div>
                    <span class="text-xs text-[var(--admin-text-secondary)] font-semibold shrink-0 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">{{ $page['count'] }} views</span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[var(--admin-text-secondary)]">No traffic data available</div>
            @endforelse
        </div>

        {{-- Recent Contacts --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--admin-border)] bg-slate-50 dark:bg-slate-900/50">
                <h2 class="text-sm font-semibold text-[var(--admin-text-primary)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Recent Messages
                </h2>
            </div>
            @forelse($recentContacts as $contact)
                <div class="px-6 py-3.5 flex items-center gap-3 hover:bg-[var(--admin-hover-bg)] transition-colors {{ !$loop->last ? 'border-b border-[var(--admin-border)]' : '' }}">
                    <div class="w-2 h-2 rounded-full shrink-0 {{ $contact['status'] === 'UNREAD' ? 'bg-blue-500' : 'bg-slate-300 dark:bg-slate-600' }}"></div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-sm font-semibold text-[var(--admin-text-primary)]">{{ $contact['name'] }}</span>
                            @if($contact['status'] === 'UNREAD')
                                <span class="text-[9px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400 px-1.5 py-0.5 rounded">NEW</span>
                            @endif
                        </div>
                        <p class="text-xs text-[var(--admin-text-secondary)] truncate">{{ $contact['message'] }}</p>
                    </div>
                    <span class="text-[11px] text-[var(--admin-text-secondary)] shrink-0">{{ $contact['created_at'] }}</span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[var(--admin-text-secondary)]">No incoming messages</div>
            @endforelse
        </div>
    </div>

    {{-- Two Column: Recent Projects + Recent News --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Projects --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--admin-border)] bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[var(--admin-text-primary)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Recent Projects
                </h2>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-[var(--admin-primary-text)] hover:text-[var(--admin-primary-hover)] flex items-center gap-1 transition-colors">
                    View All
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                </a>
            </div>
            @forelse($recentProjects as $project)
                <div class="px-6 py-3.5 flex items-center justify-between hover:bg-[var(--admin-hover-bg)] transition-colors {{ !$loop->last ? 'border-b border-[var(--admin-border)]' : '' }}">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-[var(--admin-text-primary)] truncate">{{ $project['title'] }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[11px] font-medium text-[var(--admin-text-secondary)]">{{ $project['category_name'] }}</span>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <span class="text-[11px] text-[var(--admin-text-secondary)]">{{ $project['created_at'] }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-1 rounded shrink-0
                        {{ $project['is_published'] ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                        {{ $project['is_published'] ? 'PUBLISHED' : 'DRAFT' }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[var(--admin-text-secondary)]">No projects found</div>
            @endforelse
        </div>

        {{-- Recent News --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--admin-border)] bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[var(--admin-text-primary)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Recent News
                </h2>
                <a href="{{ route('admin.news.index') }}" class="text-xs font-semibold text-[var(--admin-primary-text)] hover:text-[var(--admin-primary-hover)] flex items-center gap-1 transition-colors">
                    View All
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                </a>
            </div>
            @forelse($recentNews as $news)
                <div class="px-6 py-3.5 flex items-center justify-between hover:bg-[var(--admin-hover-bg)] transition-colors {{ !$loop->last ? 'border-b border-[var(--admin-border)]' : '' }}">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-[var(--admin-text-primary)] truncate">{{ $news['title'] }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[11px] font-medium text-[var(--admin-text-secondary)]">{{ $news['category_name'] }}</span>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <span class="text-[11px] text-[var(--admin-text-secondary)]">{{ $news['created_at'] }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-1 rounded shrink-0
                        {{ $news['is_published'] ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                        {{ $news['is_published'] ? 'PUBLISHED' : 'DRAFT' }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[var(--admin-text-secondary)]">No news found</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    function chartComponent(data) {
        return {
            initChart() {
                const ctx = this.$refs.chart.getContext('2d');
                const isDark = document.documentElement.classList.contains('dark');
                
                // Watch for theme changes
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.attributeName === 'class' || mutation.attributeName === 'data-theme') {
                            const newIsDark = document.documentElement.classList.contains('dark');
                            this.updateChartTheme(this.chartInstance, newIsDark);
                        }
                    });
                });
                observer.observe(document.documentElement, { attributes: true });

                const primaryColor = '#2563EB';
                const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
                gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [{
                            label: 'Views',
                            data: data.map(d => d.count),
                            borderColor: primaryColor,
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: primaryColor,
                            pointBorderWidth: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: primaryColor,
                            pointHoverBorderColor: isDark ? '#1E293B' : '#FFFFFF',
                            pointHoverBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#0F172A' : '#1E293B',
                                borderColor: isDark ? '#334155' : 'transparent',
                                borderWidth: 1,
                                titleFont: { family: 'Outfit', weight: '600' },
                                bodyFont: { family: 'Outfit' },
                                titleColor: '#fff',
                                bodyColor: '#cbd5e1',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: isDark ? '#64748B' : '#94A3B8', font: { family: 'Outfit', size: 12 } },
                                border: { display: false },
                            },
                            y: {
                                grid: { color: isDark ? '#334155' : '#E2E8F0', drawBorder: false },
                                ticks: { color: isDark ? '#64748B' : '#94A3B8', font: { family: 'Outfit', size: 12 }, precision: 0 },
                                border: { display: false },
                                beginAtZero: true,
                            }
                        }
                    }
                });
            },
            updateChartTheme(chart, isDark) {
                if(!chart) return;
                chart.data.datasets[0].pointHoverBorderColor = isDark ? '#1E293B' : '#FFFFFF';
                chart.options.plugins.tooltip.backgroundColor = isDark ? '#0F172A' : '#1E293B';
                chart.options.plugins.tooltip.borderColor = isDark ? '#334155' : 'transparent';
                chart.options.scales.x.ticks.color = isDark ? '#64748B' : '#94A3B8';
                chart.options.scales.y.ticks.color = isDark ? '#64748B' : '#94A3B8';
                chart.options.scales.y.grid.color = isDark ? '#334155' : '#E2E8F0';
                chart.update();
            }
        };
    }
</script>
@endpush
