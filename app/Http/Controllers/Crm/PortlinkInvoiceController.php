<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\PortlinkAssignDetails;
use App\Models\Crm\PortlinkInvoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class PortlinkInvoiceController extends Controller
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
        return view('portlinkInvoice.create',compact('customer'));
    }

    public function getHeaderFooterNote(Request $request){
        $data = Customer::select('id','header_note','footer_note')->where('id',$request->customer_id)->first();
        return response()->json($data, 200);
    }

    public function getPortInvoiceData(Request $request)
    {
        $query = PortlinkAssignDetails::join('portlink_assigns', 'portlink_assigns.id', '=', 'portlink_assign_details.portlink_assign_id')->join('job_posts','portlink_assign_details.job_post_id','=','job_posts.id')
            ->select('portlink_assigns.*', 'portlink_assign_details.*','job_posts.*');

        if ($request->customer_id) {
            $query = $query->where('portlink_assigns.customer_id', $request->customer_id);
        }

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = $query->where(function($query) use ($startDate, $endDate) {
                $query->where(function($query) use ($startDate, $endDate) {
                    $query->whereDate('portlink_assign_details.start_date', '>=', $startDate)
                    ->whereDate('portlink_assign_details.end_date', '<=', $endDate);
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('portlink_assign_details.start_date', '>=', $startDate)
                    ->whereNull('portlink_assign_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('portlink_assign_details.start_date', '<=', $startDate)
                    ->whereNull('portlink_assign_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('portlink_assign_details.start_date', '<=', $startDate)
                    ->whereDate('portlink_assign_details.end_date', '>=', $startDate);
                });

                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('portlink_assign_details.start_date', '<=', $endDate)
                    ->whereDate('portlink_assign_details.end_date', '>=', $endDate);
                });
            });
        }

        $data = $query->get();

        return response()->json($data, 200);
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
     * @param  \App\Models\Crm\PortlinkInvoice  $portlinkInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(PortlinkInvoice $portlinkInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\PortlinkInvoice  $portlinkInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(PortlinkInvoice $portlinkInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\PortlinkInvoice  $portlinkInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortlinkInvoice $portlinkInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crm\PortlinkInvoice  $portlinkInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortlinkInvoice $portlinkInvoice)
    {
        //
    }
}
