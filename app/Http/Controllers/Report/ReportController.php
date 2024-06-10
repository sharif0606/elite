<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Settings\Zone;
use Illuminate\Http\Request;
use App\Models\Crm\InvoicePayment;
use App\Models\Customer;

class ReportController extends Controller
{
    public function invoicePayment()
    {
        $zones=Zone::with('customer')->orderBy('name','ASC')->paginate(2);
        return view('report.invoice-payment',compact('zones'));
    }

    public function invoiceDue(Request $request)
    {
        $customer=Customer::all();
        $invoice=InvoiceGenerate::with('payment','customer','branch')->orderBy('id','DESC');

        if ($request->fdate && $request->tdate){
            $startDate = $request->fdate;
            $endDate = $request->tdate;

            $invoice->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('invoice_generates.start_date', '>=',$startDate )
                        ->whereDate('invoice_generates.end_date', '<=', $endDate);
                });
            });
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $invoice->where('invoice_generates.customer_id', $customerId);
        }
        if ($request->bill_date){
            $billDate = $request->bill_date;
            $invoice->where('invoice_generates.bill_date', $billDate);
        }
        $invoice = $invoice->get();
        return view('report.invoice-due',compact('invoice','customer'));
    }
}
