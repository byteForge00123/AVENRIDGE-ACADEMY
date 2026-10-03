@extends('layouts.app')
@section('title', 'Staff overview')
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <span class="eyebrow">{{ auth()->user()->role }} workspace</span><h1 class="display">Avenridge overview</h1>
        <div class="metric-grid">
            <div class="metric"><strong>{{ number_format($studentCount) }}</strong><span>Student accounts</span></div>
            <div class="metric"><strong>{{ number_format($upcomingEvents) }}</strong><span>Upcoming events</span></div>
            <div class="metric"><strong>{{ number_format($pendingPosts) }}</strong><span>Posts awaiting review</span></div>
            <div class="metric"><strong>{{ number_format($pendingReports) }}</strong><span>Open concern reports</span></div>
        </div>
        <div class="admin-section">
            <div class="section-heading"><div><span class="eyebrow">Student community</span><h2 class="display">Posts to review</h2></div><a class="text-link" href="{{ route('admin.posts') }}">All posts <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a></div>
            <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Post</th><th>Category</th><th>Submitted</th><th>Status</th></tr></thead><tbody>
                @forelse ($posts as $post)
                    <tr><td>{{ $post->title }}</td><td>{{ $post->category }}</td><td>{{ $post->created_at->format('M j') }}</td><td><span class="tag">{{ ucfirst($post->status) }}</span></td></tr>
                @empty
                    <tr><td colspan="4">No posts are waiting for review.</td></tr>
                @endforelse
            </tbody></table></div>
        </div>
        <div class="admin-section">
            <div class="section-heading"><div><span class="eyebrow">Student support</span><h2 class="display">Recent reports</h2></div><a class="text-link" href="{{ route('admin.reports') }}">Open reports <i class="icon-sm" data-lucide="arrow-right" aria-hidden="true"></i></a></div>
            <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Reference</th><th>Category</th><th>Received</th><th>Status</th></tr></thead><tbody>
                @forelse ($reports as $report)
                    <tr><td>{{ $report->reference_code }}</td><td>{{ $report->category }}</td><td>{{ $report->created_at->format('M j') }}</td><td><span class="tag">{{ str($report->status)->replace('_', ' ')->title() }}</span></td></tr>
                @empty
                    <tr><td colspan="4">No concern reports to show.</td></tr>
                @endforelse
            </tbody></table></div>
        </div>
    </section>
</div>
@endsection