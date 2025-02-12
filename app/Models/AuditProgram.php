<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditProgram extends Model
{
    use HasFactory;

    public function  division(){
        return $this->belongsTo(QMSDivision::class);
    }
    public function initiator(){
        return $this->belongsTo(User::class);
    }
}
