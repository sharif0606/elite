<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CustomerDuty;
use App\Models\Crm\CustomerAttendance;
use App\Models\Crm\EmployeeRateDetails;
use App\Models\Crm\EmployeeRate;

use App\Models\Customer;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class CustomerDutyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerduty=CustomerDuty::all();
        return view('customer_duty.index',compact('customerduty'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('customer_duty.create',compact('customer'));
    }

    public function getEmployeeDuty(Request $request)
    {
        try {
            $customerId = $request->customer_id;
            $jobpostId = $request->job_post_id;
            $empAssignId = EmployeeRate::where('customer_id', $customerId)->pluck('id');
            $data = EmployeeRateDetails::whereIn('employee_rate_id', $empAssignId)->where('job_post_id', $jobpostId)->orderBy('id', 'desc')->first();
            return $data;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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