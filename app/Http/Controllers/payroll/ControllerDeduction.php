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
        $deductions=Deduction::where('deduction_type',1)->get();
        return view('pay_roll.deduction.fineindex',compact('deductions'));
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
            $data=new Deduction;
            $data->year = $request->year;
            $data->month = $request->month;
            $data->deduction_type = $request->deduction_type;
            $data->status = 0;
            if($data->save()){
                if($request->deduction_type=='1'){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = DeductionDetail::where('employee_id',$request->employee_id[$key])->firstOrNew();
                            $details->deduction_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->fine=$request->amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
                if($request->deduction_type=='2'){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = DeductionDetail::where('employee_id',$request->employee_id[$key])->firstOrNew();
                            $details->deduction_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->mobilebill=$request->amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
                if($request->deduction_type=='3'){
                    foreach($request->employee_id as $key => $value){
                        if($value){
                            $details = DeductionDetail::where('employee_id',$request->employee_id[$key])->firstOrNew();
                            $details->deduction_id=$data->id;
                            $details->employee_id=$request->employee_id[$key];
                            $details->loan=$request->amount[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if ($data->save()) {
                \LogActivity::addToLog('Add Deduction',$request->getContent(),'Deduction,DeductionDetail');
                return redirect()->route('deduction_asign.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

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
