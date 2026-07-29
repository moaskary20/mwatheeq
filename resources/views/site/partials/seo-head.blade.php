@php
    use App\Models\Setting;

    $seo = static function (string $key, mixed $default = '') {
        return Setting::get($key, $default) ?? $default;
    };

    $seoUrl = static function (?string $path): ?string {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'image/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    };

    $focusKeyword = trim((string) $seo('seo_focus_keyword'));
    $metaTitle = trim((string) ($seo('seo_meta_title') ?: ($settings['hero_title'] ?? '') ?: __('site.brand')));
    $metaDescription = trim((string) ($seo('seo_meta_description') ?: ($settings['hero_subtitle'] ?? '') ?: __('site.brand')));
    $metaKeywords = trim((string) $seo('seo_meta_keywords'));
    if ($focusKeyword !== '' && $metaKeywords !== '' && ! str_contains(mb_strtolower($metaKeywords), mb_strtolower($focusKeyword))) {
        $metaKeywords = $focusKeyword.', '.$metaKeywords;
    } elseif ($focusKeyword !== '' && $metaKeywords === '') {
        $metaKeywords = $focusKeyword;
    }

    $canonical = trim((string) $seo('seo_canonical_url')) ?: url()->current();
    $robots = $seo('seo_noindex_site') === '1'
        ? 'noindex,nofollow'
        : (trim((string) $seo('seo_robots', 'index,follow')) ?: 'index,follow');
    $author = trim((string) $seo('seo_author', __('site.brand')));

    $ogTitle = trim((string) ($seo('seo_og_title') ?: $metaTitle));
    $ogDescription = trim((string) ($seo('seo_og_description') ?: $metaDescription));
    $ogImage = $seoUrl($seo('seo_og_image')) ?: asset('image/logo.png');
    $ogType = trim((string) $seo('seo_og_type', 'website')) ?: 'website';
    $ogSiteName = trim((string) ($seo('seo_og_site_name') ?: __('site.brand')));

    $twitterCard = trim((string) $seo('seo_twitter_card', 'summary_large_image')) ?: 'summary_large_image';
    $twitterTitle = trim((string) ($seo('seo_twitter_title') ?: $ogTitle));
    $twitterDescription = trim((string) ($seo('seo_twitter_description') ?: $ogDescription));
    $twitterImage = $seoUrl($seo('seo_twitter_image')) ?: $ogImage;

    $googleVerification = trim((string) $seo('seo_google_verification'));
    $bingVerification = trim((string) $seo('seo_bing_verification'));
    $gaId = trim((string) $seo('seo_google_analytics_id'));
    $gtmId = trim((string) $seo('seo_google_tag_manager_id'));

    $schemaName = trim((string) ($seo('seo_schema_org_name') ?: __('site.brand')));
    $schemaType = trim((string) $seo('seo_schema_org_type', 'Organization')) ?: 'Organization';
    $schemaLogo = $seoUrl($seo('seo_schema_org_logo')) ?: asset('image/logo.png');

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => $schemaType,
        'name' => $schemaName,
        'url' => $canonical,
        'logo' => $schemaLogo,
        'description' => $metaDescription,
    ];

    if ($focusKeyword !== '') {
        $schema['keywords'] = $focusKeyword;
    }
@endphp

@php
    $resolvedTitle = trim($__env->yieldContent('title'));
    if ($resolvedTitle === '') {
        $resolvedTitle = $metaTitle !== '' ? $metaTitle : __('site.brand_short');
    }
@endphp
<title>{{ $resolvedTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if ($metaKeywords !== '')
    <meta name="keywords" content="{{ $metaKeywords }}">
@endif
@if ($focusKeyword !== '')
    <meta name="focus-keyword" content="{{ $focusKeyword }}">
@endif
@if ($author !== '')
    <meta name="author" content="{{ $author }}">
@endif
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_EG' : 'en_US' }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ $ogSiteName }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">

<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
<meta name="twitter:image" content="{{ $twitterImage }}">

@if ($googleVerification !== '')
    <meta name="google-site-verification" content="{{ $googleVerification }}">
@endif
@if ($bingVerification !== '')
    <meta name="msvalidate.01" content="{{ $bingVerification }}">
@endif

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@if ($gtmId !== '')
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
@endif

@if ($gaId !== '')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}');
    </script>
@endif
