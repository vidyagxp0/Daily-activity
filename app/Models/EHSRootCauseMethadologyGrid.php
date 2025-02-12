<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EHSRootCauseMethadologyGrid extends Model
{
    use HasFactory;
    protected $fillable = [
        'ehsEvent_id',       
    ];
    protected $casts = ['data1' => 'array'];

}
