<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPlanner extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'company_name',
        'year',
        'description',
        'comments',
        'supporting_document',
        'project_details',
    ];
    

    protected $casts = [
        'project_details' => 'array',
    ];
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

