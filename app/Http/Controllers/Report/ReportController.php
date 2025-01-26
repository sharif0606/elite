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
use App\Models\Crm\CustomerDuty;
use App\Models\Crm\CustomerDutyDetail;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function invoicePayment(Request $request)
    {
        // Get filter values from the request or set defaults
        $selected_fy = $request->input('fyear', \Carbon\Carbon::now()->subMonth(6)->format('Y')); // From Year
        $selected_fmonth = $request->input('fmonth', \Carbon\Carbon::now()->subMonth(6)->format('m')); // From Month
        $selected_ty = $request->input('tyear', \Carbon\Carbon::now()->format('Y')); // To Year
        $selected_tmonth = $request->input('tmonth', \Carbon\Carbon::now()->format('m')); // To Month

        // Create a period from the selected "From" to "To" year and month
        $period = \Carbon\CarbonPeriod::create(
            "$selected_fy-$selected_fmonth-01",
            "1 month",
            "$selected_ty-$selected_tmonth-31"
        );

        // Construct the start and end date for the range based on the selected "From" and "To" month
        $startDate = Carbon::create($selected_fy, $selected_fmonth, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($selected_ty, $selected_tmonth, 1)->endOfMonth()->format('Y-m-d');

        $zones = Zone::with(['customer' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('invoiceGenerates', function ($invoiceQuery) use ($startDate, $endDate) {
                // Filter invoiceGenerates based on start and end date
                $invoiceQuery->whereBetween('start_date', [$startDate, $endDate])
                    ->whereBetween('end_date', [$startDate, $endDate])
                    ->with(['invoiceGenerateDetails', 'invPayment']); // Eager load details and payments
            });
        }])->orderBy('zones.name', 'ASC')->paginate(10);

        return view('report.invoice-payment', compact('zones', 'period'));
    }



    public function invoiceDue(Request $request)
    {
        $customer = Customer::all();
        $invoice = InvoiceGenerate::with('payment', 'customer', 'branch')->orderBy('id', 'DESC');

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
        if ($request->bill_date) {
            $billDate = $request->bill_date;
            $invoice->where('invoice_generates.bill_date', $billDate);
        }
        $invoice = $invoice->paginate(50);
        return view('report.invoice-due', compact('invoice', 'customer'));
    }
    public function paymentReceive(Request $request)
    {
        $customer = Customer::all();
        $zone = Zone::all();
        $data = InvoicePayment::select('invoice_payments.*', 'customers.id as customer_id', 'customers.zone_id as zone_id', 'customers.customer_type as customer_type', 'invoice_generates.branch_id as branch_id')
            ->leftJoin('customers', 'invoice_payments.customer_id', '=', 'customers.id')
            ->leftJoin('invoice_generates', 'invoice_payments.invoice_id', '=', 'invoice_generates.id')
            ->join(
                DB::raw('(SELECT MAX(id) as id FROM invoice_payments GROUP BY invoice_id) as latest'),
                'invoice_payments.id',
                '=',
                'latest.id'
            );
        if ($request->customer_type) {
            $data->where('customers.customer_type', $request->customer_type);
        }
        if ($request->customer_id) {
            $customerId = $request->customer_id;
            $data->where('invoice_payments.customer_id', $customerId);
        }
        if ($request->branch_id) {
            $branchId = $request->branch_id;
            $data->where('invoice_generates.branch_id', $branchId);
        }
        if ($request->zone_id) {
            $zoneId = $request->zone_id;
            $data->where('customers.zone_id', $zoneId);
        }
        $data = $data->paginate(20);
        return view('report.pay-received', compact('data', 'customer', 'zone'));
    }
    public function paymentReceiveDetails(Request $request, $id)
    {
        $customer = Customer::where('id', $id)->first();
        $branch = CustomerBrance::where('customer_id', $id)->get();
        $data = InvoicePayment::where('customer_id', $id);

        if ($request->fdate) {
            $tdate = $request->tdate ?: $request->fdate;
            $data->whereBetween(DB::raw('date(invoice_payments.pay_date)'), [$request->fdate, $tdate]);
        }
        if ($request->po_date) {
            $data->where('invoice_payments.po_date', $request->po_date);
        }
        if ($request->po_no) {
            $data->where('invoice_payments.po_no', $request->po_no);
        }

        if ($request->branch_id) {
            $branchId = $request->branch_id;
            $data->where('invoice_payments.branch_id', $branchId);
        }

        if ($request->payment_type) {
            $data->where('invoice_payments.payment_type', $request->payment_type);
        }
        $data = $data->get();
        return view('report.pay-received-detail', compact('data', 'customer', 'branch'));
    }
    public function salaryReport()
    {
        $customer = Customer::all();
        $jobposts = JobPost::all();
        return view('report.salary-report', compact('customer', 'jobposts'));
    }
    public function salaryReportDetil(Request $request)
    {
        if ($request->type == 0) {
            $salaryIds = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('status', 4)->pluck('id');
        } else {
            if ($request->type != 15) {
                $emp = Employee::where('status', 1)->where('salary_prepared_type', $request->type)->pluck('id');
            } else {
                // stop salary employee id
                $emp = Deduction::where('year', $request->year)->where('month', $request->month)->where('status', 20)->pluck('employee_id');
            }
            $salaryIds = SalarySheet::where('year', $request->year)->where('month', $request->month)->pluck('id');
        }
        $salaryStopEmployees = Deduction::where('year', $request->year)->where('month', $request->month)->where('status', 20)->pluck('employee_id');
        // dd($salaryStopEmployees);
        $getYear = $request->year;
        $getMonth = $request->month;
        $salaryType = $request->type;

        // $request->type == 15 stop salary list
        if ($request->type != 15) {
            $data = SalarySheetDetail::select('id', 'salary_id', 'employee_id', 'designation_id', 'customer_id', 'remark', 'duty_qty', DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
                ->whereIn('salary_id', $salaryIds)->whereNotIn('employee_id', $salaryStopEmployees)->groupBy('employee_id');
        } else {
            $data = SalarySheetDetail::select('id', 'salary_id', 'employee_id', 'designation_id', 'customer_id', 'remark', 'duty_qty', DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
                ->whereIn('salary_id', $salaryIds)->groupBy('employee_id');
        }

        if ($request->type != 0) {
            $data->whereIn('employee_id', $emp);
        }
        if ($request->customer_id) {
            $customerId = $request->customer_id;
            $data->where('customer_id', $customerId);
        }
        if ($request->customer_branch_id) {
            $branchId = $request->customer_branch_id;
            $data->where('branch_id', $branchId);
        }
        if ($request->job_post_id) {
            $post = $request->job_post_id;
            $data->where('designation_id', $post);
        }
        $data = $data->orderBy('salary_sheet_details.id', 'asc')->get();

        if (!$data->isEmpty()) {
            if ($request->type == 0) {
                return view('report.salary-office-staff', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else if (in_array($request->type, [15, 16])) {
                return view('report.salary-office-staff-prime', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else if (in_array($request->type, [1, 3, 4, 17])) {
                return view('report.salary-details', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else if (in_array($request->type, [2, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])) {
                return view('report.salary-details-dbbl', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } else {
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'No Data Found', ["positionClass" => "toast-top-right"]));
        }
    }
    public function customer_duty_filter(Request $request)
    {
        // Get the first date of the month
        $start_date = Carbon::create($request->year, $request->month, 1)->startOfDay(); // 2024-05-01 00:00:00

        // Get the last date of the month
        $end_date = Carbon::create($request->year, $request->month, 1)->endOfMonth()->endOfDay(); // 2024-05-31 23:59:59


        $employeeIds = DB::table('customer_duties')
            ->join('customer_duty_details', 'customer_duty_details.customerduty_id', '=', 'customer_duties.id')
            ->select('customer_duty_details.employee_id')
            ->whereDate('customer_duties.start_date', '>=', $start_date)
            ->whereDate('customer_duties.end_date', '<=', $end_date)
            ->where(function ($query) {
                $query->where('customer_duty_details.duty_qty', '>', 0)
                    ->orWhere('customer_duty_details.ot_qty', '>', 0);
            })
            ->groupBy('customer_duty_details.employee_id');
        if ($request->duty_qty) {
            if ($request->duty_qty == 60) {
                //$customerduty = $customerduty->havingRaw('SUM(customer_duty_details.duty_qty + customer_duty_details.ot_qty) > ?', [$request->duty_qty]);
                $employeeIds = $employeeIds->havingRaw('SUM(customer_duty_details.duty_qty + customer_duty_details.ot_qty) > ?', [60]);
            } elseif ($request->duty_qty == 20) {
                //$customerduty = $customerduty->havingRaw('SUM(customer_duty_details.duty_qty + customer_duty_details.ot_qty) < ?', [$request->duty_qty]);
                $employeeIds = $employeeIds->havingRaw('SUM(customer_duty_details.duty_qty + customer_duty_details.ot_qty) <= ?', [20]);
            }
            //$customerduty = $customerduty->get();
            $employeeIds = $employeeIds->pluck('customer_duty_details.employee_id'); // Pluck employee IDs

            // Convert the collection to an array if needed
            $employeeIdsArray = $employeeIds->toArray();
            //dd($employeeIdsArray);
            $customerduty = CustomerDuty::join('customer_duty_details', 'customer_duty_details.customerduty_id', '=', 'customer_duties.id')
                ->join('employees', 'employees.id', '=', 'customer_duty_details.employee_id')
                ->join('job_posts', 'job_posts.id', '=', 'customer_duty_details.job_post_id')
                ->leftJoin('customers', 'customers.id', '=', 'customer_duty_details.customer_id')
                ->select(
                    'employees.id as employee_id',
                    'employees.admission_id_no',
                    'employees.bn_applicants_name', // Employee name
                    DB::raw('GROUP_CONCAT(DISTINCT job_posts.name SEPARATOR ", ") as job_posts'), // Concatenate job post names
                    DB::raw('GROUP_CONCAT(DISTINCT customers.name SEPARATOR ", ") as customers'), // Concatenate customer names
                    DB::raw('SUM(customer_duty_details.duty_qty) as total_duty_qty'), // Total Duty Quantity
                    DB::raw('SUM(customer_duty_details.ot_qty) as total_ot_qty'), // Total OT Quantity
                    DB::raw('SUM(customer_duty_details.duty_qty + customer_duty_details.ot_qty) as total_duty_ot_qty') // Total Duty + OT
                )
                ->whereDate('customer_duties.start_date', '>=', $start_date) // Start date condition
                ->whereDate('customer_duties.end_date', '<=', $end_date)     // End date condition
                ->whereIn('customer_duty_details.employee_id', $employeeIdsArray) // Filter by employee IDs
                ->groupBy('employees.id', 'employees.bn_applicants_name') // Group by employee only
                ->get();
        } else {
            $customerduty = [];
        }



        return view('customer_duty.customer-duty-filter', compact('customerduty'));
    }

    /*== Clien Wise I|nvoice Payment Report ==*/
    public function client_wise_detail_invoice_report(Request $request)
    {
        $payments = InvoicePayment::with('customer', 'invoice');
        $receivedByCity = $request->received_by_city;
        $customerId = $request->customer_id; // Get customer_id from the query string

        // If customer_id is in the query string, do not apply the received_by_city filter
        if ($customerId && $receivedByCity) {
            // Filter by received_by_city only if customer_id is not in the query string
            $payments = $payments->whereHas('customer', function ($query) use ($receivedByCity) {
                $query->where('received_by_city', $receivedByCity);
            });
        }

        // If customer_id is in the query string, filter payments by customer_id
        if ($customerId) {
            $payments = $payments->where('customer_id', $customerId);
        }

        // Filtering payments based on provided query parameters
        if ($request->branch_id) {
            $payments = $payments->where('branch_id', $request->branch_id);
        }
        if ($request->payment_type) {
            $payments = $payments->where('payment_type', $request->payment_type);
        }
        if ($request->po_no) {
            $payments = $payments->where('po_no', $request->po_no);
        }
        if ($request->po_date) {
            $payments = $payments->where('po_date', $request->po_date);
        }
        if ($request->pay_date) {
            $payments = $payments->where('pay_date', $request->pay_date);
        }
        if ($request->fdate && $request->tdate) {
            $startDate = $request->fdate;
            $endDate = $request->tdate;
            $payments->whereHas('invoice', function ($query) use ($startDate, $endDate) {
                $query->whereDate('bill_date', '>=', $startDate)
                    ->whereDate('bill_date', '<=', $endDate);
            });
        }

        $payments = $payments->where('customer_id', $customerId)
            ->orderByRaw("YEAR(deposit_date) DESC, MONTH(deposit_date) DESC")
            ->paginate(15);

        $customer = Customer::all();
        return view('report.client-wise-invoice-report-detail', compact('payments', 'customer'));
    }
}
