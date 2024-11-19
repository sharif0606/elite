<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\InvoiceGenerate;
use App\Models\Settings\Zone;
use Illuminate\Http\Request;
use App\Models\Crm\InvoicePayment;
use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\Hrm\SalarySheet;
use App\Models\Hrm\SalarySheetDetail;
use App\Models\JobPost;
use App\Models\payroll\Deduction;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

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
        $invoice = $invoice->paginate(50);
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
        $branch = CustomerBrance::where('customer_id',$id)->get();
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

        if ($request->branch_id){
            $branchId = $request->branch_id;
            $data->where('invoice_payments.branch_id', $branchId);
        }

        if ($request->payment_type){
            $data->where('invoice_payments.payment_type', $request->payment_type);
        }
        $data = $data->get();
        return view('report.pay-received-detail',compact('data','customer','branch'));
    }
    public function salaryReport(){
        $customer=Customer::all();
        $jobposts=JobPost::all();
        return view('report.salary-report',compact('customer','jobposts'));
    }
    public function salaryReportDetil(Request $request){
        if($request->type == 0 ){
            $salaryIds= SalarySheet::where('year',$request->year)->where('month',$request->month)->where('status',4)->pluck('id');
        }else{
            if($request->type != 15){
                $emp = Employee::where('status',1)->where('salary_prepared_type',$request->type)->pluck('id');
            }else{
                // stop salary employee id
                $emp = Deduction::where('year',$request->year)->where('month',$request->month)->where('status',20)->pluck('employee_id');
            }
            $salaryIds= SalarySheet::where('year',$request->year)->where('month',$request->month)->pluck('id');
        }
        $salaryStopEmployees = Deduction::where('year',$request->year)->where('month',$request->month)->where('status',20)->pluck('employee_id');
        // dd($salaryStopEmployees);
        $getYear = $request->year;
        $getMonth = $request->month;
        $salaryType = $request->type;

        // $request->type == 15 stop salary list
        if($request->type != 15 ){
            $data= SalarySheetDetail::select('id','salary_id','employee_id','designation_id','customer_id','remark','duty_qty',DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
            ->whereIn('salary_id',$salaryIds)->whereNotIn('employee_id',$salaryStopEmployees)->groupBy('employee_id');
        }else{
            $data= SalarySheetDetail::select('id','salary_id','employee_id','designation_id','customer_id','remark','duty_qty',DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
            ->whereIn('salary_id',$salaryIds)->groupBy('employee_id');
        }

        if ($request->type != 0){
            $data->whereIn('employee_id', $emp);
        }
        if ($request->customer_id){
            $customerId = $request->customer_id;
            $data->where('customer_id', $customerId);
        }
        if ($request->customer_branch_id){
            $branchId = $request->customer_branch_id;
            $data->where('branch_id', $branchId);
        }
        if ($request->job_post_id){
            $post = $request->job_post_id;
            $data->where('designation_id', $post);
        }
        $data = $data->get();

        if(!$data->isEmpty()){
            if($request->type== 0){
                return view('report.salary-office-staff',compact('getYear','getMonth','data','salaryType'));
            }else if(in_array($request->type, [13,14])){
                return view('report.salary-office-staff-prime',compact('getYear','getMonth','data','salaryType'));
            }else if(in_array($request->type, [1,3,4,15])){
                return view('report.salary-details',compact('getYear','getMonth','data','salaryType'));
            }else if(in_array($request->type, [2,5,6,7,8,9,10,11,12])){
                return view('report.salary-details-dbbl',compact('getYear','getMonth','data','salaryType'));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }else{
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'No Data Found', ["positionClass" => "toast-top-right"]));
        }
    }
}