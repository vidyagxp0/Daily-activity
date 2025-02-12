<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeControlTraining extends Model
{
    use HasFactory;
    protected $table = 'change_control_trainings';
    protected $fillable = ['cc_id','identifier', 'data'];
    protected $casts = ['data' => 'array'];
}
