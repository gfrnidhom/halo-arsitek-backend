<div class="p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--admin-text-primary)]">Admin Accounts</h2>
            <p class="text-xs text-[var(--admin-text-secondary)] mt-0.5">Manage user access and roles for the admin dashboard</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl transition-all ">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Admin
        </button>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl px-4 py-3 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</div>
    @endif

    @if($showForm)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-md w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-4">{{ $editId ? 'Edit Admin Account' : 'New Admin Account' }}</h3>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Name</label>
                        <input wire:model="name" type="text" placeholder="John Doe"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Email</label>
                        <input wire:model="email" type="email" placeholder="admin@haloarsitek.com"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('email') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Password {{ $editId ? '(Leave blank to keep unchanged)' : '' }}</label>
                        <input wire:model="password" type="password" placeholder="••••••••"
                            class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                        @error('password') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[var(--admin-text-secondary)] uppercase tracking-wider mb-2">Role</label>
                        <select wire:model="role" class="w-full bg-[var(--admin-bg-page)] border border-[var(--admin-border)] rounded-xl px-4 py-2.5 text-sm text-[var(--admin-text-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--admin-primary)]">
                            <option value="SUPER_ADMIN">SUPER_ADMIN (Full Access)</option>
                            <option value="ADMIN">ADMIN (General Management)</option>
                            <option value="EDITOR">EDITOR (Content Only)</option>
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input wire:model="is_active" type="checkbox" class="w-4 h-4 rounded border-[var(--admin-border)] bg-[var(--admin-bg-page)] text-[var(--admin-primary)]">
                            <span class="text-sm text-[var(--admin-text-primary)]">Account Active</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-3">
                        <button type="button" wire:click="resetForm" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-[var(--admin-primary)] hover:bg-[var(--admin-primary-hover)] text-white text-sm font-semibold rounded-xl ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[var(--admin-border)]">
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">User</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Role</th>
                        <th class="text-center px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Status</th>
                        <th class="text-left px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium hidden md:table-cell">Last Login</th>
                        <th class="text-right px-6 py-3.5 text-[11px] text-[var(--admin-text-secondary)] uppercase tracking-wider font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--admin-border)]">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-[var(--admin-hover-bg)] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-xs font-bold text-[var(--admin-text-primary)] uppercase shrink-0">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-[var(--admin-text-primary)]">{{ $admin->name }}</p>
                                        <p class="text-xs text-[var(--admin-text-secondary)]">{{ $admin->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md
                                    {{ $admin->role === 'SUPER_ADMIN' ? 'bg-blue-100 dark:bg-blue-900/50 text-[var(--admin-primary-text)] border border-[var(--admin-primary)]/20' : 'bg-white/[0.05] text-[var(--admin-text-primary)]' }}">
                                    {{ $admin->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $admin->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' }}">
                                    {{ $admin->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[var(--admin-text-secondary)] hidden md:table-cell">
                                {{ $admin->last_login_at ? $admin->last_login_at->translatedFormat('j M Y, H:i') : 'Never' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="edit('{{ $admin->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-[var(--admin-primary-text)]"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                    @if($admin->id !== auth()->id())
                                        <button wire:click="confirmDelete('{{ $admin->id }}')" class="w-8 h-8 rounded-lg bg-transparent border border-[var(--admin-border)] flex items-center justify-center text-[var(--admin-text-secondary)] hover:text-red-600 dark:hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-[var(--admin-text-secondary)]">No admins found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($admins->hasPages())
            <div class="px-6 py-4 border-t border-[var(--admin-border)]">{{ $admins->links('partials.admin.pagination') }}</div>
        @endif
    </div>

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[var(--admin-bg-card)] border border-[var(--admin-border)] rounded-2xl p-6 max-w-sm w-full shadow-sm">
                <h3 class="text-lg font-semibold text-[var(--admin-text-primary)] mb-2">Delete Admin</h3>
                <p class="text-sm text-[var(--admin-text-secondary)] mb-6">Are you sure you want to delete this admin account?</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2.5 bg-transparent border border-[var(--admin-border)] rounded-xl text-sm text-[var(--admin-text-primary)]">Cancel</button>
                    <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-sm text-red-600 dark:text-red-400 font-semibold">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
