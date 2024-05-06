@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Four View'))
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
                                <table class="table table-bordered mb-0">
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
                                            {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
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
                                        @forelse ($salary->details as $d )
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $d->employee?->admission_id_no }}</td>
                                            <td>{{ $d->employee?->joining_date }}</td>
                                            <td>{{ $d->position?->name }}</td>
                                            <td>{{ $d->employee?->en_applicants_name }}</td>
                                            <td>{{ $d->duty_rate }}</td>
                                            <td>{{ $d->house_rent }}</td>
                                            <td>{{ $d->medical }}</td>
                                            <td>{{ $d->gross_salary }}</td>
                                            <td>{{ $d->duty_qty }}</td>
                                            <td>{{ $d->ot_qty }}</td>
                                            <td>{{ $d->ot_rate }}</td>
                                            <td>{{ $d->ot_amount }}</td>
                                            <td>{{ $d->post_allow }}</td>
                                            <td>{{ $d->fuel_bill }}</td>
                                            <td>{{ $d->total_salary }}</td>
                                            <td>{{ $d->deduction_mobilebill }}</td>
                                            <td>{{ $d->deduction_fine }}</td>
                                            <td>{{ $d->deduction_ins }}</td>
                                            <td>{{ $d->deduction_p_f }}</td>
                                            <td>{{ $d->deduction_mess }}</td>
                                            <td>{{ $d->deduction_loan }}</td>
                                            <td>{{ $d->deduction_traningcost }}</td>
                                            <td>{{ $d->total_payable }}</td>
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
    <div class="col-2">
        <button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
    </div>
</div>
@endsection
@push("scripts")
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

