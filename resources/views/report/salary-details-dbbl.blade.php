@extends('layout.app')
@section('pageTitle','Salary Report')
@section('pageSubTitle','report')
@section('content')
@php
$options = [
0 => "Office Staff",
1 => "Out Station",
2 => "In Station",
3 => "Peon",
4 => "Robi Tower",
5 => "Ever Care",
6 => "Linde BD",
7 => "Mas Intimates",
8 => "Mas Sumantra",
9 => "Portlink Unit 1",
10 => "Portlink Unit 2",
11 => "RSB",
12 => "Top Way",
13 => "RSGT PCT",
14 => "RSGT SCY",
15 => "Office Staff Prime",
16 => "Office Staff Others",
17 => "Stop Salary List",
18 => "City Bank & IFIC"
19 => "Midas Safety Unit-1 & 3"
20 => "Midas Safety Unit-2"
];
@endphp
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                @php $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                $month = $getMonth;
                $getMonthName = isset($mt[$month])?$mt[$month]:0;
                $sl=1;
                $totalAmount=0;
                @endphp
                <div class="d-flex justify-content-between">
                    <a class="btn btn-sm btn-danger float-start my-1 pt-2" href="{{route('report.salary_report')}}">Back</a>
                    <div>
                        <button type="button" class="btn btn-info my-1" onclick="printDiv('result_show')">Print</button>
                        <button type="button" class="btn btn-success my-1" onclick="get_print()"><i class="bi bi-filetype-xlsx"></i> Excel</button>
                    </div>
                </div>
                <div class="table-responsive" id="result_show">
                    <style>
                        .tbl_border {
                            border: 1px solid;
                            border-collapse: collapse;
                        }
                    </style>
                    @php
                    $name = array('Office Staff','Out Station','In Station','Peon','Robi Tower','Ever Care','Linde BD','Mas Intimates','Mas Sumantra','Portlink Unit 1','Portlink Unit 2','RSB','Top Way','RSGT PCT','RSGT SCY');
                    @endphp
                    <table id="salaryTable" class="table tbl_border">
                        <thead>
                            <tr class="text-center tbl_border">
                                <th colspan="8" class="tbl_border">Amount to be sent through BEFTN as salary of {{$name[$salaryType]}} For The Month of {{$getMonthName}}-{{$getYear}}</th>
                            </tr>
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
                            {{-- @if ($d->employee?->salary_prepared_type == $salaryType) --}}
                            <tr class="tbl_border">
                                <th class="tbl_border text-center">{{ $sl++}}</th>
                                <th class="tbl_border text-center">{{$d->employee?->admission_id_no}}</th>
                                <th class="tbl_border text-center">{{$d->position?->name}}</th>
                                <th class="tbl_border">{{$d->employee?->en_applicants_name}}</th>
                                <th class="tbl_border text-center">{{$d->employee?->bn_ac_no}}</th>
                                <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                <th class="tbl_border">{{--$d->branches?->brance_name--}}
                                    @isset($options[$salaryType])
                                    <p>{{ $options[$salaryType] }}</p>                                    
                                    @endisset
                                </th>
                            </tr>
                            @php
                            $totalAmount += $d->common_net_salary;
                            @endphp
                            {{-- @endif --}}
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
                                <th class="tbl_border text-center" colspan="2">Total =</th>
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
        var year = {
            {
                $getYear
            }
        };
        var month = {
            {
                $getMonth
            }
        };
        var type = {
            {
                $salaryType
            }
        };

        $.get("{{route('report.salary_report_details')}}?year=" + year + "&month=" + month + "&type=" + type, function(data) {
            $("#my-content-div").html(data);
        }).then(function() {
            exportReportToExcel('salaryTable', '{{$name[$salaryType]}}-{{$getMonthName}}-{{$getYear}}');
        });
    }
</script>
@endpush