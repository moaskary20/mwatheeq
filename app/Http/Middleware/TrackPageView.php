<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /** @var list<string> */
    protected array $excludedPrefixes = [
        'admin',
        'livewire',
        'login',
        'register',
        'logout',
        'locale',
        'up',
        '_ignition',
        'telescope',
        'horizon',
    ];

    /** @var list<string> */
    protected array $excludedExact = [
        'robots.txt',
        'sitemap.xml',
        'favicon.ico',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            try {
                PageView::recordFromRequest($request);
            } catch (\Throwable) {
                // Never break the site because of analytics.
            }
        }

        return $response;
    }

    protected function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
            return false;
        }

        if ($response->getStatusCode() >= 400) {
            return false;
        }

        $path = trim($request->path(), '/');

        if ($path === '' || $path === '/') {
            return true;
        }

        if (in_array($path, $this->excludedExact, true)) {
            return false;
        }

        foreach ($this->excludedPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return false;
            }
        }

        if (preg_match('/\.(css|js|map|jpg|jpeg|png|gif|webp|svg|ico|woff2?|ttf|eot|pdf)$/i', $path)) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');
        if ($contentType !== '' && ! str_contains($contentType, 'text/html')) {
            return false;
        }

        return true;
    }
}
