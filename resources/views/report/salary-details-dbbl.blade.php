@extends('layout.app')
@section('pageTitle','Salary Report')
@section('pageSubTitle','report')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Year</b></label>
                    <select required class="form-control form-select year" name="year">
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Month</b></label>
                    <select required class="form-control form-select month selected_month" name="month">
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 py-1">
                    <label for="billdate">{{__('Salary Type')}}</label>
                    <select name="type" class="form-control form-select" required>
                        <option value="">Select</option>
                        <option value="0">DBBL</option>
                        <option value="1">Others</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6 d-flex justify-content-end">
                    <button type="submit" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

