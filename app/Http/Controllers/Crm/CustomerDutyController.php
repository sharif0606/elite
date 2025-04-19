<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Support\Facades\Validator;

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

use App\Models\Hour;

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
        $customer = Customer::select('id', 'name')->get();
        $customerduty = CustomerDuty::with('details')->orderBy('id', 'DESC');

        // Get the first date of the month
        $start_date = Carbon::create($request->year, $request->month, 1)->startOfDay(); // 2024-05-01 00:00:00
        // Get the last date of the month
        $end_date = Carbon::create($request->year, $request->month, 1)->endOfMonth()->endOfDay(); // 2024-05-31 23:59:59

        $employee = Employee::select('id', 'bn_applicants_name', 'admission_id_no')->get();

        // Filter by customer if customer_id is present
        if ($request->customer_id) {
            $customerduty->where('customer_duties.customer_id', $request->customer_id);
        }

        // Filter by branch if branch_id is present
        if ($request->branch_id) {
            $customerduty->where('customer_duties.branch_id', $request->branch_id);
        }

        // Filter by year and month if both are provided
        if ($request->month && $request->year) {
            $customerduty->whereDate('customer_duties.start_date', '>=', $start_date);
            $customerduty->whereDate('customer_duties.end_date', '<=', $end_date);
        }

        // Filter by employee if employee_id is provided
        if ($request->employee_id) {
            // Filter customer duties where at least one detail has the matching employee_id
            $customerduty->whereHas('details', function ($query) use ($request) {
                $query->where('employee_id', $request->employee_id);
            });
        }

        // Now paginate after all conditions are applied
        $customerduty = $customerduty->paginate(10);

        // Return the appropriate view
        if ($request->employee_id) {
            return view('customer_duty.index-employee', compact('customerduty', 'customer', 'employee'));
        } else {
            return view('customer_duty.index', compact('customerduty', 'customer', 'employee'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobposts = JobPost::all();
        $customer = Customer::all();
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        return view('customer_duty.create', compact('customer', 'jobposts', 'branch', 'atm', 'hours'));
    }

    public function getEmployeeDuty(Request $request)
    {
        try {
            /*$customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $branch = $request->branch_id;
            $employee_id = $request->employee_id;
            $empRateId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            
            $empRateIdWithBranch = EmployeeRate::where('customer_id', $customerId)->where('branch_id', $branch)->pluck('id');
            if ($request->branch_id) {
                if (!$empRateIdWithBranch->isEmpty()) {
                    if($customerId && $employee_id){*/
            //echo $customerId.'<br>';
            //echo $employee_id.'<br>';
            //$data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->where('employee_id', $employee_id)->orderBy('id', 'desc')->first();
            //dd($data);
            /*if($data){
                            return $data;
                        }
                        else{
                            DB::enableQueryLog();
                            $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->orderBy('id', 'desc')->first();
                            dd(DB::getQueryLog());
                            return $data;
                        }
                    }else{
                        $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->orderBy('id', 'desc')->first();
                        return $data;
                    }
                }else {*/
            //$data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->orderBy('id', 'ASC')->first();
            /*$emp_rate_id = EmployeeRate::where('customer_id', $customerId)->whereNull('branch_id')->pluck('id');
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $emp_rate_id)->where('job_post_id', $jobpostId)->orderBy('id', 'ASC')->first();
                    return $data;
                }
            } else {
                $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->orderBy('id', 'ASC')->first();
                return $data;
            }*/
            $data = EmployeeRateDetails::find($request->job_post_id);
            return $data;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getDutyOtRateHourWise(Request $request)
    {
        try {
            /*$customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $branch = $request->branch_id;
            $jobpostHour = $request->job_post_hour;
            $empRateId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            $empRateIdWithBranch = EmployeeRate::where('customer_id', $customerId)->where('branch_id', $branch)->pluck('id');
            if ($request->branch_id) {
                if (!$empRateIdWithBranch->isEmpty()) {*/
            //DB::enableQueryLog();
            //$data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateIdWithBranch)->where('job_post_id', $jobpostId)->where('hours', $jobpostHour)->orderBy('id', 'desc')->first();
            //dd(DB::getQueryLog());
            //return $data;
            //} else {
            //$data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->where('hours', $jobpostHour)->orderBy('id', 'ASC')->first();
            /*$emp_rate_id = EmployeeRate::where('customer_id', $customerId)->whereNull('branch_id')->pluck('id');
                    $data = EmployeeRateDetails::whereIn('employee_rate_id', $emp_rate_id)->where('job_post_id', $jobpostId)->where('hours', $jobpostHour)->orderBy('id', 'ASC')->first();
                    return $data;
                }*/
            /*} else {
                $data = EmployeeRateDetails::whereIn('employee_rate_id', $empRateId)->where('job_post_id', $jobpostId)->where('hours', $jobpostHour)->orderBy('id', 'ASC')->first();
                return $data;
            }*/
            //$data = EmployeeRateDetails::whereIn('employee_rate_id', $emp_rate_id)->where('job_post_id', $jobpostId)->where('hours', $jobpostHour)->orderBy('id', 'ASC')->first();
            //return $data;
            $data = EmployeeRateDetails::find($request->job_post_id);
            return $data;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkOthersCustomerDuty(Request $request)
    {
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
                ->leftJoin('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
                ->leftJoin('customer_brances', 'customer_duties.branch_id', '=', 'customer_brances.id')
                ->select('customer_duty_details.duty_qty as general', 'customer_duty_details.customerduty_id', 'customer_duty_details.ot_qty as overtime', 'customer_duty_details.total_amount as  total', 'customer_duties.id', 'customer_duties.branch_id', 'customers.name as customer_name', 'customer_brances.brance_name as customer_branch') // Select necessary columns
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
        // Validation Rules
        $rules = [
            'job_post_id' => 'required|array',
            'job_post_hour' => 'required|array',
            'total_duty_amount' => 'required|numeric',
        ];
        $messages = [
            'job_post_id.*.required' => 'Job post ID is required for each employee.',
            'job_post_hour.*.required' => 'Job post hour is required for each employee.',
        ];
        // Validate Request
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //dd($request->all());
        DB::beginTransaction();
        try {
            $data = new CustomerDuty;
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
            if ($data->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new CustomerDutyDetail;
                            $details->customerduty_id = $data->id;
                            $details->employee_id = $request->employee_id[$key];

                            // Query the employeeratedetails table to get the job_post_hour by the primary key (job_post_id)
                            $employeeRate = EmployeeRateDetails::find($request->job_post_id[$key]);

                            // Check if we found a valid entry
                            if ($employeeRate) {
                                $job_post_id = $employeeRate->job_post_id;
                            } else {
                                //$job_post_id = 0; // Or set to a default value if no rate is found
                                return redirect()->back()->withInput()->with(Toastr::error('Employee rate not found!', 'Fail', ["positionClass" => "toast-top-right"]));
                            }

                            $details->job_post_id = $job_post_id;
                            $details->employee_salary_id = $request->job_post_id[$key];
                            $details->customer_id = $request->customer_id;
                            $details->hours = $request->job_post_hour[$key];

                            /*== New Column ==*/
                            $details->absent = $request->absent[$key];
                            $details->vacant = $request->vacant[$key];
                            $details->holiday_festival = $request->holiday_festival[$key];
                            $details->leave_cl = $request->leave_cl[$key];
                            $details->leave_sl = $request->leave_sl[$key];
                            $details->leave_el = $request->leave_el[$key];

                            $details->duty_rate = $request->duty_rate[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->total_amount = $request->total_amount[$key];
                            $details->start_date = $request->start_date_details[$key];
                            $details->end_date = $request->end_date_details[$key];
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }
                DB::commit();
            }
            if ($data->save()) {
                \LogActivity::addToLog('Add Duty', $request->all(), 'CustomerDuty,CustomerDutyDetail');
                return redirect()->route('customerduty.create', ['start_date' => $request->start_date, 'end_date' => $request->end_date])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                //return redirect()->route('customerduty.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
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
        $jobposts = JobPost::all();
        $customer = Customer::all();
        $employee = Employee::all();
        $custduty = CustomerDuty::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::all();
        $atm = Atm::all();
        $hours = Hour::get();
        return view('customer_duty.edit', compact('jobposts', 'customer', 'custduty', 'employee', 'branch', 'atm', 'hours'));
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
        //dd($request->all());
        // Validation Rules
        $rules = [
            'job_post_id' => 'required|array',
            'job_post_hour' => 'required|array',
            'total_duty_amount' => 'required|numeric',
        ];
        $messages = [
            'job_post_id.*.required' => 'Job post ID is required for each employee.',
            'job_post_hour.*.required' => 'Job post hour is required for each employee.',
        ];
        // Validate Request
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $data = CustomerDuty::findOrFail(encryptor('decrypt', $id));
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
            if ($data->save()) {
                if ($request->employee_id) {
                    $dl = CustomerDutyDetail::where('customerduty_id', $data->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new CustomerDutyDetail;
                            $details->customerduty_id = $data->id;
                            $details->employee_id = $request->employee_id[$key];

                            // Query the employeeratedetails table to get the job_post_hour by the primary key (job_post_id)
                            $employeeRate = EmployeeRateDetails::find($request->job_post_id[$key]);

                            // Check if we found a valid entry
                            if ($employeeRate) {
                                //$job_post_id = $employeeRate->job_post_id;
                                $details->job_post_id = $employeeRate->job_post_id;
                                $details->employee_salary_id = $employeeRate->id;
                            } else {
                                // Exist Employee Need to Check with Employe Salary Id

                                $employeeRate = EmployeeRateDetails::find($request->employee_salary_id[$key]);
                                if ($employeeRate) {
                                    $details->job_post_id = $employeeRate->job_post_id;
                                    $details->employee_salary_id = $employeeRate->id;
                                } else {
                                    //$job_post_id = 0; // Or set to a default value if no rate is found
                                    dd($request->employee_id[$key]);
                                    return redirect()->back()->withInput()->with(Toastr::error('Employee rate not found!', 'Fail', ["positionClass" => "toast-top-right"]));
                                }
                            }



                            $details->customer_id = $request->customer_id;
                            $details->hours = $request->job_post_hour[$key];

                            /*== New Column ==*/
                            $details->absent = $request->absent[$key];
                            $details->vacant = $request->vacant[$key];
                            $details->holiday_festival = $request->holiday_festival[$key];
                            $details->leave_cl = $request->leave_cl[$key];
                            $details->leave_sl = $request->leave_sl[$key];
                            $details->leave_el = $request->leave_el[$key];

                            $details->duty_rate = $request->duty_rate[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->total_amount = $request->total_amount[$key];
                            $details->start_date = $request->start_date_details[$key];
                            $details->end_date = $request->end_date_details[$key];
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }
                DB::commit();
            }
            if ($data->save()) {
                return redirect()->route('customerduty.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $c = CustomerDuty::findOrFail(encryptor('decrypt', $id));
        $dl = CustomerDutyDetail::where('customerduty_id', $c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
    public function copy($id)
    {
        try {
            $originalDuty = CustomerDuty::with('details')->findOrFail($id);

            // Calculate new start and end dates for the next month
            $newStartDate = Carbon::parse($originalDuty->start_date)->addMonth()->startOfMonth();
            $newEndDate = Carbon::parse($originalDuty->start_date)->addMonth()->endOfMonth();

            /*// Check if a CustomerDuty with the same start and end dates already exists
            $existingDuty = CustomerDuty::where('start_date', $newStartDate)
            ->where('end_date', $newEndDate)
            ->where('customer_id', $originalDuty->customer_id)
            ->where('branch_id', $originalDuty->branch_id)
            ->first();

            if ($existingDuty) {
                return response()->json(['error' => 'A duty with the same start and end dates already exists.'], 400);
            }*/

            // Create a new CustomerDuty instance
            $newDuty = $originalDuty->replicate();
            $newDuty->start_date = $newStartDate;
            $newDuty->end_date = $newEndDate;
            $newDuty->save();

            // Copy details
            foreach ($originalDuty->details as $detail) {
                // Calculate the total number of days in the month
                $totalDaysInMonth = $newStartDate->daysInMonth;
                $newDetail = $detail->replicate();
                $newDetail->customerduty_id = $newDuty->id;
                $newDetail->start_date = $newStartDate;
                $newDetail->end_date = $newEndDate;
                // Set the duty_qty to the total number of days in the month
                $newDetail->duty_qty = $totalDaysInMonth;
                $newDetail->save();
            }

            return response()->json(['success' => 'Data copied successfully!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to copy data.'], 500);
        }
    }
}
