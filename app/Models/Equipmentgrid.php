<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipmentgrid extends Model
{
    use HasFactory;

    protected $table='equipmentgrid';
    use HasFactory;
protected $fillable = [
    'eq_id',
    'identifier',
    'data'
    ];

    protected $casts = [
        'data' => 'array'
        // 'aainfo_product_name' => 'array',
           ];

}
