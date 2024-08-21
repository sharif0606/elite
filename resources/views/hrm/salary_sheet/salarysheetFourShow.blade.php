@extends('layout.app')

@section('pageTitle',trans('Office Staff Salary View'))
@section('pageSubTitle',trans('Show'))

@section('content')
<section id="result_show">
    <style>
        .myDIV {
          writing-mode: vertical-lr;
          text-orientation: mixed;
        }
        .tbl_border{
            border: 1px solid rgb(46, 46, 46);
            border-collapse: collapse;
        }
    </style>
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img  class="mt-5" height="30px" width="60px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                            </div>
                            <div class="col-6 col-sm-6">
                                @php $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                                    $month = $salary->month;
                                    $getMonth = isset($mt[$month])?$mt[$month]:0;
                                @endphp
                                <div style="text-align: center;">
                                    <h5 class="pb-0" style="padding-top: 5px;">ELITE SECURITY SERVICES LTD</h5>
                                    <p class="text-center m-0 p-0">Houes-02,Road-02,Block-K,Halisahar H/E Chattogram</p>
                                    <p class="text-center m-0 p-0">Salary for the Month of {{$getMonth}}-{{$salary->year}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- table bordered -->
                        <div class="row mt-4">
                            <div class="table-responsive">
                                <table id="salaryTable" class="table mb-0">
                                    <thead>
                                        <tr class="text-center tbl_border" id="">
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('S/N')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Rank & Joining date')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Basic')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('House rent')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Medical Allowance')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Amt')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Post Allow.')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Fuel Bill')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Total Salary')}}</th>
                                            <th class="tbl_border" scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Total Payble')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('SIG OF IND.')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Sing of Accounts')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Remarks')}}</th>
                                        </tr>
                                        <tr class="tbl_border text-center">
                                            <th class="tbl_border">Excess Mobile</th>
                                            <th class="tbl_border">fine</th>
                                            <th class="tbl_border">Ins</th>
                                            <th class="tbl_border">P.F</th>
                                            <th class="tbl_border">Mess</th>
                                            <th class="tbl_border">Loan</th>
                                            <th class="tbl_border">Training Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        <tr class="tbl_border">
                                            <th class="tbl_border" colspan="27">
                                                <div><h6>Office Staff Salary</h6></div>
                                            </th>
                                        </tr>
                                        @php
                                            $deductionMessTotal = 0;
                                            $deductionLoomTotal = 0;
                                            $deductionTrainingTotal = 0;
                                            $payableTotal = 0;
                                        @endphp
                                        @forelse ($details as $d )
                                        <tr class="tbl_border text-center">
                                            <td class="tbl_border">{{ ++$loop->index }}</td>
                                            <td class="tbl_border">{{ $d->employee?->admission_id_no }}</td>
                                            <td class="tbl_border">{{ $d->employee?->salary_joining_date ? \Carbon\Carbon::parse($d->employee->salary_joining_date)->format('d/m/Y') : '' }}</td>
                                            <td class="tbl_border">{{ $d->position?->name }}</td>
                                            <td class="tbl_border">{{ $d->employee?->en_applicants_name }}</td>
                                            <td class="tbl_border">
                                                @if ($d->duty_rate != 0)
                                                {{ round($d->duty_rate) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->house_rent != 0)
                                                {{ round($d->house_rent) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->medical != 0)
                                                {{ round($d->medical) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->gross_salary != 0)
                                                {{ round($d->gross_salary) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->duty_qty != 0)
                                                {{ round($d->duty_qty) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->ot_qty != 0)
                                                {{ round($d->ot_qty) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->ot_rate != 0)
                                                {{ round($d->ot_rate) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->ot_amount != 0)
                                                {{ round($d->ot_amount) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->allownce != 0)
                                                {{ round($d->allownce) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->fuel_bill != 0)
                                                {{ round($d->fuel_bill) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->total_salary_of_salary_sheet_four != 0)
                                                {{ round($d->total_salary_of_salary_sheet_four) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_mobilebill != 0)
                                                {{ round($d->deduction_mobilebill) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_fine != 0)
                                                {{ round($d->deduction_fine) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_ins != 0)
                                                {{ round($d->deduction_ins) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_p_f != 0)
                                                {{ round($d->deduction_p_f) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_mess != 0)
                                                {{ round($d->deduction_mess) }}
                                                @php
                                                    $deductionMessTotal += $d->deduction_mess;
                                                @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_loan != 0)
                                                {{ round($d->deduction_loan) }}
                                                @php
                                                    $deductionLoomTotal += $d->deduction_loan;
                                                @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_traningcost != 0)
                                                {{ round($d->deduction_traningcost) }}
                                                @php
                                                    $deductionTrainingTotal += $d->deduction_traningcost;
                                                @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->total_payable != 0)
                                                {{ $d->total_payable }}
                                                @php
                                                    $payableTotal += $d->total_payable;
                                                @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">{{ $d->sing_of_ind }}</td>
                                            <td class="tbl_border">{{ $d->sing_account }}</td>
                                            <td class="tbl_border">
                                                @if (!is_null($d->remark) && $d->remark !== '')
                                                    {{ $d->remark }}
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                         <tr class="tbl_border text-center">
                                            <th colspan="20" class="tbl_border text-center">Total</th>
                                            <th class="tbl_border">{{$deductionMessTotal}}</th>
                                            <th class="tbl_border">{{$deductionLoomTotal}}</th>
                                            <th class="tbl_border">{{$deductionTrainingTotal}}</th>
                                            <th class="tbl_border">{{$payableTotal}}</th>
                                            <th class="tbl_border">{{$deductionMessTotal + $deductionLoomTotal + $deductionTrainingTotal + $payableTotal}}</th>
                                        </tr> 
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-2 d-flex">
        <button type="button" class="btn btn-info me-2" onclick="printDiv('result_show')">Print</button>
        <button class="btn btn-sm btn-success float-end" onclick="get_print()"><i class="bi bi-filetype-xlsx"></i> Excel</button>
    </div>
</div>
<div class="full_page"></div>
<div id="my-content-div" class="d-none"></div>
@endsection
@push("scripts")
<script src="{{ asset('/assets/js/tableToExcel.js') }}"></script>

<script>
    function exportReportToExcel(tableId, filename) {
        let table = document.getElementById(tableId);
        let tableToExport = table.cloneNode(true);

        // Export the table as it is without removing any columns
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

        $.get("{{route('salarysheet.salarySheetFourShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary_Four-{{$getMonth}}-{{$salary->year}}');
        });
    }
</script>
<script>
    total_calculate();
    function total_calculate() {
        var finalTotal = 0;
        $('.final_total').each(function() {
            finalTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_dp').text(parseFloat(finalTotal).toFixed(2));
    }
</script>
@endpush

