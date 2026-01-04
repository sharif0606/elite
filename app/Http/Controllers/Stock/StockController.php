<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\Stock;
use App\Models\Stock\Product;
use App\Models\Employee\Employee;
use App\Models\Customer;
use App\Models\Crm\CustomerBrance;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = Product::with('stock');
        if ($request->product) {
            $product = $product->where('id', $request->product);
        }
        $product = $product->get();
        return view('Stock.stock.list', compact('product'));
    }

    public function stockindividual(Request $request, $id)
    {
        //$company = company()['company_id'];
        $productId = encryptor('decrypt', $id);
        
        // Get stock for display (filtered by date if provided)
        $stock = Stock::where('product_id', $productId);
        if ($request->fdate) {
            $tdate = $request->tdate ? $request->tdate : $request->fdate;
            $stock = $stock->whereBetween('entry_date', [$request->fdate, $tdate]);
        }
        $stock = $stock->orderBy('entry_date')->orderBy('created_at')->get();
        
        // Calculate total available stock up to end date (or all time if no filter)
        // This is for showing the cumulative total in the "Total STOCK" column
        $allStockForTotal = Stock::where('product_id', $productId);
        if ($request->fdate && $request->tdate) {
            // If date filter is applied, calculate total up to the end date
            $allStockForTotal = $allStockForTotal->where('entry_date', '<=', $request->tdate);
        }
        $allStockForTotal = $allStockForTotal->orderBy('entry_date')->orderBy('created_at')->get();
        
        // Calculate cumulative totals for each transaction
        $cumulativeTotals = [];
        $runningTotal = 0;
        foreach ($allStockForTotal as $s) {
            $runningTotal += $s->product_qty;
            $cumulativeTotals[$s->id] = $runningTotal;
        }
        
        $product = Product::where('id', $productId)->first();

        return view('Stock.stock.stockReportIndividual', compact('stock', 'product', 'cumulativeTotals', 'allStockForTotal'));
    }

    public function EmployeeList(Request $request)
    {
        $stock = Stock::select('id', 'employee_id', 'product_qty', 'entry_date', 'company_id', 'company_branch_id');

        // Check and apply filters based on request parameters
        if (!empty($request->employee_id)) {
            // If employee_id is provided, apply it and ignore other filters
            $stock = $stock->where('employee_id', $request->employee_id)->groupBy('employee_id');
        } elseif (!empty($request->company_id)) {
            // If company_id is provided, apply it and ignore employee_id
            $stock = $stock->where('company_id', $request->company_id)->groupBy('company_id');
        } elseif (!empty($request->company_branch_id)) {
            // If company_branch_id is provided, apply it and ignore employee_id
            $stock = $stock->where('company_branch_id', $request->company_branch_id)->groupBy('company_branch_id');
        } else {
            $stock = $stock->whereNotNull('employee_id');
        }
        DB::enableQueryLog(); // Enable query logging
        // Finalize the stock query
        $stock = $stock->paginate(50);
        // Get the executed queries from the log
        //$queries = DB::getQueryLog();
        // Optionally, log the queries to a file or display them
        //\Log::info('Executed Queries: ', $queries);
        // You can also dd() to display the queries for immediate debugging
        //dd($queries);

        // Fetch other necessary data
        $employee = Employee::select('id', 'admission_id_no', 'bn_applicants_name')->get();
        $customer = Customer::all();
        $branch = CustomerBrance::get();

        // Return the view with data
        return view('Stock.employeeReport.employee_list', compact('stock', 'employee', 'customer', 'branch'));
    }

    public function employeeIndividual(Request $request, $id)
    {
        // Decrypt the provided ID
        $decryptedId = encryptor('decrypt', $id);

        // Check if the ID belongs to an employee or customer
        if ($request->type == 1)
            $isEmployee = Stock::where('employee_id', $decryptedId)->exists();
        if ($request->type == 2) {
            $isEmployee = Stock::where('company_id', $decryptedId)->exists();
        }
        if ($isEmployee && $request->type == 1) {
            // Query for employee
            $productList = Stock::where('employee_id', $decryptedId)
                ->orderBy('product_id')
                ->get();

            $stock = json_decode(json_encode(DB::select("
        SELECT COUNT(*) AS c, product_id, SUM(product_qty) AS total_qty 
        FROM stocks 
        WHERE employee_id = '$decryptedId' 
        GROUP BY product_id
    ")), true);
            $deposits = [];
        } else {
            // Query for customer
            $productList = Stock::where('stocks.company_id', $decryptedId)
                ->orderBy('stocks.product_id')
                ->get();

            $stock = json_decode(json_encode(DB::select("
        SELECT COUNT(*) AS c, product_id, SUM(product_qty) AS total_qty 
        FROM stocks 
        WHERE company_id = '$decryptedId' 
        GROUP BY product_id
    ")), true);

            $deposits = DB::table('product_requisition_details')
                ->join('product_requisitions', 'product_requisitions.id', '=', 'product_requisition_details.product_requisition_id')
                ->where('product_requisitions.company_id', $decryptedId)
                ->where('product_requisition_details.deposite_product_qty', '>', 0)
                ->select('product_requisition_details.product_id', DB::raw('SUM(deposite_product_qty) as total_out_qty'))
                ->groupBy('product_requisition_details.product_id')
                ->get()
                ->keyBy('product_id');
        }

        //print_r($stock);die();
        // if ($request->fdate) {
        //     $tdate = $request->tdate ? $request->tdate : $request->fdate;
        //     $stock =$stock->whereBetween('entry_date',[$request->fdate, $tdate]);
        // }
        // $stock = $stock->groupBy('product_id')->get();
        $employee = Employee::where('id', (encryptor('decrypt', $id)))->first();

        return view('Stock.employeeReport.employeeReportIndividual', compact('productList', 'employee', 'stock', 'deposits'));
    }
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
