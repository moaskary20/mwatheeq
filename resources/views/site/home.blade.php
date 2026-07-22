@extends('layouts.site')

@section('title', 'مواثيق — الخدمات الحكومية')

@section('content')
    {{-- 1. Hero Slider --}}
    <section class="hero-slider relative overflow-hidden bg-brand-deep" data-hero-slider aria-roledescription="carousel" aria-label="سلايدر الصفحة الرئيسية">
        <div class="hero-frame" aria-hidden="true"></div>
        <div class="hero-stage relative w-full">
            @forelse ($slides as $index => $slide)
                <div
                    class="hero-slide absolute inset-0 {{ $index === 0 ? 'is-active' : '' }}"
                    data-slide
                    aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                >
                    <div class="hero-media">
                        <img
                            src="{{ $slide->image_url }}"
                            alt="{{ $slide->title ?: 'شريحة '.($index + 1) }}"
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
                                    المواثيق للخدمات الحكومية
                                </div>
                                <span class="hero-index" dir="ltr">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) $slides->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            @if ($slide->title)
                                <h1 class="hero-title">{{ $slide->title }}</h1>
                            @endif
                            @if ($slide->subtitle)
                                <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-actions">
                                @if ($slide->button_text && $slide->button_url)
                                    <a href="{{ $slide->button_url }}" class="btn-primary bg-white text-brand hover:bg-fog">
                                        {{ $slide->button_text }}
                                    </a>
                                @endif
                                <a href="{{ route('services') }}" class="btn-ghost">استعرض خدماتنا</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex h-full items-center justify-center bg-brand text-white">
                    <p>أضف صوراً من لوحة التحكم في قسم سلايدر الصور.</p>
                </div>
            @endforelse
        </div>

        @if ($slides->count() > 1)
            <button type="button" class="hero-nav hero-nav-prev" data-slider-prev aria-label="الشريحة السابقة">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <button type="button" class="hero-nav hero-nav-next" data-slider-next aria-label="الشريحة التالية">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <div class="hero-controls">
                <div class="hero-dots" data-slider-dots>
                    @foreach ($slides as $index => $slide)
                        <button
                            type="button"
                            class="hero-dot {{ $index === 0 ? 'is-active' : '' }}"
                            data-slider-dot="{{ $index }}"
                            aria-label="عرض الشريحة {{ $index + 1 }}"
                        >
                            <span class="hero-dot-progress" aria-hidden="true"></span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="#intro" class="hero-scroll-cue" aria-label="الانتقال للقسم التالي">
            <span aria-hidden="true"></span>
            تصفح
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
                        <p class="section-eyebrow">تعرف علينا</p>
                        <h2 class="section-title">شريككم الموثوق لإنجاز معاملات الجهات الحكومية</h2>
                    </div>

                    <div class="mt-6 space-y-5 text-base leading-9 text-brand/80 sm:text-lg sm:leading-9">
                        <p>
                            نوفر حلولًا متكاملة لإنجاز جميع المعاملات والإجراءات الحكومية بكفاءة واحترافية، من خلال فريق متخصص يمتلك خبرة واسعة في التعامل مع مختلف الجهات الحكومية، بما في ذلك الشهر العقاري، ودواوين المحافظات، والأحياء، وهيئة المساحة المصرية، وغيرها من الجهات ذات الصلة.
                        </p>
                        <p>
                            نتولى تنفيذ جميع الإجراءات اللازمة لتسجيل الأراضي والعقارات، واستخراج التراخيص، وإنهاء معاملات تأسيس الشركات وتعديلها، مع الالتزام الكامل بالأنظمة واللوائح القانونية المعمول بها.
                        </p>
                        <p>
                            نعمل على تبسيط الإجراءات وتسريع دورة العمل، بما يضمن توفير الوقت والجهد، وتحقيق أعلى مستويات الدقة والموثوقية في إنجاز معاملاتكم.
                        </p>
                        <p class="font-bold text-brand">
                            خبرتنا... تضمن لكم إنجازًا أسرع، وإجراءات أكثر سلاسة، وخدمة احترافية يمكنكم الاعتماد عليه.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-2.5">
                        @foreach (['الشهر العقاري', 'ديوان المحافظات', 'ديوان الأحياء', 'الدفاع المدني', 'تراخيص الشركات'] as $tag)
                            <span class="intro-chip">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <div class="trust-strip reveal" style="transition-delay: 140ms">
                        <div class="trust-item">
                            <strong>خبرة</strong>
                            <span>متخصصون حكوميون</span>
                        </div>
                        <div class="trust-item">
                            <strong>سرعة</strong>
                            <span>إنجاز في أقصر وقت</span>
                        </div>
                        <div class="trust-item">
                            <strong>التزام</strong>
                            <span>إطار قانوني واضح</span>
                        </div>
                    </div>

                    <div class="intro-actions">
                        <a href="{{ route('services') }}" class="btn-primary">استعرض خدماتنا</a>
                        <a href="{{ route('contact') }}" class="btn-outline">تواصل معنا</a>
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
                            <p class="text-xs font-bold text-white/70">نهج قانوني متكامل</p>
                            <p class="mt-0.5 text-sm font-extrabold text-white">دقة · سرعة · التزام</p>
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
                    <p class="section-eyebrow">خدماتنا</p>
                    <h2 class="section-title">الخدمات الحكومية</h2>
                    <p class="section-lead">
                        حلول متكاملة تسهّل إجراءاتكم الحكومية بكفاءة ووضوح واحترافية عالية.
                    </p>
                </div>
                <a href="{{ route('contact') }}" class="btn-service shrink-0 self-start">اطلب خدمة الآن</a>
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
                                <h3 class="text-2xl font-extrabold">{{ $service->title }}</h3>
                                <p class="mt-3 text-sm leading-7 text-white/85">{{ $service->summary }}</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-brand/60">لا توجد خدمات منشورة حالياً.</p>
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
                            <p class="section-eyebrow">رؤيتنا العملية</p>
                            <div class="goal-accent-bars" aria-hidden="true">
                                <span></span><span></span><span></span><span></span>
                            </div>
                        </div>
                        <h2 class="section-title">أهدافنا</h2>
                        <p class="section-lead">
                            {{ $settings['goals_subtitle'] ?? 'نحن ملتزمون بتحقيق أهدافنا من خلال فريق عمل محترف وملتزم.' }}
                        </p>
                    </div>

                    <div class="goals-grid mt-11">
                        @forelse ($goals as $index => $goal)
                            <article class="reveal goal-card goal-card--{{ ($index % 4) + 1 }}" style="transition-delay: {{ $index * 100 }}ms">
                                <div class="goal-card-top">
                                    <span class="goal-number" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="goal-badge">
                                        <span class="goal-check" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <h3>{{ $goal->title }}</h3>
                                    </div>
                                </div>
                                <p class="goal-card-text">{{ $goal->summary }}</p>
                                <span class="goal-card-glow" aria-hidden="true"></span>
                            </article>
                        @empty
                            <p class="text-brand/60">لا توجد أهداف منشورة حالياً.</p>
                        @endforelse
                    </div>

                    <div class="reveal mt-10" style="transition-delay: 220ms">
                        <a href="{{ route('contact') }}" class="btn-primary">ابدأ تحقيق هدفك معنا</a>
                    </div>
                </div>

                <div class="reveal-left relative flex justify-center lg:justify-end" style="transition-delay: 140ms">
                    <div class="goals-visual">
                        <span class="goals-ring goals-ring--outer" aria-hidden="true"></span>
                        <span class="goals-ring goals-ring--inner" aria-hidden="true"></span>
                        <span class="goals-accent-block" aria-hidden="true"></span>

                        <div class="photo-blob photo-blob-lg goals-photo">
                            <img src="{{ asset('image/goals/team.jpg') }}" alt="فريق عمل محترف" loading="lazy">
                        </div>

                        <div class="goals-float-card">
                            <span class="goals-float-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.902-6.074-2.456A12.317 12.317 0 0 1 3.75 11.75"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 12.75a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-white/70">فريق متخصص</p>
                                <p class="mt-0.5 text-sm font-extrabold text-white">خبرة حكومية موثوقة</p>
                            </div>
                        </div>

                        <div class="goals-stat-chip">
                            <strong>{{ $goals->count() ?: 4 }}+</strong>
                            <span>أهداف استراتيجية</span>
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
                    <p class="reveal text-sm font-bold tracking-[0.2em] text-white/75">تميّزنا</p>
                    <h2 class="reveal mt-3 text-4xl font-extrabold leading-snug sm:text-5xl lg:text-[3.4rem]">
                        لماذا تختارنا؟
                    </h2>
                    <p class="reveal mt-4 max-w-md text-base leading-8 text-white/85">
                        نجمع بين الخبرة الميدانية والدقة الإدارية لنقدّم تجربة سلسة ونتائج موثوقة.
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
                            <p class="text-xs text-white/70">الموقع</p>
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
                    <img src="{{ asset('image/logo.png') }}" alt="المواثيق للخدمات الحكومية" class="h-14 w-auto object-contain sm:h-16">
                </div>

                <div class="goal-accent-bars mb-7" aria-hidden="true">
                    <span></span><span></span><span></span><span></span>
                </div>

                <ul class="relative z-10 space-y-4">
                    @forelse ($whyPoints as $index => $point)
                        <li class="reveal why-point" style="transition-delay: {{ $index * 70 }}ms">
                            <span class="why-point-dot" aria-hidden="true"></span>
                            <span class="text-base font-bold leading-8 text-brand sm:text-lg">{{ $point->title }}</span>
                        </li>
                    @empty
                        <li class="text-brand/60">أضف نقاط التميز من لوحة التحكم.</li>
                    @endforelse
                </ul>

                <div class="reveal relative z-10 mt-10">
                    <a href="{{ route('contact') }}" class="btn-primary">تواصل معنا الآن</a>
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
                    <p class="section-eyebrow">{{ $settings['about_title'] ?: 'من نحن' }}</p>
                    <h2 class="section-title">شريك موثوق في الخدمات الحكومية</h2>
                </div>
                <p class="section-lead">{{ $settings['about_body'] }}</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="brand-panel">
                        <h3 class="relative z-10 text-sm font-bold text-white/80">رؤيتنا</h3>
                        <p class="relative z-10 mt-3 text-base leading-8 text-white/95">{{ $settings['vision'] }}</p>
                    </div>
                    <div class="mission-panel">
                        <h3 class="text-sm font-extrabold text-brand">رسالتنا</h3>
                        <p class="mt-3 text-base leading-8 text-brand/80">{{ $settings['mission'] }}</p>
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
                <p class="section-eyebrow mx-auto justify-center">ثقة المصانع والشركات</p>
                <h2 class="section-title section-title-center">عملاؤنا</h2>
                <p class="section-lead mx-auto">
                    نفتخر بشراكتنا مع مجموعة من المصانع والشركات الرائدة، ونقدّم لهم حلولًا حكومية موثوقة تسرّع الإنجاز وتحفظ الجودة.
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
                    <span>مصنع وشركة</span>
                </div>
                <div class="clients-trust-item">
                    <strong>قطاعات متعددة</strong>
                    <span>تجارة · إنشاء · بنوك</span>
                </div>
                <div class="clients-trust-item">
                    <strong>شراكة مستمرة</strong>
                    <span>متابعة وإنجاز حكومي</span>
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
                    <p class="section-eyebrow">شبكة تعامل حكومي</p>
                    <h2 class="section-title">الجهات المتعامل معها</h2>
                    <p class="section-lead">
                        خريطة الجهات والهيئات التي نتعامل معها يوميًا لإنجاز معاملاتكم بمسار واضح وموثوق.
                    </p>
                </div>
                <div class="partners-intro-seal" aria-hidden="true">
                    <span class="partners-intro-seal-ring"></span>
                    <strong>{{ count($partners) }}</strong>
                    <small>جهة وهيئة</small>
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
                                <span class="partner-node-label">جهة معتمدة</span>
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
