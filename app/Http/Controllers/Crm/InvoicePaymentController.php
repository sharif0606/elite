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

    public function index()
    {
        $payments=InvoicePayment::with('customer')->orderBy('id','DESC')->paginate(10);
        return view('invoice_payment.index',compact('payments'));
    }

    public function create()
    {
        $customer=Customer::all();
        return view('invoice_payment.create',compact('customer'));
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
            $data->payment_type = $request->payment_type;
            $data->bank_name = $request->bank_name;
            $data->zone_id = $request->zone_id;
            $data->po_no = $request->po_no;
            $data->po_date = $request->po_date;
            $data->pay_date = $request->pay_date;
            $data->deposit_date = $request->deposit_date;
            $data->remarks = $request->remarks;
            $data->save();
            \LogActivity::addToLog('InvoicePayment',$request->getContent(),'InvoicePayment');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function show(Request $request,$id)
    {
        
    }
   
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
