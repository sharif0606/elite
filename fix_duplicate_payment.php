<?php
// Fix duplicate payment for invoice 4687
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Crm\InvoicePayment;
use App\Models\AdvanceUsage;
use App\Models\Advance;
use Illuminate\Support\Facades\DB;

echo "=== Fixing Duplicate Payment ===\n\n";

DB::beginTransaction();

try {
    // Get both duplicate payments
    $payment3643 = InvoicePayment::find(3643);
    $payment3642 = InvoicePayment::find(3642);
    
    if (!$payment3643 || !$payment3642) {
        echo "Payment records not found!\n";
        exit;
    }
    
    echo "Payment 3643: Advance = " . $payment3643->advance_adjusted . "\n";
    echo "Payment 3642: Advance = " . $payment3642->advance_adjusted . "\n\n";
    
    // Get advance usages for the duplicate payment (3642 - older one)
    $advanceUsages = AdvanceUsage::where('invoice_payment_id', 3642)->get();
    
    echo "Found " . $advanceUsages->count() . " advance usage records for payment 3642\n\n";
    
    // Restore the advances
    foreach ($advanceUsages as $usage) {
        $advance = Advance::find($usage->advance_id);
        if ($advance) {
            echo "Restoring Advance ID " . $advance->id . ":\n";
            echo "  Current Used: " . $advance->used_amount . "\n";
            echo "  Restoring: " . $usage->used_amount . "\n";
            
            $advance->used_amount -= $usage->used_amount;
            $advance->remaining_amount = $advance->amount - $advance->used_amount;
            $advance->save();
            
            echo "  New Used: " . $advance->used_amount . "\n";
            echo "  New Remaining: " . $advance->remaining_amount . "\n\n";
        }
        
        // Delete the usage record
        $usage->delete();
    }
    
    // Delete the duplicate payment
    echo "Deleting duplicate payment 3642...\n";
    $payment3642->delete();
    
    DB::commit();
    
    echo "\n✅ SUCCESS! Duplicate payment removed and advances restored.\n\n";
    
    // Verify
    echo "=== Verification ===\n";
    $remaining = InvoicePayment::where('invoice_id', 4687)->get();
    echo "Remaining payments for invoice 4687: " . $remaining->count() . "\n";
    echo "Total advance adjusted: " . $remaining->sum('advance_adjusted') . "\n";
    
    $invoice = \App\Models\Crm\InvoiceGenerate::find(4687);
    if ($invoice) {
        $totalPaid = $remaining->sum('received_amount') + 
                     $remaining->sum('advance_adjusted') + 
                     $remaining->sum('vat_amount') + 
                     $remaining->sum('ait_amount') + 
                     $remaining->sum('fine_deduction') + 
                     $remaining->sum('paid_by_client') + 
                     $remaining->sum('less_paid_honor');
        
        $due = $invoice->grand_total - $totalPaid;
        echo "Invoice Grand Total: " . $invoice->grand_total . "\n";
        echo "Total Paid: " . $totalPaid . "\n";
        echo "Due: " . $due . "\n";
    }
    
} catch (Exception $e) {
    DB::rollBack();
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

