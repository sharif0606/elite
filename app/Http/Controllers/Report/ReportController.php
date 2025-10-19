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



        // Construct the start and end date for the range based on the selected "From" and "To" month
        $startDate = Carbon::create($selected_fy, $selected_fmonth, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($selected_ty, $selected_tmonth, 1)->endOfMonth()->format('Y-m-d');

        // Create a period from the selected "From" to "To" year and month
        $period = \Carbon\CarbonPeriod::create(
            $startDate,
            "1 month",
            $endDate
        );
        /*$zones = Zone::with([
            'customer' => function ($query) use ($startDate, $endDate, $request) {
                // Only apply the filter for 'received_by_city' if it is provided and not equal to 3
                if ($request->has('received_by_city') && $request->received_by_city == 1 || $request->received_by_city == 2) {
                    $query->where('received_by_city', $request->received_by_city);
                }
                // Eager load the branches for each customer and filter branches by zone_id if provided
                $query->with(['branch' => function ($branchQuery) use ($request) {
                    // Filter branches by zone_id if provided in the request
                    if ($request->has('zone_id')) {
                        $branchQuery->where('zone_id', $request->zone_id);
                    }
                }]);
                // Apply filter for invoiceGenerates based on start and end date
                $query->whereHas('invoiceGenerates', function ($invoiceQuery) use ($startDate, $endDate) {
                    // Filter invoiceGenerates based on start and end date
                    $invoiceQuery->whereBetween('start_date', [$startDate, $endDate])
                        ->whereBetween('end_date', [$startDate, $endDate])
                        ->with(['invoiceGenerateDetails', 'invPayment']); // Eager load details and payments
                });
            }
        ])->orderBy('zones.name', 'ASC')->paginate(10);*/
        $zones = Customer::query()
            ->leftJoin('customer_brances as cb', 'customers.id', '=', 'cb.customer_id')
            ->leftJoin('zones as z', function ($join) {
                $join->on('z.id', '=', DB::raw('COALESCE(customers.zone_id, cb.zone_id)'));
            })
            ->whereNotNull(DB::raw('COALESCE(customers.zone_id, cb.zone_id)'))
            ->whereHas('invoiceGenerates', function ($invoiceQuery) use ($startDate, $endDate) {
                $invoiceQuery->whereBetween('start_date', [$startDate, $endDate])
                    ->whereBetween('end_date', [$startDate, $endDate])
                    ->with(['invoiceGenerateDetails', 'invPayment']); // Eager load details and payments
            })
            ->select([
                DB::raw('COALESCE(customers.zone_id, cb.zone_id) as zone_id'),
                'z.name',
                'z.name_bn',
                'customers.id as customer_id',
                'customers.received_by_city',
                'customers.name as customer_name',
                'cb.id as customer_branch_id',
                'cb.brance_name',
            ])
            ->orderBy('zone_id')
            ->get()
            ->groupBy('zone_id'); // Group by zone_id

        $formattedZones = $zones->map(function ($zoneGroup) {
            $zone = $zoneGroup->first(); // Get the first customer for this zone (to get the zone data)
            return [
                'zone_id' => $zone->zone_id, // Zone ID
                'zone_name' => $zone->name, // Zone name
                'zone_name_bn' => $zone->name_bn, // Zone name in Bengali
                'customers' => $zoneGroup->map(function ($customer) use ($zone) {
                    // Check if the zone_id being used is from the customer or the branch
                    $isBranchZone = is_null($customer->zone_id); // If zone_id is NULL, use the branch's zone_id

                    // Now separate based on whether it's a customer zone or branch zone
                    if ($isBranchZone) {
                        // If zone_id is NULL, use branch_name
                        return [
                            'customer_id' => $customer->customer_id,
                            'customer_name' => $customer->brance_name, // Display branch name
                            'received_by_city' => $customer->received_by_city,
                            'customer_branch_id' => $customer->customer_branch_id,
                            'brance_name' => $customer->brance_name,
                            'is_branch' => true, // Mark as branch (no zone)
                        ];
                    } else {
                        // If zone_id is not NULL, use customer_name
                        return [
                            'customer_id' => $customer->customer_id,
                            'customer_name' => $customer->customer_name, // Display customer name
                            'received_by_city' => $customer->received_by_city,
                            'customer_branch_id' => $customer->customer_branch_id,
                            'brance_name' => $customer->brance_name,
                            'is_branch' => false, // Mark as customer (with zone)
                        ];
                    }
                })
            ];
        });

        // Optional: You can paginate or limit the results as needed
        $paginatedZones = new \Illuminate\Pagination\LengthAwarePaginator(
            $formattedZones->forPage(request()->get('page', 1), 10), // Handle pagination
            $formattedZones->count(),
            10,
            request()->get('page', 1)
        );
        $zones = Zone::with(['customers', 'branch.customer'])->get();
        return view('report.invoice-payment', compact('zones', 'period', 'paginatedZones'));
    }
    public function invoicePaymentPrint(Request $request)
    {
        // Get filter values from the request or set defaults
        $selected_fy = $request->input('fyear', \Carbon\Carbon::now()->subMonth(6)->format('Y')); // From Year
        $selected_fmonth = $request->input('fmonth', \Carbon\Carbon::now()->subMonth(6)->format('m')); // From Month
        $selected_ty = $request->input('tyear', \Carbon\Carbon::now()->format('Y')); // To Year
        $selected_tmonth = $request->input('tmonth', \Carbon\Carbon::now()->format('m')); // To Month



        // Construct the start and end date for the range based on the selected "From" and "To" month
        $startDate = Carbon::create($selected_fy, $selected_fmonth, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($selected_ty, $selected_tmonth, 1)->endOfMonth()->format('Y-m-d');

        // Create a period from the selected "From" to "To" year and month
        $period = \Carbon\CarbonPeriod::create(
            $startDate,
            "1 month",
            $endDate
        );
        $zones = Customer::query()
            ->leftJoin('customer_brances as cb', 'customers.id', '=', 'cb.customer_id')
            ->leftJoin('zones as z', function ($join) {
                $join->on('z.id', '=', DB::raw('COALESCE(customers.zone_id, cb.zone_id)'));
            })
            ->whereNotNull(DB::raw('COALESCE(customers.zone_id, cb.zone_id)'))
            ->whereHas('invoiceGenerates', function ($invoiceQuery) use ($startDate, $endDate) {
                $invoiceQuery->whereBetween('start_date', [$startDate, $endDate])
                    ->whereBetween('end_date', [$startDate, $endDate])
                    ->with(['invoiceGenerateDetails', 'invPayment']); // Eager load details and payments
            })
            ->select([
                DB::raw('COALESCE(customers.zone_id, cb.zone_id) as zone_id'),
                'z.name',
                'z.name_bn',
                'customers.id as customer_id',
                'customers.received_by_city',
                'customers.name as customer_name',
                'cb.id as customer_branch_id',
                'cb.brance_name',
            ])
            ->orderBy('zone_id')
            ->get()
            ->groupBy('zone_id'); // Group by zone_id

        $formattedZones = $zones->map(function ($zoneGroup) {
            $zone = $zoneGroup->first(); // Get the first customer for this zone (to get the zone data)
            return [
                'zone_id' => $zone->zone_id, // Zone ID
                'zone_name' => $zone->name, // Zone name
                'zone_name_bn' => $zone->name_bn, // Zone name in Bengali
                'customers' => $zoneGroup->map(function ($customer) use ($zone) {
                    // Check if the zone_id being used is from the customer or the branch
                    $isBranchZone = is_null($customer->zone_id); // If zone_id is NULL, use the branch's zone_id

                    // Now separate based on whether it's a customer zone or branch zone
                    if ($isBranchZone) {
                        // If zone_id is NULL, use branch_name
                        return [
                            'customer_id' => $customer->customer_id,
                            'customer_name' => $customer->brance_name, // Display branch name
                            'received_by_city' => $customer->received_by_city,
                            'customer_branch_id' => $customer->customer_branch_id,
                            'brance_name' => $customer->brance_name,
                            'is_branch' => true, // Mark as branch (no zone)
                        ];
                    } else {
                        // If zone_id is not NULL, use customer_name
                        return [
                            'customer_id' => $customer->customer_id,
                            'customer_name' => $customer->customer_name, // Display customer name
                            'received_by_city' => $customer->received_by_city,
                            'customer_branch_id' => $customer->customer_branch_id,
                            'brance_name' => $customer->brance_name,
                            'is_branch' => false, // Mark as customer (with zone)
                        ];
                    }
                })
            ];
        });

        // Optional: You can paginate or limit the results as needed
        $paginatedZones = new \Illuminate\Pagination\LengthAwarePaginator(
            $formattedZones->forPage(request()->get('page', 1), 10), // Handle pagination
            $formattedZones->count(),
            10,
            request()->get('page', 1)
        );
        $zones = Zone::with(['customers', 'branch.customer'])->get();
        return view('report.invoice-payment-print', compact('zones', 'period', 'paginatedZones'));
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
        //dd($request->all());
        if ($request->type == 0) {
            $salaryIds = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('status', 4)->pluck('id');
        } else {
            if ($request->type != 15) {
                $emp = Employee::where('status', 1)->where('salary_prepared_type', $request->type)->pluck('id');
            } elseif ($request->type == 15) {
                $emp = Employee::where('status', 1)->where('salary_prepared_type', $request->type)->pluck('id');
            } else {
                // stop salary employee id
                $emp = Deduction::where('year', $request->year)->where('month', $request->month)->where('status', 20)->pluck('employee_id');
            }
            $salaryIds = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('customer_id', $request->customer_id)->pluck('id');
        }
        $salaryStopEmployees = Deduction::where('year', $request->year)->where('month', $request->month)->where('status', 20)->pluck('employee_id');
        // dd($salaryStopEmployees);
        $getYear = $request->year;
        $getMonth = $request->month;
        $salaryType = $request->type;

        // $request->type == 15 stop salary list
        if ($request->type != 15) {
            /*$data = SalarySheetDetail::select('id', 'salary_id', 'employee_id', 'designation_id', 'customer_id', 'remark', 'duty_qty', DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
                ->whereIn('salary_id', $salaryIds)->whereNotIn('employee_id', $salaryStopEmployees)->groupBy('employee_id');*/
            $data = SalarySheetDetail::select('salary_sheet_details.*', 'job_posts.serial')
                ->join('job_posts', 'salary_sheet_details.designation_id', '=', 'job_posts.id')
                ->whereIn('salary_id', $salaryIds)->whereNotIn('employee_id', $salaryStopEmployees)
                ->orderBy('job_posts.serial', 'ASC')->groupBy('employee_id');
        } else {
            $data = SalarySheetDetail::select('id', 'salary_id', 'employee_id', 'designation_id', 'customer_id', 'remark', 'duty_qty', DB::raw('CASE WHEN duty_qty > 0 THEN branch_id ELSE NULL END as branch_id'), DB::raw('SUM(common_net_salary) as common_net_salary'))
                ->whereIn('salary_id', $salaryIds)->groupBy('employee_id');
        }
        //dd($data->where('employee_id',4295)->get());
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
        //$data = $data->orderBy('salary_sheet_details.branch_id', 'asc')->get();
        $data = $data->get();
        if (!$data->isEmpty()) {
            if ($request->type == 0) {
                return view('report.salary-office-staff', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else if (in_array($request->type, [15, 16])) {
                return view('report.salary-office-staff-prime', compact('getYear', 'getMonth', 'data', 'salaryType'));
            } else if (in_array($request->type, [1, 3, 4, 17, 18])) {
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
        if ($request->vat) {
            $payments = $payments->where('vat','>',0);
        }
        if ($request->ait_deducted) {
            $payments = $payments->where('ait','>',0);
        }

        $payments = $payments
            ->orderByRaw("YEAR(deposit_date) DESC, MONTH(deposit_date) DESC")
            ->paginate(15);

        $customer = Customer::all();
        return view('report.client-wise-invoice-report-detail', compact('payments', 'customer'));
    }

    public function employee_wise_training(Request $request)
    {
        // Fetch employees who have a valid training cost
        $employees = Employee::select('id', 'bn_applicants_name', 'admission_id_no')
            ->whereNotNull('bn_traning_cost')  // Exclude employees without training cost
            ->where('bn_traning_cost', '>', 0) // Exclude employees with zero training cost
            ->get();

        // Fetch months from SalarySheetDetail
        $months = SalarySheetDetail::selectRaw("DISTINCT CONCAT(year, '-', LPAD(month, 2, '0'), '-01') as month_date")
            ->whereRaw("year > 0 AND month > 0 AND month <= 12")  // Ensure valid year and month
            ->orderBy('month_date')
            ->pluck('month_date')
            ->toArray();

        // Initialize the training cost report array
        $training_cost_report = [];

        // Filtering based on request parameters
        if ($request->employee_id) {
            // If employee is selected, filter by employee
            $training_data = SalarySheetDetail::where('employee_id', $request->employee_id);
        } else {
            // If no specific employee is selected, include all employees
            $training_data = SalarySheetDetail::query();
        }

        // Add year filter if provided
        if ($request->year) {
            $training_data->where('year', $request->year);
        }

        // Add month filter if provided
        if ($request->month) {
            $training_data->where('month', $request->month);
        }

        // Group by employee and process data
        $training_data = $training_data->selectRaw('employee_id, year, month, SUM(deduction_traningcost) as total_deduction')
            ->groupBy('employee_id', 'year', 'month')
            ->with('employee:id,bn_applicants_name,admission_id_no,joining_date,bn_traning_cost,bn_remaining_cost')
            ->orderBy('year')
            ->orderBy('month')
            ->where('year', '>', 0)
            ->where('month', '>', 0)
            ->get();

        // Process each employee's data
        foreach ($training_data->groupBy('employee_id') as $employee_id => $reports) {
            $employee = $reports->first()->employee ?? null;

            if ($employee && $employee->bn_traning_cost > 0) {  // Ensure training cost is greater than 0
                $total_deduction = $reports->sum('total_deduction');
                $remaining_cost = $employee->bn_remaining_cost ?? 0;
                $due_amount = $remaining_cost - $total_deduction;
                $used_months = $reports->unique('month')->count(); // Count unique months

                // Only include employee in the report if the total deduction is greater than 0
                if ($total_deduction > 0) {
                    $training_cost_report[$employee_id] = [
                        'employee' => $employee,
                        'deductions' => $reports,
                        'total_deduction' => $total_deduction,
                        'due_amount' => $due_amount,
                        'used_months' => $used_months,
                    ];
                }
            }
        }

        return view('report.employee-wise-training', compact('employees', 'training_cost_report', 'months'));
    }
}
