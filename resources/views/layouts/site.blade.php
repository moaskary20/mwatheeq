<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="{{ $settings['hero_subtitle'] ?? 'المواثيق للخدمات الحكومية — شريككم الموثوق في الإجراءات الحكومية' }}">
    <title>@yield('title', 'مواثيق')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans">
    <header
        data-site-header
        class="site-header fixed inset-x-0 top-0 z-50 border-b border-brand/10 bg-white/85 shadow-[0_8px_30px_rgba(49,84,173,0.08)] backdrop-blur-md"
    >
        <div class="site-container flex h-16 items-center justify-between sm:h-[4.75rem]">
            <a href="{{ route('home') }}" class="group flex shrink-0 items-center" aria-label="مواثيق — العودة للرئيسية">
                <img
                    src="{{ asset('image/logo.png') }}"
                    alt="المواثيق للخدمات الحكومية"
                    class="h-11 w-auto object-contain transition duration-300 group-hover:scale-[1.03] sm:h-14"
                    width="200"
                    height="56"
                >
            </a>

            <nav class="hidden items-center gap-7 lg:gap-8 md:flex" aria-label="التنقل الرئيسي">
                <a class="nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">الرئيسية</a>
                <a class="nav-link {{ request()->routeIs('services') ? 'is-active' : '' }}" href="{{ route('services') }}">خدماتنا</a>
                <a class="nav-link {{ request()->routeIs('about') ? 'is-active' : '' }}" href="{{ route('about') }}">من نحن</a>
                <a class="nav-link {{ request()->routeIs('blog.*') ? 'is-active' : '' }}" href="{{ route('blog.index') }}">المدونة</a>
                <a class="nav-link" href="{{ route('home') }}#clients">عملاؤنا</a>
                <a class="nav-link {{ request()->routeIs('contact') ? 'is-active' : '' }}" href="{{ route('contact') }}">تواصل معنا</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <span class="hidden text-xs font-bold text-brand/70 lg:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="btn-outline !py-2.5 !px-4 !text-xs">خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex btn-outline !py-2.5 !px-4 !text-xs">دخول</a>
                    <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-flex !py-2.5 !px-5 !text-xs">تسجيل</a>
                @endauth
                <a href="{{ route('contact') }}" class="btn-primary hidden md:inline-flex !py-2.5 !px-5 !text-xs">اطلب استشارة</a>
                <button
                    type="button"
                    data-menu-toggle
                    class="menu-toggle inline-flex h-10 w-10 items-center justify-center rounded-xl border border-brand/15 bg-fog text-brand md:hidden"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    aria-label="فتح القائمة"
                >
                    <svg data-menu-icon-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg data-menu-icon-close xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <div class="mobile-drawer-overlay md:hidden" data-mobile-overlay hidden aria-hidden="true"></div>

    <aside
        id="mobile-menu"
        data-mobile-menu
        class="mobile-drawer md:hidden"
        aria-hidden="true"
        aria-label="قائمة التنقل"
    >
        <div class="mobile-drawer-head">
            <img src="{{ asset('image/logo.png') }}" alt="مواثيق" class="h-10 w-auto object-contain">
            <button type="button" class="mobile-drawer-close" data-menu-close aria-label="إغلاق القائمة">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="mobile-drawer-nav" aria-label="القائمة الجوال">
            <a href="{{ route('home') }}">الرئيسية</a>
            <a href="{{ route('services') }}">خدماتنا</a>
            <a href="{{ route('about') }}">من نحن</a>
            <a href="{{ route('blog.index') }}">المدونة</a>
            <a href="{{ route('home') }}#clients">عملاؤنا</a>
            <a href="{{ route('contact') }}">تواصل معنا</a>
            @auth
                <a href="{{ route('blog.index') }}">مرحباً، {{ auth()->user()->name }}</a>
            @else
                <a href="{{ route('login') }}">تسجيل الدخول</a>
                <a href="{{ route('register') }}">إنشاء حساب</a>
            @endauth
        </nav>

        <div class="mobile-drawer-foot">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-outline w-full justify-center">تسجيل الخروج</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn-primary w-full justify-center">إنشاء حساب</a>
            @endauth
            <a href="{{ route('contact') }}" class="btn-outline mt-3 w-full justify-center">اطلب استشارة</a>
        </div>
    </aside>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer text-white">
        <div class="site-container relative z-10 py-14 sm:py-16">
            <div class="footer-main">
                <div class="footer-brand">
                    <img src="{{ asset('image/logo.png') }}" alt="مواثيق" class="footer-logo">
                    <p class="footer-text">
                        {{ $settings['footer_text'] ?? '' }}
                    </p>
                </div>

                <nav class="footer-nav" aria-label="روابط الفوتر">
                    <a href="{{ route('services') }}">خدماتنا</a>
                    <a href="{{ route('about') }}">من نحن</a>
                    <a href="{{ route('blog.index') }}">المدونة</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                </nav>
            </div>

            <div class="footer-bottom">
                <p class="footer-copy">
                    &copy; {{ date('Y') }} المواثيق للخدمات الحكومية — جميع الحقوق محفوظة.
                </p>
                <p class="footer-credit">
                    <span class="footer-credit-label">تم التصميم بواسطة</span>
                    <span class="footer-credit-brand">Caesar Agency</span>
                </p>
            </div>
        </div>
    </footer>

    @php
        $floatWhatsapp = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '01272269000');
        if (str_starts_with($floatWhatsapp, '0')) {
            $floatWhatsapp = '20'.substr($floatWhatsapp, 1);
        }
        if ($floatWhatsapp && ! str_starts_with($floatWhatsapp, '20')) {
            $floatWhatsapp = '20'.$floatWhatsapp;
        }
    @endphp

    @if ($floatWhatsapp)
        <a
            href="https://wa.me/{{ $floatWhatsapp }}"
            class="whatsapp-float"
            target="_blank"
            rel="noopener"
            aria-label="تواصل عبر واتساب على 01272269000"
            title="واتساب: 01272269000"
        >
            <span class="whatsapp-float-pulse" aria-hidden="true"></span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="whatsapp-float-icon" aria-hidden="true">
                <path d="M20.5 3.5A11.9 11.9 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.14 1.6 5.94L0 24l6.33-1.66a11.86 11.86 0 0 0 5.7 1.45h.01c6.55 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.44-8.39ZM12.04 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.76.99 1-3.66-.24-.38a9.86 9.86 0 0 1-1.51-5.26C2.13 6.45 6.57 2 12.05 2a9.86 9.86 0 0 1 9.89 9.9c0 5.47-4.45 9.9-9.9 9.9Zm5.43-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.64.08-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.04-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35Z"/>
            </svg>
            <span class="whatsapp-float-label">واتساب</span>
        </a>
    @endif
</body>
</html>
