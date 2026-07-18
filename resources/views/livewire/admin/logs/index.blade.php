<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">System Audit Trail</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">{{ $logs->total() }} recorded actions</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search admin, details..."
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
            </div>
            <select wire:model.live="actionFilter" class="bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                <option value="">All Actions</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}">{{ $act }}</option>
                @endforeach
            </select>
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
