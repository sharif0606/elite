<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Count Query ===\n\n";

$countSql = "(SELECT COUNT(DISTINCT employee_id) as total FROM stocks WHERE employee_id IS NOT NULL) 
            UNION ALL 
            (SELECT COUNT(DISTINCT CONCAT(company_id, '-', IFNULL(company_branch_id, 0))) as total FROM stocks WHERE employee_id IS NULL AND company_id IS NOT NULL)";

echo "Count SQL:\n$countSql\n\n";

$countResults = DB::select($countSql);
echo "Count Results:\n";
print_r($countResults);

$totalCount = array_sum(array_column($countResults, 'total'));
echo "\nTotal Count: $totalCount\n";

echo "\n=== Verifying Counts Separately ===\n";
$empCount = DB::table('stocks')->whereNotNull('employee_id')->distinct()->count('employee_id');
echo "Unique employees: $empCount\n";

$compCount = DB::table('stocks')
    ->whereNull('employee_id')
    ->whereNotNull('company_id')
    ->select(DB::raw('COUNT(DISTINCT CONCAT(company_id, "-", IFNULL(company_branch_id, 0))) as total'))
    ->first()->total;
echo "Unique companies: $compCount\n";

echo "Expected total: " . ($empCount + $compCount) . "\n";

echo "\n=== DONE ===\n";
