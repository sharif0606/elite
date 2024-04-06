<?php

namespace App\Http\Controllers\payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\payroll\Deduction;
use App\Models\payroll\DeductionDetail;
use App\Models\Employee\Employee;
use Toastr;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Traits\ImageHandleTraits;
use Exception;

class ControllerDeduction extends Controller
{

    public function index()
    {
        $deductions=Deduction::all();
        return view('pay_roll.deduction.index',compact('deductions'));
    }
    public function fineIndex()
    {
        $deductions=Deduction::where('fine', '>', 0)->get();
        return view('pay_roll.deduction.fineindex',compact('deductions'));
    }
    public function mobileBillIndex()
    {
        $deductions=Deduction::where('mobilebill', '>', 0)->get();
        return view('pay_roll.deduction.mobilebillindex',compact('deductions'));
    }
    public function loanIndex()
    {
        $deductions=Deduction::where('loan', '>', 0)->get();
        return view('pay_roll.deduction.loanindex',compact('deductions'));
    }
    public function clothIndex()
    {
        $deductions=Deduction::where('cloth', '>', 0)->get();
        return view('pay_roll.deduction.clothindex',compact('deductions'));
    }
    public function JacketIndex()
    {
        $deductions=Deduction::where('jacket', '>', 0)->get();
        return view('pay_roll.deduction.jacketindex',compact('deductions'));
    }

    public function create()
    {
        $employees=Employee::select('id','admission_id_no','bn_applicants_name')->get();
        return view('pay_roll.deduction.create',compact('employees'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try{
            if($request->deduction_type=='1'){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $deduction = Deduction::where('employee_id',$request->employee_id[$key])->firstOrNew();
                        $deduction->year=$request->year;
                        $deduction->month=$request->month;
                        $deduction->employee_id=$request->employee_id[$key];
                        $deduction->fine=$request->amount[$key];
                        $deduction->status=1;
                        $deduction->save();
                    }
                }
            }
            if($request->deduction_type=='2'){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $deduction = Deduction::where('employee_id',$request->employee_id[$key])->firstOrNew();
                        $deduction->year=$request->year;
                        $deduction->month=$request->month;
                        $deduction->employee_id=$request->employee_id[$key];
                        $deduction->mobilebill=$request->amount[$key];
                        $deduction->status=2;
                        $deduction->save();
                    }
                }
            }
            if($request->deduction_type=='3'){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $deduction = Deduction::where('employee_id',$request->employee_id[$key])->firstOrNew();
                        $deduction->year=$request->year;
                        $deduction->month=$request->month;
                        $deduction->employee_id=$request->employee_id[$key];
                        $deduction->loan=$request->amount[$key];
                        $deduction->status=3;
                        $deduction->save();
                    }
                }
            }
            if($request->deduction_type=='4'){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $deduction = Deduction::where('employee_id',$request->employee_id[$key])->firstOrNew();
                        $deduction->year=$request->year;
                        $deduction->month=$request->month;
                        $deduction->employee_id=$request->employee_id[$key];
                        $deduction->cloth=$request->amount[$key];
                        $deduction->status=4;
                        $deduction->save();
                    }
                }
            }
            if($request->deduction_type=='5'){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $deduction = Deduction::where('employee_id',$request->employee_id[$key])->firstOrNew();
                        $deduction->year=$request->year;
                        $deduction->month=$request->month;
                        $deduction->employee_id=$request->employee_id[$key];
                        $deduction->jacket=$request->amount[$key];
                        $deduction->status=5;
                        $deduction->save();
                    }
                }
            }
            \LogActivity::addToLog('Add Deduction',$request->getContent(),'Deduction');
            return redirect()->route('deduction_asign.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));

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
}
