<div class="p-4 md:p-8 max-w-7xl mx-auto">
    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        {{-- Left Column: Main Content (2/3 width) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Article Content --}}
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 space-y-5">
                <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Article Content</h3>

                {{-- Title --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Title</label>
                    <input wire:model.live.debounce.500ms="title" type="text" placeholder="Article title"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all">
                    @error('title') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Slug</label>
                    <input wire:model="slug" type="text" placeholder="article-slug"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all font-mono text-xs">
                    @error('slug') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Content (Trix Editor) --}}
                <div wire:ignore>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Content</label>
                    <input id="trix-content" type="hidden" value="{{ $content }}">
                    <trix-editor input="trix-content" class="trix-content prose dark:prose-invert max-w-none text-sm"></trix-editor>
                </div>
                @error('content') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Right Column: Settings & Meta (1/3 width) --}}
        <div class="space-y-6">

            {{-- Properties --}}
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 space-y-5">
                <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] border-b border-[var(--admin-border)] pb-3">Properties</h3>

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

                {{-- Published --}}
                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input wire:model="is_published" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)] focus:ring-offset-0">
                        <span class="text-sm font-medium text-[var(--admin-text-secondary)] group-hover:text-[var(--admin-text-primary)]">Published immediately</span>
                    </label>
                </div>
            </div>

            {{-- Cover Image --}}
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
                <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Cover Image</h3>
                
                @if($cover_image)
                    <div class="w-full aspect-video rounded-xl overflow-hidden mb-4 border border-[var(--admin-border)]">
                        <img src="{{ $cover_image }}" alt="Cover" class="w-full h-full object-cover bg-slate-200 dark:bg-slate-700">
                    </div>
                @else
                    <div class="w-full aspect-video rounded-xl bg-[var(--admin-bg-page)] border border-[var(--admin-border)] border-dashed flex flex-col items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-[var(--admin-text-secondary)] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-[var(--admin-text-secondary)]">No cover selected</span>
                    </div>
                @endif
                
                <div>
                    <input wire:model="cover_image_file" type="file" accept="image/*" class="block w-full text-xs text-[var(--admin-text-secondary)] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-100 dark:bg-blue-900/40 file:text-[var(--admin-primary-text)] hover:file:bg-[var(--admin-primary)]/20 file:cursor-pointer file:transition-all">
                    <p class="text-[10px] text-[var(--admin-text-secondary)] mt-2">JPEG, PNG, WebP. Max 5MB.</p>
                    @error('cover_image_file') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @error('cover_image') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="cover_image_file" class="mt-2 text-xs text-[var(--admin-primary-text)]">Uploading...</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
                <button type="submit" class="w-full py-3 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 mb-3"
                    wire:loading.attr="disabled" wire:loading.class="opacity-70">
                    <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Update Article' : 'Create Article' }}</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
                <a href="{{ route('admin.news.index') }}" class="block w-full text-center py-3 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm font-semibold text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-all">Cancel</a>
            </div>
            
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener("trix-change", function(event) {
        if (event.target.getAttribute("input") === "trix-content") {
            @this.set('content', document.getElementById("trix-content").value);
        }
    });
</script>
@endpush

