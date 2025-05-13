<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Crm\CustomerDutyDetail;

class CustomerDuty extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function customer_branch(){
        return $this->belongsTo(CustomerBrance::class,'branch_id','id');
    }
    public function customer_atm(){
        return $this->belongsTo(Atm::class,'atm_id','id');
    }

    public function details(){
        return $this->hasMany(CustomerDutyDetail::class,'customerduty_id','id');
    }
}
