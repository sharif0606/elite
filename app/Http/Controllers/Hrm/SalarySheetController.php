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
                            $details->deduction_traningcost=$request->deduction_traningcost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_pf[$key];
                            $details->deduction_revenue_stamp=$request->deduction_stamp[$key];
                            $details->deduction_total=$request->deduction_total[$key];
                            $details->net_salary=$request->total_payable[$key];
                            $details->sing_of_ind=$request->sing_of_ind[$key];
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
    public function salarySheetTwoStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
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
    public function salarySheetThreeStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
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
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->medical=$request->medical[$key];
                            $details->trans_conve=$request->trans_conve[$key];
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
                            $details->sing_of_ind=$request->signature[$key];
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
    public function salarySheetFourStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
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
                            $details->customer_id=$request->customer_id_ind[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->house_rent=$request->house_rent[$key];
                            $details->duty_qty=$request->duty_qty[$key];
                            $details->duty_amount=$request->duty_amount[$key];
                            $details->medical=$request->medical_allowance[$key];
                            $details->ot_qty=$request->ot_qty[$key];
                            $details->ot_rate=$request->ot_rate[$key];
                            $details->ot_amount=$request->ot_amount[$key];
                            $details->allownce=$request->post_allow[$key];
                            $details->fuel_bill=$request->fuel_bill[$key];
                            $details->gross_salary=$request->total_salary[$key];
                            $details->deduction_mobilebill=$request->deduction_excess_mobile[$key];
                            $details->deduction_fine=$request->deduction_fine[$key];
                            $details->deduction_loan=$request->deduction_loan[$key];
                            $details->deduction_traningcost=$request->deduction_traning_cost[$key];
                            $details->deduction_ins=$request->deduction_ins[$key];
                            $details->deduction_p_f=$request->deduction_p_f[$key];
                            $details->deduction_mess=$request->deduction_mess[$key];
                            // $details->deduction_total=$request->deduction_total[$key];
                            // uncommon
                            $details->total_payable=$request->total_payble[$key];
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
                return redirect()->route('salarySheetFour')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        DB::beginTransaction();
        try {
            $salary = new SalarySheet;
            $salary->customer_id = $request->customer_id?implode(',',$request->customer_id):'';
            $salary->customer_id_not = $request->customer_id_not?implode(',',$request->customer_id_not):'';
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
        //return $salary;
        return view('hrm.salary_sheet.salarysheetOneShow',compact('salary'));
    }
    public function getsalarySheetTwoShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        //return $salary;
        return view('hrm.salary_sheet.salarysheetTwoShow',compact('salary'));
    }
    public function salarySheetThreeShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        //return $salary;
        return view('hrm.salary_sheet.salarysheetThreeShow',compact('salary'));
    }
    public function salarySheetFourShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        //return $salary;
        return view('hrm.salary_sheet.salarysheetFourShow',compact('salary'));
    }
    public function getsalarySheetFiveShow($id)
    {
        $salary=SalarySheet::findOrFail(encryptor('decrypt',$id));
        //return $salary;
        return view('hrm.salary_sheet.salarysheetFiveShow',compact('salary'));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function getSalaryData(Request $request)
    {
        $stdate=$request->start_date;
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
            ->select('customer_duties.*','deductions.*','customer_duty_details.*','long_loans.id as long_loan_id','long_loans.perinstallment_amount','job_posts.id as jobpost_id','job_posts.name as jobpost_name','employees.id as employee_id','employees.admission_id_no','employees.en_applicants_name','employees.joining_date','employees.bn_traning_cost','employees.bn_traning_cost_byMonth','employees.bn_traning_cost','employees.bn_remaining_cost','employees.insurance',DB::raw('(customer_duty_details.ot_amount + customer_duty_details.duty_amount) as grossAmount'));

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
            if ($request->CustomerIdNot){
                $CustomerIdNot = $request->CustomerIdNot;
                $query->whereNotIn('customer_duties.customer_id', $CustomerIdNot);
            }
        $data = $query->get();

        return response()->json($data, 200);
    }
}
