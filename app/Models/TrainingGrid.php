<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingGrid extends Model
{
    use HasFactory;
    protected $fillable = ['cc_id','identifier', 'data'];
    protected $casts = ['data' => 'array'];
}
