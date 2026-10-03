<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcernReport extends Model
{
    protected $fillable = [
        'reference_code', 'submitted_by', 'assigned_to', 'category', 'what_happened',
        'where_happened', 'happened_at', 'people_involved', 'additional_details',
        'attachment_path', 'status', 'is_anonymous',
    ];

    protected $hidden = [
        'submitted_by', 'assigned_to', 'what_happened', 'where_happened', 'happened_at',
        'people_involved', 'additional_details', 'attachment_path', 'is_anonymous',
    ];

    protected function casts(): array
    {
        return ['happened_at' => 'datetime', 'is_anonymous' => 'boolean'];
    }

    public function notes()
    {
        return $this->hasMany(ReportNote::class);
    }
}