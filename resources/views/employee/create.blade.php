@extends('layout.app')
@section('pageTitle','Add Employee')
@section('pageSubTitle','New Employee')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/assets/extensions/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/pages/filepond.css') }}">
<style>
    /* Overriding styles */
    ::-webkit-input-placeholder {
        font-size: 13px !important;
    }

    :-moz-placeholder {
        /* Firefox 18- */
        font-size: 13px !important;
    }

    ::-moz-placeholder {
        /* Firefox 19+ */
        font-size: 13px !important;
    }
</style>
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('employee.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h5 class="text-center m-0">এলিট সিকিউরিটি সার্ভিস লিমিটেড</h5>
                </div>
                <div class="row d-flex justify-content-end">
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-header p-1">
                                <h5 class="card-title">Photo</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <!-- Basic file uploader -->
                                    <input type="file" class="" name="profile_img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 class="text-center my-3">জীবন বৃন্তান্ত/ব্যাক্তিগত বিবরণ/তথ্যাদি</h6>
                    <h6 class="border-bottom my-2">বাংলা</h6>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">আবেদনকারীর নাম<span class="text-danger">*</span></label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_applicants_name')}}" class="form-control @error('bn_applicants_name') is-invalid @enderror" placeholder="" name="bn_applicants_name">
                            @if($errors->has('bn_applicants_name'))
                                <span class="text-danger"> {{ $errors->first('bn_applicants_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="admission_id_no">ভর্তিরপর আইডি নং<span class="text-danger">*</span></label>
                            <input type="text" id="admission_id_no" value="{{old('admission_id_no')}}" class="form-control @error('admission_id_no') is-invalid @enderror" placeholder="" name="admission_id_no">
                            @if($errors->has('admission_id_no'))
                            <span class="text-danger"> {{ $errors->first('admission_id_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_fathers_name">পিতার নাম</label>
                            <input type="text" id="bn_fathers_name" value="{{old('bn_fathers_name')}}" class="form-control" placeholder="" name="bn_fathers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_mothers_name">মাতার নাম</label>
                            <input type="text" id="bn_mothers_name" value="{{old('bn_mothers_name')}}" class="form-control" placeholder="" name="bn_mothers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_jobpost_id">আবেদিত পদ<span class="text-danger">*</span></label>
                            <select name="bn_jobpost_id" class=" form-control @error('bn_jobpost_id') is-invalid @enderror" id="bn_jobpost_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($jobposts as $d)
                                    @if ($d->name_bn != '')
                                    <option value="{{$d->id}}" {{ old('bn_jobpost_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                    @else
                                    <option value="{{$d->id}}" {{ old('bn_jobpost_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                    @endif
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_jobpost_id'))
                                <span class="text-danger"> {{ $errors->first('bn_jobpost_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="joining_date">যোগদানের তারিখ</label>
                            <input type="date" id="joining_date" value="{{old('joining_date')}}" class="form-control" placeholder="Joining Date" name="joining_date">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">স্বামীর নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_husband_name')}}" class="form-control" placeholder="" name="bn_husband_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">স্ত্রীর নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_spouse_name')}}" class="form-control" placeholder="" name="bn_spouse_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">ছেলের নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_son_name')}}" class="form-control" placeholder="" name="bn_son_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">মেয়ের নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_daughter_name')}}" class="form-control" placeholder="" name="bn_daughter_name">
                        </div>
                    </div>  --}}
                </div>
                <div class="row mt-2">
                    <h6 class="">স্থায়ী ঠিকানা </h6>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_district_id">জেলা</label>
                            <select onchange="show_upazila(this.value)" name="bn_parm_district_id" class="choices form-control js-example-basic-single @error('bn_parm_district_id') is-invalid @enderror" id="bn_parm_district_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ old('bn_parm_district_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No Country found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_parm_district_id'))
                                <span class="text-danger"> {{ $errors->first('bn_parm_district_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_upazila_id">উপজেলা</label>
                            <select onchange="show_unions(this.value)" name="bn_parm_upazila_id" class=" form-control js-example-basic-single @error('bn_parm_upazila_id') is-invalid @enderror" id="bn_parm_upazila_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($upazila as $d)
                                <option class="district district{{$d->district_id}}" value="{{$d->id}}" {{ old('bn_parm_upazila_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_parm_upazila_id'))
                                <span class="text-danger"> {{ $errors->first('bn_parm_upazila_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_union_id">ইউনিয়ন</label>
                            <select name="bn_parm_union_id" class="form-control @error('bn_parm_union_id') is-invalid @enderror" id="bn_parm_union_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($union as $u)
                                <option class="upazila upazila{{$u->upazila_id}}" value="{{$u->id}}" {{ old('bn_parm_union_id')==$u->id?"selected":""}}> {{ $u->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_parm_union_id'))
                                <span class="text-danger"> {{ $errors->first('bn_parm_union_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_ward_id">ওয়ার্ড নং</label>
                            <select name="bn_parm_ward_id" class=" form-control js-example-basic-single @error('bn_parm_ward_id') is-invalid @enderror" id="bn_parm_ward_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($ward as $d)
                                <option value="{{$d->id}}" {{ old('bn_ward_name')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_parm_ward_id'))
                            <span class="text-danger"> {{ $errors->first('bn_parm_ward_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_holding_name">হোল্ডিং নং</label>
                            <input type="text" id="bn_parm_holding_name" value="{{old('bn_parm_holding_name')}}" class="form-control @error('bn_parm_holding_name') is-invalid @enderror" placeholder="হোল্ডিং নং" name="bn_parm_holding_name">
                            @if($errors->has('bn_parm_holding_name'))
                            <span class="text-danger"> {{ $errors->first('bn_parm_holding_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_village_name">গ্রামের নাম</label>
                            <input type="text" id="bn_parm_village_name" value="{{old('bn_parm_village_name')}}" class="form-control @error('bn_parm_village_name') is-invalid @enderror" placeholder="গ্রামের নাম" name="bn_parm_village_name">
                            @if($errors->has('bn_parm_village_name'))
                            <span class="text-danger"> {{ $errors->first('bn_parm_village_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_post_ofc">পোঃ</label>
                            <input type="text" id="bn_parm_post_ofc" value="{{old('bn_parm_post_ofc')}}" class="form-control @error('bn_parm_post_ofc') is-invalid @enderror" placeholder="পোঃ" name="bn_parm_post_ofc">
                            @if($errors->has('bn_parm_post_ofc'))
                            <span class="text-danger"> {{ $errors->first('bn_parm_post_ofc') }}</span>
                            @endif
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_thana_id">থানা</label>
                            <select name="bn_pre_thana_id" class="form-control js-example-basic-single" id="bn_pre_thana_id">
                                <option value="">Select Thana</option>
                                <option value="1">Panchlaish</option>
                                <option value="2">Halishahar</option>
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_phone_my">মোবাইল নং নিজ</label>
                            <input type="text" id="bn_parm_phone_my" value="{{old('bn_parm_phone_my')}}" class="form-control" placeholder="মোবাইল নং নিজ" name="bn_parm_phone_my">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_phone_alt">মোবাইল নং বিকল্প</label>
                            <input type="text" id="bn_parm_phone_alt" value="{{old('bn_parm_phone_alt')}}" class="form-control" placeholder="মোবাইল নং বিকল্প" name="bn_parm_phone_alt">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <h6 class="">বর্তমান ঠিকানা </h6>
                    <p>যদি স্থায়ী ও বর্তমান ঠিকানা একই হলে চেক দিন<input class="ms-2" type="checkbox" id="copyCheckbox" onclick="copyAddress();"></p>

                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_district_id">জেলা</label>
                            <select onchange="show_upazila(this.value)" name="bn_pre_district_id" class=" form-control js-example-basic-single @error('bn_pre_district_id') is-invalid @enderror" id="bn_pre_district_id">
                                <option value="">Select Discrict</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ old('bn_pre_district_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No Country found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_pre_district_id'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_district_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_upazila_id">উপজেলা</label>
                            <select onchange="show_unions(this.value)" name="bn_pre_upazila_id" class="form-control js-example-basic-single @error('bn_pre_upazila_id') is-invalid @enderror" id="bn_pre_upazila_id">
                                <option value="">Select Upazila</option>
                                @forelse($upazila as $d)
                                <option class="district district{{$d->district_id}}" value="{{$d->id}}" {{ old('bn_pre_upazila_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_pre_upazila_id'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_upazila_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_union_id">ইউনিয়ন</label>
                            <select name="bn_pre_union_id" class="form-control js-example-basic-single" id="bn_pre_union_id">
                                <option value="">Select Union</option>
                                @forelse($union as $u)
                                <option class="upazila upazila{{$u->upazila_id}} @error('bn_pre_union_id') is-invalid @enderror" value="{{$u->id}}" {{ old('bn_pre_union_id')==$u->id?"selected":""}}> {{ $u->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_pre_union_id'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_union_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_ward_no">ওয়ার্ড নং</label>
                            <select name="bn_pre_ward_no" class=" form-control @error('bn_pre_ward_no') is-invalid @enderror" id="bn_pre_ward_no">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($ward as $d)
                                <option value="{{$d->id}}" {{ old('bn_pre_ward_no')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_pre_ward_no'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_ward_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_holding_no">হোল্ডিং নং</label>
                            <input type="text" id="bn_pre_holding_no" value="{{old('bn_pre_holding_no')}}" class="form-control @error('bn_pre_holding_no') is-invalid @enderror" placeholder="হোল্ডিং নং" name="bn_pre_holding_no">
                            @if($errors->has('bn_pre_holding_no'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_holding_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_village_name">গ্রামের নাম</label>
                            <input type="text" id="bn_pre_village_name" value="{{old('bn_pre_village_name')}}" class="form-control @error('bn_pre_village_name') is-invalid @enderror" placeholder="গ্রামের নাম" name="bn_pre_village_name">
                            @if($errors->has('bn_pre_village_name'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_village_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_pre_post_ofc">পোঃ</label>
                            <input type="text" id="bn_pre_post_ofc" value="{{old('bn_pre_post_ofc')}}" class="form-control @error('bn_pre_post_ofc') is-invalid @enderror" placeholder="পোঃ" name="bn_pre_post_ofc">
                            @if($errors->has('bn_pre_post_ofc'))
                                <span class="text-danger"> {{ $errors->first('bn_pre_post_ofc') }}</span>
                            @endif
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">থানা</label>
                            <select name="bn_prem_thana_id" class="form-control js-example-basic-single" id="bn_prem_thana_id">
                                <option value="">Select Thana</option>
                                <option value="1">Panchlaish</option>
                                <option value="2">Halishahar</option>
                            </select>
                        </div>
                    </div>  --}}
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_identification_mark">সনাক্তকরণ চিহ্ন</label>
                            <input type="text" id="bn_identification_mark" value="{{old('bn_identification_mark')}}" class="form-control @error('bn_identification_mark') is-invalid @enderror" placeholder="" name="bn_identification_mark">
                            @if($errors->has('bn_identification_mark'))
                                <span class="text-danger"> {{ $errors->first('bn_identification_mark') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_edu_qualification">শিক্ষাগতা যোগ্যতা</label>
                            <input type="text" id="bn_edu_qualification" value="{{old('bn_edu_qualification')}}" class="form-control @error('bn_edu_qualification') is-invalid @enderror" placeholder="" name="bn_edu_qualification">
                            @if($errors->has('bn_edu_qualification'))
                                <span class="text-danger"> {{ $errors->first('bn_edu_qualification') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_blood_id">রক্তের গ্রুপ</label>
                            <select name="bn_blood_id" class="form-control js-example-basic-single" id="bn_blood_id">
                                <option value="" selected>নির্বাচন করুন</option>
                                @forelse($bloods as $b)
                                <option value="{{$b->id}}" {{ old('bn_blood_id')==$b->id?"selected":""}}> {{ $b->name_bn}}</option>
                                @empty
                                    <option value="">No Blood found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_dob">জন্ম তারিখ</label>
                            <input type="date" id="bn_dob" value="{{old('bn_dob')}}" class="form-control" placeholder="" name="bn_dob">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_age">বয়স</label>
                            <input readonly type="text" id="bn_age" value="{{old('bn_age')}}" class="form-control" placeholder="" name="bn_age">
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_birth_certificate">জন্ম নিবন্ধন নং</label>
                            <input type="text" id="bn_birth_certificate" value="{{old('bn_birth_certificate')}}" class="form-control @error('bn_birth_certificate') is-invalid @enderror" placeholder="জন্ম নিবন্ধন নং" name="bn_birth_certificate">
                            @if($errors->has('bn_birth_certificate'))
                                <span class="text-danger"> {{ $errors->first('bn_birth_certificate') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_nid_no">জাতীয় পরিচয়পত্র নং</label>
                            <input type="text" id="bn_nid_no" value="{{old('bn_nid_no')}}" class="form-control" placeholder="জাতীয় পরিচয়পত্র নং" name="bn_nid_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_nationality">জাতীয়তা</label>
                            <input type="text" id="bn_nationality" value="{{old('bn_nationality','বাংলাদেশী')}}" class="form-control @error('bn_nationality') is-invalid @enderror" placeholder="" name="bn_nationality">
                            @if($errors->has('bn_nationality'))
                                <span class="text-danger"> {{ $errors->first('bn_nationality') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_religion">ধর্ম</label>
                            <select name="bn_religion" class="form-control js-example-basic-single @error('bn_religion') is-invalid @enderror" id="bn_religion">
                                <option value="">Select</option>
                                @forelse($religions as $r)
                                <option value="{{$r->id}}" {{ old('bn_religion')==$r->id?"selected":""}}> {{ $r->name_bn}}</option>
                                @empty
                                    <option value="">No Blood found</option>
                                @endforelse
                            </select>
                            @if($errors->has('bn_religion'))
                                <span class="text-danger"> {{ $errors->first('bn_religion') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group mt-3">
                            <label for="bn_experience">উচ্চতা</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_height_foot">ফুট</label>
                            <input type="text" id="bn_height_foot" value="{{old('bn_height_foot')}}" class="form-control" placeholder="" name="bn_height_foot">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_height_inc">ইঞ্চি</label>
                            <input type="text" id="bn_height_inc" value="{{old('bn_height_inc')}}" class="form-control" placeholder="" name="bn_height_inc">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group mt-3">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group mt-3">
                            <label for="bn_experience">ওজন</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_weight_kg">কেজি</label>
                            <input type="text" id="bn_weight_kg" value="{{old('bn_weight_kg')}}" class="form-control" placeholder="" name="bn_weight_kg">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_weight_pounds">পাউন্ড</label>
                            <input type="text" id="bn_weight_pounds" value="{{old('bn_weight_pounds')}}" class="form-control" placeholder="" name="bn_weight_pounds">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_experience">অভিজ্ঞতা</label>
                            <input type="text" id="bn_experience" value="{{old('bn_experience')}}" class="form-control" placeholder="" name="bn_experience">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_marital_status">বৈবাহিক অবস্থা</label>
                            <select name="bn_marital_status" class="form-control js-example-basic-single @error('bn_marital_status') is-invalid @enderror" onclick="getMarriedInfo()" id="bn_marital_status">
                                <option value="1">অবিবাহিত</option>
                                <option value="2">বিবাহিত</option>
                            </select>
                            @if($errors->has('bn_marital_status'))
                                <span class="text-danger"> {{ $errors->first('bn_marital_status') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none bn_spouse_name1" id="bn_spouse_name1">
                        <div class="form-group">
                            <label for="bn_spouse_name">স্বামী/স্ত্রীর নাম</label>
                            <input type="text" id="bn_spouse_name" value="{{old('bn_spouse_name')}}" class="form-control" placeholder="" name="bn_spouse_name">
                        </div>
                    </div>
                </div>
                <div class="row Repeter d-none children_data" id="children_data">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_song_name">ছেলের নাম</label>
                            <input type="text" id="bn_song_name" value="{{old('bn_song_name')}}" class="form-control" placeholder="ছেলের নাম" name="bn_song_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_daughters_name">মেয়ের নাম</label>
                            <input type="text" id="bn_daughters_name" value="{{old('bn_daughters_name')}}" class="form-control" placeholder="মেয়ের নাম" name="bn_daughters_name">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 ps-0">
                        <div class="form-group text-primary mt-3" style="font-size:1.3rem">
                            {{--  <span onClick='SongsRepeter(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                             {{--  <span onClick='newSongsRepeter(this);'><i class="bi bi-plus-square-fill"></i></span>  --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_legacy_name">উত্তরাধীকারী এর নাম</label>
                            <input type="text" id="bn_legacy_name" value="{{old('bn_legacy_name')}}" class="form-control" placeholder="উত্তরাধীকারী এর নাম" name="bn_legacy_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_legacy_relation">সম্পর্ক</label>
                            <input type="text" id="bn_legacy_relation" value="{{old('bn_legacy_relation')}}" class="form-control" placeholder="সম্পর্ক" name="bn_legacy_relation">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_reference_admittee">ভর্তিকারীর সুপারিশ/রেফারেন্স নাম</label>
                            <input type="text" id="bn_reference_admittee" value="{{old('bn_reference_admittee')}}" class="form-control @error('bn_reference_admittee') is-invalid @enderror" placeholder="ভর্তিকারীর সুপারিশ/রেফারেন্স নাম" name="bn_reference_admittee">
                            @if($errors->has('bn_reference_admittee'))
                                <span class="text-danger"> {{ $errors->first('bn_reference_admittee') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_reference_adm_phone">মোবাইল</label>
                            <input type="text" id="bn_reference_adm_phone" value="{{old('bn_reference_adm_phone')}}" class="form-control  @error('bn_reference_adm_phone') is-invalid @enderror" placeholder="মোবাইল" name="bn_reference_adm_phone">
                            @if($errors->has('bn_reference_adm_phone'))
                                <span class="text-danger"> {{ $errors->first('bn_reference_adm_phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 d-none">
                        <div class="form-group">
                            <label for="bn_reference_adm_adress">ঠিকানা</label>
                            <input type="text" id="bn_reference_adm_adress" value="{{old('bn_reference_adm_adress')}}" class="form-control @error('bn_reference_adm_adress') is-invalid @enderror" placeholder="ঠিকানা" name="bn_reference_adm_adress">
                            @if($errors->has('bn_reference_adm_adress'))
                                <span class="text-danger"> {{ $errors->first('bn_reference_adm_adress') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_addmit_post">ভর্তিকৃত পোষ্টের নাম</label>
                            <input type="text" id="bn_addmit_post" value="{{old('bn_addmit_post')}}" class="form-control @error('bn_addmit_post') is-invalid @enderror" placeholder="ভর্তিকৃত পোষ্টের নাম" name="bn_addmit_post">
                            @if($errors->has('bn_addmit_post'))
                                <span class="text-danger"> {{ $errors->first('bn_addmit_post') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_post_allowance">পোস্ট এলাউন্স</label>
                            <input type="text" id="bn_post_allowance" value="{{old('bn_post_allowance')}}" class="form-control @error('bn_post_allowance') is-invalid @enderror" placeholder="পোস্ট এলাউন্স" name="bn_post_allowance">
                            @if($errors->has('bn_post_allowance'))
                                <span class="text-danger"> {{ $errors->first('bn_post_allowance') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_traning_cost">ট্রেনিং ফি</label>
                            <input type="text" id="bn_traning_cost" value="{{old('bn_traning_cost')}}" class="form-control @error('bn_traning_cost') is-invalid @enderror" placeholder="ট্রেনিং খরচ" name="bn_traning_cost">
                            @if($errors->has('bn_traning_cost'))
                                <span class="text-danger"> {{ $errors->first('bn_traning_cost') }}</span>
                            @endif
                            <input type="hidden" id="bn_traning_cost_byMonth" value="6" class="form-control @error('bn_traning_cost_byMonth') is-invalid @enderror" placeholder="ট্রেনিং খরচ মাস" name="bn_traning_cost_byMonth">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_traning_cost_byMonth">ট্রেনিং খরচ মাস</label>
                            <input type="text" id="bn_traning_cost_byMonth" value="{{old('bn_traning_cost_byMonth')}}" class="form-control @error('bn_traning_cost_byMonth') is-invalid @enderror" placeholder="ট্রেনিং খরচ মাস" name="bn_traning_cost_byMonth">
                            @if($errors->has('bn_traning_cost_byMonth'))
                                <span class="text-danger"> {{ $errors->first('bn_traning_cost_byMonth') }}</span>
                            @endif
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_bank_name">ব্যাংক নাম</label>
                            <input type="text" id="bn_bank_name" value="{{old('bn_bank_name')}}" class="form-control @error('bn_bank_name') is-invalid @enderror" placeholder="ব্যাংক নাম" name="bn_bank_name">
                            @if($errors->has('bn_bank_name'))
                                <span class="text-danger"> {{ $errors->first('bn_bank_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_brance_name">ব্রাঞ্চ নাম</label>
                            <input type="text" id="bn_brance_name" value="{{old('bn_brance_name')}}" class="form-control @error('bn_brance_name') is-invalid @enderror" placeholder="ব্যাংক নাম" name="bn_brance_name">
                            @if($errors->has('bn_brance_name'))
                                <span class="text-danger"> {{ $errors->first('bn_brance_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_ac_no">একাউন্ট নং</label>
                            <input type="text" id="bn_ac_no" value="{{old('bn_ac_no')}}" class="form-control @error('bn_ac_no') is-invalid @enderror" placeholder="ব্যাংক নাম" name="bn_ac_no">
                            @if($errors->has('bn_ac_no'))
                                <span class="text-danger"> {{ $errors->first('bn_ac_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_routing_number">রাউটিং নাম</label>
                            <input type="text" id="bn_routing_number" value="{{old('bn_routing_number')}}" class="form-control @error('bn_routing_number') is-invalid @enderror" placeholder="ব্যাংক নাম" name="bn_routing_number">
                            @if($errors->has('bn_routing_number'))
                                <span class="text-danger"> {{ $errors->first('bn_routing_number') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p>প্রত্যয়ন পত্রের জন্য:</p>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_cer_gender">লিঙ্গ:</label>
                            <input type="radio" id="ma" name="bn_cer_gender" value="0">
                            <label for="ma">পুরুষ</label>
                            <input type="radio" id="fe" name="bn_cer_gender" value="1">
                            <label for="fe">মহিলা</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_cer_physical_ability">দৈহিক সক্ষমতা</label>
                            <input type="text" id="bn_cer_physical_ability" value="{{old('bn_cer_physical_ability')}}" class="form-control" placeholder="দৈহিক সক্ষমতা" name="bn_cer_physical_ability">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="concerned_person_sign">সংশ্লিষ্ট ব্যক্তির স্বক্ষর</label>
                            <input type="file" id="concerned_person_sign" value="{{old('concerned_person_sign')}}" class="form-control" placeholder="সংশ্লিষ্ট ব্যক্তির স্বক্ষর" name="concerned_person_sign">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_doctor_sign">রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</label>
                            <input type="file" id="bn_doctor_sign" value="{{old('bn_doctor_sign')}}" class="form-control" placeholder="রেজিস্টার্ড চিকিৎসকের স্বাক্ষর" name="bn_doctor_sign">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="emtype">Employee Type</label>
                            <select name="employee_type" class="form-control @error('employee_type') is-invalid @enderror" onclick="getEmpInfo()" id="employee_type">
                                <option value="1">Other Staff</option>
                                <option value="2">Office Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none desig" id="desig">
                        <div class="form-group">
                            <label for="designation_id">Designation</label>
                            <select name="designation_id" class=" form-control @error('designation_id') is-invalid @enderror" id="designation_id">
                                <option value="">নির্বাচন করুন</option>
                                @forelse($jobposts as $d)
                                    @if ($d->name_bn != null)
                                        <option value="{{$d->id}}" {{ old('designation_id')==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                    @else
                                        <option value="{{$d->id}}" {{ old('designation_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                    @endif
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none gsalary">
                        <div class="form-group">
                            <label for="gsalary">Gross Salary</label>
                            <input type="text" id="gsalary" value="{{old('gsalary')}}" class="form-control" placeholder="" name="gsalary">
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none otsalary">
                        <div class="form-group">
                            <label for="otsalary">Ot Salary</label>
                            <input type="text" id="otsalary" value="{{old('otsalary')}}" class="form-control" placeholder="" name="otsalary">
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none serialNo">
                        <div class="form-group">
                            <label for="serial">Salary Serial</label>
                            <input type="number" id="serialNo" value="{{old('salary_serial')}}" class="form-control" placeholder="" name="salary_serial">
                        </div>
                    </div>
                </div>
{{--  English  --}}
                <div class="row">
                    <h6 class="text-center my-3">Curriculum vitae/personal details/details</h6>
                    <h6 class="border-bottom my-2">English</h6>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_applicants_name">Applicant's Name</label>
                            <input type="text" id="en_applicants_name" value="{{old('en_applicants_name')}}" class="form-control" placeholder="" name="en_applicants_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_fathers_name">Father's name</label>
                            <input type="text" id="en_fathers_name" value="{{old('en_fathers_name')}}" class="form-control" placeholder="" name="en_fathers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_mothers_name">Mather's Name</label>
                            <input type="text" id="en_mothers_name" value="{{old('en_mothers_name')}}" class="form-control" placeholder="" name="en_mothers_name">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <h6 class="">Permanent Address </h6>
                </div>
                <div class="row">
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_district_id">District</label>
                            <select onchange="show_upazila(this.value)" name="en_parm_district_id" class="choices form-control js-example-basic-single" id="en_parm_district_id">
                                <option value="">select</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ old('en_parm_district_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No Country found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_upazila_id">Upazila</label>
                            <select onchange="show_unions(this.value)" name="en_parm_upazila_id" class=" form-control js-example-basic-single" id="en_parm_upazila_id">
                                <option value="">select</option>
                                @forelse($upazila as $d)
                                <option class="district district{{$d->district_id}}" value="{{$d->id}}" {{ old('en_parm_upazila_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_union_id">Union</label>
                            <select name="en_parm_union_id" class=" form-control" id="en_parm_union_id">
                                <option value="">select</option>
                                @forelse($union as $u)
                                <option class="upazila upazila{{$u->upazila_id}}" value="{{$u->id}}" {{ old('en_parm_union_id')==$u->id?"selected":""}}> {{ $u->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_ward_id">Ward no</label>
                            <select name="en_parm_ward_id" class=" form-control js-example-basic-single" id="en_parm_ward_id">
                                <option value="">select</option>
                                @forelse($ward as $d)
                                <option value="{{$d->id}}" {{ old('en_ward_name')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_holding_name">Holding no</label>
                            <input type="text" id="en_parm_holding_name" value="{{old('en_parm_holding_name')}}" class="form-control" placeholder="Holding no" name="en_parm_holding_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_village_name">village Name</label>
                            <input type="text" id="en_parm_village_name" value="{{old('en_parm_village_name')}}" class="form-control" placeholder="village Name" name="en_parm_village_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_post_ofc">Po:</label>
                            <input type="text" id="en_parm_post_ofc" value="{{old('en_parm_post_ofc')}}" class="form-control" placeholder="Po:" name="en_parm_post_ofc">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_thana_id">Thana</label>
                            <select name="en_pre_thana_id" class="form-control js-example-basic-single" id="en_pre_thana_id">
                                <option value="">Select Thana</option>
                                <option value="1">Panchlaish</option>
                                <option value="2">Halishahar</option>
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_phone_my">Mobile no</label>
                            <input type="text" id="en_parm_phone_my" value="{{old('en_parm_phone_my')}}" class="form-control" placeholder="Mobile No" name="en_parm_phone_my">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_parm_phone_alt">Mobile No. Alter</label>
                            <input type="text" id="en_parm_phone_alt" value="{{old('en_parm_phone_alt')}}" class="form-control" placeholder="Mobile no Alt" name="en_parm_phone_alt">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <h6 class="">Prensent Address </h6>
                    {{--  <p>Check if permanent and current address are same<input class="ms-2" type="checkbox" id="copyCheckbox" onclick="copyAddress();"></p>  --}}

                </div>
                <div class="row">
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_district_id">District</label>
                            <select onchange="show_upazila(this.value)" name="en_pre_district_id" class=" form-control js-example-basic-single" id="en_pre_district_id">
                                <option value="">Select Discrict</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ old('en_pre_district_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No Country found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_upazila_id">Upazila</label>
                            <select onchange="show_unions(this.value)" name="en_pre_upazila_id" class="form-control js-example-basic-single" id="en_pre_upazila_id">
                                <option value="">Select Upazila</option>
                                @forelse($upazila as $d)
                                <option class="district district{{$d->district_id}}" value="{{$d->id}}" {{ old('en_pre_upazila_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_union_id">Union</label>
                            <select name="en_pre_union_id" class="form-control js-example-basic-single" id="en_pre_union_id">
                                <option value="">Select Union</option>
                                @forelse($union as $u)
                                <option class="upazila upazila{{$u->upazila_id}}" value="{{$u->id}}" {{ old('en_pre_union_id')==$u->id?"selected":""}}> {{ $u->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_ward_no">Ward no</label>
                            <select name="en_pre_ward_id" class=" form-control" id="en_pre_ward_no">
                                <option value="">Select</option>
                                @forelse($ward as $d)
                                <option value="{{$d->id}}" {{ old('en_pre_ward_no')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_holding_no">Holding no</label>
                            <input type="text" id="en_pre_holding_no" value="{{old('en_pre_holding_no')}}" class="form-control" placeholder="Holding no" name="en_pre_holding_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_village_name">village name</label>
                            <input type="text" id="en_pre_village_name" value="{{old('en_pre_village_name')}}" class="form-control" placeholder="village name" name="en_pre_village_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_pre_post_ofc">Po:</label>
                            <input type="text" id="en_pre_post_ofc" value="{{old('en_pre_post_ofc')}}" class="form-control" placeholder="Po:" name="en_pre_post_ofc">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_applicants_name">Thana</label>
                            <select name="en_prem_thana_id" class="form-control js-example-basic-single" id="en_prem_thana_id">
                                <option value="">Select Thana</option>
                                <option value="1">Panchlaish</option>
                                <option value="2">Halishahar</option>
                            </select>
                        </div>
                    </div>  --}}
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_identification_mark">Identification mark</label>
                            <input type="text" id="en_identification_mark" value="{{old('en_identification_mark')}}" class="form-control" placeholder="" name="en_identification_mark">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_edu_qualification">Educational qualification</label>
                            <input type="text" id="en_edu_qualification" value="{{old('en_edu_qualification')}}" class="form-control" placeholder="" name="en_edu_qualification">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_blood_id">Blood Group</label>
                            <select name="en_blood_id" class="form-control js-example-basic-single" id="en_blood_id">
                                <option value="" selected>Select</option>
                                @forelse($bloods as $b)
                                <option value="{{$b->id}}" {{ old('en_blood_id')==$b->id?"selected":""}}> {{ $b->name}}</option>
                                @empty
                                    <option value="">No Blood found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>  --}}
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_dob">Date of Birth</label>
                            <input type="date" id="en_dob" value="{{old('en_dob')}}" class="form-control" placeholder="" name="en_dob">
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_age">Age</label>
                            <input readonly type="text" id="en_age" value="{{old('en_age')}}" class="form-control" placeholder="" name="en_age">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_birth_certificate">Birth Registration No</label>
                            <input type="text" id="en_birth_certificate" value="{{old('en_birth_certificate')}}" class="form-control" placeholder="" name="en_birth_certificate">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_nid_no">National Identity Card No</label>
                            <input type="text" id="en_nid_no" value="{{old('en_nid_no')}}" class="form-control" placeholder="" name="en_nid_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_nationality">Nationality</label>
                            <input type="text" id="en_nationality" value="{{old('en_nationality','Bangladeshi')}}" class="form-control" placeholder="" name="en_nationality">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_religion">Religion</label>
                            <select name="en_religion" class="form-control js-example-basic-single" id="en_religion">
                                <option value="">Select</option>
                                @forelse($religions as $r)
                                <option value="{{$r->id}}" {{ old('en_religion')==$r->id?"selected":""}}> {{ $r->name}}</option>
                                @empty
                                    <option value="">No Blood found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-2 col-6">
                        <div class="form-group mt-3">
                            <label for="en_experience">Height</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="en_height_foot">Foot</label>
                            <input type="text" id="en_height_foot" value="{{old('en_height_foot')}}" class="form-control" placeholder="" name="en_height_foot">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="en_height_inc">Inch</label>
                            <input type="text" id="en_height_inc" value="{{old('en_height_inc')}}" class="form-control" placeholder="" name="en_height_inc">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group mt-3">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group mt-3">
                            <label for="en_experience">weight</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="en_weight_kg">Kg</label>
                            <input type="text" id="en_weight_kg" value="{{old('en_weight_kg')}}" class="form-control" placeholder="" name="en_weight_kg">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="en_weight_pounds">Pound</label>
                            <input type="text" id="en_weight_pounds" value="{{old('en_weight_pounds')}}" class="form-control" placeholder="" name="en_weight_pounds">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="en_experience">Experience</label>
                            <input type="text" id="en_experience" value="{{old('en_experience')}}" class="form-control" placeholder="" name="en_experience">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_marital_status">Marital Status</label>
                            <select name="en_marital_status" class="form-control js-example-basic-single" onclick="engetMarriedInfo()" id="en_marital_status">
                                <option value="1">Unmarried</option>
                                <option value="2">Married</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-none en_spouse_name1" id="en_spouse_name1">
                        <div class="form-group">
                            <label for="en_spouse_name">Spouse Name</label>
                            <input type="text" id="en_spouse_name" value="{{old('en_spouse_name')}}" class="form-control" placeholder="" name="en_spouse_name">
                        </div>
                    </div>
                </div>
                <div class="row Repeter d-none echildren_data" id="echildren_data">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_song_name">Son's name</label>
                            <input type="text" id="en_song_name" value="{{old('en_song_name')}}" class="form-control" placeholder="son's Name" name="en_song_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_daughters_name">Girl's name</label>
                            <input type="text" id="en_daughters_name" value="{{old('en_daughters_name')}}" class="form-control" placeholder="Douthters name" name="en_daughters_name">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 ps-0">
                        <div class="form-group text-primary mt-3" style="font-size:1.3rem">
                            {{--  <span onClick='SongsRepeter(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                             {{--  <span onClick='newSongsRepeter(this);'><i class="bi bi-plus-square-fill"></i></span>  --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_legacy_name">Name of Successor</label>
                            <input type="text" id="en_legacy_name" value="{{old('en_legacy_name')}}" class="form-control" placeholder="Name of Successor" name="en_legacy_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_legacy_relation">Relationship</label>
                            <input type="text" id="en_legacy_relation" value="{{old('en_legacy_relation')}}" class="form-control" placeholder="Relationship" name="en_legacy_relation">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_reference_admittee">Name Of Recommendation/Reference Of Admitted</label>
                            <input type="text" id="en_reference_admittee" value="{{old('en_reference_admittee')}}" class="form-control" placeholder="NAME OF RECOMMENDATION/REFERENCE OF ADMITTEE" name="en_reference_admittee">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_reference_adm_phone">Mobile</label>
                            <input type="text" id="en_reference_adm_phone" value="{{old('en_reference_adm_phone')}}" class="form-control" placeholder="Mobile" name="en_reference_adm_phone">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_reference_adm_adress">Address</label>
                            <input type="text" id="en_reference_adm_adress" value="{{old('en_reference_adm_adress')}}" class="form-control" placeholder="Address" name="en_reference_adm_adress">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_jobpost_id">Position applied for</label>
                            <select name="en_jobpost_id" class=" form-control @error('en_jobpost_id') is-invalid @enderror" id="en_jobpost_id">
                                <option value="">Select</option>
                                @forelse($jobposts as $d)
                                <option value="{{$d->id}}" {{ old('en_jobpost_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                    <option value="">No found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_place_of_posting">Place of Posting</label>
                            <input type="text" id="en_place_of_posting" value="{{old('en_place_of_posting')}}" class="form-control" placeholder="Place of Posting" name="en_place_of_posting">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_is_any_case">Is any case filed against him in any Court if Justice</label>
                            <select name="en_is_any_case" class="form-control">
                                <option value="1">Yes</option>
                                <option selected value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_is_criminal_court">Had he ever been convicated by the criminal Court</label>
                            <select name="en_is_criminal_court" class="form-control">
                                <option value="1">Yes</option>
                                <option selected value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_any_other_info">Any Other Information</label>
                            <select name="en_any_other_info" class="form-control">
                                <option value="1">Yes</option>
                                <option selected value="2">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-end">
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-header p-1">
                                <h5 class="card-title">Upload Your Signture</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <!-- Basic file uploader -->
                                    <input type="file" class="" name="signature_img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row imggl">
                    <label for="status"><b>{{__('All Documents Upload')}}:</b></label>
                    <div class="col-5 col-sm-3 mb-3">
                        <input class="form-control mb-1" type="text" name="document_caption[]" placeholder="Document Caption"/>
                        <input type="file" class="dropify" data-height="100" name="document_img[]"/>
                    </div>
                    <div class="col-2 addbtn">
                        <button type="button" class="btn btn-primary" onclick="addGallery()">Add More</button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addGallery(){
        $('.addbtn').before('<div class="col-5 col-sm-3 mb-3"><input class="form-control mb-1" type="text" name="document_caption[]" placeholder="Document Caption"/> <input type="file" class="dropify" data-height="100" name="document_img[]"/></div>');
        $(".dropify").dropify({messages:{default:"  click here",replace:" click to here",remove:"Remove",error:"Ooops, something wrong appended."},error:{fileSize:"The file size is too big (1M max)."}});
    }
</script>
<script>
    function newSongsRepeter() {
        var Repeter = `
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="bn_applicants_name">ছেলের নাম</label>
                    {{--  <input type="text" id="bn_song_name" value="{{old('bn_song_name')}}" class="form-control" placeholder="ছেলের নাম" name="bn_song_name[]">  --}}
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="daughters_name">মেয়ের নাম</label>
                    {{--  <input type="text" id="daughters_name" value="{{old('daughters_name')}}" class="form-control" placeholder="মেয়ের নাম" name="daughters_name[]">  --}}
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 ps-0">
                <div class="form-group text-primary mt-3" style="font-size:1.3rem">
                    <span onClick='removeElement(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                </div>
            </div>
        </div>
        `;

        $('.Repeter').append(Repeter);
    }
    function removeElement(e){
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('.row').remove();
        }
    }
</script>
<script>
    function getMarriedInfo() {
        var selectedOption = document.querySelector('select[name="bn_marital_status"]').value;

        if (selectedOption === "2") {
            $('.bn_spouse_name1').removeClass('d-none');
            $('.children_data').removeClass('d-none');
        }else {
            $('.bn_spouse_name1').addClass('d-none');
            $('.children_data').addClass('d-none');
        }
    }
    function getEmpInfo() {
        var sop = document.querySelector('select[name="employee_type"]').value;

        if (sop === "2") {
            $('.desig').removeClass('d-none');
            $('.gsalary').removeClass('d-none');
            $('.otsalary').removeClass('d-none');
            $('.serialNo').removeClass('d-none');
        }else {
            $('#designation_id').prop('selectedIndex', 0);
            $('#gsalary').val('');
            $('#otsalary').val('');
            $('#serialNo').val('');
            $('.desig').addClass('d-none');
            $('.gsalary').addClass('d-none');
            $('.otsalary').addClass('d-none');
            $('.serialNo').addClass('d-none');
        }
    }
    function engetMarriedInfo() {
        var selectedOption = document.querySelector('select[name="en_marital_status"]').value;

        if (selectedOption === "2") {
            $('.en_spouse_name1').removeClass('d-none');
            $('.echildren_data').removeClass('d-none');
        }else {
            $('.en_spouse_name1').addClass('d-none');
            $('.echildren_data').addClass('d-none');
        }
    }
    </script>
@endsection
@push('scripts')
<script>
    /* call on load page */
    $(document).ready(function(){
        $('.district').hide();
        $('.upazila').hide();
    })

    function show_upazila(e){
         $('.district').hide();
         $('.district'+e).show();
    }
    function show_unions(e){
         $('.upazila').hide();
         $('.upazila'+e).show();
    }

    function copyAddress() {
        var district = document.getElementById("bn_parm_district_id").value;
        var upazila = document.getElementById("bn_parm_upazila_id").value;
        var union = document.getElementById("bn_parm_union_id").value;
        var ward = document.getElementById("bn_parm_ward_id").value;
        var holding = document.getElementById("bn_parm_holding_name").value;
        var village = document.getElementById("bn_parm_village_name").value;
        var postoff = document.getElementById("bn_parm_post_ofc").value;
        var perDistrict = document.getElementById("bn_pre_district_id");
        var preUpazila = document.getElementById("bn_pre_upazila_id");
        var preUnion = document.getElementById("bn_pre_union_id");
        var preWard = document.getElementById("bn_pre_ward_no");
        var preHold = document.getElementById("bn_pre_holding_no");
        var preVill = document.getElementById("bn_pre_village_name");
        var prePost = document.getElementById("bn_pre_post_ofc");

        if (document.getElementById("copyCheckbox").checked) {
            perDistrict.value = district;
            preUpazila.value = upazila;
            preUnion.value = union;
            preWard.value = ward;
            preHold.value = holding;
            preVill.value = village;
            prePost.value = postoff;
        } else {
            perDistrict.value = '';
            preUpazila.value = '';
            preUnion.value = '';
            preWard.value = '';
            preHold.value = '';
            preVill.value = '';
            prePost.value = '';
        }
    }

</script>

<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush
