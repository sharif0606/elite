<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Controller Query Logic ===\n\n";

// Simulate the controller code for no filter
$perPage = 50;
$page = 2; // Test page 2
$offset = ($page - 1) * $perPage;

$sql = "SELECT MIN(id) as id, employee_id, company_id, company_branch_id 
        FROM stocks 
        WHERE employee_id IS NOT NULL 
        GROUP BY employee_id 
        UNION ALL 
        SELECT MIN(id) as id, employee_id, company_id, company_branch_id 
        FROM stocks 
        WHERE employee_id IS NULL AND company_id IS NOT NULL 
        GROUP BY company_id, company_branch_id 
        ORDER BY id 
        LIMIT ? OFFSET ?";

echo "SQL Query:\n$sql\n\n";
echo "Parameters: LIMIT=$perPage, OFFSET=$offset\n\n";

DB::enableQueryLog();

$results = DB::select($sql, [$perPage, $offset]);

$queries = DB::getQueryLog();
echo "Executed Query:\n";
print_r($queries);

echo "\n\nFirst 10 Results:\n";
foreach (array_slice($results, 0, 10) as $r) {
    echo "  id: {$r->id}, employee_id: {$r->employee_id}, company_id: {$r->company_id}, company_branch_id: {$r->company_branch_id}\n";
    
    // Check if this employee_id appears multiple times in results
    $duplicates = array_filter($results, function($item) use ($r) {
        return $item->employee_id == $r->employee_id && $r->employee_id !== null;
    });
    
    if (count($duplicates) > 1) {
        echo "    WARNING: This employee_id appears " . count($duplicates) . " times in results!\n";
    }
}

// Count duplicates in results
$employeeIds = array_filter(array_column($results, 'employee_id'), function($id) { return $id !== null; });
$uniqueEmployeeIds = array_unique($employeeIds);
echo "\n\nTotal results: " . count($results) . "\n";
echo "Employee records in results: " . count($employeeIds) . "\n";
echo "Unique employee IDs: " . count($uniqueEmployeeIds) . "\n";
if (count($employeeIds) != count($uniqueEmployeeIds)) {
    echo "ERROR: There are duplicate employees in the results!\n";
}

echo "\n=== DONE ===\n";
