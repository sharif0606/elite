<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\InvoiceGenerateLess;
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
        // dd($request->all());
        try{
            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->sub_total_amount = $request->sub_total_amount;
            $data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->rate=$request->rate[$key];
                            $details->employee_qty=$request->employee_qty[$key];
                            $details->warking_day=$request->warking_day[$key];
                            $details->total_houres=$request->total_houres[$key];
                            $details->rate_per_houres=$request->rate_per_houres[$key];
                            $details->st_date=$request->st_date[$key];
                            $details->ed_date=$request->ed_date[$key];
                            $details->total_amounts=$request->total_amounts[$key];
                            $details->status=0;
                            $details->save();
                        }
                    }
                }
            }
            if($request->less_amount){
                foreach($request->less_amount as $i=>$less_amount){
                    if($less_amount){
                        $olddue=new InvoiceGenerateLess;
                        $olddue->invoice_id=$data->id;
                        $olddue->less_description=$request->less_description[$i];
                        $olddue->less_amount=$less_amount;
                        $olddue->status=0;
                        $olddue->save();
                    }
                }
            }
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));


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
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.show',compact('invoice_id'));
    }
    public function getSingleInvoice1($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show1',compact('invoice_id'));
    }
    public function getSingleInvoice2($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show2',compact('invoice_id'));
    }
    public function getSingleInvoice3($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show3',compact('invoice_id'));
    }
    public function getSingleInvoice4($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show4',compact('invoice_id'));
    }
    public function getSingleInvoice5($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show5',compact('invoice_id'));
    }
    public function getSingleInvoice6($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        return view('invoice_generate.single_show6',compact('invoice_id'));
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
        $query = EmployeeAssignDetails::join('employee_assigns', 'employee_assigns.id', '=', 'employee_assign_details.employee_assign_id')->join('job_posts','employee_assign_details.job_post_id','=','job_posts.id')
            ->select('employee_assigns.*', 'employee_assign_details.*','job_posts.*');

        if ($request->customer_id) {
            $query = $query->where('employee_assigns.customer_id', $request->customer_id);
        }

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = $query->where(function($query) use ($startDate, $endDate) {
                $query->where(function($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '>=', $startDate)
                    ->whereDate('employee_assign_details.end_date', '<=', $endDate);
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '>=', $startDate)
                    ->whereNull('employee_assign_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $startDate)
                    ->whereNull('employee_assign_details.end_date');
                });
                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $startDate)
                    ->whereDate('employee_assign_details.end_date', '>=', $startDate);
                });

                $query->orWhere(function($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $endDate)
                    ->whereDate('employee_assign_details.end_date', '>=', $endDate);
                });

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
