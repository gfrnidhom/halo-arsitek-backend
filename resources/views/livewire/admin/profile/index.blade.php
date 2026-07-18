<div class="p-4 md:p-8 max-w-6xl mx-auto space-y-8">
    
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[var(--admin-primary)] to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                <i data-lucide="user-circle" class="w-8 h-8 opacity-90"></i>
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-[var(--admin-text-primary)] tracking-tight">Account Profile</h2>
                <p class="text-sm text-[var(--admin-text-secondary)] mt-1">Manage your personal information and security settings</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

        {{-- Left Column: Profile Information --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-3 border-b border-[var(--admin-border)] pb-4 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <i data-lucide="contact" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-[var(--admin-text-primary)]">Profile Information</h3>
                    <p class="text-[11px] text-[var(--admin-text-secondary)] mt-0.5">Update your account's profile information and email address.</p>
                </div>
            </div>

            @if(session('profile_success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                    {{ session('profile_success') }}
                </div>
            @endif

            <form wire:submit="updateProfile" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input wire:model="name" type="text"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-11 pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    </div>
                    @error('name') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input wire:model="email" type="email"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-11 pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    </div>
                    @error('email') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all shadow-[0_4px_12px_rgba(37,99,235,0.2)] hover:shadow-[0_6px_16px_rgba(37,99,235,0.3)] flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Column: Update Password --}}
        <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-3 border-b border-[var(--admin-border)] pb-4 mb-6">
                <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-[var(--admin-text-primary)]">Update Password</h3>
                    <p class="text-[11px] text-[var(--admin-text-secondary)] mt-0.5">Ensure your account is using a long, random password to stay secure.</p>
                </div>
            </div>

            @if(session('password_success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl px-4 py-3 text-sm text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                    {{ session('password_success') }}
                </div>
            @endif

            <form wire:submit="updatePassword" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">Current Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input wire:model="current_password" type="password" placeholder="••••••••"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-11 pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    </div>
                    @error('current_password') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                            <i data-lucide="key" class="w-4 h-4"></i>
                        </div>
                        <input wire:model="new_password" type="password" placeholder="••••••••"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-11 pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    </div>
                    @error('new_password') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-[var(--admin-text-secondary)] uppercase tracking-widest mb-2">Confirm New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--admin-text-secondary)]">
                            <i data-lucide="key" class="w-4 h-4"></i>
                        </div>
                        <input wire:model="new_password_confirmation" type="password" placeholder="••••••••"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl pl-11 pr-4 py-3 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)] transition-all">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-[var(--admin-text-primary)] hover:bg-black dark:hover:bg-slate-700 text-[var(--admin-bg-page)] text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <i data-lucide="shield" class="w-4 h-4"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
