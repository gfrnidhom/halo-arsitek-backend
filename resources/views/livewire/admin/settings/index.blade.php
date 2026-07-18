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
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
            @foreach($grouped as $groupName => $items)
                @php
                    $groupIcon = match(strtolower($groupName)) {
                        'general' => 'layout-dashboard',
                        'seo' => 'search',
                        'social media' => 'share-2',
                        'social' => 'share-2',
                        'contact' => 'map-pin',
                        'company' => 'building-2',
                        'statistics' => 'bar-chart-2',
                        default => 'settings-2'
                    };
                    $groupColor = match(strtolower($groupName)) {
                        'general' => 'blue',
                        'seo' => 'violet',
                        'social media' => 'pink',
                        'social' => 'pink',
                        'contact' => 'emerald',
                        'company' => 'amber',
                        'statistics' => 'indigo',
                        default => 'slate'
                    };
                @endphp
                <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 border-b border-[var(--admin-border)] pb-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-{{ $groupColor }}-50 dark:bg-{{ $groupColor }}-900/30 text-{{ $groupColor }}-600 dark:text-{{ $groupColor }}-400 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $groupIcon }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-[var(--admin-text-primary)]">{{ $groupName }} Configuration</h3>
                            <p class="text-[11px] text-[var(--admin-text-secondary)] mt-0.5">Manage settings related to {{ strtolower($groupName) }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-5">
                        @foreach($items as $key => $meta)
                            <div>
                                <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">{{ $meta['label'] }}</label>
                                @if(str_contains(strtolower($key), 'description') || str_contains(strtolower($key), 'address') || str_contains(strtolower($key), 'script'))
                                    <textarea wire:model="settings.{{ $key }}" rows="4"
                                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all resize-y"></textarea>
                                @else
                                    <div class="relative">
                                        @if(str_contains(strtolower($key), 'url') || str_contains(strtolower($key), 'link'))
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                                                <i data-lucide="link" class="w-4 h-4"></i>
                                            </div>
                                        @elseif(str_contains(strtolower($key), 'email'))
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                                                <i data-lucide="mail" class="w-4 h-4"></i>
                                            </div>
                                        @elseif(str_contains(strtolower($key), 'phone') || str_contains(strtolower($key), 'whatsapp'))
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                                                <i data-lucide="phone" class="w-4 h-4"></i>
                                            </div>
                                        @endif
                                        
                                        @php
                                            $hasIcon = str_contains(strtolower($key), 'url') || str_contains(strtolower($key), 'link') || str_contains(strtolower($key), 'email') || str_contains(strtolower($key), 'phone') || str_contains(strtolower($key), 'whatsapp');
                                        @endphp
                                        
                                        <input wire:model="settings.{{ $key }}" type="text"
                                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl {{ $hasIcon ? 'pl-11' : 'px-4' }} pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>
