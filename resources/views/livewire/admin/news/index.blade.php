<div class="p-4 md:p-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">All News & Articles</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">{{ $newsList->total() }} total articles</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all ">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Article
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search news..."
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
            </div>
            <select wire:model.live="categoryFilter" class="bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="publishedFilter" class="bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                <option value="">All Status</option>
                <option value="1">Published</option>
                <option value="0">Draft</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[var(--admin-border)]">
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Article</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium hidden md:table-cell">Category</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium hidden lg:table-cell">Date</th>
                        <th class="text-center px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Status</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($newsList as $news)
                        <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors" wire:key="news-{{ $news->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($news->cover_image)
                                        <img src="{{ $news->cover_image }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0 bg-slate-200 dark:bg-slate-700">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-[var(--admin-text-secondary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-[var(--admin-text-primary)] truncate">{{ $news->title }}</p>
                                        <p class="text-xs text-[var(--admin-text-secondary)] font-mono truncate">{{ $news->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="text-xs text-[var(--admin-text-secondary)] bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">{{ $news->category->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[var(--admin-text-secondary)] hidden lg:table-cell">{{ $news->created_at->translatedFormat('j M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="togglePublish('{{ $news->id }}')" class="text-[10px] font-bold px-2.5 py-1 rounded-full transition-colors
                                    {{ $news->is_published ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200 dark:bg-green-900/50' : 'bg-slate-100 dark:bg-slate-800 text-[var(--admin-text-secondary)] hover:bg-slate-200 dark:bg-slate-700' }}">
                                    {{ $news->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.news.edit', $news->id) }}" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)] hover:bg-blue-50 dark:bg-blue-900/30 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button wire:click="confirmDelete('{{ $news->id }}', '{{ addslashes($news->title) }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-sm text-[var(--admin-text-secondary)]">No articles found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($newsList->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">
                {{ $newsList->links('partials.admin.pagination') }}
            </div>
        @endif
    </div>

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-1">Delete Article</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to delete "<strong class="text-[var(--admin-text-primary)]">{{ $deleteTitle }}</strong>"?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="deleteNews" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
