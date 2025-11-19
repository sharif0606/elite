<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\AdvanceUsage;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'branch_id',
        'zone_id',
        'invoice_id',
        'received_amount',
        'advance_adjusted',
        'vat',
        'vat_amount',
        'ait',
        'ait_amount',
        'fine_deduction',
        'paid_by_client',
        'less_paid_honor',
        'less_paid',
        'deposit_bank',
        'payment_type',
        'bank_name',
        'po_no',
        'po_date',
        'deposit_date',
        'rcv_date',
        'pay_date',
        'remarks'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function invoice(){
        return $this->belongsTo(InvoiceGenerate::class,'invoice_id','id');
    }

    /**
     * Get all advance usage records for this payment
     */
    public function advanceUsages()
    {
        return $this->hasMany(AdvanceUsage::class, 'invoice_payment_id', 'id');
    }
}
