<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    protected $table = 'events';

    protected $fillable = ['title', 'category', 'venue', 'description', 'starts_at', 'ends_at', 'image_url'];

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }
}