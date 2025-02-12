<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentWiseEmployees extends Model
{
    use HasFactory;

    protected $casts = [
        'document_number' => 'array',
    ];

    public function documentNumbers()
    {
        return $this->hasMany(DocumentNumbers::class, 'department_employee_id');
    }
}
