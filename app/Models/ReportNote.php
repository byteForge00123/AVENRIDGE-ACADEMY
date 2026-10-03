<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportNote extends Model
{
    protected $fillable = ['concern_report_id', 'created_by', 'note'];
}