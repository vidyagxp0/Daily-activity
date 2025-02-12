<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class extension_new extends Model
{
    use HasFactory;
    protected $table = 'extension_news';


    public function division()
    {
        return $this->belongsTo(QMSDivision::class,'site_location_code');
    }
    public function initiator()
    {
        return $this->belongsTo(User::class,'initiator');
    }
}

