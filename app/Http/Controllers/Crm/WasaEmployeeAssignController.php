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
            //$data->atm_id = $request->atm_id;
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
        //
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
}
