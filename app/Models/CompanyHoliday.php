<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CompanyHoliday extends Model
{
    use HasFactory;
    
    protected $fillable = ['company_id', 'holiday_date'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Ensure only holidays of the current year are stored
    public static function boot()
    {
        parent::boot();

        static::creating(function ($holiday) {
            if (Carbon::parse($holiday->holiday_date)->year !== Carbon::now()->year) {
                throw new \Exception('Holiday must be in the current year');
            }
        });
    }
}

