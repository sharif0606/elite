<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditVoucher extends Model
{
    use HasFactory;

    public function bkdn()
    {
        return $this->hasMany(CreVoucherBkdn::class, 'credit_voucher_id', 'id');
    }
}
