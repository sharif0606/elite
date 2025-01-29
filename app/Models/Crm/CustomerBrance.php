<?php

namespace App\Models\Crm;

use App\Models\Settings\Zone;
use App\Models\Crm\Atm;
use App\Models\Hrm\SalarySheetDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBrance extends Model
{
    use HasFactory;
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
    public function atms()
    {
        return $this->hasMany(Atm::class, 'branch_id', 'id');
    }
    // Define the inverse relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
