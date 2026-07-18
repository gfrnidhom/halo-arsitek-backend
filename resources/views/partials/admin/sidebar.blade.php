@php
    $currentRoute = request()->route()?->getName() ?? '';
    $menuItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'grid'],
        ['label' => 'Projects', 'route' => 'admin.projects.index', 'icon' => 'building'],
        ['label' => 'Project Categories', 'route' => 'admin.project-categories.index', 'icon' => 'folder'],
        ['label' => 'News', 'route' => 'admin.news.index', 'icon' => 'file-text'],
        ['label' => 'News Categories', 'route' => 'admin.news-categories.index', 'icon' => 'bookmark'],
        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'message-circle'],
        ['label' => 'Services', 'route' => 'admin.services.index', 'icon' => 'briefcase'],
        ['label' => 'Team', 'route' => 'admin.team.index', 'icon' => 'users'],
        ['label' => 'Contacts', 'route' => 'admin.contacts.index', 'icon' => 'mail'],
        ['label' => 'Settings', 'route' => 'admin.settings.index', 'icon' => 'settings'],
        ['label' => 'Admin Users', 'route' => 'admin.admins.index', 'icon' => 'shield'],
        ['label' => 'Activity Logs', 'route' => 'admin.logs.index', 'icon' => 'activity'],
    ];
@endphp

<aside
    class="admin-sidebar fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-out flex flex-col shadow-lg border-r border-[var(--admin-border)] bg-[var(--admin-sidebar-bg)]"
    :style="`width: ${sidebarWidth}px; transform: translateX(${sidebarOpen ? '0' : '-100%'});`"
    x-cloak
>
    {{-- Logo --}}
    <div class="h-[80px] flex items-center justify-between px-6 border-b border-[var(--admin-border)] shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[var(--admin-primary)] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[var(--admin-text-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="flex flex-col whitespace-nowrap overflow-hidden transition-all duration-300">
                <span class="text-[1.125rem] font-bold text-[var(--admin-sidebar-text)] tracking-tight">Halo Arsitek</span>
                <span class="text-[0.6875rem] font-medium text-[var(--admin-sidebar-text-muted)] uppercase tracking-wider">Admin Panel</span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 scrollbar-thin">
        @foreach($menuItems as $item)
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
    </nav>
</aside>
