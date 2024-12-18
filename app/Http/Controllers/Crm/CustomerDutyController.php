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

Use App\Models\Hour;

use Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Crm\Atm;
use App\Models\Crm\CustomerBrance;
use Intervention\Image\Facades\Image;
use Exception;

class CustomerDutyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id','name')->get();
        $customerduty=CustomerDuty::orderBy('id','DESC');
        if ($request->customer_id){
            $customerduty->where('customer_duties.customer_id', $request->customer_id);
        }
        if ($request->branch_id){
            $customerduty->where('customer_duties.branch_id', $request->branch_id);
        }
        $customerduty = $customerduty->paginate(10);
        return view('customer_duty.index',compact('customerduty','customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobposts=JobPost::all();
        $customer=Customer::all();
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        return view('customer_duty.create',compact('customer','jobposts','branch','atm','hours'));
    }

    public function getEmployeeDuty(Request $request)
    {
        try {
            $customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $branch = $request->branch_id;
            $empRateId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            $empRateIdWithBranch = EmployeeRate::where('customer_id', $customerId)->where('branch_id',$branch)->pluck('id');
            if($request->branch_id){
                if(!$empRateIdWithBranch->isEmpty()){
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->orderBy('id', 'desc')->first();
                        return $data;
                }else{
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->orderBy('id', 'ASC')->first();
                    return $data;
                }
            }else{
                $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->orderBy('id', 'ASC')->first();
                return $data;
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function getDutyOtRateHourWise(Request $request){
        try {
            $customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $branch = $request->branch_id;
            $jobpostHour = $request->job_post_hour;
            $empRateId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            $empRateIdWithBranch = EmployeeRate::where('customer_id', $customerId)->where('branch_id',$branch)->pluck('id');
            if($request->branch_id){
                if(!$empRateIdWithBranch->isEmpty()){
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->where('hours',$jobpostHour)->orderBy('id', 'desc')->first();
                    return $data;
                }else{
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->where('hours',$jobpostHour)->orderBy('id', 'ASC')->first();
                    return $data;
                }
            }else{
                $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->where('hours',$jobpostHour)->orderBy('id', 'ASC')->first();
                return $data;
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkOthersCustomerDuty(Request $request){
        try {
            $employee = $request->employee_id;
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Validate that the necessary request data is present
            if (is_null($startDate) && is_null($endDate)) {
                return response()->json(['error' => 'Both start date and end date are required to check duty'], 400);
            } elseif (is_null($startDate)) {
                return response()->json(['error' => 'Start date is required to check duty'], 400);
            } elseif (is_null($endDate)) {
                return response()->json(['error' => 'End date is required to check duty'], 400);
            }

            $data = CustomerDutyDetail::join('customers', 'customers.id', '=', 'customer_duty_details.customer_id')
                ->where('customer_duty_details.employee_id', $employee)
                ->where('customer_duty_details.start_date', '<=', $startDate)
                ->where('customer_duty_details.end_date', '>=', $endDate)
                ->leftJoin('customer_duties','customer_duties.id','=','customer_duty_details.customerduty_id')
                ->leftJoin('customer_brances','customer_duties.branch_id','=','customer_brances.id')
                ->select('customer_duty_details.duty_qty as general','customer_duty_details.customerduty_id','customer_duty_details.ot_qty as overtime','customer_duty_details.total_amount as  total','customer_duties.id','customer_duties.branch_id','customers.name as customer_name','customer_brances.brance_name as customer_branch') // Select necessary columns
                ->get();
            return response()->json($data, 200);
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
        DB::beginTransaction();
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
                            $details->hours=$request->job_post_hour[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->total_amount=$request->total_amount[$key];
                            $details->start_date=$request->start_date_details[$key];
                            $details->end_date=$request->end_date_details[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
                DB::commit();
            }
            if ($data->save()) {
                \LogActivity::addToLog('Add Duty',$request->getContent(),'CustomerDuty,CustomerDutyDetail');
                return redirect()->route('customerduty.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            DB::rollback();
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
        $jobposts=JobPost::all();
        $customer=Customer::all();
        $employee=Employee::all();
        $custduty = CustomerDuty::findOrFail(encryptor('decrypt',$id));
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        return view('customer_duty.edit',compact('jobposts','customer','custduty','employee','branch','atm','hours'));
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
                            $details->hours=$request->job_post_hour[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->total_amount=$request->total_amount[$key];
                            $details->start_date=$request->start_date_details[$key];
                            $details->end_date=$request->end_date_details[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                return redirect()->route('customerduty.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $c=CustomerDuty::findOrFail(encryptor('decrypt',$id));
        $dl=CustomerDutyDetail::where('customerduty_id',$c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
