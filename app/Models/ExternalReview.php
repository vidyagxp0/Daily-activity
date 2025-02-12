<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalReview extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'external_review_attachment', 'external_review_comment'];
    public function changeControlRecord()
    {
        return $this->belongsTo(CC::class);
    }
}
