<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlSampleGrid extends Model
{
    use HasFactory;
    protected $table = 'control_sample_grids';

    protected $fillable = ['control_samples_id','identifier', 'data'];

    protected $casts = ['data' => 'array'];
    
}
