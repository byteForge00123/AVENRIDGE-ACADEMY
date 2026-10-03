<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Faculty;
use App\Models\GalleryItem;
use App\Models\NewsItem;
use App\Models\Program;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home', [
            'programs' => Program::orderBy('sort_order')->take(3)->get(),
            'featuredNews' => NewsItem::whereNotNull('published_at')->orderByDesc('is_featured')->orderByDesc('published_at')->take(3)->get(),
            'events' => SchoolEvent::where('starts_at', '>=', now())->orderBy('starts_at')->take(3)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function programs()
    {
        return view('pages.programs', ['programs' => Program::orderBy('sort_order')->get()]);
    }

    public function admissions()
    {
        return view('pages.admissions');
    }

    public function faculty()
    {
        return view('pages.faculty', ['faculty' => Faculty::orderBy('sort_order')->get()]);
    }

    public function campus()
    {
        return view('pages.campus', [
            'facilities' => Facility::orderBy('sort_order')->get(),
            'gallery' => GalleryItem::orderBy('sort_order')->get(),
        ]);
    }

    public function news(Request $request)
    {
        $articles = NewsItem::whereNotNull('published_at')
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')->toString()))
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($search) => $search
                ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('excerpt', 'like', '%'.$request->string('q')->toString().'%')))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.news', [
            'articles' => $articles,
            'events' => SchoolEvent::where('starts_at', '>=', now())->orderBy('starts_at')->get(),
            'categories' => NewsItem::whereNotNull('published_at')->distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    public function article(string $slug)
    {
        $article = NewsItem::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();

        return view('pages.article', compact('article'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
}