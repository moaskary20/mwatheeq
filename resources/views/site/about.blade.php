@extends('layouts.site')

@section('title', __('site.nav.about').' — '.__('site.brand_short'))

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => __('site.intro.eyebrow'),
        'title' => __('site.home_extra.about_block_title'),
        'current' => __('site.nav.about'),
        'lead' => is_arabic()
            ? ($settings['about_body'] ?: __('site.home_extra.about_block_lead'))
            : __('site.home_extra.about_block_lead'),
    ])

    {{-- Intro --}}
    <section class="intro-section section-atmosphere section-intro-bg relative overflow-hidden section-pad">
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
                </div>
                <div class="reveal-left relative" style="transition-delay: 120ms">
                    <div class="intro-photo-accent" aria-hidden="true"></div>
                    <div class="photo-frame aspect-[4/5] sm:aspect-[5/6]">
                        <img src="{{ asset('image/sections/intro.jpg') }}" alt="بيئة عمل احترافية في المواثيق" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About vision/mission --}}
    <section id="about" class="section-atmosphere section-about-bg section-pad">
        <span class="orbit orbit-a" aria-hidden="true"></span>
        <div class="site-container grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="reveal order-2 lg:order-1">
                <div class="heading-stack">
                    <span class="heading-watermark" aria-hidden="true">نحن</span>
                    <p class="section-eyebrow">{{ locale_text('site.home_extra.about_title', $settings['about_title'] ?: null) }}</p>
                    <h2 class="section-title">{{ __('site.about_page.vision_title') }}</h2>
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

    {{-- Goals --}}
    <section id="goals" class="goals-section section-atmosphere section-goals-bg relative overflow-hidden section-pad">
        <span class="orbit orbit-a" aria-hidden="true"></span>
        <div class="goals-dots" aria-hidden="true"></div>
        <div class="site-container relative z-10">
            <div class="grid items-center gap-14 lg:grid-cols-[1.08fr_0.92fr] lg:gap-20">
                <div>
                    <div class="reveal heading-stack">
                        <span class="heading-watermark" aria-hidden="true">أهداف</span>
                        <div class="flex items-center gap-3">
                            <p class="section-eyebrow">{{ __('site.goals.eyebrow') }}</p>
                            <div class="goal-accent-bars" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
                        </div>
                        <h2 class="section-title">{{ __('site.goals.title') }}</h2>
                        <p class="section-lead">{{ locale_text('site.goals.subtitle', $settings['goals_subtitle'] ?? null) }}</p>
                    </div>
                    <div class="goals-grid mt-11">
                        @forelse ($goals as $index => $goal)
                            @php $goalKey = $goal->sort_order ?: ($index + 1); @endphp
                            <article class="reveal goal-card goal-card--{{ ($index % 4) + 1 }}" style="transition-delay: {{ $index * 100 }}ms">
                                <div class="goal-card-top">
                                    <span class="goal-number" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="goal-badge">
                                        <span class="goal-check" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>
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
                </div>
                <div class="reveal-left relative flex justify-center lg:justify-end" style="transition-delay: 140ms">
                    <div class="goals-visual">
                        <span class="goals-ring goals-ring--outer" aria-hidden="true"></span>
                        <span class="goals-ring goals-ring--inner" aria-hidden="true"></span>
                        <span class="goals-accent-block" aria-hidden="true"></span>
                        <div class="photo-blob photo-blob-lg goals-photo">
                            <img src="{{ asset('image/goals/team.jpg') }}" alt="{{ __('site.goals.team_alt') }}" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why --}}
    <section id="why" class="why-section overflow-hidden">
        <div class="grid lg:min-h-[680px] lg:grid-cols-2">
            <div class="why-panel-brand relative flex flex-col justify-between overflow-hidden px-6 py-14 text-white sm:px-10 sm:py-16 lg:px-14 lg:py-20">
                <div class="why-panel-glow" aria-hidden="true"></div>
                <div class="relative z-10">
                    <p class="reveal text-sm font-bold tracking-[0.2em] text-white/75">{{ __('site.why.eyebrow') }}</p>
                    <h2 class="reveal mt-3 text-4xl font-extrabold leading-snug sm:text-5xl">{{ __('site.why.title') }}</h2>
                    <p class="reveal mt-4 max-w-md text-base leading-8 text-white/85">{{ __('site.why.lead') }}</p>
                </div>
                <div class="reveal relative z-10 mt-10" style="transition-delay: 100ms">
                    <div class="why-photo-frame">
                        <img src="{{ asset('image/why/team-why.jpg') }}" alt="{{ __('site.goals.team_alt') }}" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="why-panel-light relative flex flex-col justify-center px-6 py-14 sm:px-10 sm:py-16 lg:px-16 lg:py-20">
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
@endsection
