<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Settings\Zone;
use Illuminate\Http\Request;
use App\Models\Crm\InvoicePayment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

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
    public function paymentReceive(Request $request){
        $customer=Customer::all();
        $zone=Zone::all();
        $data = InvoicePayment::select('invoice_payments.*', 'customers.id as customer_id', 'customers.zone_id as zone_id','customers.customer_type as customer_type')
        ->leftJoin('customers','invoice_payments.customer_id','=','customers.id')
        ->join(
            DB::raw('(SELECT MAX(id) as id FROM invoice_payments GROUP BY customer_id) as latest'),
            'invoice_payments.id',
            '=',
            'latest.id'
        );
        if ($request->customer_type){
            $data->where('customers.customer_type', $request->customer_type);
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $data->where('invoice_payments.customer_id', $customerId);
        }
        if ($request->zone_id){
            $zoneId = $request->zone_id;
            $data->where('customers.zone_id', $zoneId);
        }
        $data = $data->get();
        return view('report.pay-received',compact('data','customer','zone'));
    }
    public function paymentReceiveDetails(Request $request, $id){
        $customer=Customer::where('id',$id)->first();
        $data = InvoicePayment::where('customer_id',$id);

        if ($request->pay_date){
            $data->where('invoice_payments.pay_date', $request->pay_date);
        }
        if ($request->rec_date){
            $data->where('invoice_payments.rcv_date', $request->rec_date);
        }
        if ($request->deposit_date){
            $data->where('invoice_payments.deposit_date', $request->deposit_date);
        }
        if ($request->po_date){
            $data->where('invoice_payments.po_date', $request->po_date);
        }
        if ($request->po_date){
            $data->where('invoice_payments.po_date', $request->po_date);
        }
        if ($request->po_no){
            $data->where('invoice_payments.po_no', $request->po_no);
        }
        if($request->bank_name)
            $data=$data->where('bank_name','like','%'.$request->bank_name.'%');

        if ($request->payment_type){
            $data->where('invoice_payments.payment_type', $request->payment_type);
        }
        $data = $data->get();
        return view('report.pay-received-detail',compact('data','customer'));
    }
}
