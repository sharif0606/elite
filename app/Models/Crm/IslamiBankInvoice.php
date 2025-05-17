<?php

namespace App\Models\Crm;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IslamiBankInvoice extends Model
{
    use HasFactory;

    function details()
    {
        return $this->hasMany(IslamiBankInvoiceDetails::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(CustomerBrance::class, 'company_branch_id');
    }

    public function atm()
    {
        return $this->belongsTo(Atm::class);
    }
}