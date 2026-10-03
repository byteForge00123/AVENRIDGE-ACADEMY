@extends('layouts.app')
@section('title', 'Student community')
@section('content')
<section class="page-hero"><div class="wrap"><span class="eyebrow">Student life · Learn. Connect. Belong.</span><h1 class="display">A place to share what matters.</h1><p>Ask a question, share an idea, or talk about something on your mind. Every post is anonymous and reviewed before it appears.</p><div style="margin-top:22px"><a class="button" href="{{ route('community.create') }}">Write a post <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></div></section>
<section class="section-pad wrap community-layout">
    <div>
        <form class="search-filter" method="GET" action="{{ route('community.index') }}">
            <div class="field"><label class="sr-only" for="community-search">Search posts</label><input id="community-search" type="search" name="q" value="{{ request('q') }}" placeholder="Search the community"></div>
            <div class="field"><label class="sr-only" for="community-category">Filter by category</label><select id="community-category" name="category"><option value="">All topics</option>@foreach ($categories as $category)<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>@endforeach</select></div>
            <button class="button button-small" type="submit"><i class="icon-sm" data-lucide="search" aria-hidden="true"></i><span>Filter</span></button>
        </form>
        <div class="post-list" style="margin-top:24px">
            @forelse ($posts as $post)
                <article class="post-row">
                    <div>
                        <div class="post-meta"><span class="tag">{{ $post->category }}</span><span>Anonymous Student</span><span>{{ $post->created_at->diffForHumans() }}</span></div>
                        <h2>{{ $post->title }}</h2>
                        <p>{{ $post->body }}</p>
                        @if ($post->approvedReplies->isNotEmpty())
                            <div class="reply-list" aria-label="Approved replies">
                                @foreach ($post->approvedReplies as $reply)
                                    <div class="reply-item"><strong>Anonymous Student</strong><p>{{ $reply->body }}</p></div>
                                @endforeach
                            </div>
                        @endif
                        <form class="reply-form" method="POST" action="{{ route('community.reply', $post) }}">
                            @csrf
                            <label class="sr-only" for="reply-{{ $post->id }}">Write an anonymous reply to {{ $post->title }}</label>
                            <input id="reply-{{ $post->id }}" name="body" maxlength="2000" placeholder="Write a thoughtful reply" required>
                            <button class="icon-button" type="submit" aria-label="Send reply"><i class="icon-sm" data-lucide="send" aria-hidden="true"></i></button>
                        </form>
                        @if ($post->attachment_path)
                            <a class="text-link" style="margin-top:12px" href="{{ route('community.attachment', $post) }}">View attachment <i class="icon-sm" data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <div class="post-actions">
                        <span class="post-meta" aria-label="{{ $post->approved_replies_count }} replies"><i class="icon-sm" data-lucide="message-circle" aria-hidden="true"></i>{{ $post->approved_replies_count }}</span>
                        <details class="report-details"><summary class="icon-button" aria-label="Report this post"><i class="icon-sm" data-lucide="shield-check" aria-hidden="true"></i></summary><form class="report-pop" method="POST" action="{{ route('community.report', $post) }}">@csrf<label for="reason-{{ $post->id }}">Why are you reporting this?</label><input id="reason-{{ $post->id }}" name="reason" maxlength="1000" required><button class="button button-small" type="submit">Send report</button></form></details>
                    </div>
                </article>
            @empty
                <div class="empty-state"><h2 class="display" style="color:var(--ink)">Nothing here just yet.</h2><p>Try another filter or start a conversation for the community.</p><a class="text-link" href="{{ route('community.create') }}">Write the first post <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a></div>
            @endforelse
        </div>
        <div class="pagination">{{ $posts->links('pagination::simple-tailwind') }}</div>
    </div>
    <aside class="community-aside">
        <div class="aside-note"><i class="icon" data-lucide="lock-keyhole" aria-hidden="true"></i><span class="eyebrow">A note on privacy</span><h2 class="display">Your name stays yours.</h2><p>Public posts are shown as “Anonymous Student.” A small staff team reviews each one before it appears.</p></div>
        <div class="aside-support"><span class="eyebrow">Need someone to listen?</span><h2 class="display">You do not have to figure it out alone.</h2><p>Share a concern privately with our student support team. Your report details are never published.</p><a class="text-link" href="{{ route('concerns.create') }}">Report a concern <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a><a class="text-link" style="margin-top:12px" href="{{ route('concerns.track.form') }}">Track an existing report</a></div>
    </aside>
</section>
@endsection