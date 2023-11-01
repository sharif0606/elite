<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\CustomerRate;

class Customer extends Model
{
    use HasFactory;
    public function branch(){
        return $this->hasMany(CustomerBrance::class,'customer_id','id');
    }
    public function customerRate(){
        return $this->hasMany(CustomerRate::class,'customer_id','id');
    }
}
