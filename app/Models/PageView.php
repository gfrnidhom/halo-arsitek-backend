<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasUuids;

    protected $table = 'page_views';
    public $timestamps = false;

    protected $fillable = [
        'path',
        'ip',
        'user_agent',
        'referrer',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
