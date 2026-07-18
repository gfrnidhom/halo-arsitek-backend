<div class="min-h-screen flex items-center justify-center px-4 bg-[var(--admin-bg-page)] transition-colors duration-300">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[var(--admin-primary)] mb-4 shadow-lg shadow-blue-500/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[var(--admin-text-primary)] tracking-tight">Halo Arsitek</h1>
            <p class="text-sm text-[var(--admin-text-secondary)] mt-1">Admin Panel</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-black/20">
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-6 text-center">Masuk ke Dashboard</h2>

            <form wire:submit="login" class="space-y-5">
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Email</label>
                    <input
                        wire:model="email"
                        type="email"
                        id="email"
                        autocomplete="email"
                        placeholder="admin@haloarsitek.com"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all text-sm"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Password</label>
                    <input
                        wire:model="password"
                        type="password"
                        id="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-3 text-[var(--admin-text-primary)] placeholder-[var(--admin-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] focus:border-transparent transition-all text-sm"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember --}}
                <div class="flex items-center">
                    <input
                        wire:model="remember"
                        type="checkbox"
                        id="remember"
                        class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)] focus:ring-[var(--admin-primary)] focus:ring-offset-0"
                    >
                    <label for="remember" class="ml-2 text-sm text-[var(--admin-text-secondary)]">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white font-medium py-3 px-4 rounded-xl transition-colors duration-200 shadow-md flex items-center justify-center gap-2"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-70 cursor-not-allowed"
                >
                    <svg wire:loading wire:target="login" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="login">Masuk</span>
                    <span wire:loading wire:target="login">Memproses...</span>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-[var(--admin-text-secondary)] mt-8">&copy; {{ date('Y') }} Halo Arsitek. All rights reserved.</p>
    </div>
</div>
