<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\EmployeeAssign;
use App\Models\Crm\EmployeeAssignDetails;
use App\Models\Employee\Employee;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use App\Models\Crm\CustomerRate;
use App\Models\Hour;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class EmployeeAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id', 'name')->get();
        $empasin = EmployeeAssign::orderBy('id', 'DESC');
        if ($request->customer_id) {
            $empasin->where('employee_assigns.customer_id', $request->customer_id);
        }
        if ($request->branch_id) {
            $empasin->where('employee_assigns.branch_id', $request->branch_id);
        }

        $empasin = $empasin->paginate(15);

        return view('employee_assign.index', compact('empasin', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobpost = JobPost::all();
        $customer = Customer::all();
        $hours = Hour::get();
        return view('employee_assign.create', compact('customer', 'jobpost', 'hours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new EmployeeAssign;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new EmployeeAssignDetails;
                            $details->employee_assign_id = $data->id;
                            $details->atm_id = $request->atm_id[$key];
                            $details->job_post_id = $request->job_post_id[$key];
                            $details->qty = $request->qty[$key];
                            $details->rate = $request->rate[$key];
                            $details->bonus_type = $request->bonus_type[$key];
                            $details->bonus_amount = $request->bonus_amount[$key];
                            $details->start_date = $request->start_date[$key];
                            $details->end_date = $request->end_date[$key];
                            $details->hours = $request->hours[$key];
                            $details->status = 1;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \LogActivity::addToLog('Employee Assign', $request->getContent(), 'EmployeeAssign,EmployeeAssignDetails');
                return redirect()->route('employee_assign.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            //dd($e);
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
        $empasin = EmployeeAssign::findOrFail(encryptor('decrypt', $id));
        return view('employee_assign.show', compact('empasin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobpost = JobPost::all();
        $empasin = EmployeeAssign::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $empasin->branch_id)->first();
        $customer = Customer::where('id', $empasin->customer_id)->first();
        $atm = Atm::where('branch_id', $empasin->branch_id)->get();
        $hours = Hour::get();
        return view('employee_assign.edit', compact('jobpost', 'customer', 'empasin', 'branch', 'atm', 'hours'));
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
        try {
            $data = EmployeeAssign::findOrFail(encryptor('decrypt', $id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            //$data->atm_id = $request->atm_id;
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    $dl = EmployeeAssignDetails::where('employee_assign_id', $data->id)->delete();
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new EmployeeAssignDetails;
                            $details->employee_assign_id = $data->id;
                            $details->atm_id = $request->atm_id[$key];
                            $details->job_post_id = $request->job_post_id[$key];
                            $details->qty = $request->qty[$key];
                            $details->rate = $request->rate[$key];
                            $details->bonus_type = $request->bonus_type[$key];
                            $details->bonus_amount = $request->bonus_amount[$key];
                            $details->start_date = $request->start_date[$key];
                            $details->end_date = $request->end_date[$key];
                            $details->hours = $request->hours[$key];
                            $details->status = 1;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \LogActivity::addToLog('Employee Assign Update', $request->getContent(), 'EmployeeAssign,EmployeeAssignDetails');
                return redirect()->route('employee_assign.index', ['role' => currentUser()])->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
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

        $c = EmployeeAssign::findOrFail(encryptor('decrypt', $id));
        $dl = EmployeeAssignDetails::where('employee_assign_id', $c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }

    public function loadBranchAjax(Request $request)
    {
        $customerId = $request->customerId;
        $branch = CustomerBrance::where('customer_id', $customerId)->select('id', 'zone_id', 'brance_name', 'vat', 'billing_rate')->get();
        return response()->json($branch, 200);
    }
    public function loadAtmAjax(Request $request)
    {
        $branchId = $request->branchId;
        $atm = Atm::where('branch_id', $branchId)->select('id', 'atm')->get();
        return response()->json($atm, 200);
    }
    public function loadRateAjax(Request $request)
    {
        $customerId = $request->customerId;
        $jobpostId = $request->jobpostId;
        $rate = CustomerRate::where('customer_id', $customerId)->where('job_post_id', $jobpostId)->first();
        return response()->json($rate, 200);
    }
    public function getJobPost(Request $request)
    {
        $employee_assign = EmployeeAssign::with('details')->where('customer_id', $request->customer_id)->get();
        // Start building the select dropdown HTML
        $data = '<option value="0">Select</option>';
        // Loop through employee_assign and its related details
        foreach ($employee_assign as $ed) {
            // Assuming 'details' is a collection, so loop through it
            foreach ($ed->details as $detail) {
                // Add each job post option
                $data .= '<option data-jobpostid="' . $detail->job_post_id . '" value="' . $detail->job_post_id . '">' . $detail->jobpost?->name .'-'.$detail->rate. '</option>';
            }
        }
        // Return the generated HTML as a JSON response
        return response()->json($data, 200);
        //dd($employee_assign);
    }
}