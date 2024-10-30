<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\EmployeeRate;
use App\Models\Crm\EmployeeRateDetails;
use App\Models\JobPost;
use App\Models\Customer;
Use App\Models\Hour;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Crm\Atm;
use App\Models\Crm\CustomerBrance;
use Intervention\Image\Facades\Image;
use Exception;

class EmployeeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id','name')->get();
        $emRate=EmployeeRate::orderBy('id','DESC');
        if ($request->customer_id){
            $emRate->where('employee_rates.customer_id', $request->customer_id);
        }
        if ($request->branch_id){
            $emRate->where('employee_rates.branch_id', $request->branch_id);
        }
        $emRate = $emRate->get();
        return view('employee_rate.index',compact('emRate','customer'));
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
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        return view('employee_rate.create',compact('customer','jobpost','branch','atm','hours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $data=new EmployeeRate;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new EmployeeRateDetails;
                            $details->employee_rate_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->hours=$request->hours[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->status=1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Employee Rate',$request->getContent(),'EmployeeRate,EmployeeRateDetails');
                return redirect()->route('employeeRate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $emprate = EmployeeRate::findOrFail(encryptor('decrypt',$id));
        return view('employee_rate.show',compact('emprate'));
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
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $emprate = EmployeeRate::findOrFail(encryptor('decrypt',$id));
        $hours = Hour::get();
        return view('employee_rate.edit',compact('jobpost','customer','emprate','branch','atm','hours'));
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
        DB::beginTransaction();
        try{
            $data=EmployeeRate::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    EmployeeRateDetails::where('employee_rate_id',$data->id)->delete();
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new EmployeeRateDetails;
                            $details->employee_rate_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->hours=$request->hours[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->status=1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Employee Rate Update',$request->getContent(),'EmployeeRate,EmployeeRateDetails');
                return redirect()->route('employeeRate.index', ['role' =>currentUser()])->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=EmployeeRate::findOrFail(encryptor('decrypt',$id));
        $dl=EmployeeRateDetails::where('employee_rate_id',$c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
