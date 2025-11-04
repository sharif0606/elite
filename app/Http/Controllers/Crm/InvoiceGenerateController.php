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
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Crm\IslamiBankInvoice;
use App\Models\Crm\IslamiBankInvoiceDetails;
use App\Models\Crm\OnetripInvoiceDetails;
use App\Models\Crm\PortlinkDeductionGuard;
use App\Models\Crm\PortlinkDeductionSupervisor;
use App\Models\Crm\PortlinkInvoice;
use App\Models\Crm\PortlinkInvoiceDetails;
use App\Models\Crm\PortlinkInvoiceLess;
use App\Models\Crm\SouthBanglaInvoice;
use App\Models\Crm\SouthBanglaInvoiceDetails;
use App\Models\Crm\WasaInvoiceDetails;
use App\Models\Employee\EmployeeDetails;
use Intervention\Image\Facades\Image;
use App\Models\Settings\DepositBank;
use Exception;

class InvoiceGenerateController extends Controller
{

    public function index(Request $request)
    {
        $invoice = InvoiceGenerate::with('payment', 'customer', 'branch', 'port_link')->orderBy('id', 'DESC');
        $customer = Customer::all();
        if ($request->fdate && $request->tdate) {
            $startDate = $request->fdate;
            $endDate = $request->tdate;

            $invoice->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('invoice_generates.start_date', '>=', $startDate)
                        ->whereDate('invoice_generates.end_date', '<=', $endDate);
                });
            });
        }
        if ($request->customer_id) {
            $customerId = $request->customer_id;
            $invoice->where('invoice_generates.customer_id', $customerId);
        }
        if ($request->branch_id) {
            $invoice->where('invoice_generates.branch_id', $request->branch_id);
        }
        if ($request->bill_date) {
            $billDate = $request->bill_date;
            $invoice->where('invoice_generates.bill_date', $billDate);
        }
        $invoice = $invoice->paginate(15);
        $deposit_bank = DepositBank::get();
        return view('invoice_generate.index', compact('invoice', 'customer', 'deposit_bank'));
    }

    public function create()
    {
        $customer = Customer::all();
        return view('invoice_generate.create', compact('customer'));
    }

    public function getHeaderFooterNote(Request $request)
    {
        $data = Customer::select('id', 'header_note', 'footer_note')->where('id', $request->customer_id)->first();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            $data = new InvoiceGenerate;
            $data->customer_id = $request->customer_id;
            if ($request->branch_id > 0) {
                $data->branch_id = $request->branch_id;
            }
            $data->atm_id = $request->atm_id;
            $data->zone_id = $request->zone_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->vat_switch = $request->vat_switch;
            $data->sub_total_amount = $request->sub_total_amount;
            $data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->inv_subject = $request->inv_subject;
            $data->invoice_type = 1;
            // invoice_type 1= general, 2=wasa, 3=onetrip
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id = $data->id;
                            $details->job_post_id = $request->job_post_id[$key];
                            if ($request->emp_assign_detl_id[$key]) {
                                $emp_assign_data = EmployeeAssignDetails::where('id', $request->emp_assign_detl_id[$key])->first();
                                $details->take_home_salary =$emp_assign_data->take_home_salary;
                                $details->material_support_cost = $emp_assign_data->material_support_cost;
                                $details->reliver_cost = $emp_assign_data->reliver_cost;
                                $details->overhead_service_charge = $emp_assign_data->overhead_service_charge;
                                $details->type = $emp_assign_data->type;
                            }
                            $details->rate = $request->rate[$key];
                            $details->employee_qty = $request->employee_qty[$key];
                            $details->bonus_rate = $request->bonus_rate[$key];
                            $details->bonus_amount = $request->bonus_amount[$key];
                            $details->bonus_type = $request->bonus_type[$key];
                            $details->bonus_for = $request->bonus_for[$key];
                            $details->atm_id = $request->detail_atm_id[$key];
                            $details->warking_day = $request->warking_day[$key];
                            $details->divide_by = $request->divide_by[$key];
                            $details->actual_warking_day = $request->actual_warking_day[$key];
                            $details->duty_day = $request->duty_day[$key];
                            $details->total_houres = $request->total_houres[$key];
                            $details->type_houre = $request->type_houre[$key];
                            $details->rate_per_houres = $request->rate_per_houres[$key];
                            $details->st_date = $request->st_date[$key];
                            $details->ed_date = $request->ed_date[$key];
                            $details->total_amounts = $request->total_amounts[$key];
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }
            }
            if ($request->add_amount) {
                foreach ($request->add_amount as $i => $add_amount) {
                    if ($add_amount) {
                        $olddue = new InvoiceGenerateLess;
                        $olddue->invoice_id = $data->id;
                        $olddue->description = $request->add_description[$i];
                        $olddue->amount = $add_amount;
                        $olddue->status = 0;
                        $olddue->save();
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate', $request->getContent(), 'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
             dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function show(Request $request, $id)
    {
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('customer_id', $invoice_id->customer_id)->first();
        return view('invoice_generate.show', compact('invoice_id', 'branch'));
    }
    public function getSingleInvoice1(Request $request, $id)
    {
        // echo $request->header;
        // die();
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        return view('invoice_generate.single_show1', compact('invoice_id', 'branch', 'headershow'));
    }
    public function getSingleInvoice2(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        return view('invoice_generate.single_show2', compact('invoice_id', 'branch', 'headershow'));
    }
    public function getSingleInvoice3(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        return view('invoice_generate.single_show3', compact('invoice_id', 'branch', 'headershow'));
    }
    public function getSingleInvoice4(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
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
        return view('invoice_generate.single_show4', compact('invoice_id', 'branch', 'headershow'));
    }
    public function getSingleInvoice5(Request $request, $id)
    {

        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        $portlink = PortlinkInvoice::where('invoice_id', $invoice_id->id)->first();
        $portDetail = PortlinkInvoiceDetails::where('invoice_id', $invoice_id->id)->get();
        $less = PortlinkInvoiceLess::where('invoice_id', $invoice_id->id)->get();
        $desup = PortlinkDeductionSupervisor::where('invoice_id', $invoice_id->id)->get();
        $deguard = PortlinkDeductionGuard::where('invoice_id', $invoice_id->id)->get();
        return view('invoice_generate.single_show5', compact('invoice_id', 'branch', 'headershow', 'portlink', 'portDetail', 'less', 'desup', 'deguard'));
    }
    public function getSingleInvoice6(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        $southBangla = SouthBanglaInvoice::where('invoice_id', $invoice_id->id)->first();
        $southDetail = SouthBanglaInvoiceDetails::where('invoice_id', $invoice_id->id)->get();
        return view('invoice_generate.single_show6', compact('invoice_id', 'branch', 'headershow', 'southBangla', 'southDetail'));
    }
    public function getSingleInvoice7(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        $wasa = WasaInvoice::where('invoice_id', $invoice_id->id)->first();
        $invoiceNo = '';
        // dd($headershow);
        if (!$wasa) {
            $headershow = 2;
            $wasa = IslamiBankInvoice::with("details")->where('invoice_id', $invoice_id->id)->first();
            $invoiceNo = $wasa->bill_date ? "ESSL/" . date('y', strtotime($wasa->bill_date)) . "-" . str_pad($invoice_id->id, 3, '0', STR_PAD_LEFT) : "ESSL/" . date('y') . "-" . str_pad($invoice_id->id, 3, '0', STR_PAD_LEFT);
            // dd($invoiceNo);
        } else {
            $invoiceNo = $invoice_id->customer?->invoice_number . "/" . \Carbon\Carbon::parse($invoice_id->end_date)->format('y') . "/" . $invoice_id->id;
        }
        return view('invoice_generate.single_show7', compact('invoice_id', 'branch', 'wasa', 'headershow', 'invoiceNo'));
    }

    public function getSingleInvoice8(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        $onetrip = OnetripInvoice::where('invoice_id', $invoice_id->id)->first();
        return view('invoice_generate.single_show8', compact('invoice_id', 'branch', 'onetrip', 'headershow'));
    }
    public function getSingleInvoice9(Request $request, $id)
    {
        $headershow = $request->header;
        $invoice_id = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $branch = CustomerBrance::where('id', $invoice_id->branch_id)->first();
        return view('invoice_generate.single_show9', compact('invoice_id', 'branch', 'headershow'));
    }

    public function edit($id)
    {
        $customer = Customer::all();
        $inv = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $invDetail = InvoiceGenerateDetails::where('invoice_id', $inv->id)->get();
        $invLess = InvoiceGenerateLess::where('invoice_id', $inv->id)->get();
        return view('invoice_generate.edit', compact('customer', 'inv', 'invDetail', 'invLess'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
            $data->customer_id = $request->customer_id;
            if ($request->branch_id > 0) {
                $data->branch_id = $request->branch_id;
            }
            $data->atm_id = $request->atm_id;
            $data->zone_id = $request->zone_id;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat;
            $data->vat_switch = $request->vat_switch;
            $data->sub_total_amount = $request->sub_total_amount;
            $data->total_tk = $request->total_tk;
            $data->vat_taka = $request->vat_taka;
            $data->grand_total = $request->grand_total;
            $data->footer_note = $request->footer_note;
            $data->header_note = $request->header_note;
            $data->inv_subject = $request->inv_subject;
            $data->invoice_type = 1;
            // invoice_type 1= general, 2=wasa, 3=onetrip
            $data->status = 0;
            if ($data->save()) {
                if ($request->job_post_id) {
                    InvoiceGenerateDetails::where('invoice_id', $data->id)->delete();
                    InvoiceGenerateLess::where('invoice_id', $data->id)->delete();
                    foreach ($request->job_post_id as $key => $value) {
                        if ($value) {
                            $details = new InvoiceGenerateDetails;
                            $details->invoice_id = $data->id;
                            $details->job_post_id = $request->job_post_id[$key];
                            $details->rate = $request->rate[$key];
                            $details->employee_qty = $request->employee_qty[$key];
                            $details->bonus_rate = $request->bonus_rate[$key];
                            $details->bonus_amount = $request->bonus_amount[$key];
                            $details->bonus_type = $request->bonus_type[$key];
                            $details->bonus_for = $request->bonus_for[$key];
                            $details->atm_id = $request->detail_atm_id[$key];
                            $details->warking_day = $request->warking_day[$key];
                            $details->divide_by = $request->divide_by[$key];
                            $details->actual_warking_day = $request->actual_warking_day[$key];
                            $details->duty_day = $request->duty_day[$key];
                            $details->total_houres = $request->total_houres[$key];
                            $details->type_houre = $request->type_houre[$key];
                            $details->rate_per_houres = $request->rate_per_houres[$key];
                            $details->st_date = $request->st_date[$key];
                            $details->ed_date = $request->ed_date[$key];
                            $details->total_amounts = $request->total_amounts[$key];
                            $details->status = 0;
                            $details->save();
                        }
                    }
                }
            }
            if ($request->add_amount) {
                foreach ($request->add_amount as $i => $add_amount) {
                    if ($add_amount) {
                        $olddue = new InvoiceGenerateLess;
                        $olddue->invoice_id = $data->id;
                        $olddue->description = $request->add_description[$i];
                        $olddue->amount = $add_amount;
                        $olddue->status = 0;
                        $olddue->save();
                    }
                }
            }
            DB::commit();
            \LogActivity::addToLog('Invoice Generate', $request->getContent(), 'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
            return redirect()->route('invoiceGenerate.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            // dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function destroy(Request $request, $id)
    { {
            DB::beginTransaction();
            try {
                $invoice_id = encryptor('decrypt', $id);
                $checkPayment = InvoicePayment::where('invoice_id', $invoice_id)->first();
                if (!$checkPayment) {
                    InvoiceGenerate::where('id', $invoice_id)->delete();
                    InvoiceGenerateDetails::where('invoice_id', $invoice_id)->delete();
                    WasaInvoice::where('invoice_id', $invoice_id)->delete();
                    WasaInvoiceDetails::where('invoice_id', $invoice_id)->delete();
                    IslamiBankInvoice::where('invoice_id', $invoice_id)->delete();
                    IslamiBankInvoiceDetails::where('invoice_id', $invoice_id)->delete();
                    InvoiceGenerateLess::where('invoice_id', $invoice_id)->delete();
                    OnetripInvoice::where('invoice_id', $invoice_id)->delete();
                    OnetripInvoiceDetails::where('invoice_id', $invoice_id)->delete();
                    PortlinkInvoice::where('invoice_id', $invoice_id)->delete();
                    PortlinkInvoiceDetails::where('invoice_id', $invoice_id)->delete();
                    PortlinkInvoiceLess::where('invoice_id', $invoice_id)->delete();
                    PortlinkDeductionGuard::where('invoice_id', $invoice_id)->delete();
                    PortlinkDeductionSupervisor::where('invoice_id', $invoice_id)->delete();
                    SouthBanglaInvoice::where('invoice_id', $invoice_id)->delete();
                    SouthBanglaInvoiceDetails::where('invoice_id', $invoice_id)->delete();

                    DB::commit();
                    \App\Helpers\LogActivity::addToLog('Invoice Delete', $request->getContent(), 'InvoiceGenerate,InvoiceGenerateDetails,InvoiceGenerateLess');
                    return redirect()->route('invoiceGenerate.index', ['role' => currentUser()])->with(Toastr::success('Data Delete!', 'Success', ["positionClass" => "toast-top-right"]));
                } else
                    return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            } catch (Exception $e) {
                DB::rollback();
                dd($e);
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }
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
            ->join('job_posts', 'employee_assign_details.job_post_id', '=', 'job_posts.id')
            ->leftjoin('atms', 'employee_assign_details.atm_id', '=', 'atms.id')
            ->select('employee_assigns.*', 'employee_assign_details.*', 'job_posts.*', 'atms.*', 'employee_assign_details.id as eid',);

        if ($request->atm_id == 'a') {
            $query = $query->where('employee_assign_details.atm_id', "!=", "0")->where('employee_assigns.branch_id', $request->branch_id);
        } else if ($request->atm_id == 'n') {
            $query = $query->where('employee_assign_details.atm_id', "=", "0")->where('employee_assigns.branch_id', $request->branch_id);
        } else if ($request->atm_id > 0) {
            $query = $query->where('employee_assign_details.atm_id', $request->atm_id)->where('employee_assigns.branch_id', $request->branch_id);
        } else if ($request->branch_id) {
            $query = $query->where('employee_assigns.branch_id', $request->branch_id);
        } else {
            $query = $query->where('employee_assigns.customer_id', $request->customer_id);
        }

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = $query->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '>=', $startDate)
                        ->whereDate('employee_assign_details.end_date', '<=', $endDate);
                });
                $query->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '>=', $startDate)
                        ->whereNull('employee_assign_details.end_date');
                });
                $query->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $startDate)
                        ->whereNull('employee_assign_details.end_date');
                });
                $query->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $startDate)
                        ->whereDate('employee_assign_details.end_date', '>=', $startDate);
                });

                $query->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('employee_assign_details.start_date', '<=', $endDate)
                        ->whereDate('employee_assign_details.end_date', '>=', $endDate);
                });
            });
        }

        $data = $query->get();
        return response()->json($data, 200);
    }
    public function lessPaidInvoiceGenerate($customer, $startDate, $id, $branchId = null)
    {
        $inv = InvoiceGenerate::where('id', $id)->first();
        $branch = CustomerBrance::where('id', $branchId)->first();
        if ($branch != '') {
            $invoices = InvoiceGenerate::where('customer_id', $customer)->where('branch_id', $branchId)
                ->where('start_date', '<=', $startDate)
                ->get();
        } else {
            $invoices = InvoiceGenerate::where('customer_id', $customer)
                ->where('start_date', '<=', $startDate)
                ->get();
        }
        $result = [];
        foreach ($invoices as $invoice) {
            $receivedAmount = InvoicePayment::where('invoice_id', $invoice->id)
                ->select(
                    DB::raw("SUM(received_amount) as received_amount"),
                    DB::raw("SUM(ait_amount) as ait_amount"),
                    DB::raw("SUM(fine_deduction) as fine_deduction"),
                    DB::raw("SUM(paid_by_client) as paid_by_client"),
                    DB::raw("SUM(less_paid_honor) as less_paid_honor"),
                    DB::raw("SUM(vat_amount) as vat_amount")
                )
                ->groupBy('invoice_id')
                ->first();

            // Calculate the total received amount across all relevant fields
            $receivedAmountValue = (
                ($receivedAmount->received_amount ?? 0) +
                ($receivedAmount->ait_amount ?? 0) +
                ($receivedAmount->fine_deduction ?? 0) +
                ($receivedAmount->paid_by_client ?? 0) +
                ($receivedAmount->less_paid_honor ?? 0) +
                ($receivedAmount->vat_amount ?? 0)
            );

            // Calculate the due amount
            $dueAmount = round($invoice->grand_total - $receivedAmountValue);

            // If due amount is greater than zero, add this invoice to the result array
            if ($dueAmount > 0) {
                $invoice->due_amount = $dueAmount;
                $invoice->received_amount = round($receivedAmountValue);
                $invoice->actual_received = round($receivedAmount->received_amount);
                $result[] = $invoice;
            }
        }
        return view('invoice_generate.less_paid_invoice', compact('result', 'inv', 'branch'));
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
