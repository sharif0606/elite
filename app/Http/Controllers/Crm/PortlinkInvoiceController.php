<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\PortlinkAssignDetails;
use App\Models\Crm\PortlinkDeductionGuard;
use App\Models\Crm\PortlinkDeductionSupervisor;
use App\Models\Crm\PortlinkInvoice;
use App\Models\Crm\PortlinkInvoiceDetails;
use App\Models\Crm\PortlinkInvoiceLess;
use App\Models\Customer;
use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

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
        $query = PortlinkAssignDetails::join('portlink_assigns', 'portlink_assigns.id', '=', 'portlink_assign_details.portlink_assign_id')->join('job_posts','portlink_assign_details.job_post_id','=','job_posts.id')->leftjoin('hours','portlink_assign_details.hours','=','hours.id')
            ->select('portlink_assigns.*', 'portlink_assign_details.*','job_posts.*','hours.hour as assigned_hour');

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
        //dd($request->all());
        DB::beginTransaction();
        try{
            $data=new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->net_salary_rate = $request->net_salary_rate;
            $data->sub_total_amount = $request->net_commission_rate;
            $data->total_tk = $request->total_tk; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->invoice_type = 4;
            // invoice_type 1= general, 2=wasa, 3=onetrip, 4=portlink
            $data->status = 0;
            if($data->save()){
                $portlink = new PortlinkInvoice;
                $portlink->invoice_id = $data->id;
                $portlink->customer_id = $request->customer_id;
                $portlink->start_date = $request->start_date;
                $portlink->end_date = $request->end_date;
                $portlink->bill_date = $request->bill_date;
                $portlink->vat = $request->vat;
                $portlink->sub_amount = $request->sub_salary_total;
                $portlink->sub_commission_amount = $request->sub_commission_total;
                $portlink->sub_total_amount = $request->sub_total_amount;
                $portlink->net_amount = $request->net_salary_rate;
                $portlink->net_commission = $request->net_commission_rate;
                $portlink->net_total_tk = $request->total_tk;
                $portlink->vat_taka = $request->vat_taka;
                $portlink->grand_total = $request->grand_total;
                $portlink->footer_note = $request->footer_note;
                $portlink->header_note = $request->header_note;
                $portlink->invoice_type = 4;
                $portlink->save();
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->rate=$request->rate[$key];
                            $details->employee_qty=$request->employee_qty[$key];
                            $details->divide_by=$request->divide_by[$key];
                            $details->actual_warking_day=$request->actual_warking_day[$key];
                            $details->duty_day=$request->duty_day[$key];
                            $details->type_houre=$request->type_houre[$key];
                            $details->st_date=$request->st_date[$key];
                            $details->ed_date=$request->ed_date[$key];
                            $details->total_amounts=$request->total_amounts[$key];
                            $details->status=0;
                            $details->save();

                            //portlinkdetail
                            $portDetails = new PortlinkInvoiceDetails;
                            $portDetails->invoice_id=$data->id;
                            $portDetails->portlink_invoice_id=$portlink->id;
                            $portDetails->job_post_id=$request->job_post_id[$key];
                            $portDetails->rate=$request->rate[$key];
                            $portDetails->commission=$request->commission[$key];
                            $portDetails->employee_qty=$request->employee_qty[$key];
                            $portDetails->divide_by=$request->divide_by[$key];
                            $portDetails->duty_day=$request->duty_day[$key];
                            $portDetails->type_houre=$request->type_houre[$key];
                            $portDetails->net_salary_amount=$request->net_salary_amount[$key];
                            $portDetails->net_commission_amount=$request->net_commission_amount[$key];
                            $portDetails->total_amounts=$request->total_amounts[$key];
                            $portDetails->st_date=$request->st_date[$key];
                            $portDetails->ed_date=$request->ed_date[$key];
                            $portDetails->status=0;
                            $portDetails->save();
                        }
                    }
                }
            }
            if($request->total_less){
                foreach($request->total_less as $i=>$total_less){
                    if($total_less){
                        $lessDe=new PortlinkInvoiceLess;
                        $lessDe->invoice_id=$data->id;
                        $lessDe->portlink_invoice_id=$portlink->id;
                        $lessDe->less_description=$request->less_description[$i];
                        $lessDe->less_rate=$request->less_rate[$i];
                        $lessDe->less_commission=$request->less_commission[$i];
                        $lessDe->count_hour=$request->add_hour[$i];
                        $lessDe->net_less=$request->net_less[$i];
                        $lessDe->commission_less=$request->commission_less[$i];
                        $lessDe->total_less=$total_less;
                        $lessDe->save();
                    }
                }
            }
            if($request->supervisor_amount){
                foreach($request->supervisor_amount as $j=>$supervisor_amount){
                    if($supervisor_amount){
                        $deSuper=new PortlinkDeductionSupervisor;
                        $deSuper->invoice_id=$data->id;
                        $deSuper->portlink_invoice_id=$portlink->id;
                        $deSuper->deduction_description=$request->supervisor_deduction_description[$j];
                        $deSuper->deduct_sup_rate=$request->deduct_sup_rate[$j];
                        $deSuper->deduct_sup_commission=$request->deduct_sup_commission[$j];
                        $deSuper->count_hour=$request->hour_supervisor[$j];
                        $deSuper->net_deduction=$request->supervisor_rate_amount[$j];
                        $deSuper->commission_deduction=$request->supervisor_comission_amount[$j];
                        $deSuper->total_deduction=$supervisor_amount;
                        $deSuper->save();
                    }
                }
            }
            if($request->guard_amount){
                foreach($request->guard_amount as $k=>$guard_amount){
                    if($guard_amount){
                        $deGuard=new PortlinkDeductionGuard;
                        $deGuard->invoice_id=$data->id;
                        $deGuard->portlink_invoice_id=$portlink->id;
                        $deGuard->deduction_description=$request->guard_deduction_description[$k];
                        $deGuard->deduct_guard_rate=$request->deduct_guard_rate[$k];
                        $deGuard->deduct_guard_commission=$request->deduct_guard_commission[$k];
                        $deGuard->count_hour=$request->hour_guard[$k];
                        $deGuard->net_deduction=$request->guard_rate_amount[$k];
                        $deGuard->commission_deduction=$request->guard_comission_amount[$k];
                        $deGuard->total_deduction=$guard_amount;
                        $deGuard->save();
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
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
    public function edit($id)
    {
        $customer=Customer::all();
        $inv = InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
        $invPort = PortlinkInvoice::where('invoice_id',$inv->id)->first();
        $invPortDetail = PortlinkInvoiceDetails::where('portlink_invoice_id',$invPort->id)->get();
        $less = PortlinkInvoiceLess::where('invoice_id',$inv->id)->get();
        $supDeduct = PortlinkDeductionSupervisor::where('invoice_id',$inv->id)->get();
        $guardDeduct = PortlinkDeductionGuard::where('invoice_id',$inv->id)->get();
        return view('portlinkInvoice.edit',compact('customer','inv','invPort','invPortDetail','less','supDeduct','guardDeduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\PortlinkInvoice  $portlinkInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        DB::beginTransaction();
        try{
            $data= InvoiceGenerate::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->net_salary_rate = $request->net_salary_rate;
            $data->sub_total_amount = $request->net_commission_rate;
            $data->total_tk = $request->total_tk; //this total_tk is required for show as subtotal in payment
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->invoice_type = 4;
            // invoice_type 1= general, 2=wasa, 3=onetrip, 4=portlink
            $data->status = 0;
            if($data->save()){
                $portlink = PortlinkInvoice::where('invoice_id',$data->id)->first();
                $portlink->invoice_id = $data->id;
                $portlink->customer_id = $request->customer_id;
                $portlink->start_date = $request->start_date;
                $portlink->end_date = $request->end_date;
                $portlink->bill_date = $request->bill_date;
                $portlink->vat = $request->vat;
                $portlink->sub_amount = $request->sub_salary_total;
                $portlink->sub_commission_amount = $request->sub_commission_total;
                $portlink->sub_total_amount = $request->sub_total_amount;
                $portlink->net_amount = $request->net_salary_rate;
                $portlink->net_commission = $request->net_commission_rate;
                $portlink->net_total_tk = $request->total_tk;
                $portlink->vat_taka = $request->vat_taka;
                $portlink->grand_total = $request->grand_total;
                $portlink->footer_note = $request->footer_note;
                $portlink->header_note = $request->header_note;
                $portlink->invoice_type = 4;
                $portlink->save();
                if($request->job_post_id){
                    PortlinkInvoiceDetails::where('invoice_id',$data->id)->delete();
                    InvoiceGenerateDetails::where('invoice_id',$data->id)->delete();
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->rate=$request->rate[$key];
                            $details->employee_qty=$request->employee_qty[$key];
                            $details->divide_by=$request->divide_by[$key];
                            $details->actual_warking_day=$request->actual_warking_day[$key];
                            $details->duty_day=$request->duty_day[$key];
                            $details->type_houre=$request->type_houre[$key];
                            $details->st_date=$request->st_date[$key];
                            $details->ed_date=$request->ed_date[$key];
                            $details->total_amounts=$request->total_amounts[$key];
                            $details->status=0;
                            $details->save();

                            //portlinkdetail
                            $portDetails = new PortlinkInvoiceDetails;
                            $portDetails->invoice_id=$data->id;
                            $portDetails->portlink_invoice_id=$portlink->id;
                            $portDetails->job_post_id=$request->job_post_id[$key];
                            $portDetails->rate=$request->rate[$key];
                            $portDetails->commission=$request->commission[$key];
                            $portDetails->employee_qty=$request->employee_qty[$key];
                            $portDetails->divide_by=$request->divide_by[$key];
                            $portDetails->duty_day=$request->duty_day[$key];
                            $portDetails->type_houre=$request->type_houre[$key];
                            $portDetails->net_salary_amount=$request->net_salary_amount[$key];
                            $portDetails->net_commission_amount=$request->net_commission_amount[$key];
                            $portDetails->total_amounts=$request->total_amounts[$key];
                            $portDetails->st_date=$request->st_date[$key];
                            $portDetails->ed_date=$request->ed_date[$key];
                            $portDetails->status=0;
                            $portDetails->save();
                        }
                    }
                }
            }
            if($request->total_less){
                PortlinkInvoiceLess::where('invoice_id',$data->id)->delete();
                foreach($request->total_less as $i=>$total_less){
                    if($total_less){
                        $lessDe=new PortlinkInvoiceLess;
                        $lessDe->invoice_id=$data->id;
                        $lessDe->portlink_invoice_id=$portlink->id;
                        $lessDe->less_description=$request->less_description[$i];
                        $lessDe->less_rate=$request->less_rate[$i];
                        $lessDe->less_commission=$request->less_commission[$i];
                        $lessDe->count_hour=$request->add_hour[$i];
                        $lessDe->net_less=$request->net_less[$i];
                        $lessDe->commission_less=$request->commission_less[$i];
                        $lessDe->total_less=$total_less;
                        $lessDe->save();
                    }
                }
            }
            if($request->supervisor_amount){
                PortlinkDeductionSupervisor::where('invoice_id',$data->id)->delete();
                foreach($request->supervisor_amount as $j=>$supervisor_amount){
                    if($supervisor_amount){
                        $deSuper=new PortlinkDeductionSupervisor;
                        $deSuper->invoice_id=$data->id;
                        $deSuper->portlink_invoice_id=$portlink->id;
                        $deSuper->deduction_description=$request->supervisor_deduction_description[$j];
                        $deSuper->deduct_sup_rate=$request->deduct_sup_rate[$j];
                        $deSuper->deduct_sup_commission=$request->deduct_sup_commission[$j];
                        $deSuper->count_hour=$request->hour_supervisor[$j];
                        $deSuper->net_deduction=$request->supervisor_rate_amount[$j];
                        $deSuper->commission_deduction=$request->supervisor_comission_amount[$j];
                        $deSuper->total_deduction=$supervisor_amount;
                        $deSuper->save();
                    }
                }
            }
            if($request->guard_amount){
                PortlinkDeductionGuard::where('invoice_id',$data->id)->delete();
                foreach($request->guard_amount as $k=>$guard_amount){
                    if($guard_amount){
                        $deGuard=new PortlinkDeductionGuard;
                        $deGuard->invoice_id=$data->id;
                        $deGuard->portlink_invoice_id=$portlink->id;
                        $deGuard->deduction_description=$request->guard_deduction_description[$k];
                        $deGuard->deduct_guard_rate=$request->deduct_guard_rate[$k];
                        $deGuard->deduct_guard_commission=$request->deduct_guard_commission[$k];
                        $deGuard->count_hour=$request->hour_guard[$k];
                        $deGuard->net_deduction=$request->guard_rate_amount[$k];
                        $deGuard->commission_deduction=$request->guard_comission_amount[$k];
                        $deGuard->total_deduction=$guard_amount;
                        $deGuard->save();
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate',$request->getContent(),'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
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
