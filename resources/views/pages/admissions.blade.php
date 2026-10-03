@extends('layouts.app')
@section('title', 'Admissions')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">Admissions at Avenridge</span><h1 class="display">Start with a conversation.</h1><p>Choosing a school is a family decision. We make time to learn what matters to you and help you picture a day here.</p></div></section>
<section class="section-pad wrap two-col">
    <div>
        <span class="eyebrow">How to begin</span><h2 class="display" style="font-size:34px;margin:8px 0 22px">A straightforward first step.</h2>
        <div class="event-list">
            <article class="event-item"><div class="event-date">01</div><div><h3>Get in touch</h3><p>Tell us a little about your family and the grade you are exploring.</p></div></article>
            <article class="event-item"><div class="event-date">02</div><div><h3>Visit the school</h3><p>Meet a member of our team, see classes in action, and ask every question you have.</p></div></article>
            <article class="event-item"><div class="event-date">03</div><div><h3>Share an application</h3><p>We will guide you through records, a student conversation, and next steps.</p></div></article>
            <article class="event-item"><div class="event-date">04</div><div><h3>Plan what comes next</h3><p>Families receive a clear decision and time to talk it through with us.</p></div></article>
        </div>
        <a class="button" style="margin-top:24px" href="{{ route('contact') }}">Ask about applying <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
    </div>
    <aside>
        <div class="form-surface"><span class="eyebrow">What to have ready</span><h2 class="display" style="font-size:27px;margin:8px 0">A few helpful details</h2><ul class="prose"><li>Recent school records</li><li>A short student introduction</li><li>Any learning support information you would like to share</li><li>Your questions about daily life at Avenridge</li></ul><p class="form-note">There is no application fee for an initial conversation. Our admissions office can help with timing and records.</p></div>
        <div class="prose" style="margin-top:28px"><h2 class="display">When to apply</h2><p>We review applications throughout the year when space is available. For the next school year, families are encouraged to begin a conversation by February 1.</p><p>Need a different timeline? Contact us. We will be glad to talk through options.</p></div>
    </aside>
</section>
<section class="wrap section-pad" style="padding-top:0"><span class="eyebrow">Common questions</span><h2 class="display" style="font-size:34px;margin:8px 0 22px">A few things families ask</h2>
    <div class="info-pairs">
        <article class="info-pair"><h3>Can we visit before applying?</h3><p>Yes. A visit is often the easiest way to know whether Avenridge feels right for your family.</p></article>
        <article class="info-pair"><h3>Do you offer learning support?</h3><p>Our student support team works with teachers and families to understand what helps each learner do their best.</p></article>
        <article class="info-pair"><h3>Are applications reviewed on a rolling basis?</h3><p>Yes, when seats are available. We will be clear about timing for the grade you are considering.</p></article>
        <article class="info-pair"><h3>Who should I contact?</h3><p>Our admissions office is happy to help. Reach us at {{ config('avenridge.contact_email') }}.</p></article>
    </div>
</section>
@endsection