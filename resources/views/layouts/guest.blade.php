<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Halo Arsitek — Admin' }}</title>
    @php
        $siteFavicon = \App\Models\SiteSetting::getValue('site_favicon');
        $siteLogo = \App\Models\SiteSetting::getValue('site_logo');
        $faviconUrl = asset('favicon.ico');
        if ($siteFavicon) {
            $faviconUrl = str_starts_with($siteFavicon, 'http') ? $siteFavicon : Storage::url($siteFavicon);
        } elseif ($siteLogo) {
            $faviconUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : Storage::url($siteLogo);
        }
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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
<body class="font-['Outfit'] antialiased min-h-screen transition-colors duration-300">
    {{ $slot }}
    @livewireScripts
</body>
</html>
