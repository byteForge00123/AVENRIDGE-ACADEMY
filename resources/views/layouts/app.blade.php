<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A welcoming academic community where students are encouraged to learn, discover, and grow.">
    <title>@yield('title', config('avenridge.name')) · {{ config('avenridge.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header class="site-header" x-data="{ menuOpen: false }">
        <div class="wrap nav-row">
            <a class="brand" href="{{ route('home') }}" aria-label="{{ config('avenridge.name') }} home">
                <span class="brand-copy"><strong>{{ config('avenridge.name') }}</strong><small>Northfield · Est. 1987</small></span>
            </a>
            <nav class="nav-links" aria-label="Main navigation">
                <a href="{{ route('about') }}">Our school</a>
                <a href="{{ route('programs') }}">Learning</a>
                <a href="{{ route('campus') }}">Campus</a>
                <a href="{{ route('news.index') }}">News & events</a>
                <a href="{{ route('community.index') }}">Student life</a>
            </nav>
            <div class="nav-actions">
                <a class="button button-light button-small" href="{{ route('admissions') }}">Admissions <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                @auth
                    @if (auth()->user()->isStaff())
                        <a class="text-link" href="{{ route('admin.dashboard') }}">Staff area</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-link" type="submit">Sign out</button></form>
                @else
                    <a class="text-link" href="{{ route('login') }}">Sign in</a>
                @endauth
                <button class="nav-mobile" type="button" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen.toString()" :aria-label="menuOpen ? 'Close navigation' : 'Open navigation'" aria-controls="mobile-menu">
                    <i class="icon" data-lucide="menu" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <nav id="mobile-menu" class="mobile-menu" x-show="menuOpen" x-cloak x-transition aria-label="Mobile navigation">
            <a href="{{ route('about') }}">Our school</a>
            <a href="{{ route('programs') }}">Learning & programs</a>
            <a href="{{ route('admissions') }}">Admissions</a>
            <a href="{{ route('faculty') }}">Faculty & staff</a>
            <a href="{{ route('campus') }}">Campus</a>
            <a href="{{ route('news.index') }}">News & events</a>
            <a href="{{ route('community.index') }}">Student community</a>
            <a href="{{ route('concerns.create') }}">Report a concern</a>
            <a href="{{ route('concerns.track.form') }}">Track a report</a>
        </nav>
    </header>
    @if (session('success') || $errors->any())
        <div class="wrap flash-wrap"><x-flash /></div>
    @endif
    <main id="main-content">@yield('content')</main>
    <footer class="site-footer">
        <div class="wrap footer-main">
            <div class="footer-about">
                <a class="brand" href="{{ route('home') }}"><span class="brand-copy"><strong>{{ config('avenridge.name') }}</strong></span></a>
                <p>A school community built around thoughtful work, kind attention, and the confidence to keep asking questions.</p>
            </div>
            <div>
                <h2 class="footer-heading">Explore</h2>
                <div class="footer-links"><a href="{{ route('about') }}">About Avenridge</a><a href="{{ route('programs') }}">Academic programs</a><a href="{{ route('admissions') }}">Admissions</a><a href="{{ route('faculty') }}">Faculty & staff</a><a href="{{ route('news.index') }}">News & events</a></div>
            </div>
            <div>
                <h2 class="footer-heading">Here for students</h2>
                <div class="footer-links"><a href="{{ route('community.index') }}">Student community</a><a href="{{ route('concerns.create') }}">Report a concern</a><a href="{{ route('concerns.track.form') }}">Track a report</a><a href="{{ route('contact') }}">Contact the office</a><span>{{ config('avenridge.phone') }}</span></div>
            </div>
        </div>
        <div class="wrap footer-bottom"><span>© {{ date('Y') }} {{ config('avenridge.name') }}. All rights reserved.</span><span>{{ config('avenridge.address') }}</span></div>
    </footer>
</body>
</html>