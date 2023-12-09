@extends('layout.app')

@section('pageTitle',trans('Create Job-Post'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('jobpost.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Name')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="bill_able">{{__('Bill Able')}}<span class="text-danger">*</span></label>
                                            <select name="bill_able" class="form-control @error('bill_able') is-invalid @enderror" id="bill_able">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            @if($errors->has('bill_able'))
                                                <span class="text-danger"> {{ $errors->first('bill_able') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name_bn">{{__('Name Bangla')}}</label>
                                            <input type="text" id="name_bn" class="form-control" value="{{ old('name_bn')}}" name="name_bn">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
