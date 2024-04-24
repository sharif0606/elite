<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\InvoiceGenerateLess;
use App\Models\Crm\EmployeeAssign;
use App\Models\Crm\EmployeeAssignDetails;
use App\Models\Crm\WasaInvoice;
use App\Models\Crm\OnetripInvoice;
use App\Models\Crm\InvoicePayment;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class InvoiceGenerateController extends Controller
{

    public function index()
    {
        $invoice=InvoiceGenerate::orderBy('id','DESC')->get();
        $customer=Customer::all();
        return view('invoice_generate.index',compact('invoice','customer'));
    }

    public function create()
    {
        $customer=Customer::all();
        return view('invoice_generate.create',compact('customer'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try{
            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->sub_total_amount = $request->sub_total_amount;
            $data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
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
                            $details->atm_id = $request->detail_atm_id[$key];
                            $details->warking_day=$request->warking_day[$key];
                            $details->total_houres=$request->total_houres[$key];
                            $details->type_houre=$request->type_houre[$key];
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
            if($request->add_amount){
                foreach($request->add_amount as $i=>$add_amount){
                    if($add_amount){
                        $olddue=new InvoiceGenerateLess;
                        $olddue->invoice_id=$data->id;
                        $olddue->description=$request->add_description[$i];
                        $olddue->amount=$add_amount;
                        $olddue->status=0;
                        $olddue->save();
                    }
                }
            }
            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));


        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function invoicePayment(Request $request)
    {
        try{
            $data=new InvoicePayment;
            $data->invoice_id = $request->invId;
            $data->taka = $request->grand_total;
            $data->date = $request->date;
            $data->save();


            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));


        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function show(Request $request,$id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->customer_id)->first();
        return view('invoice_generate.show',compact('invoice_id','branch'));
    }
    public function getSingleInvoice1(Request $request,$id)
    {
        // echo $request->header;
        // die();
        $headershow=$request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('id',$invoice_id->branch_id)->first();
        return view('invoice_generate.single_show1',compact('invoice_id','branch','headershow'));
    }
    public function getSingleInvoice2(Request $request, $id)
    {
        $headershow=$request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->branch_id)->first();
        return view('invoice_generate.single_show2',compact('invoice_id','branch','headershow'));
    }
    public function getSingleInvoice3(Request $request, $id)
    {
        $headershow=$request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->branch_id)->first();
        return view('invoice_generate.single_show3',compact('invoice_id','branch','headershow'));
    }
    public function getSingleInvoice4(Request $request, $id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->branch_id)->first();
    //     $summaryQuery = "SELECT
    //     SUM(`rate`) as total,
    //     (SELECT vat FROM invoice_generates WHERE invoice_generates.id = invoice_generate_details.invoice_id) as Vat,
    //     ROUND(SUM(`rate` * (SELECT vat FROM invoice_generates WHERE invoice_generates.id = invoice_generate_details.invoice_id) / 100), 2) as withVat FROM `invoice_generate_details` WHERE `invoice_id` = $invoice_id->id;";

    // $summery = DB::select($summaryQuery)[0];
    //     $dueTotal = ($summery->withVat+$summery->total);
    //     $textValue='Zero';
    //     if ($dueTotal > 0) {
    //         $textValue = getBangladeshCurrency($dueTotal);
    //     }
        // return view('invoice_generate.single_show4',compact('invoice_id','branch','textValue'));
        return view('invoice_generate.single_show4',compact('invoice_id','branch'));
    }
    public function getSingleInvoice5($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->customer_id)->first();
        return view('invoice_generate.single_show5',compact('invoice_id','branch'));
    }
    public function getSingleInvoice6($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->customer_id)->first();
        return view('invoice_generate.single_show6',compact('invoice_id','branch'));
    }
    public function getSingleInvoice7($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->customer_id)->first();
        $wasa=WasaInvoice::where('invoice_id',$invoice_id->id)->first();
        return view('invoice_generate.single_show7',compact('invoice_id','branch','wasa'));
    }
    public function getSingleInvoice8($id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $branch=CustomerBrance::where('customer_id',$invoice_id->customer_id)->first();
        $onetrip=OnetripInvoice::where('invoice_id',$invoice_id->id)->first();
        return view('invoice_generate.single_show8',compact('invoice_id','branch','onetrip'));
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
        $query = EmployeeAssignDetails::join('employee_assigns', 'employee_assigns.id', '=', 'employee_assign_details.employee_assign_id')->join('job_posts','employee_assign_details.job_post_id','=','job_posts.id')->leftjoin('atms','employee_assign_details.atm_id','=','atms.id')
            ->select('employee_assigns.*', 'employee_assign_details.*','job_posts.*','atms.*');

        if ($request->atm_id=='a') {
            $query = $query->where('employee_assign_details.atm_id',"!=","0")->where('employee_assigns.branch_id', $request->branch_id);
        }
        else if ($request->atm_id=='n') {
            $query = $query->where('employee_assign_details.atm_id',"=","0")->where('employee_assigns.branch_id', $request->branch_id);
        }
        else if ($request->atm_id >0) {
            $query = $query->where('employee_assign_details.atm_id',$request->atm_id)->where('employee_assigns.branch_id', $request->branch_id);
        }
        else if ($request->branch_id) {
            $query = $query->where('employee_assigns.branch_id', $request->branch_id);
        }
        else{
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
