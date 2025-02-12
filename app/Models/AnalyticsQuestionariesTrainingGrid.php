<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsQuestionariesTrainingGrid extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_qualification_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
