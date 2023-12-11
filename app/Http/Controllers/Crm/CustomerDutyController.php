<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CustomerDuty;
use App\Models\Crm\CustomerDutyDetail;
use App\Models\Crm\CustomerAttendance;
use App\Models\Crm\EmployeeRate;
use App\Models\Crm\EmployeeRateDetails;
use App\Models\Employee\Employee;
use App\Models\JobPost;

use App\Models\Customer;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class CustomerDutyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerduty=CustomerDuty::all();
        return view('customer_duty.index',compact('customerduty'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('customer_duty.create',compact('customer'));
    }

    public function getEmployeeDuty(Request $request)
    {
        try {
            $customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $empRateId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->orderBy('id', 'desc')->first();
            return $data;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
        //dd($request->all());
        try{
            $data=new CustomerDuty;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->total_duty = $request->total_duty;
            $data->total_ot = $request->total_ot;
            $data->total_duty_amount = $request->total_duty_amount;
            $data->total_ot_amount = $request->total_ot_amount;
            $data->finall_amount = $request->finall_amount;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new CustomerDutyDetail;
                            $details->customerduty_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->customer_id = $request->customer_id;
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->total_amount=$request->total_amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \LogActivity::addToLog('Add Duty',$request->getContent(),'CustomerDuty,CustomerDutyDetail');
                return redirect()->route('customerduty.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $customer=Customer::all();
        $employee=Employee::all();
        $custduty = CustomerDuty::findOrFail(encryptor('decrypt',$id));
        return view('customer_duty.edit',compact('jobpost','customer','custduty','employee'));
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
            $data=CustomerDuty::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->total_duty = $request->total_duty;
            $data->total_ot = $request->total_ot;
            $data->total_duty_amount = $request->total_duty_amount;
            $data->total_ot_amount = $request->total_ot_amount;
            $data->finall_amount = $request->finall_amount;
            $data->status = 0;
            if($data->save()){
                if($request->employee_id){
                    $dl=CustomerDutyDetail::where('customerduty_id',$data->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new CustomerDutyDetail;
                            $details->customerduty_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->customer_id = $request->customer_id;
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->total_amount=$request->total_amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                return redirect()->route('customerduty.index', ['role' =>currentUser()])->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
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
}
