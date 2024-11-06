<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Crm\InvoicePayment;

use Toastr;
use Exception;

class InvoicePaymentController extends Controller
{

    public function index(Request $request)
    {
        $payments=InvoicePayment::with('customer');
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
        if($request->rcv_date){
            $payments=$payments->where('rcv_date',$request->rcv_date);
        }
        if($request->deposit_date){
            $payments=$payments->where('deposit_date',$request->deposit_date);
        }
        
        $payments=$payments->orderBy('deposit_date','DESC')->paginate(10);
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
        return view('invoice_payment.edit',compact('ivp'));
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
