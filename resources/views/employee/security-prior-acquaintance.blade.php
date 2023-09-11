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
            <form class="form" method="post" action="{{route('security.store', [$employees->id,'role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $employees->id }}" name="employee_id" id="">
                <div class="row">
                    <h5 class="text-center m-0">এলিট সিকিউরিটি সার্ভিস লিমিটেড</h5>
                </div>
                <div class="row d-flex justify-content-end">
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <!-- Basic file uploader -->
                                    <img width="100px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" alt="">
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
                            <label for="bn_applicants_name">আবেদনকারীর নাম</label>
                            <input readonly type="text" id="bn_applicants_name" value="{{old('bn_applicants_name',$employees->bn_applicants_name)}}" class="form-control" placeholder="" name="bn_applicants_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applied_position">পদবী</label>
                            <input readonly type="text" id="bn_applied_position" value="{{old('bn_applied_position',$employees->bn_applied_position)}}" class="form-control" placeholder="পদবী" name="bn_applied_position">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পিতার নাম</label>
                            <input readonly type="text" id="bn_applicants_name" value="{{old('bn_fathers_name',$employees->bn_fathers_name)}}" class="form-control" placeholder="" name="bn_fathers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="admission_id_no">আইডি নং</label>
                            <input readonly type="text" id="admission_id_no" value="{{old('admission_id_no',$employees->admission_id_no)}}" class="form-control" placeholder="" name="admission_id_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">মাতার নাম</label>
                            <input readonly type="text" id="bn_applicants_name" value="{{old('bn_mothers_name',$employees->bn_mothers_name)}}" class="form-control" placeholder="" name="bn_mothers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_spouse_name">স্বামী/স্ত্রীর নাম</label>
                            <input readonly type="text" value="{{old('bn_spouse_name',$employees->bn_spouse_name)}}" class="form-control" placeholder="" name="bn_spouse_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_dob">জন্ম তারিখ</label>
                            <input readonly type="date" id="bn_dob" value="{{old('bn_dob',$employees->bn_dob)}}" class="form-control" placeholder="" name="bn_dob">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_edu_qualification">শিক্ষাগতা যোগ্যতা</label>
                            <input readonly type="text" id="bn_edu_qualification" value="{{old('bn_edu_qualification',$employees->bn_edu_qualification)}}" class="form-control" placeholder="" name="bn_edu_qualification">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <h6 class="">বর্তমান ঠিকানা </h6>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_village_name">গ্রামের নাম</label>
                            <input readonly type="text" id="bn_pre_village_name" value="{{old('bn_pre_village_name',$employees->bn_pre_village_name)}}" class="form-control" placeholder="গ্রামের নাম" name="bn_pre_village_name">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_post_ofc">ডাকঘর</label>
                            <input readonly type="text" id="bn_pre_post_ofc" value="{{old('bn_pre_post_ofc',$employees->bn_pre_post_ofc)}}" class="form-control" placeholder="পোঃ" name="bn_pre_post_ofc">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_district_id">জেলা</label>
                            <input readonly class="form-control" type="text" value="{{ $employees->bn_district?->name_bn }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_upazila_id">উপজেলা</label>
                            <input readonly class="form-control" type="text" value="{{ $employees->bn_upazilla?->name_bn }}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <h6 class="">স্থায়ী ঠিকানা </h6>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_parm_village_name">গ্রামের নাম</label>
                            <input readonly type="text" id="bn_parm_village_name" value="{{old('bn_parm_village_name',$employees->bn_parm_village_name)}}" class="form-control" name="bn_parm_village_name">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_parm_post_ofc">ডাকঘর</label>
                            <input readonly type="text" id="bn_parm_post_ofc" value="{{old('bn_parm_post_ofc',$employees->bn_parm_post_ofc)}}" class="form-control" name="bn_parm_post_ofc">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_district_id">জেলা</label>
                            <input readonly class="form-control" type="text" value="{{ $employees->bn_parm_district?->name_bn }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="bn_pre_upazila_id">উপজেলা</label>
                            <input readonly class="form-control" type="text" value="{{ $employees->bn_parm_upazilla?->name_bn }}">
                        </div>
                    </div>
                </div>
                <div class="row my-2 gx-1">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_marital_status">বৈবাহিক অবস্থা</label>
                            <input readonly class="form-control" type="text" @if($employees->bn_marital_status==1) value="{{ 'অবিবাহিত' }}" @else value="{{ 'বিবাহিত' }}" @endif>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_nationality">জাতীয়তা</label>
                            <input readonly type="text" id="bn_nationality" value="{{old('bn_nationality',$employees->bn_nationality)}}" class="form-control" placeholder="" name="bn_nationality">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_nid_no">জাতীয় পরিচয়পত্র নং</label>
                            <input readonly type="text" id="bn_nid_no" value="{{old('bn_nid_no',$employees->bn_nid_no)}}" class="form-control" placeholder="" name="bn_nid_no">
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <h6 class="text-center my-5 border-bottom">নিরাপত্তা প্রহরীদের পূর্ব পরিচিতি</h6>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">শশুর বাড়ির ঠিকানা (বিবাহিত মহিলাদের জন্য)</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_in_laws_district_id">জেলা</label>
                            <select onchange="show_upazila(this.value)" name="bn_in_laws_district_id" class=" form-control js-example-basic-single" id="bn_in_laws_district_id">
                                <option value="">Select Discrict</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ $security && $security->bn_in_laws_district_id==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No Country found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_in_laws_upazilla_id">উপজেলা</label>
                            <select name="bn_in_laws_upazilla_id" class="form-control js-example-basic-single" id="bn_in_laws_upazilla_id">
                                <option value="">Select Upazila</option>
                                @forelse($upazila as $d)
                                <option class="district district{{$d->district_id}}" value="{{$d->id}}" {{ $security && $security->bn_in_laws_upazilla_id==$d->id?"selected":""}}> {{ $d->name_bn}}</option>
                                @empty
                                    <option value="">No district found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_in_laws_village_name">গ্রামের নাম</label>
                            <input type="text" id="bn_in_laws_village_name" value="{{old('bn_in_laws_village_name',$security? $security->bn_in_laws_village_name:'')}}" class="form-control" placeholder="গ্রামের নাম" name="bn_in_laws_village_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_in_laws_post_office">ডাকঘর</label>
                            <input type="text" id="bn_in_laws_post_office" value="{{old('bn_in_laws_post_office',$security?$security->bn_in_laws_post_office:'')}}" class="form-control" placeholder="ডাকঘর" name="bn_in_laws_post_office">
                        </div>
                    </div>
                </div>
                <div class="row gx-1">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_husband_profession">স্বামীর পেশা</label>
                            <input type="text" id="bn_husband_profession" value="{{old('bn_husband_profession',$security?$security->bn_husband_profession:'')}}" class="form-control" placeholder="" name="bn_husband_profession">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_father_profession">পিতার পেশা</label>
                            <input type="text" id="bn_father_profession" value="{{old('bn_father_profession',$security?$security->bn_father_profession:'')}}" class="form-control" placeholder="" name="bn_father_profession">
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_designation">পদবি</label>
                            <input type="text" id="bn_old_job_designation" value="{{old('bn_old_job_designation')}}" class="form-control" placeholder="" name="bn_old_job_designation">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_id">আইডি</label>
                            <input type="text" id="bn_old_job_id" value="{{old('bn_old_job_id')}}" class="form-control" placeholder="" name="bn_old_job_id">
                        </div>
                    </div>  --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_landlord_name">জমিদারের নাম</label>
                            <input type="text" id="bn_landlord_name" value="{{old('bn_landlord_name',$security ?$security->bn_landlord_name:'')}}" class="form-control" placeholder="" name="bn_landlord_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_landlord_mobile_no">জমিদারের মোবাইল নম্বর</label>
                            <input type="text" id="bn_landlord_mobile_no" value="{{old('bn_landlord_mobile_no',$security? $security->bn_landlord_mobile_no:'')}}" class="form-control" placeholder="" name="bn_landlord_mobile_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_living_dur">বর্তমান ঠিকানায় কতদিন যাবৎ বাস করছেন</label>
                            <input type="text" id="bn_living_dur" value="{{old('bn_living_dur',$security ?$security->bn_living_dur:'')}}" class="form-control" placeholder="" name="bn_living_dur">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_passport_no">পাসপোর্ট নং যদি থাকে</label>
                            <input type="text" id="bn_passport_no" value="{{old('bn_passport_no',$security ?$security->bn_passport_no:'')}}" class="form-control" placeholder="" name="bn_passport_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_office_name">পূর্বের কর্মস্থলের নাম কি</label>
                            <input type="text" id="bn_old_office_name" value="{{old('bn_old_office_name',$security ?$security->bn_old_office_name:'')}}" class="form-control" placeholder="" name="bn_old_office_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_office_address">পূর্বের কর্মস্থলের ঠিকানা</label>
                            <input type="text" id="bn_old_office_address" value="{{old('bn_old_office_address',$security? $security->bn_old_office_address:'')}}" class="form-control" placeholder="" name="bn_old_office_address">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_resign_reason">পূর্বের কর্মস্থলের থেকে কাজ ছাড়ার কারণ কি</label>
                            <input type="text" id="bn_resign_reason" value="{{old('bn_resign_reason',$security ?$security->bn_resign_reason:'')}}" class="form-control" placeholder="" name="bn_resign_reason">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_resign_letter_status">পূর্বের কর্মস্থলে অবহতিপত্র দিয়েছিলেন কি</label>
                            <select id="bn_resign_letter_status" class="form-control" name="bn_resign_letter_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1" {{ $security && $security->bn_resign_letter_status=='1'?"selected":""}}>হা</option>
                                <option value="2" {{ $security && $security->bn_resign_letter_status=='2'?"selected":""}}>না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_service_book_status">সার্ভিস বই আছে কি ?</label>
                            <select id="bn_service_book_status" class="form-control" name="bn_service_book_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1" {{ $security && $security->bn_service_book_status=='1'?"selected":""}}>হা</option>
                                <option value="2" {{ $security && $security->bn_service_book_status=='2'?"selected":""}}>না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_service_book_no">সার্ভিস বই নং</label>
                            <input type="text" id="bn_service_book_no" value="{{old('bn_service_book_no',$security ?$security->bn_service_book_no:'')}}" class="form-control" placeholder="" name="bn_service_book_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_salary">পূর্বের কর্মস্থলের কত টাকা বেতন ছিল</label>
                            <input type="text" id="bn_old_job_salary" value="{{old('bn_old_job_salary',$security ?$security->bn_old_job_salary:'')}}" class="form-control" placeholder="" name="bn_old_job_salary">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_last_desig">পূর্বের কর্মস্থলে সর্বশেষ পদবী কি ছিলো</label>
                            <input type="text" id="bn_old_job_last_desig" value="{{old('bn_old_job_last_desig',$security ?$security->bn_old_job_last_desig:'')}}" class="form-control" placeholder="" name="bn_old_job_last_desig">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_experience">পূর্বের কর্মস্থলের মোট চাকুরীর বয়স কত</label>
                            <input type="text" id="bn_old_job_experience" value="{{old('bn_old_job_experience',$security ?$security->bn_old_job_experience:'')}}" class="form-control" placeholder="" name="bn_old_job_experience">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_new_job_transportation">বর্তমান কর্মস্থল হতে আপনার বাসার যাতায়াতের মাধ্যম কি</label>
                            <input type="text" id="bn_new_job_transportation" value="{{old('bn_new_job_transportation',$security ?$security->bn_new_job_transportation:'')}}" class="form-control" placeholder="" name="bn_new_job_transportation">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_current_living">বর্তমান ঠিকানায় কার কার সাথে বসবাস করছেন</label>
                            <input type="text" id="bn_current_living" value="{{old('bn_current_living',$security ?$security->bn_current_living:'')}}" class="form-control" placeholder="" name="bn_current_living">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_total_member">পরিবার এর সদস্য সংখ্যা কত</label>
                            <input type="text" id="bn_total_member" value="{{old('bn_total_member',$security ?$security->bn_total_member:'')}}" class="form-control" placeholder="" name="bn_total_member">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_mobile_no">মোবাইল নং (যদি থাকে)</label>
                            <input type="text" id="bn_mobile_no" value="{{old('bn_mobile_no',$security ?$security->bn_mobile_no:'')}}" class="form-control" placeholder="" name="bn_mobile_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_solvent_person">পরিবার এ উপার্জনকারী কত জন</label>
                            <input type="text" id="bn_solvent_person" value="{{old('bn_solvent_person',$security ?$security->bn_solvent_person:'')}}" class="form-control" placeholder="" name="bn_solvent_person">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_sim_card_reg_status">সিম কার্ড রেজিস্ট্রেশন করা আছে কি</label>
                            <select id="bn_sim_card_reg_status" class="form-control" name="bn_sim_card_reg_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1" {{ $security && $security->bn_sim_card_reg_status=='1'?"selected":""}}>হা</option>
                                <option value="2" {{ $security && $security->bn_sim_card_reg_status=='2'?"selected":""}}>না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">আপনার দায়ের করা বা আপনার বিরুদ্ধে থানায় কিংবা আদালতে (স্থানীয় বা বর্তমান) কোনো মামলা আছে কি </label>
                            <select id="bn_case_filed_status" class="form-control" name="bn_case_filed_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1" {{ $security && $security->bn_case_filed_status=='1'?"selected":""}}>হা</option>
                                <option value="2" {{ $security && $security->bn_case_filed_status=='2'?"selected":""}}>না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_officer_name">পূর্বের কর্মস্থলের কর্মকর্তার নাম</label>
                            <input type="text" id="bn_old_job_officer_name" value="{{old('bn_old_job_officer_name',$security ?$security->bn_old_job_officer_name:'')}}" class="form-control" placeholder="" name="bn_old_job_officer_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পূর্বের কর্মস্থলের কর্মকর্তার মোবাইল নং</label>
                            <input type="text" id="bn_old_job_officer_mobile" value="{{old('bn_old_job_officer_mobile',$security ?$security->bn_old_job_officer_mobile:'')}}" class="form-control" placeholder="" name="bn_old_job_officer_mobile">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পূর্বের কর্মস্থলের কর্মকর্তার পদবি</label>
                            <input type="text" id="bn_old_job_officer_post" value="{{old('bn_old_job_officer_post',$security? $security->bn_old_job_officer_post:'')}}" class="form-control" placeholder="" name="bn_old_job_officer_post">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">দুইজন সনাক্তকারী</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_name1">নাম</label>
                            <input type="text" id="bn_identifier_name1" value="{{old('bn_identifier_name1',$security ?$security->bn_identifier_name1:'')}}" class="form-control" placeholder="নাম" name="bn_identifier_name1">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_occupation1">পেশা</label>
                            <input type="text" id="bn_identifier_occupation1" value="{{old('bn_identifier_occupation1',$security ?$security->bn_identifier_occupation1:'')}}" class="form-control" placeholder="পেশা" name="bn_identifier_occupation1">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_address1">ঠিকানা</label>
                            <input type="text" id="bn_identifier_address1" value="{{old('bn_identifier_address1',$security ?$security->bn_identifier_address1:'')}}" class="form-control" placeholder="ঠিকানা" name="bn_identifier_address1">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_phone1">ফোন নং</label>
                            <input type="text" id="bn_identifier_phone1" value="{{old('bn_identifier_phone1',$security ?$security->bn_identifier_phone1:'')}}" class="form-control" placeholder="ফোন নং" name="bn_identifier_phone1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_name2">নাম</label>
                            <input type="text" id="bn_identifier_name2" value="{{old('bn_identifier_name2',$security ?$security->bn_identifier_name2:'')}}" class="form-control" placeholder="নাম" name="bn_identifier_name2">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_occupation2">পেশা</label>
                            <input type="text" id="bn_identifier_occupation2" value="{{old('bn_identifier_occupation2',$security ?$security->bn_identifier_occupation2:'')}}" class="form-control" placeholder="পেশা" name="bn_identifier_occupation2">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_address2">ঠিকানা</label>
                            <input type="text" id="bn_identifier_address2" value="{{ old('bn_identifier_address2', $security ? $security->bn_identifier_address2 : '') }}" class="form-control" placeholder="ঠিকানা" name="bn_identifier_address2">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="bn_identifier_phone2">ফোন নং</label>
                            <input type="text" id="bn_identifier_phone2" value="{{old('bn_identifier_phone2',$security ? $security->bn_identifier_phone2 :'')}}" class="form-control" placeholder="ফোন নং" name="bn_identifier_phone2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($security ?$security->informant_sing:'')
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="informant_sing">তথ্যদানকারীর স্বাক্ষর</label>
                            <input type="file" id="informant_sing" value="{{old('informant_sing')}}" class="form-control" placeholder="তথ্যদানকারীর স্বাক্ষর" name="informant_sing">
                        </div>
                        <img height="50px" width="150px"  src="{{asset('uploads/informant_sing/'.$security->informant_sing)}}" alt="কোন স্বাক্ষর নেই">
                    </div>
                    @endif
                    @if($security ?$security->data_collector_sing:'')
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="data_collector_sing">তথ্য সংগ্রহকারীর স্বাক্ষর</label>
                            <input type="file" id="data_collector_sing" value="{{old('data_collector_sing')}}" class="form-control" placeholder="তথ্য সংগ্রহকারীর স্বাক্ষর" name="data_collector_sing">
                            <img height="50px" width="150px"  src="{{asset('uploads/data_collector_sing/'.$security->data_collector_sing)}}" alt="কোন স্বাক্ষর নেই">
                        </div>
                    </div>
                    @endif
                    @if($security ?$security->executive_sing:'')
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="executive_sing">এক্সিকিউটিভ(এইচআর)</label>
                            <input type="file" id="executive_sing" value="{{old('executive_sing')}}" class="form-control" placeholder="এক্সিকিউটিভ(এইচআর)" name="executive_sing">
                            <img height="50px" width="150px"  src="{{asset('uploads/executive_sing/'.$security->executive_sing)}}" alt="কোন স্বাক্ষর নেই">
                        </div>
                    </div>
                    @endif
                    @if($security ?$security->manager_sing:'')
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="manager_sing">ম্যানেজার(অপারেশন)</label>
                            <input type="file" id="manager_sing" value="{{old('manager_sing')}}" class="form-control" placeholder="ম্যানেজার(অপারেশন)" name="manager_sing">
                            <img height="50px" width="150px"  src="{{asset('uploads/manager_sing/'.$security->manager_sing)}}" alt="কোন স্বাক্ষর নেই">
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
</script>
<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush
