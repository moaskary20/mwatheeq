@extends('layouts.site')

@section('title', $post->title.' — مواثيق')

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => 'المدونة',
        'title' => $post->title,
        'current' => 'المدونة',
        'lead' => $post->excerpt,
    ])

    <section class="section-atmosphere relative section-pad overflow-hidden">
        <div class="site-container relative">
            <div class="blog-show-layout">
                <article class="reveal blog-article">
                    @if ($post->image_url)
                        <div class="blog-article-cover">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="blog-article-meta">
                        @if ($post->published_at)
                            <time datetime="{{ $post->published_at->toDateString() }}">
                                {{ $post->published_at->translatedFormat('d F Y') }}
                            </time>
                        @endif
                        <span>{{ $comments->count() }} رد</span>
                    </div>

                    <div class="blog-article-body">
                        {!! $post->body !!}
                    </div>

                    <div class="blog-article-back">
                        <a href="{{ route('blog.index') }}" class="btn-outline">العودة للمدونة</a>
                    </div>
                </article>

                <aside class="blog-aside">
                    @if ($related->isNotEmpty())
                        <div class="reveal blog-aside-card">
                            <h3 class="blog-aside-title">مواضيع ذات صلة</h3>
                            <ul class="blog-related-list">
                                @foreach ($related as $item)
                                    <li>
                                        <a href="{{ route('blog.show', $item) }}">
                                            <span>{{ $item->title }}</span>
                                            @if ($item->published_at)
                                                <small>{{ $item->published_at->translatedFormat('d M Y') }}</small>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="reveal blog-aside-card" style="transition-delay: 80ms">
                        <h3 class="blog-aside-title">تحتاج مساعدة؟</h3>
                        <p class="blog-aside-text">فريق المواثيق جاهز لمساعدتك في إجراءاتك الحكومية.</p>
                        <a href="{{ route('contact') }}" class="btn-primary mt-4 w-full justify-center">تواصل معنا</a>
                    </div>
                </aside>
            </div>

            <div id="comments" class="reveal blog-comments">
                <div class="blog-comments-head">
                    <h2>الردود</h2>
                    <span>{{ $comments->count() }}</span>
                </div>

                @if (session('success'))
                    <div class="blog-alert blog-alert--success" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="blog-comments-list">
                    @forelse ($comments as $comment)
                        <div class="blog-comment">
                            <div class="blog-comment-avatar" aria-hidden="true">{{ mb_substr($comment->name, 0, 1) }}</div>
                            <div>
                                <div class="blog-comment-meta">
                                    <strong>{{ $comment->name }}</strong>
                                    <time datetime="{{ $comment->created_at->toDateString() }}">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </time>
                                </div>
                                <p class="blog-comment-body">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="blog-comments-empty">لا توجد ردود بعد — كن أول من يعلّق.</p>
                    @endforelse
                </div>

                @auth
                    <form action="{{ route('blog.comment', $post) }}" method="POST" class="blog-comment-form">
                        @csrf
                        <h3>أضف ردّاً</h3>
                        <p class="blog-comment-form-hint">
                            تردّ باسم <strong>{{ auth()->user()->name }}</strong> — يظهر الرد بعد مراجعة الإدارة.
                        </p>

                        <div>
                            <label for="comment_body" class="field-label">الرد</label>
                            <textarea id="comment_body" name="body" rows="4" required class="field field-textarea" placeholder="اكتب ردّك هنا...">{{ old('body') }}</textarea>
                            @error('body') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary mt-5">إرسال الرد</button>
                    </form>
                @else
                    <div class="blog-comment-login">
                        <h3>سجّل دخولك للمشاركة</h3>
                        <p>الردود متاحة فقط للأعضاء المسجّلين. أنشئ حساباً أو سجّل دخولك أولاً.</p>
                        <div class="blog-comment-login-actions">
                            <a href="{{ route('login') }}" class="btn-primary">تسجيل الدخول</a>
                            <a href="{{ route('register') }}" class="btn-outline">إنشاء حساب</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </section>
@endsection
