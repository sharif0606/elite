<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortlinkInvoice extends Model
{
    use HasFactory;
    public function details()
    {
        return $this->hasMany(PortlinkInvoiceDetails::class);
    }

    public function less_details()
    {
        return $this->hasMany(PortlinkInvoiceLess::class, 'invoice_id', 'id');
    }
    public function deduction_sup(){
        return $this->hasMany(PortlinkDeductionSupervisor::class, 'invoice_id', 'id');
    }
    public function deduction_guard(){
        return $this->hasMany(PortlinkDeductionGuard::class, 'invoice_id', 'id');
    }
}
