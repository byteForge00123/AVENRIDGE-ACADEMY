@extends('layouts.app')
@section('title', 'Track a report')
@section('content')
<section class="page-hero"><div class="narrow"><span class="eyebrow">Private follow-up</span><h1 class="display">Track a report.</h1><p>Enter the reference number you received after submitting your concern.</p></div></section>
<section class="section-pad narrow">
    <form class="form-surface" method="POST" action="{{ route('concerns.track') }}">@csrf
        <div class="field"><label for="reference_code">Report reference number</label><input id="reference_code" name="reference_code" value="{{ old('reference_code', $result['reference_code'] ?? '') }}" placeholder="RPT-2026-00421" pattern="RPT-[0-9]{4}-[0-9]{5}" autocomplete="off" required></div>
        <div class="form-actions"><button class="button" type="submit">Check status <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></button></div>
    </form>
    @if (isset($result))
        @php($steps = ['submitted' => 'Submitted', 'under_review' => 'Under Review', 'action_in_progress' => 'Action in Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'])
        @php($stepKeys = array_keys($steps))
        <section class="track-result" aria-live="polite" style="margin-top:24px">
            <div class="status-line"><span class="status-dot" aria-hidden="true"></span><div><strong>{{ $steps[$result['status']] ?? 'Submitted' }}</strong><div class="form-note">Current status for {{ $result['reference_code'] }}</div></div></div>
            <div class="status-track" aria-label="Report progress">
                @foreach ($steps as $key => $label)
                    <div class="status-step {{ array_search($result['status'], $stepKeys, true) >= array_search($key, $stepKeys, true) ? 'active' : '' }}">{{ $label }}</div>
                @endforeach
            </div>
            <p class="form-note" style="margin-top:16px">Submitted {{ $result['submitted_at']->format('F j, Y') }}. For privacy, investigation notes and personal details are not shown here.</p>
        </section>
    @endif
</section>
@endsection