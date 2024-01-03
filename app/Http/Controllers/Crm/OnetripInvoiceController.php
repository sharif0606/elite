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
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

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
        //dd($request->all());
        try{
            $invoice=new InvoiceGenerate;
            $invoice->customer_id = $request->customer_id;
            $invoice->branch_id = $request->branch_id;
            //$invoice->atm_id = $request->atm_id;
            $invoice->start_date = $request->start_date;
            $invoice->end_date = $request->end_date;
            $invoice->bill_date = $request->bill_date;
            $invoice->vat = $request->vat;
            $invoice->sub_total_amount = $request->sub_total_amount;
            $invoice->total_tk = $request->total_tk;
            $invoice->vat_taka = $request->vat_taka;
            $invoice->grand_total = $request->grand_total;
            $invoice->footer_note = $request->footer_note;
            $invoice->status = 0;
            if($invoice->save()){
                $onetrip=new OnetripInvoice;
                $onetrip->customer_id = $request->customer_id;
                $onetrip->invoice_id = $invoice->id;
                $onetrip->branch_id = $request->branch_id;
                $onetrip->atm_id = $request->atm_id;
                $onetrip->start_date = $request->start_date;
                $onetrip->end_date = $request->end_date;
                $onetrip->bill_date = $request->bill_date;
                $onetrip->vat = $request->vat;
                $onetrip->sub_total_amount = $request->sub_total_amount;
                $onetrip->total_tk = $request->total_tk;
                $onetrip->vat_taka = $request->vat_taka;
                $onetrip->grand_total = $request->grand_total;
                $onetrip->footer_note = $request->footer_note;
                $onetrip->status = 0;
                $onetrip->save();
                if($request->rate){
                    foreach($request->rate as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$invoice->id;
                            $details->rate=$request->rate[$key];
                            $details->st_date=$request->period[$key];
                            $details->ed_date=$request->period[$key];
                            $details->total_amounts=$request->amount[$key];
                            $details->job_post_id=0;
                            $details->employee_qty=0;
                            $details->warking_day=0;
                            $details->total_houres=0;
                            $details->rate_per_houres=0;
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if($request->rate){
                foreach($request->rate as $key => $value){
                    if($value){
                        $details = new OnetripInvoiceDetails;
                        $details->invoice_id=$onetrip->id;
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
