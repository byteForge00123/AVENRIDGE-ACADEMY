<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['name', 'slug', 'level', 'summary', 'description', 'subjects', 'sort_order'];

    protected function casts(): array
    {
        return ['subjects' => 'array'];
    }
}