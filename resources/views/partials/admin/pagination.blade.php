@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between text-xs text-[var(--admin-text-secondary)]">
        <div class="hidden sm:block">
            Showing <span class="font-medium text-[var(--admin-text-primary)]">{{ $paginator->firstItem() }}</span> to <span class="font-medium text-[var(--admin-text-primary)]">{{ $paginator->lastItem() }}</span> of <span class="font-medium text-[var(--admin-text-primary)]">{{ $paginator->total() }}</span> results
        </div>

        <div class="flex items-center gap-1 ml-auto">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-[var(--admin-border)] text-[var(--admin-text-secondary)] cursor-not-allowed opacity-50">Prev</span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" class="px-3 py-1.5 rounded-lg bg-[var(--admin-bg-card)] border border-[var(--admin-border)] text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-colors">Prev</button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1.5 text-[var(--admin-text-secondary)]">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 rounded-lg bg-[var(--admin-primary)] text-white font-bold shadow-sm">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" class="px-3 py-1.5 rounded-lg bg-[var(--admin-bg-card)] border border-[var(--admin-border)] text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-colors">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" class="px-3 py-1.5 rounded-lg bg-[var(--admin-bg-card)] border border-[var(--admin-border)] text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-colors">Next</button>
            @else
                <span class="px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-[var(--admin-border)] text-[var(--admin-text-secondary)] cursor-not-allowed opacity-50">Next</span>
            @endif
        </div>
    </nav>
@endif
