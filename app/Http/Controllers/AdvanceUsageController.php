<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdvanceUsage;
use App\Models\Customer;
use App\Models\Advance;

class AdvanceUsageController extends Controller
{
    /**
     * Display advance usage history
     */
    public function index(Request $request)
    {
        $query = AdvanceUsage::with([
            'advance.branch',
            'advance.atm',
            'invoicePayment.invoice',
            'customer'
        ]);

        // Filter by customer
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->fdate && $request->tdate) {
            $query->whereBetween('created_at', [$request->fdate, $request->tdate]);
        }

        // Filter by advance ID
        if ($request->advance_id) {
            $query->where('advance_id', $request->advance_id);
        }

        $usages = $query->orderBy('created_at', 'DESC')->paginate(20);
        
        $customers = Customer::all();

        // Get summary statistics
        $totalUsed = AdvanceUsage::sum('used_amount');
        $totalTransactions = AdvanceUsage::count();
        
        return view('advance_usage.index', compact('usages', 'customers', 'totalUsed', 'totalTransactions'));
    }

    /**
     * Show detailed report for a specific advance
     */
    public function showAdvanceDetail($id)
    {
        $advanceId = encryptor('decrypt', $id);
        
        $advance = Advance::with(['usages.invoicePayment.invoice', 'customer', 'branch', 'atm'])
            ->findOrFail($advanceId);
        
        return view('advance_usage.detail', compact('advance'));
    }
}
