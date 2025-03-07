<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekendDays extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'weekend_days','year'];

    protected $casts = [
        'weekend_days' => 'array',
    ];
}
