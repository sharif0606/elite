<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitVoucher extends Model
{
    use HasFactory;
    public function bkdn()
    {
        return $this->hasMany(DevoucherBkdn::class, 'debit_voucher_id', 'id');
    }
    
}
