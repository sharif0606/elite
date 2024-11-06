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
                    $getMonthName = isset($mt[$month])?$mt[$month]:0;
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
                        $name = array('Office Staff','Out Station','In Station','Peon','Robi Tower','Ever Care','Linde BD','Mas Intimats','Mas Sumantra','Portlink','RSB','Top Way','RSGT');
                    @endphp
                    <table id="salaryTable" class="table tbl_border">
                        <thead>
                            <tr class="text-center tbl_border"><th colspan="11" class="tbl_border">Amount to be sent through BEFTN as salary of {{$name[$salaryType]}} For The Month of {{$getMonthName}}-{{$getYear}}, Elite Security Services Ltd Chittagong</th></tr>
                            <tr class="text-center tbl_border">
                                <th class="tbl_border">SL</th>
                                <th class="tbl_border">Bank's Branch With Location</th>
                                <th class="tbl_border">Rounting No</th>
                                <th class="tbl_border">Account Holder's Name</th>
                                <th class="tbl_border">Account Number</th>
                                <th class="tbl_border">Benefitiery Branches</th>
                                <th class="tbl_border">Salary Amount</th>
                                <th class="tbl_border">Total Amount</th>
                                <th class="tbl_border">Designation & ID No</th>
                                <th class="tbl_border">Mobile No</th>
                                <th class="tbl_border">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                                @if ($d->employee?->salary_prepared_type == $salaryType)
                                    <tr class="tbl_border">
                                        <th class="tbl_border text-center">{{ $sl++}}</th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_bank_name}}, {{$d->employee?->bn_brance_name}} <input type="hidden" value="{{$d->id}}"></th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_routing_number}}</th>
                                        <th class="tbl_border">
                                            @if($d->employee?->bn_ac_name != '')
                                                {{$d->employee?->bn_ac_name}}
                                            @else
                                                {{$d->employee?->en_applicants_name}}
                                            @endif
                                        </th>
                                        <th class="tbl_border text-center">{{$d->employee?->bn_ac_no}}</th>
                                        <th class="tbl_border">{{$d->branches?->brance_name}}</th>
                                        <th class="tbl_border text-end">{{money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border text-end">{{ money_format($d->common_net_salary)}}</th>
                                        <th class="tbl_border text-center">{{$d->position?->name}} <br> ID No- {{$d->employee?->admission_id_no}} </th>
                                        <th class="tbl_border text-center">{{$d->employee?->en_parm_phone_my}}</th>
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
                                <th class="tbl_border text-left" colspan="4">
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
                                <th class="tbl_border"></th>
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