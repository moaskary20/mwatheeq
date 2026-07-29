<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', function () {
    $content = \App\Models\Setting::get('seo_robots_txt');
    $sitemap = \App\Models\Setting::get('seo_sitemap_url') ?: url('/sitemap.xml');

    if (blank($content)) {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nDisallow: /register\nSitemap: {$sitemap}\n";
    } elseif (! str_contains($content, 'Sitemap:')) {
        $content = rtrim($content)."\nSitemap: {$sitemap}\n";
    }

    return response($content, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
    ]);
})->name('robots');

Route::get('/sitemap.xml', function () {
    $urls = [
        url('/'),
        url('/services'),
        url('/about'),
        url('/blog'),
        url('/contact'),
    ];

    if (class_exists(\App\Models\BlogPost::class)) {
        \App\Models\BlogPost::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function ($post) use (&$urls) {
                $urls[] = url('/blog/'.$post->slug);
            });
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
    foreach (array_unique($urls) as $loc) {
        $xml .= '  <url><loc>'.e($loc).'</loc><changefreq>weekly</changefreq></url>'."\n";
    }
    $xml .= '</urlset>';

    return response($xml, 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
    ]);
})->name('sitemap');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->whereIn('locale', ['ar', 'en'])
    ->name('locale.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [HomeController::class, 'contactPage'])->name('contact');
Route::post('/contact', [HomeController::class, 'contact'])->name('contact.store');
Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/blog/{post:slug}/comments', [BlogController::class, 'comment'])->name('blog.comment');
});
