<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hrm\SalarySheet;
use App\Models\Customer;
use App\Models\Crm\CustomerDuty;
use App\Models\Crm\CustomerDutyDetail;

class SalarySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.create',compact('customer'));
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

    public function getSalaryData(Request $request)
    {
        $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')->join('job_posts','customer_duty_details.job_post_id','=','job_posts.id')
            ->select('customer_duties.*', 'customer_duty_details.*','job_posts.*');

        // if ($request->atm_id=='a') {
        //     $query = $query->where('customer_duty_details.atm_id',"!=","0")->where('customer_duties.branch_id', $request->branch_id);
        // }
        // else if ($request->atm_id=='n') {
        //     $query = $query->where('customer_duty_details.atm_id',"=","0")->where('customer_duties.branch_id', $request->branch_id);
        // }
        // else if ($request->atm_id >0) {
        //     $query = $query->where('customer_duty_details.atm_id',$request->atm_id)->where('customer_duties.branch_id', $request->branch_id);
        // }
        // else if ($request->branch_id) {
        //     $query = $query->where('customer_duties.branch_id', $request->branch_id);
        // }
        // else{
        //     $query = $query->where('customer_duties.customer_id', $request->customer_id);
        // }

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = $query->where(function($query) use ($startDate, $endDate) {
                $query->where(function($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '>=', $startDate)
                    ->whereDate('customer_duty_details.end_date', '<=', $endDate);
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '>=', $startDate)
                    ->whereNull('customer_duty_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '<=', $startDate)
                    ->whereNull('customer_duty_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '<=', $startDate)
                    ->whereDate('customer_duty_details.end_date', '>=', $startDate);
                });

                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '<=', $endDate)
                    ->whereDate('customer_duty_details.end_date', '>=', $endDate);
                });
            });
        }

        $data = $query->get();

        return response()->json($data, 200);
    }
}
