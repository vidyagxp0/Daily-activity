<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationManagementGrid extends Model
{
    use HasFactory;
    protected $fillable = ['callibration_details_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
