<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">Client Inquiries</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">{{ $submissions->total() }} total submissions ({{ $unreadCount }} unread)</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name, email, message..."
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
            </div>
            <select wire:model.live="statusFilter" class="bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                <option value="">All Status</option>
                <option value="UNREAD">Unread</option>
                <option value="READ">Read</option>
                <option value="REPLIED">Replied</option>
                <option value="ARCHIVED">Archived</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[var(--admin-border)]">
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Sender</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Message Snippet</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium hidden md:table-cell">Budget</th>
                        <th class="text-center px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Status</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($submissions as $sub)
                        <tr wire:click="viewDetail('{{ $sub->id }}')" class="hover:bg-[var(--admin-hover-bg)] transition-colors cursor-pointer {{ $sub->status === 'UNREAD' ? 'bg-[var(--admin-primary)]/[0.03] font-medium' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($sub->status === 'UNREAD')
                                        <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                                    @endif
                                    <div>
                                        <p class="text-sm text-[var(--admin-text-primary)]">{{ $sub->name }}</p>
                                        <p class="text-xs text-[var(--admin-text-secondary)]">{{ $sub->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-xs text-[var(--admin-text-secondary)] truncate">{{ $sub->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-[var(--admin-text-secondary)] hidden md:table-cell">
                                {{ $sub->budget ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center" wire:click.stop>
                                <select wire:change="updateStatus('{{ $sub->id }}', $event.target.value)" class="text-[10px] font-bold px-2 py-1 rounded-full border-0 bg-white/[0.05] text-[var(--admin-text-primary)] focus:ring-1 focus:ring-[var(--admin-primary)]">
                                    <option value="UNREAD" {{ $sub->status === 'UNREAD' ? 'selected' : '' }}>UNREAD</option>
                                    <option value="READ" {{ $sub->status === 'READ' ? 'selected' : '' }}>READ</option>
                                    <option value="REPLIED" {{ $sub->status === 'REPLIED' ? 'selected' : '' }}>REPLIED</option>
                                    <option value="ARCHIVED" {{ $sub->status === 'ARCHIVED' ? 'selected' : '' }}>ARCHIVED</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-[var(--admin-text-secondary)]">
                                {{ $sub->created_at->translatedFormat('j M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-16 text-center text-sm text-[var(--admin-text-secondary)]">No submissions found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">{{ $submissions->links('partials.admin.pagination') }}</div>
        @endif
    </div>

    {{-- Detail Modal --}}
    @if($showDetailModal && $selectedSubmission)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-lg w-full shadow-sm space-y-5">
                <div class="flex items-start justify-between border-b border-[var(--admin-border)] pb-4">
                    <div>
                        <h3 class="text-base font-semibold text-[var(--admin-text-primary)]">{{ $selectedSubmission->name }}</h3>
                        <p class="text-xs text-[var(--admin-primary-text)]">{{ $selectedSubmission->email }} {{ $selectedSubmission->phone ? "• {$selectedSubmission->phone}" : '' }}</p>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-white/[0.05] text-[var(--admin-text-secondary)]">{{ $selectedSubmission->status }}</span>
                </div>

                <div class="space-y-3 text-sm">
                    @if($selectedSubmission->budget)
                        <div>
                            <span class="text-xs text-[var(--admin-text-secondary)] block uppercase tracking-wider">Estimated Budget</span>
                            <span class="text-[var(--admin-text-primary)] font-semibold">{{ $selectedSubmission->budget }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-xs text-[var(--admin-text-secondary)] block uppercase tracking-wider mb-1">Message</span>
                        <div class="bg-[var(--admin-bg-page)] border border-[var(--admin-border)]/80 rounded-xl p-4 text-[var(--admin-text-primary)] whitespace-pre-wrap leading-relaxed text-xs">
                            {{ $selectedSubmission->message }}
                        </div>
                    </div>
                    <div class="text-[11px] text-[var(--admin-text-secondary)]">
                        Submitted on: {{ $selectedSubmission->created_at->translatedFormat('l, j F Y H:i:s') }}
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-[var(--admin-border)] pt-4">
                    <button wire:click="confirmDelete('{{ $selectedSubmission->id }}')" class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-semibold rounded-xl hover:bg-red-200 dark:hover:bg-red-900/50 transition-all">Delete Message</button>
                    <button wire:click="$set('showDetailModal', false)" class="px-5 py-2 bg-white/[0.05] text-[var(--admin-text-primary)] text-xs font-semibold rounded-xl hover:bg-white/[0.1] transition-all">Close</button>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-2">Delete Message</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to permanently delete this message?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
