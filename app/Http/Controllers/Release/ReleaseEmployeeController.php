<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Release\ReleaseEmployee;
use App\Models\Stock\Stock;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReleaseEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReleaseEmployee::all();
        return view('release.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = Employee::select('id','admission_id_no','bn_applicants_name')->get();
        return view('release.create',compact('employee'));
    }
    public function startRelease(Request $request){
        $emp = Employee::select('id','admission_id_no','bn_applicants_name','joining_date','bn_jobpost_id','bn_parm_village_name')->where('id',$request->employee_id)->first();
        $data= Stock::where('employee_id',$request->employee_id)->where('status',1)->get();

        //dd($data->toSql()); // This will show the raw SQL query
        return view('release.releaseForm',compact('emp','data'));
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
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(ReleaseEmployee $releaseEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(ReleaseEmployee $releaseEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReleaseEmployee $releaseEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleaseEmployee $releaseEmployee)
    {
        //
    }
}
