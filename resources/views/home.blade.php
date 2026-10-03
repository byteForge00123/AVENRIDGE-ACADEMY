@extends('layouts.app')

@section('title', 'A school for curious minds')

@section('content')
<section class="hero">
    <div class="hero-grid">
        <div class="hero-copy rise-in">
            <span class="eyebrow">A thoughtful place to grow</span>
            <h1 class="display">Where curiosity becomes confidence.</h1>
            <p>A welcoming academic community where students are encouraged to learn, discover, and grow.</p>
            <div class="hero-actions">
                <a class="button" href="{{ route('about') }}">Explore Avenridge <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                <a class="button button-light" href="{{ route('admissions') }}">Admissions</a>
            </div>
            <div class="hero-note"><i class="icon" data-lucide="leaf" aria-hidden="true"></i><span>Independent learning, from early years through grade 12</span></div>
        </div>
        <div class="hero-photo">
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&q=88" alt="Students and a teacher learning together in a bright classroom">
            <div class="photo-caption"><i class="icon" data-lucide="sparkles" aria-hidden="true"></i><span><strong>Learn by wondering</strong>Small classes. Big questions.</span></div>
        </div>
    </div>
</section>

<div class="stat-strip" aria-label="Avenridge at a glance">
    <div class="stat"><strong>1987</strong><span>Rooted in Northfield</span></div>
    <div class="stat"><strong>4:1</strong><span>Student-centered learning</span></div>
    <div class="stat"><strong>Pre-K–12</strong><span>One connected community</span></div>
</div>

<section class="section-pad wrap intro-grid">
    <div class="intro-photo"><img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1100&q=85" alt="A teacher listens as students work together at a classroom table" loading="lazy"></div>
    <div class="intro-copy">
        <span class="eyebrow">A school with room to become</span>
        <h2 class="display">Good learning starts with being known.</h2>
        <p>At Avenridge, students are met as individuals. Teachers notice what makes each learner lean in, then help them build the knowledge and confidence to go further.</p>
        <p>It is a place to take your work seriously, make a few mistakes along the way, and find people who are glad you are here.</p>
        <a class="text-link" href="{{ route('about') }}">Get to know our school <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a>
        <div class="values-line"><span>Curiosity</span><span>Care</span><span>Courage</span><span>Contribution</span></div>
    </div>
</section>

<section class="section-pad" style="background:#fff">
    <div class="wrap">
        <div class="section-heading">
            <div><span class="eyebrow">Learning at Avenridge</span><h2 class="display">A path for every stage.</h2></div>
            <p>Strong foundations, thoughtful challenge, and the freedom to follow a question further.</p>
        </div>
        <div class="program-grid">
            @forelse ($programs as $program)
                <article class="program-item">
                    <small>{{ $program->level }}</small>
                    <h3>{{ $program->name }}</h3>
                    <p>{{ $program->summary }}</p>
                    <a class="text-link" href="{{ route('programs') }}">Explore the program <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a>
                </article>
            @empty
                <p class="empty-state">Program information is being prepared.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="wrap section-pad">
    <div class="campus-band">
        <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=1300&q=85" alt="Students learning in a sunlit academic space" loading="lazy">
        <div class="campus-band-copy">
            <span class="eyebrow">A campus made for possibility</span>
            <h2 class="display">Space to focus.<br>Room to roam.</h2>
            <p>From the library's quiet reading corners to the field science lab, our campus makes space for both concentration and connection.</p>
            <a class="button" href="{{ route('campus') }}">Walk the campus <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section class="section-pad wrap">
    <div class="section-heading">
        <div><span class="eyebrow">Around Avenridge</span><h2 class="display">Notes from our community.</h2></div>
        <a class="text-link" href="{{ route('news.index') }}">All news & events <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a>
    </div>
    <div class="story-grid">
        @forelse ($featuredNews as $article)
            <article class="story">
                <small>{{ $article->category }} · {{ $article->published_at->format('M j, Y') }}</small>
                <h3>{{ $article->title }}</h3>
                <p>{{ $article->excerpt }}</p>
                <a class="text-link" href="{{ route('news.show', $article->slug) }}">Read the story <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a>
            </article>
        @empty
            <p class="empty-state">School news will appear here soon.</p>
        @endforelse
    </div>
    @if ($events->isNotEmpty())
        <div class="two-col" style="margin-top:46px">
            <div><span class="eyebrow">Save a date</span><h2 class="display" style="font-size:30px">Coming up at school</h2></div>
            <div class="event-list">
                @foreach ($events as $event)
                    <article class="event-item"><div class="event-date">{{ $event->starts_at->format('M j') }}</div><div><h3>{{ $event->title }}</h3><p>{{ $event->venue }} · {{ $event->starts_at->format('g:i a') }}</p></div></article>
                @endforeach
            </div>
        </div>
    @endif
</section>

<section class="wrap section-pad" style="padding-top:0">
    <div class="community-band">
        <div><span class="eyebrow">Student life</span><h2 class="display">A community that listens.</h2><p>Share an idea, ask a question, or help someone feel a little less alone. Student posts are anonymous by default and reviewed before they appear.</p></div>
        <div class="community-actions"><a class="button" href="{{ route('community.index') }}">Visit the community <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a><a class="button button-light" href="{{ route('concerns.create') }}">Report a concern</a></div>
    </div>
</section>

<section class="wrap cta-line">
    <h2 class="display">A good next step starts with a conversation.</h2>
    <a class="button button-coral" href="{{ route('admissions') }}">Begin an inquiry <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
</section>
@endsection