<div class="p-4 md:p-8 max-w-7xl mx-auto">
    @if(session('success'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        @php
            $grouped = collect($settings)->groupBy('group');
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            @foreach($grouped as $groupName => $items)
                <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] border-b border-[var(--admin-border)] pb-3">{{ $groupName }}</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($items as $key => $meta)
                            <div>
                                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">{{ $meta['label'] }}</label>
                                @if(str_contains($key, 'description') || str_contains($key, 'address'))
                                    <textarea wire:model="settings.{{ $key }}.value" rows="3"
                                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all"></textarea>
                                @else
                                    <input wire:model="settings.{{ $key }}.value" type="text"
                                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-3 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all shadow-md flex items-center gap-2"
                wire:loading.attr="disabled" wire:loading.class="opacity-70">
                <span wire:loading.remove wire:target="save">Save All Settings</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>
