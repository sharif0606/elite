<?php

namespace App\Models\Crm;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouthBanglaInvoice extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function atms(){
        return $this->belongsTo(Atm::class,'atm_id','id');
    }
    public function branch(){
        return $this->belongsTo(CustomerBrance::class,'branch_id','id');
    }
    public function details(){
        return $this->hasMany(SouthBanglaInvoiceDetails::class,'south_bangla_invoice_id','id');
    }
}
