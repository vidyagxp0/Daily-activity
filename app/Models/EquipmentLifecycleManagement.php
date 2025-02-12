<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentLifecycleManagement extends Model
{
    use HasFactory;

    protected $table = 'equipment_lifecycle_information';

    // protected $fillable = [
    //     ''
    // ]

    public function division()
    {
        return $this->belongsTo(QMSDivision::class,'division_id');
    }
    public function initiator()
    {
        return $this->belongsTo(User::class,'initiator_id');
    }
}
