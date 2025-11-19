<?php
// Check latest invoice payments with advance
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Crm\InvoicePayment;

echo "=== Latest Invoice Payments ===\n\n";

$payments = InvoicePayment::with('invoice')
    ->orderBy('id', 'DESC')
    ->limit(5)
    ->get();

foreach ($payments as $payment) {
    echo "Payment ID: " . $payment->id . "\n";
    echo "  Invoice ID: " . $payment->invoice_id . "\n";
    echo "  Customer ID: " . $payment->customer_id . "\n";
    echo "  Received Amount (Cash): " . $payment->received_amount . "\n";
    echo "  Advance Adjusted: " . $payment->advance_adjusted . "\n";
    echo "  VAT Amount: " . $payment->vat_amount . "\n";
    echo "  Pay Date: " . $payment->pay_date . "\n";
    if ($payment->invoice) {
        echo "  Invoice Grand Total: " . $payment->invoice->grand_total . "\n";
    }
    echo "  ---\n";
}

echo "\n=== Payments with Advance > 0 ===\n";
$advancePayments = InvoicePayment::where('advance_adjusted', '>', 0)
    ->with('invoice')
    ->orderBy('id', 'DESC')
    ->limit(3)
    ->get();

foreach ($advancePayments as $payment) {
    echo "Payment ID: " . $payment->id . "\n";
    echo "  Invoice ID: " . $payment->invoice_id . "\n";
    echo "  Advance Adjusted: " . $payment->advance_adjusted . "\n";
    if ($payment->invoice) {
        echo "  Invoice Grand Total: " . $payment->invoice->grand_total . "\n";
        
        // Calculate due
        $allPayments = InvoicePayment::where('invoice_id', $payment->invoice_id)->get();
        $totalPaid = $allPayments->sum('received_amount') + 
                     $allPayments->sum('advance_adjusted') + 
                     $allPayments->sum('vat_amount') + 
                     $allPayments->sum('ait_amount') + 
                     $allPayments->sum('fine_deduction') + 
                     $allPayments->sum('paid_by_client') + 
                     $allPayments->sum('less_paid_honor');
        
        $due = $payment->invoice->grand_total - $totalPaid;
        echo "  Total Paid: " . $totalPaid . "\n";
        echo "  Due: " . $due . "\n";
    }
    echo "  ---\n";
}

