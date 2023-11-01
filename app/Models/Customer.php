<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\CustomerBrance;

class Customer extends Model
{
    use HasFactory;
    public function branch(){
        return $this->hasMany(CustomerBrance::class,'customer_id','id');
    }
}
