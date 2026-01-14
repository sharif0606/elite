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
        /**
         * GOAL:
         * - When showing employees (default / employee filter): each employee should appear ONLY ONCE.
         * - When showing companies (customer/branch filter): each company/branch should appear ONLY ONCE.
         *
         * Implementation:
         * - Use simple Eloquent queries with GROUP BY instead of complex raw SQL.
         */

        $perPage = 50;

        // Base query with relationships
        $stock = Stock::with(['employee', 'company', 'company_branch']);

        // EMPLOYEE MODE (default and when employee filter is used)
        if (!empty($request->employee_id) || (empty($request->company_id) && empty($request->company_branch_id))) {
            if (!empty($request->employee_id)) {
                $stock = $stock->where('employee_id', $request->employee_id);
            }

            $stock = $stock->whereNotNull('employee_id')
                ->select(DB::raw('MIN(id) as id'), 'employee_id')
                ->groupBy('employee_id')
                ->orderBy('id');

        // COMPANY MODE (when customer or branch filter is used)
        } else {
            if (!empty($request->company_id)) {
                $stock = $stock->where('company_id', $request->company_id);
            }
            if (!empty($request->company_branch_id)) {
                $stock = $stock->where('company_branch_id', $request->company_branch_id);
            }

            $stock = $stock->whereNull('employee_id')
                ->select(DB::raw('MIN(id) as id'), 'company_id', 'company_branch_id')
                ->groupBy('company_id', 'company_branch_id')
                ->orderBy('id');
        }

        // Paginate the grouped result
        $stock = $stock->paginate($perPage);

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

    /**
     * Report: Product-wise Employee Report
     * Shows employees who have taken exactly 1 quantity of each selected product (up to 6 products)
     */
    public function productWiseEmployeeReport(Request $request)
    {
        // Get selected product IDs (up to 6)
        $selectedProducts = [];
        for ($i = 1; $i <= 6; $i++) {
            $productKey = 'product_id_' . $i;
            if ($request->has($productKey) && $request->$productKey) {
                $selectedProducts[] = $request->$productKey;
            }
        }

        // If no products selected, show empty result
        if (empty($selectedProducts)) {
            $employeeRows = [];
        } else {
            // Find employees who have exactly 1 qty for ANY selected product
            // Step 1: Get all employees who have exactly 1 qty for each selected product
            $employeeProductData = [];
            $allEmployeeIds = [];
            
            foreach ($selectedProducts as $productId) {
                $productQuery = DB::table('stocks')
                    ->select(
                        'stocks.employee_id',
                        DB::raw('ABS(SUM(stocks.product_qty)) as total_qty')
                    )
                    ->whereNotNull('stocks.employee_id')
                    ->where('stocks.product_id', $productId)
                    ->where('stocks.status', 1) // Only issued products (status = 1 means out/issued)
                    ->groupBy('stocks.employee_id')
                    ->havingRaw('ABS(SUM(stocks.product_qty)) = 1'); // Exactly 1 piece

                $productResults = $productQuery->get();
                
                foreach ($productResults as $result) {
                    $allEmployeeIds[] = $result->employee_id;
                    if (!isset($employeeProductData[$result->employee_id])) {
                        $employeeProductData[$result->employee_id] = [];
                    }
                    $employeeProductData[$result->employee_id][$productId] = $result;
                }
            }

            // Step 2: Get all unique employee IDs who have at least one product with exactly 1 qty
            $uniqueEmployeeIds = array_unique($allEmployeeIds);

            // Step 3: Format results for columnar display
            // Show all employees who have exactly 1 qty of ANY selected product
            // For products they don't have, show empty/null
            $employeeRows = [];
            foreach ($uniqueEmployeeIds as $employeeId) {
                $employeeRows[$employeeId] = [];
                foreach ($selectedProducts as $productId) {
                    if (isset($employeeProductData[$employeeId][$productId])) {
                        $employeeRows[$employeeId][$productId] = [
                            'qty' => $employeeProductData[$employeeId][$productId]->total_qty,
                        ];
                    } else {
                        // Show empty/null for products this employee doesn't have
                        $employeeRows[$employeeId][$productId] = [
                            'qty' => null,
                        ];
                    }
                }
            }
        }

        // Load employee data
        $employeeIds = !empty($employeeRows) ? array_keys($employeeRows) : [];
        $employees = [];
        if (!empty($employeeIds)) {
            $employees = Employee::whereIn('id', $employeeIds)->get()->keyBy('id');
        }

        // Load product data for selected products
        $products = [];
        if (!empty($selectedProducts)) {
            $products = Product::whereIn('id', $selectedProducts)->get()->keyBy('id');
        }

        // Get all products for filters
        $allProducts = Product::all();

        return view('Stock.report.productWiseEmployee', compact('employeeRows', 'employees', 'products', 'allProducts', 'selectedProducts'));
    }
}
