<?php

namespace App\Models\Hrm;

use App\Models\Crm\CustomerBrance;
use App\Models\Customer;
use App\Models\Crm\Atm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\JobPost;

class SalarySheetDetail extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function position()
    {
        return $this->belongsTo(JobPost::class, 'designation_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function branches()
    {
        return $this->belongsTo(CustomerBrance::class, 'branch_id', 'id');
    }
    public function salarySheet()
    {
        return $this->belongsTo(SalarySheet::class, 'salary_id');
    }
    public function customer_atm()
    {
        return $this->belongsTo(Atm::class, 'atm_id', 'id');
    }
}
