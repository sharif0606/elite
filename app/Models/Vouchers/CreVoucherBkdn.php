<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreVoucherBkdn extends Model
{
    use HasFactory;

    public function gl()
    {
        return $this->hasOne(GeneralLedger::class, 'crvoucher_bkdn_id', 'id');
    }
}
