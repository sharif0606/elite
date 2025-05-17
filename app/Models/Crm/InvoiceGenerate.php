<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\InvoiceGenerateLess;
use App\Models\Crm\CustomerBrance;

class InvoiceGenerate extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    // InvoiceGenerate Model
    public function invoiceGenerateDetails()
    {
        return $this->hasMany(InvoiceGenerateDetails::class, 'invoice_id', 'id');
    }
    public function payment()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(CustomerBrance::class, 'branch_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(InvoiceGenerateDetails::class, 'invoice_id', 'id');
    }
    public function detail()
    {
        return $this->hasOne(InvoiceGenerateDetails::class, 'invoice_id', 'id');
    }
    public function less()
    {
        return $this->hasMany(InvoiceGenerateLess::class, 'invoice_id', 'id');
    }
    public function port_link(){
        return $this->hasOne(PortlinkInvoice::class, 'invoice_id', 'id');
    }
    public function atm()
    {
        return $this->belongsTo(Atm::class);
    }
}