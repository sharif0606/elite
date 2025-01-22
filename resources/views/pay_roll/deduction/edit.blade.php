@extends('layout.app')

@section('pageTitle',trans('Update'))
@section('pageSubTitle',trans('User Wise Deduction'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                    <a class="float-start btn btn-sm bg-danger text-white" href="{{route('deduction_asign.index')}}">Return Index</a>
                </div>
                @if(Session::has('response'))
                {!!Session::get('response')['message']!!}
                @endif
                <form class="form" method="post" enctype="multipart/form-data" action="{{route('deduction_asign.update',$c->id)}}">
                    @csrf
                    @method('PATCH')
                    {{--$c--}}
                    <div class="row">
                        <div class="col-lg-4 mt-2">
                            <label for=""><b>Salary Year</b></label>
                            <select required class="form-control form-select year" name="year">
                                <option value="">Select Year</option>
                                @for($i=2023;$i<= date('Y');$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <label for=""><b>Salary Month</b></label>
                            <select required class="form-control form-select month" name="month">
                                <option value="">Select Month</option>
                                @for($i=1;$i<= 12;$i++)
                                    <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection