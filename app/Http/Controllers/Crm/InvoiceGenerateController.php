<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\EmployeeAssign;
use App\Models\Crm\EmployeeAssignDetails;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class InvoiceGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice=InvoiceGenerate::all();
        return view('invoice_generate.index',compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('invoice_generate.create',compact('customer'));
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

    // public function getInvoiceData(Request $request)
    // {
    //     $customerId=$request->customer_id;
    //     $startDate=$request->start_date;
    //     $endDate=$request->end_date;
    //     $emAsinId=EmployeeAssign::where('customer_id', $customerId)->pluck('id');
    //     $getInvoice=EmployeeAssignDetails::whereIn('employee_assign_id', $emAsinId)->get();
    //     return response()->json($getInvoice,200);
    // }
    public function getInvoiceData(Request $request)
    {
        $query = EmployeeAssignDetails::join('employee_assigns', 'employee_assigns.id', '=', 'employee_assign_details.employee_assign_id')
            ->select('employee_assigns.*', 'employee_assign_details.*');

        if ($request->customer_id) {
            $query->where('employee_assigns.customer_id', $request->customer_id);
        }

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->toDateString();
            $endDate = Carbon::parse($request->end_date)->toDateString();

            $query->where(function($query) use ($startDate, $endDate) {
                $query->where('employee_assign_details.start_date', '>=', $startDate)
                ->where('employee_assign_details.end_date', '<=', $endDate);
            });
        }

        $data = $query->get();

        return response()->json($data, 200);
    }
    // public function getInvoiceData(Request $request)
    // {
    //     $query = EmployeeAssignDetails::join('employee_assigns', 'employee_assigns.id', '=', 'employee_assign_details.employee_assign_id')
    //         ->select('employee_assigns.*', 'employee_assign_details.*');

    //     if ($request->customer_id) {
    //         $query->where('employee_assigns.customer_id', $request->customer_id);
    //     }

    //     if ($request->start_date && $request->end_date) {
    //         $startDate = Carbon::parse($request->start_date)->toDateString();
    //         $endDate = Carbon::parse($request->end_date)->toDateString();

    //         $query->where(function($query) use ($startDate, $endDate) {
    //             $query->where(function($q) use ($startDate) {
    //                 $q->where('employee_assign_details.start_date', '>=', $startDate);
    //             })
    //             ->where(function($q) use ($startDate, $endDate) {
    //                 $q->where('employee_assign_details.end_date', '<=', $endDate)
    //                     ->orWhereNull('employee_assign_details.end_date');
    //             });
    //         });
    //     }

    //     $data = $query->get();

    //     return response()->json($data, 200);
    // }


}
