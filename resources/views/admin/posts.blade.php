@extends('layouts.app')
@section('title', 'Community moderation')
@section('content')
<div class="admin-shell">
    @include('admin.partials.nav')
    <section class="admin-content">
        <span class="eyebrow">Student community</span><h1 class="display">Post moderation</h1>
        <p class="muted">Review anonymous submissions and student reports. Only approved posts appear publicly.</p>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Submission</th><th>Moderation reports</th><th>Review action</th></tr></thead><tbody>
            @forelse ($posts as $post)
                <tr>
                    <td style="min-width:290px"><span class="tag">{{ $post->category }}</span><p><strong>{{ $post->title }}</strong></p><p style="white-space:pre-line">{{ $post->body }}</p><small>Anonymous Student · {{ $post->created_at->format('M j, Y') }} · {{ ucfirst($post->status) }}</small>@if ($post->attachment_path)<p><a class="text-link" href="{{ route('admin.posts.attachment', $post) }}">View private attachment</a></p>@endif
                        @if ($post->replies->isNotEmpty())<div class="admin-replies"><strong>Replies</strong>@foreach ($post->replies as $reply)<div class="admin-reply"><p>{{ $reply->body }}</p><small>Anonymous Student · {{ ucfirst($reply->status) }}</small>@if ($reply->status === 'pending')<form method="POST" action="{{ route('admin.replies.moderate', $reply) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="text-link" type="submit">Approve</button></form><form method="POST" action="{{ route('admin.replies.moderate', $reply) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="text-link" type="submit">Reject</button></form>@endif</div>@endforeach</div>@endif
                    </td>
                    <td style="min-width:210px">@if ($post->reports->isEmpty())<span class="muted">No reports</span>@else<strong>{{ $post->reports_count }} report(s)</strong>@foreach ($post->reports as $report)<p>{{ $report->reason }}<br><small>{{ $report->created_at->format('M j') }}</small></p>@endforeach @endif</td>
                    <td style="min-width:220px"><form method="POST" action="{{ route('admin.posts.moderate', $post) }}">@csrf @method('PATCH')<label class="sr-only" for="post-status-{{ $post->id }}">Set post status</label><select id="post-status-{{ $post->id }}" name="status"><option value="approved" @selected($post->status === 'approved')>Approve</option><option value="rejected" @selected($post->status === 'rejected')>Reject</option><option value="hidden" @selected($post->status === 'hidden')>Hide</option></select><button class="button button-small" type="submit">Save</button></form><form method="POST" action="{{ route('admin.posts.delete', $post) }}" onsubmit="return confirm('Delete this post and its moderation reports?')" style="margin-top:12px">@csrf @method('DELETE')<button class="text-link" type="submit">Delete post</button></form></td>
                </tr>
            @empty
                <tr><td colspan="3">No posts have been submitted.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="pagination">{{ $posts->links('pagination::simple-tailwind') }}</div>
    </section>
</div>
@endsection