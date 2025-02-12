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
                @foreach ($paginatedZones as $zone)
                <tr class="text-center">
                    <th colspan="{{ 3 + count($period) }}">{{ $zone['zone_name'] }} ({{ $zone['zone_name_bn'] }})</th>
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
                @foreach($zone['customer'] as $i => $cust) <!-- Accessing the customers for each zone -->
                @php
                $totalDue = 0;
                @endphp
                <!-- Your code for displaying customer data goes here -->
                @endforeach
                @endforeach
            </table>

            <div class="pt-2">
                {{ $paginatedZones->links() }}
            </div>
        </div>

    </div>
</div>

@endsection