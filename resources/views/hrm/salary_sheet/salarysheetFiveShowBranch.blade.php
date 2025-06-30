@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Five View'))
@section('pageSubTitle',trans('Show'))

@section('content')
<div>
    <form method="get" action="">
        <div class="row">
            <div class="col-sm-3">
                <label for="">Customer</label>
                <select name="customer_id" id="customer_id" class="select2 form-select" onchange="getBranch(this);">
                    <option value="">Select Customer</option>
                    @forelse ($customer as $c)
                    <option value="{{$c->id}}" {{request()->customer_id==$c->id?'selected':''}}>{{$c->name}}</option>
                    @empty

                    @endforelse
                </select>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12">
                <label for="lcNo">{{__('Branch')}}</label>
                <select class="select2 form-select branch_id" id="branch_id" name="branch_id">
                    <option value="">Select Branch</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="">Designation</label>
                <select name="designation_id" class="select2 form-select">
                    <option value="">Select Customer</option>
                    @forelse ($designation as $c)
                    <option value="{{$c->id}}" {{request()->designation_id==$c->id?'selected':''}}>{{$c->name}}</option>
                    @empty

                    @endforelse
                </select>
            </div>
            <div class="col-sm-3" style="margin-top: 1.4rem;">
                <button type="submit" class="btn btn-sm btn-info">Search</button>
                <a href="{{route('salarysheet.salarySheetFiveShow',[encryptor('encrypt',$salary->id)])}}" class="btn btn-sm btn-danger">Clear</a>
            </div>
        </div>
    </form>
</div>
<section id="result_show">
    <style>
        .tbl_border {
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
                                <img class="mt-5" height="30px" width="60px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
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
                                <table id="salaryTable" class=" mb-0" style="width: 1800px !important;">
                                    <thead>
                                        <tr class="text-center tbl_border" id="">
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('SL No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2">{{__('ID No')}}</th>
                                            <th class="tbl_border" scope="col" rowspan="2" style="width: 100px !important;">{{__('Date of Joining')}}</th>
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
                                    @if (!empty($groupedAtmData))
                                    <div class="mt-5">
                                        <h4 class="text-center">ATM Staff Salary Sheet</h4>
                                    </div>
                                    @php
                                    $atmDeductionLoanTotal = 0;
                                    $atmDeductionTrainingTotal = 0;
                                    $atmPayableTotal = 0;
                                    @endphp
                                    @foreach ($groupedAtmData as $customerId => $branches)
                                    @foreach ($branches as $branchId => $details)
                                    <tr class="tbl_border">
                                        <td class="tbl_border" colspan="25">
                                            <div class="d-flex">
                                                <h6>{{ $details[0]->customer?->name }}</h6>
                                                <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->branches?->brance_name }}</b></span>
                                                <span>&nbsp;&nbsp;&nbsp;<b>{{ $details[0]->customer_atm?->atm }}</b></span>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($details as $d)
                                    <tr class="text-center tbl_border">
                                        <!-- copy your detail row here like in the main loop -->
                                        <!-- make sure to update total calculations -->
                                        <td class="tbl_border">{{ ++$loop->index }}</td>
                                        <td class="tbl_border">{{ $d->employee?->admission_id_no }}</td>
                                        <td class="tbl_border">{{ \Carbon\Carbon::parse($d->employee->salary_joining_date)->format('d-m-Y') }}</td>
                                        <td class="tbl_border">{{ $d->position?->name }}</td>
                                        <td class="tbl_border">{{ $d->employee?->en_applicants_name }}</td>
                                        <td class="tbl_border">{{ round($d->duty_rate) }}</td>
                                        <td class="tbl_border">{{ $d->duty_qty }}</td>
                                        <td class="tbl_border">{{ round($d->duty_amount) }}</td>
                                        <td class="tbl_border">{{ $d->ot_qty }}</td>
                                        <td class="tbl_border">{{ round($d->ot_rate) }}</td>
                                        <td class="tbl_border">{{ round($d->ot_amount) }}</td>
                                        <td class="tbl_border">{{ round($d->allownce) }}</td>
                                        <td class="tbl_border">{{ round($d->gross_salary) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_dress) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_fine) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_banck_charge) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_ins) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_p_f) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_revenue_stamp) }}</td>
                                        <td class="tbl_border">{{ round($d->deduction_traningcost) }}
                                            @php $atmDeductionTrainingTotal += $d->deduction_traningcost; @endphp
                                        </td>
                                        <td class="tbl_border">{{ round($d->deduction_loan) }}
                                            @php $atmDeductionLoanTotal += $d->deduction_loan; @endphp
                                        </td>
                                        <td class="tbl_border">{{ $d->net_salary }}
                                            @php $atmPayableTotal += $d->net_salary; @endphp
                                        </td>
                                        <td class="tbl_border">{{ $d->sing_of_ind }}</td>
                                        <td class="tbl_border">{{ $d->sing_account }}</td>
                                        <td class="tbl_border">{{ $d->remark }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @endforeach

                                    <!-- ATM Footer Totals -->
                                    <tr class="tbl_border">
                                        <th colspan="19" class="text-center tbl_border">ATM Total</th>
                                        <th class="tbl_border text-center">{{$atmDeductionTrainingTotal}}</th>
                                        <th class="tbl_border text-center">{{$atmDeductionLoanTotal}}</th>
                                        <th class="tbl_border text-center">{{$atmPayableTotal}}</th>
                                        <th class="tbl_border text-center">{{ $atmDeductionLoanTotal + $atmDeductionTrainingTotal + $atmPayableTotal}}</th>
                                        <th class="tbl_border"></th>
                                        <th class="tbl_border"></th>
                                    </tr>
                                    @endif
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

        $.get("{{route('salarysheet.salarySheetFiveShow',[encryptor('encrypt',$salary->id)])}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function(data) {
            $("#my-content-div").html(data);
        }).then(function() {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary General-{{$getMonth}}-{{$salary->year}}');
        });
    }
</script>
<script>
    total_calculate();

    function total_calculate() {
        var finalTotal = 0;
        $('.final_total').each(function() {
            finalTotal += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
        });
        $('.total_dp').text(parseFloat(finalTotal).toFixed(2));
    }
</script>
@endpush
{{-- @push('scripts')
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