@extends('layouts.site')

@section('title', __('site.brand_short').' — '.__('site.nav.services'))

@section('content')
    {{-- 1. Hero Slider --}}
    <section class="hero-slider relative overflow-hidden bg-brand-deep" data-hero-slider aria-roledescription="carousel" aria-label="{{ __('site.hero.aria') }}">
        <div class="hero-frame" aria-hidden="true"></div>
        <div class="hero-stage relative w-full">
            @forelse ($slides as $index => $slide)
                @php
                    $slideKey = $slide->sort_order ?: ($index + 1);
                    $slideTitle = locale_text('site.hero.slides.'.$slideKey.'.title', $slide->title);
                    $slideSubtitle = locale_text('site.hero.slides.'.$slideKey.'.subtitle', $slide->subtitle);
                    $slideButton = locale_text('site.hero.slides.'.$slideKey.'.button', $slide->button_text);
                @endphp
                <div
                    class="hero-slide absolute inset-0 {{ $index === 0 ? 'is-active' : '' }}"
                    data-slide
                    aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                >
                    <div class="hero-media">
                        <img
                            src="{{ $slide->image_url }}"
                            alt="{{ $slideTitle ?: __('site.brand') }}"
                            class="h-full w-full object-cover"
                            @if ($index === 0) fetchpriority="high" @else loading="lazy" @endif
                        >
                    </div>
                    <div class="hero-veil"></div>
                    <div class="hero-veil-bottom"></div>

                    <div class="site-container absolute inset-x-0 bottom-0 top-0 flex flex-col justify-end">
                        <div class="hero-content max-w-3xl text-white">
                            <div class="hero-meta">
                                <div class="hero-badge">
                                    <span class="hero-badge-dot" aria-hidden="true"></span>
                                    {{ __('site.hero.badge') }}
                                </div>
                                <span class="hero-index" dir="ltr">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) $slides->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            @if ($slideTitle)
                                <h1 class="hero-title">{{ $slideTitle }}</h1>
                            @endif
                            @if ($slideSubtitle)
                                <p class="hero-subtitle">{{ $slideSubtitle }}</p>
                            @endif
                            <div class="hero-actions">
                                @if ($slideButton && $slide->button_url)
                                    <a href="{{ $slide->button_url }}" class="btn-primary bg-white text-brand hover:bg-fog">
                                        {{ $slideButton }}
                                    </a>
                                @endif
                                <a href="{{ route('services') }}" class="btn-ghost">{{ __('site.cta.view_services') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex h-full items-center justify-center bg-brand text-white">
                    <p>{{ __('site.hero.empty') }}</p>
                </div>
            @endforelse
        </div>

        @if ($slides->count() > 1)
            <button type="button" class="hero-nav hero-nav-prev" data-slider-prev aria-label="{{ __('site.hero.prev') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <button type="button" class="hero-nav hero-nav-next" data-slider-next aria-label="{{ __('site.hero.next') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <div class="hero-controls">
                <div class="hero-dots" data-slider-dots>
                    @foreach ($slides as $index => $slide)
                        <button
                            type="button"
                            class="hero-dot {{ $index === 0 ? 'is-active' : '' }}"
                            data-slider-dot="{{ $index }}"
                            aria-label="{{ __('site.hero.show', ['num' => $index + 1]) }}"
                        >
                            <span class="hero-dot-progress" aria-hidden="true"></span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="#intro" class="hero-scroll-cue" aria-label="{{ __('site.hero.browse') }}">
            <span aria-hidden="true"></span>
            {{ __('site.hero.browse') }}
        </a>
    </section>

    {{-- 2. Company Intro --}}
    <section id="intro" class="intro-section section-atmosphere section-intro-bg relative overflow-hidden section-pad">
        <span class="section-ribbon section-ribbon-top" aria-hidden="true"></span>
        <span class="orbit orbit-a" aria-hidden="true"></span>
        <span class="orbit orbit-b" aria-hidden="true"></span>

        <div class="site-container relative">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <div class="reveal soft-panel lg:bg-transparent lg:p-0 lg:shadow-none lg:backdrop-blur-none lg:border-0">
                    <div class="heading-stack">
                        <span class="heading-watermark" aria-hidden="true">مواثيق</span>
                        <p class="section-eyebrow">{{ __('site.intro.eyebrow') }}</p>
                        <h2 class="section-title">{{ __('site.intro.title') }}</h2>
                    </div>

                    <div class="mt-6 space-y-5 text-base leading-9 text-brand/80 sm:text-lg sm:leading-9">
                        <p>{{ __('site.intro.p1') }}</p>
                        <p>{{ __('site.intro.p2') }}</p>
                        <p>{{ __('site.intro.p3') }}</p>
                        <p class="font-bold text-brand">{{ __('site.intro.p4') }}</p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-2.5">
                        @foreach (__('site.intro.tags') as $tag)
                            <span class="intro-chip">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <div class="trust-strip reveal" style="transition-delay: 140ms">
                        <div class="trust-item">
                            <strong>{{ __('site.intro.trust_exp') }}</strong>
                            <span>{{ __('site.intro.trust_exp_sub') }}</span>
                        </div>
                        <div class="trust-item">
                            <strong>{{ __('site.intro.trust_speed') }}</strong>
                            <span>{{ __('site.intro.trust_speed_sub') }}</span>
                        </div>
                        <div class="trust-item">
                            <strong>{{ __('site.intro.trust_commit') }}</strong>
                            <span>{{ __('site.intro.trust_commit_sub') }}</span>
                        </div>
                    </div>

                    <div class="intro-actions">
                        <a href="{{ route('services') }}" class="btn-primary">{{ __('site.cta.view_services') }}</a>
                        <a href="{{ route('contact') }}" class="btn-outline">{{ __('site.cta.contact_us') }}</a>
                    </div>
                </div>

                <div class="reveal-left relative" style="transition-delay: 120ms">
                    <div class="intro-photo-accent" aria-hidden="true"></div>
                    <div class="photo-frame aspect-[4/5] sm:aspect-[5/6]">
                        <img
                            src="{{ asset('image/sections/intro.jpg') }}"
                            alt="بيئة عمل احترافية في المواثيق للخدمات الحكومية"
                            loading="lazy"
                        >
                    </div>
                    <div class="intro-float-card reveal" style="transition-delay: 280ms">
                        <span class="intro-float-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-white/70">{{ __('site.intro.float_label') }}</p>
                            <p class="mt-0.5 text-sm font-extrabold text-white">{{ __('site.intro.float_value') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="section-ribbon section-ribbon-bottom" aria-hidden="true"></span>
    </section>

    {{-- 3. Services --}}
    <section id="services" class="section-atmosphere section-services-bg relative section-pad overflow-hidden">
        <span class="orbit orbit-b" aria-hidden="true"></span>
        <span class="orbit orbit-c" aria-hidden="true"></span>
        <div class="site-container relative">
            <div class="reveal flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="heading-stack">
                    <span class="heading-watermark" aria-hidden="true">خدمات</span>
                    <p class="section-eyebrow">{{ __('site.services.eyebrow') }}</p>
                    <h2 class="section-title">{{ __('site.services.title') }}</h2>
                    <p class="section-lead">
                        {{ __('site.services.lead') }}
                    </p>
                </div>
                <a href="{{ route('contact') }}" class="btn-service shrink-0 self-start">{{ __('site.cta.request_service') }}</a>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($services as $index => $service)
                    <article class="reveal-scale service-card" style="transition-delay: {{ $index * 90 }}ms">
                        <div class="service-card-media">
                            @if ($service->image_url)
                                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" loading="lazy">
                            @else
                                <div class="h-full w-full bg-brand-soft"></div>
                            @endif
                            <div class="service-card-overlay"></div>
                            <div class="service-card-body">
                                <h3 class="text-2xl font-extrabold">{{ locale_text('site.services.items.'.$service->slug.'.title', $service->title) }}</h3>
                                <p class="mt-3 text-sm leading-7 text-white/85">{{ locale_text('site.services.items.'.$service->slug.'.summary', $service->summary) }}</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-brand/60">{{ __('site.services.empty') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. Goals --}}
    <section id="goals" class="goals-section section-atmosphere section-goals-bg relative overflow-hidden section-pad">
        <span class="section-ribbon section-ribbon-top" aria-hidden="true"></span>
        <span class="orbit orbit-a" aria-hidden="true"></span>
        <span class="orbit orbit-b" aria-hidden="true"></span>
        <div class="goals-dots" aria-hidden="true"></div>

        <div class="site-container relative z-10">
            <div class="grid items-center gap-14 lg:grid-cols-[1.08fr_0.92fr] lg:gap-20">
                <div>
                    <div class="reveal heading-stack">
                        <span class="heading-watermark" aria-hidden="true">أهداف</span>
                        <div class="flex items-center gap-3">
                            <p class="section-eyebrow">{{ __('site.goals.eyebrow') }}</p>
                            <div class="goal-accent-bars" aria-hidden="true">
                                <span></span><span></span><span></span><span></span>
                            </div>
                        </div>
                        <h2 class="section-title">{{ __('site.goals.title') }}</h2>
                        <p class="section-lead">
                            {{ locale_text('site.goals.subtitle', $settings['goals_subtitle'] ?? null) }}
                        </p>
                    </div>

                    <div class="goals-grid mt-11">
                        @forelse ($goals as $index => $goal)
                            @php $goalKey = $goal->sort_order ?: ($index + 1); @endphp
                            <article class="reveal goal-card goal-card--{{ ($index % 4) + 1 }}" style="transition-delay: {{ $index * 100 }}ms">
                                <div class="goal-card-top">
                                    <span class="goal-number" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="goal-badge">
                                        <span class="goal-check" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <h3>{{ locale_text('site.goals.items.'.$goalKey.'.title', $goal->title) }}</h3>
                                    </div>
                                </div>
                                <p class="goal-card-text">{{ locale_text('site.goals.items.'.$goalKey.'.summary', $goal->summary) }}</p>
                                <span class="goal-card-glow" aria-hidden="true"></span>
                            </article>
                        @empty
                            <p class="text-brand/60">{{ __('site.goals.empty') }}</p>
                        @endforelse
                    </div>

                    <div class="reveal mt-10" style="transition-delay: 220ms">
                        <a href="{{ route('contact') }}" class="btn-primary">{{ __('site.cta.start_goal') }}</a>
                    </div>
                </div>

                <div class="reveal-left relative flex justify-center lg:justify-end" style="transition-delay: 140ms">
                    <div class="goals-visual">
                        <span class="goals-ring goals-ring--outer" aria-hidden="true"></span>
                        <span class="goals-ring goals-ring--inner" aria-hidden="true"></span>
                        <span class="goals-accent-block" aria-hidden="true"></span>

                        <div class="photo-blob photo-blob-lg goals-photo">
                            <img src="{{ asset('image/goals/team.jpg') }}" alt="{{ __('site.goals.team_alt') }}" loading="lazy">
                        </div>

                        <div class="goals-float-card">
                            <span class="goals-float-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.902-6.074-2.456A12.317 12.317 0 0 1 3.75 11.75"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 12.75a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-white/70">{{ __('site.goals.float_label') }}</p>
                                <p class="mt-0.5 text-sm font-extrabold text-white">{{ __('site.goals.float') }}</p>
                            </div>
                        </div>

                        <div class="goals-stat-chip">
                            <strong>{{ $goals->count() ?: 4 }}+</strong>
                            <span>{{ __('site.goals.stat_label') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="section-ribbon section-ribbon-bottom" aria-hidden="true"></span>
    </section>

    {{-- 5. Why Choose Us --}}
    <section id="why" class="why-section overflow-hidden">
        <div class="grid lg:min-h-[680px] lg:grid-cols-2">
            <div class="why-panel-brand relative flex flex-col justify-between overflow-hidden px-6 py-14 text-white sm:px-10 sm:py-16 lg:px-14 lg:py-20">
                <div class="why-panel-glow" aria-hidden="true"></div>

                <div class="relative z-10">
                    <p class="reveal text-sm font-bold tracking-[0.2em] text-white/75">{{ __('site.why.eyebrow') }}</p>
                    <h2 class="reveal mt-3 text-4xl font-extrabold leading-snug sm:text-5xl lg:text-[3.4rem]">
                        {{ __('site.why.title') }}
                    </h2>
                    <p class="reveal mt-4 max-w-md text-base leading-8 text-white/85">
                        {{ __('site.why.lead') }}
                    </p>
                </div>

                <div class="reveal relative z-10 mt-10" style="transition-delay: 100ms">
                    <div class="why-photo-frame">
                        <img src="{{ asset('image/why/team-why.jpg') }}" alt="فريق عمل محترف في المواثيق" loading="lazy">
                    </div>
                </div>

                <div class="reveal relative z-10 mt-10" style="transition-delay: 160ms">
                    <div class="inline-flex items-center gap-3 rounded-2xl bg-white/12 px-4 py-3 backdrop-blur-md">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.5 12h19M12 2.5c2.5 3 4 6.2 4 9.5s-1.5 6.5-4 9.5c-2.5-3-4-6.2-4-9.5s1.5-6.5 4-9.5Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs text-white/70">{{ __('site.why.location') }}</p>
                            <a href="https://{{ ltrim($settings['website_url'] ?? 'mwatheeq.com', '/') }}" class="text-base font-bold hover:underline" target="_blank" rel="noopener">
                                {{ $settings['website_url'] ?? 'mwatheeq.com' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="why-panel-light relative flex flex-col justify-center px-6 py-14 sm:px-10 sm:py-16 lg:px-16 lg:py-20">
                <span class="orbit orbit-c opacity-60" aria-hidden="true"></span>
                <div class="reveal relative z-10 mb-8 flex items-center gap-3">
                    <img src="{{ asset('image/logo.png') }}" alt="{{ __('site.brand') }}" class="h-14 w-auto object-contain sm:h-16">
                </div>

                <div class="goal-accent-bars mb-7" aria-hidden="true">
                    <span></span><span></span><span></span><span></span>
                </div>

                <ul class="relative z-10 space-y-4">
                    @forelse ($whyPoints as $index => $point)
                        @php $whyKey = $point->sort_order ?: ($index + 1); @endphp
                        <li class="reveal why-point" style="transition-delay: {{ $index * 70 }}ms">
                            <span class="why-point-dot" aria-hidden="true"></span>
                            <span class="text-base font-bold leading-8 text-brand sm:text-lg">{{ locale_text('site.why.items.'.$whyKey, $point->title) }}</span>
                        </li>
                    @empty
                        <li class="text-brand/60">{{ __('site.why.empty') }}</li>
                    @endforelse
                </ul>

                <div class="reveal relative z-10 mt-10">
                    <a href="{{ route('contact') }}" class="btn-primary">{{ __('site.cta.contact_now') }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. About --}}
    <section id="about" class="section-atmosphere section-about-bg section-pad">
        <span class="orbit orbit-a" aria-hidden="true"></span>
        <span class="orbit orbit-b" aria-hidden="true"></span>
        <div class="site-container grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="reveal order-2 lg:order-1">
                <div class="heading-stack">
                    <span class="heading-watermark" aria-hidden="true">نحن</span>
                    <p class="section-eyebrow">{{ locale_text('site.home_extra.about_title', $settings['about_title'] ?: null) }}</p>
                    <h2 class="section-title">{{ __('site.home_extra.about_block_title') }}</h2>
                </div>
                <p class="section-lead">{{ locale_text('site.home_extra.about_block_lead', $settings['about_body'] ?? null) }}</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="brand-panel">
                        <h3 class="relative z-10 text-sm font-bold text-white/80">{{ __('site.home_extra.vision') }}</h3>
                        <p class="relative z-10 mt-3 text-base leading-8 text-white/95">{{ locale_text('site.home_extra.vision_text', $settings['vision'] ?? null) }}</p>
                    </div>
                    <div class="mission-panel">
                        <h3 class="text-sm font-extrabold text-brand">{{ __('site.home_extra.mission') }}</h3>
                        <p class="mt-3 text-base leading-8 text-brand/80">{{ locale_text('site.home_extra.mission_text', $settings['mission'] ?? null) }}</p>
                    </div>
                </div>
            </div>

            <div class="reveal-left order-1 lg:order-2" style="transition-delay: 120ms">
                <div class="photo-frame aspect-[4/5] sm:aspect-[5/6]">
                    <img src="{{ asset('image/sections/about.jpg') }}" alt="بيئة عمل احترافية" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- 7. Clients --}}
    <section id="clients" class="clients-section section-atmosphere section-clients-bg section-pad">
        <span class="section-ribbon section-ribbon-top" aria-hidden="true"></span>
        <span class="orbit orbit-b" aria-hidden="true"></span>

        <div class="site-container">
            <div class="reveal text-center heading-stack mx-auto max-w-3xl">
                <span class="heading-watermark left-1/2 -translate-x-1/2" aria-hidden="true">شركاء</span>
                <p class="section-eyebrow mx-auto justify-center">{{ __('site.clients.eyebrow') }}</p>
                <h2 class="section-title section-title-center">{{ __('site.clients.title') }}</h2>
                <p class="section-lead mx-auto">
                    {{ __('site.clients.lead') }}
                </p>
            </div>
        </div>

        <div class="clients-marquee-wrap mt-12 reveal" data-clients-marquee>
            <div class="clients-fade clients-fade--start" aria-hidden="true"></div>
            <div class="clients-fade clients-fade--end" aria-hidden="true"></div>

            <div class="clients-marquee" dir="ltr">
                <div class="clients-track">
                    @foreach (array_merge($clients, $clients) as $client)
                        <article class="client-logo-card" title="{{ $client['name'] }}">
                            <img src="{{ asset($client['logo']) }}" alt="{{ $client['name'] }}" loading="lazy">
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="clients-marquee clients-marquee--reverse mt-5" dir="ltr">
                <div class="clients-track">
                    @foreach (array_merge(array_reverse($clients), array_reverse($clients)) as $client)
                        <article class="client-logo-card" title="{{ $client['name'] }}">
                            <img src="{{ asset($client['logo']) }}" alt="{{ $client['name'] }}" loading="lazy">
                        </article>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="site-container mt-12">
            <div class="reveal clients-trustbar">
                <div class="clients-trust-item">
                    <strong>{{ count($clients) }}+</strong>
                    <span>{{ __('site.clients.count_label') }}</span>
                </div>
                <div class="clients-trust-item">
                    <strong>{{ __('site.clients.sectors') }}</strong>
                    <span>{{ __('site.clients.sectors_sub') }}</span>
                </div>
                <div class="clients-trust-item">
                    <strong>{{ __('site.clients.partnership') }}</strong>
                    <span>{{ __('site.clients.partnership_sub') }}</span>
                </div>
            </div>
        </div>
        <span class="section-ribbon section-ribbon-bottom" aria-hidden="true"></span>
    </section>

    {{-- 8. Partners / Entities --}}
    <section id="partners" class="partners-section section-pad">
        <div class="partners-blueprint" aria-hidden="true"></div>

        <div class="site-container relative z-10">
            <div class="partners-intro reveal">
                <div>
                    <p class="section-eyebrow">{{ __('site.partners.eyebrow') }}</p>
                    <h2 class="section-title">{{ __('site.partners.title') }}</h2>
                    <p class="section-lead">
                        {{ __('site.partners.lead') }}
                    </p>
                </div>
                <div class="partners-intro-seal" aria-hidden="true">
                    <span class="partners-intro-seal-ring"></span>
                    <strong>{{ count($partners) }}</strong>
                    <small>{{ __('site.partners.seal') }}</small>
                </div>
            </div>

            <div class="partners-map mt-12">
                <svg class="partners-map-routes" viewBox="0 0 1000 420" preserveAspectRatio="none" aria-hidden="true">
                    <path class="partners-route" d="M60 70 C220 70, 280 140, 420 140 S680 40, 940 90"/>
                    <path class="partners-route partners-route--alt" d="M80 300 C260 240, 340 320, 520 280 S760 360, 940 300"/>
                    <path class="partners-route" d="M120 200 C300 120, 480 260, 700 180 S860 220, 960 160"/>
                </svg>

                <div class="partners-nodes">
                    @foreach ($partners as $index => $partner)
                        @php
                            $isLast = $loop->last;
                            $name = $partner['name'];
                            $icon = $partner['icon'];
                        @endphp
                        <article
                            class="reveal partner-node {{ $isLast ? 'partner-node--wide' : '' }}"
                            style="transition-delay: {{ $index * 70 }}ms"
                        >
                            <span class="partner-node-seal" aria-hidden="true">
                                @include('site.partials.partner-icon', ['icon' => $icon])
                            </span>
                            <div class="partner-node-body">
                                <span class="partner-node-label">{{ __('site.partners.label') }}</span>
                                <h3>{{ $name }}</h3>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 9. Contact --}}
    @include('site.partials.contact-section')
@endsection
