@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Five View'))
@section('pageSubTitle',trans('Show'))

@section('content')
<section id="result_show">
<style>

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
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('SL No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Rank')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Rate of Salary')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Pre Days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Taka')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Post Allowance')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                            <th class="tbl_border" scope="col" colspan="8">{{__('DEDUCTION')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Total Payable Salary')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('SIGN OF IND.')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Sign of Account')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Remark')}}</th>
                                        </tr>
                                        <tr class="text-center tbl_border">
                                            <th class="tbl_border">Dress</th>
                                            <th class="tbl_border">Fine</th>
                                            <th class="tbl_border">Bank Charge/ Exc</th>
                                            <th class="tbl_border">ins</th>
                                            <th class="tbl_border">P.F</th>
                                            <th class="tbl_border">stamp</th>
                                            <th class="tbl_border">Training Cost</th>
                                            <th class="tbl_border">Loan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        @php
                                            $deductionLoanTotal = 0;
                                            $deductionTrainingTotal = 0;
                                            $payableTotal = 0;
                                        @endphp
                                        @foreach ($groupedData as $customerId => $branches)
                                            @foreach ($branches as $branchId => $details)
                                                <tr class="tbl_border">
                                                    <td class="tbl_border" colspan="25">
                                                        <div class="d-flex">
                                                            <h6>{{ $details[0]->customer?->name }},</h6>
                                                            <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @forelse ($details as $d )
                                                <tr class="text-center tbl_border">
                                                    <td class="tbl_border">{{ ++$loop->index }}</td>
                                                    <td class="tbl_border">{{ $d->employee?->admission_id_no }}</td>
                                                    <td class="tbl_border">
                                                        {{ $d->employee->salary_joining_date ? \Carbon\Carbon::parse($d->employee->salary_joining_date)->format('d-m-Y') : '' }}
                                                    </td>
                                                    <td class="tbl_border">{{ $d->position?->name }}</td>
                                                    <td class="tbl_border">{{ $d->employee?->en_applicants_name }}</td>
                                                    <td class="tbl_border">
                                                        @if ($d->duty_qty != 0)
                                                            {{ round($d->duty_rate) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->duty_qty != 0)
                                                        {{ (int)$d->duty_qty }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->duty_amount != 0)
                                                        {{ round($d->duty_amount) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->ot_qty != 0)
                                                        {{ (int)$d->ot_qty }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->ot_qty != 0)
                                                            @if ($d->ot_rate != 0)
                                                            {{ round($d->ot_rate) }}
                                                            @endif
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
                                                    <td class="tbl_border">{{ round($d->gross_salary) }}</td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_dress != 0)
                                                        {{ round($d->deduction_dress) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_fine != 0)
                                                        {{ round($d->deduction_fine) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_banck_charge != 0)
                                                        {{ round($d->deduction_banck_charge) }}
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
                                                        @if ($d->deduction_revenue_stamp != 0)
                                                        {{ round($d->deduction_revenue_stamp) }}
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
                                                        @if ($d->deduction_loan != 0)
                                                        {{ round($d->deduction_loan) }}
                                                        @php
                                                            $deductionLoanTotal += $d->deduction_loan;
                                                        @endphp
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->net_salary != 0)
                                                        {{ $d->net_salary }}
                                                        @php
                                                            $payableTotal += $d->net_salary;
                                                        @endphp
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">{{ $d->sing_of_ind }}</td>
                                                    <td class="tbl_border">{{ $d->sing_account }}</td>
                                                    <td class="tbl_border">{{ $d->remark }}</td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            @endforeach
                                        @endforeach
                                        {{-- footer --}}
                                        <tr class="tbl_border">
                                            <th colspan="19" class="text-center tbl_border">Total</th>
                                            <th class="tbl_border text-center">{{$deductionTrainingTotal}}</th>
                                            <th class="tbl_border text-center">{{$deductionLoanTotal}}</th>
                                            <th class="tbl_border text-center">{{$payableTotal}}</th>
                                            <th class="tbl_border text-center">{{ $deductionLoanTotal + $deductionTrainingTotal + $payableTotal}}</th>
                                            <th class="tbl_border"></th>
                                            <th class="tbl_border"></th>
                                        </tr> 
                                        {{-- footer --}}
                                    </tbody>
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
        <button class="btn btn-sm btn-success float-end" onclick="get_print()" target="__blank"><i class="bi bi-filetype-xlsx"></i> Excel</button>
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

        $.get("{{route('salarysheet.salarySheetFiveShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary_Five-{{$getMonth}}-{{$salary->year}}');
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
{{--  @push('scripts')
<script>
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
@endpush  --}}