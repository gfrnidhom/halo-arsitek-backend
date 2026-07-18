<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasUuids;

    protected $table = 'site_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) return $default;

        return match ($setting->type) {
            'NUMBER' => (float) $setting->value,
            'BOOLEAN' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'JSON' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, mixed $value, string $type = 'STRING'): void
    {
        $storeValue = match ($type) {
            'JSON' => json_encode($value),
            'BOOLEAN' => $value ? 'true' : 'false',
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $storeValue, 'type' => $type]
        );
    }
}
