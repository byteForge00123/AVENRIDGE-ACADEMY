<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReply;
use App\Models\PostReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    public const CATEGORIES = [
        'General Discussion', 'Suggestions', 'Confessions', 'Questions',
        'School Feedback', 'Lost & Found', 'Campus Life', 'Other',
    ];

    public function index(Request $request)
    {
        $posts = Post::query()
            ->where('status', 'approved')
            ->withCount('approvedReplies')
            ->with('approvedReplies')
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')->toString()))
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($search) => $search
                ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('body', 'like', '%'.$request->string('q')->toString().'%')))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('community.index', ['posts' => $posts, 'categories' => self::CATEGORIES]);
    }

    public function create()
    {
        return view('community.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'title' => ['required', 'string', 'max:140'],
            'body' => ['required', 'string', 'min:10', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('community-attachments', 'local');
        }

        Post::create([
            ...$data,
            'user_id' => $request->user()?->id,
            'status' => 'pending',
            'is_anonymous' => true,
        ]);

        return redirect()->route('community.index')->with('success', 'Your post is in the moderation queue. It will appear here after review.');
    }

    public function report(Request $request, Post $post)
    {
        abort_unless($post->status === 'approved', 404);

        $data = $request->validate(['reason' => ['required', 'string', 'max:1000']]);

        PostReport::create([
            'post_id' => $post->id,
            'user_id' => $request->user()?->id,
            'reason' => $data['reason'],
        ]);

        return back()->with('success', 'Thank you. A staff member will review this post.');
    }

    public function reply(Request $request, Post $post)
    {
        abort_unless($post->status === 'approved', 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        PostReply::create([
            'post_id' => $post->id,
            'user_id' => $request->user()?->id,
            'body' => $data['body'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your reply was sent for review. It will appear after a staff member approves it.');
    }

    public function attachment(Post $post)
    {
        abort_unless($post->status === 'approved', 404);
        abort_unless($post->attachment_path && Storage::disk('local')->exists($post->attachment_path), 404);

        return Storage::disk('local')->download($post->attachment_path);
    }
}