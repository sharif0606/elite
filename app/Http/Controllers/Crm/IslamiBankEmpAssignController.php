<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Atm;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Crm\IslamiBankEmpAssign;
use App\Models\JobPost;
use App\Models\Settings\Branch;
use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\EmployeeRateDetails;
use App\Models\Crm\IslamiBankEmpAssignDetails;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class IslamiBankEmpAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $islamiBankEmpAssign = [];
        $islamiBankEmpAssign = IslamiBankEmpAssign::with('details')->get();
        return view('islami_bank_assign.index', compact('islamiBankEmpAssign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobpost = JobPost::get();
        $customer = Customer::where('id', 66)->limit(1)->get();
        $branch = CustomerBrance::where('customer_id', 66)
            ->select('id', 'brance_name')
            ->orderBy('brance_name', 'asc')
            ->get();
        $employee = Employee::select('id', 'admission_id_no', 'en_applicants_name')->get();
        return view('islami_bank_assign.create', compact('customer', 'jobpost', 'employee', 'branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {

            // check if job post is not null
            if ($request->job_post_id) {
                $jobPost = JobPost::where('id', $request->job_post_id)->first();
                if (!$jobPost) {
                    return redirect()->back()->withInput()->with(Toastr::error('Job post not found!', 'Fail', ["positionClass" => "toast-top-right"]));
                }
            }
            // check if customer already assign
            // $customerAssign = IslamiBankEmpAssign::where('customer_id', $request->customer_id)->first();
            // if ($customerAssign) {
            //     return redirect()->back()->withInput()->with(Toastr::error('Customer already assign!', 'Fail', ["positionClass" => "toast-top-right"]));
            // }


            $data = new IslamiBankEmpAssign;
            $data->customer_id = $request->customer_id;
            $data->company_branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary ?? 0;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 0;
            if ($data->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new IslamiBankEmpAssignDetails();
                            $details->islami_bank_emp_assign_id = $data->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->job_post_id = $request->job_post_id[$key];
                            // $details->area = $request->area[$key];
                            // $details->employee_name = $request->employee_name[$key];
                            // $details->duty_rate = $request->duty_rate[$key] ?? 0;
                            $details->duty = $request->duty[$key] ?? 0;
                            // $details->hours = $request->hours[$key] ?? 0;
                            $details->shift = $request->shift[$key] ?? 1;
                            // $details->account_no = $request->account_no[$key];
                            // $details->salary_amount = $request->salary_amount[$key];
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \App\Helpers\LogActivity::addToLog('Islami Bank Employee Assign', $request->getContent(), 'IslamiBankEmpAssign,IslamiBankEmpAssignDetails');
                return redirect()->route('islamiBankEmpAssign.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\IslamiBankEmpAssign  $islamiBankEmpAssign
     * @return \Illuminate\Http\Response
     */
    public function show(IslamiBankEmpAssign $islamiBankEmpAssign)
    {
        dd($islamiBankEmpAssign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IslamiBankEmpAssign  $islamiBankEmpAssign
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encryptor('decrypt', $id);
        $islamiBankEmpAssign = IslamiBankEmpAssign::with('details')->find($id);
        // dd($islamiBankEmpAssign);
        $jobpost = JobPost::get();
        $customer = Customer::where('id', 66)->limit(1)->get();
        $branch = CustomerBrance::where('customer_id', 66)
            ->select('id', 'brance_name')
            ->orderBy('brance_name', 'asc')
            ->get();
        $employee = Employee::select('id', 'admission_id_no', 'en_applicants_name')->get();
        $atms = Atm::where('branch_id', $islamiBankEmpAssign->company_branch_id)->orderBy('atm', 'asc')->get();
        // dd($islamiBankEmpAssign);
        return view('islami_bank_assign.edit', compact('customer', 'jobpost', 'employee', 'branch', 'islamiBankEmpAssign', 'atms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IslamiBankEmpAssign  $islamiBankEmpAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Check if job post exists (optional)
            if ($request->job_post_id) {
                if (is_array($request->job_post_id)) {
                    foreach ($request->job_post_id as $jobPostId) {
                        if (!JobPost::where('id', $jobPostId)->exists()) {
                            return redirect()->back()->withInput()->with(Toastr::error('One or more job posts not found!', 'Fail', ["positionClass" => "toast-top-right"]));
                        }
                    }
                } else {
                    if (!JobPost::where('id', $request->job_post_id)->exists()) {
                    return redirect()->back()->withInput()->with(Toastr::error('Job post not found!', 'Fail', ["positionClass" => "toast-top-right"]));
                }
            }
            }

            $data = IslamiBankEmpAssign::findOrFail(decrypt($id));
            $data->customer_id = $request->customer_id;
            $data->company_branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->add_commission = $request->add_commission;
            $data->vat_on_commission = $request->vat_on_commission;
            $data->ait_on_commission = $request->ait_on_commission;
            $data->vat_on_subtotal = $request->vat_on_subtotal;
            $data->ait_on_subtotal = $request->ait_on_subtotal;
            $data->sub_total_salary = $request->sub_total_salary ?? 0;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 0;

            if ($data->save()) {
                // Delete all previous details once, outside the loop
                IslamiBankEmpAssignDetails::where('islami_bank_emp_assign_id', $data->id)->delete();

                // Save updated employee details
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new IslamiBankEmpAssignDetails();
                            $details->islami_bank_emp_assign_id = $data->id;
                            $details->employee_id = $value;
                            $details->job_post_id = $request->job_post_id[$key] ?? null;
                            $details->duty = $request->duty[$key] ?? 0;
                            $details->shift = $request->shift[$key] ?? 1;
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }

                \App\Helpers\LogActivity::addToLog('Islami Bank Employee Assign Updated', $request->getContent(), 'IslamiBankEmpAssign,IslamiBankEmpAssignDetails');

                return redirect()->route('islamiBankEmpAssign.index', ['role' => currentUser()])
                    ->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()
                    ->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            dd($e); // Consider logging this instead of dd in production
            return redirect()->back()->withInput()
                ->with(Toastr::error('An error occurred. Please try again.', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IslamiBankEmpAssign  $islamiBankEmpAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = encryptor('decrypt', $id);
        $islamiBankEmpAssign = IslamiBankEmpAssign::find($id);
        // delete from islami_bank_emp_assign_details
        $islamiBankEmpAssign->details()->delete();
        $islamiBankEmpAssign->delete();
        return redirect()->back()->with(Toastr::success('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }


    // !API
    public function getAtmsByCompany(Request $request)
    {
        $atms = Atm::where('company_id', $request->company_id)->get();
        return response()->json($atms);
    }

    public function islamiBankGetEmployee(Request $request)
    {
        $data = Employee::where('id', $request->id)
            // ->select('id', 'admission_id_no', 'en_applicants_name', 'second_ac_no', 'bn_jobpost_id', '')
            ->with('position')
            ->get();
        // employee rate
        $employeeRate = EmployeeRateDetails::where('employee_id', $request->id)
            ->select('duty_rate', 'id', 'ot_rate', 'hours')
            ->with('employee')
            ->first();

        return response()->json(['employee' => $data, 'rate' => $employeeRate]);
    }

    public function islamiBankGetRate(Request $request)
    {
        // dd($request->all());
        $data = EmployeeRateDetails::where('employee_id', $request->employeeId)
            ->select('duty_rate', 'id', 'ot_rate', 'hours')
            ->with('employee')
            ->first();
        $rate = 0;
        $hours = 0;
        $ot_rate = 0;
        if ($request->atmId) {
            $rate = EmployeeRateDetails::where('atm_id', $request->atmId)
                ->with('hour')
                ->first();
            $rate = $rate->duty_rate ?? 0;
            $hours = $rate->hour->hour ?? 0;
            $ot_rate = $rate->ot_rate ?? 0;
        }
        if ($rate == 0) {
            $branch = CustomerBrance::where('id', $request->branchId)->where('billing_rate', '>', 0)->first();
            $rate = $branch->billing_rate ?? 0;
        }

        return response()->json(['employee' => $data, 'rate' => $rate, 'hours' => $hours, 'ot_rate' => $ot_rate]);
    }
}