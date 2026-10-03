@extends('layouts.app')
@section('title', 'Report submitted')
@section('content')
<section class="section-pad narrow">
    <div class="confirmation-panel"><span class="eyebrow">Student support</span><h1 class="display">Your report has been submitted.</h1><p>A designated member of the school support team will review it privately.</p><p>Keep this reference number to check the status of your report. The tracking page only shows the status and submission date, never investigation details.</p><div class="reference-code" aria-label="Report reference number">{{ $reference }}</div><div class="form-actions"><a class="button" href="{{ route('concerns.track.form') }}">Track a report <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a><a class="text-link" href="{{ route('home') }}">Return to Avenridge</a></div></div>
</section>
@endsection