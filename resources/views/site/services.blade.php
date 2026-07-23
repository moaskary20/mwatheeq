@extends('layouts.site')

@section('title', __('site.nav.services').' — '.__('site.brand_short'))

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => __('site.services.eyebrow'),
        'title' => __('site.services.title'),
        'current' => __('site.nav.services'),
        'lead' => __('site.services.lead'),
    ])

    <section class="section-atmosphere section-services-bg relative section-pad overflow-hidden">
        <span class="orbit orbit-b" aria-hidden="true"></span>
        <span class="orbit orbit-c" aria-hidden="true"></span>
        <div class="site-container relative">
            <div class="reveal flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="heading-stack">
                    <span class="heading-watermark" aria-hidden="true">{{ is_arabic() ? 'خدمات' : 'Services' }}</span>
                    <p class="section-eyebrow">{{ __('site.services.eyebrow') }}</p>
                    <h2 class="section-title">{{ __('site.services.page_title') }}</h2>
                    <p class="section-lead">
                        {{ __('site.services.page_lead') }}
                    </p>
                </div>
                <a href="{{ route('contact') }}" class="btn-service shrink-0 self-start">{{ __('site.cta.request_service') }}</a>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($services as $index => $service)
                    <article class="reveal-scale service-card" style="transition-delay: {{ $index * 90 }}ms">
                        <div class="service-card-media">
                            @if ($service->image_url)
                                <img src="{{ $service->image_url }}" alt="{{ locale_text('site.services.items.'.$service->slug.'.title', $service->title) }}" loading="lazy">
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

            <div class="reveal mt-14 rounded-[1.75rem] bg-gradient-to-br from-brand via-brand-soft to-brand-deep p-8 text-center text-white shadow-[0_24px_60px_rgba(49,84,173,0.28)] sm:p-12">
                <h3 class="text-2xl font-extrabold sm:text-3xl">{{ __('site.services.cta_title') }}</h3>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-8 text-white/85">
                    {{ __('site.services.cta_lead') }}
                </p>
                <a href="{{ route('contact') }}" class="btn-primary mt-8 bg-white text-brand hover:bg-fog">{{ __('site.cta.contact_now') }}</a>
            </div>
        </div>
    </section>
@endsection
