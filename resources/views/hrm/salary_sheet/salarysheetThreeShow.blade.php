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
                            <div class="col-3">
                                {{$salary->customer?->name}}
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
                                            <th scope="col" rowspan="2">{{__('Rank')}}</th>
                                            <th scope="col" rowspan="2">{{__('Name')}}</th>
                                            <th scope="col" rowspan="2">{{__('Joining Date')}}</th>
                                            <th scope="col" rowspan="2">{{__('Basic')}}</th>
                                            <th scope="col" rowspan="2">{{__('House rent (50%)')}}</th>
                                            <th scope="col" rowspan="2">{{__('Medical')}}</th>
                                            <th scope="col" rowspan="2">{{__('Trans. Conve.')}}</th>
                                            <th scope="col" rowspan="2">{{__('Gross Wages')}}</th>
                                            <th scope="col" rowspan="2">{{__('Total Working Days')}}</th>
                                            <th scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                            <th scope="col" rowspan="2">{{__('Absent')}}</th>
                                            <th scope="col" rowspan="2">{{__('Vacant')}}</th>
                                            <th scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                            <th scope="col" colspan="3">{{__('Leave')}}</th>
                                            <th scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                            <th scope="col" rowspan="2">{{__('Net Wages')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT hour')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT rate(Basic*2)')}}</th>
                                            <th scope="col" rowspan="2">{{__('OT Amt.')}}</th>
                                            <th scope="col" rowspan="2">{{__('Total Payable')}}</th>
                                            <th scope="col" rowspan="2">{{__('Signature')}}</th>
                                        </tr>
                                        <tr>
                                            <th>CL</th>
                                            <th>SL</th>
                                            <th>EL</th>
                                            <th>Absent</th>
                                            <th>Vacant</th>
                                            <th>H.rent</th>
                                            <th>PF</th>
                                            <th>Adv.</th>
                                            <th>Stm</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        @forelse ($salary->details as $d )
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $d->employee?->admission_id_no }}</td>
                                            <td>{{ $d->position?->name }}</td>
                                            <td>{{ $d->employee?->en_applicants_name }}</td>
                                            <td>{{ $d->employee?->joining_date }}</td>
                                            <td>{{ $d->duty_rate }}</td>
                                            <td>{{ $d->house_rent }}</td>
                                            <td>{{ $d->medical }}</td>
                                            <td>{{ $d->trans_conve }}</td>
                                            <td>{{ $d->gross_wages }}</td>
                                            <td>{{ (int)$d->total_workingday }}</td>
                                            <td>{{ (int)$d->present_day }}</td>
                                            <td>{{ (int)$d->absent }}</td>
                                            <td>{{ (int)$d->vacant }}</td>
                                            <td>{{ (int)$d->holiday_festival }}</td>
                                            <td>{{ (int)$d->leave_cl }}</td>
                                            <td>{{ (int)$d->leave_sl }}</td>
                                            <td>{{ (int)$d->leave_el }}</td>
                                            <td>{{ $d->deduction_absent }}</td>
                                            <td>{{ $d->deduction_vacant }}</td>
                                            <td>{{ $d->deduction_hr }}</td>
                                            <td>{{ $d->deduction_p_f }}</td>
                                            <td>{{ $d->deduction_adv }}</td>
                                            <td>{{ $d->deduction_revenue_stamp }}</td>
                                            <td>{{ $d->deduction_total }}</td>
                                            <td>{{ $d->net_salary }}</td>
                                            <td>{{ $d->ot_qty }}</td>
                                            <td>{{ $d->ot_rate_basicDuble }}</td>
                                            <td>{{ $d->ot_amount }}</td>
                                            <td>{{ $d->total_payable }}</td>
                                            <td>{{ $d->sing_of_ind }}</td>
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

        $.get("{{route('salarysheet.salarySheetThreeShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary_Three-{{$getMonth}}-{{$salary->year}}');
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

