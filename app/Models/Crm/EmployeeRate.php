<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

use App\Models\Crm\EmployeeRateDetails;

class EmployeeRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'branch_id',
        'atm_id',
        'status',
    ];
    
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function customer_branch(){
        return $this->belongsTo(CustomerBrance::class,'branch_id','id');
    }

    public function details(){
        return $this->hasMany(EmployeeRateDetails::class,'employee_rate_id','id');
    }

}
