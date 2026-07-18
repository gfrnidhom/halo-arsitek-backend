<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasUuids;

    protected $table = 'activity_logs';
    public $timestamps = false;

    protected $fillable = [
        'action',
        'details',
        'admin_name',
        'admin_role',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Log an admin activity.
     */
    public static function logActivity(string $action, ?string $details = null, ?Admin $admin = null, ?string $ipAddress = null): void
    {
        static::create([
            'action' => $action,
            'details' => $details,
            'admin_name' => $admin?->name ?? 'System',
            'admin_role' => $admin?->role ?? 'SYSTEM',
            'ip_address' => $ipAddress,
        ]);
    }
}
