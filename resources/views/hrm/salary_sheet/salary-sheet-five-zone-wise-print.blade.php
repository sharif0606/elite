@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Zone Wise Print'))
@section('pageSubTitle',trans('Print'))

@section('content')
<div>
    <form method="get" action="{{route('salarysheet.printZoneWise')}}">
        <div class="row">
            <div class="col-lg-2">
                <label for="">Year</label>
                <select required class="form-control year" name="year">
                    <option value="">Select Year</option>
                    @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}" {{ $i == request('year') ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-lg-2">
                <label for="">Month</label>
                <select required class="form-control month selected_month" name="month">
                    <option value="">Select Month</option>
                    @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}" {{ $i == request('month') ? 'selected' : '' }}>{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-lg-2">
                <label for="">Zone</label>
                <select required class="form-control month selected_month" name="zone">
                    <option value="">Select Zone</option>
                    @forelse ($zone as $z)
                    <option value="{{ $z->id }}" {{ $z->id == request('zone') ? 'selected' : '' }}>{{ $z->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            {{--<div class="col-lg-2">
                <label for="">Type</label>
                <select required class="form-control month selected_month" name="type">
                    <option value="">Select Sheet Type</option>
                    <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>Salary Sheet One</option>
            <option value="3" {{ request('type') == 3 ? 'selected' : '' }}>Salary Sheet Three</option>
            <option value="5" {{ request('type') == 5 ? 'selected' : '' }}>Salary Sheet Five</option>
            </select>
        </div>
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
        </div>--}}
        <div class="col-sm-3">
            <label for="">Designation</label>
            <select name="designation_id" class="select2 form-select">
                <option value="">Select</option>
                @forelse ($designation as $c)
                <option value="{{$c->id}}" {{request()->designation_id==$c->id?'selected':''}}>{{$c->name}}</option>
                @empty

                @endforelse
            </select>
        </div>
        {{--<div class="col-lg-4">
            <div class="form-group">
                <label for="">Employee</label>
                <select class="form-select employee_id select2" id="employee_id" name="employee_id">
                    <option value="">Select Employee</option>
                    @forelse ($employee as $em)
                    <option value="{{ $em->id }}" @if(request()->get('employee_id') == $em->id) selected @endif>
                        {{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}
                    </option>
                    @empty
                    @endforelse
                </select>
                @if($errors->has('employee_id'))
                <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                @endif
            </div>
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

        th {
            color: #000;
            font-weight: bold;
        }

        td {
            color: #000;
            font-weight: 400;
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
                                    <h6 class="text-center m-0 p-0">Houes-02,Road-02,Block-K,Halisahar H/E Chattogram</h6>
                                    @if(isset($month))
                                    <p class="text-center m-0 p-0 fw-bold">Salary for the Month of {{$getMonth}}-{{$year}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- table bordered -->
                        <!-- Salary Table -->
                        <div class="row mt-4">
                            <div class="table-responsive">
                                <table id="salaryTable" class="mb-0" style="width: 1800px !important;">
                                    <thead>
                                        <tr class="text-center tbl_border">
                                            <th class="tbl_border" scope="col" rowspan="2">SL No</th>
                                            <th class="tbl_border" scope="col" rowspan="2">ID No</th>
                                            <th class="tbl_border" scope="col" rowspan="2" style="width: 100px;">Date of Joining</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Rank</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Name</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Rate of Salary</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Pre Days</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Net Salary</th>
                                            <th class="tbl_border" scope="col" rowspan="2">OT days</th>
                                            <th class="tbl_border" scope="col" rowspan="2">OT Rate</th>
                                            <th class="tbl_border" scope="col" rowspan="2">OT Taka</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Post Allowance</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Gross Salary</th>
                                            <th class="tbl_border" scope="col" colspan="8">DEDUCTION</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Total Payable Salary</th>
                                            <th class="tbl_border" scope="col" rowspan="2">SIGN OF IND.</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Sign of Account</th>
                                            <th class="tbl_border" scope="col" rowspan="2">Remark</th>
                                        </tr>
                                        <tr class="text-center tbl_border">
                                            <th class="tbl_border">Dress</th>
                                            <th class="tbl_border">Fine</th>
                                            <th class="tbl_border">Bank Charge/Exc</th>
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
                                        <!-- Customer Header -->
                                        <tr class="tbl_border">
                                            <td class="tbl_border" colspan="25">
                                                <h6 class="m-0">{{ $sheet->customer->name }}</h6>
                                            </td>
                                        </tr>

                                        <!-- Loop through Branches -->
                                        @foreach($sheet->customer->branch as $branch)
                                        @php $branchIndex = 1; @endphp
                                        @if($sheet->details->where('branch_id', $branch->id)->isNotEmpty() && $branch->zone_id == request('zone'))
                                        
                                        <tr class="tbl_border">
                                            <td class="tbl_border" colspan="25">
                                                <small><b>{{ $branch->brance_name }}{{-- $branch->zone_id --}}</b></small>
                                            </td>
                                        </tr>

                                        @foreach($sheet->details->where('branch_id', $branch->id) as $index => $detail)
                                            @php
                                            $deductionTrainingTotal += $detail->deduction_traningcost;
                                            $deductionLoanTotal += $detail->deduction_loan;
                                            $payableTotal += $detail->net_salary;
                                            @endphp
                                        @include('hrm.salary_sheet.partials.salary_row', ['index' => $branchIndex++, 'detail' => $detail])
                                        @endforeach
                                        @endif
                                        @endforeach

                                        <!-- Check for Null Branch -->
                                        @if($sheet->details->where('branch_id', null)->isNotEmpty())
                                        {{--<tr class="tbl_border">
                                            <td class="tbl_border" colspan="25">
                                                <small><b>Branch: Not Assigned</b></small>
                                            </td>
                                        </tr>--}}

                                        @foreach($sheet->details->where('branch_id', null) as $index => $detail)
                                        @include('hrm.salary_sheet.partials.salary_row', ['index' => ++$loop->parent->index, 'detail' => $detail])
                                        @endforeach
                                        @endif
                                        @endforeach
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
    
    function get_print() {
        $('.full_page').html('<div style="background:rgba(0,0,0,0.5);width:100vw; height:100vh;position:fixed; top:0; left;0"><div class="loader my-5"></div></div>');

        $.get("{{route('salarysheet.printZoneWise') }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('salaryTable', 'Salary General-{{$month}}-{{$year}}');
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