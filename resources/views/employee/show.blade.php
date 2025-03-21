@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}">
<div class="container">
    <ul class="nav nav-pills mt-3 mb-5" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link step-1-tab active" id="step-1-tab" data-toggle="pill" href="#step-1" role="tab" aria-controls="step-1" aria-selected="true"><span>জীবন বৃত্তান্ত</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-5-tab" id="step-5-tab" data-toggle="pill" href="#step-5" role="tab" aria-controls="step-5" aria-selected="false"><span>দায়িত্ব ও শর্তাবলী </span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-6-tab" id="step-6-tab" data-toggle="pill" href="#step-6" role="tab" aria-controls="step-6" aria-selected="false"><span>BIO-DATA </span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-2-tab" id="step-2-tab" data-toggle="pill" href="#step-2" role="tab" aria-controls="step-2" aria-selected="false"><span>নিয়োগের জন্য আবেদন</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-9-tab" id="step-9-tab" data-toggle="pill" href="#step-9" role="tab" aria-controls="step-9" aria-selected="false"><span>ফরম নং-১৫</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-3-tab" id="step-3-tab" data-toggle="pill" href="#step-3" role="tab" aria-controls="step-3" aria-selected="false"><span>গার্ডের কর্ম বিবরণী</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-4-tab" id="step-4-tab" data-toggle="pill" href="#step-4" role="tab" aria-controls="step-4" aria-selected="false"><span>পূর্ব পরিচিতি</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-7-tab" id="step-7-tab" data-toggle="pill" href="#step-7" role="tab" aria-controls="step-7" aria-selected="false"><span>প্রশিক্ষণ ফি সংক্রান্ত</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-8-tab" id="step-8-tab" data-toggle="pill" href="#step-8" role="tab" aria-controls="step-8" aria-selected="false"><span> ভর্তির প্রাথমিক কার্যক্রম</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-10-tab" id="step-10-tab" data-toggle="pill" href="#step-10" role="tab" aria-controls="step-10" aria-selected="false"><span>পুলিশ ভেরিফিকেশন</span></a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="step-1" role="tabpanel" aria-labelledby="step-1-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
            </div>
            <div id="result_show">

                <div class="row p-3">
                    <div class="col-3">
                        <img height="auto" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                    </div>
                    <div class="col-6 col-sm-6" style="padding-left: 10px;">
                        <div style="text-align: center;">
                            <h6 style="padding-top: 5px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h6>
                            <p class="text-center m-0 p-0">ভর্তি ফরম:সকল অস্থায়ী পদের জন্য</p>
                            <p class="text-center m-0 p-0">বাড়ি নং-২,লেইন নং-২,রোড নং-২,ব্লক-''কে''</p>
                            <p class="text-center m-0 p-0">হালিশহর হাউজিং এষ্টেট,চট্টগ্রাম-৪২২৪</p>
                            <h6 class="text-center m-0 p-0"><u>জীবন বৃত্তান্ত/ব্যক্তিগত বিবরন/তথ্যাদি</u></h6>
                        </div>
                    </div>
                    <div class="col-3" style="padding-left: 10px;">
                        <img class="tbl_border" height="auto" width="130px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">
                    </div>
                </div>
                <div class="row p-3">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">১ । আবেদনকারীর নাম :</td>
                                <td class="py-1 tbborder" colspan="5" style="width: 40%;">{{ $employees->bn_applicants_name }}</td>
                                <td class="py-1" style="text-align: center; width: 20%;">ভর্তির পর আইডি নং</td>
                                <td class="py-1 tbborder" colspan="2" style="width: 15%;">{{ convertToBanglaNumber($employees->admission_id_no) }}</td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">২ । পিতার নাম:</td>
                                <td class="py-1 tbborder" colspan="4">{{ $employees->bn_fathers_name }}</td>
                                <td class="py-1" style="text-align: center;">মাতার নাম:</td>
                                <td class="py-1 tbborder" colspan="3">{{ $employees->bn_mothers_name }}</td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৩ । স্থায়ী ঠিকানা :</td>
                                <td class="py-1" colspan="8">
                                    <label for="">হোল্ডিং নং:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_holding_name }}</span>
                                    <label for="">ওয়ার্ড:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_ward?->name_bn }}</span>
                                    <label for="">গ্রাম:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_village_name }}</span>
                                    <label for="">ইউনিয়ন :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_union?->name_bn }}</span>
                                    <label for="">পোঃ :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_post_ofc }}</span>
                                    <label for="">উপজেলা :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_upazilla?->name_bn }}</span>
                                    <label for="">জেলা :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_parm_district?->name_bn }}</span>
                                    <label for="">মোবাইল নং(নিজ) :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ convertToBanglaNumber($employees->bn_parm_phone_my) }}</span>
                                    <label for="">বিকল্প :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ convertToBanglaNumber($employees->bn_parm_phone_alt) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৪ । বর্তমান ঠিকানা :</td>
                                <td class="py-1" colspan="8">
                                    <label for="">হোল্ডিং নং:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_pre_holding_no }}</span>
                                    <label for="">ওয়ার্ড:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_pre_ward?->name_bn }}</span>
                                    <label for="">গ্রাম:</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_pre_village_name }}</span>
                                    <label for="">ইউনিয়ন :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_union?->name_bn }}</span>
                                    <label for="">পোঃ :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_pre_post_ofc }}</span>
                                    <label for="">উপজেলা :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_upazilla?->name_bn }}</span>
                                    <label for="">জেলা :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:18px; padding-top:15px">{{ $employees->bn_district?->name_bn }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" colspan="9" style="text-align: center;"><b>(উল্লেখ্য, আমার বর্তমান ঠিকানা পরিবর্তন হলে আমি তাহা সাথে সাথে অফিস কে জানাবো)</b></td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৫ । সনাক্তহকরণ চিহ্ন :</td>
                                <td class="py-1 tbborder" colspan="5" style="width: 35%;">{{ $employees->bn_identification_mark }}</td>
                                <td class="py-1" style="text-align: center; width: 10%;">রক্তের গ্রুপ</td>
                                <td class="py-1 tbborder" colspan="2" style="width: 35%;">{{ $employees->bloodgroup?->name_bn }}</td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৬ । শিক্ষাগতা যোগ্যতা :</td>
                                <td class="py-1" colspan="8">
                                    <span class="tbborder d-inline-block" style="padding-right:38px; padding-top:15px">{{ $employees->bn_edu_qualification }}</span>
                                    <label for="">জন্ম তারিখ :</label>
                                    <span class="tbborder d-inline-block" style="padding-right:38px; padding-top:15px">{{ $employees->bn_dob ? convertToBanglaNumber(\Carbon\Carbon::parse($employees->bn_dob)->format('d-m-Y')) : '' }}</span>
                                    <label for="">বয়স :</label>
                                    @php
                                    $birthDate = $employees->bn_dob;
                                    $age = \Carbon\Carbon::parse($birthDate)->age;
                                    @endphp
                                    <span class="tbborder d-inline-block" style="padding-right:38px; padding-top:15px">{{ convertToBanglaNumber($age) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; ">৭ । জন্ম নিবন্ধন নং :</td>
                                <td class="py-1" colspan="8">
                                    <input type="text" class="sinput" value="{{ convertToBanglaNumber($employees->bn_birth_certificate) }}">
                                    <label for="">জাতীয় পরিচয়পত্র নং :</label>
                                    <input type="text" class="sinput" value="{{ convertToBanglaNumber($employees->bn_nid_no) }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৮ । জাতীয়তা :</td>
                                <td class="py-1" colspan="8">
                                    <input type="text" class="small" value="{{ $employees->bn_nationality }}">
                                    <label for="">ধর্ম :</label>
                                    <input type="text" class="small" value="{{ $employees->religion?->name_bn }}">
                                    <label for="">উচ্চতা :</label>
                                    <input type="text" class="verySmall" value="{{ convertToBanglaNumber($employees->bn_height_foot) }}">
                                    <label for="">ফুট :</label>
                                    <input type="text" class="verySmall" value="{{ convertToBanglaNumber($employees->bn_height_inc) }}">
                                    <label for="">ইঞ্চি :</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">৯ । ওজন :</td>
                                <td class="py-1" colspan="8">
                                    <input type="text" class="sminput" value="{{ convertToBanglaNumber($employees->bn_weight_kg) }}">
                                    <label for="">কেজি</label>
                                    <label for="">অভিজ্ঞতা :</label>
                                    <input type="text" class="semiTinput" value="{{ $employees->bn_experience }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">১০ । বৈবাহিক অবস্থা :</td>
                                <td class="py-1" colspan="8">
                                    <input type="text" class="sinput" @if($employees->bn_marital_status=='1') value="{{ 'অবিবাহিত' }}" @else value="{{ 'বিবাহিত' }}" @endif>
                                    <label for="">স্বামী/স্ত্রীর নাম :</label>
                                    <input type="text" class="semiTinput" value="{{ $employees->bn_spouse_name }}">
                                    <label for="">ছেলের নাম :</label>
                                    <input type="text" class="sinput" value="{{ $employees->bn_song_name }}">
                                    <label for="">মেয়ের নাম :</label>
                                    <input type="text" class="sinput" value="{{ $employees->bn_daughters_name }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" colspan="9" style="text-align: left;">
                                    <label for="">১১ । উত্তরাধীকারী (Next of Kin) এর নাম :</label>
                                    <input type="text" class="sinput" value="{{ $employees->bn_legacy_name }}">
                                    <label for="">সম্পর্ক :</label>
                                    <input type="text" class="verySmall" value="{{ $employees->bn_legacy_relation }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" colspan="9" style="text-align: left;">
                                    <label for="">১২ । ভর্তিকারীর সুপারিশ/রেফারেন্স নাম :</label>
                                    <input type="text" class="sinput" value="{{ $employees->bn_reference_admittee }}">
                                    <label for="">মোবাইল :</label>
                                    <input type="text" class="sminput" value="{{ $employees->bn_reference_adm_phone }}">
                                    <label for="" style="padding-left: 11rem;">ঠিকানা :</label>
                                    <input type="text" class="semiSinput" value="{{ $employees->bn_reference_adm_adress }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1" style="text-align: left; width: 25%;">১৩ । আবেদিত পদ :</td>
                                <td class="py-1" colspan="3"><input type="text" class="tinput" value="{{ $employees->position?->name_bn }}"></td>
                                <td class="py-1" colspan="5" style="text-align: left;">ভর্তিকৃত পোষ্টের নাম : <span class="tbborder d-inline-block" style="padding-right:18px; width:50%; padding-top:15px">{{ $employees->bn_addmit_post }}</span></td>
                            </tr>
                            <tr>
                                <th class="py-1" colspan="9" style="text-align: left;">
                                    ১৪ । এই মর্মে আমি অঙ্গীকার করছি যে, আমার দেওয়া উপরুক্ত বিবরণ/ তথ্যাদি সম্পূর্ণ সঠিক। আমি নির্ধারিত বেতনে আবেদিত পদে অস্থায়ীভাবে এলিট সিকিউরিটি সার্ভিসেস লিমিটেড, চট্টগ্রাম এলাকায় করতে আগ্রহী। আমি সজ্ঞানে পড়ে ও বুজে নিন্মে স্বাক্ষর করলাম।
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;"><label for="">তারিখ :{{ !is_null($employees->joining_date) ? convertToBanglaDate(date('d-M-Y', strtotime($employees->joining_date))) : '' }}</label></td>
                                <td colspan="5" style="text-align: right; padding-right: 30px;">
                                    @if($employees->signature_img !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <label for="">(আবেদনকারীর স্বাক্ষর)</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="step-2" role="tabpanel" aria-labelledby="step-2-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_two')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
            </div>
            <div id="result_show_two">
                <div class="row p-3">
                    <table style="width: 100%; margin-top: 1rem;">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: left;">তারিখ: {{ date('d-M-Y', strtotime($employees->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; padding-left: 45px;">
                                    <p style="padding-top: 10px; margin: 0px;">পরিচালক</p>
                                    <p style="margin: 0px;">এলিট সিকিউরিটি সার্ভিসেস লি:</p>
                                    <p style="margin: 0px;">বাড়ি-২, রোড-, লেন-২, ব্লক-কে,</p>
                                    <p style="margin: 0px;">হালিশহর হাউসিং এষ্টেট, চট্টগ্রাম।</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; ">
                                    <label for="">বিষয়:</label>
                                    <span style="border-bottom: solid 1px;"><b>নিরাপত্তা প্রহরী/মহিলা প্রহরী/ সুপারভাইজার পদে নিয়োগের জন্য আবেদন।</b></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;">জনাব,</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <p style="padding-top: 12px; margin: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;বিশ্বস্ত সূত্রে জানিতে পারলাম <b>"এলিট সিকিউরিটি সার্ভিসেস লি "</b> এর অধীনে কিছু সংখক নিরাপত্তা প্রহরী/মহিলা প্রহরী/সুপারভাইজার নিয়োগ করা হইব। উক্ত নিরাপত্তা প্রহরী/মহিলা প্রহরী/সুপারভাইজার পদে একজন আগ্রহী প্রার্থী হিসেবে নিন্মে আমার জীবন বৃত্তান্ত পেশ করলাম:-</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <tbody>
                            <tr>
                                <th class="py-1" style="max-width: 25%;">১. নাম</th>
                                <td class="py-1" style="width: 1%;">:</td>
                                <td class="py-1" style="width: 74%;" colspan="2">{{ $employees->bn_applicants_name }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">২. পিতা নাম </th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->bn_fathers_name }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">৩. মাতার নাম </th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->bn_mothers_name }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">৪. স্থায়ী ঠিকানা </th>
                                <td class="py-1">:</td>
                                <td class="py-1" style="width: 37%;">
                                    <p style="margin: 2px;">গ্রাম: {{ $employees->bn_parm_village_name }}</p>
                                    <p style="margin: 2px;">উপজেলা: {{ $employees->bn_parm_upazilla?->name_bn }}</p>
                                    <p style="margin: 2px;">মোবাইল নং: {{ convertToBanglaNumber($employees->bn_parm_phone_alt) }}</p>
                                </td>
                                <td class="py-1" style="width: 37%;">
                                    <p style="margin: 2px;">পোঃ {{ $employees->bn_parm_post_ofc }}</p>
                                    <p style="margin: 2px;">জেলা: {{ $employees->bn_parm_district?->name_bn }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-1">৫. বর্তমান ঠিকানা </th>
                                <td class="py-1">:</td>
                                <td class="py-1" style="width: 36%;">
                                    <p style="margin: 2px;">হোল্ডিং/বাসা নং {{ $employees->bn_pre_holding_no }}</p>
                                    <p style="margin: 2px;">উপজেলা : {{ $employees->bn_upazilla?->name_bn }}</p>
                                </td>
                                <td class="py-1" style="width: 36%;">
                                    <p style="margin: 2px;">পোঃ {{ $employees->bn_pre_post_ofc }}</p>
                                    <p style="margin: 2px;">গ্রাম/সড়ক: {{ $employees->bn_pre_village_name }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-1">৬. শিক্ষাগতা যোগ্যতা</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2"> {{ $employees->bn_edu_qualification }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">৭. জন্ম তারিখ</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->bn_dob }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">৮. বয়স</th>
                                <td class="py-1">:</td>
                                @php
                                $birthDate = $employees->bn_dob;
                                $age = \Carbon\Carbon::parse($birthDate)->age;
                                @endphp

                                <td class="py-1" colspan="2">{{ convertToBanglaNumber($age) }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">৯. জাতীয়তা</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->bn_nationality }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">১০. ধর্ম</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->religion?->name_bn }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">১১. অভিজ্ঞতা</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ $employees->bn_experience }}</td>
                            </tr>
                            <tr>
                                <th class="py-1">১২. মোবাইল নং</th>
                                <td class="py-1">:</td>
                                <td class="py-1" colspan="2">{{ convertToBanglaNumber($employees->bn_parm_phone_my) }}</td>
                            </tr>
                            <tr>
                                <td class="py-1" colspan="4" style="width: 100%;">অতএব উপরুক্ত তথ্যাদি আলোকে আমাকে উক্ত পদে নিয়োগ দিলে বাদিত থাকিব।</td>
                            </tr>
                            <tr>
                                <th class="py-1" colspan="3">বিনীত নিবেদক</th>
                            </tr>
                            <tr>
                                <th colspan="3" style="">
                                    @if($employees->signature_img !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    আবেদনকারীর স্বাক্ষর
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="step-3" role="tabpanel" aria-labelledby="step-3-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_three')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
            </div>
            <div id="result_show_three">
                <div class="row p-3">
                    <div style="text-align: center; margin-top: 4rem;">
                        <h4>{{ $jobdescription?->head_title }}</h4>
                        <h5><span style="border-bottom: solid 1px;">{{ $jobdescription?->head_title_bn }}</span></h5>
                    </div>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th>
                                    <h6><span style="text-align: left; border-bottom: solid 1px;">পদবী :- {{ $jobdescription?->title_bn }}</span></h6>
                                    <h6><span style="text-align: left; border-bottom: solid 1px;">বিভাগ :- {{ $jobdescription?->department_bn }}</span></h6>
                                    <h6><span style="text-align: left; border-bottom: solid 1px;">দায়িত্ব ও কর্তব্য :</span></h6>
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-left: 2rem;">
                                    @if ($jobdescription?->details)
                                    @foreach ($jobdescription->details as $d)
                                    @if ($d->type == '1')
                                    <p style="margin: 12px;">{{$d->description }}</p>
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%; margin-top: 2rem;">
                        <tbody>
                            <tr>
                                <th>
                                    <h6><span style="text-align: left; border-bottom: solid 1px;">দক্ষতা:</span></h6>
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-left: 2rem;">
                                    @if ($jobdescription?->details)
                                    @foreach ($jobdescription->details as $d)
                                    @if ($d->type == '2')
                                    <p style="margin: 12px;">{{$d->description }}</p>
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <h6><span style="text-align: left; border-bottom: solid 1px;">ব্যাক্তিত্ব:</span></h6>
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-left: 2rem;">
                                    @if ($jobdescription?->details)
                                    @foreach ($jobdescription->details as $d)
                                    @if ($d->type == '3')
                                    <p style="margin: 12px;">{{$d->description }}</p>
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: .5rem; border: solid 1px; text-align:center;">
                                    <h6 class="py-2">আমি এই পত্রখানা পড়িয়া, বুঝিয়া সজ্ঞানে ও স্ব-ইচ্ছায় সাক্ষর করিয়া মূলকপি গ্রহণ করিলাম</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="mt-5" style="width: 100%;">
                        <tbody>
                            <tr>
                                <th style="width: 50%">
                                    {{-- <img src="" alt="alt" width="120px" height="50px;"><br>  --}}
                                    <span style="border-top: solid 1px;">অনুমোদনকারী</span>
                                </th>
                                <th style="width: 50%">
                                    <h6>স্বাক্ষর-</h6>
                                    <h6>পূর্ণ নাম-</h6>
                                    <h6>কার্ড নং-</h6>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="step-4" role="tabpanel" aria-labelledby="step-4-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_four')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
            </div>
            <div id="result_show_four">
                <div class="row p-3">
                    <table style="width: 100%; margin-top: 1rem;">
                        <tbody>
                            <tr>
                                <td style="width: 33%">
                                    <div>
                                        <img class="mt-4" height="80px" width="auto" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                                    </div>
                                </td>
                                <td style="width: 67%; text-align:start;">
                                    <div>
                                        <h5 class="ps-3">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                                        <p class="ps-5">বাড়ি নং-২, লেইন নং-২, রোড নং-২, ব্লক-"কে"</p>
                                        <p style="padding-left:4rem;">হালিশহর হাউজিং এষ্টেট, চট্টগ্রাম- ৪২২</p>
                                        <h6 style="padding-left:4rem;"><span style="border-bottom: solid 1px;">নিরাপত্তা প্রহরীদের পূর্ব পরিচিতি </span></h6>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th>১ । নাম</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                            </tr>
                            <tr>
                                <th>২ । পদবী</th>
                                <th>:</th>
                                <td colspan="2"><input type="text" class="tinput" value="{{ $employees->position?->name_bn }}"></td>
                                <th>আইডি নং</th>
                                <td><input type="text" class="tinput" value="{{ convertToBanglaNumber($employees->admission_id_no) }}"></td>
                            </tr>
                            <tr>
                                <th>৩ । পিতার নাম</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_fathers_name }}"></td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">৪। পিতার পেশা (প্রযোজ্য ক্ষেত্রে )</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $security?->bn_father_profession }}"></td>
                            </tr>
                            <tr>
                                <th>৫। মাতার নাম</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_mothers_name }}"></td>
                            </tr>
                            <tr>
                                <th>৬। স্বামী/স্ত্রীর নাম</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_spouse_name }}"></td>
                            </tr>
                            <tr>
                                <th>৭। স্বামীর পেশা (প্রযোজ্য ক্ষেত্রে )</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $security?->bn_husband_profession }}"></td>
                            </tr>
                            <tr>
                                <th>৮। জন্ম তারিখ</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ convertToBanglaNumber($employees->bn_dob) }}"></td>
                            </tr>
                            <tr>
                                <th>৯ । শিক্ষাগতা যোগ্যতা</th>
                                <th>:</th>
                                <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_edu_qualification }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th style="width: 25%;">১০। স্থায়ী ঠিকানা:</th>
                                <td>
                                    <label for="">গ্রাম/মহল্লা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_parm_village_name }}">
                                    <label for="">ডাকঘর:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_parm_post_ofc }}">
                                    <label for="">উপজেলা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_parm_upazilla?->name_bn }}">
                                    <label for="">জেলা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_parm_district?->name_bn }}">
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">১১। শশুর বাড়ীর স্থায়ী ঠিকানা (বিবাহিত মহিলাদের ক্ষেত্রে ):</th>
                                <td>
                                    <label for="">গ্রাম/মহল্লা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_in_laws_village_name }}">
                                    <label for="">ডাকঘর:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_in_laws_post_office }}">
                                    <label for="">থানা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_in_laws_upazilla_id }}">
                                    <label for="">জেলা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_in_laws_district_id }}">
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">১২। বর্তমান ঠিকানা:</th>
                                <td>
                                    <label for="">গ্রাম/মহল্লা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_pre_village_name }}">
                                    <label for="">ডাকঘর:</label>
                                    <input type="text" class="sbinput" value="{{old('bn_pre_post_ofc',$employees->bn_pre_post_ofc)}}">
                                    <label for="">উপজেলা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_upazilla?->name_bn }}">
                                    <label for="">জেলা:</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_district?->name_bn }}">
                                </td>
                            </tr>
                            <tr>
                                <th>১৩। জমিদারের নাম ও মোবাইল নং:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_landlord_name }} , {{ ($security?->bn_landlord_mobile_no) }}"></td>
                            </tr>
                            <tr>
                                <th>১৪। বর্তমান ঠিকানায় কতদিন যাবৎ বাস করছেন:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_living_dur }}"></td>
                            </tr>
                            <tr>
                                <th>১৫। বৈবাহিক অবস্থা:</th>
                                <td>
                                    <input type="text" class="sbinput" @if($employees->bn_marital_status==1) value="{{ 'অবিবাহিত' }}" @else value="{{ 'বিবাহিত' }}" @endif>
                                    <label for="">জাতীয়তা :</label>
                                    <input type="text" class="sbinput" value="{{ $employees->bn_nationality }}">
                                </td>
                            </tr>
                            <tr>
                                <th>১৬। জাতীয় পরিচয়পত্র নং:</th>
                                <td><input type="text" class="tinput" value="{{ convertToBanglaNumber($employees->bn_nid_no) }}"></td>
                            </tr>
                            <tr>
                                <th>১৭। পাসপোর্ট নং (যদি থাকে):</th>
                                <td><input type="text" class="tinput" value="{{ convertToBanglaNumber($security?->bn_passport_no) }}"></td>
                            </tr>
                            <tr>
                                <th>১৮। পূর্বের কর্মস্থলের নাম কি:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_old_office_name }}"></td>
                            </tr>
                            <tr>
                                <th>১৯। পূর্বের কর্মস্থলের ঠিকানা:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_old_office_address }}"></td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th>২০। পূর্বের কর্মস্থল হতে চাকুরী ছাড়ার কারণ কি:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_resign_reason }}"></td>
                            </tr>
                            <tr>
                                <th>২১। পূর্বের কর্মস্থল অব্যহতি পত্র দিয়েছিলেন কি:</th>
                                <td><input type="text" class="tinput" value="@if ($security?->bn_resign_letter_status=='1') হা @else না @endif"></td>
                            </tr>
                            <tr>
                                <th>২২। সার্ভিস বই আছে কি:</th>
                                <td><input type="text" class="tinput" value="@if ($security?->bn_service_book_status=='1') হা @else না @endif"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th colspan="">২৩। সার্ভিস বই নং (যদি থাকে ):</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_service_book_no }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">২৪। পূর্বের কর্মস্থলে কত টাকা বেতন ছিল:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_old_job_salary }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">২৫। পূর্বের কর্মস্থলে সর্বশেষ পদবী কি ছিল:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_old_job_last_desig }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">২৬। পূর্বের কর্মস্থলে মোট চাকুরীর বয়স কত:</th>
                                <td>
                                    <input type="text" class="tinput" value="{{ $security?->bn_old_job_experience }}">
                                    {{-- <label for="">20 বছর</label>
                                    <label for="">11 মাস </label>
                                    <label for="">20 দিন </label>  --}}
                                </td>
                            </tr>
                            <tr>
                                <th colspan="">২৭। বর্তমান কর্মস্থল হতে আপনার বাসায় যাতায়াতের মাধ্যম কি:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_new_job_transportation }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">২৮। বর্তমান ঠিকানায় কার সাথে বসবাস করছেন:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_current_living }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">২৯। পরিবারে মোট সদস্য সংখ্যা কত:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_total_member }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">৩০। পরিবারে উপার্জনকারী সদস্য সংখ্যা কত:</th>
                                <td><input type="text" class="tinput" value="{{ $security?->bn_solvent_person }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">৩১। মোবাইল ফোন নং (যদি থাকে ):</th>
                                <td><input type="text" class="tinput" value="{{ convertToBanglaNumber($security?->bn_mobile_no) }}"></td>
                            </tr>
                            <tr>
                                <th colspan="">৩২। সীম কার্ড রেজিস্টেশন করা আছে কি:</th>
                                <td><input type="text" class="tinput" value="@if ($security?->bn_sim_card_reg_status=='1') হা @else না @endif"></td>
                            </tr>
                            <tr>
                                <th colspan="">৩৩। আপনার দায়ের করা বা আপনার বিরুদ্ধে থানায় কিংবা আদালতে (স্থানীয় ও বর্তমান ) কোনো মামলা আছে কি:</th>
                                <td><input type="text" class="tinput" value="@if ($security?->bn_case_filed_status=='1') হা @else না @endif"></td>
                            </tr>
                            <tr>
                                <th colspan="">৩৪। পূর্বের কর্মস্থলের একজন কর্মকর্তার নাম:</th>
                                <td>
                                    <input type="text" class="semiSinput" value="{{ $security?->bn_old_job_officer_name }}"><br>
                                    <label for="">পদবী</label>
                                    <input type="text" class="semiSinput" value="{{ $security?->bn_old_job_officer_post }}">
                                    <label for="">ফোন নং:</label>
                                    <input type="text" class="semiSinput" value="{{ $security?->bn_old_job_officer_mobile }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th><span style="border-bottom: solid 1px;">৩৫।দুইজন সনাক্তকারী</span></th>
                                <td>
                                    <label for="">(কে)নাম:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_name1 }}">
                                    <label for="">পেশা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_occupation1 }}">
                                    <label for="">ঠিকানা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_address1 }}">
                                    <label for="">ফোন নং:</label>
                                    <input type="text" class="sbinput" value="{{ convertToBanglaNumber($security?->bn_identifier_phone1) }}">
                                    <label for="">(খ) নাম:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_name2 }}">
                                    <label for="">পেশা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_occupation2 }}"><br>
                                    <label for="">ঠিকানা:</label>
                                    <input type="text" class="sbinput" value="{{ $security?->bn_identifier_address2 }}">
                                    <label for="">ফোন নং:</label>
                                    <input type="text" class="sbinput" value="{{ convertToBanglaNumber($security?->bn_identifier_phone2) }}">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">উপরের বর্ণিত তথ্যাদি সত্য ও সঠিক</th>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="text-align: center;">
                                <th style="width: 50%; padding-bottom: 1rem;">
                                    @if($security?->informant_sing !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/informant_sing/'.$security?->informant_sing)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <span style="border-top: solid 1px;">তথ্যদানকারীর স্বাক্ষর</span>
                                </th>
                                <th style="padding-bottom: 1rem;">
                                    @if($security?->data_collector_sing !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/data_collector_sing/'.$security?->data_collector_sing)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <span style="border-top: solid 1px;">তথ্য সংগ্রহকারীর স্বাক্ষর</span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <hr>  --}}
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <th colspan="2">
                                    <h6 style="margin-bottom:0px !important;"><span style="border-bottom: solid 1px;">অফিস ব্যবহারের অংশ</span></h6>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" style="margin-bottom:0px !important;">
                                    <p>তথপ্রদানকারীর তথ্য ও সকল কাগজপত্র পর্যবেক্ষন ও সনাক্তকারীদের নিশ্চয়তার ভিত্তিতে তথ্য সমূহ সঠিক/সঠিক নহে বলে প্রতীয়মান হয়েছে।<br>উপরুক্ত তথ্য যাচাইয়ের ক্ষেত্রে ব্যবহৃত মাধ্যম : </p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="text-align: center">
                                <th style="width: 50%;">
                                    @if($security?->executive_sing !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/executive_sing/'.$security?->executive_sing)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <span style="border-top: solid 1px;">এক্সেকিউটিভ(এইচআর)</span>
                                </th>
                                <th>
                                    @if($security?->manager_sing !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/manager_sing/'.$security?->manager_sing)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <span style="border-top: solid 1px;">ম্যানেজার (অপারেশন )</span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="step-5" role="tabpanel" aria-labelledby="step-5-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_five')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
            </div>
            <div id="result_show_five">
                <div class="row p-3">
                    <div style="page-break-inside: avoid;">
                        <div class="text-center" style="margin-top: 2rem;">
                            <h4><span style="border-bottom: solid 1px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড এ ভর্তি হয়ে চাকুরীকালীন সময়ে পালনীয় দায়িত্ব ও শর্তাবলী</span></h4>
                        </div>
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>
                                            ১। যোগ্যতা সম্পন্ন প্রত্যেক আবেদনকারীকে ৩,৫০০/- (তিন হাজার পাঁচশত টাকা) প্রশিক্ষণ ফি (অফেরতযোগ্য) বাবদ জমা দিতে হবে। আবেদন পত্রের সাথে রিক্রুটিং অফিসারের নিকট প্রয়োজনীয় কাগজপত্র (সদ্য উত্তোলনকৃত চেয়ারম্যান সার্টিফিকেটের মূল কপি, জাতীয় পরিচয় পত্রের ফটোকপি, জন্ম নিবন্ধন এর সনদ, শিক্ষাগত যোগ্যতার সনদ, ১ কপি পাসপোর্ট সাইজ ছবি ও নমনীর জাতীয়পরিচয়পত্র এবং ছবি) জমা দিয়ে নির্দিষ্ট পদের জন্য ভর্তি হতে হবে।
                                        </p>
                                        <p>
                                            ২। ভর্তির পরে আমার নিজ দায়িত্বে আমার স্থায়ী ঠিকানার পুলিশ কর্তৃপক্ষ থেকে প্রাক-পরিচিতি যাচাই পূর্বক পুলিশ ভেরিফিকেশন প্রতিবেদনটি অনতিবিলম্বে এলিট ফোর্স, চট্টগ্রাম অফিসে জমা করতে বাধ্য থাকবো। তবে পরবর্তীতে পুলিশ ভেরিফিকেশন রিপোর্ট এর সাথে আমার দেওয়া তথ্য ভূয়া/মিথ্যা প্রমাণিত হলে আমাকে বিনা নোটিশে চাকুরীচ্যুত করা হবে এবং আইনানুগ ব্যবস্থা নেয়া হবে।
                                        </p>
                                        <p>
                                            ৩। আমি অত্র সংস্থায় কমপক্ষে তিন বছর চাকুরী করিতে বাধ্য থাকবো।
                                        </p>
                                        <p>
                                            ৪। ভর্তির পরে প্রত্যেক প্রহরীকে এলিট সিকিউরিটি সার্ভিসেস লিঃ এর প্রশিক্ষণ কেন্দ্র থেকে কোম্পানীর নির্ধারিত নিয়ম ও সিলেবাস অনুযায়ী প্রশিক্ষণ গ্রহণ করতে বাধ্য থাকবো। প্রশিক্ষণ গ্রহণকালে কোন প্রকার বেতন/ভাতা প্রদান করা হবে না। তবে বিনামূল্যে থাকা ও খাওয়ার ব্যবস্থা করা হবে।
                                        </p>
                                        <p>
                                            ৫। সাফল্যের সাথে প্রশিক্ষণ শেষে কোম্পানীর নির্ধারিত নিয়ম অনুযায়ী ১ সেট পোশাক বিনামূল্যে প্রদান করে যোগ্যতা অনুযায়ী উপযুক্ত পোষ্টে পোষ্টিং দেয়া হবে । শীতকালিন সময়ে ১টি জ্যাকেট এবং বর্ষার পূর্বে ১টি ছাতাও বিনামূল্যে প্রদান করা হবে। তবে চাকুরী থেকে অব্যহতি নেওয়ার সময় এই সকল পোশাক জমা করা বাধ্যতামূলক।
                                        </p>
                                        <p>
                                            ৬। চাকুরীকালীন সময় নির্ধারিত হারে প্রভিডেন্ট ফান্ড (ফেরতযোগ্য) ও গ্রুপ জীবন বীমার প্রিমিয়াম (অফেরতযোগ্য) জমা করতে হবে।
                                        </p>
                                        <p>
                                            ৭। চাকুরীতে যোগদানের পরে কোন গার্ড বিনা কারণে কর্তৃপক্ষের অনুমতি ব্যতিত কোন অবস্থাতেই ডিউটি থেকে অনুপস্থিত থাকতে পারবেনা। একদিনের অনুপস্থিতির জন্য ২ দিনের বেতন কাটা যাবে।
                                        </p>
                                        <p>
                                            ৮। ডিউটি পোষ্টে সঠিক সময় অর্থাৎ ডিউটি শুরু হওয়ার কমপক্ষে ১৫ মিনিট পূর্বে উপস্থিত হতে হবে। পর পর ৩ দিন বিলম্ব করে ডিউটিতে আসলে ১ দিনের বেতন কাটা যাবে।
                                        </p>
                                        <p>
                                            ৯। ডিউটিরত অবস্থায় ঘুমন্ত পাওয়া গেলে কমপক্ষে ১ দিনের বেতন কাটা যাবে। এরূপ পর পর তিন দিন ঘুমের রিপোর্ট পাওয়া গেলে বিনা নোটিশে ও বিনা বেতনে চাকুরি থেকে বহিষ্কার করা হবে।
                                        </p>
                                        <p>
                                            ১০। এলিট সিকিউরিটি সার্ভিসেস লিঃ কর্তৃপক্ষ অফিস কিংবা পোষ্টের নিরাপত্তার স্বার্থে/সুবিধার্থে যে কোন সময় যে কোন গার্ডকে চাকুরী থেকে অব্যহতি প্রদানের ক্ষমতা রাখে। আবেদনকারী কোন ছল-চাতুরী কিংবা থানা-পুলিশ ও শ্রমিক আদালতে অভিযোগ করতে পারবে না বা তাহা করলে আইনগত অগ্রাহ্য হবে ।
                                        </p>
                                        <p>
                                            ১১। প্রহরী কোন অবস্থাতেই কোম্পানীর নিরাপত্তা সেবা গ্রহণকারীদের সাথে বেয়াদবি কিংবা অসদাচরণ করতে পারবে না। ডিউটি পোষ্টে সম্মানিত গ্রাহক/কাষ্টমারদের অনুমতি ব্যতিত কোন দর্শনার্থী/অতিথি এমনকি কোন সরকারী কর্মকর্তাকেও গেইটের ভিতরে প্রবেশ করতে দিবে না।
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="page-break-inside: avoid;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>
                                            ১২। কোন প্রহরী চুরি, ডাকাতি, রাহাজানি কিংবা কোন অসামাজিক কাজে লিপ্ত হতে পারবে না। এ রকম কোন কাজে লিপ্ত হলে অথবা অন্য কাউকে সহযোগীতা করার প্রমাণ পাওয়া গেলে তাহলে আর্থিক জরিমানা/দন্ড এবং চাকুরীচ্যুতসহ তার বিরুদ্ধে গণপ্রজাতন্ত্রী বাংলাদেশ সরকারে প্রচলিত আইন অনুসারে প্রয়োজনীয় ব্যবস্থা গ্রহণ করা হবে।
                                        </p>
                                        <p>
                                            ১৩। যদি কোন প্রহরী চাকুরী হতে অব্যাহতি পেতে চায় তাহলে কমপক্ষে ২ (দুই) মাস পূর্বে তাকে কোম্পানীর কাছে লিখিত দরখাস্ত প্রদান করতে হবে এবং তার স্থলে উপযুক্ত একজন বদলী প্রহরী ভর্তির ব্যবস্থা করতে হবে। অফিস কর্তৃপক্ষ দরখাস্ত গ্রহণের ২ (দুই) মাস পরে দেনা-পাওনা বুঝিয়ে দিয়ে চাকুরী থেকে অব্যাহতি প্রদান করবে যদি কমপক্ষে তার চাকুরী ৩ বছর পূর্ণ হয়। তবে শর্ত থাকে যে তাকে প্রদানকৃত সকল পোশাক পরিচ্ছেদ এলিট ফোর্স, চট্টগ্রাম অফিসে জমা করে ছাড়পত্র গ্রহণ করতে হবে।
                                        </p>
                                        <p>
                                            ১৪ । এক বার চাকুরী থেকে অব্যাহতি নিয়ে যাওয়ার পর পরবর্তীতে পুনরায় ভর্তি হওয়ার ইচ্ছা প্রকাশ করলে পুনরায় প্রশিক্ষণ ফি জমা দিয়ে ভর্তি হতে হবে । তবে শর্ত থাকে যে তিন মাসের কম সময়ে পুনঃভর্তি হলে প্রশিক্ষণ ফি মওকুফ করা যাবে।
                                        </p>
                                        <p>
                                            ১৫ । এই প্রতিষ্ঠানের অধীনে চাকুরিটি অস্থায়ী এবং কোম্পানীর প্রদত্ত নিয়ম অনুযায়ী এক বছর চাকুরী পূর্ণ হলে ঈদ/পূজা উপলক্ষে কোম্পানীর সামর্থ অনুযায়ী বোনাস এবং ছুটির টাকা দেওয়ার ব্যবস্থা আছে।
                                        </p>
                                        <p>
                                            ১৬। কোন ধর্মীয় উৎসব এবং জাতীয় দিবসগুলোতে বন্ধকালীন সময়ের পূর্বে চাকুরী থেকে অব্যাহতিপত্র গ্রহণ করা হবে না এবং ছুটিও দেয়া যাবে না। প্রয়োজনে পরে বিবেচনা যোগ্য ।
                                        </p>
                                        <p>
                                            ১৭। ভালো ডিউটির জন্য প্রত্যেক প্রহরী বছর শেষে প্রমোশন, বেতন বৃদ্ধি ও অন্যান্য সুবিধা পেতে পারে। ভাল কাজ করা সাপেক্ষে বিশেষ পুরষ্কার প্রদান করা হবে।
                                        </p>
                                        <p>
                                            ১৮। প্রত্যেক প্রহরী তার দৈনন্দিন ডিউটি শুরু হওয়ার পূর্বে ডিউটি রেজিষ্টারে নাম, তারিখ ও সময় লিখে স্বাক্ষর করবে। ডিউটি রেজিষ্টারে কোনরূপ কাটা ছেড়া করতে পারবে না। অফিস কর্মকর্তা/জোন ইন্সপেক্টর/সুপারভাইজার/সিনিয়র গার্ড কর্তৃক নির্ধারিত ডিউটি রোষ্টার অনুসারে ডিউটি হবে যেখানে আপনি বুঝে স্বাক্ষর করবেন এবং মাস শেষে আপনার হাজিরা শীটে হাজিরার স্বাক্ষর অনুযায়ী বেতন প্রদান করা হবে।
                                        </p>
                                        <p>
                                            ১৯। কোন প্রহরী কোম্পানীর কোন সুপারভাইজার, ইন্সপেক্টর, অফিসার কিংবা কর্মকর্তাদের সাথে বেয়াদবী, খারাপ আচরণ করতে পারবে না । যদি এ ধরনের অভিযোগ পাওয়া যায় তবে তার বিরুদ্ধে কঠোর ব্যবস্থা নেয়া হবে।
                                        </p>
                                        <p>
                                            ২০। প্রত্যেক প্রহরীকে সব সময় পরিস্কার পরিচ্ছন্ন থাকতে হবে, ক্লিন সেভ করবে, বুট পালিশ করবে, নিয়ম মত চুল কাটা রাখবে, ইউনিফর্ম, বেল্ট ও টুপি পরিহিত অবস্থায় লাঠি ও বাঁশি সহ ডিউটি পোষ্টে সময়মত হাজির হতে হবে। ডিউটিরত অবস্থায় ইউনিফর্ম, বেল্ট, টুপি, জুতা-মোজা খোলা যাবে না। পোষ্ট পরিদর্শনের সময় ডিউটিরত অফিসার কোনরূপ ভুল-ত্রুটি অথবা অনিয়ম লক্ষ্য করলে গার্ডের বিরুদ্ধে আর্থিক কিংবা সংশোধনমূলক শাস্তি প্রদান করতে পারবেন।
                                        </p>
                                        <p>
                                            ২১। কোন অবস্থাতেই গার্ড তার ডিউটি পোষ্টে পরবর্তী বদলী প্রহরী না আসা পর্যন্ত পোষ্ট ত্যাগ করতে পারবে না। এমতাবস্থায় খালি রেখে পোষ্ট ত্যাগ করলে ২ দিনের বেতন কর্তনসহ চাকুরীচ্যুত করা হবে।
                                        </p>
                                        <p>
                                            ২২। প্রহরী অসুস্থ হলে নিজ দায়িত্বে বদলীর ব্যবস্থা করবেন বা জোন কমান্ডারকে অবগত করে বদলী প্রহরীর ব্যবস্থা করবেন।
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="page-break-inside: avoid;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p style="margin-bottom: 0px !important">
                                            ২৩। ভর্তির পর ৬(ছয়) মাসের মধ্যে ছুটি দেওয়া যাবে না। কেউ বিবাহিত হলে এবং ফ্যামিলি গ্রামের বাড়ীতে থাকলে ৩ মাস পরে ছুটি দেওয়া যেতে পারে। জরুরী প্রয়োজন, দুর্ঘটনা কিংবা কোন বিশেষ প্রয়োজনে অবশ্যই ছুটি বিবেচনা যোগ্য ।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৪। প্রহরীগণ বছরে ১২ দিন ছুটি পাওয়ার যোগ্য। তবে ১ বছর চাকুরী শেষে এই ছুটির আংশিক বেতন প্রদানযোগ্য।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৫। কোন ব্যক্তি/প্রহরী এলিট সিকিউরিটি সার্ভিসেস লিঃ এ ভর্তি হওয়ার পরে কোন অবস্থাতেই কোন সমিতি অথবা ট্রেড ইউনিয়ন সংগঠন করতে বা এই ধরণের কোন সংগঠনের কর্মকান্ডের সাথে সম্পৃক্ত হতে/থাকতে পারবে না।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৬। অত্র কোম্পানীর অধীনে প্রহরীর দায়িত্বরত কোন পোষ্টে ব্যক্তিগতভাবে চাকুরীর জন্য আমাদের সম্মানিত গ্রাহকের সাথে যোগাযোগ করতে পারবে না কিংবা চাকুরী নিতে পারবে না। ইহাতে আইনানুগ ব্যবস্থাসহ বেতন বাজেয়াপ্ত হবে।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৭। প্রত্যেক প্রহরীকে কোম্পানীর প্রয়োজনে যে কোন সময় যে কোন স্থানে চাকুরী/ডিউটি/ওভার টাইম করার জন্য প্রস্তুত/রাজি থাকতে হবে।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৮। প্রহরীর কর্তব্যস্থান থেকে কোন কিছু চুরি/হারানো/খোয়া অথবা ক্ষতি সাধিত হলে তার জন্য দায়িত্ব পালনকারী প্রহরী দায়ী হবে এবং ক্ষতিপূরণ হিসেবে সমপরিমাণ টাকা পরিশোধ করতে বাধ্য থাকবে।
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ২৯। দায়িত্ব পালনকালীন সময়ে কারো থেকে কোনো বখশিস/আর্থিক সাহায্য চাওয়া যাবে না
                                        </p>
                                        <p style="margin-bottom: 0px !important">
                                            ৩০। চাকুরী হতে অব্যহতিকালীন অথবা চাকুরী করা অবস্থায় কোম্পানী প্রদত্ত আইডি কার্ড ও কিটবুক হারানো গেলে থানায় সাধারণ ডায়েরী করতে হবে। সাধারণ ডায়েরীর প্রমাণ অফিসে জমা করে পুনরায় আইডি কার্ড এবং কিটবুক ইস্যু করা যাবে। অন্যথায় প্রতিটির জন্য ১০০/- (একশত টাকা) হারে জরিমানা আদায়যোগ্য ।
                                        </p>
                                    </td>
                                    {{-- <img src="{{asset('assets/images/terms1.jpeg')}}" alt=""><br /> --}}
                                </tr>
                                <tr style="text-align: end">
                                    <td><img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br /></td>
                                </tr>
                                <tr>
                                    <td>আবেদনকারীর স্বাক্ষর</td><br />
                                </tr>
                                {{-- <h5><span style="border-bottom: solid 1px;">পৃষ্ঠা-৩</span></h5>  --}}
                            </tbody>
                        </table>
                        <div style="text-align: center;">
                            <h4 style="margin-bottom: 0px;"><span style="border-bottom: solid 1px;">অঙ্গীকারনামা</span></h4>
                        </div>
                        <table style="width: 100%; margin-bottom: 3rem;">
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <table>
                                            <tr>
                                                <td class="py-1" style="text-align: left; width: 15%;">আমি, নামঃ</td>
                                                <td class="py-1" style="width: 25%;"><input type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                                                <td class="py-1" style="text-align: center; width: 10%;">পিতাঃ</td>
                                                <td class="py-1" style="width: 15%;"><input type="text" class="tinput" value="{{ $employees->bn_fathers_name }}"></td>
                                                <td class="py-1" style="text-align: center; width: 35%;">উপরের উল্লেখিত ১ থেকে ৩০ পর্যন্ত</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style='text-align:justify;'>
                                        শর্তাবলি ভালোভাবে পড়ে ও বুঝে, অত্র কোম্পানীর(এলিট সিকিউরিটি সার্ভিসেস লিঃ) এ চাকুরী করার জন্য রাজি আছি। আমি সর্ব
                                        অবস্থায় এ শর্তগুলো মেনে চলবো। কোন অবস্থাতেই ব্যতিক্রম বা কোম্পানীর স্বার্থ বিরোধী কোন কাজ করবো না। করলে
                                        কোম্পানী আমার বিরুদ্ধে শাস্তিমূলক ব্যবস্থাসহ দেশের প্রচলিত আইন অনুযায়ী ব্যবস্থা গ্রহন করতে পারবে। আমি বর্তমানে
                                        বাংলাদেশের কোন ট্রেড ইউনিয়ন/সংগঠন/সমিতির সদস্য নই এবং ভবিষ্যতেও সদস্য হবো না।আমার বিরুদ্ধে কোন আদালতে কোন
                                        মামলা/মোকাদ্দমা নেই,আমি কোন আদালত কর্তৃক সাজাপ্রাপ্ত হইনি এবং কোন আদালতের/পুলিশের গ্রেপ্তারি পরোয়ানাভুক্ত নই।
                                        আমি ইতিপূর্বে রাষ্ট্র বিরোধী কোন কর্মকান্ডে জড়িত ছিলাম না।ইহার ব্যতিক্রম হলো এলিট সিকিউরিটি সার্ভিসেস লিঃ কর্তৃপক্ষ
                                        আমার বিরুদ্ধে চাকরিচ্যুতসহ আইনানুগ ব্যবস্থা গ্রহন করতে পারবেন।
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        আমি সজ্ঞানে পড়ে, বুঝে ও সকল শর্ত মেনে নিয়ে নিজ ইচ্ছায় আমার স্বাক্ষর প্রদান করলাম। ভর্তিকালীন সময়ে প্রশিক্ষণ ফি বাবদ
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table>
                                            <tr>
                                                <td style="text-align: left; width: 6% !important;">নগদ</td>
                                                <td style="width: 10% !important;"><input readonly type="text" class="verySmall" value=""></td>
                                                <td style="text-align: center; width: 25% !important;">টাকা প্রদান করলাম।বাকী</td>
                                                <td style="width: 7% !important;"><input readonly type="text" class="verySmall" value=""></td>
                                                <td style="text-align: center; width: 50% !important;">টাকা আমার মাসিক বেতন থেকে সমন্বয় করে দিব।</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 15%;">স্বাক্ষীর স্বাক্ষরঃ </td>
                                    <td style="width: 30%;"></td>
                                    <td style="text-align: end; width: 25%;">স্বাক্ষরঃ</td>
                                    <td colspan="2" style="width: 30%;"><input readonly type="text" class="tinput" value=""></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 15%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="text-align: end; width: 25%;">আবেদনকারীর নামঃ</td>
                                    <td colspan="2" style="width: 30%;"><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 15%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="text-align: end; width: 25%;">তারিখ</td>
                                    <td colspan="2" style="width: 30%;"><input readonly type="text" class="tinput" value="{{ date('d-M-Y', strtotime($employees->created_at)) }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="page-break-inside: avoid;">
                        <table style="width: 100%;">
                            {{-- <p style="text-align: center;">পৃষ্ঠা-৪</p>  --}}
                            <div style="text-align: center;">
                                <h4 style="margin-top:2px !important;"><span style="border-bottom: solid 1px; margin-top:1px !important">অফিসে ব্যবহারের জন্য</span></h4>
                            </div>
                            <tbody>
                                <tr>
                                    <td colspan="5" style='text-align:justify;'>
                                        আবেদনকারীর শারীরিক, মানসিক ও শিক্ষাগত যোগ্যতা বিবেচিত হওয়ার ফলে এলিট সিকিউরিটি সার্ভিসেস লিঃ এর
                                        অধীনে <b>{{ $employees->position?->name_bn }}</b> পদে প্রাথমিকভাবে নির্বাচন করে
                                        ভর্তি করা হলো। ভর্তির তারিখ <b>{{ date('d-M-Y', strtotime($employees?->created_at)) }}</b> । প্রশিক্ষণ ফি সম্পূর্ণ নগদ প্রদানে অপরাগতায় জাতীয় পরিচয়
                                        পত্র নম্বর <b>{{ $employees->bn_nid_no }} </b> এর কার্ডটি জমা রাখা হল যা ভর্তির শর্ত পূর্ণ হলে ফেরত প্রদানযোগ্য।
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 15%; padding-top: 50px;">প্রশিক্ষণ কর্মকর্তা </td>
                                    <td style="text-align: center; width: 25%; padding-top: 50px;">ডিজিএম/জেনারেল ম্যানেজার</td>
                                    <td style="text-align: end; width: 25%; padding-top: 50px;">জোন কমান্ডার/ভর্তিকারী কর্মকর্তা</td>
                                    <td style="width: 10%;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="page-break-inside: avoid;">
                        <div style="text-align: center;">
                            <h5 style="margin-top:10px !important;"><span style="border-bottom: solid 1px; margin-top:1px !important">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড এর প্রশিক্ষণ ফি প্রদান সংক্রান্ত স্বেচ্ছায় হলফনামাঃ</span></h5>
                        </div>
                        <div>
                            <p>আমি {{ $employees->bn_applicants_name }}, বয়সঃ {{$age}}, পিতাঃ {{ $employees->bn_fathers_name }}, মাতাঃ {{ $employees->bn_mothers_name }}, স্থায়ী ঠিকানাঃ গ্রামঃ {{ $employees->bn_parm_village_name }}, ডাকঘরঃ {{ $employees->bn_parm_post_ofc }}, থানাঃ {{ $employees->bn_parm_upazilla?->name_bn }}, {{ $employees->bn_parm_district?->name_bn }}, এলিট সিকিউরিটি সার্ভিসেস লিঃ এ নিরাপত্তা প্রহরী হিসেবে প্রশিক্ষণ নিতে আগ্রহী।</p>
                            <p class="my-0">এলিট সিকিউরিটি সার্ভিসেস লিঃ-এ প্রশিক্ষণ পূর্ববর্তী থাকা, খাওয়া ও প্রশিক্ষণ খরচের ৫০% কোম্পানী বহন করবে এবং বাকি ৫০% খরচ প্রশিক্ষণ ফি বাবদ {{round($employees->bn_traning_cost+$employees->bn_remaining_cost)}} /- টাকা (অফেরতযোগ্য) নির্ধারিত। আমি স্বজ্ঞানে, সুস্থ মস্তিস্কে হলফপূর্বক ঘোষণা করছি যে, প্রশিক্ষণ গ্রহণের পূর্বে আমি প্রশিক্ষণ ফি বাবদ @if($employees->bn_traning_cost > 0) {{round($employees->bn_traning_cost)}} @else <span>০-/</span> @endif টাকা প্রদান করি। প্রশিক্ষণ ফি বাবদ বাকি @if($employees->bn_remaining_cost > 0) {{round($employees->bn_remaining_cost)}} @else <span>০-/</span> @endif টাকা আমার মাসিক বেতন থেকে ছয় মাসে কর্তন করা হলে আমার কোনো প্রকার আপত্তি থাকবে না। প্রশিক্ষণ ফি প্রদানের ব্যাপারে আমার কোনো অভিযোগ/আপত্তি নেই।</p>
                        </div>
                        <table style="width: 100%;">
                            <p style="text-align: left; padding-top: 17px; margin-top: 2rem;"><span style="border-top: solid 2px;">ঘোষণাকারীর স্বাক্ষর</span></p>
                            <div style="text-align: center;">
                                <h4><span style="border-bottom: solid 1px;">আঙ্গুলের ছাপ</span></h4>
                            </div>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%;">বাম</td>
                                    <td style="text-align: end; width: 40%;"></td>
                                    <td style="width: 10%;">ডান</td>
                                    <td style="width: 20%;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 10px;">১.কনিষ্ঠ
                                        @if($employees->biometrics->where('hand_type', 1)->where('finger_type', 5)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 1)->firstWhere('finger_type', 5)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="text-align: end; width: 40%;">
                                    </td>
                                    <td style="width: 10%; padding-bottom: 10px;">১.কনিষ্ঠ
                                        @if($employees->biometrics->where('hand_type', 2)->where('finger_type', 5)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 2)->firstWhere('finger_type', 5)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="width: 20%;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 10px;">২.অনামিকা
                                        @if($employees->biometrics->where('hand_type', 1)->where('finger_type', 4)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 1)->firstWhere('finger_type', 4)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="text-align: end; width: 40%;">
                                    </td>
                                    <td style="width: 10%; padding-bottom: 10px;">২.অনামিকা
                                        @if($employees->biometrics->where('hand_type', 2)->where('finger_type', 4)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 2)->firstWhere('finger_type', 4)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="width: 20%;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 10px;">৩.মধ্যমা
                                        @if($employees->biometrics->where('hand_type', 1)->where('finger_type', 3)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 1)->firstWhere('finger_type', 3)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="text-align: end; width: 40%;">
                                    </td>
                                    <td style="width: 10%; padding-bottom: 10px;">৩.মধ্যমা
                                        @if($employees->biometrics->where('hand_type', 2)->where('finger_type', 3)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 2)->firstWhere('finger_type', 3)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="width: 20%;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 10px;">৪.তর্জনী
                                        @if($employees->biometrics->where('hand_type', 1)->where('finger_type', 2)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 1)->firstWhere('finger_type', 2)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="text-align: end; width: 40%;">
                                    </td>
                                    <td style="width: 10%; padding-bottom: 10px;">৪.তর্জনী
                                        @if($employees->biometrics->where('hand_type', 2)->where('finger_type', 2)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 2)->firstWhere('finger_type', 2)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="width: 20%;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 10px;">৫.বৃদ্ধা
                                        @if($employees->biometrics->where('hand_type', 1)->where('finger_type', 1)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 1)->firstWhere('finger_type', 1)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="text-align: end; width: 40%;">

                                    </td>
                                    <td style="width: 10%; padding-bottom: 10px;">৫.বৃদ্ধা
                                        @if($employees->biometrics->where('hand_type', 2)->where('finger_type', 1)->isNotEmpty())
                                        <img src="{{ asset('uploads/fingerprints/' . $employees->biometrics->firstWhere('hand_type', 2)->firstWhere('finger_type', 1)->img) }}" alt="Fingerprint Image" width="50" class="mt-1 d-block">
                                        @endif
                                    </td>
                                    <td style="width: 20%;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 20%;"></td>
                                    <td style="width: 10%; padding-bottom: 20px;">৬.নমুনা স্বাক্ষর</td>
                                    <td style="width: 30%;"><input type="text"></td>
                                    <td style="width: 10%;"><input type="text"></td>
                                    <td style="width: 30%;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 5%;">তারিখ </td>
                                    <td style="width: 30%;"><input readonly type="text" class="tinput" value="{{ date('d-M-Y', strtotime($employees->created_at)) }}"></td>
                                    <td style="text-align: end; width: 25%;">নামঃ</td>
                                    <td style="width: 10%;"><input readonly type="text" class="tinput" value=""></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 5%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="text-align: end; width: 25%;">নংঃ</td>
                                    <td style="width: 10%;"><input readonly type="text" class="tinput" value=""></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 5%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="text-align: end; width: 25%;">স্বাক্ষরঃ</td>
                                    <td style="width: 10%;"><input readonly type="text" class="tinput" value=""></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="step-6" role="tabpanel" aria-labelledby="step-6-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_six')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                        </g>
                    </svg></a>
                <!-- <button id="downloadDoc">Download as DOC</button> -->
                <a href="{{route('employee.exportToWord', ['id' => $employees->id])}}" class="no_print" title="print"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35" viewBox="0 0 48 48">
                        <path d="M 17.4375 5 C 14.969999 5 12.9375 7.0324991 12.9375 9.5 A 1.50015 1.50015 0 1 0 15.9375 9.5 C 15.9375 8.6535009 16.591001 8 17.4375 8 L 40.480469 8 C 41.326968 8 41.980469 8.6535009 41.980469 9.5 L 41.980469 13.550781 L 27.298828 13.550781 A 1.50015 1.50015 0 1 0 27.298828 16.550781 L 41.980469 16.550781 L 41.980469 22.365234 L 27.298828 22.365234 A 1.50015 1.50015 0 1 0 27.298828 25.365234 L 41.980469 25.365234 L 41.980469 31.236328 L 28.488281 31.236328 A 1.50015 1.50015 0 1 0 28.488281 34.236328 L 41.980469 34.236328 L 41.980469 38.5 C 41.980469 39.346499 41.326968 40 40.480469 40 L 17.4375 40 C 16.591001 40 15.9375 39.346499 15.9375 38.5 A 1.50015 1.50015 0 1 0 12.9375 38.5 C 12.9375 40.967501 14.969999 43 17.4375 43 L 40.480469 43 C 42.94797 43 44.980469 40.967501 44.980469 38.5 L 44.980469 9.5 C 44.980469 7.0324991 42.94797 5 40.480469 5 L 17.4375 5 z M 6.1054688 13 C 4.4078712 13 3 14.409085 3 16.105469 L 3 31.894531 C 3 33.592129 4.409085 35 6.1054688 35 L 15.894531 35 A 1.50015 1.50015 0 1 0 15.894531 32 L 6.1054688 32 C 6.0298524 32 6 31.970934 6 31.894531 L 6 16.105469 C 6 16.029852 6.0290662 16 6.1054688 16 L 6.2128906 16 A 1.50015 1.50015 0 1 0 6.2128906 13 L 6.1054688 13 z M 10.957031 13 A 1.50015 1.50015 0 1 0 10.957031 16 L 21.894531 16 C 21.970148 16 22 16.029066 22 16.105469 L 22 31.896484 C 22 31.972104 21.97093 32.001953 21.894531 32.001953 L 20.787109 32.001953 A 1.50015 1.50015 0 1 0 20.787109 35.001953 L 21.894531 35.001953 C 23.592129 35.001953 25 33.592868 25 31.896484 L 25 16.105469 C 25 14.407871 23.590915 13 21.894531 13 L 10.957031 13 z M 7.8828125 18.939453 C 7.8068125 18.939453 7.7335469 18.975156 7.6855469 19.035156 C 7.6385469 19.095156 7.6216719 19.172094 7.6386719 19.246094 L 9.8945312 28.867188 C 9.9205312 28.980187 10.020719 29.060547 10.136719 29.060547 L 12.400391 29.060547 C 12.517391 29.060547 12.619531 28.979234 12.644531 28.865234 L 14.046875 22.5625 L 15.451172 28.865234 C 15.476172 28.980234 15.578313 29.060547 15.695312 29.060547 L 17.861328 29.060547 C 17.977328 29.060547 18.079469 28.980188 18.105469 28.867188 L 20.359375 19.246094 C 20.378375 19.171094 20.361453 19.093203 20.314453 19.033203 C 20.266453 18.973203 20.193187 18.939453 20.117188 18.939453 L 18.236328 18.939453 C 18.118328 18.939453 18.016188 19.021719 17.992188 19.136719 L 16.736328 25.035156 L 15.34375 19.132812 C 15.31775 19.019813 15.215609 18.939453 15.099609 18.939453 L 12.996094 18.939453 C 12.880094 18.939453 12.779906 19.020813 12.753906 19.132812 L 11.308594 25.253906 L 10.007812 19.138672 C 9.9838125 19.023672 9.8816719 18.939453 9.7636719 18.939453 L 7.8828125 18.939453 z"></path>
                    </svg>
                </a>
            </div>
            <div id="result_show_six">

                <section>
                    <div style="page-break-inside: avoid;">
                        {{-- <div class="row mb-2">
                            <div class="col-3 mt-2">
                                <img height="auto" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                    </div>
                    <div class="col-6 text-center mt-3">
                        <h6>ELITE SECURITY SERVICES LIMITED </h6>
                        <p style="margin: 1px;">BIO-DATA</p>
                        <p style="margin: 1px;"><b style="border-bottom: solid 1px;">{{ $employees->position?->name }}</b></p>
                    </div>
                    <div class="col-3 text-end">
                        <img class="tbl_border" height="auto" width="120px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="No Img">
                    </div>
            </div> --}}
            <table style="width: 100%; margin-bottom: 10px; border: none;">
                <tr>
                    <!-- Logo on the left side -->
                    <td style="width: 20%; vertical-align: middle;">
                        <img height="auto" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                    </td>

                    <!-- Center text in the middle -->
                    <td style="width: 60%; text-align: center; vertical-align: middle;">
                        <h6 style="margin: 0; font-size: 16px;">ELITE SECURITY SERVICES LIMITED</h6>
                        <p style="margin: 1px; font-size: 12px;">BIO-DATA</p>
                        <p style="margin: 1px; font-size: 14px;"><b style="border-bottom: solid 1px;">{{ $employees->position?->name }}</b></p>
                    </td>

                    <!-- Employee photo on the right side -->
                    <td style="width: 20%; text-align: right; vertical-align: middle;">
                        <img class="tbl_border" height="auto" width="120px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="No Img">
                    </td>
                </tr>
            </table>


            <table class="tbl_border" style="width: 100%;">
                <tbody>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">1</th>
                        <th class="tbl_border" style="padding: 6px;">Name</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_applicants_name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">2</th>
                        <th class="tbl_border" style="padding: 6px;">Designation</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->position?->name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">3</th>
                        <th class="tbl_border" style="padding: 6px;">Place of Posting</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_place_of_posting }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">4</th>
                        <th class="tbl_border" style="padding: 6px;">Employee ID No</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->admission_id_no }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">5</th>
                        <th class="tbl_border" style="padding: 6px;">Height</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_height_foot }} Feet {{ $employees->en_height_inc }} Inch</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">6</th>
                        <th class="tbl_border" style="padding: 6px;">Blood Group</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->bloodgroup?->name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">7</th>
                        <th class="tbl_border" style="padding: 6px;">Father's Name</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_fathers_name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">8</th>
                        <th class="tbl_border" style="padding: 6px;">Mother's Name</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_mothers_name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">9</th>
                        <th class="tbl_border" style="padding: 6px;">Next of Kin(NOK)</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_legacy_name }} @if($employees->en_legacy_relation != '')({{ $employees->en_legacy_relation }}) @else @endif</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">10</th>
                        <th class="tbl_border" style="padding: 6px;">Present Address</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">
                            @if ($employees->en_pre_holding_no != '')
                            <b>C/O:</b> {{ $employees->en_pre_holding_no }},
                            @endif
                            @if ($employees->en_pre_village_name != '')
                            <b>Vill:</b> {{ $employees->en_pre_village_name }},
                            @endif
                            @if ($employees->bn_pre_ward?->name != '')
                            <b>Ward:</b> {{ $employees->bn_pre_ward?->name }},
                            @endif
                            @if ($employees->en_pre_post_ofc != '')
                            <b>Post:</b> {{ $employees->en_pre_post_ofc }},
                            @endif
                            @if ($employees->bn_union?->name != '')
                            <b>P.S:</b> {{ $employees->bn_union?->name }},
                            @endif
                            @if ($employees->bn_upazilla?->name != '')
                            <b>UP:</b> {{ $employees->bn_upazilla?->name }},
                            @endif
                            @if ($employees->bn_district?->name != '')
                            <b>Dist:</b> {{ $employees->bn_district?->name }}
                            @endif
                        </th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">11</th>
                        <th class="tbl_border" style="padding: 6px;">Permanent Address</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">
                            @if ($employees->en_parm_holding_name != '')
                            <b>C/O:</b> {{ $employees->en_parm_holding_name }},
                            @endif
                            @if ($employees->en_parm_village_name != '')
                            <b>Vill:</b> {{ $employees->en_parm_village_name }},
                            @endif
                            @if ($employees->bn_parm_ward?->name != '')
                            <b>Ward:</b> {{ $employees->bn_parm_ward?->name }},
                            @endif
                            @if ($employees->en_parm_post_ofc != '')
                            <b>Post:</b> {{ $employees->en_parm_post_ofc }},
                            @endif
                            @if ($employees->bn_parm_union?->name != '')
                            <b>P.S:</b> {{ $employees->bn_parm_union?->name }},
                            @endif
                            @if ($employees->bn_parm_upazilla?->name != '')
                            <b>UP:</b> {{ $employees->bn_parm_upazilla?->name }},
                            @endif
                            @if ($employees->bn_parm_district?->name != '')
                            <b>Dist:</b> {{ $employees->bn_parm_district?->name }}
                            @endif
                        </th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">12</th>
                        <th class="tbl_border" style="padding: 6px;">NID/Birth Certificate No</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">@if($employees->en_nid_no) {{ 'NID  :'.$employees->en_nid_no }} @else {{ 'B.C.  :'.$employees->en_birth_certificate }} @endif</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">13</th>
                        <th class="tbl_border" style="padding: 6px;">Date of Birth</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ date('d-M-Y', strtotime($employees->bn_dob)) }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">14</th>
                        <th class="tbl_border" style="padding: 6px;">Personal & Alt. Phone No</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_parm_phone_my }} , {{ $employees->en_parm_phone_alt }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">15</th>
                        <th class="tbl_border" style="padding: 6px;">Educational Qualification</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_edu_qualification }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">16</th>
                        <th class="tbl_border" style="padding: 6px;">Experience</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_experience }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">17</th>
                        <th class="tbl_border" style="padding: 6px;">Religion</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->religion?->name }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">18</th>
                        <th class="tbl_border" style="padding: 6px;">Marital Status</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;"> @if($employees->bn_marital_status=='1') {{ 'Unmarried' }} @else {{ 'Married' }} @endif</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">19</th>
                        <th class="tbl_border" style="padding: 6px;">Character Certificate <br> (By Chairman)</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">(Certificate attached)</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">20</th>
                        <th class="tbl_border" style="padding: 6px;">Nationality</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_nationality }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">21</th>
                        <th class="tbl_border" style="padding: 6px;">Identification Mark(if any)</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">{{ $employees->en_identification_mark }}</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">22</th>
                        <th class="tbl_border" style="padding: 6px;">Is any case filed against him <br> in any court of Justice</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">@if($employees->en_is_any_case=='1') {{ 'Yes' }} @elseif($employees->en_is_any_case=='2') {{ 'No' }}@else @endif</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">23</th>
                        <th class="tbl_border" style="padding: 6px;">Had he ever been convicted <br> by the criminal Court</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">@if($employees->en_is_criminal_court=='1') {{ 'Yes' }} @elseif($employees->en_is_criminal_court=='2') {{ 'No' }}@else @endif</th>
                    </tr>
                    <tr class="tbl_border">
                        <th class="tbl_border" style="text-align: center; padding: 6px;">24</th>
                        <th class="tbl_border" style="padding: 6px;">Any Other Information</th>
                        <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                        <th class="tbl_border" style="padding: 6px;">@if($employees->en_any_other_info=='1') {{ 'Yes' }} @elseif($employees->en_any_other_info=='2') {{ 'No' }}@else @endif</th>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-12 text-end mt-5" style="margin-top: 50px !important;">
                    @if($employees->signature_img !='')
                    <img height="50px" width="150px" class="me-3" src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt="">
                    @endif
                    <p style="margin: 1px;"><b style="border-top: solid 2px;">Signature of the {{ $employees->position?->name }}</b></p>
                </div>
            </div>
            <p class="mb-0 pb-0">I have checked and verified the above mentioned information and found all correct.</p>
            <p class="mt-0 pt-0"><span style="border-bottom: solid 1px;">Certified by</span> </p>
        </div>
        </section>
    </div>
</div>
<div class="tab-pane fade" id="step-7" role="tabpanel" aria-labelledby="step-7-tab">
    <div class="text-center m-2">
        <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_seven')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                <g fill="currentColor">
                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                    <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                </g>
            </svg></a>
    </div>
    <div id="result_show_seven">
        <section style="margin-bottom: 2rem;">
            <div style="page-break-inside: avoid;">
                <div class="row" style="margin-top: 2rem;">
                    <div class="col-12 text-center mb-5" style="margin-bottom: 50px !important;">
                        <h5 style="padding-top: 3rem;"> <span style="border-bottom: solid 1px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড এ প্রশিক্ষণ ফি সংক্রান্ত</span></h5>
                        <p style="margin: 1px;"><b style="border-bottom: solid 1px;">হলফনামা</b></p>
                    </div>
                </div>
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td colspan="8">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 10% !important;">আমি</td>
                                        <td colspan="2" style="width: 25% !important;"><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                                        <td style="text-align: center; width: 15% !important;">বয়স</td>
                                        <td style="text-align: center; width: 15% !important;"><input readonly type="text" class="tinput" value="{{ convertToBanglaNumber($age) }}"></td>
                                        <td style="width: 10% !important;">পিতা</td>
                                        <td colspan="2" style="text-align: center; width: 25% !important;"><input readonly type="text" class="tinput" value="{{ $employees->bn_fathers_name }}"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 10% !important;">মাতা</td>
                                        <td colspan="2" style="width: 24% !important;"><input readonly type="text" class="tinput" value="{{ $employees->bn_mothers_name }}"></td>
                                        <td style="text-align: center; width: 10% !important;">গ্রাম</td>
                                        <td style="text-align: center; width: 20% !important;"><input type="text" class="tinput" value="{{ $employees->bn_parm_village_name }}"></td>
                                        <td style="width: 14% !important;">ডাকঘর</td>
                                        <td colspan="2" style="text-align: center; width: 23% !important;"><input type="text" class="tinput" value="{{ $employees->bn_parm_post_ofc }}"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>উপজেলা</td>
                            <td><input readonly type="text" class="tinput" value="{{ $employees->bn_parm_upazilla?->name_bn }}"></td>
                            <td>জেলা</td>
                            <td><input type="text" class="tinput" value="{{ $employees->bn_parm_district?->name_bn }}"></td>
                            <td>ধর্ম</td>
                            <td><input type="text" class="tinput" value="{{ $employees->religion?->name_bn }}"></td>
                            <td>জাতীয়তা</td>
                            <td><input type="text" class="tinput" value="{{ $employees->bn_nationality }}"></td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 15% !important;">নং</td>
                                        <td style="width: 15% !important;"><input readonly type="text" class="tinput" value=""></td>
                                        <td style="text-align: center; width: 10% !important;">গত</td>
                                        <td colspan="2" style="text-align: center; width: 30% !important;"><input type="text" class="tinput" value=""></td>
                                        <td style="width: 10% !important;">ইং তারিখে</td>
                                        <td colspan="2" style="width: 20% !important;">{{ $employees->position?->name_bn }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                হিসেবে এলিট সিকিউরিটি সার্ভিসেস লিঃ এ ভর্তি হয়েছি।
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                আমি স্বজ্ঞানে, সু্স্থ্য মস্তিষ্কে, অন্যের বিনা প্ররোচনায় হলফ পূর্বক ঘোষণা করছি যে, ভর্তি
                                হওয়ার সময় আমি প্রশিক্ষণ ফি বাবদ {{ $employees->bn_traning_cost }} টাকা মাত্র প্রদান করেছি। আমি আরো ঘোষণা
                                করছি যে, উল্লেখিত প্রশিক্ষণ ফি ছাড়া অতিরিক্ত কোন অর্থ প্রদান করি নাই এবং তৃতীয় কোন
                                পক্ষের সাথে প্রশিক্ষণ ফি সংক্রান্ত কোন লেনদেন করি নাই। প্রশিক্ষণ ফি প্রদানের ব্যাপারে আমার
                                কোন অভিযোগ উত্থাপন করব না, করলে তাহা সকল
                                ক্ষেত্রে অগ্রাহ্য হবে ।
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start" colspan="8">
                                <p style="margin: 1px; margin-top: 50px !important;"><b style="border-top: solid 2px;">জেনারেল কর্মকর্তার স্বাক্ষর</b></p>
                                <p style="margin: 1px;"><b>(সীলসহ এবং ঠিকানা সহকারে)</b></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row" style="margin-top: 50px !important;">
                    <div class="col-6">
                        <p style="margin: 1px; margin-top: 50px !important;"><b style="border-bottom: solid 2px;">স্বাক্ষীঃ (ঠিকানা সহকারে নিকট আত্বীয়স্বজন)</b></p>
                        <p style="padding: 2px;"><b>১।</b></p>
                        <p style="padding: 2px;"><b>২।</b></p>
                        <p style="padding: 2px;"><b>৩।</b></p>
                    </div>
                    <div class="col-6">
                        <p style="margin: 1px; margin-top: 50px !important;"><b style="border-bottom: solid 2px;"> ঘোষণাকারীর স্বাক্ষর</b></p>
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>ভর্তি আইডি নং</td>
                                    <td><input readonly type="text" class="tinput" value="{{ $employees->admission_id_no }}"></td>
                                </tr>
                                <tr>
                                    <td>নামঃ</td>
                                    <td><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                                </tr>
                                <tr>
                                    <td>পদবীঃ</td>
                                    <td><input readonly type="text" class="tinput" value="{{ $employees->position?->name_bn }}"></td>
                                </tr>
                                <tr>
                                    <td>ন্যাশনাল আইডি নংঃ</td>
                                    <td><input readonly type="text" class="tinput" value="{{ $employees->bn_nid_no }}"></td>
                                </tr>
                                <tr>
                                    <td>মোবাইল নংঃ</td>
                                    <td><input readonly type="text" class="tinput" value="{{ $employees->bn_parm_phone_my }}"></td>
                                </tr>
                                <tr>
                                    <td>তারিখঃ</td>
                                    <td><input readonly type="text" class="tinput" value="{{ date('d-m-Y', strtotime($employees->created_at)) }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<div class="tab-pane fade" id="step-8" role="tabpanel" aria-labelledby="step-8-tab">
    <div class="text-center m-2">
        <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_eight')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                <g fill="currentColor">
                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                    <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                </g>
            </svg></a>
    </div>
    <div id="result_show_eight">
        <section>
            <div style="page-break-inside: avoid;">
                <div class="row" style="">
                    <div class="col-12 text-center" style="margin-bottom: 5px !important;">
                        <h5 style="padding-top:5px !important;">জনবল ভর্তির প্রাথমিক কার্যক্রম</h5>
                        {{-- <span class="text-end" style="padding-left: 50px !important;">তারিখ:{{ date('d-m-Y', strtotime($employees->created_at)) }}</span> --}}
                        <p style="margin: 1px;"><b>এলিট সিকিউরিটি সার্ভিসেস লিমিটেড,চট্টগ্রাম ।</b></p>
                    </div>
                </div>
                <table style="width: 100%;">
                    <tbody style="font-size: 14px !important;">
                        <tr>
                            <td>০১।</td>
                            <td>নির্বাচিত প্রার্থীর নামঃ</td>
                            <td><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                            <td>উচ্চতাঃ</td>
                            <td><input readonly type="text" class="tinput" value="{{ $employees->bn_height_foot }} ফুট {{ $employees->bn_height_inc }} ইঞ্চি"></td>
                        </tr>
                        <tr>
                            <td>০২।</td>
                            <td>পিতার নামঃ</td>
                            <td><input type="text" class="tinput" value="{{ $employees->bn_fathers_name }}"></td>
                            <td>বয়স</td>
                            <td><input type="text" class="tinput" value="{{ convertToBanglaNumber($age) }}"></td>
                        </tr>
                        <tr>
                            <td>০৩।</td>
                            <td>উপজেলা</td>
                            <td><input readonly type="text" class="tinput" value="{{ $employees->bn_parm_upazilla?->name_bn }}"></td>
                            <td>জেলা</td>
                            <td><input readonly type="text" class="tinput" value="{{ $employees->bn_parm_district?->name_bn }}"></td>
                        </tr>
                        <tr>
                            <td>০৪।</td>
                            <td colspan="2">জাতীয় পরিচয়পত্র সংযুক্ত (মূলকপি/ফটোকপি)</td>
                            <td colspan="2"> : আছে / নাই</td>
                        </tr>
                        <tr>
                            <td>০৫।</td>
                            <td colspan="2">জাতীয়তা সনদ সংযুক্ত (মূলকপি/ফটোকপি)</td>
                            <td colspan="2"> : আছে / নাই</td>
                        </tr>
                        <tr>
                            <td>০৬।</td>
                            <td colspan="2">শিক্ষাগত যোগ্যতা সনদ সংযুক্ত (মূলকপি/ফটোকপি)</td>
                            <td colspan="2"> : আছে / নাই</td>
                        </tr>
                        <tr>
                            <td>০৭।</td>
                            <td colspan="2">জন্ম নিবন্ধন সনদ সংযুক্ত (মূলকপি/ফটোকপি)</td>
                            <td colspan="2"> : আছে / নাই</td>
                        </tr>
                        <tr>
                            <td>০৮।</td>
                            <td colspan="2">অভিজ্ঞতা সনদ সংযুক্ত</td>
                            <td colspan="2"> : আছে / নাই</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 6% !important;">০৯।</td>
                                        <td style="width: 35% !important;">প্রশিক্ষণ ফি বাবদ (অফেরতযোগ্য)নগদঃ </td>
                                        <td style="width: 11% !important;">{{ $employees->bn_traning_cost }}</td>
                                        <td style="width: 15% !important;">টাকা দিয়ে বাকি</td>
                                        <td style="width: 8% !important;"><input readonly type="text" class="tinput" value=""></td>
                                        <td style="width: 25% !important;">টাকা রেখে স্বাক্ষর করলাম ।</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>১০।</td>
                            <td>প্রার্থীর স্বাক্ষরঃ</td>
                            <td colspan="3"><input readonly type="text" class="tinput" value=""></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 7% !important;">১১।</td>
                                        <td style="width: 60% !important;">সনাক্তকারী/কাগজপত্র গ্রহনকারী/টাকা গ্রহনকারী/নাম ও স্বাক্ষরঃ </td>
                                        <td style="width: 33% !important;"><input readonly type="text" class="tinput" value=""></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table style="margin-top:1rem; width: 100%;">
                                    <tr>
                                        <td style="text-align: left; width: 7% !important;">১২।</td>
                                        <td style="width: 20% !important;">স্বাক্ষরঃ-</td>
                                        <td style="width: 30% !important;">ভর্তিকারী/জোন কমান্ডার</td>
                                        <td style="width: 18% !important;"></td>
                                        <td style="width: 25% !important; text-align: end !important;">ডিজিএম/জিএম</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="text-align: left; width: 6% !important;">১৩।</td>
                                        <td style="width: 25% !important;">
                                            <h5 class="mb-0">‍শপথ বাক্য পাঠঃ-</h5>
                                        </td>
                                        <td style="width: 10% !important;">আমি(নাম)</td>
                                        <td style="width: 23% !important;"><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                                        <td style="width: 13% !important;">{{ $employees->position?->name_bn }}</td>
                                        <td style="width: 23% !important;">হিসেবে মহান সৃষ্টিকর্তার</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4">
                                শপথ কবে এবং স্বাক্ষী রেখে অঙ্গীকার করিতেছি যে, আজ থেকে আমার উপর অত্র কোম্পানীর অর্পিত নিরাপত্তার
                                সকল দায়-দায়িত্ব সঠিকভাবে পালন করিব। যে কোন সময় মানুষের জান ও মালের নিরাপত্তা প্রদানের দায়িত্ব আমাকে
                                দেওয়া হইলে তা পালন করিতে কোন রকম অবহেলা ও গাফিলতি করিব না। অত্র কোম্পানির সকল নিয়ম-কানুন এবং
                                উর্ধ্বতন কর্মকর্তার সকল আইনগত আদেশ/উপদেশ মেনে নিয়ে দায়িত্ব পালন করিতে আমি বাধ্য থাকিব । হে মহান
                                সৃষ্টিকর্তা আমার উপর অর্পিত সকল দায় দায়িত্ব পালন করার শক্তি ও সামর্থ দিন, আমিন ।
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 7% !important;">১৪।</td>
                                        <td style="width: 60% !important;">মান যাচাইকারী এবং শপথ পরিচালনাকারীর নাম ও স্বাক্ষর </td>
                                        <td style="width: 33% !important;"><input readonly type="text" class="tinput" value=""></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>১৫।</td>
                            <td colspan="4">প্রশিক্ষনের কালঃ ------------ হইতে ------------------ মোট = ------- দিন</td>
                        </tr>
                        <tr>
                            <td class="text-start" colspan="5">
                                <p style="margin: 1px; margin-top: 10px !important;">
                                <h5 class="text-center"><span style="border-bottom: solid 2px;">জোন কমান্ডারের মন্তব্যঃ</span></h5>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td style="text-align: left; width: 7% !important;">১৬।</td>
                                        <td style="width: 60% !important;">উক্ত গার্ডটি নতুন পোষ্টের জন্য ভর্তি করা হলে পোষ্টের নাম লিখুনঃ</td>
                                        <td style="width: 33% !important;"><input readonly type="text" class="tinput" value=""></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>১৭।</td>
                            <td colspan="2">যদি পুরাতন পোষ্ট হয়,তাহলে পোষ্টের নামঃ</td>
                            <td colspan="2"><input readonly type="text" class="tinput" value=""></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">কাহার পরিবর্তেও ভর্তির কারণঃ</td>
                            <td colspan="2"><input readonly type="text" class="tinput" value=""></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="5">
                                <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                <p style="margin: 1px;"><b style="border-top: solid 2px;">জেনারেল কমান্ডারের স্বাক্ষর</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start" colspan="5">
                                <h5 class="text-center" style="margin-top:3px !important;"><span style="border-bottom: solid 2px;">ষ্টোরম্যান/অফিস এক্সিকিউটিভ এর করণীয় ।</span></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>১৮।</td>
                            <td>বরাদ্ধকৃত আইডি নং </td>
                            <td><input readonly type="text" class="tinput" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>১৯।</td>
                            <td colspan="4">উল্লেখিত সনদপত্রগুলো গ্রহন করে পোশাক ইস্যু করলাম।</td>
                        </tr>
                        <tr>
                            <td>তারিখঃ</td>
                            <td><input readonly type="text" class="tinput" value=""></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                <p style="margin: 1px;"><b style="border-top: solid 2px;">স্টোরম্যানের সীল/স্বাক্ষর</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>২০।</td>
                            <td>প্রশিক্ষণ ফি বাবদ নগদ </td>
                            <td><input readonly type="text" class="tinput" value=""></td>
                            <td colspan="2">টাকা সদস্য সচিব থেকে বুঝে গ্রহন করলাম ।</td>
                        </tr>
                        <tr>
                            <td>তারিখঃ</td>
                            <td><input readonly type="text" class="tinput" value=""></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                <p style="margin-top: 1rem;"><b style="border-top: solid 2px;">হিসাব শাখার প্রধান</b></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</div>
<div class="tab-pane fade" id="step-9" role="tabpanel" aria-labelledby="step-9-tab">
    <div class="text-center m-2">
        <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_nine')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                <g fill="currentColor">
                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                    <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                </g>
            </svg></a>
    </div>
    <div id="result_show_nine">
        <div class="row p-3">
            <div class="text-center mt-5">
                <h5 style="padding-top: 3rem;">ফরম নং-১৫ </h5>
                <p style="margin: 2px;">ধারা ৩৪, ৩৬, ৩৭ ও ২৭৭ এবং বিধি ৩৪ (১) ও ৩৩৬ (৪)</p>
                <p style="margin: 2px;"><b>বয়স ও সক্ষমতার প্রত্যয়নপত্র</b></p>
            </div>
            <table class="tbl_border" style="width: 100%;">
                <tbody>
                    <tr class="tbl_border" style="text-align: center;">
                        <th class="tbl_border">বয়স ও সক্ষমতার প্রত্যয়নপত্র</th>
                        <th class="tbl_border">বয়স ও সক্ষমতার প্রত্যয়নপত্র</th>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">১ । ক্রমিক নং {{ $employees->id }}</td>
                        <td class="tbl_border">১ । ক্রমিক নং {{ $employees->id }}</td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">তারিখ {{ date('d/m/Y', strtotime($employees->created_at)) }}</td>
                        <td class="tbl_border">তারিখ {{ date('d/m/Y', strtotime($employees->created_at)) }}</td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">২ । নাম :{{ $employees->bn_applicants_name }}</td>
                        <td class="tbl_border"></td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">২ । পিতার নাম: {{ $employees->bn_fathers_name }}</td>
                        <td class="tbl_border" rowspan="2">
                            আমি এই মর্মে প্রত্যয়ন করিতেছি যে (নাম )<span style="border-bottom: 1px dashed;">{{ $employees->bn_applicants_name }}</span> পিতা: <span style="border-bottom: 1px dashed;">{{ $employees->bn_fathers_name }}</span>
                            মাতা: <span style="border-bottom: 1px dashed;">{{ $employees->bn_mothers_name }}</span>
                            ঠিকানা : <span style="border-bottom: 1px dashed;">{{ $employees->bn_parm_village_name}}, {{ $employees->bn_parm_upazilla?->name_bn}}, {{ $employees->bn_parm_district?->name_bn }}</span> কে আমি পরীক্ষা করিয়াছি।
                        </td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">৩ । মাতার নাম: {{ $employees->bn_mothers_name }}</td>
                        {{-- <td  class="tbl_border">
                                    আমি এই মর্মে প্রত্যয়ন করিতেছি যে (নাম )<input type="text" class="sminput"  value="{{ $employees->bn_applicants_name }}">পিতা:<input type="text" class="sminput" value="{{ $employees->bn_fathers_name }}">
                        মাতা:<input type="text" class="sminput" value="{{ $employees->bn_mothers_name }}">
                        ঠিকানা :<input type="text" class="semiTinput" value="{{ $employees->bn_parm_village_name}}, {{ $employees->bn_parm_upazilla?->name_bn}}, {{ $employees->bn_parm_district?->name_bn }}">কে আমি পরীক্ষা করিয়াছি।
                        </td> --}}
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">৪ । লিঙ্গ: পুরুষ/মহিলা
                        </td>
                        <td class="tbl_border">
                            তিনি প্রতিষ্টানে নিযুক্ত হইতে ইচ্ছুক এবং আমার পরীক্ষা হইতে এইরূপ পাওয়া গিয়াছে যে তাহার বয়স <input type="text" class="verySmall text-center" value="{{ $age }}">বছর এবং তিনি প্রতিষ্টানে প্রাপ্ত বয়স্ক/কিশোর হিসাবে নিযুক্ত হইবার যোগ্য।
                        </td>
                    </tr>
                    <tr class="tbl_border">
                        <td style="width: 40%;" class="tbl_border">৫ । স্থায়ী ঠিকানা <br>

                            <label for="">গ্রাম:</label>{{ $employees->bn_parm_village_name }}&nbsp;&nbsp;
                            <label for="">পোঃ:</label>{{ $employees->bn_parm_post_ofc }}&nbsp;&nbsp;<br>
                            <label for="">উপজেলা:</label>{{ $employees->bn_parm_upazilla?->name_bn }} &nbsp;&nbsp;<br>
                            <label for="">জেলা:</label>{{ $employees->bn_parm_district?->name_bn }}
                        </td>
                        <td class="tbl_border">
                            তাহার সনাক্তকরণের চিহ্ন : <span style="border-bottom: 1px dashed;">{{ $employees->bn_identification_mark }}</span>
                        </td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">৬ । অস্থায়ী/যোগাযোগের ঠিকানা - হোল্ডিং নং - {{ $employees->bn_pre_holding_no }}<br>
                            <label for="">গ্রাম/সড়ক:</label>{{ $employees->bn_pre_village_name }}&nbsp;&nbsp;
                            <label for="">পোঃ:</label>{{ $employees->bn_pre_post_ofc }}&nbsp;&nbsp;<br>
                            <label for="">উপজেলা:</label>{{ $employees->bn_upazilla?->name_bn }} &nbsp;&nbsp;<br>
                            <label for="">জেলা:</label>{{ $employees->bn_district?->name_bn }}
                        </td>
                        <td class="tbl_border"></td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">৮। জন্ম সনদ/শিক্ষা সনদ অনুসারে বয়স/জন্ম তারিখ :</td>
                        <td class="tbl_border">{{ date('d-M-Y', strtotime($employees->bn_dob)) }}</td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">৯। দৈহিক সক্ষমতা :</td>
                        <td class="tbl_border">{{ $employees->bn_cer_physical_ability }}</td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">১০। সনাক্তকরণ চিহ্ন :</td>
                        <td class="tbl_border">{{ $employees->bn_identification_mark }}</td>
                    </tr>
                    <tr class="tbl_border">
                        <td class="tbl_border">
                            <div class="d-flex justify-content-between p-2">
                                <div>
                                    @if($employees->concerned_person_sign !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/concerned_person_sign/'.$employees->concerned_person_sign)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <p>সংশ্লিষ্ট ব্যক্তির<br />স্বাক্ষর/টিপসহি </p>
                                </div>
                                <div>
                                    @if($employees->bn_doctor_sign !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/bn_doctor_sign/'.$employees->bn_doctor_sign)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</p>
                                </div>
                            </div>
                        </td>
                        <td class="tbl_border">
                            <div class="d-flex justify-content-between p-2">
                                <div>
                                    @if($employees->concerned_person_sign !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/concerned_person_sign/'.$employees->concerned_person_sign)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <p>সংশ্লিষ্ট ব্যক্তির<br />স্বাক্ষর/টিপসহি </p>
                                </div>
                                <div>
                                    @if($employees->bn_doctor_sign !='')
                                    <img height="50px" width="150px" src="{{asset('uploads/bn_doctor_sign/'.$employees->bn_doctor_sign)}}" alt=""><br />
                                    @else
                                    <img height="50px" width="150px" src="{{ asset('assets/images/defaultsing.png')}}" alt=""><br />
                                    @endif
                                    <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="step-10" role="tabpanel" aria-labelledby="step-10-tab">
    <div class="text-center m-2">
        <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_ten')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                <g fill="currentColor">
                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                    <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z" />
                </g>
            </svg></a>
    </div>
    <div id="result_show_ten">
        <div class="row">
            <div class="row" style="">
                <div class="col-5">
                    <img class="" height="80px" width="auto" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                </div>
                <div class="col-7 text-end mb-3" style="">
                    <div style="display: inline-block; text-align: left;">
                        <span style="margin: 0; font-size: 13px; font-weight:bold;">House #2, Lane #2, Road #2, Block-K,</span><br>
                        <span style="margin: 0; font-size: 13px; font-weight:bold;">Halishahar Housing Estate, Chattogram-4224</span><br>
                        <span style="margin: 0; font-size: 13px; font-weight:bold;">Tel: 02333323387, Mobile: 01841117770, 01844-040715</span><br>
                        <span style="margin: 0; font-size: 13px; font-weight:bold;">Email: ctg@elitebd.com</span>
                    </div>
                </div>
            </div>
            <div class="red-line" style="height: 2px; background-color: red; margin-bottom: 0.5rem;">&nbsp;&nbsp;</div>
            <table class="mx-2" width="100%">
                <tr>
                    <td width="40%" style="text-align: left;"> <b>File No ESSL/CTG/ID:&nbsp;<span style="border-bottom: 1px dashed;">{{ $employees->admission_id_no }}</span></b></td>
                    <td width="30%"></td>
                    <td width="30%" style="text-align: right;"> <b>Date :<input type="text" value="" style="border: none; border-bottom: 1px dashed; background-color:transparent;"></b></td>
                </tr>
            </table>
            <div class="col-12 mt-2">
                <div class="row">
                    <div class="col-8">
                        <span class="police-vf-font"><b>প্রতি,</b></span><br>
                        <span class="police-vf-font"><b>অতিরিক্ত আইজিপি</b></span><br>
                        <span class="police-vf-font"><b>স্পেশাল ব্রাঞ্চ (ভিআর)</b></span><br>
                        <span class="police-vf-font"><b>বাংলাদেশ পুলিশ, মালিবাগ, ঢাকা- ১২১৭।</b></span><br><br>
                        <span class="police-vf-font"><b>বিষয় : পুলিশ ভেরিফিকেশন প্রসঙ্গে।</b></span><br><br>
                        <span class="police-vf-font"><b>বরাত: বে-সরকারি নিরাপত্তা সেবা বিধিমালা ২০০৭ এর বিধি ৮ এর ৩ উপবিধি।</b></span><br><br>
                        <span class="police-vf-font"><b>মহাত্মন,</b></span><br>
                    </div>
                    <div class="col-4 text-end">
                        <img class="tbl_border" height="160px" width="auto" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2 mb-3">
                <span class="police-vf-font"><b>১। ইহা একটি বেসরকারি নিরাপত্তা সেবা প্রদানকারী প্রতিষ্ঠান। আপনার থানার আওতাধীন নিন্মোক্ত ব্যক্তি এলিট সিকিউরিটি সার্ভিসেস লিঃ (এলিট ফোর্স ) এর অধীনে {{ $employees->position?->name_bn }} পদে নিয়োগের জন্য প্রাথমিকভাবে নির্বাচিত হয়েছেন:</b></span><br>
                <table style="width: 100%; margin-top: 1rem;">
                    <tr class="police-vf-font">
                        <th width="25%">নাম:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_applicants_name }}</th>
                        <th>বয়স:</th>
                        <th style="border-bottom: 1px dashed;">{{convertToBanglaNumber($age)}}</th>
                    </tr>
                    <tr class="police-vf-font">
                        <th>পিতা:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_fathers_name }}</th>
                        <th>মাতা:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_mothers_name }}</th>
                    </tr>
                    <tr class="police-vf-font">
                        <th>গ্রাম:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_village_name }}</th>
                        <th>ওয়ার্ড নং:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_ward?->name_bn }}</th>
                    </tr>
                    <tr class="police-vf-font">
                        <th>ইউনিয়ন:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_union?->name_bn }}</th>
                        <th>ডাকঘর:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_post_ofc }}</th>
                    </tr>
                    <tr class="police-vf-font">
                        <th>থানা/উপজেলা:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_upazilla?->name_bn }}</th>
                        <th>জেলা:</th>
                        <th style="border-bottom: 1px dashed;">{{ $employees->bn_parm_district?->name_bn }}</th>
                    </tr>
                    <tr class="police-vf-font">
                        <th>এনআইডি/জন্ম নিবন্ধন নং:</th>
                        <th style="border-bottom: 1px dashed;">
                            @if ($employees->bn_nid_no != '')
                            {{convertToBanglaNumber($employees->bn_nid_no)}}
                            @else
                            {{ convertToBanglaNumber($employees->bn_birth_certificate) }}
                            @endif
                        </th>
                        <th>মোবাইল নং:</th>
                        <th style="border-bottom: 1px dashed;">{{ convertToBanglaNumber($employees->bn_parm_phone_my) }}</th>
                    </tr>
                </table>
            </div>
            <div class="col-12 mt-2">
                <span class="police-vf-font">নিরাপত্তার মতো একটি স্পর্শকাতর পেশায় নিয়োজিত ব্যক্তিবর্গের প্রাক-পরিচয় যাচাই করা খুবই জরুরী। উল্লেখিত ব্যক্তির প্রাক-পরিচিতি (Antecedence) যাচাই এর জন্য বাংলাদেশ পুলিশ অধিদপ্তর খাত (কোড নং:<input type="text" value="১- ৭৩০১-০০০১-২৬৮১" style="border: none; border-bottom: 1px dashed; background-color:transparent;">) এর অনুকূলে ১০০-/ টাকা জমা ট্রেজারী চালান নম্বর <input type="text" value="" style="border: none; border-bottom: 1px dashed; background-color:transparent;"> তাং <input type="text" value="" style="border: none; border-bottom: 1px dashed; background-color:transparent; width: 90px;"> (মূল কপি) আপনার সমীপে প্রেরণ করলাম।</span><br><br>
                <span class="police-vf-font">২। প্রহরীটি গরিব পরিবারের সদস্য। তাকে এই চাকুরীতে রাখার স্বার্থে আপনার মূল্যবান মতামত অতীব জরুরী বিধায় যত দ্রুত সম্ভব আপনার মতামতটি অত্র প্রতিষ্ঠানে প্রেরণের জন্য বিশেষভাবে অনুরোধ করছি। </span><br><br>
                <span class="police-vf-font">ধন্যবাদান্তে</span><br>
                <span class="police-vf-font">আপনার বিশ্বস্ত</span><br>
                <img src="" id="photo_p" height="40px" width="100px"><br><br>
                <span class="police-vf-font"><b>মেজর (অবঃ) মোহাম্মদ মোস্তফা</b></span><br>
                <span class="police-vf-font"><b>এক্সেকিউটিভ ডাইরেক্টর, চট্টগ্রাম</b></span><br>
                <span class="police-vf-font"><b>মোবা: ০১৮১৯-৮১৪৯৯৯</b></span>
            </div>
            <div class="col-12 mt-2 mb-1">
                <br><span class="police-vf-font">সংযুক্ত:</span><br>
                <span class="police-vf-font"><b>১) ব্যাংকে টাকা জমা সংক্রান্ত চালানের কপি</b></span><br>
                <span class="police-vf-font"><b>২) এনআইডি/ জন্মনিবন্ধন কপি</b></span><br>
                <span class="police-vf-font"><b>৩) জাতীয়তা সনদপত্র</b></span>
            </div>
            <div class="black-line" style="height: 1px; background-color: #000; margin-bottom: 0.2rem; margin-top: 0.3rem;">&nbsp;&nbsp;</div>
            <div>
                <span class="police-vf-foot-font"><b>Dhaka Head Office:</b> Elite Tower, House #3, Road #6/A, Block-J, Baridara, Dhaka-1212, E-mail: wecare@elitebd.com, wwwe.elitebd.com, Tel: 02-8821289, 9885141</span><br>
                <span class="police-vf-foot-font"><b>Sylhet Office:</b> 58, Kismat Complex, Block-A, Main Road, Sahjalal Upashahar, Sylhet-3100. Tel: 0821-760807</span><br>
                <span class="police-vf-foot-font"><b>Khulna Office:</b> 31-A, K.D.A Avenue, Khulna-9100, Tel: 041-714722, 720051, Fax: 041-729305</span>
            </div>
        </div>
    </div>
    <div>
        <label for=""><b>Signature Upload here</b></label><br>
        <input type="file" class="no-print" id="photo" name="image" class="form-control" onchange="pview(this)"><br>
    </div>
</div>

</div>
</div>

<section class="mt-5">
    <div class="row imggl">
        <p>সকল ডকুমেন্ট</p>
        @forelse($employeeDocuments as $ed)
        <div class="col-5 col-sm-3 mb-3 text-center del{{$ed->id}}">
            <input readonly class="form-control mb-1" value="{{$ed->document_caption}}" type="text" name="document_caption[]" placeholder="Document Caption" />
            <a target="_blank" href="{{asset('uploads/document_img/'.$ed->document_img)}}"><i class="bi bi-eye"></i></a>
        </div>
        @empty
        @endforelse
    </div>
</section>

<script>
    function pview(e) {
        document.getElementById('photo_p').src = window.URL.createObjectURL(e.files[0]);
    }
    $('.nav-item a').click(function(e) {
        var currentTab = $(this).attr('href');
        var prevTab = $('.tab-content .tab-pane.show').attr('id');

        $('#' + prevTab).removeClass('show active');
        $('#' + prevTab + '-tab').removeClass('active');
        $(currentTab).addClass('show active');
        $(currentTab + '-tab').addClass('active');
        e.preventDefault();
    });

    // function printDivemp(divName) {
    //     var prtContent = document.getElementById(divName);
    //     var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    //     WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
    //     WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}" type="text/css"/>');
    //     WinPrint.document.write('<style> table tr td,table tr th{font-size:13px !important;} </style>');
    //     WinPrint.document.write(prtContent.innerHTML);
    //     WinPrint.document.close();
    //     WinPrint.onload =function(){
    //         WinPrint.focus();
    //         WinPrint.print();
    //         WinPrint.close();
    //     }
    // }
    function printDivemp(divName) {
        // Clone the content of the div
        var prtContent = document.getElementById(divName).cloneNode(true);

        // Update input values in the cloned content
        var inputs = prtContent.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type === 'text' || inputs[i].type === 'date') {
                inputs[i].setAttribute('value', inputs[i].value);
            }
        }

        // Update textarea values in the cloned content
        var textareas = prtContent.getElementsByTagName('textarea');
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].innerHTML = textareas[i].value;
        }

        // Update select options in the cloned content
        var selects = prtContent.getElementsByTagName('select');
        for (var i = 0; i < selects.length; i++) {
            var selectedOption = selects[i].options[selects[i].selectedIndex];
            selectedOption.setAttribute('selected', 'selected');
        }

        // Open a new window for printing
        var WinPrint = window.open('', '_blank', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

        // Write the content into the print window
        WinPrint.document.open();
        WinPrint.document.write(`
        <html>
        <head>
            <title>Print</title>
            <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>
            <link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}" type="text/css"/>
            <style>
                table tr td, table tr th { font-size: 13px !important; }
                .police-vf-font { font-size: 13px; }
                .police-vf-foot-font { font-size: 9px; }
                .red-line { height: 2px !important; background-color: red !important; margin-bottom: 0.5rem; }
                .black-line { height: 1px !important; background-color: #000 !important; margin-bottom: 0.5rem; }
                body { background-color: #fff !important; }
                .no-print { display: none !important; }
            </style>
        </head>
        <body>
            ${prtContent.innerHTML}
        </body>
        </html>
    `);
        WinPrint.document.close();

        // Wait for the content to fully load before printing
        WinPrint.onload = function() {
            WinPrint.focus();
            WinPrint.print();

            // Delay closing the window to avoid blinking
            setTimeout(() => {
                WinPrint.close();
            }, 1000); // Keep the window open for 1 second
        };
    }

    function downloadDivAsWord(divName) {
        var content = document.getElementById(divName).cloneNode(true);

        // Get all inputs within the div and update their values in the cloned content
        var inputs = content.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type === 'text' || inputs[i].type === 'date') {
                inputs[i].setAttribute('value', inputs[i].value);
            }
        }

        // Get all textareas within the div and update their text in the cloned content
        var textareas = content.getElementsByTagName('textarea');
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].innerHTML = textareas[i].value;
        }

        // Get all selects within the div and update their selected options in the cloned content
        var selects = content.getElementsByTagName('select');
        for (var i = 0; i < selects.length; i++) {
            var selectedOption = selects[i].options[selects[i].selectedIndex];
            selectedOption.setAttribute('selected', 'selected');
        }

        // Create a blob object with the content formatted as HTML
        var htmlContent = `
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head><meta charset='utf-8'><title>Export as Word</title>
        <style>
            body {font-family: Arial, sans-serif; background-color: #fff;}
            table {border-collapse: collapse; width: 100%;}
            table, th, td {border: 1px solid black; padding: 5px;}
            .no-print { display: none; }
        </style>
        </head>
        <body>
            ${content.innerHTML}
        </body>
        </html>
    `;

        var blob = new Blob(['\ufeff', htmlContent], {
            type: 'application/msword'
        });

        // Create a download link and trigger the download
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'document.doc'; // The file name for the Word document
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    document.getElementById('downloadDoc').addEventListener('click', function() {
        var content = document.getElementById('result_show_six').innerHTML; // Get content from the element with id "myContent"
        var converted = htmlDocx.asBlob(content);
        var link = document.createElement('a');
        link.href = URL.createObjectURL(converted);
        link.download = 'employee_bio_data.docx';
        link.click();
    });
</script>
@endsection