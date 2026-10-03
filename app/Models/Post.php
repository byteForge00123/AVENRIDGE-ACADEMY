<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'category', 'title', 'body', 'status', 'is_anonymous', 'attachment_path'];

    protected $hidden = ['user_id'];

    protected function casts(): array
    {
        return ['is_anonymous' => 'boolean'];
    }

    public function approvedReplies()
    {
        return $this->hasMany(PostReply::class)->where('status', 'approved');
    }

    public function reports()
    {
        return $this->hasMany(PostReport::class);
    }

    public function replies()
    {
        return $this->hasMany(PostReply::class);
    }
}