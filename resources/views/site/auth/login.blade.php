@extends('layouts.site')

@section('title', 'تسجيل الدخول — مواثيق')

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => 'حسابك',
        'title' => 'تسجيل الدخول',
        'current' => 'تسجيل الدخول',
        'lead' => 'سجّل دخولك للمشاركة بالردود على مواضيع المدونة.',
    ])

    <section class="section-atmosphere relative section-pad overflow-hidden">
        <div class="site-container relative">
            <div class="auth-panel reveal">
                <form action="{{ route('login.store') }}" method="POST" class="auth-form">
                    @csrf
                    <h2 class="auth-form-title">مرحباً بعودتك</h2>
                    <p class="auth-form-lead">أدخل بياناتك للمتابعة.</p>

                    <div class="mt-6">
                        <label for="email" class="field-label">البريد الإلكتروني</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="field" placeholder="email@example.com" dir="ltr" autocomplete="email">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="field-label">كلمة المرور</label>
                        <input id="password" name="password" type="password" required class="field" placeholder="••••••••" dir="ltr" autocomplete="current-password">
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <label class="auth-remember">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                        <span>تذكرني</span>
                    </label>

                    <button type="submit" class="btn-primary mt-6 w-full justify-center">تسجيل الدخول</button>

                    <p class="auth-switch">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}">إنشاء حساب جديد</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection
