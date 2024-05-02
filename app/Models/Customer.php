<?php

namespace App\Models;

use App\Models\Crm\InvoicePayment;
use App\Models\Settings\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\CustomerRate;
use DB;
class Customer extends Model
{
    use HasFactory;
    public function branch(){
        return $this->hasMany(CustomerBrance::class,'customer_id','id');
    }
    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id','id');
    }
    public function invPayment(){
        return $this->hasMany(InvoicePayment::class,'customer_id','id');
    }
    public function customerRate(){
        return $this->hasMany(CustomerRate::class,'customer_id','id');
    }
}
