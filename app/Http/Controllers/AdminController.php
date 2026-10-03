<?php

namespace App\Http\Controllers;

use App\Models\ConcernReport;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\ReportNote;
use App\Models\ReportUpdate;
use App\Models\SchoolEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public const STATUSES = ['submitted', 'under_review', 'action_in_progress', 'resolved', 'closed'];

    public function dashboard()
    {
        $reportQuery = ConcernReport::query();

        if (auth()->user()->role === 'staff') {
            $reportQuery->where('assigned_to', auth()->id());
        }

        return view('admin.dashboard', [
            'studentCount' => User::where('role', 'student')->count(),
            'upcomingEvents' => SchoolEvent::where('starts_at', '>=', now())->count(),
            'pendingPosts' => Post::where('status', 'pending')->count(),
            'pendingReports' => (clone $reportQuery)->whereIn('status', ['submitted', 'under_review', 'action_in_progress'])->count(),
            'reports' => (clone $reportQuery)->latest()->take(6)->get(),
            'posts' => Post::where('status', 'pending')->latest()->take(6)->get(),
        ]);
    }

    public function posts()
    {
        return view('admin.posts', ['posts' => Post::with(['reports' => fn ($query) => $query->latest(), 'replies' => fn ($query) => $query->latest()])->withCount('reports')->latest()->paginate(12)]);
    }

    public function moderatePost(Request $request, Post $post)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['approved', 'rejected', 'hidden'])]]);
        $post->update($data);

        return back()->with('success', 'Post status updated.');
    }

    public function moderateReply(Request $request, PostReply $reply)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['approved', 'rejected'])]]);
        $reply->update($data);

        return back()->with('success', 'Reply status updated.');
    }

    public function deletePost(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    public function postAttachment(Post $post)
    {
        abort_unless($post->attachment_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($post->attachment_path), 404);

        return \Illuminate\Support\Facades\Storage::disk('local')->download($post->attachment_path);
    }

    public function reports(Request $request)
    {
        $query = ConcernReport::query()->with('notes');

        if (auth()->user()->role === 'staff') {
            $query->where('assigned_to', auth()->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        return view('admin.reports', [
            'reports' => $query->latest()->paginate(10)->withQueryString(),
            'statuses' => self::STATUSES,
            'categories' => ConcernReportController::CATEGORIES,
            'staff' => auth()->user()->role === 'admin' ? User::where('role', 'staff')->orderBy('name')->get() : collect(),
        ]);
    }

    public function updateReport(Request $request, ConcernReport $report)
    {
        abort_unless(auth()->user()->role === 'admin' || $report->assigned_to === auth()->id(), 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
            'note' => ['nullable', 'string', 'max:5000'],
        ]);

        $report->update(['status' => $data['status']]);
        ReportUpdate::create([
            'concern_report_id' => $report->id,
            'created_by' => auth()->id(),
            'status' => $data['status'],
        ]);

        if (filled($data['note'] ?? null)) {
            ReportNote::create([
                'concern_report_id' => $report->id,
                'created_by' => auth()->id(),
                'note' => $data['note'],
            ]);
        }

        return back()->with('success', 'Report updated.');
    }

    public function assignReport(Request $request, ConcernReport $report)
    {
        $data = $request->validate([
            'assigned_to' => ['nullable', Rule::exists('users', 'id')->where('role', 'staff')],
        ]);
        $report->update(['assigned_to' => $data['assigned_to'] ?? null]);

        return back()->with('success', 'Report assignment updated.');
    }

    public function reportAttachment(ConcernReport $report)
    {
        abort_unless(auth()->user()->role === 'admin' || $report->assigned_to === auth()->id(), 403);
        abort_unless($report->attachment_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($report->attachment_path), 404);

        return \Illuminate\Support\Facades\Storage::disk('local')->download($report->attachment_path);
    }

    public function users()
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('admin.users', ['users' => User::orderBy('role')->orderBy('name')->paginate(20)]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        abort_if($user->is(auth()->user()), 422, 'You cannot change your own role.');

        $data = $request->validate(['role' => ['required', Rule::in(['admin', 'staff', 'student'])]]);
        $user->update($data);

        return back()->with('success', 'User role updated.');
    }
}