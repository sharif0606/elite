@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Three View'))
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
                                <table id="salaryTable" class=" mb-0" style="width: 1900px !important;">
                                    <thead>
                                        <tr class="text-center tbl_border" id="">
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('S/N')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Rank')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2" style="width: 100px !important;">{{__('Joining Date')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Basic')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('House rent (50%)')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Medical')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Trans. Conve.')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Food Allownce')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Post Allownce')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Gross Wages')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Total Working Days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Absent')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Vacant')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                            <th class="tbl_border" scope="col" colspan="3">{{__('Leave')}}</th>
                                            <th class="tbl_border" scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Net Wages')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT hour')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT rate(Basic*2)')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('OT Amt.')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Total Payable')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Signature')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('Remarks')}}</th>
                                        </tr>
                                        <tr class="tbl_border text-center">
                                            <th class="tbl_border">CL</th>
                                            <th class="tbl_border">SL</th>
                                            <th class="tbl_border">EL</th>
                                            <th class="tbl_border">Absent</th>
                                            <th class="tbl_border">Vacant</th>
                                            <th class="tbl_border">H.rent</th>
                                            <th class="tbl_border">PF</th>
                                            <th class="tbl_border">Adv.</th>
                                            <th class="tbl_border">Stm</th>
                                            <th class="tbl_border">Total</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $totalPayable = 0;
                                    @endphp
                                    <tbody class="salarySheet">
                                        @foreach ($groupedData as $customerId => $branches)
                                            @foreach ($branches as $branchId => $details)
                                                <tr class="tbl_border">
                                                    <td class="tbl_border" colspan="31">
                                                        <div class="d-flex">
                                                            <h6>{{ $details[0]->customer?->name }},</h6>
                                                            <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{--@forelse (collect($details)->sortBy(fn($d) => $d['employee']['salary_joining_date'] ?? null) as $d )--}}
                                                @forelse (collect($details)->sortBy('job_post.serial') as $d)
                                                <tr class="tbl_border text-center">
                                                    <td class="tbl_border">{{ ++$loop->index }}</td>
                                                    <td class="tbl_border">{{ $d->employee?->admission_id_no }}</td>
                                                    <td class="tbl_border">{{ $d->position?->name }}</td>
                                                    <td class="tbl_border">{{ $d->employee?->en_applicants_name }}</td>
                                                    <td class="tbl_border">
                                                        {{ $d->employee->salary_joining_date ? \Carbon\Carbon::parse($d->employee->salary_joining_date)->format('d-m-Y') : '' }}
                                                    </td>
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
                                                        @if ($d->trans_conve != 0)
                                                            {{ round($d->trans_conve) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if($d->food_allownce > 0)
                                                            {{ round($d->food_allownce) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if($d->allownce > 0)
                                                            {{ round($d->allownce) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->gross_wages != 0)
                                                            {{ round($d->gross_wages) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->total_workingday != 0)
                                                            {{ round($d->total_workingday) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->present_day != 0)
                                                            {{ round($d->present_day) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->absent != 0)
                                                            {{ round($d->absent) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->vacant != 0)
                                                            {{ round($d->vacant) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->holiday_festival != 0)
                                                            {{ round($d->holiday_festival) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->leave_cl != 0)
                                                            {{ round($d->leave_cl) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->leave_sl != 0)
                                                            {{ round($d->leave_sl) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->leave_el != 0)
                                                            {{ round($d->leave_el) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_absent != 0)
                                                            {{ round($d->deduction_absent) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_vacant != 0)
                                                            {{ round($d->deduction_vacant) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_hr != 0)
                                                            {{ round($d->deduction_hr) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_p_f != 0)
                                                            {{ round($d->deduction_p_f) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_adv != 0)
                                                            {{ round($d->deduction_adv) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_revenue_stamp != 0)
                                                            {{ round($d->deduction_revenue_stamp) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->deduction_total != 0)
                                                            {{ round($d->deduction_total) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->net_salary != 0)
                                                            {{ round($d->net_salary) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->ot_qty != 0)
                                                            {{ round($d->ot_qty) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->ot_rate_basicDuble != 0)
                                                            {{ round($d->ot_rate_basicDuble) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">
                                                        @if ($d->ot_amount != 0)
                                                            {{ round($d->ot_amount) }}
                                                        @endif
                                                    </td>
                                                    <td class="tbl_border">{{ $d->total_payable }}</td>
                                                    <td class="tbl_border">{{ $d->sing_of_ind }}</td>
                                                    <td class="tbl_border">{{ $d->remark }}</td>
                                                </tr>
                                                @php
                                                    $totalPayable += $d->total_payable;
                                                @endphp
                                                @empty
                                                @endforelse
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td class="tbl_border text-center" colspan="31"> Total</td>
                                        <td class="tbl_border text-center">{{money_format($totalPayable)}}</td>
                                        <td class="tbl_border text-center"></td>
                                        <td class="tbl_border text-center"></td>
                                    </tr>
                                    <tfoot>
                                        {{--  <tr>
                                            <td></td>
                                            <td></td>
                                            <td> Total</td>
                                            <td><input style="width:100px;" class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></td>
                                            <td><input style="width:100px;" class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></td>
                                            <td><input style="width:100px;" class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                            <td><input style="width:100px;" class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></td>
                                            <td><input style="width:100px;" class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></td>
                                            <td></td>
                                        </tr>  --}}
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

        $.get("{{route('salarysheet.salarySheetThreeShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary Three-{{$getMonth}}-{{$salary->year}}');
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

