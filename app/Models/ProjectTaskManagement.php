<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTaskManagement extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'project_task_management';

    protected $fillable = ['identifier', 'data'];

    // Automatically cast `data` to array
    protected $casts = [
        'data' => 'array',
    ];

}

