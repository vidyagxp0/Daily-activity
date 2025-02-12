<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentDocumentNumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_employee_id', 'location', 'Prepared_by', 'Prepared_date', 'reviewer',
        'approver', 'start_date', 'end_date', 'department', 'document_number', 
        'year', 'employee_name', 'employee_code', 'job_role', 'status', 'stage'
    ];

    public function departmentWiseEmployee()
    {
        return $this->belongsTo(DepartmentWiseEmployees::class, 'department_employee_id');
    }
}
