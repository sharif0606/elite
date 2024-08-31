@extends('layout.app')
@section('pageTitle',trans('Release Start'))
@section('pageSubTitle',trans('Start'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form action="{{route('employee.release')}}">
                    <div class="row">
                        <div class="text-center">
                            <h3 class="mb-4">Start Release</h3>
                        </div>
                        <div class="col-6">
                            <select name="employee_id" class="form-control form-select select2">
                                <option value="">Select employee</option>
                                @foreach ($employee as $e)
                                    <option value="{{$e->id}}">{{$e->bn_applicants_name}}-({{$e->admission_id_no}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-sm btn-block btn-danger">Go</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection