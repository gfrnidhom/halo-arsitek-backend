<div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
    
    {{-- Top Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Views --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-1">Total Page Views</p>
                <h4 class="text-3xl font-bold text-[var(--admin-text-primary)]">{{ number_format($totalViews) }}</h4>
            </div>
        </div>

        {{-- Unique Visitors --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-1">Unique Visitors</p>
                <h4 class="text-3xl font-bold text-[var(--admin-text-primary)]">{{ number_format($uniqueVisitors) }}</h4>
            </div>
        </div>

        {{-- Device Stats --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 flex flex-col justify-center">
            <p class="text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-3">Devices Used</p>
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span class="text-[var(--admin-text-secondary)]">Mobile</span>
                </div>
                <span class="font-semibold text-[var(--admin-text-primary)]">{{ number_format($deviceStats['mobile'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-sm mt-2">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-[var(--admin-text-secondary)]">Desktop</span>
                </div>
                <span class="font-semibold text-[var(--admin-text-primary)]">{{ number_format($deviceStats['desktop'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-sm mt-2">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span class="text-[var(--admin-text-secondary)]">Tablet</span>
                </div>
                <span class="font-semibold text-[var(--admin-text-primary)]">{{ number_format($deviceStats['tablet'] ?? 0) }}</span>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
        <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-6">Traffic (Last 30 Days)</h3>
        <div class="h-72 w-full relative">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>

    {{-- Tables: Top Pages & Referrers --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Top Pages --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Top Pages</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-xs text-[var(--admin-text-secondary)] uppercase bg-[var(--admin-bg-page)]/50">
                        <tr>
                            <th class="px-4 py-3 font-medium rounded-l-xl">Page Path</th>
                            <th class="px-4 py-3 font-medium rounded-r-xl text-right">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--admin-border)]">
                        @forelse($topPages as $page)
                            <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors group">
                                <td class="px-4 py-3 text-[var(--admin-text-primary)] truncate max-w-[200px]" title="{{ $page->path }}">{{ $page->path }}</td>
                                <td class="px-4 py-3 text-[var(--admin-text-secondary)] text-right font-medium">{{ number_format($page->views) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-[var(--admin-text-secondary)]">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Referrers --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Top Referrers</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-xs text-[var(--admin-text-secondary)] uppercase bg-[var(--admin-bg-page)]/50">
                        <tr>
                            <th class="px-4 py-3 font-medium rounded-l-xl">Source</th>
                            <th class="px-4 py-3 font-medium rounded-r-xl text-right">Visits</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--admin-border)]">
                        @forelse($topReferrers as $referrer)
                            <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors group">
                                <td class="px-4 py-3 text-[var(--admin-text-primary)] truncate max-w-[200px]" title="{{ $referrer->referrer }}">{{ $referrer->referrer }}</td>
                                <td class="px-4 py-3 text-[var(--admin-text-secondary)] text-right font-medium">{{ number_format($referrer->views) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-[var(--admin-text-secondary)]">No referrers data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const ctx = document.getElementById('trafficChart');
        if (ctx) {
            const chartData = @json($chartData);
            
            // Get CSS Variables for theme matching
            const root = document.documentElement;
            const primaryColor = getComputedStyle(root).getPropertyValue('--admin-primary').trim() || '#2563EB';
            const gridColor = getComputedStyle(root).getPropertyValue('--admin-border').trim() || '#E2E8F0';
            const textColor = getComputedStyle(root).getPropertyValue('--admin-text-secondary').trim() || '#64748B';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Page Views',
                        data: chartData.data,
                        borderColor: primaryColor,
                        backgroundColor: primaryColor + '20', // add alpha
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: primaryColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleFont: { size: 13, family: 'Outfit' },
                            bodyFont: { size: 13, family: 'Outfit' },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { 
                                color: textColor,
                                font: { family: 'Outfit', size: 11 },
                                maxTicksLimit: 10 
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { 
                                color: gridColor,
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: { 
                                color: textColor,
                                font: { family: 'Outfit', size: 11 },
                                precision: 0
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        }
    });
</script>
@endpush
