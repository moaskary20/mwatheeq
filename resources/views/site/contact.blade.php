@extends('layouts.site')

@section('title', __('site.nav.contact').' — '.__('site.brand_short'))

@section('content')
    @include('site.partials.page-hero', [
        'eyebrow' => __('site.contact.eyebrow'),
        'title' => __('site.contact.title'),
        'current' => __('site.nav.contact'),
        'lead' => __('site.contact.lead'),
    ])

    @include('site.partials.contact-section', ['showHeading' => false])
@endsection
