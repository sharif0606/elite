@extends('layout.app')
@section('pageTitle','Employee Wise Training Cost Report')
@section('pageSubTitle','Training Cost Report')
@section('content')
<div class="col-12">
    <div class="card">

        <form action="{{route('report.employee_wise_training')}}">
            <div class="row mb-2">
                <div class="col-lg-2 col-sm-6">
                    <select class="form-control year" name="year">
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                            <option value="{{ $i }}" @if(request()->get('year') == $i) selected @endif>{{ $i }}</option>
                            @endfor
                    </select>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <select class="form-control month selected_month" name="month">
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                            <option value="{{ $i }}" @if(request()->get('month') == $i) selected @endif>{{ date('F',strtotime("2022-$i-01")) }}</option>
                            @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <select class="form-select employee_id select2" id="employee_id" name="employee_id">
                            <option value="">Select Employee</option>
                            @forelse ($employees as $em)
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
                </div>

                <div class="col-lg-7 col-sm-6 my-2">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-danger ms-2" href="{{route('report.employee_wise_training')}}" title="Clear">Clear</a>
                    </div>
                </div>
            </div>
        </form>

        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2">Admission ID No</th>
                        <th rowspan="2">DOJ</th>
                        <th rowspan="2">Applicant Name</th>
                        <th rowspan="2">Deposit Amount</th>
                        <th colspan="{{ count($months) + 2 }}">Total Deduction From Salary</th>
                    </tr>
                    <tr class="text-center">
                        @foreach ($months as $month)
                        <th>{{ \Carbon\Carbon::parse($month)->format('M-y') }}</th>
                        @endforeach
                        <th>Total Deduction</th>
                        <th>Remaining Due</th>
                        <th>Dues Installment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($training_cost_report as $employee_id => $reports)
                    @php
                    $employee = $reports['employee'] ?? null;
                    $total_deduction = $reports['total_deduction'] ?? 0;
                    $remaining_due = $reports['due_amount'] ?? 0;
                    $used_months = $reports['used_months'] ?? 0; // Number of used months
                    @endphp
                    <tr class="text-center">
                        <td>{{ $employee['admission_id_no'] ?? 'N/A' }}</td>
                        <td>{{ $employee['joining_date'] ?? 'N/A' }}</td>
                        <td>{{ $employee['bn_applicants_name'] ?? 'N/A' }}</td>
                        <td>{{ $employee['bn_traning_cost'] ?? 'N/A' }}</td>

                        @foreach ($months as $month)
                        @php
                        $deduction = collect($reports['deductions'])->firstWhere('month', date('m', strtotime($month)));
                        @endphp
                        <td>{{ $deduction['total_deduction'] ?? 0 }}</td>
                        @endforeach

                        <td class="fw-bold">{{ $total_deduction }}</td>
                        <td class="fw-bold">{{ $remaining_due }}</td>
                        <td class="fw-bold">{{$used_months}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($months) + 6 }}" class="text-center">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection