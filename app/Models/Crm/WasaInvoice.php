<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\WasaInvoiceDetails;

class WasaInvoice extends Model
{
    use HasFactory;
    public function wasadetails(){
        return $this->hasMany(WasaInvoiceDetails::class,'wasa_invoice_id','id');
    }
}
