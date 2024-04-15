<?php

namespace App\Models\payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class LongLoan extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
