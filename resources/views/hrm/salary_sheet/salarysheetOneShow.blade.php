@extends('layout.app')

@section('pageTitle',trans('Salary Sheet One View'))
@section('pageSubTitle',trans('Show'))

@section('content')
<section id="result_show">
    <style>
        .myDIV {
          writing-mode: vertical-lr;
          text-orientation: mixed;
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
                                <table id="salaryTable" class="table table-bordered mb-0">
                                    <thead>
                                        <tr class="text-center" id="">
                                            <th scope="col" rowspan="2">{{__('S/N')}}</th>
                                            <th class="myDIV" scope="col" rowspan="2">{{__('Online Payment')}}</th>
                                            <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                            <th scope="col" rowspan="2">{{__('Designation')}}</th>
                                            <th scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                            <th scope="col" rowspan="2">{{__('Days')}}</th>
                                            <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT/Hrs')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                            <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                            <th scope="col" rowspan="2">{{__('Fixed OT')}}</th>
                                            <th scope="col" rowspan="2">{{__('Allownce')}}</th>
                                            <th scope="col" rowspan="2">{{__('Leave')}}</th>
                                            <th scope="col" rowspan="2">{{__('Arrear')}}</th>
                                            <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                            <th scope="col" colspan="14">{{__('DEDUCTION')}}</th>
                                            <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                            <th scope="col" rowspan="2">{{__('SIGN OF IND.')}}</th>
                                            <th scope="col" rowspan="2">{{__('Remark')}}</th>
                                            {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                        </tr>
                                        <tr>
                                            <th>Fine</th>
                                            <th>Mobile bill</th>
                                            <th>Loan</th>
                                            <th>Long Loan</th>
                                            <th>Cloth</th>
                                            <th>Jacket</th>
                                            <th>HR</th>
                                            <th>Training Cost</th>
                                            <th>C/F</th>
                                            <th>Medical</th>
                                            <th>Ins</th>
                                            <th>P/F</th>
                                            <th>Revenue Stamp</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        @foreach ($groupedData as $customerId => $branches)
                                            @foreach ($branches as $branchId => $details)
                                                <tr>
                                                    <td colspan="34">
                                                        <div class="d-flex">
                                                            <h6>{{ $details[0]->customer?->name }},</h6>
                                                            <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @forelse ($details as $d )
                                                <tr>
                                                    <td>{{ ++$loop->index }}</td>
                                                    <td>{{ $d->online_payment }}</td>
                                                    <td>{{ $d->employee?->admission_id_no }}</td>
                                                    <td>{{ $d->employee?->salary_joining_date }}</td>
                                                    <td>{{ $d->employee?->position?->name }}</td>
                                                    <td>{{ $d->employee?->en_applicants_name }}</td>
                                                    <td>

                                                        @if ($d->duty_rate != 0)
                                                        {{ round($d->duty_rate) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->duty_qty != 0)
                                                        {{ round($d->duty_qty) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->duty_amount != 0)
                                                        {{ round($d->duty_amount) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->ot_qty != 0)
                                                        {{ round($d->ot_qty) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->ot_rate != 0)
                                                        {{ round($d->ot_rate) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->ot_amount != 0)
                                                        {{ round($d->ot_amount) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->fixed_ot != 0)
                                                        {{ round($d->fixed_ot) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->allownce != 0)
                                                        {{ round($d->allownce) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->leave != 0)
                                                        {{ round($d->leave) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->arrear != 0)
                                                        {{ round($d->arrear) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->gross_salary != 0)
                                                        {{ round($d->gross_salary) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_fine != 0)
                                                        {{ round($d->deduction_fine) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_mobilebill != 0)
                                                        {{ round($d->deduction_mobilebill) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_loan != 0)
                                                        {{ round($d->deduction_loan) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_long_loan != 0)
                                                        {{ round($d->deduction_long_loan) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_cloth != 0)
                                                        {{ round($d->deduction_cloth) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_jacket != 0)
                                                        {{ round($d->deduction_jacket) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_hr != 0)
                                                        {{ round($d->deduction_hr) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_traningcost != 0)
                                                        {{ round($d->deduction_traningcost) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_c_f != 0)
                                                        {{ round($d->deduction_c_f) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_medical != 0)
                                                        {{ round($d->deduction_medical) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_ins != 0)
                                                        {{ round($d->deduction_ins) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_p_f != 0)
                                                        {{ round($d->deduction_p_f) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_revenue_stamp != 0)
                                                        {{ round($d->deduction_revenue_stamp) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->deduction_total != 0)
                                                        {{ round($d->deduction_total) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->net_salary != 0)
                                                        {{ round($d->net_salary) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $d->sing_of_ind }}</td>
                                                    <td>{{ $d->remark }}</td>
                                                    {{--  <td>
                                                        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                    </td>  --}}
                                                </tr>
                                                @empty
                                                @endforelse
                                            @endforeach
                                        @endforeach
                                    </tbody>
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

        $.get("{{route('salarysheet.salarySheetOneShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary_One-{{$getMonth}}-{{$salary->year}}');
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

