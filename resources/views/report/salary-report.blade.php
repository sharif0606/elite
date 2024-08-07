@extends('layout.app')
@section('pageTitle','Salary Report Details')
@section('pageSubTitle','report')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="{{route('report.salary_report_details')}}">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Year</b></label>
                    <select required class="form-control form-select year" name="year">
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Month</b></label>
                    <select required class="form-control form-select month selected_month" name="month">
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="billdate">{{__('Salary Type')}}</label>
                    <select name="type" class="form-control form-select" required>
                        <option value="">Select</option>
                        <option value="0">Others</option>
                        <option value="1">DBBL</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-sm btn-success btn-block mt-4">{{__('Show')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

