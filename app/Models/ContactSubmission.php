<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasUuids;

    protected $table = 'contact_submissions';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'budget',
        'status',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'UNREAD');
    }

    public function markAsRead(): void
    {
        $this->update([
            'status' => 'READ',
            'read_at' => now(),
        ]);
    }
}
