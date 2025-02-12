<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EHSEnvironmentTrainingData extends Model
{
    use HasFactory;
    protected $table = "e_h_s_environment_training_data";
    protected $fillable = [
       'ehsEvent_id', 'trainingTopic', 'documentNumber', 'documentName', 'sopType', 'trainingType', 'trainees','per_screen_run_time', 'total_minimum_time',
        'startDate', 'endDate', 'trainer', 'trainingAttempt'
    ];
}
