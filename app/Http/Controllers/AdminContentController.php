<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Faculty;
use App\Models\GalleryItem;
use App\Models\NewsItem;
use App\Models\Program;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminContentController extends Controller
{
    private const TYPES = [
        'programs' => [
            'label' => 'Programs', 'model' => Program::class, 'sort' => 'sort_order',
            'fields' => [
                'name' => ['Name', 'text', 'required|string|max:120'],
                'level' => ['Grade/year level', 'text', 'required|string|max:100'],
                'summary' => ['Short description', 'textarea', 'required|string|max:500'],
                'description' => ['Full description', 'textarea', 'required|string|max:5000'],
                'subjects' => ['Key subjects (comma-separated)', 'textarea', 'nullable|string|max:1000'],
                'sort_order' => ['Display order', 'number', 'required|integer|min:0|max:999'],
            ],
        ],
        'news' => [
            'label' => 'News articles', 'model' => NewsItem::class, 'sort' => 'published_at',
            'fields' => [
                'title' => ['Title', 'text', 'required|string|max:180'],
                'category' => ['Category', 'text', 'required|string|max:80'],
                'excerpt' => ['Excerpt', 'textarea', 'required|string|max:500'],
                'body' => ['Article body', 'textarea', 'required|string|max:20000'],
                'image_url' => ['Image URL (optional)', 'url', 'nullable|url|max:2048'],
                'is_featured' => ['Featured story', 'checkbox', 'nullable|boolean'],
                'is_published' => ['Published', 'checkbox', 'nullable|boolean'],
            ],
        ],
        'events' => [
            'label' => 'Events', 'model' => SchoolEvent::class, 'sort' => 'starts_at',
            'fields' => [
                'title' => ['Title', 'text', 'required|string|max:180'],
                'category' => ['Category', 'text', 'required|string|max:80'],
                'venue' => ['Venue', 'text', 'required|string|max:180'],
                'description' => ['Description', 'textarea', 'required|string|max:5000'],
                'starts_at' => ['Starts at', 'datetime-local', 'required|date'],
                'ends_at' => ['Ends at (optional)', 'datetime-local', 'nullable|date|after:starts_at'],
                'image_url' => ['Image URL (optional)', 'url', 'nullable|url|max:2048'],
            ],
        ],
        'faculty' => [
            'label' => 'Faculty & staff profiles', 'model' => Faculty::class, 'sort' => 'sort_order',
            'fields' => [
                'name' => ['Name', 'text', 'required|string|max:120'],
                'position' => ['Position', 'text', 'required|string|max:120'],
                'department' => ['Department', 'text', 'required|string|max:120'],
                'biography' => ['Biography', 'textarea', 'required|string|max:5000'],
                'image_url' => ['Image URL (optional)', 'url', 'nullable|url|max:2048'],
                'sort_order' => ['Display order', 'number', 'required|integer|min:0|max:999'],
            ],
        ],
        'facilities' => [
            'label' => 'Campus facilities', 'model' => Facility::class, 'sort' => 'sort_order',
            'fields' => [
                'name' => ['Name', 'text', 'required|string|max:120'],
                'category' => ['Category', 'text', 'required|string|max:80'],
                'description' => ['Description', 'textarea', 'required|string|max:3000'],
                'image_url' => ['Image URL (optional)', 'url', 'nullable|url|max:2048'],
                'sort_order' => ['Display order', 'number', 'required|integer|min:0|max:999'],
            ],
        ],
        'gallery' => [
            'label' => 'Campus gallery', 'model' => GalleryItem::class, 'sort' => 'sort_order',
            'fields' => [
                'caption' => ['Caption', 'text', 'required|string|max:180'],
                'category' => ['Category', 'text', 'required|string|max:80'],
                'image_url' => ['Image URL', 'url', 'required|url|max:2048'],
                'sort_order' => ['Display order', 'number', 'required|integer|min:0|max:999'],
            ],
        ],
    ];

    public function index(string $type)
    {
        $definition = $this->definition($type);
        $model = $definition['model'];

        return view('admin.content.index', [
            'type' => $type,
            'definition' => $definition,
            'items' => $model::orderBy($definition['sort'])->paginate(15),
        ]);
    }

    public function create(string $type)
    {
        return view('admin.content.form', [
            'type' => $type,
            'definition' => $this->definition($type),
            'item' => null,
        ]);
    }

    public function store(Request $request, string $type)
    {
        $definition = $this->definition($type);
        $data = $this->validatedData($request, $type, $definition);
        $model = $definition['model'];

        $model::create($this->prepareData($data, $type));

        return redirect()->route('admin.content.index', $type)->with('success', $definition['label'].' item created.');
    }

    public function edit(string $type, int $item)
    {
        $definition = $this->definition($type);
        $model = $definition['model'];

        return view('admin.content.form', [
            'type' => $type,
            'definition' => $definition,
            'item' => $model::findOrFail($item),
        ]);
    }

    public function update(Request $request, string $type, int $item)
    {
        $definition = $this->definition($type);
        $data = $this->validatedData($request, $type, $definition);
        $model = $definition['model'];
        $record = $model::findOrFail($item);
        $record->update($this->prepareData($data, $type, $record));

        return redirect()->route('admin.content.index', $type)->with('success', $definition['label'].' item updated.');
    }

    public function destroy(string $type, int $item)
    {
        $definition = $this->definition($type);
        $model = $definition['model'];
        $model::findOrFail($item)->delete();

        return back()->with('success', $definition['label'].' item deleted.');
    }

    private function definition(string $type): array
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        return self::TYPES[$type];
    }

    private function validatedData(Request $request, string $type, array $definition): array
    {
        $rules = [];

        foreach ($definition['fields'] as $key => [, , $rule]) {
            $rules[$key] = explode('|', $rule);
        }

        $uniqueField = match ($type) {
            'programs', 'facilities' => 'name',
            'news' => 'title',
            default => null,
        };

        if ($uniqueField) {
            $rules[$uniqueField][] = Rule::unique($type, $uniqueField)->ignore($request->route('item'));
        }

        return $request->validate($rules);
    }

    private function prepareData(array $data, string $type, ?object $record = null): array
    {
        if ($type === 'programs') {
            $data['slug'] = Str::slug($data['name']);
            $data['subjects'] = filled($data['subjects'] ?? null)
                ? array_values(array_filter(array_map('trim', explode(',', $data['subjects']))))
                : [];
        }

        if ($type === 'facilities') {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($type === 'news') {
            $data['slug'] = Str::slug($data['title']);
            $data['published_at'] = ($data['is_published'] ?? false) ? ($record?->published_at ?? now()) : null;
            unset($data['is_published']);
        }

        if ($type === 'gallery') {
            $data['image_url'] = trim($data['image_url']);
        }

        return $data;
    }
}