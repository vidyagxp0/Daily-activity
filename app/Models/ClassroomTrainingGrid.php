<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomTrainingGrid extends Model
{
    use HasFactory;

    protected $fillable = ['jobTraining_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
