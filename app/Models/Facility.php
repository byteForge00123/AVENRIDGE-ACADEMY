<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'description', 'image_url', 'sort_order'];
}