<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );

        Cache::forget('site_settings');
    }

    public static function many(array $keys): array
    {
        $result = [];

        foreach ($keys as $key => $default) {
            if (is_int($key)) {
                $result[$default] = static::get($default);
            } else {
                $result[$key] = static::get($key, $default);
            }
        }

        return $result;
    }
}
