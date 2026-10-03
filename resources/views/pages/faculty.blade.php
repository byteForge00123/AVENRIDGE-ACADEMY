@extends('layouts.app')
@section('title', 'Faculty and staff')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">The people of Avenridge</span><h1 class="display">Teachers who know their subject. And their students.</h1><p>Our faculty bring deep knowledge, generous attention, and a belief that good questions are worth following.</p></div></section>
<section class="section-pad wrap">
    <div class="directory-grid">
        @forelse ($faculty as $person)
            <article class="directory-item"><div class="person-avatar" aria-hidden="true">{{ collect(explode(' ', $person->name))->map(fn ($part) => mb_substr($part, 0, 1))->join('') }}</div><span class="eyebrow">{{ $person->department }}</span><h2>{{ $person->name }}</h2><strong style="font-size:12px;color:var(--pine)">{{ $person->position }}</strong><p>{{ $person->biography }}</p></article>
        @empty
            <p class="empty-state">Faculty profiles are being prepared.</p>
        @endforelse
    </div>
</section>
<section class="wrap cta-line"><h2 class="display">Have a question for our team?</h2><a class="button" href="{{ route('contact') }}">Get in touch <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a></section>
@endsection