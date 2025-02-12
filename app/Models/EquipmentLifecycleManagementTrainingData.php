<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentLifecycleManagementTrainingData extends Model
{
    use HasFactory;

    protected $table = "equipment_lifecycle_management_training_data";
    protected $fillable = [
       'equipmentInfo_id', 'trainingTopic', 'documentNumber', 'documentName', 'sopType', 'trainingType', 'trainees','per_screen_run_time', 'total_minimum_time',
        'startDate', 'endDate', 'trainer', 'trainingAttempt'
    ];
}
