<?php

namespace App\Http\Controllers\Hrm;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Hrm\SalarySheet;
use App\Models\Hrm\SalarySheetDetail;
use App\Models\Crm\CustomerDuty;
use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerDutyDetail;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Crm\CustomerBrance;
use App\Models\Employee\Employee;
use App\Models\JobPost;
use App\Models\payroll\LongLoan;
use App\Models\Settings\Zone;

class SalarySheetController extends Controller
{

    public function index()
    {
        //
    }
    public function getsalarySheetOneIndex()
    {
        $salarysheet = SalarySheet::where('status', 1)->get();
        return view('hrm.salary_sheet.salarysheetOneIndex', compact('salarysheet'));
    }
    public function getsalarySheetTwoIndex()
    {
        $salarysheet = SalarySheet::where('status', 2)->get();
        return view('hrm.salary_sheet.salarysheetTwoIndex', compact('salarysheet'));
    }
    public function getsalarySheetThreeIndex()
    {
        $salarysheet = SalarySheet::where('status', 3)->get();
        return view('hrm.salary_sheet.salarysheetThreeIndex', compact('salarysheet'));
    }
    public function getsalarySheetFourIndex()
    {
        $salarysheet = SalarySheet::where('status', 4)->get();
        return view('hrm.salary_sheet.salarysheetFourIndex', compact('salarysheet'));
    }
    public function getsalarySheetFiveIndex()
    {
        $salarysheet = SalarySheet::with('details.customer_atm', 'details.branches', 'customer')->where('status', 5)->orderBy('id', 'desc')->paginate(50);
        return view('hrm.salary_sheet.salarysheetFiveIndex', compact('salarysheet'));
    }


    public function create()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.create', compact('customer'));
    }
    public function getsalarySheetOne()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.salarysheetOne', compact('customer'));
    }
    public function getsalarySheetTwo()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.salarysheetTwo', compact('customer'));
    }
    public function salarySheetThree()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.salarysheetThree', compact('customer'));
    }
    public function salarySheetFour()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.salarysheetFour', compact('customer'));
    }
    public function salarySheetFive()
    {
        $customer = Customer::all();
        return view('hrm.salary_sheet.salarysheetFive', compact('customer'));
    }

    public function salarySheetOneStore(Request $request)
    {
        // dd($request->all());
        // die();
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 1;
            if ($salary->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->fixed_ot = $request->fixed_ot[$key];
                            $details->leave = $request->leave[$key];
                            $details->arrear = $request->arrear[$key];
                            $details->allownce = $request->allownce[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_mobilebill = $request->deduction_mobilebill[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_long_loan = $request->deduction_long_loan[$key];
                            $details->deduction_cloth = $request->deduction_cloth[$key];
                            $details->deduction_jacket = $request->deduction_jacket[$key];
                            $details->deduction_hr = $request->deduction_hr[$key];
                            $details->deduction_traningcost = $request->deduction_traningcost[$key];
                            $details->deduction_c_f = $request->deduction_c_f[$key];
                            $details->deduction_medical = $request->deduction_medical[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_revenue_stamp = $request->deduction_revenue_stamp[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_salary[$key];
                            $details->common_net_salary = $request->net_salary[$key];
                            $details->sing_of_ind = $request->sing_of_ind[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetOneIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function editSalaryOne($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer = Customer::all();
        $branch = CustomerBrance::select('id', 'brance_name', 'customer_id')->whereIn('customer_id', $selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id', $salary->id)->get();
        return view('hrm.salary_sheet.salarysheetOneEdit', compact('salary', 'salaryDetail', 'customer', 'branch', 'selectedCustomerIds', 'selectedCustomerIdsNot', 'branchIds', 'atmIds'));
    }
    public function salarySheetOneUpdate(Request $request, $id)
    {
        // dd($request->all());
        // die();
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 1;
            if ($salary->save()) {
                if ($request->employee_id) {
                    SalarySheetDetail::where('salary_id', $salary->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->fixed_ot = $request->fixed_ot[$key];
                            $details->leave = $request->leave[$key];
                            $details->arrear = $request->arrear[$key];
                            $details->allownce = $request->allownce[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_mobilebill = $request->deduction_mobilebill[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_long_loan = $request->deduction_long_loan[$key];
                            $details->deduction_cloth = $request->deduction_cloth[$key];
                            $details->deduction_jacket = $request->deduction_jacket[$key];
                            $details->deduction_hr = $request->deduction_hr[$key];
                            $details->deduction_traningcost = $request->deduction_traningcost[$key];
                            $details->deduction_c_f = $request->deduction_c_f[$key];
                            $details->deduction_medical = $request->deduction_medical[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_revenue_stamp = $request->deduction_revenue_stamp[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_salary[$key];
                            $details->common_net_salary = $request->net_salary[$key];
                            $details->sing_of_ind = $request->sing_of_ind[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetOneIndex')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function salarySheetTwoStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 2;
            if ($salary->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->online_payment = $request->payment_type[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->weekly_leave = $request->weekly_leave[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->leave = $request->leave[$key];
                            $details->arrear = $request->arrear[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_long_loan = $request->deduction_longLoan[$key];
                            $details->deduction_cloth = $request->deduction_cloth[$key];
                            $details->deduction_hr = $request->deduction_hr[$key];
                            $details->deduction_jacket = $request->deduction_jacket[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stamp[$key];
                            $details->deduction_traningcost = $request->deduction_traningCost[$key];
                            $details->deduction_c_f = $request->deduction_c_f[$key];
                            $details->deduction_medical = $request->deduction_medical[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_salary[$key];
                            $details->common_net_salary = $request->net_salary[$key];
                            $details->sing_of_ind = $request->signature[$key];
                            // uncommon
                            $details->ht_ribon_alice = $request->ht_ribon_alice[$key];
                            $details->gun_alice = $request->gun_alice[$key];
                            $details->extra_alice = $request->extra_alice[$key];
                            $details->bonus = $request->bonus[$key];
                            $details->donation = $request->donation[$key];
                            $details->deduction_matterss_pillowCost = $request->deduction_matterss_pillowCost[$key];
                            $details->deduction_tonic_sim = $request->deduction_tonic_sim[$key];
                            $details->deduction_over_paymentCut = $request->deduction_over_paymentCut[$key];
                            $details->zone = $request->zone[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Two', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetTwoIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function editSalaryTwo($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer = Customer::all();
        $branch = CustomerBrance::select('id', 'brance_name', 'customer_id')->whereIn('customer_id', $selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id', $salary->id)->get();
        return view('hrm.salary_sheet.salarysheetTwoEdit', compact('salary', 'salaryDetail', 'customer', 'branch', 'selectedCustomerIds', 'selectedCustomerIdsNot', 'branchIds', 'atmIds'));
    }
    public function salarySheetTwoUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by = currentUserId();
            $salary->status = 2;
            if ($salary->save()) {
                if ($request->employee_id) {
                    SalarySheetDetail::where('salary_id', $salary->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->online_payment = $request->payment_type[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->weekly_leave = $request->weekly_leave[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->leave = $request->leave[$key];
                            $details->arrear = $request->arrear[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_long_loan = $request->deduction_longLoan[$key];
                            $details->deduction_cloth = $request->deduction_cloth[$key];
                            $details->deduction_hr = $request->deduction_hr[$key];
                            $details->deduction_jacket = $request->deduction_jacket[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stamp[$key];
                            $details->deduction_traningcost = $request->deduction_traningCost[$key];
                            $details->deduction_c_f = $request->deduction_c_f[$key];
                            $details->deduction_medical = $request->deduction_medical[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_salary[$key];
                            $details->common_net_salary = $request->net_salary[$key];
                            $details->sing_of_ind = $request->signature[$key];
                            // uncommon
                            $details->ht_ribon_alice = $request->ht_ribon_alice[$key];
                            $details->gun_alice = $request->gun_alice[$key];
                            $details->extra_alice = $request->extra_alice[$key];
                            $details->bonus = $request->bonus[$key];
                            $details->donation = $request->donation[$key];
                            $details->deduction_matterss_pillowCost = $request->deduction_matterss_pillowCost[$key];
                            $details->deduction_tonic_sim = $request->deduction_tonic_sim[$key];
                            $details->deduction_over_paymentCut = $request->deduction_over_paymentCut[$key];
                            $details->zone = $request->zone[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Two', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetTwoIndex')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function salarySheetThreeStore(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 3;
            if ($salary->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->year = $request->year;
                            $details->month = $request->month;
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->house_rent = $request->house_rent[$key];
                            $details->medical = $request->medical[$key];
                            $details->trans_conve = $request->trans_conve[$key];
                            $details->food_allownce = $request->food_allownce[$key];
                            $details->allownce = $request->post_allowance[$key];
                            $details->gross_wages = $request->gross_wages[$key];
                            $details->total_workingday = $request->total_workingDay[$key];
                            $details->present_day = $request->present_day[$key];
                            $details->absent = $request->absent[$key];
                            $details->vacant = $request->vacant[$key];
                            $details->holiday_festival = $request->holiday_festival[$key];
                            $details->leave_cl = $request->leave_cl[$key];
                            $details->leave_sl = $request->leave_sl[$key];
                            $details->leave_el = $request->leave_el[$key];
                            $details->deduction_absent = $request->deduction_absent[$key];
                            $details->deduction_vacant = $request->deduction_vacant[$key];
                            $details->deduction_hr = $request->deduction_h_rent[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_adv = $request->deduction_adv[$key];
                            $details->deduction_traningcost = $request->deduction_training_cost[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stm[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_wages[$key];
                            $details->ot_qty = $request->ot_hour[$key];
                            $details->ot_rate_basicDuble = $request->ot_rate_basicDuble[$key];
                            $details->ot_amount = $request->ot_amt[$key];
                            $details->total_payable = $request->total_payable[$key];
                            $details->common_net_salary = $details->total_payable;
                            $details->sing_of_ind = $request->signature[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Three', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetThreeIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function editSalaryThree($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer = Customer::all();
        $branch = CustomerBrance::select('id', 'brance_name', 'customer_id')->whereIn('customer_id', $selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id', $salary->id)->get();
        return view('hrm.salary_sheet.salarysheetThreeEdit', compact('salary', 'salaryDetail', 'customer', 'branch', 'selectedCustomerIds', 'selectedCustomerIdsNot', 'branchIds', 'atmIds'));
    }
    public function salarySheetThreeUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by = currentUserId();
            $salary->status = 3;
            if ($salary->save()) {
                if ($request->employee_id) {
                    SalarySheetDetail::where('salary_id', $salary->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->house_rent = $request->house_rent[$key];
                            $details->medical = $request->medical[$key];
                            $details->trans_conve = $request->trans_conve[$key];
                            $details->food_allownce = $request->food_allownce[$key];
                            $details->gross_wages = $request->gross_wages[$key];
                            $details->total_workingday = $request->total_workingDay[$key];
                            $details->present_day = $request->present_day[$key];
                            $details->absent = $request->absent[$key];
                            $details->vacant = $request->vacant[$key];
                            $details->holiday_festival = $request->holiday_festival[$key];
                            $details->leave_cl = $request->leave_cl[$key];
                            $details->leave_sl = $request->leave_sl[$key];
                            $details->leave_el = $request->leave_el[$key];
                            $details->deduction_absent = $request->deduction_absent[$key];
                            $details->deduction_vacant = $request->deduction_vacant[$key];
                            $details->deduction_hr = $request->deduction_h_rent[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_adv = $request->deduction_adv[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stm[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->net_wages[$key];
                            $details->ot_qty = $request->ot_hour[$key];
                            $details->ot_rate_basicDuble = $request->ot_rate_basicDuble[$key];
                            $details->ot_amount = $request->ot_amt[$key];
                            $details->total_payable = $request->total_payable[$key];
                            $details->common_net_salary = $details->total_payable;
                            $details->sing_of_ind = $request->signature[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Three', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetThreeIndex')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function salarySheetFourStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 4;
            if ($salary->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->house_rent = $request->house_rent[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            //$details->duty_amount=$request->duty_amount[$key];
                            $details->medical = $request->medical_allowance[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->allownce = $request->post_allow[$key];
                            $details->fuel_bill = $request->fuel_bill[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->total_salary_of_salary_sheet_four = $request->total_salary[$key];
                            $details->deduction_mobilebill = $request->deduction_excess_mobile[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_traningcost = $request->deduction_traning_cost[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_mess = $request->deduction_mess[$key];
                            // uncommon
                            $details->total_payable = $request->total_payble[$key];
                            $details->common_net_salary = $request->total_payble[$key];
                            $details->sing_of_ind = $request->signature_ind[$key];
                            $details->sing_account = $request->signature_accounts[$key];
                            $details->remark = $request->remarks[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Four', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetFourIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function editSalaryFour($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $salaryDetail = SalarySheetDetail::where('salary_id', $salary->id)->get();
        return view('hrm.salary_sheet.salarysheetFourEdit', compact('salary', 'salaryDetail'));
    }
    public function salarySheetFourUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by = currentUserId();
            $salary->status = 4;
            if ($salary->save()) {
                if ($request->employee_id) {
                    SalarySheetDetail::where('salary_id', $salary->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->house_rent = $request->house_rent[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            //$details->duty_amount=$request->duty_amount[$key];
                            $details->medical = $request->medical_allowance[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->allownce = $request->post_allow[$key];
                            $details->fuel_bill = $request->fuel_bill[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->total_salary_of_salary_sheet_four = $request->total_salary[$key];
                            $details->deduction_mobilebill = $request->deduction_excess_mobile[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_traningcost = $request->deduction_traning_cost[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_p_f[$key];
                            $details->deduction_mess = $request->deduction_mess[$key];
                            // uncommon
                            $details->total_payable = $request->total_payble[$key];
                            $details->common_net_salary = $request->total_payble[$key];
                            $details->sing_of_ind = $request->signature_ind[$key];
                            $details->sing_account = $request->signature_accounts[$key];
                            $details->remark = $request->remarks[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Four', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetFourIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function salarySheetFiveStore(Request $request)
    {
        //dd($request->all()); die();
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by = currentUserId();
            $salary->status = 5;
            if ($salary->save()) {
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->year = $request->year;
                            $details->month = $request->month;
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->divided_by = $request->divided_by[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->allownce = $request->post_allowance[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_traningcost = $request->deduction_training_cost[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_pf[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stamp[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->total_payable[$key];
                            $details->common_net_salary = $request->total_payable[$key];
                            $details->sing_of_ind = $request->sing_ind[$key];
                            $details->sing_account = $request->sing_account[$key];
                            $details->deduction_dress = $request->deduction_dress[$key];
                            $details->deduction_banck_charge = $request->deduction_banck_charge[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            if ($details->save()) {
                                // Find the LongLoan record by ID
                                $long_loan = LongLoan::find($request->long_loan_id[$key]);

                                // Check if the loan is found
                                if ($long_loan) {
                                    // Subtract the deduction_loan from the current loan_balance
                                    $long_loan->loan_balance -= $request->deduction_loan[$key];

                                    // If loan_balance reaches 0, mark the loan as fully paid
                                    if ($long_loan->loan_balance == 0) {
                                        $long_loan->status = 1; // Loan fully paid
                                    }

                                    // Save the updated LongLoan record
                                    $long_loan->save();
                                }
                            }

                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetFiveIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function editSalaryFive($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer = Customer::all();
        $branch = CustomerBrance::select('id', 'brance_name', 'customer_id')->whereIn('customer_id', $selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id', $salary->id)->get();
        return view('hrm.salary_sheet.salarySheetFiveEdit', compact('salary', 'salaryDetail', 'customer', 'branch', 'selectedCustomerIds', 'selectedCustomerIdsNot', 'branchIds', 'atmIds'));
    }

    public function salarySheetFiveUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
            $salary->customer_id = $request->customer_id ? implode(',', $request->customer_id) : '';
            $salary->customer_id_not = $request->customer_id_not ? implode(',', $request->customer_id_not) : '';
            if ($request->branch_id) {
                $salary->branch_id = $request->branch_id ? implode(',', $request->branch_id) : '';
            } else {
                $salary->branch_id = $request->customer_branch_id ? implode(',', $request->customer_branch_id) : '';
            }
            $salary->atm_id = $request->customer_atm_id ? implode(',', $request->customer_atm_id) : '';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by = currentUserId();
            $salary->status = 5;
            if ($salary->save()) {
                if ($request->employee_id) {
                    SalarySheetDetail::where('salary_id', $salary->id)->delete();
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $details = new SalarySheetDetail;
                            $details->salary_id = $salary->id;
                            $details->employee_id = $request->employee_id[$key];
                            $details->designation_id = $request->designation_id[$key];
                            $details->customer_id = $request->customer_id_ind[$key];
                            $details->branch_id = $request->customer_branch_id[$key];
                            $details->atm_id = $request->customer_atm_id[$key];
                            $details->divided_by = $request->divided_by[$key];
                            $details->duty_rate = $request->duty_rate[$key];
                            $details->duty_qty = $request->duty_qty[$key];
                            $details->duty_amount = $request->duty_amount[$key];
                            $details->ot_qty = $request->ot_qty[$key];
                            $details->ot_rate = $request->ot_rate[$key];
                            $details->ot_amount = $request->ot_amount[$key];
                            $details->allownce = $request->post_allowance[$key];
                            $details->gross_salary = $request->gross_salary[$key];
                            $details->deduction_fine = $request->deduction_fine[$key];
                            $details->deduction_loan = $request->deduction_loan[$key];
                            $details->deduction_traningcost = $request->deduction_training_cost[$key];
                            $details->deduction_ins = $request->deduction_ins[$key];
                            $details->deduction_p_f = $request->deduction_pf[$key];
                            $details->deduction_revenue_stamp = $request->deduction_stamp[$key];
                            $details->deduction_total = $request->deduction_total[$key];
                            $details->net_salary = $request->total_payable[$key];
                            $details->common_net_salary = $request->total_payable[$key];
                            $details->sing_of_ind = $request->sing_ind[$key];
                            $details->sing_account = $request->sing_account[$key];
                            $details->deduction_dress = $request->deduction_dress[$key];
                            $details->deduction_banck_charge = $request->deduction_banck_charge[$key];
                            $details->remark = $request->remark[$key];
                            $details->status = 0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet', $request->getContent(), 'SalarySheet,SalarySheetDetail');
                return redirect()->route('salarysheet.salarySheetFiveIndex')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }
    public function getsalarySheetOneShow($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $customerIds = explode(',', $salary->customer_id);
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function ($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();

        foreach ($salaryDetails as $detail) {
            if (
                in_array($detail->customer_id, $customerIds) &&
                (empty($branchIds) || in_array($detail->branch_id, $branchIds) || $detail->branch_id == 0)
            ) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }
        //dd($salary);
        return view('hrm.salary_sheet.salarysheetOneShow', compact('salary', 'groupedData'));
    }
    public function getsalarySheetTwoShow($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $customerIds = explode(',', $salary->customer_id);
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function ($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }
        return view('hrm.salary_sheet.salarysheetTwoShow', compact('salary', 'groupedData'));
    }
    // public function salarySheetThreeShow($id)
    // {
    //     $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
    //     $customerIds = explode(',', $salary->customer_id);
    //     $branchIds = explode(',', $salary->branch_id);

    //     $groupedData = [];

    //     $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();
    //     foreach ($salaryDetails as $detail) {
    //         if (in_array($detail->customer_id, $customerIds) && in_array($detail->branch_id, $branchIds)) {
    //             $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
    //         }
    //     }
    //     return view('hrm.salary_sheet.salarysheetThreeShow',compact('salary','groupedData'));
    // }
    public function salarySheetThreeShow($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $customerIds = explode(',', $salary->customer_id);
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function ($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::select('salary_sheet_details.*', 'job_posts.serial')
            ->join('job_posts', 'salary_sheet_details.designation_id', '=', 'job_posts.id')
            ->where('salary_sheet_details.salary_id', $salary->id)
            ->orderBy('job_posts.serial', 'ASC')
            ->get();


        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) || (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }



        return view('hrm.salary_sheet.salarysheetThreeShow', compact('salary', 'groupedData'));
    }



    public function salarySheetFourShow($id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        $details = SalarySheetDetail::where('salary_id', $salary->id)
            ->with(['employee' => function ($query) {
                $query->orderBy('salary_serial', 'ASC');
            }])
            ->get();

        // Sort the details collection by the related employee's salary_serial
        $details = $details->sortBy(function ($detail) {
            return $detail->employee->salary_serial;
        });
        return view('hrm.salary_sheet.salarysheetFourShow', compact('salary', 'details'));
    }
    // public function getsalarySheetFiveShow($id)
    // {
    //     $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
    //     //return $salary;
    //     return view('hrm.salary_sheet.salarysheetFiveShow',compact('salary'));
    // }
    public function getsalarySheetFiveShow(Request $request, $id)
    {
        $groupedData = [];

        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));

        $customerIds = explode(',', $salary->customer_id);
        $customer = Customer::whereIn('id', $customerIds)->get();
        $designationIds = SalarySheetDetail::where('salary_id', $salary->id)->pluck('designation_id');
        $designation = JobPost::whereIn('id', $designationIds)->get();
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function ($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id);

        if ($request->customer_id) {
            $salaryDetails = $salaryDetails->where('customer_id', $request->customer_id);
        }

        if ($request->branch_id) {
            $salaryDetails = $salaryDetails->where('branch_id', $request->branch_id);
        }

        if ($request->designation_id) {
            $salaryDetails = $salaryDetails->where('designation_id', $request->designation_id);
        }

        $salaryDetails = $salaryDetails->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $customerId = $detail->customer_id;
                $branchId = $detail->branch_id;

                if (!empty($detail->atm_id)) {
                    // Store ATM-related data under 'atm'
                    $groupedData[$customerId][$branchId]['atm'][] = $detail;
                } else {
                    // Store Non-ATM data under 'non_atm'
                    $groupedData[$customerId][$branchId]['non_atm'][] = $detail;
                }
            }
        }
        return view('hrm.salary_sheet.salarysheetFiveShowBranch', [
            'salary' => $salary,
            'customer' => $customer,
            'designation' => $designation,
            'groupedData' => $groupedData,
        ]);
    }



    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function getSalaryBranch(Request $request)
    {
        $customerIds = $request->customer_ids;
        $branch = CustomerBrance::whereIn('customer_id', $customerIds)->select('id', 'brance_name')->get();
        return response()->json($branch, 200);
    }

    public function getSalaryData(Request $request)
    {
        //dd($request);
        $stdate = $request->start_date;
        $date = Carbon::parse($stdate);

        // Extract the year and month
        /*$year = $date->year;
        $month = $date->month;
        $salaryIds = SalarySheet::where('year',$year)->where('month',$month)->whereIn('customer_id',$request->customer_id)->pluck('id');
        $salaryGeneratedEmp = SalarySheetDetail::whereIn('salary_id',$salaryIds)->pluck('employee_id');

        $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
        ->join('job_posts','customer_duty_details.job_post_id','=','job_posts.id')
        ->join('employees','customer_duty_details.employee_id','=','employees.id')
        ->leftjoin('deductions', function ($join) use ($request) {
            $join->on('customer_duty_details.employee_id', '=', 'deductions.employee_id')
                 ->where('deductions.month', '=', $request->Month)
                 ->where('deductions.year', '=', $request->Year);
        })
        ->leftjoin('long_loans', function ($j) use ($stdate) {
            $j->on('customer_duty_details.employee_id', '=', 'long_loans.employee_id')
                 ->whereDate('long_loans.installment_date', '<=',$stdate)
                 ->whereDate('long_loans.end_date', '>=',$stdate)
                 ->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
        })
        ->leftJoin('customer_brances','customer_duties.branch_id','=','customer_brances.id')
        ->leftJoin('customers','customer_duties.customer_id','=','customers.id')
        ->select('customer_duties.*','deductions.*','customer_duty_details.*','customer_brances.brance_name as customer_branch','customers.name as customer_name','long_loans.id as long_loan_id','long_loans.perinstallment_amount','job_posts.id as jobpost_id','job_posts.name as jobpost_name','employees.id as employee_id','employees.admission_id_no','employees.en_applicants_name','employees.salary_joining_date','employees.bn_traning_cost','employees.bn_traning_cost_byMonth','employees.salary_status','employees.bn_remaining_cost','employees.bn_post_allowance','employees.bn_fuel_bill','employees.bn_food_allowance','employees.insurance','employees.p_f',DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'))
        ->whereNotIn('employees.id',$salaryGeneratedEmp)
        ->orderBy('admission_id_no','ASC')
        ->orderBy('customer_duty_details.duty_qty','DESC');

        if ($request->start_date && $request->end_date){
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '>=',$startDate )
                        ->whereDate('customer_duty_details.end_date', '<=', $endDate);
                });
            });
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $query->whereIn('customer_duties.customer_id', $customerId);
        }
        if ($request->customer_branch_id){
            $branchId = $request->customer_branch_id;
            $query->whereIn('customer_duties.branch_id', $branchId);
        }
        if ($request->CustomerIdNot){
            $CustomerIdNot = $request->CustomerIdNot;
            $query->whereNotIn('customer_duties.customer_id', $CustomerIdNot);
        }
        $data = $query->get();*/


        // Extract the year and month
        /*$year = $date->year;
        $month = $date->month;
        $salaryIds = SalarySheet::where('year',$year)->where('month',$month)->whereIn('customer_id',$request->customer_id)->pluck('id');
        $salaryGeneratedEmp = SalarySheetDetail::whereIn('salary_id',$salaryIds)->pluck('employee_id');

        $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
        ->join('job_posts', 'customer_duty_details.job_post_id', '=', 'job_posts.id')
        ->join('employees', 'customer_duty_details.employee_id', '=', 'employees.id')
        ->leftJoin('deductions', function ($join) use ($request) {
            $join->on('customer_duty_details.employee_id', '=', 'deductions.employee_id')
                ->where('deductions.month', '=', $request->Month)
                ->where('deductions.year', '=', $request->Year);
        })
        ->leftJoin('long_loans', function ($j) use ($stdate) {
            $j->on('customer_duty_details.employee_id', '=', 'long_loans.employee_id')
                ->whereDate('long_loans.installment_date', '<=', $stdate)
                ->whereDate('long_loans.end_date', '>=', $stdate)
                ->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
        })
        ->leftJoin('customer_brances', 'customer_duties.branch_id', '=', 'customer_brances.id')
        ->leftJoin('customers', 'customer_duty_details.customer_id', '=', 'customers.id') // Using customer_id in customer_duty_details
        ->leftJoin('salary_sheet_details', function ($join) {
            $join->on('employees.id', '=', 'salary_sheet_details.employee_id');
        })
        ->leftJoin('salary_sheets', function ($join) use ($request) {
            $join->on('salary_sheet_details.salary_id', '=', 'salary_sheets.id')
                ->where('salary_sheets.year', '=', $request->Year)
                ->where('salary_sheets.month', '=', $request->Month);
        })
        ->select(
            'customer_duties.*',
            'deductions.*',
            'customer_duty_details.*',
            'customer_brances.brance_name as customer_branch',
            'customers.name as customer_name',
            'long_loans.id as long_loan_id',
            'long_loans.perinstallment_amount',
            'job_posts.id as jobpost_id',
            'job_posts.name as jobpost_name',
            'employees.id as employee_id',
            'employees.admission_id_no',
            'employees.en_applicants_name',
            'employees.salary_joining_date',
            'employees.bn_traning_cost',
            'employees.bn_traning_cost_byMonth',
            'employees.salary_status',
            'employees.bn_remaining_cost',
            'employees.bn_post_allowance',
            'employees.bn_fuel_bill',
            'employees.bn_food_allowance',
            'employees.insurance',
            'employees.p_f',
            DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'),
            DB::raw("IF(salary_sheet_details.deduction_ins IS NOT NULL OR salary_sheet_details.deduction_p_f IS NOT NULL, 1, 0) AS charge_status")
        )
        ->where(function ($query) use ($request) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->whereDate('customer_duties.start_date', '<=', $request->end_date)
                        ->whereDate('customer_duties.end_date', '>=', $request->start_date);
            });
        });
        // Ensure the query properly handles the salary sheet logic for data existence
        $dataExists = DB::table('salary_sheets')
        ->where('year', '=', $request->Year)
        ->where('month', '=', $request->Month)
        ->where('customer_id', '=', $request->customer_id);
    if ($dataExists->exists()) {
        $query->whereNotIn('customer_duties.branch_id', function ($query) use ($request) {
            $query->select('branch_id')
                ->from('salary_sheets')
                ->where('year', '=', $request->Year)
                ->where('month', '=', $request->Month)
                ->where('customer_id', '=', $request->customer_id);

            if ($request->customer_branch_id) {
                $query->where('branch_id', '=', $request->customer_branch_id);
            }
        });
    }

    if ($request->customer_id){
        $customerId = $request->customer_id;
        $query->whereIn('customer_duties.customer_id', $customerId);
    }
    
$query->where('customer_duty_details.customer_id', '=', $request->customer_id) // Filter by customer_id

    //->orderBy('admission_id_no', 'ASC')
    //->orderBy('customer_duty_details.duty_qty', 'DESC');
    ->orderBy('job_posts.serial', 'ASC');

    
        $data = $query->get();

        return response()->json($data, 200);*/


        // Aggregate subquery to check if charges exist
        /*$aggregateSubquery = DB::table('salary_sheet_details')
            ->select(
                'employee_id',
                DB::raw('SUM(CASE WHEN NOT (year = '.$request->Year.' AND month = '.$request->Month.') THEN deduction_traningcost ELSE 0 END) as total_deduction_traningcost_except_requested'),
                DB::raw("IF(
        SUM(deduction_ins IS NOT NULL OR deduction_p_f IS NOT NULL 
            OR allownce IS NOT NULL OR deduction_fine IS NOT NULL
            OR deduction_dress IS NOT NULL OR deduction_banck_charge IS NOT NULL
            OR deduction_revenue_stamp IS NOT NULL OR deduction_traningcost IS NOT NULL
            OR deduction_loan IS NOT NULL) > 0, 1, 0
    ) AS charge_status")
            )
            //->where('customer_id', $request->customer_id)
            ->where('year', $request->Year)
            ->where('month', $request->Month)
            ->groupBy('employee_id');*/

        $aggregateSubquery = DB::table('salary_sheet_details')
            ->select(
                'employee_id',
                'deduction_ins',
                'year',
                'month',
                // Exclude deduction_traningcost for requested year and month
                DB::raw('SUM(CASE WHEN NOT (year = ' . $request->Year . ' AND month = ' . $request->Month . ') THEN deduction_traningcost ELSE 0 END) as total_deduction_traningcost_except_requested'),

                // Keep other fields only for the requested year and month
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_ins ELSE 0 END) as total_deduction_ins'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_p_f ELSE 0 END) as total_deduction_p_f'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN allownce ELSE 0 END) as total_allowance'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_fine ELSE 0 END) as total_deduction_fine'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_dress ELSE 0 END) as total_deduction_dress'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_banck_charge ELSE 0 END) as total_deduction_banck_charge'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_revenue_stamp ELSE 0 END) as total_deduction_revenue_stamp'),
                DB::raw('SUM(CASE WHEN year = ' . $request->Year . ' AND month = ' . $request->Month . ' THEN deduction_loan ELSE 0 END) as total_deduction_loan'),

                // Charge status logic
                DB::raw("IF(
                    SUM(CASE 
                      WHEN year = {$request->Year} AND month = {$request->Month}
                           AND (
                                deduction_ins IS NOT NULL AND deduction_ins != 0 OR
                                deduction_p_f IS NOT NULL AND deduction_p_f != 0 OR
                                allownce IS NOT NULL AND allownce != 0 OR
                                deduction_fine IS NOT NULL AND deduction_fine != 0 OR
                                deduction_dress IS NOT NULL AND deduction_dress != 0 OR
                                deduction_banck_charge IS NOT NULL AND deduction_banck_charge != 0 OR
                                deduction_traningcost IS NOT NULL AND deduction_traningcost != 0 OR
                                deduction_loan IS NOT NULL AND deduction_loan != 0
                           ) 
                      THEN 1 
                      ELSE 0 
                    END
                  ) > 0,
                  1,
                  0
                ) AS charge_status"),
            )
            ->where('year', '>', 0)
            ->where('month', '>', 0)
            //->where('employee_id',675)
            /*->where('year', $request->Year)
            ->where('month', $request->Month)*/
            ->groupBy('employee_id');
        //dd($aggregateSubquery->get());
        $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
            ->join('job_posts', 'customer_duty_details.job_post_id', '=', 'job_posts.id')
            ->join('employees', 'customer_duty_details.employee_id', '=', 'employees.id')
            ->leftJoin('deductions', function ($join) use ($request) {
                $join->on('customer_duty_details.employee_id', '=', 'deductions.employee_id')
                    ->where('deductions.month', '=', $request->Month)
                    ->where('deductions.year', '=', $request->Year);
            })
            ->leftJoin('long_loans', function ($j) use ($stdate) {
                $j->on('customer_duty_details.employee_id', '=', 'long_loans.employee_id')
                    ->whereDate('long_loans.installment_date', '<=', $stdate)
                    ->whereDate('long_loans.end_date', '>=', $stdate)
                    ->where('long_loans.status', 0);
                //->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
            })
            ->leftJoin('customer_brances', 'customer_duties.branch_id', '=', 'customer_brances.id')
            ->leftJoin('customers', 'customer_duty_details.customer_id', '=', 'customers.id')
            ->leftJoin('salary_sheet_details', function ($join) use ($request) {
                $join->on('employees.id', '=', 'salary_sheet_details.employee_id')
                    ->where('salary_sheet_details.customer_id', $request->customer_id)
                    ->where('salary_sheet_details.year', '=', $request->Year)
                    ->where('salary_sheet_details.month', '=', $request->Month);
            })
            ->leftJoin('salary_sheets', function ($join) use ($request) {
                $join->on('salary_sheet_details.salary_id', '=', 'salary_sheets.id')
                    ->where('salary_sheets.customer_id', $request->customer_id)
                    ->where('salary_sheets.year', '=', $request->Year)
                    ->where('salary_sheets.month', '=', $request->Month);
            })
            ->leftJoinSub($aggregateSubquery, 'aggregate_data', function ($join) {
                $join->on('employees.id', '=', 'aggregate_data.employee_id');
            })
            ->select(
                'customer_duties.*',
                'deductions.*',
                'customer_duty_details.*',
                'customer_brances.brance_name as customer_branch',
                'customers.name as customer_name',
                'customers.insurance as cinsurance',
                'customers.pf as cpf',
                'customers.stamp as cstamp',
                'customers.medical as cmedical',
                'long_loans.installment_date',
                'long_loans.end_date',
                'long_loans.id as long_loan_id',
                'long_loans.perinstallment_amount',
                'long_loans.loan_amount',
                'long_loans.loan_balance',
                'job_posts.id as jobpost_id',
                'job_posts.name as jobpost_name',
                'employees.id as employee_id',
                'employees.admission_id_no',
                'employees.en_applicants_name',
                'employees.salary_joining_date',
                'employees.bn_traning_cost',
                'employees.bn_traning_cost_byMonth',
                'employees.salary_status',
                'employees.bn_remaining_cost',
                'employees.bn_post_allowance',
                'employees.bn_fuel_bill',
                'employees.bn_food_allowance',
                'employees.insurance',
                'employees.p_f',
                'employees.p_f',
                'customers.medical as cmedical',
                'customers.food_allownce as cfood_allowance',
                'customers.trans_conve as ctrans_conve',
                'employees.pf_ins_med_food_status',
                DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'),
                //'aggregate_data.total_deduction_traningcost',
                /*DB::raw("IF((salary_sheet_details.deduction_ins IS NOT NULL OR 
                salary_sheet_details.deduction_p_f IS NOT NULL 
                OR salary_sheet_details.allownce IS NOT NULL
                OR salary_sheet_details.deduction_fine IS NOT NULL
                OR salary_sheet_details.deduction_dress IS NOT NULL
                OR salary_sheet_details.deduction_banck_charge IS NOT NULL
                OR salary_sheet_details.deduction_revenue_stamp IS NOT NULL
                OR salary_sheet_details.deduction_traningcost IS NOT NULL
                OR salary_sheet_details.deduction_loan IS NOT NULL) 
                AND (salary_sheets.year = {$request->Year} AND salary_sheets.month = {$request->Month}), 1, 0) AS charge_status"),
                        'aggregate_data.total_deduction_traningcost'*/
                //DB::raw('SUM(salary_sheet_details.deduction_traningcost) as total_deduction_traningcost')
                DB::raw("IFNULL(aggregate_data.total_deduction_traningcost_except_requested, 0) AS total_deduction_traningcost"),
                DB::raw("IFNULL(aggregate_data.charge_status, 0) AS charge_status") // Use charge_status from aggregate data
            )
            ->where(function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->whereDate('customer_duties.start_date', '<=', $request->end_date)
                        ->whereDate('customer_duties.end_date', '>=', $request->start_date);
                });
            });
        // Get the customer_branch_id values from the query string (optional)
        $customerBranchIds = $request->input('customer_branch_id'); // This will return an array or null

        // Start building the query to get branch_ids for the given customer_id, year, and month
        $dataExists = DB::table('salary_sheets')
            ->where('year', '=', $request->Year)
            ->where('month', '=', $request->Month)
            ->where('customer_id', '=', $request->customer_id);

        // If customer_branch_id is provided, use FIND_IN_SET to filter by branch_id
        if ($customerBranchIds) {
            foreach ($customerBranchIds as $branchId) {
                // Use FIND_IN_SET to check if the branch_id is in the comma-separated list
                $dataExists = $dataExists->whereRaw('FIND_IN_SET(?, branch_id) > 0', [$branchId]);
            }
        }

        // Retrieve the matching branch_ids for the given customer_id, year, and month
        $branchIds = $dataExists->pluck('branch_id'); // Get the branch_id values as an array
        //dd($branchIds);

        //dd($branchIds);
        // Extract branch_ids from the result
        $branchIdsArray = collect($branchIds)
            ->flatMap(function ($item) {
                return explode(',', $item);
            })
            ->unique()
            ->filter() // Remove empty values
            ->values() // Re-index array
            ->toArray();
        //dd($branchIdsArray);
        // Check if data exists for the given parameters
        if ($dataExists->exists()) {
            // Ensure branchIdsArray is properly processed
            if (!empty($branchIdsArray)) {
                /*$query->whereNotIn('customer_duties.branch_id', function ($query) use ($request, $branchIdsArray) {
                    $query->select('branch_id')
                        ->from('salary_sheets')
                        ->where('year', '=', $request->Year)
                        ->where('month', '=', $request->Month)
                        ->where('customer_id', '=', $request->customer_id);

                    // Add a condition for each branchId using FIND_IN_SET
                    foreach ($branchIdsArray as $branchId) {
                        $query->orWhereRaw('FIND_IN_SET(?, branch_id) > 0', [$branchId]);
                    }
                });*/
                $query->whereNotIn('customer_duties.branch_id', $branchIdsArray);
            }
        }




        if ($request->customer_id) {
            $customerId = $request->customer_id;
            $query->whereIn('customer_duties.customer_id', $customerId);
        }
        if ($request->has('customer_branch_id') && is_array($request->customer_branch_id)) {
            $query->whereIn('customer_duties.branch_id', $request->customer_branch_id);
        } elseif ($request->has('customer_branch_id')) {
            $query->where('customer_duties.branch_id', '=', $request->customer_branch_id);
        }

        $query->where('customer_duty_details.customer_id', '=', $request->customer_id)
            ->orderBy('job_posts.serial', 'ASC');

        $data = $query->get();

        return response()->json($data, 200);


        /*
        $query = DB::table('customer_duties')
    ->select(
        'customer_duties.*',
        'deductions.*',
        'customer_duty_details.*',
        'customer_brances.brance_name as customer_branch',
        'customers.name as customer_name',
        'long_loans.id as long_loan_id',
        'long_loans.perinstallment_amount',
        'job_posts.id as jobpost_id',
        'job_posts.name as jobpost_name',
        'employees.id as employee_id',
        'employees.admission_id_no',
        'employees.en_applicants_name',
        'employees.salary_joining_date',
        'employees.bn_traning_cost',
        'employees.bn_traning_cost_byMonth',
        'employees.salary_status',
        'employees.bn_remaining_cost',
        'employees.bn_post_allowance',
        'employees.bn_fuel_bill',
        'employees.bn_food_allowance',
        'employees.insurance',
        'employees.p_f',
        DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'),
        DB::raw("IF(ssd.deduction_ins IS NOT NULL OR ssd.deduction_p_f IS NOT NULL, 'Charged', 'Not Charged') AS charge_status")
    )
    ->join('customer_duty_details', 'customer_duty_details.customerduty_id', '=', 'customer_duties.id')
    ->join('job_posts', 'customer_duty_details.job_post_id', '=', 'job_posts.id')
    ->join('employees', 'customer_duty_details.employee_id', '=', 'employees.id')
    ->leftJoin('deductions', function ($join) use ($request) {
        $join->on('customer_duty_details.employee_id', '=', 'deductions.employee_id')
            ->where('deductions.month', '=', $request->Month)
            ->where('deductions.year', '=', $request->Year);
    })
    ->leftJoin('long_loans', function ($join) use ($request) {
        $join->on('customer_duty_details.employee_id', '=', 'long_loans.employee_id')
            ->whereDate('long_loans.installment_date', '>=', $request->start_date)
            ->whereDate('long_loans.end_date', '<=', $request->end_date)
            ->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
    })
    ->leftJoin('customer_brances', 'customer_duties.branch_id', '=', 'customer_brances.id')
    ->leftJoin('customers', 'customer_duty_details.customer_id', '=', 'customers.id')
    ->leftJoin('salary_sheets as ss', function ($join) use ($request) {
        $join->on('ss.customer_id', '=', 'customer_duty_details.customer_id')
            ->where('ss.year', '=', $request->Year)
            ->where('ss.month', '=', $request->Month);
        
        if ($request->customer_branch_id) {
            $join->where('ss.branch_id', '=', $request->customer_branch_id);
        }
    })
    ->leftJoin('salary_sheet_details as ssd', function ($join) {
        $join->on('ss.id', '=', 'ssd.salary_id')
            ->on('ssd.employee_id', '=', 'customer_duty_details.employee_id');
    })
    ->where('customer_duties.start_date', '>=', $request->start_date)
    ->where('customer_duties.end_date', '<=', $request->end_date);

if ($request->customer_id) {
    $query->whereIn('customer_duties.customer_id', $request->customer_id);
}

if ($request->CustomerIdNot) {
    $query->whereNotIn('customer_duties.customer_id', $request->CustomerIdNot);
}

// Ensure the query properly handles the salary sheet logic for data existence
$dataExists = DB::table('salary_sheets')
    ->where('year', '=', $request->Year)
    ->where('month', '=', $request->Month)
    ->where('customer_id', '=', $request->customer_id);

if ($request->customer_branch_id) {
    $dataExists = $dataExists->where('branch_id', '=', $request->customer_branch_id);
}

if ($dataExists->exists()) {
    $query->whereNotIn('customer_duties.branch_id', function ($query) use ($request) {
        $query->select('branch_id')
            ->from('salary_sheets')
            ->where('year', '=', $request->Year)
            ->where('month', '=', $request->Month)
            ->where('customer_id', '=', $request->customer_id);

        if ($request->customer_branch_id) {
            $query->where('branch_id', '=', $request->customer_branch_id);
        }
    });
}

// Fetch data
$data = $query->get();

return response()->json($data, 200);
*/
    }
    // public function getSalaryFourData(Request $request)
    // {
    //     $stdate=$request->start_date;
    //     $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
    //     ->join('job_posts','customer_duty_details.job_post_id','=','job_posts.id')
    //     ->join('employees','customer_duty_details.employee_id','=','employees.id')
    //     ->leftjoin('deductions', function ($join) use ($request) {
    //         $join->on('customer_duty_details.employee_id', '=', 'deductions.employee_id')
    //              ->where('deductions.month', '=', $request->Month)
    //              ->where('deductions.year', '=', $request->Year);
    //     })
    //     ->leftjoin('long_loans', function ($j) use ($stdate) {
    //         $j->on('customer_duty_details.employee_id', '=', 'long_loans.employee_id')
    //              ->whereDate('long_loans.installment_date', '<=',$stdate)
    //              ->whereDate('long_loans.end_date', '>=',$stdate)
    //              ->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
    //     })
    //         ->select('customer_duties.*','deductions.*','customer_duty_details.*','long_loans.id as long_loan_id','long_loans.perinstallment_amount','job_posts.id as jobpost_id','job_posts.name as jobpost_name','employees.id as employee_id','employees.admission_id_no','employees.en_applicants_name','employees.salary_joining_date','employees.bn_traning_cost','employees.bn_traning_cost_byMonth','employees.bn_traning_cost','employees.bn_remaining_cost','employees.insurance',DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'));

    //     if ($request->customer_id){
    //         $customerId = $request->customer_id;
    //         $query->whereIn('customer_duties.customer_id', $customerId);
    //     }
    //     $data = $query->get();

    //     return response()->json($data, 200);
    // }
    public function getSalaryFourData(Request $request)
    {
        $stdate = $request->start_date;
        $query = Employee::join('job_posts', 'job_posts.id', '=', 'employees.designation_id')
            ->leftjoin('deductions', function ($join) use ($request) {
                $join->on('employees.id', '=', 'deductions.employee_id')
                    ->where('deductions.month', '=', $request->Month)
                    ->where('deductions.year', '=', $request->Year);
            })
            ->leftjoin('long_loans', function ($j) use ($stdate) {
                $j->on('employees.id', '=', 'long_loans.employee_id')
                    ->whereDate('long_loans.installment_date', '<=', $stdate)
                    ->whereDate('long_loans.end_date', '>=', $stdate);
                //->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
            })
            ->select('deductions.*', 'long_loans.id as long_loan_id', 'long_loans.perinstallment_amount', 'long_loans.installment_date', 'long_loans.end_date', 'job_posts.id as jobpost_id', 'job_posts.name as jobpost_name', 'employees.id as employee_id', 'employees.admission_id_no', 'employees.en_applicants_name', 'employees.salary_joining_date', 'employees.bn_traning_cost', 'employees.bn_traning_cost_byMonth', 'employees.bn_traning_cost', 'employees.bn_remaining_cost', 'employees.insurance', 'employees.bn_post_allowance', 'employees.bn_fuel_bill', 'employees.employee_type', 'employees.gross_salary', 'employees.ot_salary', 'employees.salary_serial', 'employees.medical', 'employees.p_f')
            ->where('employees.status', 1)
            ->orderBy('employees.salary_serial', 'ASC');

        $data = $query->get();
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salarySheet = SalarySheet::findOrFail(encryptor('decrypt', $id));

        // Use Eloquent's relationship to delete related details
        $salarySheet->details()->delete();

        // Delete the salary sheet
        $salarySheet->delete();

        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
    public function printZoneWise(Request $request)
    {
        // Retrieve request parameters
        /*$year = $request->input('year');
        $month = $request->input('month');
        $zone = $request->input('zone');
        $type = $request->input('type');
        $employeeId = $request->input('employee_id'); // Employee ID from request*/
        /*$salary = SalarySheet::whereHas('details.employee', function ($query) use ($employeeId) {
        $query->where('id', $employeeId); // Filter by employee ID
    })
    ->with('details.employee')
    ->get();
        dd($salary);*/


        // Retrieve request parameters
        $year = $request->input('year');
        $month = $request->input('month');
        $type = 5/*$request->input('type')*/;
        $employeeId = $request->input('employee_id'); // Employee ID from request
        $zone_id = $request->input('zone'); // Zone from request
        $designation_id = $request->input('designation_id');

        // Retrieve zones and employee
        $zone = Zone::all();
        $employee = Employee::all();

        // Query the SalarySheet table with related zone and status
        /*$salary = SalarySheet::where('year', $year)
            ->where('month', $month)
            ->where('status', $type)
            ->whereHas('customer', function ($query) use ($zone_id) {
                $query->where(function ($query) use ($zone_id) {
                    $query->where('zone_id', $zone_id) // Direct match in customers.zone_id
                        ->orWhere(function ($query) use ($zone_id) {
                            $query->whereNull('zone_id') // If customers.zone_id is NULL
                                ->whereHas('branch', function ($query) use ($zone_id) {
                                    $query->where('zone_id', $zone_id); // Match in branches
                                });
                        });
                });
            })
            ->whereHas('details') // Ensure salary sheets have details
            ->with(['customer', 'details'])
            ->get();*/

        // Fetch salary sheets with the specified filters
        $salary = SalarySheet::where('year', $year)
            ->where('month', $month)
            ->where('status', $type)
            ->whereHas('customer', function ($query) use ($zone_id) {
                $query->where(function ($query) use ($zone_id) {
                    // Case where the customer has a zone assigned directly
                    $query->whereNotNull('zone_id')
                        ->where('zone_id', $zone_id);
                })->orWhere(function ($query) use ($zone_id) {
                    // Case where the customer does not have a zone assigned, but belongs to a branch with a matching zone_id
                    $query->whereNull('zone_id')
                        ->whereHas('branch', function ($query) use ($zone_id) {
                            $query->where('zone_id', $zone_id);
                        });
                })->orWhere(function ($query) {
                    // Case where the customer has no branches
                    $query->whereDoesntHave('branch');
                });
            })
            ->whereHas('details', function ($query) use ($zone_id, $designation_id) {
                // Filter salary details based on zone_id and designation_id
                $query->whereHas('branches', function ($query) use ($zone_id) {
                    $query->where('zone_id', $zone_id);
                });

                // Optionally filter by designation_id
                if ($designation_id) {
                    $query->whereIn('designation_id', $designation_id);
                }

                // Include salary sheet details with null branch_id
                $query->orWhereNull('branch_id')
                    ->orWhere('branch_id', 0) // Add this condition for `branch_id = 0`
                    ->orWhereHas('branches', function ($query) {
                        // Add condition to match `salary_sheet_details.branch_id = customer_brances.id`
                        $query->whereColumn('branch_id', 'customer_brances.id');
                    });
            })
            ->with([
                // Eager load customer and their related branches
                'customer',
                'details' => function ($query) use ($designation_id) {
                    // If designation_id is provided, filter details by it
                    if ($designation_id) {
                        $query->whereIn('designation_id', $designation_id);
                    }

                    // Include salary sheet details with null branch_id
                    /*$query->orWhereNull('branch_id')
                  ->orWhere('branch_id', 0);*/ // Add condition for `branch_id = 0`
                },
                'details.branches'
            ])
            ->get();











        $designation = JobPost::get();







        // Proceed with the existing logic
        return view('hrm.salary_sheet.salary-sheet-five-zone-wise-print', compact('salary', 'zone', 'employee', 'month', 'year', 'designation'));
    }

    public function employeeWiseSalary(Request $request)
    {
        // Retrieve request parameters
        $year = $request->input('year');
        $month = $request->input('month');
        $type = 5; // $request->input('type') can be uncommented if needed
        $employeeId = $request->input('employee_id');
        $zone_id = $request->input('zone');
        $designation_id = $request->input('designation_id');

        // Retrieve zones and employee
        $zone = Zone::all();
        $employee = Employee::all();

        // Fetch salary sheets with the specified filters
        // Retrieve request parameters
        $year = $request->input('year');
        $month = $request->input('month');
        $type = 5; // $request->input('type') can be uncommented if needed
        $employeeId = $request->input('employee_id'); // Employee ID from request
        $zone_id = $request->input('zone');
        $designation_id = $request->input('designation_id');

        // Retrieve zones and employee
        $zone = Zone::all();
        $employee = Employee::all();
        // Retrieve salary sheets with the specified filters
        $salary = SalarySheet::whereHas('details.employee', function ($query) use ($employeeId) {
            // Filter by employee ID inside the 'details' relationship
            $query->where('id', $employeeId);
        })
            ->whereHas('details', function ($query) use ($designation_id) {
                // Optionally filter by designation_id inside the 'details' relationship
                if ($designation_id) {
                    $query->whereIn('designation_id', $designation_id);
                }

                // Ensure the `details` relationship has the `branches` relationship
                $query->whereHas('branches');
                // Include salary sheet details with null branch_id
                $query->orWhereNull('branch_id')
                    ->orWhere('branch_id', 0);
            })
            ->with([
                'details.employee', // Eager load employee details
                'details.branches'  // Eager load branches related to the salary details
            ])
            ->where('year', $year) // Filter by year
            ->where('month', $month) // Filter by month
            ->get();

        //dd($salary);


        // Retrieve job posts (designations)
        $designation = JobPost::get();

        // Proceed with the existing logic to return the view
        return view('hrm.salary_sheet.salary-sheet-employee-wise', compact('salary', 'zone', 'employee', 'month', 'year', 'designation'));
    }
}
