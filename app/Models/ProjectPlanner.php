<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPlanner extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'milestone', 'functionality', 'start_date', 'end_date', 'no_of_days', 'remarks', 'supporting_document'];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

