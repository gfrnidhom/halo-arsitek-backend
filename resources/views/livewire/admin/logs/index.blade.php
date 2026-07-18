<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">System Audit Trail</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">{{ $logs->total() }} recorded actions</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-6 space-y-3">
        <div class="flex flex-col gap-3">
            <div class="w-full">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search admin, details..."
                    class="w-full bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] shadow-sm">
            </div>
            <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 hide-scrollbar">
                <span class="text-[10px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-wider shrink-0 mr-1">ACTION:</span>
                <button wire:click="$set('actionFilter', '')" class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $actionFilter === '' ? 'bg-[var(--admin-primary)] text-white shadow-md' : 'bg-white dark:bg-slate-800 text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)] border border-[var(--admin-border)] shadow-sm' }}">
                    All Actions
                </button>
                @foreach($actions as $act)
                    <button wire:click="$set('actionFilter', '{{ $act }}')" class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $actionFilter === $act ? 'bg-[var(--admin-primary)] text-white shadow-md' : 'bg-white dark:bg-slate-800 text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)] border border-[var(--admin-border)] shadow-sm' }}">
                        {{ $act }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[var(--admin-border)]">
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Timestamp</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Admin</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Action</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Details</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium hidden md:table-cell">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($logs as $log)
                        <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors">
                            <td class="px-6 py-4 text-xs text-[var(--admin-text-secondary)] font-mono whitespace-nowrap">
                                {{ $log->created_at->translatedFormat('j M Y, H:i:s') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-[var(--admin-text-primary)]">{{ $log->admin_name }}</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-white/[0.05] text-[var(--admin-text-secondary)]">{{ $log->admin_role }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-mono text-[var(--admin-primary-text)]/90 bg-blue-100 dark:bg-blue-900/40 px-2 py-1 rounded-md">{{ $log->action }}</span>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <p class="text-xs text-[var(--admin-text-primary)] truncate">{{ $log->details ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-[var(--admin-text-secondary)] font-mono hidden md:table-cell">
                                {{ $log->ip_address ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-16 text-center text-sm text-[var(--admin-text-secondary)]">No activity logs recorded</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">{{ $logs->links('partials.admin.pagination') }}</div>
        @endif
    </div>
</div>
