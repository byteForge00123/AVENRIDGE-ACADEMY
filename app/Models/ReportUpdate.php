<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportUpdate extends Model
{
    protected $fillable = ['concern_report_id', 'created_by', 'status', 'public_message'];
}