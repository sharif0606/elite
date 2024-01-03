<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\OnetripInvoiceDetails;

class OnetripInvoice extends Model
{
    use HasFactory;
    public function onetripdetails(){
        return $this->hasMany(OnetripInvoiceDetails::class,'ontrip_id','id');
    }
}
