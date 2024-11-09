<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\WasaEmployeeAssign;
use App\Models\Crm\WasaEmployeeAssignDetails;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\WasaInvoice;
use App\Models\Crm\WasaInvoiceDetails;

use Exception;
use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;

class WasaEmployeeAssignController extends Controller
{

    public function index()
    {
        $wasaemployee=WasaEmployeeAssign::all();
        return view('wasa_employee_assign.index',compact('wasaemployee'));
    }


    public function create()
    {
        $jobpost=JobPost::all();
        $customer=Customer::all();
        $employee = Employee::select('id','admission_id_no','en_applicants_name')->get();
        return view('wasa_employee_assign.create',compact('customer','jobpost','employee'));
    }

    public function wasaGetEmployee(Request $request)
	{
		$data = Employee::where('id',$request->id)->select('id','admission_id_no','en_applicants_name','bn_ac_no','bn_jobpost_id')->with('position')->get();
		return $data;
	}


    public function store(Request $request)
    {
        try{
            $data=new WasaEmployeeAssign;
            $data->customer_id = $request->customer_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new WasaEmployeeAssignDetails;
                            $details->wasa_employee_assign_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->area=$request->area[$key];
                            $details->employee_name=$request->employee_name[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty=$request->duty[$key];
                            $details->account_no=$request->account_no[$key];
                            $details->salary_amount=$request->salary_amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \LogActivity::addToLog('Wasa Employee Assign',$request->getContent(),'WasaEmployeeAssign,WasaEmployeeAssignDetails');
                return redirect()->route('wasaEmployeeAsign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $jobpost=JobPost::all();
        $empasin = WasaEmployeeAssign::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('id',$empasin->branch_id)->first();
        $customer=Customer::where('id',$empasin->customer_id)->first();
        $atm=Atm::where('branch_id',$empasin->branch_id)->get();
        $employee = Employee::select('id','admission_id_no','en_applicants_name')->get();
        return view('wasa_employee_assign.edit',compact('jobpost','customer','empasin','branch','atm','employee'));
    }


    public function update(Request $request, $id)
    {
        try{
            $data=WasaEmployeeAssign::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    $dl=WasaEmployeeAssignDetails::where('wasa_employee_assign_id',$data->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new WasaEmployeeAssignDetails;
                            $details->wasa_employee_assign_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->area=$request->area[$key];
                            $details->employee_name=$request->employee_name[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty=$request->duty[$key];
                            $details->account_no=$request->account_no[$key];
                            $details->salary_amount=$request->salary_amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
                \LogActivity::addToLog('Wasa Employee Assign Update',$request->getContent(),'WasaEmployeeAssign,WasaEmployeeAssignDetails');
                return redirect()->route('wasaEmployeeAsign.index')->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function destroy($id)
    {
        $crate=WasaEmployeeAssign::findOrFail(encryptor('decrypt',$id));
        $dl=WasaEmployeeAssignDetails::where('wasa_employee_assign_id',$crate->id)->delete();
        $crate->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }

    public function createInvoice(Request $request)
    {
        $empasin = WasaEmployeeAssign::where('customer_id',$request->customer_id)->first();
        if($empasin){
            $jobpost=JobPost::all();
            $branch=CustomerBrance::where('id',$empasin->branch_id)->first();
            $customer=Customer::where('id',$empasin->customer_id)->first();
            $atm=Atm::where('branch_id',$empasin->branch_id)->get();
            $employee = Employee::select('id','admission_id_no','en_applicants_name')->get();
            return view('wasa_employee_assign.createInvoice',compact('jobpost','customer','empasin','branch','atm','employee'));
        }else{
            return back();
        }
    }
    public function storeWasaInvoice(Request $request, $id=null)
    {
        //dd($request->all());
        try{
            $billDate = Carbon::parse($request->bill_date);
            $firstDayOfMonth = $request->start_date;
            $lastDayOfMonth = $request->end_date;

            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            // $data->branch_id = $request->branch_id;
            $data->start_date = $firstDayOfMonth;
            $data->end_date = $lastDayOfMonth;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat_on_subtotal;
            $data->sub_total_amount = $request->sub_total_salary;
            $data->total_tk = $request->sub_total_salary; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_tk_subtotal;
            $data->grand_total = $request->grand_total_tk;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->zone_id = $request->zone_id;
            $data->invoice_type = 2;
            // invoice_type 1= general, 2=wasa, 3=onetrip
            $data->status = 0;
            if($data->save()){
                $invoice=new WasaInvoice;
                $invoice->invoice_id=$data->id;
                $invoice->customer_id = $request->customer_id;
                $invoice->branch_id = $request->branch_id;
                $invoice->sub_total_salary = $request->sub_total_salary;
                $invoice->add_commission = $request->add_commission_percentage;
                $invoice->add_commission_tk = $request->add_commission_tk;
                $invoice->vat_on_commission = $request->vat_commission_percentage;
                $invoice->vat_on_commission_tk = $request->vat_commission_percentage_tk;
                $invoice->ait_on_commission = $request->ait_commission_percentage;
                $invoice->ait_on_commission_tk = $request->ait_commission_percentage_tk;
                $invoice->vat_ait_on_commission = $request->vat_ait_commission_percentage;
                $invoice->vat_ait_on_commission_tk = $request->vat_ait_commission_tk;
                $invoice->vat_on_subtotal = $request->vat_on_subtotal;
                $invoice->vat_on_subtotal_tk = $request->vat_tk_subtotal;
                $invoice->ait_on_subtotal = $request->ait_on_subtotal;
                $invoice->ait_on_subtotal_tk = $request->ait_tk_subtotal;
                $invoice->grand_total_tk = $request->grand_total_tk;
                $invoice->footer_note = $request->footer_note;
                $invoice->bill_date = $request->bill_date;
                $invoice->start_date = $firstDayOfMonth;
                $invoice->end_date = $lastDayOfMonth;
                $invoice->status = 0;
                $invoice->save();
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $invoiceDetail = new WasaInvoiceDetails;
                            $invoiceDetail->wasa_invoice_id=$invoice->id;
                            $invoiceDetail->invoice_id=$data->id;
                            $invoiceDetail->atm_id = $request->atm_id[$key];
                            $invoiceDetail->employee_id=$request->employee_id[$key];
                            $invoiceDetail->job_post_id=$request->job_post_id[$key];
                            $invoiceDetail->area=$request->area[$key];
                            $invoiceDetail->account_no=$request->account_no[$key];
                            $invoiceDetail->duty_rate=$request->duty_rate[$key];
                            $invoiceDetail->duty=$request->duty[$key];
                            $invoiceDetail->start_date=$firstDayOfMonth;
                            $invoiceDetail->end_date = $lastDayOfMonth;
                            $invoiceDetail->salary_amount=$request->salary_amount[$key];
                            $invoiceDetail->status=0;
                            $invoiceDetail->save();
                        }
                    }
                    // $wasaInvoice = WasaInvoiceDetails::where('wasa_invoice_id', $invoice->id)->select('job_post_id','atm_id','duty', DB::raw('SUM(salary_amount) as total_amounts'))->groupBy('job_post_id')->get();
                    $wasaInvoice = WasaInvoiceDetails::where('wasa_invoice_id', $invoice->id)->select('job_post_id', 'atm_id','duty_rate','duty','salary_amount','start_date','end_date', DB::raw('SUM(salary_amount) as total_amounts'),DB::raw('COUNT(employee_id) as employee_count'))->groupBy('job_post_id')->get();

                    foreach ($wasaInvoice as $winvoice) {
                        $details = new InvoiceGenerateDetails;
                        $details->invoice_id = $data->id;
                        $details->job_post_id = $winvoice->job_post_id;
                        $details->rate = $winvoice->duty_rate;
                        $details->total_amounts = $winvoice->salary_amount;
                        $details->employee_qty = $winvoice->employee_count;
                        $details->total_houres = ($winvoice->employee_count*$winvoice->duty*8);
                        $details->warking_day = $winvoice->duty;
                        $details->st_date=$winvoice->start_date;
                        $details->ed_date =$winvoice->end_date;
                        $details->status = 0;
                        $details->save();
                    }
                }
                // if($request->job_post_id){
                //     foreach($request->job_post_id as $key => $value){
                //         if($value){
                //             $details = new InvoiceGenerateDetails;
                //             $details->invoice_id=$data->id;
                //             $details->job_post_id=$request->job_post_id[$key];
                //             $details->atm_id = $request->atm_id[$key];
                //             $details->duty=$request->duty[$key];
                //             $details->st_date=$firstDayOfMonth;
                //             $details->ed_date = $lastDayOfMonth;
                //             $details->rate=$request->salary_amount[$key];

                //             //aigula invoice table a rakha dorkar

                //             // $details->employee_id=$request->employee_id[$key];
                //             // $details->area=$request->area[$key];
                //             // $details->employee_name=$request->employee_name[$key];
                //             // $details->account_no=$request->account_no[$key];
                //             $details->status=0;
                //             $details->save();

                //             //invoice a achea but amader aikhane nai

                //             // $details->employee_qty=$request->employee_qty[$key];
                //             // $details->total_houres=$request->total_houres[$key];
                //             // $details->rate_per_houres=$request->rate_per_houres[$key];
                //             // $details->total_amounts=$request->total_amounts[$key];
                //         }
                //     }
                // }
                \LogActivity::addToLog('Wasa invoice Create',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails');
                return redirect()->route('invoiceGenerate.index')->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function wasaInvoiceEdit($id){
        $inv = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $invWasa = WasaInvoice::where('invoice_id',$inv->id)->first();
        $invWasaDetail = WasaInvoiceDetails::where('wasa_invoice_id',$invWasa->id)->get();
        return view('wasa_employee_assign.editInvoice',compact('inv','invWasa','invWasaDetail'));
    }

    public function wasaInvoiceUpdate(Request $request, $id){
        try{
            $billDate = Carbon::parse($request->bill_date);
            $firstDayOfMonth = $request->start_date;
            $lastDayOfMonth = $request->end_date;

            $data= InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            // $data->branch_id = $request->branch_id;
            $data->start_date = $firstDayOfMonth;
            $data->end_date = $lastDayOfMonth;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat_on_subtotal;
            $data->sub_total_amount = $request->sub_total_salary;
            $data->total_tk = $request->sub_total_salary; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_tk_subtotal;
            $data->grand_total = $request->grand_total_tk;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->zone_id = $request->zone_id;
            $data->invoice_type = 2;
            // invoice_type 1= general, 2=wasa, 3=onetrip
            $data->status = 0;
            if($data->save()){
                $invoice= WasaInvoice::where('invoice_id',$data->id)->first();
                $invoice->invoice_id=$data->id;
                $invoice->customer_id = $request->customer_id;
                $invoice->branch_id = $request->branch_id;
                $invoice->sub_total_salary = $request->sub_total_salary;
                $invoice->add_commission = $request->add_commission_percentage;
                $invoice->add_commission_tk = $request->add_commission_tk;
                $invoice->vat_on_commission = $request->vat_commission_percentage;
                $invoice->vat_on_commission_tk = $request->vat_commission_percentage_tk;
                $invoice->ait_on_commission = $request->ait_commission_percentage;
                $invoice->ait_on_commission_tk = $request->ait_commission_percentage_tk;
                $invoice->vat_ait_on_commission = $request->vat_ait_commission_percentage;
                $invoice->vat_ait_on_commission_tk = $request->vat_ait_commission_tk;
                $invoice->vat_on_subtotal = $request->vat_on_subtotal;
                $invoice->vat_on_subtotal_tk = $request->vat_tk_subtotal;
                $invoice->ait_on_subtotal = $request->ait_on_subtotal;
                $invoice->ait_on_subtotal_tk = $request->ait_tk_subtotal;
                $invoice->grand_total_tk = $request->grand_total_tk;
                $invoice->footer_note = $request->footer_note;
                $invoice->bill_date = $request->bill_date;
                $invoice->start_date = $firstDayOfMonth;
                $invoice->end_date = $lastDayOfMonth;
                $invoice->status = 0;
                $invoice->save();
                if($request->employee_id){
                    WasaInvoiceDetails::where('wasa_invoice_id',$invoice->id)->delete();
                    InvoiceGenerateDetails::where('invoice_id',$data->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $invoiceDetail = new WasaInvoiceDetails;
                            $invoiceDetail->wasa_invoice_id=$invoice->id;
                            $invoiceDetail->invoice_id=$data->id;
                            $invoiceDetail->atm_id = $request->atm_id[$key];
                            $invoiceDetail->employee_id=$request->employee_id[$key];
                            $invoiceDetail->job_post_id=$request->job_post_id[$key];
                            $invoiceDetail->area=$request->area[$key];
                            $invoiceDetail->account_no=$request->account_no[$key];
                            $invoiceDetail->duty_rate=$request->duty_rate[$key];
                            $invoiceDetail->duty=$request->duty[$key];
                            $invoiceDetail->start_date=$firstDayOfMonth;
                            $invoiceDetail->end_date = $lastDayOfMonth;
                            $invoiceDetail->salary_amount=$request->salary_amount[$key];
                            $invoiceDetail->status=0;
                            $invoiceDetail->save();
                        }
                    }
                    // $wasaInvoice = WasaInvoiceDetails::where('wasa_invoice_id', $invoice->id)->select('job_post_id','atm_id','duty', DB::raw('SUM(salary_amount) as total_amounts'))->groupBy('job_post_id')->get();
                    $wasaInvoice = WasaInvoiceDetails::where('wasa_invoice_id', $invoice->id)->select('job_post_id', 'atm_id','duty_rate','duty','salary_amount','start_date','end_date', DB::raw('SUM(salary_amount) as total_amounts'),DB::raw('COUNT(employee_id) as employee_count'))->groupBy('job_post_id')->get();

                    foreach ($wasaInvoice as $winvoice) {
                        $details = new InvoiceGenerateDetails;
                        $details->invoice_id = $data->id;
                        $details->job_post_id = $winvoice->job_post_id;
                        $details->rate = $winvoice->duty_rate;
                        $details->total_amounts = $winvoice->salary_amount;
                        $details->employee_qty = $winvoice->employee_count;
                        $details->total_houres = ($winvoice->employee_count*$winvoice->duty*8);
                        $details->warking_day = $winvoice->duty;
                        $details->st_date=$winvoice->start_date;
                        $details->ed_date =$winvoice->end_date;
                        $details->status = 0;
                        $details->save();
                    }
                }
                \LogActivity::addToLog('Wasa invoice Update',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails');
                return redirect()->route('invoiceGenerate.index')->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function createOneTrip(Request $request)
    {
        //
    }
}
