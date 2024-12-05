<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\SouthBanglaAssignDetails;
use App\Models\Crm\SouthBanglaInvoice;
use App\Models\Crm\SouthBanglaInvoiceDetails;
use App\Models\Customer;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class SouthBanglaInvoiceController extends Controller
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
        $customer = Customer::all();
        return view('southBanglaInvoice.create',compact('customer'));
    }

    public function getEmployeeRate(Request $request)
    {
        $customerId = $request->customer_id; 
        $branch = $request->branch_id;
        $empId = $request->employee_id; //employee_id as admission_id_no
        $emp = Employee::join('job_posts', 'job_posts.id', '=', 'employees.bn_jobpost_id')->select('employees.id','employees.bn_applicants_name','employees.en_applicants_name','employees.bn_jobpost_id','employees.id','job_posts.name as post_name')->where('employees.id',$empId)->first();
        if($emp){
            $empRate = SouthBanglaAssignDetails::select('id','duty_rate','service_rate','job_post_id')->where('customer_id', $customerId)->where('job_post_id', $request->job_post)->where('branch_id',$branch)->first();
            /*->where('job_post_id', $emp->bn_jobpost_id)->latest()*/
            // Log the executed query
            //dd(DB::getQueryLog());
            return response()->json([
                'employee' => $emp,
                'rate' => $empRate,
            ], 200);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }
    public function getEmployeeDesignation(Request $request)
    {
        $customerId = $request->customer_id; 
        $branch = $request->branch_id;
        $empId = $request->employee_id; //employee_id as admission_id_no
        $emp = Employee::join('job_posts', 'job_posts.id', '=', 'employees.bn_jobpost_id')->select('employees.id','employees.bn_applicants_name','employees.en_applicants_name','employees.bn_jobpost_id','employees.admission_id_no','job_posts.name as post_name')->where('admission_id_no',$empId)->first();
        if($emp){
            DB::enableQueryLog(); // Enable the query log    
            $empDesignation = SouthBanglaAssignDetails::select('south_bangla_assign_details.job_post_id','job_posts.name')
            ->join('job_posts','job_posts.id','=','south_bangla_assign_details.job_post_id')
            ->where('south_bangla_assign_details.customer_id', $customerId)->where('south_bangla_assign_details.branch_id',$branch)->get();
            // Log the executed query
            //dd(DB::getQueryLog());
            return response()->json([
                'employee' => $emp,
                'designation' => $empDesignation,
            ], 200);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
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
        DB::beginTransaction();
        try{
            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            if($request->branch_id > 0){
                $data->branch_id = $request->branch_id;
            }
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->sub_total_amount = $request->net_service;
            $data->total_tk = $request->net_service; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->invoice_type = 5;
            // invoice_type 1= general, 2=wasa, 3=onetrip, 4=portlink, 5=South Bangla
            $data->status = 0;
            if($data->save()){
                $southBangla = new SouthBanglaInvoice;
                $southBangla->invoice_id = $data->id;
                $southBangla->customer_id = $request->customer_id;
                $southBangla->start_date = $request->start_date;
                $southBangla->end_date = $request->end_date;
                $southBangla->bill_date = $request->bill_date;
                $southBangla->vat = $request->vat;
                $southBangla->net_payment = $request->net_payment;
                $southBangla->net_service = $request->net_service;
                $southBangla->total = $request->total;
                $southBangla->vat_taka = $request->vat_taka;
                $southBangla->grand_total = $request->grand_total;
                $southBangla->footer_note = $request->footer_note;
                $southBangla->header_note = $request->header_note;
                $southBangla->invoice_type = 5;
                $southBangla->save();
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->rate=$request->rate[$key];
                            $details->divide_by=$request->divide_by[$key];
                            $details->actual_warking_day=$request->divide_by[$key];
                            $details->duty_day=$request->duty_day[$key];
                            $details->total_amounts=$request->total_amounts[$key];
                            $details->status=0;
                            $details->save();

                            //southDetails
                            $southDetails = new SouthBanglaInvoiceDetails;
                            $southDetails->invoice_id=$data->id;
                            $southDetails->south_bangla_invoice_id=$southBangla->id;
                            $southDetails->employee_id=$request->employee_id[$key];
                            $southDetails->job_post_id=$request->job_post_id[$key];
                            $southDetails->rate=$request->rate[$key];
                            $southDetails->service=$request->service[$key];
                            $southDetails->divide_by=$request->divide_by[$key];
                            $southDetails->duty_day=$request->duty_day[$key];
                            $southDetails->net_payment_amount=$request->net_payment_amount[$key];
                            $southDetails->net_service_amount=$request->net_service_amount[$key];
                            $southDetails->total_amounts=$request->total_amounts[$key];
                            $southDetails->remarks=$request->remarks[$key];
                            $southDetails->status=0;
                            $southDetails->save();
                        }
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,SouthBanglaInvoice,SouthBanglaInvoiceDetails');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crm\SouthBanglaInvoice  $southBanglaInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(SouthBanglaInvoice $southBanglaInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\SouthBanglaInvoice  $southBanglaInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inv = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $customer = Customer::all();
        $branch = CustomerBrance::where('customer_id',$inv->customer_id)->get();
        $invSouthBangla = SouthBanglaInvoice::where('invoice_id',$inv->id)->first();
        $invSouthBanglaDetail = SouthBanglaInvoiceDetails::where('south_bangla_invoice_id',$invSouthBangla->id)->get();
        return view('southBanglaInvoice.edit',compact('customer','branch','inv','invSouthBangla','invSouthBanglaDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\SouthBanglaInvoice  $southBanglaInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        DB::beginTransaction();
        try{
            $data= InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            if($request->branch_id > 0){
                $data->branch_id = $request->branch_id;
            }
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->sub_total_amount = $request->net_service;
            $data->total_tk = $request->net_service; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->invoice_type = 5;
            // invoice_type 1= general, 2=wasa, 3=onetrip, 4=portlink, 5=South Bangla
            $data->status = 0;
            if($data->save()){
                $southBangla = SouthBanglaInvoice::where('invoice_id',$data->id)->first();
                $southBangla->invoice_id = $data->id;
                $southBangla->customer_id = $request->customer_id;
                $southBangla->start_date = $request->start_date;
                $southBangla->end_date = $request->end_date;
                $southBangla->bill_date = $request->bill_date;
                $southBangla->vat = $request->vat;
                $southBangla->net_payment = $request->net_payment;
                $southBangla->net_service = $request->net_service;
                $southBangla->total = $request->total;
                $southBangla->vat_taka = $request->vat_taka;
                $southBangla->grand_total = $request->grand_total;
                $southBangla->footer_note = $request->footer_note;
                $southBangla->header_note = $request->header_note;
                $southBangla->invoice_type = 5;
                $southBangla->save();
                if($request->job_post_id){
                    InvoiceGenerateDetails::where('invoice_id', $data->id)->delete();
                    SouthBanglaInvoiceDetails::where('invoice_id', $data->id)->delete();
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->rate=$request->rate[$key];
                            $details->divide_by=$request->divide_by[$key];
                            $details->actual_warking_day=$request->divide_by[$key];
                            $details->duty_day=$request->duty_day[$key];
                            $details->total_amounts=$request->total_amounts[$key];
                            $details->status=0;
                            $details->save();

                            //southDetails
                            $southDetails = new SouthBanglaInvoiceDetails;
                            $southDetails->invoice_id=$data->id;
                            $southDetails->south_bangla_invoice_id=$southBangla->id;
                            $southDetails->employee_id=$request->employee_id[$key];
                            $southDetails->job_post_id=$request->job_post_id[$key];
                            $southDetails->rate=$request->rate[$key];
                            $southDetails->service=$request->service[$key];
                            $southDetails->divide_by=$request->divide_by[$key];
                            $southDetails->duty_day=$request->duty_day[$key];
                            $southDetails->net_payment_amount=$request->net_payment_amount[$key];
                            $southDetails->net_service_amount=$request->net_service_amount[$key];
                            $southDetails->total_amounts=$request->total_amounts[$key];
                            $southDetails->remarks=$request->remarks[$key];
                            $southDetails->status=0;
                            $southDetails->save();
                        }
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,SouthBanglaInvoice,SouthBanglaInvoiceDetails');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crm\SouthBanglaInvoice  $southBanglaInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SouthBanglaInvoice $southBanglaInvoice)
    {
        //
    }
}
