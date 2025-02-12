<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamplePlaningGrid extends Model
{
    use HasFactory;
    protected $table = 'sample_planing_grids';

    protected $fillable = ['planning_id','identifier', 'data'];

    protected $casts = ['data' => 'array'];
}
