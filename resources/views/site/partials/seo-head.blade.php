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
    $themeColor = trim((string) $seo('seo_theme_color', '#3154ad')) ?: '#3154ad';

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
    $yandexVerification = trim((string) $seo('seo_yandex_verification'));
    $gaId = trim((string) $seo('seo_google_analytics_id'));
    $googleTagId = trim((string) $seo('seo_google_tag_id'));
    $googleAdsId = trim((string) $seo('seo_google_ads_id'));
    $gtmId = trim((string) $seo('seo_google_tag_manager_id'));
    $facebookPixelId = trim((string) $seo('seo_facebook_pixel_id'));
    $facebookDomainVerification = trim((string) $seo('seo_facebook_domain_verification'));

    $hreflangAr = trim((string) $seo('seo_hreflang_ar'));
    $hreflangEn = trim((string) $seo('seo_hreflang_en'));
    $hreflangDefault = trim((string) $seo('seo_hreflang_x_default'));
    $customHead = trim((string) $seo('seo_custom_head'));

    $schemaName = trim((string) ($seo('seo_schema_org_name') ?: __('site.brand')));
    $schemaType = trim((string) $seo('seo_schema_org_type', 'ProfessionalService')) ?: 'ProfessionalService';
    $schemaLogo = $seoUrl($seo('seo_schema_org_logo')) ?: asset('image/logo.png');
    $schemaPhone = trim((string) ($seo('seo_schema_phone') ?: ($settings['phone'] ?? '')));
    $schemaEmail = trim((string) ($seo('seo_schema_email') ?: ($settings['email'] ?? '')));
    $schemaAddress = trim((string) ($seo('seo_schema_address') ?: ($settings['address'] ?? '')));
    $schemaCity = trim((string) $seo('seo_schema_city'));
    $schemaRegion = trim((string) $seo('seo_schema_region'));
    $schemaPostal = trim((string) $seo('seo_schema_postal_code'));
    $schemaCountry = trim((string) ($seo('seo_schema_country') ?: 'EG'));
    $schemaLat = trim((string) $seo('seo_schema_lat'));
    $schemaLng = trim((string) $seo('seo_schema_lng'));
    $sameAs = collect(preg_split('/\r\n|\r|\n/', (string) $seo('seo_schema_same_as')))
        ->map(fn ($line) => trim($line))
        ->filter()
        ->values()
        ->all();

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => $schemaType,
        'name' => $schemaName,
        'url' => $canonical,
        'logo' => $schemaLogo,
        'image' => $ogImage,
        'description' => $metaDescription,
    ];

    if ($focusKeyword !== '') {
        $schema['keywords'] = $focusKeyword;
    }
    if ($schemaPhone !== '') {
        $schema['telephone'] = $schemaPhone;
    }
    if ($schemaEmail !== '') {
        $schema['email'] = $schemaEmail;
    }
    if ($schemaAddress !== '' || $schemaCity !== '') {
        $schema['address'] = array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $schemaAddress ?: null,
            'addressLocality' => $schemaCity ?: null,
            'addressRegion' => $schemaRegion ?: null,
            'postalCode' => $schemaPostal ?: null,
            'addressCountry' => $schemaCountry ?: null,
        ]);
    }
    if ($schemaLat !== '' && $schemaLng !== '') {
        $schema['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => $schemaLat,
            'longitude' => $schemaLng,
        ];
    }
    if ($sameAs !== []) {
        $schema['sameAs'] = $sameAs;
    }

    $gtagIds = collect([$googleTagId, $gaId, $googleAdsId])
        ->map(fn ($id) => trim((string) $id))
        ->filter()
        ->unique()
        ->values()
        ->all();

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
<meta name="googlebot" content="{{ $robots }}">
<meta name="theme-color" content="{{ $themeColor }}">
<link rel="canonical" href="{{ $canonical }}">

@if ($hreflangAr !== '')
    <link rel="alternate" hreflang="ar" href="{{ $hreflangAr }}">
@endif
@if ($hreflangEn !== '')
    <link rel="alternate" hreflang="en" href="{{ $hreflangEn }}">
@endif
@if ($hreflangDefault !== '')
    <link rel="alternate" hreflang="x-default" href="{{ $hreflangDefault }}">
@endif

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
@if ($yandexVerification !== '')
    <meta name="yandex-verification" content="{{ $yandexVerification }}">
@endif
@if ($facebookDomainVerification !== '')
    <meta name="facebook-domain-verification" content="{{ $facebookDomainVerification }}">
@endif

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@if ($gtmId !== '')
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
@endif

@if (count($gtagIds) > 0)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtagIds[0] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        @foreach ($gtagIds as $tagId)
            gtag('config', '{{ $tagId }}');
        @endforeach
    </script>
@endif

@if ($facebookPixelId !== '')
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $facebookPixelId }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id={{ $facebookPixelId }}&ev=PageView&noscript=1"
             alt="">
    </noscript>
@endif

@if ($customHead !== '')
    {!! $customHead !!}
@endif
