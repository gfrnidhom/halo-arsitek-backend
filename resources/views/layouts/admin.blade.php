<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Admin' }} — Halo Arsitek</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    
    <!-- Next.js Theme Match Script -->
    <script>
        (function() {
            try {
                let theme = localStorage.getItem('admin-theme');
                if (!theme) {
                    theme = 'light';
                    localStorage.setItem('admin-theme', theme);
                }
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    document.documentElement.setAttribute('data-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            } catch (e) {}
        })();
    </script>
</head>
<body
    class="font-['Outfit'] antialiased min-h-screen transition-colors duration-300"
    x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        sidebarWidth: 260
    }"
    x-on:resize.window="sidebarOpen = window.innerWidth >= 1024"
>
    {{-- Sidebar Overlay (mobile) --}}
    <div
        x-show="sidebarOpen && window.innerWidth < 1024"
        x-on:click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none"
    ></div>

    <div class="admin-root min-h-screen flex" data-admin-root="true">
        {{-- Sidebar --}}
        @include('partials.admin.sidebar')

        {{-- Main Content --}}
        <main class="admin-root flex-1 flex flex-col transition-all duration-300 ease-out min-h-screen overflow-hidden"
            :style="`margin-left: ${window.innerWidth >= 1024 ? sidebarWidth : 0}px; width: ${window.innerWidth >= 1024 ? 'calc(100% - ' + sidebarWidth + 'px)' : '100%'}`">
            {{-- Topbar --}}
            @include('partials.admin.topbar')

            {{-- Page Content --}}
            <div class="flex-1 overflow-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
