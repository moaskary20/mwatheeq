<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'path',
        'full_url',
        'method',
        'ip',
        'session_id',
        'user_agent',
        'referer',
        'referer_host',
        'device',
        'browser',
        'platform',
        'locale',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'is_bot',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'is_bot' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function scopeHumans(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * @return array{device: string, browser: string, platform: string, is_bot: bool}
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        $ua = $userAgent ?? '';
        $isBot = (bool) preg_match(
            '/bot|crawl|spider|slurp|facebookexternalhit|preview|wget|curl|python|scrapy|semrush|ahrefs|bingpreview|yandex|duckduck/i',
            $ua
        );

        $device = 'desktop';
        if ($isBot) {
            $device = 'bot';
        } elseif (preg_match('/ipad|tablet|playbook|silk|(android(?!.*mobile))/i', $ua)) {
            $device = 'tablet';
        } elseif (preg_match('/mobile|iphone|ipod|android.*mobile|windows phone|blackberry|opera mini/i', $ua)) {
            $device = 'mobile';
        }

        $browser = 'أخرى';
        if (preg_match('/Edg\//i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/OPR\/|Opera/i', $ua)) {
            $browser = 'Opera';
        } elseif (preg_match('/Chrome\//i', $ua) && ! preg_match('/Edg\//i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\//i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari\//i', $ua) && ! preg_match('/Chrome\//i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/MSIE|Trident/i', $ua)) {
            $browser = 'IE';
        }

        $platform = 'أخرى';
        if (preg_match('/Windows/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/Android/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $ua)) {
            $platform = 'iOS';
        } elseif (preg_match('/Mac OS X|Macintosh/i', $ua)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/i', $ua)) {
            $platform = 'Linux';
        }

        return [
            'device' => $device,
            'browser' => $browser,
            'platform' => $platform,
            'is_bot' => $isBot,
        ];
    }

    public static function recordFromRequest(Request $request): void
    {
        $ua = (string) $request->userAgent();
        $parsed = static::parseUserAgent($ua);
        $referer = $request->headers->get('referer');
        $refererHost = null;

        if (filled($referer)) {
            $host = parse_url($referer, PHP_URL_HOST);
            $appHost = parse_url(config('app.url'), PHP_URL_HOST);

            if ($host && $host !== $appHost) {
                $refererHost = $host;
            }
        }

        static::query()->create([
            'path' => '/'.ltrim($request->path(), '/'),
            'full_url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'session_id' => $request->hasSession() ? $request->session()->getId() : null,
            'user_agent' => mb_substr($ua, 0, 1000),
            'referer' => $referer ? mb_substr($referer, 0, 1000) : null,
            'referer_host' => $refererHost,
            'device' => $parsed['device'],
            'browser' => $parsed['browser'],
            'platform' => $parsed['platform'],
            'locale' => app()->getLocale(),
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'is_bot' => $parsed['is_bot'],
            'created_at' => now(),
        ]);
    }
}
