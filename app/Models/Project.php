<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasUuids;

    protected $table = 'projects';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'year',
        'location',
        'area',
        'description',
        'cover_image',
        'images',
        'is_published',
        'is_headliner',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'images' => 'array',
            'is_published' => 'boolean',
            'is_headliner' => 'boolean',
            'sort_order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeHeadliner($query)
    {
        return $query->where('is_headliner', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }
}
