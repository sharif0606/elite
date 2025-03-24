<table class="table table-bordered mb-0 tbl_border">
                @php $grandTotal = 0; @endphp
                @foreach($zones as $zone)
                    @if(request()->get('zone_id') == $zone->id)
                    <tr class="text-center tbl_border">
                        <th class="tbl_border" colspan="{{ 3 + count($period) }}">{{ $zone->name }}-{{ $zone->name_bn }}</th>
                    </tr>
                    <tr class="text-center tbl_border">
                        <th class="tbl_border">#</th>
                        <th class="tbl_border">Customer</th>
                        @foreach($period as $dt)
                        <th class="tbl_border">{{ $dt->format("M-Y") }}</th> <!-- Month-Year format -->
                        @endforeach
                        <th class="tbl_border">Amount</th>
                        <th class="tbl_border">Remarks</th>
                    </tr>
                    @if($zone->customers->isNotEmpty())
                        @foreach($zone->customers as $i => $customer)
                            @php
                            $branchTotalDue = 0; // Initialize the total due for the branch
                            @endphp

                            @if(request()->get('received_by_city') == $customer->received_by_city)
                            <!-- First, calculate the total due for the entire branch across all periods -->
                            @foreach($period as $dt)
                                @php
                                $invoices = DB::select(DB::raw("
                                    SELECT 
                                        SUM(invoice_generates.grand_total) AS total_grand_total,
                                        SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                        SUM(invoice_generates.grand_total - 
                                            (IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                    FROM 
                                        invoice_generates
                                    LEFT JOIN 
                                        invoice_payments 
                                        ON invoice_generates.id = invoice_payments.invoice_id
                                    WHERE 
                                        invoice_generates.customer_id = :customer_id 
                                        AND MONTH(invoice_generates.end_date) = :month
                                        AND YEAR(invoice_generates.end_date) = :year
                                "), [
                                    'customer_id' => $customer->id,
                                    'month' => $dt->month,
                                    'year' => $dt->year
                                ]);
                                
                                if ($invoices[0]->total_due > 0.5) {
                                    $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                } elseif ($invoices[0]->total_due < 0.5) {
                                    $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                }
                                
                                // Add to total due if greater than threshold (5)
                                if ($rounded_due> 5) {
                                    $branchTotalDue += $rounded_due;
                                }
                                @endphp
                            @endforeach
                            @endif

                            <!-- Now, check if the accumulated total due for the branch is greater than 1 -->
                            @if($branchTotalDue > 5)
                                <tr class="text-center tbl_border">
                                    <td class="tbl_border">{{ ++$i }}</td>
                                    <td class="tbl_border">{{ $customer->name }}</td>
                                    @foreach($period as $dt)
                                        @php
                                        $invoices = DB::select(DB::raw("
                                            SELECT 
                                                SUM(invoice_generates.grand_total) AS total_grand_total,
                                                SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                                SUM(invoice_generates.grand_total - 
                                                    (IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                            FROM 
                                                invoice_generates
                                            LEFT JOIN 
                                                invoice_payments 
                                                ON invoice_generates.id = invoice_payments.invoice_id
                                            WHERE 
                                                invoice_generates.customer_id = :customer_id 
                                                AND MONTH(invoice_generates.end_date) = :month
                                                AND YEAR(invoice_generates.end_date) = :year
                                        "), [
                                            'customer_id' => $customer->id,
                                            'month' => $dt->month,
                                            'year' => $dt->year
                                        ]);
                                        @endphp
                                        <td class="tbl_border">{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
                                            @php
                                            if ($invoices[0]->total_due > 0.5) {
                                                $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                            } elseif ($invoices[0]->total_due < 0.5) {
                                                $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                            }
                                            echo $rounded_due> 5 ? $rounded_due : '-';
                                            @endphp
                                        
                                            
                                            
                                        </td>
                                    @endforeach
                                    <td class="tbl_border">{{$branchTotalDue}}</td>
                                    <td class="tbl_border"></td>
                                </tr>
                            @else
                                @continue <!-- Skip rendering this branch row if total_due <= 1 -->
                            @endif
                        
                        @endforeach
                    @endif

                    @if($zone->branch->isNotEmpty())
                        @php $i = 0; @endphp <!-- Ensure $i is defined -->
                        @foreach($zone->branch as $branch)
                            {{--$branch--}}
                            @php
                            $branchTotalDue = 0; // Initialize the total due for the branch
                            @endphp
                            @if(request()->get('received_by_city') == $branch->received_by_city)
                            <!-- First, calculate the total due for the entire branch across all periods -->
                            @foreach($period as $dt)
                                @php
                                $invoices = DB::select(DB::raw("
                                    SELECT 
                                        SUM(invoice_generates.grand_total) AS total_grand_total,
                                        SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                        SUM(invoice_generates.grand_total - 
                                            (IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                    FROM 
                                        invoice_generates
                                    LEFT JOIN 
                                        invoice_payments 
                                        ON invoice_generates.id = invoice_payments.invoice_id
                                    WHERE 
                                        invoice_generates.customer_id = :customer_id 
                                        AND invoice_generates.branch_id = :branch_id
                                        AND MONTH(invoice_generates.end_date) = :month
                                        AND YEAR(invoice_generates.end_date) = :year
                                "), [
                                    'customer_id' => $branch->customer_id,
                                    'branch_id' => $branch->id,
                                    'month' => $dt->month,
                                    'year' => $dt->year
                                ]);
                                
                                if ($invoices[0]->total_due > 0.5) {
                                    $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                } elseif ($invoices[0]->total_due < 0.5) {
                                    $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                }
                                
                                // Add to total due if greater than threshold (5)
                                if ($rounded_due> 5) {
                                    $branchTotalDue += $rounded_due;
                                }
                                @endphp
                            @endforeach

                            <!-- Now, check if the accumulated total due for the branch is greater than 1 -->
                            @if($branchTotalDue > 5)
                                <tr class="text-center tbl_border">
                                    <td class="tbl_border">{{ ++$i }}</td>
                                    <td class="tbl_border">Branch:{{ $branch->brance_name }}<br>
                                        <small>Company:{{$branch->customer->name}}</small>
                                    </td>
                                    @foreach($period as $dt)
                                        @php
                                        $invoices = DB::select(DB::raw("
                                            SELECT 
                                                SUM(invoice_generates.grand_total) AS total_grand_total,
                                                SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                                SUM(invoice_generates.grand_total - 
                                                    (IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                            FROM 
                                                invoice_generates
                                            LEFT JOIN 
                                                invoice_payments 
                                                ON invoice_generates.id = invoice_payments.invoice_id
                                            WHERE 
                                                invoice_generates.customer_id = :customer_id 
                                                AND invoice_generates.branch_id = :branch_id
                                                AND MONTH(invoice_generates.end_date) = :month
                                                AND YEAR(invoice_generates.end_date) = :year
                                        "), [
                                            'customer_id' => $branch->customer_id,
                                            'branch_id' => $branch->id,
                                            'month' => $dt->month,
                                            'year' => $dt->year
                                        ]);
                                        @endphp
                                        <td class="tbl_border">{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
                                            @php
                                            if ($invoices[0]->total_due > 0.5) {
                                                $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                            } elseif ($invoices[0]->total_due < 0.5) {
                                                $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                            }
                                            echo $rounded_due> 5 ? $rounded_due : '-';
                                            @endphp
                                        
                                            
                                            
                                        </td>
                                    @endforeach
                                    <td class="tbl_border">{{$branchTotalDue}}</td>
                                    <td class="tbl_border"></td>
                                </tr>
                            @else
                                @continue <!-- Skip rendering this branch row if total_due <= 1 -->
                            @endif
                            @endif
                        @endforeach
                    @endif
                    <tr class="tbl_border">
                        <th colspan="{{ 3 + count($period) }}" class="text-end tbl_border">Total</th>
                        <th class="tbl_border" colspan="2">{{ $grandTotal > 0 ? $grandTotal : '-' }}</th> <!-- Display grand total for the zone -->
                    </tr>
                    @endif
                    
                    @if(!request()->has('zone_id') || request()->get('zone_id') == '') 
                    <tr class="text-center tbl_border">
                        <th class="tbl_border" colspan="{{ 3 + count($period) }}">{{ $zone->name }}-{{ $zone->name_bn }}</th>
                    </tr>
                    <tr class="text-center tbl_border">
                        <th class="tbl_border">#</th>
                        <th class="tbl_border">Customer</th>
                        @foreach($period as $dt)
                        <th class="tbl_border">{{ $dt->format("M-Y") }}</th> <!-- Month-Year format -->
                        @endforeach
                        <th class="tbl_border">Amount</th>
                        <th class="tbl_border">Remarks</th>
                    </tr>
                    @if($zone->customers->isNotEmpty())
                        @foreach($zone->customers as $i => $customer)
                            @php
                            $branchTotalDue = 0; // Initialize the total due for the branch
                            @endphp

                            @if(request()->get('received_by_city') == $customer->received_by_city)
                            <!-- First, calculate the total due for the entire branch across all periods -->
                            @foreach($period as $dt)
                                @php
                                $invoices = DB::select(DB::raw("
                                    SELECT 
                                        SUM(invoice_generates.grand_total) AS total_grand_total,
                                        SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                        SUM(invoice_generates.grand_total - 
                                            (IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                    FROM 
                                        invoice_generates
                                    LEFT JOIN 
                                        invoice_payments 
                                        ON invoice_generates.id = invoice_payments.invoice_id
                                    WHERE 
                                        invoice_generates.customer_id = :customer_id 
                                        AND MONTH(invoice_generates.end_date) = :month
                                        AND YEAR(invoice_generates.end_date) = :year
                                "), [
                                    'customer_id' => $customer->id,
                                    'month' => $dt->month,
                                    'year' => $dt->year
                                ]);
                                
                                if ($invoices[0]->total_due > 0.5) {
                                    $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                } elseif ($invoices[0]->total_due < 0.5) {
                                    $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                }
                                
                                // Add to total due if greater than threshold (5)
                                if ($rounded_due> 5) {
                                    $branchTotalDue += $rounded_due;
                                }
                                @endphp
                            @endforeach
                            @endif

                            <!-- Now, check if the accumulated total due for the branch is greater than 1 -->
                            @if($branchTotalDue > 5)
                                <tr class="text-center tbl_border">
                                    <td class="tbl_border">{{ ++$i }}</td>
                                    <td class="tbl_border">{{ $customer->name }}</td>
                                    @foreach($period as $dt)
                                        @php
                                        $invoices = DB::select(DB::raw("
                                            SELECT 
                                                SUM(invoice_generates.grand_total) AS total_grand_total,
                                                SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                                SUM(invoice_generates.grand_total - 
                                                    (IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                            FROM 
                                                invoice_generates
                                            LEFT JOIN 
                                                invoice_payments 
                                                ON invoice_generates.id = invoice_payments.invoice_id
                                            WHERE 
                                                invoice_generates.customer_id = :customer_id 
                                                AND MONTH(invoice_generates.end_date) = :month
                                                AND YEAR(invoice_generates.end_date) = :year
                                        "), [
                                            'customer_id' => $customer->id,
                                            'month' => $dt->month,
                                            'year' => $dt->year
                                        ]);
                                        @endphp
                                        <td class="tbl_border">{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
                                            @php
                                            if ($invoices[0]->total_due > 0.5) {
                                                $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                            } elseif ($invoices[0]->total_due < 0.5) {
                                                $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                            }
                                            echo $rounded_due> 5 ? $rounded_due : '-';
                                            @endphp
                                        
                                            
                                            
                                        </td>
                                    @endforeach
                                    <td class="tbl_border">{{$branchTotalDue}}</td>
                                    <td class="tbl_border"></td>
                                </tr>
                            @else
                                @continue <!-- Skip rendering this branch row if total_due <= 1 -->
                            @endif
                        
                        @endforeach
                    @endif

                    @if($zone->branch->isNotEmpty())
                        @php $i = 0; @endphp <!-- Ensure $i is defined -->
                        @foreach($zone->branch as $branch)
                            {{--$branch--}}
                            @php
                            $branchTotalDue = 0; // Initialize the total due for the branch
                            @endphp
                            @if(request()->get('received_by_city') == $branch->received_by_city)
                            <!-- First, calculate the total due for the entire branch across all periods -->
                            @foreach($period as $dt)
                                @php
                                $invoices = DB::select(DB::raw("
                                    SELECT 
                                        SUM(invoice_generates.grand_total) AS total_grand_total,
                                        SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                        SUM(invoice_generates.grand_total - 
                                            (IFNULL(invoice_payments.received_amount, 0) + 
                                            IFNULL(invoice_payments.ait_amount, 0) + 
                                            IFNULL(invoice_payments.vat_amount, 0) + 
                                            IFNULL(invoice_payments.less_paid_honor, 0) + 
                                            IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                    FROM 
                                        invoice_generates
                                    LEFT JOIN 
                                        invoice_payments 
                                        ON invoice_generates.id = invoice_payments.invoice_id
                                    WHERE 
                                        invoice_generates.customer_id = :customer_id 
                                        AND invoice_generates.branch_id = :branch_id
                                        AND MONTH(invoice_generates.end_date) = :month
                                        AND YEAR(invoice_generates.end_date) = :year
                                "), [
                                    'customer_id' => $branch->customer_id,
                                    'branch_id' => $branch->id,
                                    'month' => $dt->month,
                                    'year' => $dt->year
                                ]);
                                
                                if ($invoices[0]->total_due > 0.5) {
                                    $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                } elseif ($invoices[0]->total_due < 0.5) {
                                    $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                }
                                
                                // Add to total due if greater than threshold (5)
                                if ($rounded_due> 5) {
                                    $branchTotalDue += $rounded_due;
                                }
                                @endphp
                            @endforeach

                            <!-- Now, check if the accumulated total due for the branch is greater than 1 -->
                            @if($branchTotalDue > 5)
                                <tr class="text-center tbl_border">
                                    <td class="tbl_border">{{ ++$i }}</td>
                                    <td class="tbl_border">Branch:{{ $branch->brance_name }}<br>
                                        <small>Company:{{$branch->customer->name}}</small>
                                    </td>
                                    @foreach($period as $dt)
                                        @php
                                        $invoices = DB::select(DB::raw("
                                            SELECT 
                                                SUM(invoice_generates.grand_total) AS total_grand_total,
                                                SUM(IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0)) AS total_paid, 
                                                SUM(invoice_generates.grand_total - 
                                                    (IFNULL(invoice_payments.received_amount, 0) + 
                                                    IFNULL(invoice_payments.ait_amount, 0) + 
                                                    IFNULL(invoice_payments.vat_amount, 0) + 
                                                    IFNULL(invoice_payments.less_paid_honor, 0) + 
                                                    IFNULL(invoice_payments.fine_deduction, 0))) AS total_due
                                            FROM 
                                                invoice_generates
                                            LEFT JOIN 
                                                invoice_payments 
                                                ON invoice_generates.id = invoice_payments.invoice_id
                                            WHERE 
                                                invoice_generates.customer_id = :customer_id 
                                                AND invoice_generates.branch_id = :branch_id
                                                AND MONTH(invoice_generates.end_date) = :month
                                                AND YEAR(invoice_generates.end_date) = :year
                                        "), [
                                            'customer_id' => $branch->customer_id,
                                            'branch_id' => $branch->id,
                                            'month' => $dt->month,
                                            'year' => $dt->year
                                        ]);
                                        @endphp
                                        <td class="tbl_border">{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
                                            @php
                                            if ($invoices[0]->total_due > 0.5) {
                                                $rounded_due = ceil($invoices[0]->total_due); // Apply ceil if greater than 0.5
                                            } elseif ($invoices[0]->total_due < 0.5) {
                                                $rounded_due=floor($invoices[0]->total_due); // Apply floor if less than 0.5
                                            }
                                            echo $rounded_due> 5 ? $rounded_due : '-';
                                            @endphp
                                        
                                            
                                            
                                        </td>
                                    @endforeach
                                    <td class="tbl_border">{{$branchTotalDue}}</td>
                                    <td class="tbl_border"></td>
                                </tr>
                            @else
                                @continue <!-- Skip rendering this branch row if total_due <= 1 -->
                            @endif
                            @endif
                        @endforeach
                    @endif
                    <tr class="tbl_border">
                        <th colspan="{{ 3 + count($period) }}" class="text-end tbl_border">Total</th>
                        <th class="tbl_border" colspan="2">{{ $grandTotal > 0 ? $grandTotal : '-' }}</th> <!-- Display grand total for the zone -->
                    </tr>
                    @endif
                @endforeach
            </table>