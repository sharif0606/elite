@extends('layout.app')
@section('pageTitle','Zone Wise Invoice Due Report')
@section('pageSubTitle','All Invoice')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-info my-1 mx-2" onclick="printDiv('result_show')">Print</button>
            <button type="button" class="btn btn-success my-1" onclick="get_print()"><i class="bi bi-filetype-xlsx"></i> Excel</button>
        </div>
        <form method="get" action="">
            <div class="row">
                <div class="col-sm-2">
                    <label for="">From Year</label>
                    <select class="form-control" name="fyear">
                        @foreach(range(2023, \Carbon\Carbon::now()->format('Y')) as $year)
                        <option value="{{ $year }}" {{ request()->get('fyear', \Carbon\Carbon::now()->subMonth(6)->format('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">From Month</label>
                    <select class="form-control" name="fmonth">
                        @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request()->get('fmonth', \Carbon\Carbon::now()->subMonth(6)->format('m')) == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">To Year</label>
                    <select class="form-control" name="tyear">
                        @foreach(range(2024, \Carbon\Carbon::now()->format('Y')) as $year)
                        <option value="{{ $year }}" {{ request()->get('tyear', \Carbon\Carbon::now()->format('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">To Month</label>
                    <select class="form-control" name="tmonth">
                        @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request()->get('tmonth', \Carbon\Carbon::now()->format('m')) == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="received_by_city">Received By</label>
                    <select class="form-control" name="received_by_city">
                        <option value="">Select</option>
                        <option value="1" @if(request()->get('received_by_city') == 1) selected @endif>Ctg</option>
                        <option value="2" @if(request()->get('received_by_city') == 2) selected @endif>Head Office</option>
                    </select>
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-info">Search</button>
                    <a href="{{ route('report.inv_payment') }}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered mb-0" id="result_show">
                @php $grandTotal = 0; @endphp
                @foreach($zones as $zone)
                <tr class="text-center">
                    <th colspan="{{ 3 + count($period) }}">{{ $zone->name }}-{{ $zone->name_bn }}</th>
                </tr>
                <tr class="text-center">
                    <th>#</th>
                    <th>Customer</th>
                    @foreach($period as $dt)
                    <th>{{ $dt->format("M-Y") }}</th> <!-- Month-Year format -->
                    @endforeach
                    <th>Amount</th>
                    <th>Remarks</th>
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
                            <tr class="text-center">
                                <td>{{ ++$i }}</td>
                                <td>{{ $customer->name }}</td>
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
                                    <td>{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
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
                                <td>{{$branchTotalDue}}</td>
                                <td></td>
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
                            <tr class="text-center">
                                <td>{{ ++$i }}</td>
                                <td>Branch:{{ $branch->brance_name }}<br>
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
                                    <td>{{-- $invoices[0]->total_due > 0 ? $invoices[0]->total_due : '-' --}}
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
                                <td>{{$branchTotalDue}}</td>
                                <td></td>
                            </tr>
                        @else
                            @continue <!-- Skip rendering this branch row if total_due <= 1 -->
                        @endif
                        @endif
                    @endforeach
                @endif
                <tr>
                    <th colspan="{{ 3 + count($period) }}" class="text-end">Total</th>
                    <th colspan="2">{{ $grandTotal > 0 ? $grandTotal : '-' }}</th> <!-- Display grand total for the zone -->
                </tr>
            @endforeach
            </table>
            <div class="pt-2">
            </div>
        </div>

    </div>
</div>

@endsection
@push('scripts')
<script src="{{ asset('/assets/js/tableToExcel.js') }}"></script>
<script>
    function printDivemp(divName) {
    var prtContent = document.getElementById(divName).cloneNode(true);
    
    // Get all inputs within the div and update their values in the cloned content
    var inputs = prtContent.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type === 'text' || inputs[i].type === 'date') {
            inputs[i].setAttribute('value', inputs[i].value);
        }
    }
    
    // Get all textareas within the div and update their text in the cloned content
    var textareas = prtContent.getElementsByTagName('textarea');
    for (var i = 0; i < textareas.length; i++) {
        textareas[i].innerHTML = textareas[i].value;
    }
    
    // Get all selects within the div and update their selected options in the cloned content
    var selects = prtContent.getElementsByTagName('select');
    for (var i = 0; i < selects.length; i++) {
        var selectedOption = selects[i].options[selects[i].selectedIndex];
        selectedOption.setAttribute('selected', 'selected');
    }

    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
    WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}" type="text/css"/>');
    WinPrint.document.write('<style> table tr td, table tr th { font-size:13px !important; } .police-vf-font{font-size: 13px;} .police-vf-foot-font{font-size: 9px;} .red-line {height: 2px !important; background-color: red !important; margin-bottom: 0.5rem;} .black-line {height: 1px !important; background-color: #000 !important; margin-bottom: 0.5rem;} body { background-color: #ffff !important; } .no-print { display: none !important;} </style>');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();

    WinPrint.onload = function () {
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    };
}
</script>
<script>
    function exportReportToExcel(tableId, filename) {
        let table = document.getElementById(tableId);
        let tableToExport = table.cloneNode(true);

        TableToExcel.convert(tableToExport, {
            name: `${filename}.xlsx`,
            sheet: {
                name: 'Zone_Wise_Invoice_Due_Report'
            }
        });

        $("#my-content-div").html("");
        $('.full_page').html("");
    }
    
    function get_print() {
        $('.full_page').html('<div style="background:rgba(0,0,0,0.5);width:100vw; height:100vh;position:fixed; top:0; left;0"><div class="loader my-5"></div></div>');
        var fyear = "{{ request()->get('fyear') }}";
        var fmonth = "{{ request()->get('fmonth') }}";

        var tyear = "{{ request()->get('tyear') }}";
        var received_by_city = "{{ request()->get('received_by_city') }}";

        $.get("{{route('report.inv_payment')}}?fyear=" + fyear + "&fmonth=" + fmonth + "&tyear=" + tyear + "&received_by_city=" + received_by_city, function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            exportReportToExcel('Zone_Wise_Invoice_Due_Report', 'Zone_Wise_Invoice_Due_Report');
        });
    }
</script>
@endpush