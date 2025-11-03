<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
class Advance extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(CustomerBrance::class, 'branch_id', 'id');
    }
     public function atm()
    {
        return $this->belongsTo(Atm::class, 'atm_id', 'id');
    }
}
