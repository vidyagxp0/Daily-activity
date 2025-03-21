<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CompanyHoliday extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'start_date', 'end_date', 'reason'];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

