@extends('layouts.app')
@section('title', 'Campus')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">A place to learn and belong</span><h1 class="display">A campus that invites you in.</h1><p>Our Northfield campus brings classrooms, gathering places, and the outdoors close enough to make a school day feel connected.</p></div></section>
<section class="section-pad wrap">
    <div class="intro-grid">
        <div class="intro-photo"><img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=1100&q=85" alt="Sunlight fills a welcoming school learning space" loading="lazy"></div>
        <div class="intro-copy"><span class="eyebrow">Around the grounds</span><h2 class="display">Made for both focus and friendship.</h2><p>Students move between places to concentrate and places to connect. The campus is intentionally easy to navigate, with room to pause, make, read, and play.</p><p>Visitors are welcome by appointment. Our admissions team can help plan a first visit.</p><a class="text-link" href="{{ route('contact') }}">Plan a visit <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a></div>
    </div>
</section>
<section class="section-pad" style="background:#fff"><div class="wrap"><div class="section-heading"><div><span class="eyebrow">Places to learn</span><h2 class="display">A few favorite corners.</h2></div><p>Thoughtful spaces make it easier to settle in, try something new, and spend time together.</p></div><div class="directory-grid">
    @foreach ($facilities as $facility)
        <article class="directory-item"><span class="eyebrow">{{ $facility->category }}</span><h2>{{ $facility->name }}</h2><p>{{ $facility->description }}</p></article>
    @endforeach
</div></div></section>
<section class="section-pad wrap"><div class="section-heading"><div><span class="eyebrow">Scenes from the day</span><h2 class="display">A little of life here.</h2></div></div><div class="directory-grid">
    @foreach ($gallery as $item)
        <figure class="directory-item" style="margin:0"><img src="{{ $item->image_url }}" alt="{{ $item->caption }}" loading="lazy"><figcaption><span class="eyebrow">{{ $item->category }}</span><h2>{{ $item->caption }}</h2></figcaption></figure>
    @endforeach
</div></section>
@endsection