@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">We would like to hear from you</span><h1 class="display">Start a conversation.</h1><p>Questions about visiting, applying, or school life? The office will help you find the right person.</p></div></section>
<section class="section-pad wrap two-col">
    <div>
        <span class="eyebrow">The school office</span><h2 class="display" style="font-size:34px;margin:8px 0 24px">Come by or get in touch.</h2>
        <div class="event-list">
            <article class="event-item"><i class="icon" data-lucide="map-pin" aria-hidden="true"></i><div><h3>Visit us</h3><p>{{ config('avenridge.address') }}</p><a class="text-link" style="margin-top:8px" target="_blank" rel="noopener" href="https://maps.google.com/?q={{ urlencode(config('avenridge.address')) }}">Open directions <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
            <article class="event-item"><i class="icon" data-lucide="phone" aria-hidden="true"></i><div><h3>Call the office</h3><p>{{ config('avenridge.phone') }}</p></div></article>
            <article class="event-item"><i class="icon" data-lucide="mail" aria-hidden="true"></i><div><h3>Send a note</h3><p>{{ config('avenridge.contact_email') }}</p></div></article>
            <article class="event-item"><i class="icon" data-lucide="calendar-days" aria-hidden="true"></i><div><h3>Office hours</h3><p>{{ config('avenridge.office_hours') }}</p></div></article>
        </div>
        <div class="map-placeholder"><i class="icon" data-lucide="map-pin" aria-hidden="true"></i><span>Northfield, Massachusetts</span></div>
    </div>
    <div class="form-surface">
        <span class="eyebrow">Write to us</span><h2 class="display" style="font-size:30px;margin:8px 0 22px">How can we help?</h2>
        <form method="POST" action="{{ route('contact.send') }}">@csrf
            <div class="form-grid">
                <div class="field"><label for="name">Your name</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required></div>
                <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required></div>
                <div class="field field-full"><label for="subject">Subject</label><input id="subject" name="subject" value="{{ old('subject') }}" required></div>
                <div class="field field-full"><label for="message">Message</label><textarea id="message" name="message" minlength="10" maxlength="5000" required>{{ old('message') }}</textarea></div>
            </div>
            <div class="form-actions"><button class="button" type="submit">Send message <i class="icon-sm" data-lucide="send" aria-hidden="true"></i></button><span class="form-note">Your message goes to the school office.</span></div>
        </form>
    </div>
</section>
@endsection