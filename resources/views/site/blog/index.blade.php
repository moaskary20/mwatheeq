@extends('layouts.site')

@section('title', 'المدونة — مواثيق')

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => 'معرفة ومقالات',
        'title' => 'المدونة',
        'current' => 'المدونة',
        'lead' => 'مقالات ونصائح حول الخدمات الحكومية، التسجيل العقاري، والتراخيص.',
    ])

    <section class="section-atmosphere section-services-bg relative section-pad overflow-hidden">
        <span class="orbit orbit-b" aria-hidden="true"></span>
        <div class="site-container relative">
            <div class="blog-grid">
                @forelse ($posts as $index => $post)
                    <article class="reveal blog-card" style="transition-delay: {{ ($index % 3) * 80 }}ms">
                        <a href="{{ route('blog.show', $post) }}" class="blog-card-media">
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                            @else
                                <div class="blog-card-placeholder" aria-hidden="true"></div>
                            @endif
                        </a>
                        <div class="blog-card-body">
                            @if ($post->published_at)
                                <time class="blog-card-date" datetime="{{ $post->published_at->toDateString() }}">
                                    {{ $post->published_at->translatedFormat('d F Y') }}
                                </time>
                            @endif
                            <h2 class="blog-card-title">
                                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                            </h2>
                            @if ($post->excerpt)
                                <p class="blog-card-excerpt">{{ $post->excerpt }}</p>
                            @endif
                            <a href="{{ route('blog.show', $post) }}" class="blog-card-link">
                                اقرأ المزيد
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full text-center text-brand/60">لا توجد مواضيع منشورة حالياً.</p>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
