<header class="h-[80px] bg-[var(--admin-bg-card)] border-b border-[var(--admin-border)] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30 shadow-sm transition-colors duration-300">
    <div class="flex items-center gap-4">
        {{-- Mobile menu button --}}
        <button
            x-on:click="sidebarOpen = !sidebarOpen"
            class="lg:hidden p-2 rounded-lg bg-transparent border border-[var(--admin-border)] text-[var(--admin-text-primary)] hover:bg-[var(--admin-hover-bg)] transition-colors"
            title="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Page title --}}
        <div>
            <h1 class="text-[1.25rem] md:text-[1.5rem] font-semibold text-[var(--admin-text-primary)] tracking-tight m-0 leading-tight">{{ $title ?? 'Dashboard' }}</h1>
            @if(isset($subtitle))
                <p class="hidden md:block text-[0.8125rem] text-[var(--admin-text-secondary)] mt-1 font-['Outfit']">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-4" x-data="{ 
        theme: localStorage.getItem('admin-theme') || 'light',
        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('admin-theme', this.theme);
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
            }
        }
    }">
        {{-- Theme Toggle --}}
        <button
            x-on:click="toggleTheme()"
            class="p-2 rounded-lg bg-transparent border border-[var(--admin-border)] text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)] hover:bg-[var(--admin-hover-bg)] transition-colors"
            title="Toggle Theme"
        >
            <template x-if="theme === 'light'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </template>
            <template x-if="theme === 'dark'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </template>
        </button>

        {{-- Visit site --}}
        <a
            href="{{ config('app.frontend_url', '/') }}"
            target="_blank"
            class="hidden sm:flex items-center gap-2 px-3 md:px-4 py-2 rounded-lg text-[0.75rem] tracking-wide text-[var(--admin-text-secondary)] bg-transparent border border-[var(--admin-border)] hover:bg-[var(--admin-hover-bg)] hover:text-[var(--admin-text-primary)] transition-colors"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Visit Site
        </a>

        {{-- Profile --}}
        <a
            href="{{ route('admin.profile') }}"
            class="p-2 rounded-lg bg-transparent border border-[var(--admin-border)] text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)] hover:bg-[var(--admin-hover-bg)] transition-colors"
            title="Edit Profile"
        >
            <i data-lucide="user" class="w-4 h-4"></i>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button
                type="submit"
                class="p-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800/50 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors"
                title="Logout"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</header>
