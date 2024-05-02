<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class InvoicePayment extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

}
