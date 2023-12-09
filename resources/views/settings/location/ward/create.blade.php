@extends('layout.app')

@section('pageTitle',trans('Create ward'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('ward.store')}}">
                                @csrf
                                <div class="row">

                                    {{--  <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="upazila_id">Upazila<span class="text-danger">*</span></label>
                                            <select class="choices form-select" name="upazila_id" id="upazila_id">
                                                <option value="">Select Upazila</option>
                                                @forelse($upazilas as $d)
                                                    <option value="{{$d->id}}" {{ old('upazila_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No Upazila found</option>
                                                @endforelse
                                            </select>
                                            @if($errors->has('upazila_id'))
                                                <span class="text-danger"> {{ $errors->first('upazila_id') }}</span>
                                            @endif
                                        </div>
                                    </div>  --}}
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="wardName">ward Name<span class="text-danger">*</span></label>
                                            <input type="text" id="wardName" class="form-control" value="{{ old('wardName')}}" name="wardName">
                                            @if($errors->has('wardName'))
                                                <span class="text-danger"> {{ $errors->first('wardName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="wardBn">ward Bangla</label>
                                            <input type="text" id="wardBn" class="form-control" value="{{ old('wardBn')}}" name="wardBn">
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
