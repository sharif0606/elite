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
use Exception;
use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;

class WasaEmployeeAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wasaemployee=WasaEmployeeAssign::all();
        return view('wasa_employee_assign.index',compact('wasaemployee'));
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
        return view('wasa_employee_assign.create',compact('customer','jobpost','employee'));
    }

    public function wasaGetEmployee(Request $request)
	{
		$data = Employee::where('id',$request->id)->select('id','admission_id_no','en_applicants_name','bn_ac_no','bn_jobpost_id')->with('position')->get();
		return $data;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data=new WasaEmployeeAssign;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new WasaEmployeeAssignDetails;
                            $details->wasa_employee_assign_id=$data->id;
                            $details->atm_id = $request->atm_id[$key];
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->area=$request->area[$key];
                            $details->employee_name=$request->employee_name[$key];
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
        $jobpost=JobPost::all();
        $empasin = WasaEmployeeAssign::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('id',$empasin->branch_id)->first();
        $customer=Customer::where('id',$empasin->customer_id)->first();
        $atm=Atm::where('branch_id',$empasin->branch_id)->get();
        $employee = Employee::select('id','admission_id_no','en_applicants_name')->get();
        return view('wasa_employee_assign.edit',compact('jobpost','customer','empasin','branch','atm','employee'));
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
        try{
            $data=WasaEmployeeAssign::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    $dl=WasaEmployeeAssignDetails::where('wasa_employee_assign_id',$data->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new WasaEmployeeAssignDetails;
                            $details->wasa_employee_assign_id=$data->id;
                            $details->atm_id = $request->atm_id[$key];
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->area=$request->area[$key];
                            $details->employee_name=$request->employee_name[$key];
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        dd($request->all());
        try{
            $billDate = Carbon::parse($request->bill_date);
            $firstDayOfMonth = $billDate->firstOfMonth();
            $lastDayOfMonth = $billDate->lastOfMonth();

            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            //$data->atm_id = $request->atm_id;
            $data->start_date = $firstDayOfMonth;
            $data->end_date = $lastDayOfMonth;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat_subtotal;
            $data->sub_total_amount = $request->sub_total_salary;
            //$data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_tk_subtotal;
            $data->grand_total = $request->grand_total_tk;
            $data->footer_note = $request->footer_note;
            $data->status = 0;

            //aigula invoice table a rakha dorkar

            // $data->add_commission = $request->add_commission;
            // $data->vat_on_commission = $request->vat_on_commission;
            // $data->ait_on_commission = $request->ait_on_commission;
            // $data->vat_on_subtotal = $request->vat_on_subtotal;
            // $data->ait_on_subtotal = $request->ait_on_subtotal;

            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->duty=$request->duty[$key];
                            $details->st_date=$firstDayOfMonth;
                            $details->ed_date = $lastDayOfMonth;
                            $details->total_amounts=$request->salary_amount[$key];
                            //$details->atm_id = $request->atm_id[$key];

                            //aigula invoice table a rakha dorkar

                            // $details->employee_id=$request->employee_id[$key];
                            // $details->area=$request->area[$key];
                            // $details->employee_name=$request->employee_name[$key];
                            // $details->account_no=$request->account_no[$key];
                            $details->status=0;
                            $details->save();

                            //invoice a achea but amader aikhane nai

                            // $details->employee_qty=$request->employee_qty[$key];
                            // $details->total_houres=$request->total_houres[$key];
                            // $details->rate_per_houres=$request->rate_per_houres[$key];
                            // $details->rate=$request->rate[$key];
                        }
                    }
                }
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
    public function createOneTrip(Request $request)
    {
        //
    }
}
