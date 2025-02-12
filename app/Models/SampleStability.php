<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleStability extends Model
{
    use HasFactory;


    protected $casts = [
        'specification_attachment' => 'array',
        'suupportive_attachment_gi' => 'array',
        'supportive_attachment' => 'array',
        'supportiveAttachment' => 'array',
        'supportiveAttachmentsss' => 'array',
        'qa_supportive_attachment' => 'array',
        'stp_attachment' => 'array',
        'analysis_attachment' => 'array',

    ];

   
    public function division(){
        return $this->belongsTo(QMSDivision::class);
    }

    public function initiator()
    {
        return $this->belongsTo(User::class,'id');
    }
    
}
