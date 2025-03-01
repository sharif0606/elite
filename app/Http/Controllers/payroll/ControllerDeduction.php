<?php

namespace App\Http\Controllers\payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\payroll\Deduction;
use App\Models\payroll\DeductionDetail;
use App\Models\Employee\Employee;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Traits\ImageHandleTraits;
use Exception;

class ControllerDeduction extends Controller
{

    public function index()
    {
        $deductions = Deduction::all();
        return view('pay_roll.deduction.index', compact('deductions'));
    }
    public function fineIndex()
    {
        $deductions = Deduction::where('fine', '>', 0)->get();
        return view('pay_roll.deduction.fineindex', compact('deductions'));
    }
    public function mobileBillIndex()
    {
        $deductions = Deduction::where('mobilebill', '>', 0)->get();
        return view('pay_roll.deduction.mobilebillindex', compact('deductions'));
    }
    public function loanIndex()
    {
        $deductions = Deduction::where('loan', '>', 0)->get();
        return view('pay_roll.deduction.loanindex', compact('deductions'));
    }
    public function clothIndex()
    {
        $deductions = Deduction::where('cloth', '>', 0)->get();
        return view('pay_roll.deduction.clothindex', compact('deductions'));
    }
    public function JacketIndex()
    {
        $deductions = Deduction::where('jacket', '>', 0)->get();
        return view('pay_roll.deduction.jacketindex', compact('deductions'));
    }
    public function HrIndex()
    {
        $deductions = Deduction::where('hr', '>', 0)->get();
        return view('pay_roll.deduction.hrindex', compact('deductions'));
    }
    public function CfIndex()
    {
        $deductions = Deduction::where('c_f', '>', 0)->get();
        return view('pay_roll.deduction.cfindex', compact('deductions'));
    }
    public function medicalIndex()
    {
        $deductions = Deduction::where('medical', '>', 0)->get();
        return view('pay_roll.deduction.medicalindex', compact('deductions'));
    }
    public function MatterssPillowIndex()
    {
        $deductions = Deduction::where('matterss_pillowCost', '>', 0)->get();
        return view('pay_roll.deduction.mattersspillowindex', compact('deductions'));
    }
    public function tonicSimIndex()
    {
        $deductions = Deduction::where('tonic_sim', '>', 0)->get();
        return view('pay_roll.deduction.tonicsimindex', compact('deductions'));
    }
    public function overPaymentIndex()
    {
        $deductions = Deduction::where('over_paymentCut', '>', 0)->get();
        return view('pay_roll.deduction.overPaymentindex', compact('deductions'));
    }
    public function bankChargeIndex()
    {
        $deductions = Deduction::where('bank_charge_exc', '>', 0)->get();
        return view('pay_roll.deduction.bankChargeIndex', compact('deductions'));
    }
    public function DressIndex()
    {
        $deductions = Deduction::where('dress', '>', 0)->get();
        return view('pay_roll.deduction.DressIndex', compact('deductions'));
    }
    public function advIndex()
    {
        $deductions = Deduction::where('adv', '>', 0)->get();
        return view('pay_roll.deduction.AdvIndex', compact('deductions'));
    }
    public function stmpIndex()
    {
        $deductions = Deduction::where('stmp', '>', 0)->get();
        return view('pay_roll.deduction.StmpIndex', compact('deductions'));
    }
    public function mobileExcessIndex()
    {
        $deductions = Deduction::where('excess_mobile', '>', 0)->get();
        return view('pay_roll.deduction.mobileExcessIndex', compact('deductions'));
    }
    public function messIndex()
    {
        $deductions = Deduction::where('mess', '>', 0)->get();
        return view('pay_roll.deduction.messIndex', compact('deductions'));
    }
    public function absentIndex()
    {
        $deductions = Deduction::where('absent', '>', 0)->get();
        return view('pay_roll.deduction.absentIndex', compact('deductions'));
    }
    public function vacantIndex()
    {
        $deductions = Deduction::where('vacant', '>', 0)->get();
        return view('pay_roll.deduction.vacantIndex', compact('deductions'));
    }
    public function fuelIndex()
    {
        $deductions = Deduction::where('fuel_bill', '>', 0)->get();
        return view('pay_roll.deduction.fuelIndex', compact('deductions'));
    }
    public function postAllowanceIndex()
    {
        $deductions = Deduction::where('post_allowance', '>', 0)->get();
        return view('pay_roll.deduction.postAllowanceIndex', compact('deductions'));
    }
    public function allowanceIndex()
    {
        $deductions = Deduction::where('allowance', '>', 0)->get();
        return view('pay_roll.deduction.allowanceIndex', compact('deductions'));
    }
    public function leaveIndex()
    {
        $deductions = Deduction::where('leave', '>', 0)->get();
        return view('pay_roll.deduction.leaveIndex', compact('deductions'));
    }
    public function arrearIndex()
    {
        $deductions = Deduction::where('arrear', '>', 0)->get();
        return view('pay_roll.deduction.arrearIndex', compact('deductions'));
    }
    public function salaryStopIndex()
    {
        $deductions = Deduction::where('salary_stop_message', '!=', null)->get();
        return view('pay_roll.deduction.salaryStopIndex', compact('deductions'));
    }

    public function createDeduction($deduction_id)
    {
        $did = $deduction_id;
        $employees = Employee::select('id', 'admission_id_no', 'bn_applicants_name')->get();
        return view('pay_roll.deduction.create', compact('employees', 'did'));
    }
    public function salary_stop()
    {
        $employees = Employee::select('id', 'admission_id_no', 'bn_applicants_name')->get();
        return view('pay_roll.deduction.salaryStop', compact('employees'));
    }
    public function getOldDeduction(Request $request)
    {
        $data = Deduction::where('employee_id', $request->employee_id)->where('year', $request->year)->where('month', $request->month)->first();

        if ($data) {
            return response()->json([
                'status' => 1,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'No data found'
            ]);
        }
    }


    public function store(Request $request)
    {
        //dd($request->all());
        try {
            if ($request->deduction_type == '1') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->fine = $request->amount[$key];
                        $deduction->fine_rmk = $request->remarks[$key];
                        $deduction->status = 1;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '2') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->mobilebill = $request->amount[$key];
                        $deduction->mobilebill_rmk = $request->remarks[$key];
                        $deduction->status = 2;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '3') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->loan = $request->amount[$key];
                        $deduction->loan_rmk = $request->remarks[$key];
                        $deduction->status = 3;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '4') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->cloth = $request->amount[$key];
                        $deduction->cloth_rmk = $request->remarks[$key];
                        $deduction->status = 4;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '5') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->jacket = $request->amount[$key];
                        $deduction->jacket_rmk = $request->remarks[$key];
                        $deduction->status = 5;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '6') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->hr = $request->amount[$key];
                        $deduction->hr_rmk = $request->remarks[$key];
                        $deduction->status = 6;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '7') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->c_f = $request->amount[$key];
                        $deduction->c_f_rmk = $request->remarks[$key];
                        $deduction->status = 7;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '8') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->medical = $request->amount[$key];
                        $deduction->medical_rmk = $request->remarks[$key];
                        $deduction->status = 8;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '9') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->matterss_pillowCost = $request->amount[$key];
                        $deduction->matterss_pillowCost_rmk = $request->remarks[$key];
                        $deduction->status = 9;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '10') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->tonic_sim = $request->amount[$key];
                        $deduction->tonic_sim_rmk = $request->remarks[$key];
                        $deduction->status = 10;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '11') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->over_paymentCut = $request->amount[$key];
                        $deduction->over_paymentCut_rmk = $request->remarks[$key];
                        $deduction->status = 11;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '12') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->bank_charge_exc = $request->amount[$key];
                        $deduction->bank_charge_exc_rmk = $request->remarks[$key];
                        $deduction->status = 12;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '13') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->dress = $request->amount[$key];
                        $deduction->dress_rmk = $request->remarks[$key];
                        $deduction->status = 13;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '14') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->stmp = $request->amount[$key];
                        $deduction->stmp_rmk = $request->remarks[$key];
                        $deduction->status = 14;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '15') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->excess_mobile = $request->amount[$key];
                        $deduction->excess_mobile_rmk = $request->remarks[$key];
                        $deduction->status = 15;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '16') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->mess = $request->amount[$key];
                        $deduction->mess_rmk = $request->remarks[$key];
                        $deduction->status = 16;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '17') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->absent = $request->amount[$key];
                        $deduction->absent_rmk = $request->remarks[$key];
                        $deduction->status = 17;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '18') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->vacant = $request->amount[$key];
                        $deduction->vacant_rmk = $request->remarks[$key];
                        $deduction->status = 18;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '19') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->adv = $request->amount[$key];
                        $deduction->adv_rmk = $request->remarks[$key];
                        $deduction->status = 19;
                        $deduction->save();
                    }
                }
            }
            if ($request->salary_stop_message) {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->salary_stop_message = $request->salary_stop_message[$key];
                        $deduction->status = 20;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '21') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->fuel_bill = $request->amount[$key];
                        $deduction->fuel_bill_rmk = $request->remarks[$key];
                        $deduction->status = 21;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '22') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->post_allowance = $request->amount[$key];
                        $deduction->post_allowance_rmk = $request->remarks[$key];
                        $deduction->status = 22;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '23') {
                //dd($request->all());
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->allowance = $request->amount[$key];
                        $deduction->status = 23;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '24') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->leave = $request->amount[$key];
                        $deduction->status = 24;
                        $deduction->save();
                    }
                }
            }
            if ($request->deduction_type == '25') {
                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        $deduction = Deduction::where('employee_id', $request->employee_id[$key])->where('year', $request->year)->where('month', $request->month)->firstOrNew();
                        $deduction->year = $request->year;
                        $deduction->month = $request->month;
                        $deduction->employee_id = $request->employee_id[$key];
                        $deduction->arrear = $request->amount[$key];
                        $deduction->status = 25;
                        $deduction->save();
                    }
                }
            }
            \LogActivity::addToLog('Add Deduction', $request->getContent(), 'Deduction');
            $deductionRoutes = [
                1 => 'deduction_asign.fineIndex',
                2 => 'deduction_asign.mobileBillIndex',
                3 => 'deduction_asign.loanIndex',
                4 => 'deduction_asign.clothIndex',
                5 => 'deduction_asign.JacketIndex',
                6 => 'deduction_asign.HrIndex',
                7 => 'deduction_asign.CfIndex',
                8 => 'deduction_asign.medicalIndex',
                9 => 'deduction_asign.MatterssPillowIndex',
                10 => 'deduction_asign.tonicSimIndex',
                11 => 'deduction_asign.overPaymentIndex',
                12 => 'deduction_asign.bankChargeIndex',
                13 => 'deduction_asign.DressIndex',
                14 => 'deduction_asign.stmpIndex',
                15 => 'deduction_asign.mobileExcessIndex',
                16 => 'deduction_asign.messIndex',
                17 => 'deduction_asign.absentIndex',
                18 => 'deduction_asign.vacantIndex',
                19 => 'deduction_asign.advIndex',
                20 => 'deduction_asign.salaryStopIndex',
                21 => 'deduction_asign.fuelBillIndex',
                22 => 'deduction_asign.postAllowanceIndex',
                23 => 'deduction_asign.allowanceIndex',
                24 => 'deduction_asign.leaveIndex',
                25 => 'deduction_asign.arrearIndex',
                'default' => 'deduction_asign.index',
            ];

            $route = $deductionRoutes[$request->deduction_type] ?? $deductionRoutes['default'];

            return redirect()->route($route)->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $c = Deduction::findOrFail(encryptor('decrypt', $id));
        $employee = Employee::select('id', 'admission_id_no', 'bn_applicants_name')->get();
        return view('pay_roll.deduction.edit', compact('c', 'employee'));
    }


    public function update(Request $request, $id)
    {
        try {
            $c = Deduction::findOrFail(encryptor('decrypt', $id));
            // Update each field individually
            $c->fine = $request->input('fine', $c->fine);
            $c->mobilebill = $request->input('mobilebill', $c->mobilebill);
            $c->loan = $request->input('loan', $c->loan);
            $c->cloth = $request->input('cloth', $c->cloth);
            $c->jacket = $request->input('jacket', $c->jacket);
            $c->hr = $request->input('hr', $c->hr);
            $c->c_f = $request->input('c_f', $c->c_f);
            $c->medical = $request->input('medical', $c->medical);
            $c->matterss_pillowCost = $request->input('matterss_pillowCost', $c->matterss_pillowCost);
            $c->tonic_sim = $request->input('tonic_sim', $c->tonic_sim);
            $c->over_paymentCut = $request->input('over_paymentCut', $c->over_paymentCut);
            $c->bank_charge_exc = $request->input('bank_charge_exc', $c->bank_charge_exc);
            $c->dress = $request->input('dress', $c->dress);
            $c->excess_mobile = $request->input('excess_mobile', $c->excess_mobile);
            $c->mess = $request->input('mess', $c->mess);
            $c->absent = $request->input('absent', $c->absent);
            $c->vacant = $request->input('vacant', $c->vacant);
            $c->adv = $request->input('adv', $c->adv);
            $c->stmp = $request->input('stmp', $c->stmp);
            $c->fuel_bill = $request->input('fuel_bill', $c->fuel_bill);
            $c->post_allowance = $request->input('post_allowance', $c->post_allowance);
            $c->allowance = $request->input('allowance', $c->allowance);
            $c->leave = $request->input('leave', $c->leave);
            $c->arrear = $request->input('arrear', $c->arrear);
            $c->status = $request->input('status', $c->status);
            $c->salary_stop_message = $request->input('salary_stop_message', $c->salary_stop_message);
            $c->remarks = $request->input('remarks', $c->remarks);

            // Save the updated record
            $c->save();
            return redirect()->back()->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    public function destroy($id)
    {
        //dd(encryptor('decrypt',$id));
        $c = Deduction::findOrFail(encryptor('decrypt', $id));
        //dd($c);
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
