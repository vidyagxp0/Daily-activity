<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TNIMatrixData extends Model
{
    use HasFactory;
    protected $table= 't_n_i_matrixdatas';

    protected $fillable = [
        'tni_id',
        'division',
        'training_effective',
        'attempt_count',
        'training_completion',
        'documentNumber',
        'designation',
        'department',
        'employee',
        'startDate',
        'endDate'
    ];
}
