<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryManagementGrid extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_management_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
