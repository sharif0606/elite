@extends('layout.app')
@section('pageTitle','Salary Report')
@section('pageSubTitle','report')
@section('content')
<style>
    .input_css{
        border: none;
        outline: none;
    }
</style>
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                @php $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                    $month = $getMonth;
                    $getMonthName = isset($mt[$month])?$mt[$month]:0;
                    $data = $data->sortBy(fn($d) => $d->employee?->salary_serial);
                    $sl=1;
                    $totalAmount=0;
                @endphp
                <div class="d-flex justify-content-between">
                    <a class="btn btn-sm btn-danger float-start my-1 pt-2" href="{{route('report.salary_report')}}">Back</a>
                    <div>
                        <button type="button" class="btn btn-info my-1" onclick="printDiv('result_show')">Print</button>
                        {{-- <button type="button" class="btn btn-success my-1" onclick="get_print()"><i class="bi bi-filetype-xlsx"></i> Excel</button> --}}
                    </div>
                </div>
                <div class="table-responsive" id="result_show">
                    <style>
                        .input_css{
                            border: none;
                            outline: none;
                        }
                        .tbl_border{
                        border: 1px solid;
                        border-collapse: collapse;
                        }
                    </style>
                    @php
                        $name = array('Office Staff','Out Station','In Station','Peon','Robi Tower','Ever Care','Linde BD','Mas Intimates','Mas Sumantra','Portlink','RSB','Top Way','RSGT','Office Staff Prime','Office Staff Others');
                    @endphp
                    <table id="salaryTable" class="table tbl_border">
                        <thead>
                            <tr class="text-center tbl_border"><th colspan="8" class="tbl_border">Amount to be sent through BEFTN as salary of {{$name[$salaryType]}} for the month of {{$getMonthName}}-{{$getYear}}, Elite Security Services Ltd Chittagong</th></tr>
                            <tr class="text-center tbl_border">
                                <th class="tbl_border">SL</th>
                                <th class="tbl_border">Bank's Branch With Location</th>
                                <th class="tbl_border">Rounting No</th>
                                <th class="tbl_border">Account Holder's Name</th>
                                <th class="tbl_border">Account Number</th>
                                <th class="tbl_border">Salary Amount</th>
                                <th class="tbl_border">Total Amount</th>
                                <th class="tbl_border">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                                @if ($d->employee?->salary_prepared_type != 1)
                                    <tr class="tbl_border">
                                        <th class="tbl_border text-center">{{ $sl++}}</th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_bank_name}}, {{$d->employee?->bn_brance_name}}<input type="hidden" value="{{$d->id}}"></th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_routing_number}}</th>
                                        <th class="tbl_border">{{$d->employee?->en_applicants_name}}</th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_ac_no}}</th>
                                        <th class="tbl_border text-end">{{money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border text-center"><input type="text" class="input_css" value="{{$d->remark}}"></th>
                                    </tr>
                                    @php
                                        $totalAmount += $d->common_net_salary;
                                    @endphp
                                @else
                                @endif
                            @empty
                            @endforelse
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
                                <th class="tbl_border text-center">Total =</th>
                                <th class="tbl_border"></th>
                                <th class="tbl_border text-end">{{money_format($totalAmount)}}</th>
                                <th class="tbl_border"></th>
                            </tr>
                        </tbody>
                            
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
<div class="full_page"></div>
<div id="my-content-div" class="d-none"></div>
@endsection
@push('scripts')
<script src="{{ asset('/assets/js/tableToExcel.js') }}"></script>
<script>
    function exportReportToExcel(tableId, filename) {
        let table = document.getElementById(tableId);
        let tableToExport = table.cloneNode(true);

        TableToExcel.convert(tableToExport, {
            name: `${filename}.xlsx`,
            sheet: {
                name: 'Salary'
            }
        });

        $("#my-content-div").html("");
        $('.full_page').html("");
    }
    
    function get_print() {
        $('.full_page').html('<div style="background:rgba(0,0,0,0.5);width:100vw; height:100vh;position:fixed; top:0; left;0"><div class="loader my-5"></div></div>');
        var year = {{ $getYear }};
        var month = {{ $getMonth }};
        var type = {{ $salaryType }};

        $.get("{{route('report.salary_report_details')}}?year=" + year + "&month=" + month + "&type=" + type, function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            exportReportToExcel('salaryTable', '{{$name[$salaryType]}}-{{$getMonthName}}-{{$getYear}}');
        });
    }
</script>
@endpush