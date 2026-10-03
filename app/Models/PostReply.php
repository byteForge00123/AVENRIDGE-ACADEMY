<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReply extends Model
{
    protected $fillable = ['post_id', 'user_id', 'body', 'status'];

    protected $hidden = ['user_id'];
}