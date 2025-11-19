<?php
// Quick diagnostic script to check invoice #14 payments
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoicePayment;

echo "=== Checking Invoice #14 ===\n\n";

// Get invoice
$invoice = InvoiceGenerate::find(14);
if ($invoice) {
    echo "Invoice ID: " . $invoice->id . "\n";
    echo "Grand Total: " . $invoice->grand_total . "\n";
    echo "Customer ID: " . $invoice->customer_id . "\n\n";
} else {
    echo "Invoice #14 not found!\n";
    exit;
}

// Get payments
echo "=== Payments for Invoice #14 ===\n";
$payments = InvoicePayment::where('invoice_id', 14)->get();

if ($payments->count() > 0) {
    echo "Number of payments: " . $payments->count() . "\n\n";
    
    foreach ($payments as $payment) {
        echo "Payment ID: " . $payment->id . "\n";
        echo "  Received Amount (Cash): " . $payment->received_amount . "\n";
        echo "  Advance Adjusted: " . $payment->advance_adjusted . "\n";
        echo "  VAT Amount: " . $payment->vat_amount . "\n";
        echo "  AIT Amount: " . $payment->ait_amount . "\n";
        echo "  Fine Deduction: " . $payment->fine_deduction . "\n";
        echo "  Paid by Client: " . $payment->paid_by_client . "\n";
        echo "  Less Paid Honor: " . $payment->less_paid_honor . "\n";
        echo "  Pay Date: " . $payment->pay_date . "\n";
        echo "  Created At: " . $payment->created_at . "\n";
        echo "  ---\n";
    }
    
    echo "\n=== Summary ===\n";
    echo "Total Cash Received: " . $payments->sum('received_amount') . "\n";
    echo "Total Advance Used: " . $payments->sum('advance_adjusted') . "\n";
    echo "Total VAT: " . $payments->sum('vat_amount') . "\n";
    echo "Total AIT: " . $payments->sum('ait_amount') . "\n";
    echo "Total Fine: " . $payments->sum('fine_deduction') . "\n";
    echo "Total Paid by Client: " . $payments->sum('paid_by_client') . "\n";
    echo "Total Discount: " . $payments->sum('less_paid_honor') . "\n";
    
    $totalPaid = $payments->sum('received_amount') + 
                 $payments->sum('advance_adjusted') + 
                 $payments->sum('vat_amount') + 
                 $payments->sum('ait_amount') + 
                 $payments->sum('fine_deduction') + 
                 $payments->sum('paid_by_client') + 
                 $payments->sum('less_paid_honor');
    
    echo "\nTotal Paid: " . $totalPaid . "\n";
    echo "Due: " . ($invoice->grand_total - $totalPaid) . "\n";
} else {
    echo "No payments found for invoice #14\n";
}

echo "\n=== Advance Usage Records ===\n";
$advanceUsages = \App\Models\AdvanceUsage::whereHas('invoicePayment', function($query) {
    $query->where('invoice_id', 14);
})->with('advance')->get();

if ($advanceUsages->count() > 0) {
    foreach ($advanceUsages as $usage) {
        echo "Advance Usage ID: " . $usage->id . "\n";
        echo "  Advance ID: " . $usage->advance_id . "\n";
        echo "  Used Amount: " . $usage->used_amount . "\n";
        echo "  Payment ID: " . $usage->invoice_payment_id . "\n";
        if ($usage->advance) {
            echo "  Original Advance Amount: " . $usage->advance->amount . "\n";
            echo "  Advance Remaining: " . $usage->advance->remaining_amount . "\n";
        }
        echo "  ---\n";
    }
} else {
    echo "No advance usage records found\n";
}

