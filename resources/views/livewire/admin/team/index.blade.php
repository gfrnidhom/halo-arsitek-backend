<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">Our Team</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">Manage profiles of architects and interior designers</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all ">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Team Member
        </button>
    </div>

    @if($showForm)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-md w-full shadow-2xl">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-4">{{ $editId ? 'Edit Team Member' : 'Add Team Member' }}</h3>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Name</label>
                        <input wire:model="name" type="text" placeholder="Ar. Ahmad Fauzi, IAI"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Role / Title</label>
                        <input wire:model="role" type="text" placeholder="Principal Architect"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('role') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Photo</label>
                        <div class="flex items-center gap-3">
                            @if($image)
                                <img src="{{ $image }}" alt="" class="w-14 h-14 rounded-xl object-cover bg-slate-200 dark:bg-slate-700">
                            @endif
                            <input wire:model="image_file" type="file" accept="image/*" class="text-sm text-[var(--admin-text-secondary)] file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-100 dark:bg-blue-900/40 file:text-[var(--admin-primary-text)]">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input wire:model="is_published" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)]">
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

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($teamMembers as $tm)
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden hover:border-[var(--admin-border)]/50 transition-all flex flex-col">
                <div class="aspect-square bg-slate-200 dark:bg-slate-700 relative overflow-hidden">
                    @if($tm->image)
                        <img src="{{ $tm->image }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-[var(--admin-text-secondary)]">{{ substr($tm->name, 0, 1) }}</div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <button wire:click="togglePublish('{{ $tm->id }}')" class="text-[9px] font-bold px-2 py-0.5 rounded-full backdrop-blur-md {{ $tm->is_published ? 'bg-emerald-500/80 text-[var(--admin-text-primary)]' : 'bg-black/60 text-[var(--admin-text-primary)]' }}">
                            {{ $tm->is_published ? 'ACTIVE' : 'HIDDEN' }}
                        </button>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] truncate">{{ $tm->name }}</h3>
                        <p class="text-xs text-[var(--admin-primary-text)] mt-0.5 truncate">{{ $tm->role }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 mt-3 border-t border-[var(--admin-border)]">
                        <span class="text-[11px] text-[var(--admin-text-secondary)] font-mono">Order: {{ $tm->sort_order }}</span>
                        <div class="flex gap-1">
                            <button wire:click="edit('{{ $tm->id }}')" class="w-7 h-7 rounded-lg bg-transparent flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)]"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button wire:click="confirmDelete('{{ $tm->id }}')" class="w-7 h-7 rounded-lg bg-transparent flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-red-600 dark:hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-sm text-[var(--admin-text-secondary)]">No team members found</div>
        @endforelse
    </div>
    @if($teamMembers->hasPages())
        <div class="mt-6">{{ $teamMembers->links('partials.admin.pagination') }}</div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-2xl">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-2">Delete Team Member</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to delete this profile?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
