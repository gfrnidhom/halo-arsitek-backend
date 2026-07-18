<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasUuids;

    protected $table = 'sessions';
    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'token_hash',
        'expires_at',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now());
    }
}
