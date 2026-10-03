@extends('layouts.app')
@section('title', 'Create a student account')
@section('content')
<section class="section-pad narrow">
    <div class="auth-heading"><span class="eyebrow">Avenridge community</span><h1 class="display">Make yourself at home.</h1><p class="muted">Create a student account to join the community. Your account details are never shown on anonymous posts.</p></div>
    <form class="form-surface" method="POST" action="{{ route('register.store') }}">@csrf
        <div class="field"><label for="name">Your name</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="120" required></div>
        <div class="field" style="margin-top:18px"><label for="email">School email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required></div>
        <div class="field" style="margin-top:18px"><label for="password">Create a password</label><input id="password" name="password" type="password" autocomplete="new-password" minlength="10" required><small>Use at least 10 characters.</small></div>
        <div class="field" style="margin-top:18px"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required></div>
        <div class="form-actions"><button class="button" type="submit">Create account <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></button><a class="text-link" href="{{ route('login') }}">I already have an account</a></div>
    </form>
</section>
@endsection