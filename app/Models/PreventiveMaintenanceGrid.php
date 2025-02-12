<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenanceGrid extends Model
{
    use HasFactory;

    protected $fillable = ['preventive_maintenance_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
