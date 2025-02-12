<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleStability_Grid extends Model
{
    use HasFactory;

    protected $table = 'sample_stability__grids';
    protected $fillable = ['ssgrid_id','identifier', 'data'];

    protected $casts = ['data' => 'array'];

    public function SampleStability()
    {
        return $this->hasMany(SampleStability::class);
    }
}
