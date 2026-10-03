@extends('layouts.app')
@section('title', $article->title)
@section('content')
<section class="page-hero"><div class="narrow"><a class="text-link" href="{{ route('news.index') }}"><i class="icon-sm" data-lucide="arrow-right" style="transform:rotate(180deg)" aria-hidden="true"></i> Back to news</a><p class="eyebrow" style="margin-top:26px">{{ $article->category }} · {{ $article->published_at->format('F j, Y') }}</p><h1 class="display">{{ $article->title }}</h1><p>{{ $article->excerpt }}</p></div></section>
<article class="narrow section-pad prose"><img class="news-image" src="{{ $article->image_url ?: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=85' }}" alt="Students learning at Avenridge" loading="lazy"><p style="white-space:pre-line">{{ $article->body }}</p></article>
@endsection