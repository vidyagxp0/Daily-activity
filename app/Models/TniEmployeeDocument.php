<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TniEmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'employee_code',
        'department',
        'designation',
        'job_role',
        'joining_date',
        'document_number',
        'document_title',
        'startdate',
        'enddate',
        'total_minimum_time', 'per_screen_run_time',
    ];
}
