@extends('layouts.app')
@section('title', 'Write a community post')
@section('content')
<section class="page-hero"><div class="narrow"><a class="text-link" href="{{ route('community.index') }}"><i class="icon-sm" data-lucide="arrow-right" style="transform:rotate(180deg)" aria-hidden="true"></i> Back to the community</a><p class="eyebrow" style="margin-top:25px">Your voice belongs here</p><h1 class="display">Write a post.</h1><p>Posts are anonymous by default and reviewed by a staff member before they appear in the feed.</p></div></section>
<section class="section-pad narrow">
    <form class="form-surface" method="POST" action="{{ route('community.store') }}" enctype="multipart/form-data">@csrf
        <div class="form-grid">
            <div class="field field-full"><label for="category">Topic</label><select name="category" id="category" required><option value="">Choose a topic</option>@foreach ($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach</select></div>
            <div class="field field-full"><label for="title">Title</label><input id="title" name="title" value="{{ old('title') }}" maxlength="140" required></div>
            <div class="field field-full"><label for="body">Your message</label><textarea id="body" name="body" minlength="10" maxlength="5000" required>{{ old('body') }}</textarea><small>Keep identifying details out of public posts.</small></div>
            <div class="field field-full"><label for="attachment">Optional attachment</label><input id="attachment" type="file" name="attachment" accept="image/jpeg,image/png,application/pdf"><small>JPG, PNG, or PDF · up to 5 MB</small></div>
            <div class="field field-full"><div class="checkbox-row"><input id="anonymous" type="checkbox" checked disabled><label for="anonymous">Posted as <strong>Anonymous Student</strong>. Your name and account details are never shown publicly.</label></div></div>
        </div>
        <div class="form-actions"><button class="button" type="submit">Send for review <i class="icon-sm" data-lucide="send" aria-hidden="true"></i></button><a class="text-link" href="{{ route('community.index') }}">Cancel</a></div>
    </form>
</section>
@endsection