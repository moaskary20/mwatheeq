@extends('layouts.site')

@section('title', 'تواصل معنا — مواثيق')

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => 'نحن بانتظارك',
        'title' => 'تواصل معنا',
        'current' => 'تواصل معنا',
        'lead' => 'يسعدنا تواصلكم معنا، أرسل استفسارك أو زر مقرنا في الإسكندرية.',
    ])

    @include('site.partials.contact-section', ['showHeading' => false])
@endsection
