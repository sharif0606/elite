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

class SalarySheetController extends Controller
{

    public function index()
    {
        //
    }
    public function getsalarySheetOneIndex()
    {
        $salarysheet=SalarySheet::where('status',1)->get();
        return view('hrm.salary_sheet.salarysheetOneIndex',compact('salarysheet'));
    }
    public function getsalarySheetTwoIndex()
    {
        $salarysheet=SalarySheet::where('status',2)->get();
        return view('hrm.salary_sheet.salarysheetTwoIndex',compact('salarysheet'));
    }
    public function getsalarySheetThreeIndex()
    {
        $salarysheet=SalarySheet::where('status',3)->get();
        return view('hrm.salary_sheet.salarysheetThreeIndex',compact('salarysheet'));
    }
    public function getsalarySheetFourIndex()
    {
        $salarysheet=SalarySheet::where('status',4)->get();
        return view('hrm.salary_sheet.salarysheetFourIndex',compact('salarysheet'));
    }
    public function getsalarySheetFiveIndex()
    {
        $salarysheet=SalarySheet::where('status',5)->get();
        return view('hrm.salary_sheet.salarysheetFiveIndex',compact('salarysheet'));
    }


    public function create()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.create',compact('customer'));
    }
    public function getsalarySheetOne()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetOne',compact('customer'));
    }
    public function getsalarySheetTwo()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetTwo',compact('customer'));
    }
    public function salarySheetThree()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetThree',compact('customer'));
    }
    public function salarySheetFour()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetFour',compact('customer'));
    }
    public function salarySheetFive()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetFive',compact('customer'));
    }

    public function salarySheetOneStore(Request $request)
    {
        // dd($request->all());
        // die();
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by=currentUserId();
            $salary->status = 1;
            if ($salary->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->fixed_ot=$request->fixed_ot[$key];
                            $details->leave=$request->leave[$key];
                            $details->arrear=$request->arrear[$key];
                            $details->allownce=$request->allownce[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_mobilebill=$request->deduction_mobilebill[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_long_loan=$request->deduction_long_loan[$key];
                            $details->deduction_cloth=$request->deduction_cloth[$key];
                            $details->deduction_jacket=$request->deduction_jacket[$key];
                            $details->deduction_hr=$request->deduction_hr[$key];
                            $details->deduction_traningcost=$request->deduction_traningcost[$key];
                            $details->deduction_c_f=$request->deduction_c_f[$key];
                            $details->deduction_medical=$request->deduction_medical[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_revenue_stamp=$request->deduction_revenue_stamp[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_salary[$key];
                            $details->common_net_salary=$request->net_salary[$key];
                            $details->sing_of_ind=$request->sing_of_ind[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
    public function editSalaryOne($id){
        $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer=Customer::all();
        $branch=CustomerBrance::select('id','brance_name','customer_id')->whereIn('customer_id',$selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id',$salary->id)->get();
        return view('hrm.salary_sheet.salarysheetOneEdit',compact('salary','salaryDetail','customer','branch','selectedCustomerIds','selectedCustomerIdsNot','branchIds','atmIds'));
    }
    public function salarySheetOneUpdate(Request $request, $id)
    {
        // dd($request->all());
        // die();
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by=currentUserId();
            $salary->status = 1;
            if ($salary->save()){
                if($request->employee_id){
                    SalarySheetDetail::where('salary_id',$salary->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->fixed_ot=$request->fixed_ot[$key];
                            $details->leave=$request->leave[$key];
                            $details->arrear=$request->arrear[$key];
                            $details->allownce=$request->allownce[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_mobilebill=$request->deduction_mobilebill[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_long_loan=$request->deduction_long_loan[$key];
                            $details->deduction_cloth=$request->deduction_cloth[$key];
                            $details->deduction_jacket=$request->deduction_jacket[$key];
                            $details->deduction_hr=$request->deduction_hr[$key];
                            $details->deduction_traningcost=$request->deduction_traningcost[$key];
                            $details->deduction_c_f=$request->deduction_c_f[$key];
                            $details->deduction_medical=$request->deduction_medical[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_revenue_stamp=$request->deduction_revenue_stamp[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_salary[$key];
                            $details->common_net_salary=$request->net_salary[$key];
                            $details->sing_of_ind=$request->sing_of_ind[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by=currentUserId();
            $salary->status = 2;
            if ($salary->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->online_payment=$request->payment_type[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->weekly_leave=$request->weekly_leave[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->leave=$request->leave[$key];
                            $details->arrear=$request->arrear[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_long_loan=$request->deduction_longLoan[$key];
                            $details->deduction_cloth=$request->deduction_cloth[$key];
                            $details->deduction_hr=$request->deduction_hr[$key];
                            $details->deduction_jacket=$request->deduction_jacket[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stamp[$key];
                            $details->deduction_traningcost=$request->deduction_traningCost[$key];
                            $details->deduction_c_f=$request->deduction_c_f[$key];
                            $details->deduction_medical=$request->deduction_medical[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_salary[$key];
                            $details->common_net_salary=$request->net_salary[$key];
                            $details->sing_of_ind=$request->signature[$key];
                            // uncommon
                            $details->ht_ribon_alice=$request->ht_ribon_alice[$key];
                            $details->gun_alice=$request->gun_alice[$key];
                            $details->extra_alice=$request->extra_alice[$key];
                            $details->bonus=$request->bonus[$key];
                            $details->donation=$request->donation[$key];
                            $details->deduction_matterss_pillowCost=$request->deduction_matterss_pillowCost[$key];
                            $details->deduction_tonic_sim=$request->deduction_tonic_sim[$key];
                            $details->deduction_over_paymentCut=$request->deduction_over_paymentCut[$key];
                            $details->zone=$request->zone[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Two',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
    public function editSalaryTwo($id){
        $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer=Customer::all();
        $branch=CustomerBrance::select('id','brance_name','customer_id')->whereIn('customer_id',$selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id',$salary->id)->get();
        return view('hrm.salary_sheet.salarysheetTwoEdit',compact('salary','salaryDetail','customer','branch','selectedCustomerIds','selectedCustomerIdsNot','branchIds','atmIds'));
    }
    public function salarySheetTwoUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by=currentUserId();
            $salary->status = 2;
            if ($salary->save()){
                if($request->employee_id){
                    SalarySheetDetail::where('salary_id',$salary->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->online_payment=$request->payment_type[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->weekly_leave=$request->weekly_leave[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->leave=$request->leave[$key];
                            $details->arrear=$request->arrear[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_long_loan=$request->deduction_longLoan[$key];
                            $details->deduction_cloth=$request->deduction_cloth[$key];
                            $details->deduction_hr=$request->deduction_hr[$key];
                            $details->deduction_jacket=$request->deduction_jacket[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stamp[$key];
                            $details->deduction_traningcost=$request->deduction_traningCost[$key];
                            $details->deduction_c_f=$request->deduction_c_f[$key];
                            $details->deduction_medical=$request->deduction_medical[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_salary[$key];
                            $details->common_net_salary=$request->net_salary[$key];
                            $details->sing_of_ind=$request->signature[$key];
                            // uncommon
                            $details->ht_ribon_alice=$request->ht_ribon_alice[$key];
                            $details->gun_alice=$request->gun_alice[$key];
                            $details->extra_alice=$request->extra_alice[$key];
                            $details->bonus=$request->bonus[$key];
                            $details->donation=$request->donation[$key];
                            $details->deduction_matterss_pillowCost=$request->deduction_matterss_pillowCost[$key];
                            $details->deduction_tonic_sim=$request->deduction_tonic_sim[$key];
                            $details->deduction_over_paymentCut=$request->deduction_over_paymentCut[$key];
                            $details->zone=$request->zone[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Two',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by=currentUserId();
            $salary->status = 3;
            if ($salary->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->medical=$request->medical[$key];
                            $details->trans_conve=$request->trans_conve[$key];
                            $details->food_allownce=$request->food_allownce[$key];
                            $details->gross_wages=$request->gross_wages[$key];
                            $details->total_workingday=$request->total_workingDay[$key];
                            $details->present_day=$request->present_day[$key];
                            $details->absent=$request->absent[$key];
                            $details->vacant=$request->vacant[$key];
                            $details->holiday_festival=$request->holiday_festival[$key];
                            $details->leave_cl=$request->leave_cl[$key];
                            $details->leave_sl=$request->leave_sl[$key];
                            $details->leave_el=$request->leave_el[$key];
                            $details->deduction_absent=$request->deduction_absent[$key];
                            $details->deduction_vacant=$request->deduction_vacant[$key];
                            $details->deduction_hr=$request->deduction_h_rent[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_adv=$request->deduction_adv[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stm[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_wages[$key];
                            $details->ot_qty=$request->ot_hour[$key];
                            $details->ot_rate_basicDuble=$request->ot_rate_basicDuble[$key];
                            $details->ot_amount=$request->ot_amt[$key];
                            $details->total_payable=$request->total_payable[$key];
                            $details->common_net_salary=$details->total_payable;
                            $details->sing_of_ind=$request->signature[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Three',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
    public function editSalaryThree($id){
        $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer=Customer::all();
        $branch=CustomerBrance::select('id','brance_name','customer_id')->whereIn('customer_id',$selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id',$salary->id)->get();
        return view('hrm.salary_sheet.salarysheetThreeEdit',compact('salary','salaryDetail','customer','branch','selectedCustomerIds','selectedCustomerIdsNot','branchIds','atmIds'));
    }
    public function salarySheetThreeUpdate(Request $request, $id){
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by=currentUserId();
            $salary->status = 3;
            if ($salary->save()){
                if($request->employee_id){
                    SalarySheetDetail::where('salary_id',$salary->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->medical=$request->medical[$key];
                            $details->trans_conve=$request->trans_conve[$key];
                            $details->food_allownce=$request->food_allownce[$key];
                            $details->gross_wages=$request->gross_wages[$key];
                            $details->total_workingday=$request->total_workingDay[$key];
                            $details->present_day=$request->present_day[$key];
                            $details->absent=$request->absent[$key];
                            $details->vacant=$request->vacant[$key];
                            $details->holiday_festival=$request->holiday_festival[$key];
                            $details->leave_cl=$request->leave_cl[$key];
                            $details->leave_sl=$request->leave_sl[$key];
                            $details->leave_el=$request->leave_el[$key];
                            $details->deduction_absent=$request->deduction_absent[$key];
                            $details->deduction_vacant=$request->deduction_vacant[$key];
                            $details->deduction_hr=$request->deduction_h_rent[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_adv=$request->deduction_adv[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stm[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->net_wages[$key];
                            $details->ot_qty=$request->ot_hour[$key];
                            $details->ot_rate_basicDuble=$request->ot_rate_basicDuble[$key];
                            $details->ot_amount=$request->ot_amt[$key];
                            $details->total_payable=$request->total_payable[$key];
                            $details->common_net_salary=$details->total_payable;
                            $details->sing_of_ind=$request->signature[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Three',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
            $salary->created_by=currentUserId();
            $salary->status = 4;
            if ($salary->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            //$details->duty_amount=$request->duty_amount[$key];
                            $details->medical=$request->medical_allowance[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->allownce=$request->post_allow[$key];
                            $details->fuel_bill=$request->fuel_bill[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->total_salary_of_salary_sheet_four=$request->total_salary[$key];
                            $details->deduction_mobilebill=$request->deduction_excess_mobile[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_traningcost=$request->deduction_traning_cost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_mess=$request->deduction_mess[$key];
                            // uncommon
                            $details->total_payable=$request->total_payble[$key];
                            $details->common_net_salary=$request->total_payble[$key];
                            $details->sing_of_ind=$request->signature_ind[$key];
                            $details->sing_account=$request->signature_accounts[$key];
                            $details->remark=$request->remarks[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Four',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
    public function editSalaryFour($id){
        $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
        $salaryDetail = SalarySheetDetail::where('salary_id',$salary->id)->get();
        return view('hrm.salary_sheet.salarysheetFourEdit',compact('salary','salaryDetail'));
    }
    public function salarySheetFourUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by=currentUserId();
            $salary->status = 4;
            if ($salary->save()){
                if($request->employee_id){
                    SalarySheetDetail::where('salary_id',$salary->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            //$details->duty_amount=$request->duty_amount[$key];
                            $details->medical=$request->medical_allowance[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->allownce=$request->post_allow[$key];
                            $details->fuel_bill=$request->fuel_bill[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->total_salary_of_salary_sheet_four=$request->total_salary[$key];
                            $details->deduction_mobilebill=$request->deduction_excess_mobile[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_traningcost=$request->deduction_traning_cost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_mess=$request->deduction_mess[$key];
                            // uncommon
                            $details->total_payable=$request->total_payble[$key];
                            $details->common_net_salary=$request->total_payble[$key];
                            $details->sing_of_ind=$request->signature_ind[$key];
                            $details->sing_account=$request->signature_accounts[$key];
                            $details->remark=$request->remarks[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet Four',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->created_by=currentUserId();
            $salary->status = 5;
            if ($salary->save()){
                if($request->employee_id){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->divided_by=$request->divided_by[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->allownce=$request->post_allowance[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_traningcost=$request->deduction_training_cost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_pf[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stamp[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->total_payable[$key];
                            $details->common_net_salary=$request->total_payable[$key];
                            $details->sing_of_ind=$request->sing_ind[$key];
                            $details->sing_account=$request->sing_account[$key];
                            $details->deduction_dress=$request->deduction_dress[$key];
                            $details->deduction_banck_charge=$request->deduction_banck_charge[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
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
                \LogActivity::addToLog('Generate Salary Sheet',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
    public function editSalaryFive($id){
        $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
        $selectedCustomerIds = explode(',', $salary->customer_id);
        $selectedCustomerIdsNot = explode(',', $salary->customer_id_not);
        $branchIds = explode(',', $salary->branch_id);
        $atmIds = explode(',', $salary->atm_id);
        $customer=Customer::all();
        $branch=CustomerBrance::select('id','brance_name','customer_id')->whereIn('customer_id',$selectedCustomerIds)->get();
        $salaryDetail = SalarySheetDetail::where('salary_id',$salary->id)->get();
        return view('hrm.salary_sheet.salarySheetFiveEdit',compact('salary','salaryDetail','customer','branch','selectedCustomerIds','selectedCustomerIdsNot','branchIds','atmIds'));
    }

    public function salarySheetFiveUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $salary = SalarySheet::findOrFail(encryptor('decrypt',$id));
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
            if($request->branch_id){
                $salary->branch_id = $request->branch_id?implode(',',$request->branch_id):'';
            }else{
                $salary->branch_id = $request->customer_branch_id?implode(',',$request->customer_branch_id):'';
            }
            $salary->atm_id = $request->customer_atm_id?implode(',',$request->customer_atm_id):'';
            $salary->year = $request->year;
            $salary->month = $request->month;
            $salary->updated_by=currentUserId();
            $salary->status = 5;
            if ($salary->save()){
                if($request->employee_id){
                    SalarySheetDetail::where('salary_id',$salary->id)->delete();
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = new SalarySheetDetail;
                            $details->salary_id=$salary->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->designation_id=$request->designation_id[$key];
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->branch_id=$request->customer_branch_id[$key];
                            $details->atm_id=$request->customer_atm_id[$key];
                            $details->divided_by=$request->divided_by[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->allownce=$request->post_allowance[$key];
                            $details->gross_salary=$request->gross_salary[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_traningcost=$request->deduction_training_cost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_pf[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stamp[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->total_payable[$key];
                            $details->common_net_salary=$request->total_payable[$key];
                            $details->sing_of_ind=$request->sing_ind[$key];
                            $details->sing_account=$request->sing_account[$key];
                            $details->deduction_dress=$request->deduction_dress[$key];
                            $details->deduction_banck_charge=$request->deduction_banck_charge[$key];
                            $details->remark=$request->remark[$key];
                            $details->status=0;
                            $details->save();
                            DB::commit();
                        }
                    }
                }
                \LogActivity::addToLog('Generate Salary Sheet',$request->getContent(),'SalarySheet,SalarySheetDetail');
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
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        $customerIds = explode(',', $salary->customer_id);
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }
        return view('hrm.salary_sheet.salarysheetOneShow',compact('salary','groupedData'));
    }
    public function getsalarySheetTwoShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        $customerIds = explode(',', $salary->customer_id);
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }
        return view('hrm.salary_sheet.salarysheetTwoShow',compact('salary','groupedData'));
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
        $branchIds = array_filter(explode(',', $salary->branch_id), function($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id)->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }

        return view('hrm.salary_sheet.salarysheetThreeShow', compact('salary', 'groupedData'));
    }



    public function salarySheetFourShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        $details = SalarySheetDetail::where('salary_id', $salary->id)
        ->with(['employee' => function ($query) {
            $query->orderBy('salary_serial', 'ASC');
        }])
        ->get();

        // Sort the details collection by the related employee's salary_serial
        $details = $details->sortBy(function($detail) {
            return $detail->employee->salary_serial;
        });
        return view('hrm.salary_sheet.salarysheetFourShow',compact('salary','details'));
    }
    // public function getsalarySheetFiveShow($id)
    // {
    //     $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
    //     //return $salary;
    //     return view('hrm.salary_sheet.salarysheetFiveShow',compact('salary'));
    // }
    public function getsalarySheetFiveShow(Request $request, $id)
    {
        $salary = SalarySheet::findOrFail(encryptor('decrypt', $id));
        
        $customerIds = explode(',', $salary->customer_id);
        $customer = Customer::whereIn('id',$customerIds)->get();
        $designationIds = SalarySheetDetail::where('salary_id', $salary->id)->pluck('designation_id');
        $designation = JobPost::whereIn('id',$designationIds)->get();
        // Handle "null" string values in branch_id
        $branchIds = array_filter(explode(',', $salary->branch_id), function($value) {
            return $value !== "null";
        });
        $groupedData = [];

        $salaryDetails = SalarySheetDetail::where('salary_id', $salary->id);

        if($request->customer_id){
            $salaryDetails = $salaryDetails->where('customer_id',$request->customer_id);
        }

        if($request->branch_id){
            $salaryDetails = $salaryDetails->where('branch_id',$request->branch_id);
        }

        if($request->designation_id){
            $salaryDetails = $salaryDetails->where('designation_id',$request->designation_id);
        }

        $salaryDetails = $salaryDetails->get();

        foreach ($salaryDetails as $detail) {
            if (in_array($detail->customer_id, $customerIds) && (empty($branchIds) || in_array($detail->branch_id, $branchIds))) {
                $groupedData[$detail->customer_id][$detail->branch_id][] = $detail;
            }
        }
        return view('hrm.salary_sheet.salarysheetFiveShowBranch', [
            'salary' => $salary,
            'customer' => $customer,
            'designation' => $designation,
            'groupedData' => $groupedData
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
        $branch = CustomerBrance::whereIn('customer_id', $customerIds)->select('id','brance_name')->get();
        return response()->json($branch, 200);
    }

    public function getSalaryData(Request $request)
    {
        $stdate=$request->start_date;
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
        ->where('salary_sheet_details.customer_id',$request->customer_id);
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
        DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'),
        DB::raw("IF((salary_sheet_details.deduction_ins IS NOT NULL OR salary_sheet_details.deduction_p_f IS NOT NULL OR salary_sheet_details.deduction_loan IS NOT NULL) and (`salary_sheets`.`year` = '2024' and `salary_sheets`.`month` = '11') , 1, 0) AS charge_status ")
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
        $query->whereNotIn('customer_duties.branch_id', function ($query) use ($request, $branchIdsArray) {
            $query->select('branch_id')
                ->from('salary_sheets')
                ->where('year', '=', $request->Year)
                ->where('month', '=', $request->Month)
                ->where('customer_id', '=', $request->customer_id);

            // Add a condition for each branchId using FIND_IN_SET
            foreach ($branchIdsArray as $branchId) {
                $query->orWhereRaw('FIND_IN_SET(?, branch_id) > 0', [$branchId]);
            }
        });
    }
}




if ($request->customer_id) {
    $customerId = $request->customer_id;
    $query->whereIn('customer_duties.customer_id', $customerId);
}
if ($request->has('customer_branch_id')) {
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
        $stdate=$request->start_date;
        $query = Employee::join('job_posts', 'job_posts.id', '=', 'employees.designation_id')
        ->leftjoin('deductions', function ($join) use ($request) {
            $join->on('employees.id', '=', 'deductions.employee_id')
                 ->where('deductions.month', '=', $request->Month)
                 ->where('deductions.year', '=', $request->Year);
        })
        ->leftjoin('long_loans', function ($j) use ($stdate) {
            $j->on('employees.id', '=', 'long_loans.employee_id')
                 ->whereDate('long_loans.installment_date', '<=',$stdate)
                 ->whereDate('long_loans.end_date', '>=',$stdate)
                 ->whereRaw('long_loans.loan_balance < long_loans.loan_amount');
        })
            ->select('deductions.*','long_loans.id as long_loan_id','long_loans.perinstallment_amount','job_posts.id as jobpost_id','job_posts.name as jobpost_name','employees.id as employee_id','employees.admission_id_no','employees.en_applicants_name','employees.salary_joining_date','employees.bn_traning_cost','employees.bn_traning_cost_byMonth','employees.bn_traning_cost','employees.bn_remaining_cost','employees.insurance','employees.bn_post_allowance','employees.bn_fuel_bill','employees.employee_type','employees.gross_salary','employees.ot_salary','employees.salary_serial')->orderBy('employees.salary_serial','ASC');

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
}
