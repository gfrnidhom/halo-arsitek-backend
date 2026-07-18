@php
    $currentRoute = request()->route()?->getName() ?? '';
    $menuGroups = [
        'Menu Utama' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'grid'],
        ],
        'Portofolio' => [
            ['label' => 'Projects', 'route' => 'admin.projects.index', 'icon' => 'building'],
            ['label' => 'Project Categories', 'route' => 'admin.project-categories.index', 'icon' => 'folder'],
            ['label' => 'Services', 'route' => 'admin.services.index', 'icon' => 'briefcase'],
        ],
        'Konten' => [
            ['label' => 'News', 'route' => 'admin.news.index', 'icon' => 'file-text'],
            ['label' => 'News Categories', 'route' => 'admin.news-categories.index', 'icon' => 'bookmark'],
            ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'message-circle'],
            ['label' => 'Team', 'route' => 'admin.team.index', 'icon' => 'users'],
        ],
        'Sistem' => [
            ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'icon' => 'bar-chart'],
            ['label' => 'Contacts', 'route' => 'admin.contacts.index', 'icon' => 'mail'],
            ['label' => 'Admin Users', 'route' => 'admin.admins.index', 'icon' => 'shield'],
            ['label' => 'Activity Logs', 'route' => 'admin.logs.index', 'icon' => 'activity'],
            ['label' => 'Settings', 'route' => 'admin.settings.index', 'icon' => 'settings'],
        ],
    ];
@endphp

<aside
    class="admin-sidebar fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-out flex flex-col shadow-xs border-r border-[var(--admin-border)] bg-[var(--admin-sidebar-bg)]"
    :style="`width: ${sidebarWidth}px; transform: translateX(${sidebarOpen ? '0' : '-100%'});`"
    x-cloak
>
    {{-- Logo --}}
    <div class="h-[80px] flex items-center justify-between px-6 border-b border-[var(--admin-border)] shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="/logo/logo-halo-arsitek-black.png" alt="Halo Arsitek" class="w-9 h-9 object-contain shrink-0 dark:hidden">
            <img src="/logo/logo-halo-arsitek-white.png" alt="Halo Arsitek" class="w-9 h-9 object-contain shrink-0 hidden dark:block">
            <div class="flex flex-col whitespace-nowrap overflow-hidden transition-all duration-300">
                <span class="text-[1.125rem] font-bold text-[var(--admin-sidebar-text)] tracking-tight uppercase">HALO ARSITEK</span>
                <span class="text-[0.6875rem] font-medium text-[var(--admin-sidebar-text-muted)] tracking-wide truncate max-w-[160px]">{{ auth()->user()->email ?? 'Admin Panel' }}</span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-6 px-4 scrollbar-thin">
        @foreach($menuGroups as $groupName => $items)
            <div class="mb-6 last:mb-0">
                <h3 class="px-3 text-[0.6875rem] font-semibold text-[var(--admin-sidebar-text-muted)] uppercase tracking-wider mb-2">
                    {{ $groupName }}
                </h3>
                <div class="space-y-1">
                    @foreach($items as $item)
                        @php
                            $isActive = str_starts_with($currentRoute, str_replace('.index', '', $item['route']));
                        @endphp
                        <a
                            href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.875rem] font-medium transition-colors group relative
                                {{ $isActive
                                    ? 'bg-[var(--admin-sidebar-active)] text-[var(--admin-primary-text)]'
                                    : 'text-[var(--admin-sidebar-text)] hover:bg-[var(--admin-sidebar-hover)]'
                                }}"
                        >
                            @if($isActive)
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-[var(--admin-primary)] rounded-r-full"></div>
                            @endif
                            <span class="w-5 h-5 flex items-center justify-center shrink-0
                                {{ $isActive ? 'text-[var(--admin-primary-text)]' : 'text-[var(--admin-sidebar-text-muted)] group-hover:text-[var(--admin-sidebar-text)]' }}">
                                @include('partials.admin.icons.' . $item['icon'])
                            </span>
                            <span class="whitespace-nowrap transition-all duration-300">{{ $item['label'] }}</span>
                            
                            @if($item['route'] === 'admin.contacts.index')
                                @php $unreadCount = \App\Models\ContactSubmission::where('status', 'UNREAD')->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="ml-auto text-[0.625rem] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center">{{ $unreadCount }}</span>
                                @endif
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>
</aside>
