<div class="p-4 md:p-8 max-w-6xl mx-auto space-y-8">
    
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[var(--admin-primary)] to-cyan-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                <i data-lucide="settings" class="w-8 h-8 opacity-90"></i>
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-[var(--admin-text-primary)] tracking-tight">Site Settings</h2>
                <p class="text-sm text-[var(--admin-text-secondary)] mt-1">Configure your website's global information, SEO, and contact details</p>
            </div>
        </div>
        
        <div class="flex items-center">
            <button type="submit" form="settings-form" class="w-full sm:w-auto px-6 py-3.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all shadow-[0_4px_12px_rgba(37,99,235,0.2)] hover:shadow-[0_6px_16px_rgba(37,99,235,0.3)] flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Save All Settings
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" id="settings-form" class="space-y-6">
        @php
            $grouped = collect($schema)->groupBy('group', true);
            $leftColumn = collect();
            $rightColumn = collect();
            
            $idx = 0;
            foreach($grouped as $groupName => $items) {
                if ($idx % 2 === 0) {
                    $leftColumn->put($groupName, $items);
                } else {
                    $rightColumn->put($groupName, $items);
                }
                $idx++;
            }
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
            {{-- Left Column --}}
            <div class="flex flex-col gap-6 lg:gap-8">
                @foreach($leftColumn as $groupName => $items)
                    @include('livewire.admin.settings.partials.card', ['groupName' => $groupName, 'items' => $items])
                @endforeach
            </div>
            
            {{-- Right Column --}}
            <div class="flex flex-col gap-6 lg:gap-8">
                @foreach($rightColumn as $groupName => $items)
                    @include('livewire.admin.settings.partials.card', ['groupName' => $groupName, 'items' => $items])
                @endforeach
            </div>
        </div>
    </form>
</div>
