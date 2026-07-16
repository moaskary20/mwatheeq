<section id="contact" class="contact-section section-atmosphere section-contact-bg section-pad">
    <span class="section-ribbon section-ribbon-top" aria-hidden="true"></span>
    <span class="orbit orbit-a" aria-hidden="true"></span>
    <span class="orbit orbit-c" aria-hidden="true"></span>

    <div class="site-container">
        @if ($showHeading ?? true)
            <div class="reveal text-center heading-stack mx-auto max-w-3xl">
                <span class="heading-watermark left-1/2 -translate-x-1/2" aria-hidden="true">تواصل</span>
                <p class="section-eyebrow mx-auto justify-center">تواصل معنا</p>
                <h2 class="section-title section-title-center">اتصل بنا</h2>
                <p class="section-lead mx-auto">
                    يسعدنا تواصلكم معنا، أرسل استفسارك أو زر مقرنا في الإسكندرية.
                </p>
            </div>
        @endif

        <div class="contact-shell {{ ($showHeading ?? true) ? 'mt-12' : '' }}">
            <div class="grid lg:grid-cols-2 lg:min-h-[620px]">
                <div class="contact-form-panel relative space-y-7 p-6 sm:p-8 lg:p-10">
                    <div class="reveal contact-hero-row">
                        <div class="contact-thumb">
                            <img src="{{ asset('image/sections/contact.jpg') }}" alt="بيئة مكتبية للتواصل" loading="lazy">
                        </div>
                        <div>
                            <p class="text-sm font-extrabold tracking-wide text-brand">نحن هنا لخدمتكم</p>
                            <p class="mt-2 text-sm leading-7 text-brand/70">
                                فريق المواثيق جاهز للرد على استفساراتكم ومتابعة معاملاتكم الحكومية بسرعة واحترافية.
                            </p>
                        </div>
                    </div>

                    <div class="reveal contact-info-grid" style="transition-delay: 60ms">
                        @if ($settings['address'])
                            <div class="contact-info-card">
                                <span class="contact-info-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="contact-info-label">العنوان</p>
                                    <p class="contact-info-value">{{ $settings['address'] }}</p>
                                    @if (! empty($settings['address_en']))
                                        <p class="contact-info-muted" dir="ltr">{{ $settings['address_en'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($settings['phone'])
                            <a class="contact-info-card contact-info-card--link" href="tel:{{ preg_replace('/\s+/', '', $settings['phone']) }}">
                                <span class="contact-info-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.426c-2.734-.873-4.91-3.049-5.783-5.783a1.125 1.125 0 0 1 .426-1.21l1.293-.97a1.125 1.125 0 0 0 .417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="contact-info-label">الهاتف</p>
                                    <p class="contact-info-value" dir="ltr">{{ $settings['phone'] }}</p>
                                </div>
                            </a>
                        @endif

                        @if ($settings['email'])
                            <a class="contact-info-card contact-info-card--link" href="mailto:{{ $settings['email'] }}">
                                <span class="contact-info-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="contact-info-label">البريد</p>
                                    <p class="contact-info-value">{{ $settings['email'] }}</p>
                                </div>
                            </a>
                        @endif
                    </div>

                    @php
                        $facebookUrl = $settings['facebook_url'] ?? '';
                        $instagramUrl = $settings['instagram_url'] ?? '';
                        $whatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp'] ?? '');
                        if ($whatsappNumber && str_starts_with($whatsappNumber, '0')) {
                            $whatsappNumber = '20'.substr($whatsappNumber, 1);
                        }
                        $whatsappUrl = $whatsappNumber ? 'https://wa.me/'.$whatsappNumber : '';
                        $hasSocial = $facebookUrl || $instagramUrl || $whatsappUrl;
                    @endphp

                    @if ($hasSocial)
                        <div class="reveal social-links" style="transition-delay: 80ms">
                            <p class="social-links-label">تابعنا على منصات التواصل</p>
                            <div class="social-links-row">
                                @if ($facebookUrl)
                                    <a class="social-btn social-btn--facebook" href="{{ $facebookUrl }}" target="_blank" rel="noopener" aria-label="فيسبوك">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path d="M13.5 22v-8.2h2.76l.41-3.2H13.5V8.55c0-.93.26-1.56 1.59-1.56H16.8V4.14C16.4 4.1 15.1 4 13.64 4 10.58 4 8.5 5.87 8.5 9.15v2.45H5.9v3.2h2.6V22h5Z"/>
                                        </svg>
                                        <span>فيسبوك</span>
                                    </a>
                                @endif

                                @if ($instagramUrl)
                                    <a class="social-btn social-btn--instagram" href="{{ $instagramUrl }}" target="_blank" rel="noopener" aria-label="إنستجرام">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path d="M12 7.2A4.8 4.8 0 1 0 12 16.8 4.8 4.8 0 0 0 12 7.2Zm0 7.92a3.12 3.12 0 1 1 0-6.24 3.12 3.12 0 0 1 0 6.24Zm6.14-8.12a1.12 1.12 0 1 1-2.24 0 1.12 1.12 0 0 1 2.24 0ZM12 3c-2.45 0-2.76.01-3.72.05a5.57 5.57 0 0 0-3.84 1.4 5.57 5.57 0 0 0-1.4 3.84C3.01 9.24 3 9.55 3 12s.01 2.76.05 3.72a5.57 5.57 0 0 0 1.4 3.84 5.57 5.57 0 0 0 3.84 1.4c.96.04 1.27.05 3.72.05s2.76-.01 3.72-.05a5.57 5.57 0 0 0 3.84-1.4 5.57 5.57 0 0 0 1.4-3.84c.04-.96.05-1.27.05-3.72s-.01-2.76-.05-3.72a5.57 5.57 0 0 0-1.4-3.84 5.57 5.57 0 0 0-3.84-1.4C14.76 3.01 14.45 3 12 3Zm0 1.62c2.4 0 2.69.01 3.63.05.88.04 1.36.19 1.68.31.42.16.72.36 1.04.68.32.32.52.62.68 1.04.12.32.27.8.31 1.68.04.94.05 1.23.05 3.63s-.01 2.69-.05 3.63a4.52 4.52 0 0 1-.31 1.68 2.79 2.79 0 0 1-.68 1.04 2.79 2.79 0 0 1-1.04.68c-.32.12-.8.27-1.68.31-.94.04-1.23.05-3.63.05s-2.69-.01-3.63-.05a4.52 4.52 0 0 1-1.68-.31 2.79 2.79 0 0 1-1.04-.68 2.79 2.79 0 0 1-.68-1.04 4.52 4.52 0 0 1-.31-1.68c-.04-.94-.05-1.23-.05-3.63s.01-2.69.05-3.63c.04-.88.19-1.36.31-1.68.16-.42.36-.72.68-1.04.32-.32.62-.52 1.04-.68.32-.12.8-.27 1.68-.31.94-.04 1.23-.05 3.63-.05Z"/>
                                        </svg>
                                        <span>إنستجرام</span>
                                    </a>
                                @endif

                                @if ($whatsappUrl)
                                    <a class="social-btn social-btn--whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="واتساب">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path d="M20.5 3.5A11.9 11.9 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.14 1.6 5.94L0 24l6.33-1.66a11.86 11.86 0 0 0 5.7 1.45h.01c6.55 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.44-8.39ZM12.04 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.76.99 1-3.66-.24-.38a9.86 9.86 0 0 1-1.51-5.26C2.13 6.45 6.57 2 12.05 2a9.86 9.86 0 0 1 9.89 9.9c0 5.47-4.45 9.9-9.9 9.9Zm5.43-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.64.08-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.04-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35Z"/>
                                        </svg>
                                        <span>واتساب</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="rounded-xl border border-brand/30 bg-fog px-4 py-3 text-sm font-bold text-brand">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="reveal contact-form" style="transition-delay: 100ms">
                        @csrf
                        <div class="contact-form-head">
                            <h3>أرسل رسالة</h3>
                            <p>املأ النموذج وسنعود إليك في أقرب وقت.</p>
                        </div>

                        <div>
                            <label for="name" class="field-label">الاسم</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="field" placeholder="اسمك الكامل">
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="email" class="field-label">البريد الإلكتروني</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field" placeholder="name@example.com" dir="ltr">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="field-label">الجوال</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="field" placeholder="01xxxxxxxx" dir="ltr">
                                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="field-label">الموضوع</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" class="field" placeholder="موضوع الرسالة">
                            @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="message" class="field-label">الرسالة</label>
                            <textarea id="message" name="message" rows="5" required class="field field-textarea" placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn-primary contact-submit">
                            <span>إرسال الرسالة</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="map-panel relative min-h-[420px] bg-brand lg:min-h-full">
                    <iframe
                        title="خريطة موقع المواثيق"
                        src="{{ $mapEmbedUrl }}"
                        class="absolute inset-0 h-full w-full border-0"
                        loading="eager"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        allow="fullscreen; geolocation"
                    ></iframe>
                    <div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-white/10"></div>
                    <div class="map-overlay-top">
                        <span class="map-pin-dot" aria-hidden="true"></span>
                        <span>مقر المواثيق — كفر عبدو، الإسكندرية</span>
                    </div>
                    <div class="map-overlay-bottom">
                        <a href="{{ $mapSearchUrl }}" target="_blank" rel="noopener">
                            فتح الموقع في خرائط جوجل
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
