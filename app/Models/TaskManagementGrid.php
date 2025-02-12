<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManagementGrid extends Model
{
    use HasFactory;
    
    protected $fillable = ['task_management_id','type','identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
