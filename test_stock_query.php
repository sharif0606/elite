<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Database Analysis ===\n\n";

// Total stocks
$totalStocks = DB::table('stocks')->count();
echo "Total stocks: {$totalStocks}\n";

// Unique employee_ids
$uniqueEmployees = DB::table('stocks')
    ->whereNotNull('employee_id')
    ->distinct()
    ->count('employee_id');
echo "Unique employees with stock: {$uniqueEmployees}\n\n";

// Check a specific employee from the screenshot
echo "=== Checking মোঃ জহির উদ্দিন (22276) ===\n";
$employee = DB::table('employees')->where('admission_id_no', '22276')->first();
if ($employee) {
    echo "Employee ID: {$employee->id}\n";
    echo "Name: {$employee->bn_applicants_name}\n";
    
    $stockCount = DB::table('stocks')->where('employee_id', $employee->id)->count();
    echo "Stock records for this employee: {$stockCount}\n";
    
    // Get sample records
    echo "\nSample stock records:\n";
    $samples = DB::table('stocks')
        ->where('employee_id', $employee->id)
        ->limit(10)
        ->get(['id', 'employee_id', 'company_id', 'company_branch_id', 'product_id']);
    
    foreach ($samples as $s) {
        echo "  ID: {$s->id}, employee_id: {$s->employee_id}, company_id: {$s->company_id}, company_branch_id: {$s->company_branch_id}\n";
    }
}

// Test the GROUP BY query
echo "\n=== Testing GROUP BY Query ===\n";
$groupedQuery = DB::table('stocks')
    ->select(DB::raw('MIN(id) as id, employee_id, COUNT(*) as record_count'))
    ->whereNotNull('employee_id')
    ->groupBy('employee_id')
    ->orderBy('record_count', 'desc')
    ->limit(5)
    ->get();

echo "Top 5 employees by stock record count:\n";
foreach ($groupedQuery as $row) {
    echo "  employee_id: {$row->employee_id}, records: {$row->record_count}, min_id: {$row->id}\n";
}

// Check if GROUP BY is actually working correctly
echo "\n=== Verifying GROUP BY Result ===\n";
$testQuery = "SELECT MIN(id) as id, employee_id 
              FROM stocks 
              WHERE employee_id IS NOT NULL 
              GROUP BY employee_id 
              LIMIT 10";
$results = DB::select($testQuery);
echo "First 10 grouped results (should be unique employee_ids):\n";
foreach ($results as $r) {
    echo "  id: {$r->id}, employee_id: {$r->employee_id}\n";
}

echo "\n=== DONE ===\n";
