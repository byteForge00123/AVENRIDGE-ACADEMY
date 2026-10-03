<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $table = 'news';

    protected $fillable = ['title', 'slug', 'category', 'excerpt', 'body', 'image_url', 'is_featured', 'published_at'];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'published_at' => 'datetime'];
    }
}