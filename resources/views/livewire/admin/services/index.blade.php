<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">Our Services</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">Manage architectural & interior design services</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all ">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Service
        </button>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-md w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-4">{{ $editId ? 'Edit Service' : 'Add Service' }}</h3>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Title</label>
                        <input wire:model="title" type="text" placeholder="Desain Arsitektur"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('title') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{
                        open: false,
                        search: '',
                        icons: [],
                        init() {
                            // Load icons from global lucide object
                            setTimeout(() => {
                                if (window.lucide && window.lucide.icons) {
                                    this.icons = Object.keys(window.lucide.icons).map(name => name.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase());
                                }
                            }, 500);
                        },
                        get filteredIcons() {
                            let res = this.search === '' ? this.icons : this.icons.filter(i => i.includes(this.search.toLowerCase()));
                            return res.slice(0, 100);
                        },
                        selectIcon(iconName) {
                            $wire.set('icon', iconName);
                            this.open = false;
                            this.search = '';
                        }
                    }">
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Icon (Optional)</label>
                        
                        {{-- Icon Trigger Button --}}
                        <div class="flex items-center gap-3">
                            <button type="button" @click="open = true; setTimeout(() => $refs.searchInput.focus(), 100)" class="w-12 h-12 rounded-xl border border-[var(--admin-border)] flex items-center justify-center bg-[var(--admin-bg-page)] hover:bg-[var(--admin-hover-bg)] transition-colors text-[var(--admin-text-primary)]">
                                @if($icon)
                                    <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
                                @else
                                    <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                @endif
                            </button>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-[var(--admin-text-primary)]">{{ $icon ?: 'No icon selected' }}</p>
                                <p class="text-xs text-[var(--admin-text-secondary)]">Click the box to search & pick an icon</p>
                            </div>
                            @if($icon)
                                <button type="button" wire:click="$set('icon', '')" class="text-xs text-red-500 hover:underline">Remove</button>
                            @endif
                        </div>
                        @error('icon') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                        {{-- Icon Picker Modal --}}
                        <div x-show="open" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
                            <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
                            
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="relative bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl w-full max-w-2xl max-h-[85vh] flex flex-col shadow-xl overflow-hidden"
                                @click.stop>
                                
                                {{-- Header & Search --}}
                                <div class="p-4 border-b border-[var(--admin-border)] shrink-0 flex items-center gap-3">
                                    <div class="relative flex-1">
                                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--admin-text-secondary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        <input x-ref="searchInput" x-model="search" type="text" placeholder="Search icons (e.g. home, user, building)..." class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-10 pr-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                                    </div>
                                    <button type="button" @click="open = false" class="p-2 text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                {{-- Icon Grid --}}
                                <div class="p-4 overflow-y-auto flex-1 grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3 content-start" x-effect="if (open || search) { setTimeout(() => window.lucide.createIcons(), 50) }">
                                    <template x-for="i in filteredIcons" :key="i">
                                        <button type="button" @click="selectIcon(i)" class="aspect-square flex flex-col items-center justify-center p-2 rounded-xl border border-[var(--admin-border)] hover:border-[var(--admin-primary)] hover:text-[var(--admin-primary)] hover:bg-[var(--admin-bg-page)] transition-colors group text-[var(--admin-text-secondary)]" :title="i">
                                            <span class="w-6 h-6 flex items-center justify-center mb-1">
                                                <i :data-lucide="i"></i>
                                            </span>
                                            <span class="text-[9px] w-full truncate text-center opacity-0 group-hover:opacity-100 transition-opacity" x-text="i"></span>
                                        </button>
                                    </template>
                                    <div x-show="filteredIcons.length === 0" class="col-span-full py-12 text-center text-[var(--admin-text-secondary)] text-sm">
                                        No icons found matching "<span x-text="search"></span>"
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Description</label>
                        <textarea wire:model="description" rows="4" placeholder="Penjelasan lengkap mengenai layanan ini..."
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]"></textarea>
                        @error('description') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input wire:model="is_published" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)]">
                            <span class="text-sm text-[var(--admin-text-primary)]">Published</span>
                        </label>
                        <div class="w-28">
                            <input wire:model="sort_order" type="number" placeholder="Order" class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-3 py-1.5 text-sm text-[var(--admin-text-primary)] text-center">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-3">
                        <button type="button" wire:click="resetForm" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[var(--admin-border)]">
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Service</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Description</th>
                        <th class="text-center px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Status</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($services as $s)
                        <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-[var(--admin-text-primary)]">{{ $s->title }}</p>
                                @if($s->icon)
                                    <div class="flex items-center gap-1.5 mt-1 text-[var(--admin-primary-text)] opacity-80">
                                        <i data-lucide="{{ $s->icon }}" class="w-3.5 h-3.5"></i>
                                        <span class="text-[10px] font-mono">{{ $s->icon }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <p class="text-xs text-[var(--admin-text-secondary)] line-clamp-2">{{ $s->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="togglePublish('{{ $s->id }}')" class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $s->is_published ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-slate-100 dark:bg-slate-800 text-[var(--admin-text-secondary)]' }}">
                                    {{ $s->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="edit('{{ $s->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)]"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                    <button wire:click="confirmDelete('{{ $s->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-red-600 dark:hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-[var(--admin-text-secondary)]">No services found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">{{ $services->links('partials.admin.pagination') }}</div>
        @endif
    </div>

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-2">Delete Service</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to delete this service?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
