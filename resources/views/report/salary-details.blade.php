@extends('layout.app')
@section('pageTitle','Salary Report')
@section('pageSubTitle','report')
@section('content')

<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                @php $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                    $month = $getMonth;
                    $getMonth = isset($mt[$month])?$mt[$month]:0;
                    $sl=1;
                    $totalAmount=0;
                @endphp
                <div class="d-flex justify-content-between">
                    <a class="btn btn-sm btn-danger float-start my-1 pt-2" href="{{route('report.salary_report')}}">Back</a>
                    <button type="button" class="btn btn-info my-1" onclick="printDiv('result_show')">Print</button>
                </div>
                <div class="table-responsive" id="result_show">
                    <style>
                        .tbl_border{
                        border: 1px solid;
                        border-collapse: collapse;
                        }
                    </style>
                    <table class="table tbl_border">
                        <thead>
                            <tr class="text-center tbl_border"><th colspan="8" class="tbl_border">Release Salary Sheet For The Month of {{$getMonth}}-{{$getYear}}</th></tr>
                            <tr class="text-center tbl_border">
                                <th class="tbl_border">SL</th>
                                <th class="tbl_border">ID NO</th>
                                <th class="tbl_border">Rank</th>
                                <th class="tbl_border">Name</th>
                                <th class="tbl_border">Account Number</th>
                                <th class="tbl_border">Salary Amount</th>
                                <th class="tbl_border">Total Amount</th>
                                <th class="tbl_border">Post</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                                @if ($d->employee?->salary_prepared_type != 1)
                                    <tr class="tbl_border">
                                        <th class="tbl_border text-center">{{ $sl++}}</th>
                                        <th class="tbl_border text-center">{{$d->employee?->admission_id_no}}</th>
                                        <th class="tbl_border text-center">{{$d->position?->name}}</th>
                                        <th class="tbl_border">{{$d->employee?->en_applicants_name}}</th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_ac_no}}</th>
                                        <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border">{{$d->branches?->brance_name}}</th>
                                    </tr>
                                    @php
                                        $totalAmount += $d->common_net_salary;
                                    @endphp
                                @endif
                            @empty
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="tbl_border">
                                <th class="tbl_border"></th>
                                <th class="tbl_border text-left" colspan="3">
                                    @php
                                        if ($totalAmount > 0) {
                                            $textValue = getBangladeshCurrency($totalAmount);
                                            echo "<em> In Words: $textValue </em>";
                                        } else {
                                            echo "Zero";
                                        }
                                    @endphp
                                </th>
                                <th class="tbl_border text-center" colspan="2">Total =</th>
                                <th class="tbl_border text-end">{{money_format($totalAmount)}}</th>
                                <th class="tbl_border"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-between" style="text-align: center; margin-top:2rem;">
                        <div style="text-align:left;">
                            <p class="mb-5"><b>Prepared By</b></p>
                            <span><b>Mr. Sreekanta Dey</b></span><br>
                            <span><b>Deputy Manager (Accounts Finance)</b></span><br>
                            <span><b>Cell: 01844-040716</b></span>
                        </div>
                        <div>
                            <p class="mb-5">&nbsp;&nbsp;&nbsp;</p>
                            <span>&nbsp;&nbsp;&nbsp;</span><br>
                            <span><b>Senior Manager</b></span><br>
                            <span><b>Accounts & Finance</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection