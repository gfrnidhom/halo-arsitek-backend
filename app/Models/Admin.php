<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasUuids;

    protected $table = 'admins';

    protected $fillable = [
        'email',
        'name',
        'password_hash',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Override for Laravel Auth — use password_hash column.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'admin_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'SUPER_ADMIN';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
