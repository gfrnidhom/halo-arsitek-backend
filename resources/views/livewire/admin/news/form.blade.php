<div class="p-4 md:p-8 max-w-4xl">
    <form wire:submit="save" class="space-y-6">
        {{-- Basic Info --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 space-y-5">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Article Content</h3>

            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Title</label>
                <input wire:model.live.debounce.500ms="title" type="text" placeholder="Article title"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                @error('title') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Slug</label>
                    <input wire:model="slug" type="text" placeholder="article-slug"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] font-mono text-xs">
                    @error('slug') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

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
            </div>

            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Content (HTML / Markdown)</label>
                <textarea wire:model="content" rows="12" placeholder="Write your article content here..."
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] font-mono resize-y"></textarea>
                @error('content') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
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
                    <input wire:model="cover_image_file" type="file" accept="image/*" class="block w-full text-sm text-[var(--admin-text-secondary)] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-100 dark:bg-blue-900/40 file:text-[var(--admin-primary-text)] hover:file:bg-[var(--admin-primary)]/20 file:cursor-pointer transition-all">
                    @error('cover_image_file') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @error('cover_image') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="cover_image_file" class="mt-2 text-xs text-[var(--admin-primary-text)]">Uploading...</div>
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-4">Publishing</h3>
            <label class="flex items-center gap-3 cursor-pointer group">
                <input wire:model="is_published" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)]">
                <span class="text-sm text-[var(--admin-text-secondary)] group-hover:text-[var(--admin-text-primary)]">Published immediately</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all "
                wire:loading.attr="disabled" wire:loading.class="opacity-70">
                <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Update Article' : 'Create Article' }}</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-secondary)] hover:text-[var(--admin-text-primary)] transition-all">Cancel</a>
        </div>
    </form>
</div>
