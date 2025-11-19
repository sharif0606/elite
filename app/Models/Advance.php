<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use App\Models\AdvanceUsage;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'branch_id',
        'atm_id',
        'amount',
        'used_amount',
        'remaining_amount',
        'taken_date',
        'created_by',
        'updated_by'
    ];

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

    /**
     * Get all usage records for this advance
     */
    public function usages()
    {
        return $this->hasMany(AdvanceUsage::class, 'advance_id', 'id');
    }

    /**
     * Calculate and return the remaining/available balance
     */
    public function getAvailableBalanceAttribute()
    {
        return $this->amount - $this->used_amount;
    }

    /**
     * Get total available advance for a customer (optionally filtered by branch)
     */
    public static function getAvailableAdvance($customerId, $branchId = null)
    {
        $query = self::where('customer_id', $customerId);
        
        if ($branchId !== null && $branchId != 0) {
            $query->where('branch_id', $branchId);
        }

        $advances = $query->get();
        
        $totalAdvance = $advances->sum('amount');
        $totalUsed = $advances->sum('used_amount');
        $totalAvailable = $totalAdvance - $totalUsed;

        return [
            'total_advance' => $totalAdvance,
            'total_used' => $totalUsed,
            'total_available' => $totalAvailable,
            'advances' => $advances
        ];
    }
}
