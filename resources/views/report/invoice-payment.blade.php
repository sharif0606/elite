@extends('layout.app')
@section('pageTitle','Zone Wise Invoice Due Report')
@section('pageSubTitle','All Invoice')
@section('content')

<div class="col-12">
    <div class="card">
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
                    <select class="form-control" name="received_by_city" required>
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
            <table class="table table-bordered mb-0">
                @foreach($zones as $zone)
                <tr class="text-center">
                    <th colspan="{{ 3 + count($period) }}">{{ $zone->name }}</th>
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
    @endforeach
@endif

@if($zone->branch->isNotEmpty())
    @php $i = 0; @endphp <!-- Ensure $i is defined -->
    @foreach($zone->branch as $branch)
        <tr class="text-center">
            <td>{{ ++$i }}</td>
            <td>{{ $branch->brance_name }}-{{$branch->customer->name}}</td>
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
                        AND MONTH(invoice_generates.bill_date) = :month
                        AND YEAR(invoice_generates.bill_date) = :year
                "), [
                    'customer_id' => $branch->customer_id,
                    'branch_id' => $branch->id,
                    'month' => $dt->month,
                    'year' => $dt->year
                ]);
                @endphp
                <td>
                    @if(!empty($invoices) && isset($invoices[0]))
                        Grand Total: {{ $invoices[0]->total_grand_total ?? 0 }}<br>
                        Paid: {{ $invoices[0]->total_paid ?? 0 }}<br>
                        Due: {{ $invoices[0]->total_due ?? 0 }}
                    @else
                        No Data
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
@endif
@endforeach
            </table>
            <div class="pt-2">
            </div>
        </div>

    </div>
</div>

@endsection