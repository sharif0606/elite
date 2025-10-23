<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Advance extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(\App\Models\Crm\InvoiceGenerate::class, 'invoice_id', 'id');
    }
}
