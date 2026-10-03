<?php

namespace App\Http\Controllers;

use App\Models\ConcernReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ConcernReportController extends Controller
{
    public const CATEGORIES = [
        'Bullying', 'Harassment', 'Discrimination', 'Safety Concern',
        'Academic Concern', 'Staff Concern', 'Student Concern', 'Other',
    ];

    public function create()
    {
        return view('concerns.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'what_happened' => ['required', 'string', 'min:20', 'max:10000'],
            'where_happened' => ['nullable', 'string', 'max:255'],
            'happened_at' => ['nullable', 'date', 'before_or_equal:now'],
            'people_involved' => ['nullable', 'string', 'max:3000'],
            'additional_details' => ['nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('concern-reports', 'local');
        }

        do {
            $reference = 'RPT-'.now()->format('Y').'-'.str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (ConcernReport::where('reference_code', $reference)->exists());

        $report = ConcernReport::create([
            ...$data,
            'reference_code' => $reference,
            'submitted_by' => $request->user()?->id,
            'status' => 'submitted',
            'is_anonymous' => $request->boolean('anonymous', true),
        ]);

        return view('concerns.submitted', ['reference' => $report->reference_code]);
    }

    public function trackForm()
    {
        return view('concerns.track');
    }

    public function track(Request $request)
    {
        $data = $request->validate(['reference_code' => ['required', 'string', 'regex:/^RPT-\d{4}-\d{5}$/']]);
        $report = ConcernReport::where('reference_code', strtoupper($data['reference_code']))->first();

        if (! $report) {
            return back()->withErrors(['reference_code' => 'We could not find a report with that reference number.'])->onlyInput('reference_code');
        }

        return view('concerns.track', [
            'result' => [
                'reference_code' => $report->reference_code,
                'status' => $report->status,
                'submitted_at' => $report->created_at,
            ],
        ]);
    }

    public function attachment(ConcernReport $report)
    {
        abort_unless(auth()->user()?->role === 'admin' || $report->assigned_to === auth()->id(), 403);
        abort_unless($report->attachment_path && Storage::disk('local')->exists($report->attachment_path), 404);

        return Storage::disk('local')->download($report->attachment_path);
    }
}