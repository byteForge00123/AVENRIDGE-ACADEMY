@extends('layouts.app')
@section('title', 'Concern reports')
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <span class="eyebrow">Private student support</span><h1 class="display">Concern reports</h1>
        <p class="muted">Case information is visible only to authorized staff. Never share report details outside this workspace.</p>
        <form method="GET" action="{{ route('admin.reports') }}" class="search-filter" style="margin:20px 0">
            <div class="field"><label class="sr-only" for="report-status">Filter by status</label><select name="status" id="report-status"><option value="">All statuses</option>@foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>@endforeach</select></div>
            <div class="field"><label class="sr-only" for="report-category">Filter by category</label><select name="category" id="report-category"><option value="">All categories</option>@foreach ($categories as $category)<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>@endforeach</select></div>
            <button class="button button-small" type="submit">Apply filters</button>
        </form>
        <div class="report-case-list">
            @forelse ($reports as $report)
                <article class="report-case">
                    <div class="report-case-head"><div><span class="eyebrow">{{ $report->category }}</span><h2 class="display">{{ $report->reference_code }}</h2><p class="muted">Received {{ $report->created_at->format('F j, Y · g:i a') }} · {{ $report->is_anonymous ? 'Anonymous submission' : 'Identified submission' }}</p></div><span class="tag">{{ str($report->status)->replace('_', ' ')->title() }}</span></div>
                    <div class="report-case-body"><p><strong>What happened</strong><br>{{ $report->what_happened }}</p>@if ($report->where_happened)<p><strong>Where</strong><br>{{ $report->where_happened }}</p>@endif @if ($report->happened_at)<p><strong>When</strong><br>{{ $report->happened_at->format('F j, Y · g:i a') }}</p>@endif @if ($report->people_involved)<p><strong>People involved</strong><br>{{ $report->people_involved }}</p>@endif @if ($report->additional_details)<p><strong>Additional details</strong><br>{{ $report->additional_details }}</p>@endif @if ($report->attachment_path)<a class="text-link" href="{{ route('admin.reports.attachment', $report) }}">Download private attachment <i class="icon-sm" data-lucide="arrow-down-right" aria-hidden="true"></i></a>@endif</div>
                    @if ($report->notes->isNotEmpty())<div class="internal-notes"><strong>Internal notes</strong>@foreach ($report->notes as $note)<p>{{ $note->note }} <small>· {{ $note->created_at->format('M j, Y') }}</small></p>@endforeach</div>@endif
                    <div class="report-case-actions">
                        <form method="POST" action="{{ route('admin.reports.update', $report) }}">@csrf @method('PATCH')<div class="field"><label for="status-{{ $report->id }}">Update status</label><select name="status" id="status-{{ $report->id }}">@foreach ($statuses as $status)<option value="{{ $status }}" @selected($report->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>@endforeach</select></div><div class="field"><label for="note-{{ $report->id }}">Internal note <span class="muted">(optional)</span></label><textarea name="note" id="note-{{ $report->id }}" rows="2" maxlength="5000"></textarea></div><button class="button button-small" type="submit">Save case update</button></form>
                        @if (auth()->user()->role === 'admin')<form method="POST" action="{{ route('admin.reports.assign', $report) }}">@csrf @method('PATCH')<div class="field"><label for="staff-{{ $report->id }}">Assign to staff</label><select name="assigned_to" id="staff-{{ $report->id }}"><option value="">Unassigned</option>@foreach ($staff as $member)<option value="{{ $member->id }}" @selected($report->assigned_to === $member->id)>{{ $member->name }}</option>@endforeach</select></div><button class="button button-light button-small" type="submit">Save assignment</button></form>@endif
                    </div>
                </article>
            @empty
                <p class="empty-state">No reports match those filters.</p>
            @endforelse
        </div>
        <div class="pagination">{{ $reports->links('pagination::simple-tailwind') }}</div>
    </section>
</div>
@endsection