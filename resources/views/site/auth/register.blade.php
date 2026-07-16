@extends('layouts.site')

@section('title', 'إنشاء حساب — مواثيق')

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => 'انضم إلينا',
        'title' => 'إنشاء حساب',
        'current' => 'التسجيل',
        'lead' => 'أنشئ حساباً لتتمكن من إضافة ردود على مواضيع المدونة.',
    ])

    <section class="section-atmosphere relative section-pad overflow-hidden">
        <div class="site-container relative">
            <div class="auth-panel reveal">
                <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                    @csrf
                    <h2 class="auth-form-title">حساب جديد</h2>
                    <p class="auth-form-lead">املأ البيانات التالية لإنشاء حسابك.</p>

                    <div class="mt-6">
                        <label for="name" class="field-label">الاسم</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="field" placeholder="اسمك الكامل" autocomplete="name">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="email" class="field-label">البريد الإلكتروني</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field" placeholder="email@example.com" dir="ltr" autocomplete="email">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="field-label">كلمة المرور</label>
                        <input id="password" name="password" type="password" required class="field" placeholder="••••••••" dir="ltr" autocomplete="new-password">
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="field-label">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="field" placeholder="••••••••" dir="ltr" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn-primary mt-6 w-full justify-center">إنشاء الحساب</button>

                    <p class="auth-switch">
                        لديك حساب بالفعل؟
                        <a href="{{ route('login') }}">تسجيل الدخول</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection
