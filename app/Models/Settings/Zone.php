<?php

namespace App\Models\Settings;

use App\Models\Crm\CustomerBrance;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    /*public function customer(){
        return $this->hasMany(Customer::class,'zone_id','id')->with('invPayment');
    }*/
    public function customers()
    {
        return $this->hasMany(Customer::class, 'zone_id', 'id');
    }
    public function branch()
    {
        return $this->hasMany(CustomerBrance::class, 'zone_id', 'id');
    }
}
