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
                                            <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                            <th scope="col" rowspan="2">{{__('Rank & Joining date')}}</th>
                                            <th scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th scope="col" rowspan="2">{{__('Basic')}}</th>
                                            <th scope="col" rowspan="2">{{__('House rent')}}</th>
                                            <th scope="col" rowspan="2">{{__('Medical Allowance')}}</th>
                                            <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                            <th scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT Days')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT Amt')}}</th>
                                            <th scope="col" rowspan="2">{{__('Post Allow.')}}</th>
                                            <th scope="col" rowspan="2">{{__('Fuel Bill')}}</th>
                                            <th scope="col" rowspan="2">{{__('Total Salary')}}</th>
                                            <th scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                            <th scope="col" rowspan="2">{{__('Total Payble')}}</th>
                                            <th scope="col" rowspan="2">{{__('SIG OF IND.')}}</th>
                                            <th scope="col" rowspan="2">{{__('Sing of Accounts')}}</th>
                                            <th scope="col" rowspan="2">{{__('Remarks')}}</th>
                                        </tr>
                                        <tr>
                                            <th>Excess Mobile</th>
                                            <th>fine</th>
                                            <th>Ins</th>
                                            <th>P.F</th>
                                            <th>Mess</th>
                                            <th>Loan</th>
                                            <th>Training Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        <tr>
                                            <th colspan="27">
                                                <div><h6>Office Staff Salary</h6></div>
                                            </th>
                                        </tr>
                                        @forelse ($salary->details as $d )
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $d->employee?->admission_id_no }}</td>
                                            <td>{{ $d->employee?->joining_date }}</td>
                                            <td>{{ $d->position?->name }}</td>
                                            <td>{{ $d->employee?->en_applicants_name }}</td>
                                            <td>
                                                @if ($d->duty_rate != 0)
                                                {{ $d->duty_rate }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->house_rent != 0)
                                                {{ $d->house_rent }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->medical != 0)
                                                {{ $d->medical }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->gross_salary != 0)
                                                {{ $d->gross_salary }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->duty_qty != 0)
                                                {{ $d->duty_qty }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->ot_qty != 0)
                                                {{ $d->ot_qty }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->ot_rate != 0)
                                                {{ $d->ot_rate }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->ot_amount != 0)
                                                {{ $d->ot_amount }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->allownce != 0)
                                                {{ $d->allownce }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->fuel_bill != 0)
                                                {{ $d->fuel_bill }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->total_salary_of_salary_sheet_four != 0)
                                                {{ $d->total_salary_of_salary_sheet_four }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_mobilebill != 0)
                                                {{ $d->deduction_mobilebill }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_fine != 0)
                                                {{ $d->deduction_fine }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_ins != 0)
                                                {{ $d->deduction_ins }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_p_f != 0)
                                                {{ $d->deduction_p_f }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_mess != 0)
                                                {{ $d->deduction_mess }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_loan != 0)
                                                {{ $d->deduction_loan }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->deduction_traningcost != 0)
                                                {{ $d->deduction_traningcost }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->total_payable != 0)
                                                {{ $d->total_payable }}
                                                @endif
                                            </td>
                                            <td>{{ $d->sing_of_ind }}</td>
                                            <td>{{ $d->sing_account }}</td>
                                            <td>{{ $d->remark }}</td>
                                        </tr>
                                        @empty
                                        @endforelse
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

