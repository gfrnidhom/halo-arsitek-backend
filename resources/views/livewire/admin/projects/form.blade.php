<div class="p-4 md:p-8 max-w-4xl">
    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        {{-- Basic Info --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 space-y-5">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Basic Information</h3>

            {{-- Title --}}
            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Title</label>
                <input wire:model.live.debounce.500ms="title" type="text" placeholder="Project title"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all">
                @error('title') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Slug</label>
                <input wire:model="slug" type="text" placeholder="project-slug"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all font-mono text-xs">
                @error('slug') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Category --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Category</label>
                    <select wire:model="category_id" class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Year --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Year</label>
                    <input wire:model="year" type="number" min="1900" max="2100"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    @error('year') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Location --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Location</label>
                    <input wire:model="location" type="text" placeholder="Jakarta, Indonesia"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    @error('location') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Area --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Area</label>
                    <input wire:model="area" type="text" placeholder="250 m²"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    @error('area') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Description</label>
                <textarea wire:model="description" rows="6" placeholder="Project description..."
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all resize-y"></textarea>
                @error('description') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Cover Image</h3>
            <div class="flex items-start gap-4">
                @if($cover_image)
                    <img src="{{ $cover_image }}" alt="Cover" class="w-32 h-24 rounded-xl object-cover bg-slate-200 dark:bg-slate-700">
                @else
                    <div class="w-32 h-24 rounded-xl bg-[var(--admin-bg-page)] border border-[var(--admin-border)] border-dashed flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                <div class="flex-1">
                    <input wire:model="cover_image_file" type="file" accept="image/*" class="block w-full text-sm text-[var(--admin-text-secondary)] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-100 dark:bg-blue-900/40 file:text-[var(--admin-primary-text)] hover:file:bg-[var(--admin-primary)]/20 file:cursor-pointer file:transition-all">
                    <p class="text-xs text-[var(--admin-text-secondary)] mt-2">JPEG, PNG, WebP, AVIF. Max 5MB.</p>
                    @error('cover_image_file') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @error('cover_image') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="cover_image_file" class="mt-2 text-xs text-[var(--admin-primary-text)]">Uploading...</div>
                </div>
            </div>
        </div>

        {{-- Project Images --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-[var(--admin-text-primary)]">Project Images</h3>
                @if(count($images) > 0)
                    <span class="text-xs text-[var(--admin-text-secondary)] bg-[var(--admin-bg-page)] px-2.5 py-1 rounded-lg border border-[var(--admin-border)]">{{ count($images) }} image{{ count($images) > 1 ? 's' : '' }}</span>
                @endif
            </div>
            
            <div class="space-y-4">
                {{-- Upload Area --}}
                <div class="relative">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[var(--admin-border)] rounded-xl cursor-pointer bg-[var(--admin-bg-page)] hover:bg-[var(--admin-hover-bg)] hover:border-[var(--admin-primary)] transition-all duration-300 group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6" wire:loading.remove wire:target="image_files">
                            <svg class="w-8 h-8 mb-2 text-[var(--admin-text-secondary)] group-hover:text-[var(--admin-primary)] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 16V4m0 0L8 8m4-4l4 4m-12 8l1.292-1.293a2 2 0 012.828 0L12 15l2.88-2.88a2 2 0 012.828 0L20 14.5M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-[var(--admin-text-secondary)]"><span class="font-semibold text-[var(--admin-primary)]">Klik untuk upload</span> atau drag & drop</p>
                            <p class="text-[10px] text-[var(--admin-text-secondary)] mt-1">JPEG, PNG, WebP, AVIF. Max 5MB per image.</p>
                        </div>
                        <div wire:loading wire:target="image_files" class="flex flex-col items-center gap-2">
                            <svg class="w-6 h-6 animate-spin text-[var(--admin-primary)]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span class="text-xs text-[var(--admin-primary)] font-medium">Uploading images...</span>
                        </div>
                        <input wire:model="image_files" type="file" multiple accept="image/*" class="hidden">
                    </label>
                </div>
                @error('image_files.*') <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                {{-- Image Grid with Reorder --}}
                @if(count($images) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-2">
                        @foreach($images as $index => $img)
                            <div class="relative group aspect-[4/3] rounded-xl overflow-hidden border border-[var(--admin-border)] bg-[var(--admin-bg-page)] transition-all duration-200 hover:border-[var(--admin-primary)]/50 hover:shadow-lg hover:shadow-[var(--admin-primary)]/5" wire:key="project-image-{{ $index }}">
                                {{-- Image --}}
                                <img src="{{ $img }}" alt="Project Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                
                                {{-- Order Badge --}}
                                <div class="absolute top-2 left-2 w-6 h-6 bg-black/60 backdrop-blur-sm text-white rounded-lg flex items-center justify-center text-[10px] font-bold z-10">
                                    {{ $index + 1 }}
                                </div>

                                {{-- Hover Overlay with Actions --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-3 gap-1.5">
                                    {{-- Move Up --}}
                                    <button type="button" wire:click="moveImageUp({{ $index }})"
                                        @if($index === 0) disabled @endif
                                        class="w-8 h-8 bg-white/20 backdrop-blur-sm hover:bg-white/40 disabled:opacity-30 disabled:cursor-not-allowed text-white rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110"
                                        title="Geser ke kiri">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    {{-- Move Down --}}
                                    <button type="button" wire:click="moveImageDown({{ $index }})"
                                        @if($index === count($images) - 1) disabled @endif
                                        class="w-8 h-8 bg-white/20 backdrop-blur-sm hover:bg-white/40 disabled:opacity-30 disabled:cursor-not-allowed text-white rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110"
                                        title="Geser ke kanan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                    {{-- Remove --}}
                                    <button type="button" wire:click="removeImage({{ $index }})"
                                        class="w-8 h-8 bg-red-500/80 backdrop-blur-sm hover:bg-red-500 text-white rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110"
                                        title="Hapus image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-[var(--admin-text-secondary)] mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Hover gambar untuk menampilkan tombol aksi. Gunakan panah untuk menggeser posisi urutan.
                    </p>
                @endif
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Settings</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                {{-- Published --}}
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input wire:model="is_published" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)] focus:ring-offset-0">
                    <span class="text-sm text-[var(--admin-text-secondary)] group-hover:text-[var(--admin-text-primary)]">Published</span>
                </label>

                {{-- Headliner --}}
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input wire:model="is_headliner" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)] focus:ring-offset-0">
                    <span class="text-sm text-[var(--admin-text-secondary)] group-hover:text-[var(--admin-text-primary)]">Headliner</span>
                </label>

                {{-- Sort Order --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Sort Order</label>
                    <input wire:model="sort_order" type="number" class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all  flex items-center gap-2"
                wire:loading.attr="disabled" wire:loading.class="opacity-70">
                <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Update Project' : 'Create Project' }}</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
            <a href="{{ route('admin.projects.index') }}" class="px-6 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-all">Cancel</a>
        </div>
    </form>
</div>
