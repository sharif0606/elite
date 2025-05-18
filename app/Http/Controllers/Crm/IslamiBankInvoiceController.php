<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Atm;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Crm\InvoiceGenerateDetails;
use App\Models\Crm\IslamiBankEmpAssign;
use App\Models\Crm\IslamiBankInvoice;
use App\Models\Crm\IslamiBankInvoiceDetails;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\JobPost;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IslamiBankInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('crm.islami_bank_invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $checkIBBLAssign = IslamiBankEmpAssign::where('customer_id', $request->customer_id)->first();
        if ($checkIBBLAssign) {
            $jobpost = JobPost::get();
            $branch = CustomerBrance::where('id', $checkIBBLAssign->branch_id)->first();
            $customer = Customer::where('id', $checkIBBLAssign->customer_id)->first();
            $atm = Atm::where('branch_id', $checkIBBLAssign->branch_id)->get();
            $employee = Employee::select('id', 'admission_id_no', 'en_applicants_name')->get();
            return view('islami_bank_assign.createInvoice', compact('jobpost', 'customer', 'checkIBBLAssign', 'branch', 'atm', 'employee'));
        } else {
            return back();
        }
    }

    public function createInvoice(Request $request, $customer_id)
    {
        $branch_id = $request->query('branch_id');
        $atm_id = $request->query('atm_id');
        $IBBLAssign = IslamiBankEmpAssign::with('branch', 'atm')
            ->where('customer_id', $customer_id)
            // ->where('company_branch_id', $branch_id)
            // ->where('atm_id', $atm_id)
            ->first();
        // dd($IBBLAssign);
        if ($IBBLAssign) {
            $jobpost = JobPost::get();
            $customer = Customer::where('id', $IBBLAssign->customer_id)->first();
            $branch = CustomerBrance::where('customer_id', $IBBLAssign->customer_id)->get();
            $atm = Atm::where('id', $IBBLAssign->atm_id)->get();
            $employee = Employee::select('id', 'admission_id_no', 'en_applicants_name')->get();
            return view('islami_bank_assign.createInvoice', compact('jobpost', 'customer', 'IBBLAssign', 'branch', 'atm', 'employee'));
        } else {
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // $billDate = Carbon::parse($request->bill_date);
            $firstDayOfMonth = $request->start_date;
            $lastDayOfMonth = $request->end_date;

            $data = new InvoiceGenerate();
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $firstDayOfMonth;
            $data->end_date = $lastDayOfMonth;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat_on_subtotal;
            $data->sub_total_amount = $request->sub_total_salary;
            $data->total_tk = $request->sub_total_salary;
            $data->vat_taka = $request->vat_tk_subtotal;
            $data->grand_total = $request->grand_total_tk;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->zone_id = $request->zone_id;
            $data->invoice_type = 6;
            // invoice_type 1= general, 2=wasa, 3=onetrip
            $data->status = 0;
            if ($data->save()) {
                $invoice = new IslamiBankInvoice();
                $invoice->invoice_id = $data->id;
                $invoice->customer_id = $request->customer_id;
                $invoice->company_branch_id = $request->branch_id;
                $invoice->atm_id = $request->atm_id;
                $invoice->sub_total_salary = $request->sub_total_salary;
                $invoice->add_commission = $request->add_commission_percentage;
                $invoice->add_commission_tk = $request->add_commission_tk;
                $invoice->vat_on_commission = $request->vat_commission_percentage;
                $invoice->vat_on_commission_tk = $request->vat_commission_percentage_tk;
                $invoice->ait_on_commission = $request->ait_commission_percentage;
                $invoice->ait_on_commission_tk = $request->ait_commission_percentage_tk;
                $invoice->vat_ait_on_commission = $request->vat_ait_commission_percentage;
                $invoice->vat_ait_on_commission_tk = $request->vat_ait_commission_tk;
                $invoice->vat_on_subtotal = $request->vat_on_subtotal;
                $invoice->vat_on_subtotal_tk = $request->vat_tk_subtotal;
                $invoice->ait_on_subtotal = $request->ait_on_subtotal;
                $invoice->ait_on_subtotal_tk = $request->ait_tk_subtotal;
                $invoice->grand_total_tk = $request->grand_total_tk;
                $invoice->footer_note = $request->footer_note;
                $invoice->bill_date = $request->bill_date;
                $invoice->start_date = $firstDayOfMonth;
                $invoice->end_date = $lastDayOfMonth;
                $invoice->status = 0;
                $invoice->save();
                if ($request->employee_id) {
                    foreach ($request->employee_id as $key => $value) {
                        if ($value) {
                            $invoiceDetail = new IslamiBankInvoiceDetails();
                            $invoiceDetail->islami_bank_invoice_id = $invoice->id;
                            $invoiceDetail->invoice_id = $data->id;
                            $invoiceDetail->atm_id = $request->atm_id;
                            $invoiceDetail->employee_id = $request->employee_id[$key];
                            $invoiceDetail->job_post_id = $request->job_post_id[$key];
                            // $invoiceDetail->area = $request->area[$key];
                            // $invoiceDetail->account_no = $request->account_no[$key];
                            // $invoiceDetail->duty_rate = $request->duty_rate[$key];
                            $invoiceDetail->duty = $request->duty[$key];
                            $invoiceDetail->start_date = $firstDayOfMonth;
                            $invoiceDetail->end_date = $lastDayOfMonth;
                            $invoiceDetail->salary_amount = $request->salary_amount[$key];
                            $invoiceDetail->status = 0;
                            $invoiceDetail->save();
                        }
                    }
                    $islamiBankInvoice = IslamiBankInvoiceDetails::where('islami_bank_invoice_id', $invoice->id)
                        ->select('job_post_id', 'atm_id', 'duty', 'salary_amount', 'start_date', 'end_date', DB::raw('SUM(salary_amount) as total_amounts'), DB::raw('COUNT(employee_id) as employee_count'))->groupBy('job_post_id')->get();

                    foreach ($islamiBankInvoice as $winvoice) {
                        $details = new InvoiceGenerateDetails();
                        $details->invoice_id = $data->id;
                        $details->job_post_id = $winvoice->job_post_id;
                        // $details->rate = $winvoice->duty_rate;
                        $details->total_amounts = $winvoice->salary_amount;
                        $details->employee_qty = $winvoice->employee_count;
                        $details->total_houres = ($winvoice->employee_count * $winvoice->duty * 8);
                        $details->warking_day = $winvoice->duty;
                        $details->st_date = $winvoice->start_date;
                        $details->ed_date = $winvoice->end_date;
                        $details->status = 0;
                        $details->save();
                    }
                }
                DB::commit();
                \App\Helpers\LogActivity::addToLog('IBBL invoice Create', $request->getContent(), 'InvoiceGenerate,InvoiceGenerateDetails');
                return redirect()->route('invoiceGenerate.index')->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                DB::rollBack();
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            dd($e);

            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('crm.islami_bank_invoice.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inv = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $invIslamiBank = IslamiBankInvoice::with('customer', 'branch', 'atm')->where('invoice_id', $inv->id)->first();
        $invIslamiBankDetail = IslamiBankInvoiceDetails::where('islami_bank_invoice_id', $invIslamiBank->id)->get();
        // dd($invIslamiBank);
        return view('islami_bank_assign.editInvoice', compact('inv', 'invIslamiBank', 'invIslamiBankDetail'));

        // return view('crm.islami_bank_invoice.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        // dd($request->employee_id);
        // dd($request->all(), encryptor('decrypt', $id));
        try {
            $firstDayOfMonth = $request->start_date;
            $lastDayOfMonth = $request->end_date;

            $data = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->atm_id = $request->atm_id;
            $data->start_date = $firstDayOfMonth;
            $data->end_date = $lastDayOfMonth;
            $data->bill_date = $request->bill_date;
            $data->vat = $request->vat_on_subtotal;
            $data->sub_total_amount = $request->sub_total_salary;
            $data->total_tk = $request->sub_total_salary;
            $data->vat_taka = $request->vat_tk_subtotal;
            $data->grand_total = $request->grand_total_tk;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->zone_id = $request->zone_id;
            $data->invoice_type = 6;
            $data->status = 0;
            $data->save();

            $invoice = IslamiBankInvoice::where('invoice_id', $data->id)->first();
            // dd($invoice);
            $invoice->invoice_id = $data->id;
            $invoice->customer_id = $request->customer_id;
            $invoice->company_branch_id = $request->branch_id;
            $invoice->atm_id = $request->atm_id;
            $invoice->sub_total_salary = $request->sub_total_salary;
            $invoice->add_commission = $request->add_commission_percentage;
            $invoice->add_commission_tk = $request->add_commission_tk;
            $invoice->vat_on_commission = $request->vat_commission_percentage;
            $invoice->vat_on_commission_tk = $request->vat_commission_percentage_tk;
            $invoice->ait_on_commission = $request->ait_commission_percentage;
            $invoice->ait_on_commission_tk = $request->ait_commission_percentage_tk;
            $invoice->vat_ait_on_commission = $request->vat_ait_commission_percentage;
            $invoice->vat_ait_on_commission_tk = $request->vat_ait_commission_tk;
            $invoice->vat_on_subtotal = $request->vat_on_subtotal;
            $invoice->vat_on_subtotal_tk = $request->vat_tk_subtotal;
            $invoice->ait_on_subtotal = $request->ait_on_subtotal;
            $invoice->ait_on_subtotal_tk = $request->ait_tk_subtotal;
            $invoice->grand_total_tk = $request->grand_total_tk;
            $invoice->footer_note = $request->footer_note;
            $invoice->bill_date = $request->bill_date;
            $invoice->start_date = $firstDayOfMonth;
            $invoice->end_date = $lastDayOfMonth;
            $invoice->status = 0;
            $invoice->save();

            if (!empty($request->employee_id)) {
                $invoiceDetail = IslamiBankInvoiceDetails::where('islami_bank_invoice_id', $invoice->id)->delete();
                // foreach ($invoiceDetail as $detail) {
                //     $detail->delete();
                // }
                // dd($invoiceDetail);

                foreach ($request->employee_id as $key => $value) {
                    if ($value) {
                        // add new data
                        $invoiceDetail = new IslamiBankInvoiceDetails();
                        $invoiceDetail->islami_bank_invoice_id = $invoice->id;
                        $invoiceDetail->invoice_id = $data->id;
                        $invoiceDetail->atm_id = $request->atm_id;
                        $invoiceDetail->employee_id = $value;
                        $invoiceDetail->job_post_id = $request->job_post_id[$key] ?? null;
                        $invoiceDetail->duty = $request->duty[$key] ?? 0;
                        $invoiceDetail->start_date = $firstDayOfMonth;
                        $invoiceDetail->end_date = $lastDayOfMonth;
                        $invoiceDetail->salary_amount = $request->salary_amount[$key] ?? 0;
                        $invoiceDetail->status = 0;
                        $invoiceDetail->save();
                    }
                }

                $islamiBankInvoice = IslamiBankInvoiceDetails::where('islami_bank_invoice_id', $invoice->id)
                    ->select(
                        'job_post_id',
                        'atm_id',
                        'duty',
                        'salary_amount',
                        'start_date',
                        'end_date',
                        DB::raw('SUM(salary_amount) as total_amounts'),
                        DB::raw('COUNT(employee_id) as employee_count')
                    )
                    ->groupBy('job_post_id')
                    ->get();

                foreach ($islamiBankInvoice as $winvoice) {
                    $details = new InvoiceGenerateDetails(); // You probably want to create new
                    $details->invoice_id = $data->id;
                    $details->job_post_id = $winvoice->job_post_id;
                    $details->total_amounts = $winvoice->total_amounts;
                    $details->employee_qty = $winvoice->employee_count;
                    $details->total_houres = ($winvoice->employee_count * $winvoice->duty * 8);
                    $details->warking_day = $winvoice->duty;
                    $details->st_date = $winvoice->start_date;
                    $details->ed_date = $winvoice->end_date;
                    $details->status = 0;
                    $details->save();
                }
            }

            \App\Helpers\LogActivity::addToLog('IBBL invoice Update', $request->getContent(), 'InvoiceGenerate,InvoiceGenerateDetails');
            DB::commit();
            return redirect()->route('invoiceGenerate.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->withInput()->with(Toastr::error('Error: ' . $e->getMessage(), 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = InvoiceGenerate::findOrFail(encryptor('decrypt', $id));
        $invoice->delete();
        return redirect()->back()->with(Toastr::success('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}