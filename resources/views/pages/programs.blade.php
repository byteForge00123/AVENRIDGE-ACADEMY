@extends('layouts.app')
@section('title', 'Academic programs')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">Learning at Avenridge</span><h1 class="display">Strong foundations. Open horizons.</h1><p>Each program is shaped for the stage students are in now, with teachers who help them take the next step with care.</p></div></section>
<section class="section-pad wrap">
    @forelse ($programs as $program)
        <article class="program-detail">
            <div><span class="eyebrow">{{ $program->level }}</span><h2 class="display" style="font-size:29px;margin:8px 0">{{ $program->name }}</h2></div>
            <div><p style="max-width:690px;color:var(--muted);margin-top:0">{{ $program->description }}</p><p style="font-size:12px;color:var(--pine);font-weight:700">Key areas of study</p><div style="display:flex;flex-wrap:wrap;gap:9px">@foreach ($program->subjects ?? [] as $subject)<span class="tag">{{ $subject }}</span>@endforeach</div></div>
        </article>
    @empty
        <p class="empty-state">Program details are being prepared.</p>
    @endforelse
</section>
<section class="wrap cta-line"><h2 class="display">Not sure where to begin?</h2><a class="button" href="{{ route('contact') }}">Talk with admissions</a></section>
@endsection