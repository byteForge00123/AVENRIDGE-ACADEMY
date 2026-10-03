@extends('layouts.app')
@section('title', 'About Avenridge')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">A school with room to become</span><h1 class="display">A place to be known, challenged, and welcomed.</h1><p>Since 1987, Avenridge has brought students and teachers together around good questions, meaningful work, and a shared sense of responsibility.</p></div></section>
<section class="section-pad wrap content-grid">
    <div class="prose">
        <h2 class="display" style="margin-top:0">Our story</h2>
        <p>Avenridge began with a simple belief: students learn best when they are both well supported and genuinely stretched. A small group of Northfield educators opened the school with that idea in mind. It still guides our choices today.</p>
        <p>Our campus has grown, our programs have deepened, and the world our students are preparing to meet has changed. What has stayed steady is the importance of careful teaching, honest relationships, and learning that matters beyond the classroom.</p>
        <div class="info-pairs">
            <article class="info-pair"><h3>Our mission</h3><p>To help each student develop a clear mind, a kind heart, and the confidence to contribute meaningfully.</p></article>
            <article class="info-pair"><h3>Our vision</h3><p>A learning community where curiosity is practiced, differences are respected, and every person can grow with purpose.</p></article>
        </div>
        <h2 class="display">What we practice</h2>
        <ul><li><strong>Curiosity:</strong> ask a better question and stay with it.</li><li><strong>Care:</strong> notice who is here and what they need.</li><li><strong>Courage:</strong> try, revise, and begin again.</li><li><strong>Contribution:</strong> use what you learn in service of others.</li></ul>
    </div>
    <aside class="prose">
        <img class="news-image" src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=900&q=85" alt="A bright, welcoming school learning space" loading="lazy">
        <span class="eyebrow">A note from our head of school</span>
        <h2 class="display" style="margin-top:10px">Dear Avenridge families,</h2>
        <p>What I value most about this school is the way people make room for one another. A student can be serious about a difficult problem and still know it is all right to ask for help. That balance takes practice, and it is work we do together.</p>
        <p>We are glad you are here, and we look forward to meeting you.</p>
        <p><strong>Elena Brooks</strong><br>Head of School</p>
    </aside>
</section>
<section class="wrap cta-line"><h2 class="display">Come see what learning feels like here.</h2><a class="button" href="{{ route('contact') }}">Plan a visit <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a></section>
@endsection