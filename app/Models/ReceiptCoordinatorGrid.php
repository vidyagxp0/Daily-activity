<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCoordinatorGrid extends Model
{
    use HasFactory;

    protected $fillable = ['receipt_coordinator_id', 'identifier', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
