<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeControlTrainingData extends Model
{
    use HasFactory;
    protected $table = "change_control_training_datas";
    protected $fillable = [
       'cc_id', 'trainingTopic', 'documentNumber', 'documentName', 'sopType', 'trainingType', 'trainees','per_screen_run_time', 'total_minimum_time',
        'startDate', 'endDate', 'trainer', 'trainingAttempt'
    ];
}

