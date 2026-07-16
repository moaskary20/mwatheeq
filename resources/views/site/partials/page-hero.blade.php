<section class="page-hero">
    <div class="page-hero-bg" aria-hidden="true"></div>
    <div class="site-container relative z-10 py-20 sm:py-24">
        <nav class="reveal text-sm font-bold text-white/70" aria-label="مسار الصفحة">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a class="hover:text-white" href="{{ route('home') }}">الرئيسية</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-white">{{ $current }}</li>
            </ol>
        </nav>
        <p class="reveal mt-6 text-sm font-extrabold tracking-[0.16em] text-white/75">{{ $eyebrow }}</p>
        <h1 class="reveal mt-3 max-w-3xl text-4xl font-extrabold leading-[1.2] text-white sm:text-5xl lg:text-6xl">
            {{ $title }}
        </h1>
        @if (! empty($lead))
            <p class="reveal mt-5 max-w-2xl text-base leading-8 text-white/85 sm:text-lg">
                {{ $lead }}
            </p>
        @endif
    </div>
</section>
