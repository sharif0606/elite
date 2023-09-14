<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\EmployeeAssign;
use App\Models\Employee\Employee;
use App\Models\Customer;

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
    public function index()
    {
        $empasin=EmployeeAssign::groupBy('generate_unique_id')->get();
        return view('employee_assign.index',compact('empasin'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee=Employee::all();
        $customer=Customer::all();
        return view('employee_assign.create',compact('employee','customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $uniqueid=substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
            if($request->employee_id){
                foreach($request->employee_id as $key => $value){
                    if($value){
                        $employee = new EmployeeAssign;
                        $employee->date=$request->date;
                        $employee->generate_unique_id=$uniqueid;
                        // $employee->generate_unique_id='EM-'.Carbon::now()->format('m-y').'-'. str_pad((EmployeeAssign::whereYear('created_at', Carbon::now()->year)->count() + 1),4,"0",STR_PAD_LEFT);
                        $employee->employee_id=$request->employee_id[$key];
                        $employee->customer_id=$request->customer_id[$key];
                        $employee->start_date=$request->start_date[$key];
                        $employee->end_date=$request->end_date[$key];
                        $employee->status=1;
                        $employee->save();
                    }
                }
                return redirect()->route('empasign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
