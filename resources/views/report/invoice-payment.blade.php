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
                @php
                $customerCount = $zone->customer->count();
                @endphp
                @if($customerCount > 0)
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

                @php $grandTotal = 0; @endphp
                @foreach($zone->customer as $i => $cust)
                @php
                $totalDue = 0;
                @endphp

                @foreach($period as $dt)
                @php
                $bill_amount = $cust->invoiceGenerates()
                ->whereMonth('bill_date', $dt->month)
                ->whereYear('bill_date', $dt->year)
                ->first();

                $paid_amount = 0;
                if ($bill_amount) {
                $paid_amount = $bill_amount->payment()
                ->selectRaw('SUM(IFNULL(received_amount, 0) + IFNULL(ait_amount, 0) + IFNULL(vat_amount, 0) + IFNULL(less_paid_honor, 0) + IFNULL(fine_deduction, 0)) as total_received')
                ->value('total_received');
                }

                $due = $bill_amount?->grand_total - $paid_amount;
                $rounded_due = round($due, 2);

                // Apply ceil or floor based on value
                if ($rounded_due > 0.5) {
                $rounded_due = ceil($rounded_due); // Apply ceil if greater than 0.5
                } elseif ($rounded_due < 0.5) {
                    $rounded_due=floor($rounded_due); // Apply floor if less than 0.5
                    }

                    // Add to total due if greater than threshold (5)
                    if ($rounded_due> 5) {
                    $totalDue += $rounded_due;
                    }
                    @endphp
                    @endforeach

                    @if($totalDue > 5) <!-- Only show customer row if total due is greater than 5 -->
                    <tr class="text-center">
                        <td>{{ ++$i }}</td>
                        <td>{{ $cust->name }}</td>
                        @foreach($period as $dt)
                        <td>
                            @php
                            /*$bill_amount = $cust->invoiceGenerates()
                            ->whereMonth('bill_date', $dt->month)
                            ->whereYear('bill_date', $dt->year)
                            ->first();*/
                            $bill_amount = $cust->invoiceGenerates()
    ->whereMonth('start_date', $dt->month)
    ->whereYear('start_date', $dt->year)
    ->whereMonth('end_date', $dt->month)
    ->whereYear('end_date', $dt->year)
    ->first();


                            $paid_amount = 0;
                            if ($bill_amount) {
                            $paid_amount = $bill_amount->payment()
                            ->selectRaw('SUM(IFNULL(received_amount, 0) + IFNULL(ait_amount, 0) + IFNULL(vat_amount, 0) + IFNULL(less_paid_honor, 0) + IFNULL(fine_deduction, 0)) as total_received')
                            ->value('total_received');
                            }

                            $due = $bill_amount?->grand_total - $paid_amount;
                            $rounded_due = round($due, 2);

                            if ($rounded_due > 0.5) {
                            $rounded_due = ceil($rounded_due);
                            } elseif ($rounded_due < 0.5) {
                                $rounded_due=floor($rounded_due);
                                }

                                echo $rounded_due> 5 ? $rounded_due : '-';
                                @endphp
                        </td>
                        @endforeach
                        <td>{{ $totalDue }}</td> <!-- Display total due for the customer -->
                        <td></td> <!-- Remarks column -->
                    </tr>
                    @php
                    $grandTotal += $totalDue;
                    @endphp
                    @endif
                    @endforeach
                    <tr>
                        <th colspan="{{ 3 + count($period) }}" class="text-end">Total</th>
                        <th colspan="2">{{ $grandTotal > 0 ? $grandTotal : '-' }}</th> <!-- Display grand total for the zone -->
                    </tr>
                    @endif
                    @endforeach
            </table>

            <div class="pt-2">
                {{ $zones->links() }}
            </div>
        </div>
    </div>
</div>

@endsection