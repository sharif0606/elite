@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Zone Wise Print'))
@section('pageSubTitle',trans('Print'))

@section('content')
<div>
    <form method="get" action="{{route('salarysheet.printZoneWise')}}">
        <div class="row">
            <div class="col-lg-3">
                <label for="">Year</label>
                <select required class="form-control year" name="year">
                    <option value="">Select Year</option>
                    @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}" {{ $i == request('year') ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-lg-3">
                <label for="">Month</label>
                <select required class="form-control month selected_month" name="month">
                    <option value="">Select Month</option>
                    @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}" {{ $i == request('month') ? 'selected' : '' }}>{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-lg-3">
                <label for="">Zone</label>
                <select required class="form-control month selected_month" name="zone">
                    <option value="">Select Zone</option>
                    @forelse ($zone as $z)
                    <option value="{{ $z->id }}" {{ $z->id == request('zone') ? 'selected' : '' }}>{{ $z->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-lg-3">
                <label for="">Zone</label>
                <select required class="form-control month selected_month" name="type">
                    <option value="">Select Sheet Type</option>
                    <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>Salary Sheet One</option>
                    <option value="3" {{ request('type') == 3 ? 'selected' : '' }}>Salary Sheet Three</option>
                    <option value="5" {{ request('type') == 5 ? 'selected' : '' }}>Salary Sheet Five</option>
                </select>
            </div>
            {{--<div class="col-sm-3">
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
                <option value="">Select</option>
                @forelse ($designation as $c)
                <option value="{{$c->id}}" {{request()->designation_id==$c->id?'selected':''}}>{{$c->name}}</option>
                @empty

                @endforelse
            </select>
        </div>--}}
        <div class="col-sm-3" style="margin-top: 1.4rem;">
            <button type="submit" class="btn btn-sm btn-info">Search</button>
            <a href="{{route('salarysheet.printZoneWise')}}" class="btn btn-sm btn-danger">Clear</a>
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
                                @php
                                $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                                if(isset($month)){
                                $getMonth = $mt[$month] ?? '';
                                }
                                @endphp
                                <div style="text-align: center;">
                                    <h5 class="pb-0" style="padding-top: 5px;">ELITE SECURITY SERVICES LTD</h5>
                                    <p class="text-center m-0 p-0">Houes-02,Road-02,Block-K,Halisahar H/E Chattogram</p>
                                    @if(isset($month))
                                    <p class="text-center m-0 p-0">Salary for the Month of {{$getMonth}}-{{$year}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- table bordered -->
                        <div class="row mt-4">
                            <div class="table-responsive">
                                <table id="salaryTable" class="mb-0" style="width: 1800px !important;">
                                    <thead>
                                        <tr class="text-center tbl_border">
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
                                            <th class="tbl_border">Ins</th>
                                            <th class="tbl_border">P.F</th>
                                            <th class="tbl_border">Stamp</th>
                                            <th class="tbl_border">Training Cost</th>
                                            <th class="tbl_border">Loan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="salarySheet">
                                        @if($salary->isEmpty())
                                        <tr>
                                            <td colspan="25" class="text-center">No salary data found.</td>
                                        </tr>
                                        @else
                                        @php
                                        $deductionLoanTotal = 0;
                                        $deductionTrainingTotal = 0;
                                        $payableTotal = 0;
                                        @endphp
                                        @foreach($salary as $sheet)
                                        <tr class="tbl_border">
                                            <td class="tbl_border" colspan="25">
                                                <h6 class="m-0">{{$sheet->customer->name}}</h6>
                                            </td>
                                        </tr>
                                        @foreach($sheet->customer->branch as $b)
                                        @if($sheet->details->where('branch_id', $b->id)->isNotEmpty())
                                        <tr class="tbl_border">
                                            <td class="tbl_border" colspan="25">
                                                <small class="d-block px-0"><b>{{$b->brance_name}}</b></small>
                                                @foreach($sheet->details->where('branch_id', $b->id) as $d)
                                        <tr class="text-center tbl_border">
                                            <td class="tbl_border">{{ ++$loop->parent->index }}</td>
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
                                                {{ $d->duty_qty }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->duty_amount != 0)
                                                {{ round($d->duty_amount) }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->ot_qty != 0)
                                                {{ $d->ot_qty }}
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->ot_qty != 0)
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
                                                @php $deductionTrainingTotal += $d->deduction_traningcost; @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->deduction_loan != 0)
                                                {{ round($d->deduction_loan) }}
                                                @php $deductionLoanTotal += $d->deduction_loan; @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">
                                                @if ($d->net_salary != 0)
                                                {{ $d->net_salary }}
                                                @php $payableTotal += $d->net_salary; @endphp
                                                @endif
                                            </td>
                                            <td class="tbl_border">{{ $d->sing_of_ind }}</td>
                                            <td class="tbl_border">{{ $d->sing_account }}</td>
                                            <td class="tbl_border">{{ $d->remark }}</td>
                                        </tr>
                                        @endforeach
                                        </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @endif
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