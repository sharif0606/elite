@extends('layout.app')

@section('pageTitle',trans('Update Job-Post'))
@section('pageSubTitle',trans('Update'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route(currentUser().'.jobpost.update',encryptor('encrypt',$jobpost->id))}}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$jobpost->id)}}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Name')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName',$jobpost->name)}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name_bn">{{__('jobpost Bangla')}}</label>
                                            <input type="text" id="name_bn" class="form-control" value="{{ old('name_bn',$jobpost->name_bn)}}" name="name_bn">
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
