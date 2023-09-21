<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Crm\EmployeeAssignDetails;

class EmployeeAssign extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function details(){
        return $this->hasMany(EmployeeAssignDetails::class,'employee_assign_id','id');
    }

}
