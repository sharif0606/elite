<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Settings\Zone;
use Illuminate\Http\Request;
use App\Models\Crm\InvoicePayment;
use App\Models\Customer;
use App\Models\Hrm\SalarySheet;
use App\Models\Hrm\SalarySheetDetail;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function invoicePayment()
    {
        $zones=Zone::with('customer')->orderBy('name','ASC')->paginate(2);
        return view('report.invoice-payment',compact('zones'));
    }

    public function invoiceDue(Request $request)
    {
        $customer=Customer::all();
        $invoice=InvoiceGenerate::with('payment','customer','branch')->orderBy('id','DESC');

        if ($request->fdate && $request->tdate){
            $startDate = $request->fdate;
            $endDate = $request->tdate;

            $invoice->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('invoice_generates.start_date', '>=',$startDate )
                        ->whereDate('invoice_generates.end_date', '<=', $endDate);
                });
            });
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $invoice->where('invoice_generates.customer_id', $customerId);
        }
        if ($request->bill_date){
            $billDate = $request->bill_date;
            $invoice->where('invoice_generates.bill_date', $billDate);
        }
        $invoice = $invoice->get();
        return view('report.invoice-due',compact('invoice','customer'));
    }
    public function paymentReceive(Request $request){
        $customer=Customer::all();
        $zone=Zone::all();
        $data = InvoicePayment::select('invoice_payments.*', 'customers.id as customer_id', 'customers.zone_id as zone_id','customers.customer_type as customer_type','invoice_generates.branch_id as branch_id')
        ->leftJoin('customers','invoice_payments.customer_id','=','customers.id')
        ->leftJoin('invoice_generates','invoice_payments.invoice_id','=','invoice_generates.id')
        ->join(
            DB::raw('(SELECT MAX(id) as id FROM invoice_payments GROUP BY invoice_id) as latest'),
            'invoice_payments.id',
            '=',
            'latest.id'
        );
        if ($request->customer_type){
            $data->where('customers.customer_type', $request->customer_type);
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $data->where('invoice_payments.customer_id', $customerId);
        }
        if ($request->branch_id){
            $branchId = $request->branch_id;
            $data->where('invoice_generates.branch_id', $branchId);
        }
        if ($request->zone_id){
            $zoneId = $request->zone_id;
            $data->where('customers.zone_id', $zoneId);
        }
        $data = $data->get();
        return view('report.pay-received',compact('data','customer','zone'));
    }
    public function paymentReceiveDetails(Request $request, $id){
        $customer=Customer::where('id',$id)->first();
        $data = InvoicePayment::where('customer_id',$id);

        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $data->whereBetween(DB::raw('date(invoice_payments.pay_date)'), [$request->fdate, $tdate]);
        }
        if ($request->po_date){
            $data->where('invoice_payments.po_date', $request->po_date);
        }
        if ($request->po_no){
            $data->where('invoice_payments.po_no', $request->po_no);
        }

        if ($request->payment_type){
            $data->where('invoice_payments.payment_type', $request->payment_type);
        }
        $data = $data->get();
        return view('report.pay-received-detail',compact('data','customer'));
    }
    public function salaryReport(){
        return view('report.salary-report');
    }
    public function salaryReportDetil(Request $request){
        $salaryIds= SalarySheet::where('year',$request->year)->where('month',$request->month)->pluck('id');
        $getYear = $request->year;
        $getMonth = $request->month;
        $data= SalarySheetDetail::select('id','salary_id','employee_id','designation_id','customer_id','branch_id','common_net_salary')
        ->whereIn('salary_id',$salaryIds)
        ->get();
        if($request->type==0){
            return view('report.salary-details',compact('getYear','getMonth','data'));
        }else{
            return view('report.salary-details-dbbl',compact('getYear','getMonth','data'));

        }
    }
}