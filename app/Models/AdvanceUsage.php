<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Advance;
use App\Models\Customer;
use App\Models\Crm\InvoicePayment;
use App\Models\Crm\CustomerBrance;

class AdvanceUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'advance_id',
        'invoice_payment_id',
        'customer_id',
        'branch_id',
        'used_amount',
        'remarks',
        'created_by'
    ];

    /**
     * Get the advance that was used
     */
    public function advance()
    {
        return $this->belongsTo(Advance::class, 'advance_id', 'id');
    }

    /**
     * Get the invoice payment this advance was applied to
     */
    public function invoicePayment()
    {
        return $this->belongsTo(InvoicePayment::class, 'invoice_payment_id', 'id');
    }

    /**
     * Get the customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the branch
     */
    public function branch()
    {
        return $this->belongsTo(CustomerBrance::class, 'branch_id', 'id');
    }
}
