<div class="p-4 md:p-8 max-w-4xl space-y-8">
    {{-- Profile Information --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
        <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-1">Profile Information</h3>
        <p class="text-xs text-[var(--admin-text-secondary)] mb-6">Update your account's profile information and email address.</p>

        @if(session('profile_success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-400">
                {{ session('profile_success') }}
            </div>
        @endif

        <form wire:submit="updateProfile" class="space-y-4 max-w-lg">
            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Name</label>
                <input wire:model="name" type="text"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Email</label>
                <input wire:model="email" type="email"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                @error('email') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-xs font-semibold rounded-xl transition-all ">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6">
        <h3 class="text-sm font-semibold text-[var(--admin-text-primary)] mb-1">Update Password</h3>
        <p class="text-xs text-[var(--admin-text-secondary)] mb-6">Ensure your account is using a long, random password to stay secure.</p>

        @if(session('password_success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-400">
                {{ session('password_success') }}
            </div>
        @endif

        <form wire:submit="updatePassword" class="space-y-4 max-w-lg">
            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Current Password</label>
                <input wire:model="current_password" type="password" placeholder="••••••••"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                @error('current_password') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">New Password</label>
                <input wire:model="new_password" type="password" placeholder="••••••••"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                @error('new_password') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Confirm New Password</label>
                <input wire:model="new_password_confirmation" type="password" placeholder="••••••••"
                    class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-xs font-semibold rounded-xl transition-all ">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
