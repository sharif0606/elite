<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\OnetripInvoice;
use App\Models\Crm\OnetripInvoiceDetails;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;

class OnetripInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobpost=JobPost::all();
        $customer=Customer::all();
        $employee = Employee::select('id','admission_id_no','en_applicants_name')->get();
        return view('onetripInvoice.create',compact('customer','jobpost','employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        try{
            $data=new OnetripInvoice;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->sub_total_amount = $request->sub_total_amount;
            $data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->status = 0;
            if($data->save()){
                if($request->rate){
                    foreach($request->rate as $key => $value){
                        if($value){
                            $details = new OnetripInvoiceDetails;
                            $details->invoice_id=$data->id;
                            $details->service=$request->service[$key];
                            $details->rate=$request->rate[$key];
                            $details->period=$request->period[$key];
                            $details->trip=$request->trip[$key];
                            $details->amount=$request->amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            \LogActivity::addToLog(' OneTrip',$request->getContent(),'OnetripInvoice,OnetripInvoiceDetails');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));


        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
