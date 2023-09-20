<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Crm\EmployeeRateDetails;

class EmployeeRate extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function details(){
        return $this->hasMany(EmployeeRateDetails::class,'employee_rate_id','id');
    }
}
