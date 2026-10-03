@extends('layouts.app')
@section('title', 'News and events')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">The Avenridge journal</span><h1 class="display">What we are learning, making, and celebrating.</h1><p>News from campus, upcoming gatherings, and good work worth sharing.</p></div></section>
<section class="section-pad wrap">
    <div class="admin-tools" style="align-items:end"><div><span class="eyebrow">Latest stories</span><h2 class="display" style="font-size:32px;margin:7px 0">From around the school</h2></div>
        <form action="{{ route('news.index') }}" method="GET" class="search-filter"><label class="sr-only" for="news-search">Search news</label><input id="news-search" name="q" type="search" value="{{ request('q') }}" placeholder="Search stories"><label class="sr-only" for="news-category">Filter by category</label><select name="category" id="news-category"><option value="">All categories</option>@foreach ($categories as $category)<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>@endforeach</select><button class="button button-small" type="submit"><i class="icon-sm" data-lucide="search" aria-hidden="true"></i><span>Search</span></button></form>
    </div>
    <div class="directory-grid">
        @forelse ($articles as $article)
            <article class="directory-item"><img class="news-image" src="{{ $article->image_url ?: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80' }}" alt="Students learning at Avenridge" loading="lazy"><span class="eyebrow">{{ $article->category }} · {{ $article->published_at->format('M j, Y') }}</span><h2><a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ $article->excerpt }}</p><a class="text-link" href="{{ route('news.show', $article->slug) }}">Read story <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a></article>
        @empty
            <p class="empty-state">No stories match that search yet.</p>
        @endforelse
    </div>
    <div class="pagination">{{ $articles->links('pagination::simple-tailwind') }}</div>
</section>
<section class="section-pad" style="background:#fff"><div class="wrap two-col"><div><span class="eyebrow">Save a date</span><h2 class="display" style="font-size:34px;margin:8px 0">Upcoming events</h2><p class="muted">There is always something worth gathering for.</p></div><div class="event-list">@forelse ($events as $event)<article class="event-item"><div class="event-date">{{ $event->starts_at->format('M j') }}</div><div><h3>{{ $event->title }}</h3><p>{{ $event->category }} · {{ $event->venue }} · {{ $event->starts_at->format('g:i a') }}</p></div></article>@empty<p class="empty-state">New dates will be posted here.</p>@endforelse</div></div></section>
@endsection