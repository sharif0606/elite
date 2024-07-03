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
                                    <table id="salaryTable" class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2">{{__('Designation')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Payment Type')}}</th>
                                                <th scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Working Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Taka')}}</th>
                                                <th scope="col" rowspan="2">{{__('Weekly Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amount')}}</th>
                                                <th scope="col" rowspan="2">{{__('HT/Ribon Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gun Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('Extra Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Arrear')}}</th>
                                                <th scope="col" rowspan="2">{{__('Bonus')}}</th>
                                                <th scope="col" rowspan="2">{{__('Donation')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="16">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Signature')}}</th>
                                                <th scope="col" rowspan="2">{{__('Zone')}}</th>
                                            </tr>
                                            <tr>
                                                <th>Mattress & Pillow Cost</th>
                                                <th>Tonic Sim</th>
                                                <th>Over Payment Cutt</th>
                                                <th>Fine</th>
                                                <th>Loan</th>
                                                <th>Long Loan</th>
                                                <th>Cloth</th>
                                                <th>HR</th>
                                                <th>Jacket</th>
                                                <th>Stamp</th>
                                                <th>Training Cost</th>
                                                <th>C/F</th>
                                                <th>Medical</th>
                                                <th>Ins</th>
                                                <th>P/F</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">
                                            @foreach ($groupedData as $customerId => $branches)
                                                @foreach ($branches as $branchId => $details)
                                                    <tr>
                                                        <td colspan="40">
                                                            <div class="d-flex">
                                                                <h6>{{ $details[0]->customer?->name }},</h6>
                                                                <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @forelse ($details as $d )
                                                    <tr>
                                                        <td>{{ ++$loop->index }}</td>
                                                        <td>{{ $d->employee?->admission_id_no }}</td>
                                                        <td>{{ $d->employee?->salary_joining_date }}</td>
                                                        <td>{{ $d->position?->name }}</td>
                                                        <td>{{ $d->employee?->en_applicants_name }}</td>
                                                        <td>{{ $d->online_payment }}</td>
                                                        <td>{{ $d->duty_rate }}</td>
                                                        <td>{{ (int)$d->duty_qty }}</td>
                                                        <td>{{ $d->duty_amount }}</td>
                                                        <td>{{ (int)$d->weekly_leave }}</td>
                                                        <td>{{ (int)$d->ot_qty }}</td>
                                                        <td>{{ $d->ot_rate }}</td>
                                                        <td>{{ $d->ot_amount }}</td>
                                                        <td>{{ $d->ht_ribon_alice }}</td>
                                                        <td>{{ $d->gun_alice }}</td>
                                                        <td>{{ $d->leave }}</td>
                                                        <td>{{ $d->extra_alice }}</td>
                                                        <td>{{ $d->arrear }}</td>
                                                        <td>{{ $d->bonus }}</td>
                                                        <td>{{ $d->donation }}</td>
                                                        <td>{{ $d->gross_salary }}</td>
                                                        <td>{{ $d->deduction_matterss_pillowCost }}</td>
                                                        <td>{{ $d->deduction_tonic_sim }}</td>
                                                        <td>{{ $d->deduction_over_paymentCut }}</td>
                                                        <td>{{ $d->deduction_fine }}</td>
                                                        <td>{{ $d->deduction_loan }}</td>
                                                        <td>{{ $d->deduction_long_loan }}</td>
                                                        <td>{{ $d->deduction_cloth }}</td>
                                                        <td>{{ $d->deduction_hr }}</td>
                                                        <td>{{ $d->deduction_jacket }}</td>
                                                        <td>{{ $d->deduction_revenue_stamp }}</td>
                                                        <td>{{ $d->deduction_traningcost }}</td>
                                                        <td>{{ $d->deduction_c_f }}</td>
                                                        <td>{{ $d->deduction_medical }}</td>
                                                        <td>{{ $d->deduction_ins }}</td>
                                                        <td>{{ $d->deduction_p_f }}</td>
                                                        <td>{{ $d->deduction_total }}</td>
                                                        <td>{{ $d->net_salary }}</td>
                                                        <td>{{ $d->sing_of_ind }}</td>
                                                        <td>{{ $d->zone }}</td>
                                                    </tr>
                                                    @empty
                                                    @endforelse
                                                @endforeach
                                            @endforeach
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
            exportReportToExcel('salaryTable', 'Salary_Two-{{$getMonth}}-{{$salary->year}}');
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

