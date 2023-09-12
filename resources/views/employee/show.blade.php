@extends('layout.app')
@section('content')
<div>
    <a href="#" class="btn btn-info no-print"> Go To Dashboard</a>
    <button type="button" class="btn btn-info no-print" onclick="printDiv('result_show')">Print</button>
</div>
<section id="result_show">
    <style>
        .tinput {
            width: 100%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .semiTinput {
            width: 44%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .semiSinput {
            width: 64%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .sbinput {
            width: 36%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .sinput {
            width: 30%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .sminput {
            width: 18%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .small {
            width: 25%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .verySmall {
            width: 10%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
            {{--  color: white;  --}}
        }
        .tbl_border{
            border: 1px solid;
            border-collapse: collapse;
        }
    </style>
    <section>
        <div class="container">
            <div class="row p-3">
                <div class="col-3">
                    <img  class="mt-5" height="80px" width="140px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                </div>
                <div class="col-6 col-sm-6" style="padding-left: 10px;">
                    <div style="text-align: center;">
                        <h5 style="padding-top: 5px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                        <p class="text-center m-0 p-0">ভর্তি ফরম:সকল অস্থায়ী পদের জন্য</p>
                        <p class="text-center m-0 p-0">বাড়ি নং-২,লেইন নং-২,রোড নং-২,ব্লক-''কে''</p>
                        <p class="text-center m-0 p-0">হালিশহর হাউজিং এষ্টেট,চট্টগ্রাম-৪২২৪</p>
                        <h6 class="text-center m-0 p-0"><u>জীবন বৃত্তান্ত/ব্যক্তিগত বিবরন/তথ্যাদি</u></h6>
                    </div>
                </div>
                <div class="col-3" style="padding-left: 10px;">
                    <img height="150px" width="150px"  src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">
                </div>
            </div>
            <div class="row p-3">
                <table style="width:100%">
                    <tbody >
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">১ । আবেদনকারীর নাম :</td>
                            <td class="py-1" colspan="5" style="width: 40%;"><input type="text" class="tinput"  value="{{ $employees->bn_applicants_name }}"></td>
                            <td class="py-1" style="text-align: center; width: 20%;">ভর্তির পর আইডি নং</td>
                            <td class="py-1" colspan="2" style="width: 15%;"><input type="text" class="tinput"  value="{{ $employees->admission_id_no }}"></td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">২ । পিতার নাম:</td>
                            <td class="py-1" colspan="4" ><input type="text" class="tinput"  value="{{ $employees->bn_fathers_name }}"></td>
                            <td class="py-1" style="text-align: center;">মাতার নাম:</td>
                            <td class="py-1" colspan="3" ><input type="text" class="tinput"  value="{{ $employees->bn_mothers_name }}"></td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৩ । স্থায়ী ঠিকানা :</td>
                            <td class="py-1" colspan="8">
                                <label for="">হোল্ডিং নং:</label>
                                <input type="text" class="sinput" value="{{ $employees->bn_parm_holding_name }}">
                                <label for="">ওয়ার্ড:</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_parm_ward?->name_bn }}">
                                <label for="">গ্রাম:</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_parm_village_name }}">
                                <label for="">ইউনিয়ন :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_parm_union?->name_bn }}">
                                <label for="">পোঃ :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_parm_post_ofc }}">
                                <label for="">উপজেলা :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_parm_upazilla?->name_bn }}">
                                <label for="">জেলা :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_parm_district?->name_bn }}">
                                <label for="">মোবাইল নং(নিজ) :</label>
                                <input type="text" class="sinput" value="{{ $employees->bn_parm_phone_my }}">
                                <label for="">বিকল্প :</label>
                                <input type="text" class="sinput" value="{{ $employees->bn_parm_phone_alt }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৪ । বর্তমান ঠিকানা :</td>
                            <td class="py-1" colspan="8">
                                <label for="">হোল্ডিং নং:</label>
                                <input type="text" class="sinput" value="{{ $employees->bn_pre_holding_no }}">
                                <label for="">ওয়ার্ড:</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_pre_ward?->name_bn }}">
                                <label for="">গ্রাম:</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_pre_village_name }}">
                                <label for="">ইউনিয়ন :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_union?->name_bn }}">
                                <label for="">পোঃ :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_pre_post_ofc }}">
                                <label for="">উপজেলা :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_upazilla?->name_bn }}">
                                <label for="">জেলা :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_district?->name_bn }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" colspan="9" style="text-align: center;"><b>(উল্লেখ্য, আমার বর্তমান ঠিকানা পরিবর্তন হলে আমি তাহা সাথে সাথে অফিস কে জানাবো)</b></td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৫ । সনাক্তহকরণ চিহ্ন :</td>
                            <td class="py-1" colspan="5" style="width: 35%;"><input type="text" class="tinput"  value="{{ $employees->bn_identification_mark }}"></td>
                            <td class="py-1" style="text-align: center; width: 10%;">রক্তের গ্রুপ</td>
                            <td class="py-1" colspan="2" style="width: 35%;"><input type="text" class="tinput"  value="{{ $employees->bloodgroup?->name_bn }}"></td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৬ । শিক্ষাগতা যোগ্যতা</td>
                            <td class="py-1" colspan="8">
                                <input type="text" class="sbinput" value="{{ $employees->bn_edu_qualification }}">
                                <label for="">জন্ম তারিখ</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_dob }}">
                                <label for="">বয়স</label>
                                @php
                                $birthDate = $employees->bn_dob;
                                $age = \Carbon\Carbon::parse($birthDate)->age;
                                @endphp
                                <input type="text" class="sminput" value="{{ $age }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; ">৭ । জন্ম নিবন্ধন নং :</td>
                            <td class="py-1" colspan="8">
                                <input type="text" class="sinput"  value="{{ $employees->bn_birth_certificate }}">
                                <label for="">জাতীয় পরিচয়পত্র নং</label>
                                <input type="text" class="sinput"  value="{{ $employees->bn_nid_no }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৮ । জাতীয়তা :</td>
                            <td class="py-1" colspan="8">
                                <input type="text" class="small"  value="{{ $employees->bn_nationality }}">
                                <label for="">ধর্ম</label>
                                <input type="text" class="small"  value="{{ $employees->religion?->name_bn }}">
                                <label for="">উচ্চতা</label>
                                <input type="text" class="verySmall"  value="{{ $employees->bn_height_foot }}">
                                <label for="">ফুট</label>
                                <input type="text" class="verySmall"  value="{{ $employees->bn_height_inc }}">
                                <label for="">ইঞ্চি</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">৯ । ওজন :</td>
                            <td class="py-1" colspan="8">
                                <input type="text" class="sminput"  value="{{ $employees->bn_weight_kg }}">
                                <label for="">কেজি</label>
                                <label for="">অভিজ্ঞতা</label>
                                <input type="text" class="semiTinput"  value="{{ $employees->bn_experience }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">১০ । বৈবাহিক অবস্থা :</td>
                            <td class="py-1" colspan="8">
                                <input type="text" class="sinput" @if($employees->bn_marital_status=='1') value="{{ 'অবিবাহিত' }}" @else value="{{ 'বিবাহিত' }}" @endif>
                                <label for="">স্বামী/স্ত্রীর নাম</label>
                                <input type="text" class="semiTinput"  value="{{ $employees->bn_spouse_name }}">
                                <label for="">ছেলের নাম</label>
                                <input type="text" class="sinput"  value="{{ $employees->bn_song_name }}">
                                <label for="">মেয়ের নাম</label>
                                <input type="text" class="sinput"  value="{{ $employees->bn_daughters_name }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" colspan="9"  style="text-align: left;">
                                <label for="">১১ । উত্তরাধীকারী (Next of Kin) এর নাম:</label>
                                <input type="text" class="sinput"  value="{{ $employees->bn_legacy_name }}">
                                <label for="">সম্পর্ক</label>
                                <input type="text" class="verySmall"  value="{{ $employees->bn_legacy_relation }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" colspan="9"  style="text-align: left;">
                                <label for="">১২ । ভর্তিকারীর সুপারিশ/রেফারেন্স নাম:</label>
                                <input type="text" class="sinput" value="{{ $employees->bn_reference_admittee }}">
                                <label for="">মোবাইল</label>
                                <input type="text" class="sminput" value="{{ $employees->bn_reference_adm_phone }}">
                                <label for="" style="padding-left: 11rem;">ঠিকানা</label>
                                <input type="text" class="semiSinput"  value="{{ $employees->bn_reference_adm_adress }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 25%;">১৩ । আবেদিত পদ :</td>
                            <td class="py-1" colspan="8" style="width: 75%;"><input type="text" class="tinput"  value="{{ $employees->position?->name_bn }}"></td>
                        </tr>
                        <tr>
                            <th class="py-1" colspan="9"  style="text-align: left;">
                                ১৪ । এই মর্মে আমি অঙ্গীকার করছি যে, আমার দেওয়া উপরুক্ত বিবরণ/ তথ্যাদি সম্পূর্ণ সঠিক। আমি নির্ধারিত বেতনে আবেদিত পদে অস্থায়ীভাবে এলিট সিকিউরিটি সার্ভিসেস লিমিটেড, চট্টগ্রাম এলাকায় করতে আগ্রহী।  আমি সজ্ঞানে পড়ে ও বুজে নিন্মে স্বাক্ষর করলাম।
                            </th>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left; padding-top: 2rem;"><label for="">তারিখ: {{ date('d-M-Y', strtotime($employees->created_at)) }}</label></td>
                            <td colspan="5" style="text-align: right; padding-top: 2rem; padding-right: 30px;">
                                <img height="50px" width="150px"  src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                <label for="">(আবেদনকারীর স্বাক্ষর)</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-top: 2rem;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="text-align: left;">তারিখ:</td>
                        </tr>
                        <tr>
                            <td  style="text-align: left; padding-left: 45px;">
                                <p style="padding-top: 20px; margin: 0px;">পরিচালক</p>
                                <p style="margin: 0px;">এলিট সিকিউরিটি সার্ভিসেস লি:</p>
                                <p style="margin: 0px;">বাড়ি-২, রোড-, লেন-২, ব্লক-কে,</p>
                                <p style="margin: 0px;">হালিশহর হাউসিং এষ্টেট, চট্টগ্রাম।</p>
                            </td>
                        </tr>
                        <tr>
                            <td  style="text-align: left; ">
                                <label for="">বিষয়:</label>
                                <span style="border-bottom: solid 1px;"><b>নিরাপত্তা প্রহরী/মহিলা প্রহরী/ সুপারভাইজার পদে নিয়োগের জন্য আবেদন।</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left;">জনাব,</td>
                        </tr>
                        <tr>
                            <td  style="text-align: left;">
                                <p style="padding-top: 12px; margin: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;বিশ্বস্ত সূত্রে জানিতে পারলাম <b>"এলিট সিকিউরিটি সার্ভিসেস লি "</b> এর অধীনে কিছু সংখক নিরাপত্তা প্রহরী/মহিলা প্রহরী/সুপারভাইজার নিয়োগ করা হইব।  উক্ত নিরাপত্তা প্রহরী/মহিলা প্রহরী/সুপারভাইজার পদে একজন আগ্রহী প্রার্থী হিসেবে নিন্মে আমার জীবন বৃত্তান্ত পেশ করলাম:-</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="widht:100%;">
                    <tbody>
                        <tr>
                            <th class="py-2" style="width: 25%;">১. নাম</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_applicants_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">২. পিতা নাম </th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_fathers_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৩. মাতার নাম </th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_mothers_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৪. স্থায়ী ঠিকানা </th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 36%;">
                                <p style="margin: 2px;">গ্রাম: {{ $employees->bn_parm_village_name }}</p>
                                <p style="margin: 2px;">উপজেলা: {{ $employees->bn_parm_upazilla?->name_bn }}</p>
                                <p style="margin: 2px;">মোবাইল নং: {{ $employees->bn_parm_phone_alt }}</p>
                            </td>
                            <td class="py-2" style="width: 36%;">
                                <p style="margin: 2px;">পোঃ {{ $employees->bn_parm_post_ofc }}</p>
                                <p style="margin: 2px;">জেলা: {{ $employees->bn_parm_district?->name_bn }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৫. বর্তমান ঠিকানা </th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 36%;">
                                <p style="margin: 2px;">হোল্ডিং/বাসা নং {{ $employees->bn_pre_holding_no }}</p>
                                <p style="margin: 2px;">উপজেলা : {{ $employees->bn_upazilla?->name_bn }}</p>
                            </td>
                            <td class="py-2" style="width: 36%;">
                                <p style="margin: 2px;">পোঃ {{ $employees->bn_pre_post_ofc }}</p>
                                <p style="margin: 2px;">গ্রাম/সড়ক: {{ $employees->bn_pre_village_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৬. শিক্ষাগতা যোগ্যতা</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2"> {{ $employees->bn_edu_qualification }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৭. জন্ম তারিখ</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_dob }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৮. বয়স</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            @php
                            $birthDate = $employees->bn_dob;
                            $age = \Carbon\Carbon::parse($birthDate)->age;
                            @endphp

                            <td class="py-2" style="width: 73%;" colspan="2">{{ $age }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">৯. জাতীয়তা</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_nationality }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">১০. ধর্ম</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->religion?->name_bn }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">১১. অভিজ্ঞতা</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_experience }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" style="width: 25%;">১২. মোবাইল নং</th>
                            <td class="py-2" style="width: 2%;">:</td>
                            <td class="py-2" style="width: 73%;" colspan="2">{{ $employees->bn_parm_phone_my }}</td>
                        </tr>
                        <tr>
                            <th class="py-2" colspan="3">অতএব উপরুক্ত তথ্যাদি আলোকে আমাকে উক্ত পদে নিয়োগ দিলে বাদিত থাকিব।</th>
                        </tr>
                        <tr>
                            <th class="py-2" colspan="3">বিনীত নিবেদক</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="padding-top: 5rem;">
                                <img height="50px" width="150px"  src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                আবেদনকারীর স্বাক্ষর
                            </th>
                        </tr>
                    </tbody>
                </table>
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
                            <td class="tbl_border">তারিখ {{ date('d-M-Y', strtotime($employees->created_at)) }}</td>
                            <td class="tbl_border">তারিখ {{ date('d-M-Y', strtotime($employees->created_at)) }}</td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">২ । নাম :{{ $employees->bn_applicants_name }}</td>
                            <td class="tbl_border"></td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">২ । পিতার নাম: {{ $employees->bn_fathers_name }}</td>
                            <td class="tbl_border">
                                আমি এই মর্মে প্রত্যয়ন করিতেছি যে (নাম )<input type="text" class="sminput"  value="{{ $employees->bn_applicants_name }}">পিতা:<input type="text" class="sminput"  value="{{ $employees->bn_fathers_name }}">
                                মাতা:<input type="text" class="sminput"  value="{{ $employees->bn_mothers_name }}">
                                ঠিকানা :<input type="text" class="semiTinput"  value="{{ $employees->bn_parm_village_name}}, {{ $employees->bn_parm_upazilla?->name_bn}}, {{ $employees->bn_parm_district?->name_bn }}">কে আমি পরীক্ষা করিয়াছি।
                            </td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">৩ । মাতার নাম: {{ $employees->bn_mothers_name }}</td>
                            <td  class="tbl_border">
                                আমি এই মর্মে প্রত্যয়ন করিতেছি যে (নাম )<input type="text" class="sminput"  value="{{ $employees->bn_applicants_name }}">পিতা:<input type="text" class="sminput"  value="{{ $employees->bn_fathers_name }}">
                                মাতা:<input type="text" class="sminput"  value="{{ $employees->bn_mothers_name }}">
                                ঠিকানা :<input type="text" class="semiTinput"  value="{{ $employees->bn_parm_village_name}}, {{ $employees->bn_parm_upazilla?->name_bn}}, {{ $employees->bn_parm_district?->name_bn }}">কে আমি পরীক্ষা করিয়াছি।
                            </td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">৪ । লিঙ্গ: পুরুষ/মহিলা
                            </td>
                            <td  class="tbl_border">
                                তিনি প্রতিষ্টানে নিযুক্ত হইতে ইচ্ছুক এবং আমার পরীক্ষা হইতে এইরূপ পাওয়া গিয়াছে যে তাহার বয়স  <input type="text" class="verySmall text-center"  value="30">বছর এবং তিনি প্রতিষ্টানে প্রাপ্ত বয়স্ক/কিশোর হিসাবে নিযুক্ত হইবার যুগ্য।
                            </td>
                        </tr>
                        <tr class="tbl_border">
                            <td style="width: 40%;"  class="tbl_border">৫ । স্থায়ী ঠিকানা <br>

                                <label for="">গ্রাম:</label>{{ $employees->bn_parm_village_name }}&nbsp;&nbsp;
                                <label for="">পোঃ:</label>{{ $employees->bn_parm_post_ofc }}&nbsp;&nbsp;<br>
                                <label for="">উপজেলা:</label>{{ $employees->bn_parm_upazilla?->name_bn }} &nbsp;&nbsp;<br>
                                <label for="">জেলা:</label>{{ $employees->bn_parm_district?->name_bn }}
                            </td>
                            <td  class="tbl_border">
                                তাহার সনাক্তকরণের চিহ্ন :<input type="text" class="verySmall"  value="30">
                            </td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">৬ । অস্থায়ী/যোগাযোগের ঠিকানা - হোল্ডিং নং - {{ $employees->bn_pre_holding_no }}<br>
                                <label for="">গ্রাম/সড়ক:</label>{{ $employees->bn_pre_village_name }}&nbsp;&nbsp;
                                <label for="">পোঃ:</label>{{ $employees->bn_pre_post_ofc }}&nbsp;&nbsp;<br>
                                <label for="">উপজেলা:</label>{{ $employees->bn_upazilla?->name_bn }} &nbsp;&nbsp;<br>
                                <label for="">জেলা:</label>{{ $employees->bn_district?->name_bn }}
                            </td>
                            <td  class="tbl_border"></td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">৮। জন্ম সনদ/শিক্ষা সনদ অনুসারে বয়স/জন্ম তারিখ :</td>
                            <td  class="tbl_border">{{ date('d-M-Y', strtotime($employees->bn_dob)) }}</td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">৯। দৈহিক সক্ষমতা :</td>
                            <td  class="tbl_border">{{ $employees->bn_cer_physical_ability }}</td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">১০। সনাক্তকরণ চিহ্ন :</td>
                            <td  class="tbl_border">{{ $employees->bn_identification_mark }}</td>
                        </tr>
                        <tr class="tbl_border">
                            <td class="tbl_border">
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <img height="50px" width="150px"  src="{{asset('uploads/concerned_person_sign/'.$employees->concerned_person_sign)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                        <p>সংশ্লিষ্ট ব্যক্তির স্বাক্ষর/টিপসহি </p>
                                    </div>
                                    <div>
                                        <img height="50px" width="150px"  src="{{asset('uploads/bn_doctor_sign/'.$employees->bn_doctor_sign)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                        <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</p>
                                    </div>
                                </div>
                            </td>
                            <td  class="tbl_border">
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <img height="50px" width="150px"  src="{{asset('uploads/concerned_person_sign/'.$employees->concerned_person_sign)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                        <p>সংশ্লিষ্ট ব্যক্তির স্বাক্ষর/টিপসহি </p>
                                    </div>
                                    <div>
                                        <img height="50px" width="150px"  src="{{asset('uploads/bn_doctor_sign/'.$employees->bn_doctor_sign)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                        <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: center; margin-top: 13rem;">
                    <h4>Job Description of Security Guard</h4>
                    <h5><span style="border-bottom: solid 1px;">(সিকিউরিটি গার্ডের কর্ম বিবরণী )</span></h5>
                </div>
                <table style="widht: 100%;">
                    <tbody>
                        <tr>
                            <th>
                                <h6><span style="text-align: left; border-bottom: solid 1px;">পদবী :- গার্ড</span></h6>
                                <h6><span style="text-align: left; border-bottom: solid 1px;">বিভাগ :- সিকিউরিটি</span></h6>
                                <h6><span style="text-align: left; border-bottom: solid 1px;">দায়িত্ব ও কর্তব্য :</span></h6>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-left: 2rem;">
                                <p style="margin: 12px;">১. কোম্পনির নিয়ম-নীতি ও কর্তৃপক্ষের নির্দেশ অনুযায়ী সকল কার্যক্রম পরিচালনা করা।</p>
                                <p style="margin: 12px;">২. ফ্যাক্টরীর সম্পদের উপর সার্বক্ষণিক কড়া নজর রাখতে হবে।</p>
                                <p style="margin: 12px;">৩. মেইন গেইটের নিরাপত্তা (খোলা ও বন্ধ ) নিশ্চিত করা। </p>
                                <p style="margin: 12px;">৪. বহির্গমন দরজা তালামুক্ত ও বাধামুক্ত রাখা।</p>
                                <p style="margin: 12px;">৫. কারখানার চারদিকে টহল দেয়া। </p>
                                <p style="margin: 12px;">৬. বহিরাগতদের বা দর্শনার্থীদের পরিচয় ও সাক্ষাতের কারণ কর্তৃপক্ষকে অবশই অবগত করা।</p>
                                <p style="margin: 12px;">৭. বহির্গমন পথসমূহ সবসময় যাতে বাধামুক্ত থাকে তা নিশ্চিত করা।</p>
                                <p style="margin: 12px;">৮. ছুটির সময় প্রত্যেক শ্রমিক/কর্মীদের বহনকৃত বাগসমূহ সঠিকভাবে চেক করা। </p>
                                <p style="margin: 12px;">৯. কারখানার সকল অগ্নি নিরাপত্তা সরঞ্জামাদি সর্বদা বাধামুক্ত আছে কিনা তা নিশ্চিত করা।</p>
                                <p style="margin: 12px;">১০. সকলের সাথে (শ্রমিক ও কর্তৃপক্ষ ) পর্যাপ্ত যোগাযোগ  ব্যবস্থা নিশ্চিত করা।</p>
                                <p style="margin: 12px;">১১. কোনো ধরণের বিপদের সময় কারখানায় কর্মরত সকলের নিরাপত্তা নিশ্চিত করা।</p>
                                <p style="margin: 12px;">১২. ক্রয়কৃত মালামাল কারখানায় প্রবেশের সময় সঠিকভাবে চেক করা। </p>
                                <p style="margin: 12px;">১৩. কর্তৃপক্ষের অনুমতি প্রাপ্ত প্রত্যেক দর্শনার্থী বা বহিরাগতদের পরিচয় ও সাক্ষাতের কারণ ভিজিটর রেজিস্টারে লিপিবদ্ধ করতে সহযোগিতা করা।</p>
                                <p style="margin: 12px;">১৪. যে কোনো পণ্য কারখানা থেকে বাহিরে যাওয়ার সময় ও কারখানায় প্রবেশ করার সময় গেট পাশ ও চালান সংগ্রহ করে সুপারভাইজারের কাছে হস্তান্তর করা।</p>
                                <p style="margin: 12px;">১৫. কন্টেইনার কারখানায় প্রবেশের পূর্বে এর ভিতর ও বাহির সঠিকভাবে মেটাল ডিটেক্টর দিয়ে পরীক্ষা করে দেখতে হবে কোথাও কোনো বিষ্ফোরক দ্রব্য, দাহ্যপদার্থ, অবৈধ মালামাল ও যন্ত্রপাতি আছে কিনা।  যদি অবৈধ কোনো কিছু পাওয়া যায় তবে তা সাথে সাথে কর্তৃপক্ষকে অবহিত করতে হবে।</p>
                                <p style="margin: 12px;">১৬. কোনো প্রকার দুর্ঘটনা, অগ্নিকান্ড, হাঙ্গামা, হৈ চৈ ও ব্যাক্তিগত বা কোম্পানির ক্ষতিজনিত বিষয় তৎক্ষণাৎ দায়িত্বরত সুপারভাইজারকে/কর্তৃপক্ষকে জানানো।</p>
                                <p style="margin: 12px;">১৭. কাজের পুনরাবৃত্তি উপেক্ষা করতে সঠিক কর্মপদ্ধতিতে কর্ম পরিচালনা করতে হবে। </p>
                                <p style="margin: 12px;">১৮. প্যাকিংয়ে প্রবেশকালে প্রত্যেকের নাম ও পদবী ও প্রবেশের কারণ উল্লেখপূর্বক প্রবেশ ও বাহিরের সময় এন্ট্রি করা। (পাকিং এরিয়ায় কর্মরত গার্ডের জন্য প্রযোজ্য )</p>
                                <p style="margin: 12px;">১৯. বাউন্ডারীর নিরাপত্তা নিশ্চিত কর। (বাউন্ডারীর পোষ্টে কর্মরত গার্ডের জন্য প্রযোজ্য)</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="widht: 100%; margin-top: 2rem;">
                    <tbody>
                        <tr>
                            <th>
                                <h6><span style="text-align: left; border-bottom: solid 1px;">দক্ষতা:</span></h6>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-left: 2rem;">
                                <p style="margin: 12px;">১. নিজের দায়িত্ব সম্পর্কে যথাযত জ্ঞান থাকতে হবে।</p>
                                <p style="margin: 12px;">২. কাজের প্রতি মনোযোগী হতে হবে। </p>
                                <p style="margin: 12px;">৩. নির্দিষ্ট সময়ের কাজ নির্দিষ্ট সময়ের মধ্যে শেষ করার মানসিকতা থাকতে হবে। </p>
                                <p style="margin: 12px;">৪. যেকোনো জায়গায় নিরাপত্তা নিশ্চিত করার দক্ষতা থাকা। </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><span style="text-align: left; border-bottom: solid 1px;">ব্যাক্তিত্ব:</span></h6>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-left: 2rem;">
                                <p style="margin: 12px;">১. নিরাপত্তা নীতি, হয়রানী ও উৎপীড়নমুক্ত নীতি সম্পর্কে যথেষ্ট জ্ঞান ও প্রশিক্ষণ থাকতে হবে।</p>
                                <p style="margin: 12px;">২. বিনা অনুমতিতে অনুপস্থিত না থাকা।</p>
                                <p style="margin: 12px;">৩. কারো সাথে খারাপ আচরণ না করা।</p>
                                <p style="margin: 12px;">৪. নিয়মিত সকল ট্রেনিং এ অংশগ্রহণ করা।</p>
                                <p style="margin: 12px;">৫. সর্বদা সহযোগিতামূলক আচরণ করতে হবে। </p>
                                <p style="margin: 12px;">৬. সুপারভাইজার নির্দেশ মেনে চলা। </p>
                                <p style="margin: 12px;">৭. কর্মরত অবস্থায় সর্বদা পরিচয় ও পোষাক পরিধান করবে। </p>
                                <p style="margin: 12px;">৮. যে কোনো ধরণের পরিবর্তনের সাথে খাপ খাওয়ানোর ক্ষমতা থাকতে হবে।</p>
                                <p style="margin: 12px;">৯. কোনো অবস্থাতেই কারো সাথে শারীরিক বা মানসিক নির্যাতন, গালিগালাজ, হয়রানী এবং যৌনহয়রানি করা যাবে না। </p>
                                <p style="margin: 12px;">১০. নিরাপত্তা কাজে নিয়োজিত প্রহরী দৈনন্দিন সাধারণ কাজ কর্ম সম্পাদনের ক্ষেত্রে পেশিশক্তি ব্যবহার করবে না। </p>
                                <p style="margin: 12px; padding-bottom:2rem;">১১. প্রতিষ্ঠানের পরিবেশ পরিষ্কার -পরিছন্ন রাখতে বিশেষ  ভূমিকা পালন করা। </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: .5rem; border: solid 1px; text-align:center;">
                                <h6 class="py-2">আমি এই পত্রখানা পড়িয়া, বুঝিয়া সজ্ঞানে ও স্ব-ইচ্ছায় সাক্ষর করিয়া মূলকপি গ্রহণ করিলাম</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="mt-5" style="widht: 100%;">
                    <tbody>
                        <tr>
                            <th>
                                {{--  <img src="" alt="alt" width="120px" height="50px;"><br>  --}}
                                <span style="border-top: solid 1px;">অনুমোদনকারী</span>
                            </th>
                            <th>
                                <h6>স্বাক্ষর-</h6>
                                <h6>পূর্ণ নাম-</h6>
                                <h6>কার্ড নং-</h6>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-top: 13rem;">
                    <tbody>
                        <tr>
                            <td style="width: 33%">
                                <div>
                                    <img  class="mt-4" height="80px" width="140px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
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
                            <td colspan="2"><input type="text" class="tinput" value="{{ $employees->bn_applied_position }}"></td>
                            <th>আইডি নং</th>
                            <td><input type="text" class="tinput" value="{{ $employees->admission_id_no }}"></td>
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
                            <td colspan="4"><input type="text" class="tinput" value="{{ $employees->bn_dob }}"></td>
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
                            <td >
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
                            <td >
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
                            <th style="width: 25%;">১২।  বর্তমান ঠিকানা:</th>
                            <td >
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
                            <th >১৩। জমিদারের নাম ও মোবাইল নং:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_landlord_name }} , {{ ($security?->bn_landlord_mobile_no) }}"></td>
                        </tr>
                        <tr>
                            <th >১৪। বর্তমান ঠিকানায় কতদিন যাবৎ বাস করছেন:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_living_dur }}"></td>
                        </tr>
                        <tr>
                            <th >১৫। বৈবাহিক অবস্থা:</th>
                            <td>
                                <input type="text" class="sbinput" @if($employees->bn_marital_status==1) value="{{ 'অবিবাহিত' }}" @else value="{{ 'বিবাহিত' }}" @endif>
                                <label for="">জাতীয়তা :</label>
                                <input type="text" class="sbinput" value="{{ $employees->bn_nationality }}">
                            </td>
                        </tr>
                        <tr>
                            <th >১৬। জাতীয় পরিচয়পত্র নং:</th>
                            <td><input type="text" class="tinput" value="{{ $employees->bn_nid_no }}"></td>
                        </tr>
                        <tr>
                            <th >১৭। পাসপোর্ট নং (যদি থাকে):</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_passport_no }}"></td>
                        </tr>
                        <tr>
                            <th >১৮। পূর্বের কর্মস্থলের নাম কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_old_office_name }}"></td>
                        </tr>
                        <tr>
                            <th >১৯। পূর্বের কর্মস্থলের ঠিকানা:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_old_office_address }}"></td>
                        </tr>
                        <tr>
                            <th >২০। পূর্বের কর্মস্থল হতে চাকুরী ছাড়ার কারণ কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_resign_reason }}"></td>
                        </tr>
                        <tr>
                            <th >২১। পূর্বের কর্মস্থল অব্যহতি পত্র দিয়েছিলেন কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_resign_letter_status }}"></td>
                        </tr>
                        <tr>
                            <th >২২। সার্ভিস বই আছে কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_service_book_status }}"></td>
                        </tr>
                    </tbody>
                </table>
                <table style="widht: 100%;">
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
                                {{--  <label for="">20 বছর</label>
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
                            <td><input type="text" class="tinput" value="{{ $security?->bn_mobile_no }}"></td>
                        </tr>
                        <tr>
                            <th colspan="">৩২। সীম কার্ড রেজিস্টেশন করা আছে কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_sim_card_reg_status }}"></td>
                        </tr>
                        <tr>
                            <th colspan="">৩৩। আপনার দায়ের করা বা আপনার বিরুদ্ধে থানায় কিংবা আদালতে (স্থানীয় ও বর্তমান ) কোনো মামলা আছে কি:</th>
                            <td><input type="text" class="tinput" value="{{ $security?->bn_case_filed_status }}"></td>
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
                                <input type="text" class="sbinput" value="{{ $security?->bn_identifier_phone1 }}">
                                <label for="">(খ) নাম:</label>
                                <input type="text" class="sbinput" value="{{ $security?->bn_identifier_name2 }}">
                                <label for="">পেশা:</label>
                                <input type="text" class="sbinput" value="{{ $security?->bn_identifier_occupation2 }}"><br>
                                <label for="">ঠিকানা:</label>
                                <input type="text" class="sbinput" value="{{ $security?->bn_identifier_address2 }}">
                                <label for="">ফোন নং:</label>
                                <input type="text" class="sbinput" value="{{ $security?->bn_identifier_phone2 }}">
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
                            <th style="width: 50%; padding-bottom: 3rem;">
                                <img height="50px" width="150px"  src="{{asset('uploads/informant_sing/'.$security?->informant_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                <span style="border-top: solid 1px;">তথ্যদানকারীর স্বাক্ষর</span>
                            </th>
                            <th style="padding-bottom: 3rem;">
                                <img height="50px" width="150px"  src="{{asset('uploads/data_collector_sing/'.$security?->data_collector_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                <span style="border-top: solid 1px;">তথ্য সংগ্রহকারীর স্বাক্ষর</span>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <th colspan="2"><h6><span style="border-bottom: solid 1px;">অফিস ব্যবহারের অংশ</span></h6></th>
                        </tr>
                        <tr>
                            <th colspan="2" style="padding-bottom: 3rem;"><p>তথপ্রদানকারীর তথ্য ও সকল কাগজপত্র পর্যবেক্ষন ও সনাক্তকারীদের নিশ্চয়তার ভিত্তিতে তথ্য সমূহ সঠিক/সঠিক নহে বলে প্রতীয়মান হয়েছে।<br>উপরুক্ত তথ্য যাচাইয়ের ক্ষেত্রে ব্যবহৃত মাধ্যম : </p></th>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <tbody>
                        <tr style="text-align: center">
                            <th style="width: 50%;">
                                <img height="50px" width="150px"  src="{{asset('uploads/executive_sing/'.$security?->executive_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                <span style="border-top: solid 1px;">এক্সেকিউটিভ(এইচআর)</span>
                            </th>
                            <th>
                                <img height="50px" width="150px"  src="{{asset('uploads/manager_sing/'.$security?->manager_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                <span style="border-top: solid 1px;">ম্যানেজার (অপারেশন )</span>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</section>

<script>
    function printDiv(divName) {
        var prtContent = document.getElementById(divName);
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.onload =function(){
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }
    }
</script>
@endsection
