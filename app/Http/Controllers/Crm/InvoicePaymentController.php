<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Crm\InvoicePayment;

use Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class InvoicePaymentController extends Controller
{

    public function index(Request $request)
    {
        $payments=InvoicePayment::with('customer','invoice');
        if($request->customer_id){
            $payments=$payments->where('customer_id',$request->customer_id);
        }
        if($request->payment_type){
            $payments=$payments->where('payment_type',$request->payment_type);
        }
        if($request->po_no){
            $payments=$payments->where('po_no',$request->po_no);
        }
        if($request->po_date){
            $payments=$payments->where('po_date',$request->po_date);
        }
        if($request->pay_date){
            $payments=$payments->where('pay_date',$request->pay_date);
        }
        // if($request->rcv_date){
        //     $payments=$payments->where('rcv_date',$request->rcv_date);
        // }
        // if($request->deposit_date){
        //     $payments=$payments->where('deposit_date',$request->deposit_date);
        // }
        if ($request->fdate && $request->tdate) {
            $startDate = $request->fdate;
            $endDate = $request->tdate;
            $payments->whereHas('invoice', function ($query) use ($startDate, $endDate) {
                $query->whereDate('bill_date', '>=', $startDate)
                      ->whereDate('bill_date', '<=', $endDate);
            });
        }
        
        $payments=$payments->orderBy('id','DESC')->paginate(15);
        $customer=Customer::all();
        return view('invoice_payment.index',compact('payments','customer'));
    }

    public function create()
    {
        $customer=Customer::all();
        return view('invoice_payment.create',compact('customer'));
    }

    public function checkPoNumber(Request $request){
        try {
            $customer = $request->customer_id;
            $invoice = $request->invId;
            $poNumber = $request->po_no;

            $data = InvoicePayment::join('invoice_generates', 'invoice_generates.id', '=', 'invoice_payments.invoice_id')
                ->where('invoice_payments.po_no', $poNumber)
                ->leftJoin('customers','customers.id','=','invoice_payments.customer_id')
                ->leftJoin('customer_brances','invoice_generates.branch_id','=','customer_brances.id')
                ->select('invoice_payments.po_no as po_number','invoice_payments.received_amount as receive','customers.name as customer_name','customer_brances.brance_name as customer_branch')
                ->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $data=new InvoicePayment;
            $data->customer_id = $request->customer_id;
            $data->invoice_id = $request->invId;
            $data->received_amount = $request->received_amount;
            $data->vat = $request->vat;
            $data->vat_amount = $request->vat_amount;
            $data->ait = $request->ait;
            $data->ait_amount = $request->ait_amount;
            $data->fine_deduction = $request->fine_deduction;
            $data->paid_by_client = $request->paid_by_client;
            $data->less_paid_honor = $request->less_paid_honor;
            $data->less_paid = $request->less_paid;
            $data->deposit_bank = $request->deposit_bank;
            $data->payment_type = $request->payment_type;
            $data->bank_name = $request->bank_name;
            $data->zone_id = $request->zone_id;
            $data->po_no = $request->po_no;
            $data->po_date = $request->po_date;
            $data->pay_date = $request->pay_date;
            $data->rcv_date = $request->rcv_date;
            $data->deposit_date = $request->deposit_date;
            $data->remarks = $request->remarks;
            $data->save();
            \LogActivity::addToLog('InvoicePayment',$request->getContent(),'InvoicePayment');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser(),'customer_id' => $data->customer_id])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function show(Request $request,$id)
    {
    }
   
    public function edit($id)
    {
        $ivp=InvoicePayment::findOrFail(encryptor('decrypt',$id));
        $totalPaid = InvoicePayment::select(
            DB::raw("SUM(received_amount) as received_amount"),
            DB::raw("SUM(vat_amount) as vat_amount"),
            DB::raw("SUM(ait_amount) as ait_amount"),
            DB::raw("SUM(fine_deduction) as fine_deduction"),
            DB::raw("SUM(paid_by_client) as paid_by_client"),
            DB::raw("SUM(less_paid_honor) as less_paid_honor"),
            DB::raw("SUM(received_amount) + SUM(vat_amount) + SUM(ait_amount) + SUM(fine_deduction) + SUM(paid_by_client) + SUM(less_paid_honor) as total_sum")
        )
        ->where("invoice_id", $ivp->invoice_id)->first();
        $paidFromThisId = $ivp->received_amount + $ivp->vat_amount + $ivp->ait_amount + $ivp->fine_deduction + $ivp->paid_by_client + $ivp->less_paid_honor;

        return view('invoice_payment.edit',compact('ivp','paidFromThisId','totalPaid'));
    }

    public function update(Request $request, $id)
    {
        try{
            $data=InvoicePayment::findOrFail(encryptor('decrypt',$id));
            $data->received_amount = $request->received_amount;
            $data->vat = $request->vat;
            $data->vat_amount = $request->vat_amount;
            $data->ait = $request->ait;
            $data->ait_amount = $request->ait_amount;
            $data->fine_deduction = $request->fine_deduction;
            $data->paid_by_client = $request->paid_by_client;
            $data->less_paid_honor = $request->less_paid_honor;
            $data->less_paid = $request->less_paid;
            $data->deposit_bank = $request->deposit_bank;
            $data->payment_type = $request->payment_type;
            $data->bank_name = $request->bank_name;
            $data->po_no = $request->po_no;
            $data->po_date = $request->po_date;
            $data->pay_date = $request->pay_date;
            $data->rcv_date = $request->rcv_date;
            $data->deposit_date = $request->deposit_date;
            $data->remarks = $request->remarks;
            $data->save();
            \LogActivity::addToLog('InvoicePayment update',$request->getContent(),'InvoicePayment');
            return redirect()->route('invoice-payment.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function destroy($id)
    {
        //
    }
}
