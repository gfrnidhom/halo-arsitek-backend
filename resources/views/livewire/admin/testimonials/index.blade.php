<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">Client Testimonials</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">Manage feedback and reviews displayed on website</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all ">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Testimonial
        </button>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-lg w-full shadow-sm max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-4">{{ $editId ? 'Edit Testimonial' : 'Add Testimonial' }}</h3>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Client Name</label>
                        <input wire:model="name" type="text" placeholder="Budi Santoso"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Role / Profession</label>
                            <input wire:model="role" type="text" placeholder="CEO, PT X / Pemilik Rumah"
                                class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Project Name</label>
                            <input wire:model="project" type="text" placeholder="Villa Modern Bali"
                                class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Quote / Review</label>
                        <textarea wire:model="quote" rows="4" placeholder="Desainnya sangat memuaskan..."
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]"></textarea>
                        @error('quote') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Avatar (Optional)</label>
                        <div class="flex items-center gap-3">
                            @if($avatar_url)
                                <img src="{{ $avatar_url }}" alt="" class="w-12 h-12 rounded-full object-cover bg-slate-200 dark:bg-slate-700">
                            @endif
                            <input wire:model="avatar_file" type="file" accept="image/*" class="text-sm text-[var(--admin-text-secondary)] file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-100 dark:bg-blue-900/40 file:text-[var(--admin-primary-text)]">
                        </div>
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
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Client</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Review</th>
                        <th class="text-center px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Status</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($testimonials as $t)
                        <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($t->avatar_url)
                                        <img src="{{ $t->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover shrink-0 bg-slate-200 dark:bg-slate-700">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-[var(--admin-primary-text)] font-bold flex items-center justify-center shrink-0">
                                            {{ substr($t->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-[var(--admin-text-primary)]">{{ $t->name }}</p>
                                        <p class="text-xs text-[var(--admin-text-secondary)]">{{ $t->role ?: '-' }} {{ $t->project ? "• {$t->project}" : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <p class="text-xs text-[var(--admin-text-secondary)] line-clamp-2 italic">"{{ $t->quote }}"</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="togglePublish('{{ $t->id }}')" class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $t->is_published ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-slate-100 dark:bg-slate-800 text-[var(--admin-text-secondary)]' }}">
                                    {{ $t->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="edit('{{ $t->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)]"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                    <button wire:click="confirmDelete('{{ $t->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-red-600 dark:hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-[var(--admin-text-secondary)]">No testimonials found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($testimonials->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">{{ $testimonials->links('partials.admin.pagination') }}</div>
        @endif
    </div>

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-2">Delete Testimonial</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to delete this testimonial?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
