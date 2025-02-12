<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Crm\EmployeeRate;
use App\Models\Crm\EmployeeRateDetails;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\Hour;

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
        $customer = Customer::select('id', 'name')->get();
        $emRate = EmployeeRate::orderBy('id', 'DESC');
        if ($request->customer_id) {
            $emRate->where('employee_rates.customer_id', $request->customer_id);
        }
        if ($request->branch_id) {
            $emRate->where('employee_rates.branch_id', $request->branch_id);
        }
        if ($request->employee_id) {
            $emRate->whereHas('details', function ($query) use ($request) {
                $query->where('employee_id', $request->employee_id);
            });
        }

        $emRate = $emRate->paginate(10);
        $employee = Employee::all();
        return view('employee_rate.index', compact('emRate', 'customer','employee'));
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
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        $employee = Employee::get();
        return view('employee_rate.create', compact('customer', 'jobpost', 'branch', 'atm', 'hours', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try {
            $data = new EmployeeRate;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new EmployeeRateDetails;
                            $details->employee_rate_id = $data->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->branch_id = $request->branch_id;
                            $details->atm_id = $request->atm_id;
                            $details->job_post_id = $request->job_post_id[$key];
                            $details->hours = $request->hours[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->status = 1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Employee Rate', $request->getContent(), 'EmployeeRate,EmployeeRateDetails');
                return redirect()->route('employeeRate.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $emprate = EmployeeRate::findOrFail(encryptor('decrypt', $id));
        return view('employee_rate.show', compact('emprate'));
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
        $customer = Customer::all();
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $emprate = EmployeeRate::findOrFail(encryptor('decrypt', $id));
        $hours = Hour::get();
        $employee = Employee::get();
        return view('employee_rate.edit', compact('jobpost', 'customer', 'emprate', 'branch', 'atm', 'hours', 'employee'));
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
        try {
            $data = EmployeeRate::findOrFail(encryptor('decrypt', $id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    EmployeeRateDetails::where('employee_rate_id', $data->id)->delete();
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new EmployeeRateDetails;
                            $details->employee_rate_id = $data->id;
                            $details->employee_id = $request->employee_id[$key] ?? null;
                            $details->branch_id = $request->branch_id;
                            $details->atm_id = $request->atm_id;
                            $details->job_post_id = $request->job_post_id[$key];
                            $details->hours = $request->hours[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->status = 1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Employee Rate Update', $request->all(), 'EmployeeRate,EmployeeRateDetails');
                return redirect()->route('employeeRate.index', ['role' => currentUser()])->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $c = EmployeeRate::findOrFail(encryptor('decrypt', $id));
        $dl = EmployeeRateDetails::where('employee_rate_id', $c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
    public function getEmployeeRate(Request $request)
    {
        // Base query
        $query = DB::table('employee_rates')
            ->join('employee_rate_details', 'employee_rates.id', '=', 'employee_rate_details.employee_rate_id')
            ->join('job_posts', 'job_posts.id', '=', 'employee_rate_details.job_post_id')
            ->select('job_posts.name as job_post_name', 'employee_rate_details.*');

        // Check if employee_id exists in the request
        if (!empty($request->employee_id)) {
            // Check if employee_id exists in the database
            $matchingEmployee = DB::table('employee_rate_details')
                ->where('employee_id', $request->employee_id)
                ->exists();

            if ($matchingEmployee) {
                // If employee_id exists, return only matching rows
                $query->where('employee_rate_details.employee_id', $request->employee_id);
            } else {
                // If no employee_id match, exclude NULL employee_id rows (no data related to employee_id)
                $query->whereNull('employee_rate_details.employee_id');
            }
        } else {
            // If employee_id is not provided in the request, exclude rows where employee_id is NULL
            $query->whereNotNull('employee_rate_details.employee_id');
        }

        // Add filters based on customer_id, branch_id, and atm_id
        if (!empty($request->customer_id)) {
            $query->where('employee_rates.customer_id', $request->customer_id);

            /*if (!empty($request->branch_id)) {*/
                // Check if branch_id exists in the database
                $matchBranch = DB::table('employee_rate_details')
                    ->where('branch_id', $request->branch_id)
                    ->exists();
            /*}else{
                $matchBranch = false;
            }*/

            /*if (!empty($request->atm_id)) {*/
                $matchAtm = DB::table('employee_rate_details')
                ->where('atm_id', $request->atm_id)
                ->exists();
            /*}else{
                $matchAtm = false;
            }*/

            // Check if branch_id exists in the database
           
            if ($matchBranch && $matchAtm) {
                $query->where('employee_rates.branch_id', $request->branch_id)->where('employee_rates.atm_id', $request->atm_id);
            } elseif ($matchBranch) {
                $query->where('employee_rates.branch_id', $request->branch_id);
            } elseif ($matchAtm) {
                $query->where('employee_rates.atm_id', $request->atm_id);
            } else {
                $query->whereNull('employee_rate_details.branch_id')
                    ->orWhereNull('employee_rate_details.atm_id');
            }
        }

        // Execute the query and get the results
        $result = $query->get();

        // Build the dropdown HTML
        $data = '<option value="0">Select</option>';
        foreach ($result as $r) {
            $data .= '<option data-jobpostid="' . $r->id . '" value="' . $r->id . '">' . $r->job_post_name . '-' . $r->duty_rate . '</option>';
        }

        return response()->json($data, 200);



        // Debug query log if needed
        //dd(DB::getQueryLog());



        /*$employee_rate = EmployeeRate::with('details.jobPost')->where('customer_id', $request->customer_id);
        if ($request->branch_id) {
        }
        if ($request->branch_id) {
            $branchId = $request->branch_id;*/

        // Check if data exists with the given branch ID
        /*$dataExists = EmployeeRate::where('customer_id', $request->customer_id)
                ->where('branch_id', $branchId)
                ->exists();

            if ($dataExists) {
                // If data exists, filter by branch ID
                $employee_rate->where('branch_id', $branchId);
            } else {
                // If no data matches, filter by NULL branch ID
                $employee_rate->whereNull('branch_id');
            }
        }
        if ($request->atm_id) {
            $atm_id = $request->atm_id;
            $employee_rate->where('employee_rates.atm_id', $atm_id);
        }*/
        // Show the SQL query without executing it
        //DB::enableQueryLog(); // Enable query log

        // Execute your query
        //$employee_rate = $employee_rate->get();

        // View the query log
        //dd(DB::getQueryLog());


        // Start building the select dropdown HTML
        //$data = '<option value="0">Select</option>';
        // Loop through employee_assign and its related details
        //foreach ($employee_rate as $rate) {
        // echo '<pre>';
        // print_r($rate->toArray())."<hr/>";
        // Assuming 'details' is a collection, so loop through it
        //foreach ($rate->details as $detail) {
        // Add each job post option
        //$data .= '<option data-jobpostid="' . $detail->job_post_id . '" value="' . $detail->job_post_id . '">' . $detail->jobPost->name . '</option>';
        //}
        //}
        // Return the generated HTML as a JSON response
        //return response()->json($data, 200);
        //dd($employee_assign);
    }
}
