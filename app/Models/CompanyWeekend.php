<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyWeekend extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'weekend_days', 'year'];
    protected $casts = ['weekend_days' => 'array'];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
