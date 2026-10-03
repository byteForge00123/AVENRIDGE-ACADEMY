@extends('layouts.app')
@section('title', 'Sign in')
@section('content')
<section class="section-pad narrow">
    <div class="auth-heading"><span class="eyebrow">Avenridge community</span><h1 class="display">Welcome back.</h1><p class="muted">Sign in to your student or staff account.</p></div>
    <form class="form-surface" method="POST" action="{{ route('login.store') }}">@csrf
        <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus></div>
        <div class="field" style="margin-top:18px"><label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
        <div class="checkbox-row" style="margin-top:16px"><input id="remember" type="checkbox" name="remember" value="1"><label for="remember">Keep me signed in on this device</label></div>
        <div class="form-actions"><button class="button" type="submit">Sign in <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></button><a class="text-link" href="{{ route('register') }}">Create a student account</a></div>
    </form>
</section>
@endsection