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
                                    <input type="file" class="basic-filepond" name="profile_img">
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
                            <input type="text" id="bn_applicants_name" value="{{old('bn_applicants_name')}}" class="form-control" placeholder="" name="bn_applicants_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পিতার নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_fathers_name')}}" class="form-control" placeholder="" name="bn_fathers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">মাতার নাম</label>
                            <input type="text" id="bn_applicants_name" value="{{old('bn_mothers_name')}}" class="form-control" placeholder="" name="bn_mothers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
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
                    </div>
                </div>
                <div class="row mt-3 gx-1">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">স্থায়ী ঠিকানা</label>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_applicants_name" value="{{old('bn_pre_holding_no')}}" class="form-control" placeholder="হোল্ডিং নং" name="bn_pre_holding_no">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_applicants_name" value="{{old('bn_pre_word_no')}}" class="form-control" placeholder="ওয়ার্ড নং" name="bn_pre_word_no">
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <select name="bn_pre_post_ofc_id" class="form-control js-example-basic-single" id="bn_pre_post_ofc_id">
                                        <option value="">Select Post Office</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="bn_pre_thana_id" class="form-control js-example-basic-single" id="bn_pre_thana_id">
                                        <option value="">Select Thana</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_applicants_name" value="{{old('bn_pre_village_name')}}" class="form-control" placeholder="গ্রামের নাম" name="bn_pre_village_name">
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="bn_pre_union_id" class="form-control js-example-basic-single" id="bn_pre_union_id">
                                        <option value="">Select Union</option>
                                        <option value="1">Banskhali</option>
                                        <option value="2">Boalkhali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <select name="bn_pre_upazila_id" class="form-control js-example-basic-single" id="bn_pre_upazila_id">
                                        <option value="">Select Upazila</option>
                                        <option value="1">Fatikchori</option>
                                        <option value="2">Boalkhali</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="bn_pre_district_id" class="form-control js-example-basic-single" id="bn_pre_district_id">
                                        <option value="">Select Discrict</option>
                                        <option value="1">Chittagong</option>
                                        <option value="2">Dhaka</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">বর্তমান ঠিকানা</label>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_prem_holding_no" value="{{old('bn_prem_holding_no')}}" class="form-control" placeholder="হোল্ডিং নং" name="bn_prem_holding_no">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_prem_road_no" value="{{old('bn_prem_road_no')}}" class="form-control" placeholder="রোড নং" name="bn_prem_road_no">
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_prem_village_name" value="{{old('bn_prem_village_name')}}" class="form-control" placeholder="গ্রামের নাম" name="bn_prem_village_name">
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="en_prem_district_id" class="form-control js-example-basic-single" id="en_prem_district_id">
                                        <option value="">Select Discrict</option>
                                        <option value="1">Chittagong</option>
                                        <option value="2">Dhaka</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-12 col-12">
                                    <select name="bn_prem_thana_id" class="form-control js-example-basic-single" id="bn_prem_thana_id">
                                        <option value="">Select Thana</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">সুপারিশ/রেফারেন্স নাম</label>
                            <input type="text" id="bn_ref_name" value="{{old('bn_ref_name')}}" class="form-control" placeholder="" name="bn_ref_name">

                            <label for="bn_applicants_name">সুপারিশ/রেফারেন্স ঠিকানা</label>
                            <input type="text" id="bn_ref_address" value="{{old('bn_ref_address')}}" class="form-control" placeholder="" name="bn_ref_address">
                            <div class="row gx-1">
                                <div class="col-md-6 col-12">
                                    <label for="bn_applicants_name">জাতীয়তা</label>
                                    <input type="text" id="bn_nationality" value="{{old('bn_nationality')}}" class="form-control" placeholder="" name="bn_nationality">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="bn_religion">ধর্ম</label>
                                    <select name="bn_religion" class="form-control js-example-basic-single" id="bn_religion">
                                        <option value="">Select</option>
                                        <option value="1">Muslim</option>
                                        <option value="2">Hindu</option>
                                        <option value="3">Buddhist</option>
                                        <option value="4">Christian</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2 gx-1">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="bn_identification_mark">সনাক্তহকরণ চিহ্ন</label>
                                <input type="text" id="bn_identification_mark" value="{{old('bn_identification_mark')}}" class="form-control" placeholder="" name="bn_identification_mark">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="bn_edu_qualification">শিক্ষাগতা যোগ্যতা</label>
                                <input type="text" id="bn_edu_qualification" value="{{old('bn_edu_qualification')}}" class="form-control" placeholder="" name="bn_edu_qualification">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="bn_experience">অভিজ্ঞতা</label>
                                <input type="text" id="bn_experience" value="{{old('bn_experience')}}" class="form-control" placeholder="" name="bn_experience">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="bn_applied_post">আবেদিত পদ</label>
                                <input type="text" id="bn_applied_post" value="{{old('bn_applied_post')}}" class="form-control" placeholder="" name="bn_applied_post">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-1">
                    <h6 class="text-center my-5 border-bottom">নিরাপত্তা প্রহরীদের পূর্ব পরিচিতি</h6>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">শশুর বাড়ির ঠিকানা (বিবাহিত মহিলাদের জন্য)</label>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="bn_in_laws_village_name" value="{{old('bn_in_laws_village_name')}}" class="form-control" placeholder="গ্রাম মহল্লা" name="bn_in_laws_village_name">
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="bn_in_laws_post_office_id" class="form-control js-example-basic-single" id="bn_in_laws_post_office_id">
                                        <option value="">Select Post Office</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <select name="bn_in_laws_thana_id" class="form-control js-example-basic-single" id="bn_in_laws_thana_id">
                                        <option value="">Select Thana</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="bn_in_laws_district_id" class="form-control js-example-basic-single" id="bn_in_laws_district_id">
                                        <option value="">Select Discrict</option>
                                        <option value="1">Chittagong</option>
                                        <option value="2">Dhaka</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="row gx-1">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="bn_husband_profession">স্বামীর পেশা</label>
                                    <input type="text" id="bn_husband_profession" value="{{old('bn_husband_profession')}}" class="form-control" placeholder="" name="bn_husband_profession">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="bn_father_profession">পিতার পেশা</label>
                                    <input type="text" id="bn_father_profession" value="{{old('bn_father_profession')}}" class="form-control" placeholder="" name="bn_father_profession">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="bn_old_job_designation">পদবি</label>
                                    <input type="text" id="bn_old_job_designation" value="{{old('bn_old_job_designation')}}" class="form-control" placeholder="" name="bn_old_job_designation">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="bn_old_job_id">আইডি</label>
                                    <input type="text" id="bn_old_job_id" value="{{old('bn_old_job_id')}}" class="form-control" placeholder="" name="bn_old_job_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_landlord_name">জমিদারের নাম</label>
                            <input type="text" id="bn_landlord_name" value="{{old('bn_landlord_name')}}" class="form-control" placeholder="" name="bn_landlord_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_landlord_mobile_no">জমিদারের মোবাইল নম্বর</label>
                            <input type="text" id="bn_landlord_mobile_no" value="{{old('bn_landlord_mobile_no')}}" class="form-control" placeholder="" name="bn_landlord_mobile_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_living_dur">বর্তমান ঠিকানায় যাবৎ কতদিন বাস করছেন</label>
                            <input type="text" id="bn_living_dur" value="{{old('bn_living_dur')}}" class="form-control" placeholder="" name="bn_living_dur">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_passport_no">পাসপোর্ট নং যদি থাকে</label>
                            <input type="text" id="bn_passport_no" value="{{old('bn_passport_no')}}" class="form-control" placeholder="" name="bn_passport_no">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_office_name">পূর্বের কর্মস্থলের নাম কি</label>
                            <input type="text" id="bn_old_office_name" value="{{old('bn_old_office_name')}}" class="form-control" placeholder="" name="bn_old_office_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_office_address">পূর্বের কর্মস্থলের ঠিকানা</label>
                            <input type="text" id="bn_old_office_address" value="{{old('bn_old_office_address')}}" class="form-control" placeholder="" name="bn_old_office_address">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_resign_reason">পূর্বের কর্মস্থলের থেকে কাজ ছাড়ার কারণ কি</label>
                            <input type="text" id="bn_resign_reason" value="{{old('bn_resign_reason')}}" class="form-control" placeholder="" name="bn_resign_reason">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_resign_letter_status">পূর্বের কর্মস্থলে অবহতিপত্র দিয়েছিলেন কি</label>
                            <select id="bn_resign_letter_status" class="form-control" name="bn_resign_letter_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1">হা</option>
                                <option value="2">না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">সার্ভিস বই আছে কি ?</label>
                            <select id="bn_service_book_status" class="form-control" name="bn_service_book_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1">হা</option>
                                <option value="2">না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_salary">পূর্বের কর্মস্থলের কত টাকা বেতন ছিল</label>
                            <input type="text" id="bn_old_job_salary" value="{{old('bn_old_job_salary')}}" class="form-control" placeholder="" name="bn_old_job_salary">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_experience">পূর্বের কর্মস্থলের মোট চাকুরীর বয়স কত</label>
                            <input type="text" id="bn_old_job_experience" value="{{old('bn_old_job_experience')}}" class="form-control" placeholder="" name="bn_old_job_experience">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_current_living">বর্তমান ঠিকানায় কার কার সাথে বসবাস করছেন</label>
                            <input type="text" id="bn_current_living" value="{{old('bn_current_living')}}" class="form-control" placeholder="" name="bn_current_living">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_total_member">পরিবার এর সদস্য সংখ্যা কত</label>
                            <input type="text" id="bn_total_member" value="{{old('bn_total_member')}}" class="form-control" placeholder="" name="bn_total_member">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_solvent_person">পরিবার এ উপার্জনকারী কত জন</label>
                            <input type="text" id="bn_solvent_person" value="{{old('bn_solvent_person')}}" class="form-control" placeholder="" name="bn_solvent_person">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_sim_card_reg_status">সিম কার্ড রেজিস্ট্রেশন করা আছে কি</label>
                            <select id="bn_sim_card_reg_status" class="form-control" name="bn_sim_card_reg_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1">হা</option>
                                <option value="2">না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">আপনার দায়ের করা বা আপনার বিরুদ্ধে থানায় কিংবা আদালতে (স্থানীয় বা বর্তমান) কোনো মামলা আছে কি </label>
                            <select id="bn_case_filed_status" class="form-control" name="bn_case_filed_status">
                                <option value="">নির্বাচন করুন</option>
                                <option value="1">হা</option>
                                <option value="2">না</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_old_job_officer_name">পূর্বের কর্মস্থলের কর্মকর্তার নাম</label>
                            <input type="text" id="bn_old_job_officer_name" value="{{old('bn_old_job_officer_name')}}" class="form-control" placeholder="" name="bn_old_job_officer_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পূর্বের কর্মস্থলের কর্মকর্তার মোবাইল নং</label>
                            <input type="text" id="bn_old_job_officer_mobile" value="{{old('bn_old_job_officer_mobile')}}" class="form-control" placeholder="" name="bn_old_job_officer_mobile">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">পূর্বের কর্মস্থলের কর্মকর্তার পদবি</label>
                            <input type="text" id="bn_old_job_officer_post" value="{{old('bn_old_job_officer_post')}}" class="form-control" placeholder="" name="bn_old_job_officer_post">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 class="border-bottom my-5">English</h6>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_applicants_name">Applicant Name</label>
                            <input type="text" id="en_applicants_name" value="{{old('en_applicants_name')}}" class="form-control" placeholder="" name="en_applicants_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_fathers_name">Father's Name</label>
                            <input type="text" id="en_fathers_name" value="{{old('en_fathers_name')}}" class="form-control" placeholder="" name="en_fathers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_mothers_name">Mother's Name</label>
                            <input type="text" id="en_mothers_name" value="{{old('en_mothers_name')}}" class="form-control" placeholder="" name="en_mothers_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_husband_name">Husband Name</label>
                            <input type="text" id="en_husband_name" value="{{old('en_husband_name')}}" class="form-control" placeholder="" name="en_husband_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_spouse_name">Spouse Name</label>
                            <input type="text" id="en_spouse_name" value="{{old('en_spouse_name')}}" class="form-control" placeholder="" name="en_spouse_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_son_name">Son Name</label>
                            <input type="text" id="en_son_name" value="{{old('en_son_name')}}" class="form-control" placeholder="" name="en_son_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_daughter_name">Daughter Name</label>
                            <input type="text" id="en_daughter_name" value="{{old('en_daughter_name')}}" class="form-control" placeholder="" name="en_daughter_name">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_applicant_contact">Mobile No</label>
                            <input type="text" id="en_applicant_contact" value="{{old('en_applicant_contact')}}" class="form-control" placeholder="" name="en_applicant_contact">
                        </div>
                    </div>
                </div>
                <div class="row mt-3 gx-1">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="">Permanent Address</label>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_pre_holding_no" value="{{old('en_pre_holding_no')}}" class="form-control" placeholder="Holding No" name="en_pre_holding_no">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_pre_word_no" value="{{old('en_pre_word_no')}}" class="form-control" placeholder="Ward No" name="en_pre_word_no">
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <select name="en_pre_post_ofc_id" class="form-control js-example-basic-single" id="en_pre_post_ofc_id">
                                        <option value="">Select Post Office</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="en_pre_thana_id" class="form-control js-example-basic-single" id="en_pre_thana_id">
                                        <option value="">Select Thana</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_pre_village_name" value="{{old('en_pre_village_name')}}" class="form-control" placeholder="Village Name" name="en_pre_village_name">
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="en_pre_union_id" class="form-control js-example-basic-single" id="en_pre_union_id">
                                        <option value="">Select Union</option>
                                        <option value="1">Banskhali</option>
                                        <option value="2">Boalkhali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <select name="en_pre_upazila_id" class="form-control js-example-basic-single" id="en_pre_upazila_id">
                                        <option value="">Select Upazila</option>
                                        <option value="1">Fatikchori</option>
                                        <option value="2">Boalkhali</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="en_pre_district_id" class="form-control js-example-basic-single" id="en_pre_district_id">
                                        <option value="">Select Discrict</option>
                                        <option value="1">Chittagong</option>
                                        <option value="2">Dhaka</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="">Present Address</label>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_prem_holding_no" value="{{old('en_prem_holding_no')}}" class="form-control" placeholder="Holding No" name="en_prem_holding_no">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_prem_road_no" value="{{old('en_prem_road_no')}}" class="form-control" placeholder="Road No" name="en_prem_road_no">
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" id="en_prem_building_name" value="{{old('en_prem_building_name')}}" class="form-control" placeholder="Building Name" name="en_prem_building_name">
                                </div>
                                <div class="col-md-6 col-12">
                                    <select name="en_prem_district_id" class="form-control js-example-basic-single" id="en_prem_district_id">
                                        <option value="">Select Discrict</option>
                                        <option value="1">Chittagong</option>
                                        <option value="2">Dhaka</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-1 my-2">
                                <div class="col-md-12 col-12">
                                    <select name="en_prem_thana_id" class="form-control js-example-basic-single" id="en_prem_thana_id">
                                        <option value="">Select Thana</option>
                                        <option value="1">Panchlaish</option>
                                        <option value="2">Halishahar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="en_reference_name">Reference Name</label>
                            <input type="text" id="en_reference_name" value="{{old('en_reference_name')}}" class="form-control" placeholder="" name="en_reference_name">

                            <label for="en_ref_address">Reference Address</label>
                            <input type="text" id="en_ref_address" value="{{old('en_ref_address')}}" class="form-control" placeholder="" name="en_ref_address">

                            <label for="en_ref_mobile">Reference Mobile</label>
                            <input type="text" id="en_ref_mobile" value="{{old('en_ref_mobile')}}" class="form-control" placeholder="" name="en_ref_mobile">
                            <div class="row gx-1">
                                <div class="col-md-6 col-12">
                                    <label for="en_religion">Religion</label>
                                    <select name="en_religion" class="form-control js-example-basic-single" id="en_religion">
                                        <option value="">Select</option>
                                        <option value="1">Muslim</option>
                                        <option value="2">Hindu</option>
                                        <option value="3">Buddhist</option>
                                        <option value="4">Christian</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="en_ident_mark">Identification Mark</label>
                                        <input type="text" id="en_ident_mark" value="{{old('en_ident_mark')}}" class="form-control" placeholder="" name="en_ident_mark">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="en_height">Height</label>
                                    <input type="text" id="en_height" value="{{old('en_height')}}" class="form-control" placeholder="" name="en_height">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="en_weight">Weight</label>
                                    <input type="text" id="en_weight" value="{{old('en_weight')}}" class="form-control" placeholder="" name="en_weight">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2 gx-1">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_edu_qualification">Education Qualification</label>
                                <input type="text" id="en_edu_qualification" value="{{old('en_edu_qualification')}}" class="form-control" placeholder="" name="en_edu_qualification">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_experience">Experience</label>
                                <input type="text" id="en_experience" value="{{old('en_experience')}}" class="form-control" placeholder="" name="en_experience">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="dob">DOB</label>
                                <input type="date" id="dob" value="{{old('dob')}}" class="form-control" placeholder="" name="dob">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_birth_cert">Birth Certificate</label>
                                <input type="text" id="en_birth_cert" value="{{old('en_birth_cert')}}" class="form-control" placeholder="" name="en_birth_cert">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_nationality">Nationality</label>
                                <input type="text" id="en_nationality" value="{{old('en_nationality')}}" class="form-control" placeholder="" name="en_nationality">

                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_nid">Nid</label>
                                <input type="text" id="en_nid" value="{{old('en_nid')}}" class="form-control" placeholder="" name="en_nid">
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="marital_status">Maritial Status</label>
                                <select id="marital_status" class="form-control" name="marital_status">
                                    <option value="">Select</option>
                                    <option value="1">Married</option>
                                    <option value="2">Unmarried</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="en_applied_position">Position Applied For</label>
                                <input type="text" id="en_applied_position" value="{{old('en_applied_position')}}" class="form-control" placeholder="" name="en_applied_position">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 mt-3">
                        <div class="form-group">
                            <label for="en_next_of_kin">Next Of Kin</label>
                            <input type="text" id="en_next_of_kin" value="{{old('en_next_of_kin')}}" class="form-control" placeholder="" name="en_next_of_kin">
                        </div>
                    </div>
                    <div class="col-md-3 col-12 mt-3">
                        <div class="form-group">
                            <label for="en_relation_with_applicant">Relationship With Applicant</label>
                            <input type="text" id="en_relation_with_applicant" value="{{old('en_relation_with_applicant')}}" class="form-control" placeholder="" name="en_relation_with_applicant">
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
                                    <input type="file" class="basic-filepond" name="signature_img">
                                </div>
                            </div>
                        </div>
                    </div>
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
<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush