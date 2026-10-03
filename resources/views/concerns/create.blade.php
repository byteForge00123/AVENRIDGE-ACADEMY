@extends('layouts.app')
@section('title', 'Report a concern')
@section('content')
<section class="page-hero"><div class="narrow"><span class="eyebrow">Student support</span><h1 class="display">Report a concern.</h1><p>Tell us what is happening. A designated member of the student support team will review your report privately.</p></div></section>
<section class="section-pad narrow">
    <div class="safety-note" role="note"><i class="icon" data-lucide="shield-check" aria-hidden="true"></i><p><strong>If someone is in immediate danger, call 911 or tell a trusted adult right now.</strong><br>This form is for concerns that need follow-up from the school.</p></div>
    <form class="form-surface" method="POST" action="{{ route('concerns.store') }}" enctype="multipart/form-data" style="margin-top:20px">@csrf
        <div class="form-grid">
            <div class="field field-full"><label for="category">Type of concern</label><select name="category" id="category" required><option value="">Choose a category</option>@foreach ($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach</select></div>
            <div class="field field-full"><label for="what_happened">What happened?</label><textarea id="what_happened" name="what_happened" minlength="20" maxlength="10000" required>{{ old('what_happened') }}</textarea><small>Include what you are comfortable sharing. This information is private to authorized school staff.</small></div>
            <div class="field"><label for="where_happened">Where did it happen?</label><input id="where_happened" name="where_happened" value="{{ old('where_happened') }}" maxlength="255"></div>
            <div class="field"><label for="happened_at">When did it happen?</label><input id="happened_at" type="datetime-local" name="happened_at" value="{{ old('happened_at') }}"></div>
            <div class="field field-full"><label for="people_involved">People involved <span class="muted">(optional)</span></label><textarea id="people_involved" name="people_involved" rows="3" maxlength="3000">{{ old('people_involved') }}</textarea></div>
            <div class="field field-full"><label for="additional_details">Anything else we should know? <span class="muted">(optional)</span></label><textarea id="additional_details" name="additional_details" rows="3" maxlength="5000">{{ old('additional_details') }}</textarea></div>
            <div class="field field-full"><label for="attachment">Optional attachment</label><input id="attachment" type="file" name="attachment" accept="image/jpeg,image/png,application/pdf"><small>JPG, PNG, or PDF · up to 5 MB. Stored privately for staff review.</small></div>
            <div class="field field-full"><div class="checkbox-row"><input id="anonymous" type="checkbox" name="anonymous" value="1" @checked(old('anonymous', true))><label for="anonymous"><strong>Submit anonymously</strong><br><span class="form-note">Your identity will not be shown publicly. Authorized staff may see account details if you are signed in.</span></label></div></div>
        </div>
        <div class="form-actions"><button class="button button-coral" type="submit">Submit privately <i class="icon-sm" data-lucide="shield-check" aria-hidden="true"></i></button><span class="form-note">Your report is never published in the community feed.</span></div>
    </form>
</section>
@endsection