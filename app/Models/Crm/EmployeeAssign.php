<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Crm\EmployeeAssignDetails;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;

class EmployeeAssign extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function details(){
        return $this->hasMany(EmployeeAssignDetails::class,'employee_assign_id','id');
    }
    public function atms(){
        return $this->belongsTo(Atm::class,'atm_id','id');
    }
    public function branch(){
        return $this->belongsTo(CustomerBrance::class,'branch_id','id');
    }

}
