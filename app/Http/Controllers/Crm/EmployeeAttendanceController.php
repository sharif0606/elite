<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\EmployeeAttendance;
use App\Models\Employee\Employee;
use App\Models\Customer;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empatten=EmployeeAttendance::all();
        return view('employee_atten.index',compact('empatten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('employee_atten.create',compact('customer'));
    }

    public function getEmployee(Request $request)
	{
		$data = Employee::where('admission_id_no',$request->id)->with('position')->first();
        if($request->id && isset($data)){
            if($data->status == 1){
                $data = Employee::where('admission_id_no',$request->id)->with('position')->get();
                return $data;
            }
            else{
                $d['msg'] ="Inactive";
                return $d;
            }
        }
        elseif(!$data && $request->id){
            $d['msg'] ="Not Found";
            return $d;
        }else{
            $d['msg'] ="";
            return $d;
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
        //
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
