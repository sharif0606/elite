@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Two View'))
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
                            {{-- <div class="col-3">
                                <ul class="text-start">
                                    @foreach($salary->customers as $customer)
                                        <li>{{ $customer->name }}</li>
                                    @endforeach
                                </ul>
                            </div> --}}
                        </div>
                        <!-- table bordered -->
                        <div class="row mt-4">
                                <div class="table-responsive">
                                    <table id="salaryTable" class=" mb-0" style="width: 2000px !important;">
                                        <thead>
                                            <tr class="text-center tbl_border" id="">
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('S/N')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2" style="width: 100px !important;">{{__('Date of Joining')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Designation')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Payment Type')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Working Days')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Taka')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Weekly Leave')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('OT Days')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('OT Amount')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('HT/ Ribon Alice')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Gun Alice')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Leave')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Extra Alice')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Arrear')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Bonus')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Donation')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th class="tbl_border" scope="col" colspan="16">{{__('DEDUCTION')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Signature')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Zone')}}</th>
                                                <th class="tbl_border" scope="col" rowspan="2">{{__('Remarks')}}</th>
                                            </tr>
                                            <tr class="tbl_border text-center">
                                                <th class="tbl_border">Mattress & Pillow Cost</th>
                                                <th class="tbl_border">Tonic Sim</th>
                                                <th class="tbl_border">Over Payment Cutt</th>
                                                <th class="tbl_border">Fine</th>
                                                <th class="tbl_border">Loan</th>
                                                <th class="tbl_border">Long Loan</th>
                                                <th class="tbl_border">Cloth</th>
                                                <th class="tbl_border">HR</th>
                                                <th class="tbl_border">Jacket</th>
                                                <th class="tbl_border">Stamp</th>
                                                <th class="tbl_border">Training Cost</th>
                                                <th class="tbl_border">C/F</th>
                                                <th class="tbl_border">Medical</th>
                                                <th class="tbl_border">Ins</th>
                                                <th class="tbl_border">P/F</th>
                                                <th class="tbl_border">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">
                                            @php
                                                $deductionTrainingTotal = 0;
                                                $deductionLoanTotal = 0;
                                                $deductionLongLoanTotal = 0;
                                                $netTotal = 0;
                                            @endphp
                                            @foreach ($groupedData as $customerId => $branches)
                                                @foreach ($branches as $branchId => $details)
                                                    <tr class="tbl_border">
                                                        <td colspan="40">
                                                            <div class="d-flex">
                                                                <h6>{{ $details[0]->customer?->name }},</h6>
                                                                <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @forelse ($details as $d )
                                                    <tr class="tbl_border text-center">
                                                        <td class="tbl_border">{{ ++$loop->index }}</td>
                                                        <td class="tbl_border">{{ $d->employee?->admission_id_no }}</td>
                                                        <td class="tbl_border">
                                                            {{ $d->employee->salary_joining_date ? \Carbon\Carbon::parse($d->employee->salary_joining_date)->format('d-m-Y') : '' }}
                                                        </td>
                                                        <td class="tbl_border">{{ $d->position?->name }}</td>
                                                        <td class="tbl_border">{{ $d->employee?->en_applicants_name }}</td>
                                                        <td class="tbl_border">{{ $d->online_payment }}</td>
                                                        <td class="tbl_border">
                                                            @if ($d->duty_rate != 0)
                                                                {{ round($d->duty_rate) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ (int)$d->duty_qty }}</td>
                                                        <td class="tbl_border">
                                                            @if ($d->duty_amount != 0)
                                                                {{ round($d->duty_amount) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ (int)$d->weekly_leave }}</td>
                                                        <td class="tbl_border">
                                                            {{ (int)$d->ot_qty }}</td>
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
                                                            @if ($d->ht_ribon_alice != 0)
                                                                {{ round($d->ht_ribon_alice) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->gun_alice != 0)
                                                                {{ round($d->gun_alice) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->leave != 0)
                                                                {{ round($d->leave) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->extra_alice != 0)
                                                                {{ round($d->extra_alice) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->arrear != 0)
                                                                {{ round($d->arrear) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->bonus != 0)
                                                                {{ round($d->bonus) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->donation != 0)
                                                                {{ round($d->donation) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->gross_salary != 0)
                                                                {{ round($d->gross_salary) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_matterss_pillowCost != 0)
                                                                {{ round($d->deduction_matterss_pillowCost) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_tonic_sim != 0)
                                                                {{ round($d->deduction_tonic_sim) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_over_paymentCut != 0)
                                                                {{ round($d->deduction_over_paymentCut) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_fine != 0)
                                                                {{ round($d->deduction_fine) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_loan != 0)
                                                                {{ $d->deduction_loan }}
                                                                @php
                                                                    $deductionLoanTotal += $d->deduction_loan;
                                                                @endphp
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_long_loan != 0)
                                                                {{ $d->deduction_long_loan }}
                                                                @php
                                                                    $deductionLongLoanTotal += $d->deduction_long_loan;
                                                                @endphp
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_cloth != 0)
                                                                {{ round($d->deduction_cloth) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_hr != 0)
                                                                {{ round($d->deduction_hr) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_jacket != 0)
                                                                {{ round($d->deduction_jacket) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_revenue_stamp != 0)
                                                                {{ round($d->deduction_revenue_stamp) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_traningcost != 0)
                                                                {{ $d->deduction_traningcost }}
                                                                @php
                                                                    $deductionTrainingTotal += $d->deduction_traningcost;
                                                                @endphp
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_c_f != 0)
                                                                {{ round($d->deduction_c_f) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            @if ($d->deduction_medical != 0)
                                                                {{ round($d->deduction_medical) }}
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
                                                            @if ($d->deduction_total != 0)
                                                                {{ round($d->deduction_total) }}
                                                            @endif
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ $d->net_salary }}
                                                            @php
                                                                $netTotal += $d->net_salary;
                                                            @endphp
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ $d->sing_of_ind }}
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ $d->zone }}
                                                        </td>
                                                        <td class="tbl_border">
                                                            {{ $d->remark }}
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    @endforelse
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tr class="tbl_border">
                                            <th colspan="25" class="text-center tbl_border">Total</th>
                                            <th class="tbl_border text-center">{{$deductionLoanTotal}}</th>
                                            <th class="tbl_border text-center">{{$deductionLongLoanTotal}}</th>
                                            <th colspan="4" class="tbl_border"></th>
                                            <th class="tbl_border text-center">{{$deductionTrainingTotal}}</th>
                                            <th colspan="5" class="tbl_border"></th>
                                            <th class="tbl_border text-center">{{$netTotal}}</th>
                                            <th class="tbl_border text-center">{{ $deductionLoanTotal + $deductionLongLoanTotal + $deductionTrainingTotal + $netTotal}}</th>
                                            <th class="tbl_border"></th>
                                            <th class="tbl_border"></th>
                                        </tr> 
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

        $.get("{{route('salarysheet.salarySheetTwoShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary Two-{{$getMonth}}-{{$salary->year}}');
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

