@extends('layout.app')
@section('content')
<div>
    <a href="#" onclick="history.back()" class="btn btn-info no-print"> Go To Dashboard</a>
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
        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-3">
                    <img  class="mt-5" height="80px" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
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
                    <img class="tbl_border" height="150px" width="150px"  src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">
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
                            <td colspan="4" style="text-align: left;"><label for="">তারিখ: {{ date('d-M-Y', strtotime($employees->created_at)) }}</label></td>
                            <td colspan="5" style="text-align: right; padding-right: 30px;">
                                {{--  @if($employees->signature_img !='')  --}}
                                <img height="50px" width="150px"  src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                {{--  @endif  --}}
                                <label for="">(আবেদনকারীর স্বাক্ষর)</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-top: 1rem;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="text-align: left;">তারিখ: {{ date('d-M-Y', strtotime($employees->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td  style="text-align: left; padding-left: 45px;">
                                <p style="padding-top: 10px; margin: 0px;">পরিচালক</p>
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
                            <td class="py-1" colspan="4" style="width: 100%;">অতএব উপরুক্ত তথ্যাদি আলোকে আমাকে উক্ত পদে নিয়োগ দিলে বাদিত থাকিব।</td>
                        </tr>
                        <tr>
                            <th class="py-1" colspan="3">বিনীত নিবেদক</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="">
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
                            <td class="tbl_border">তারিখ {{ date('d/m/Y', strtotime($employees->created_at)) }}</td>
                            <td class="tbl_border">তারিখ {{ date('d/m/Y', strtotime($employees->created_at)) }}</td>
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
                                তিনি প্রতিষ্টানে নিযুক্ত হইতে ইচ্ছুক এবং আমার পরীক্ষা হইতে এইরূপ পাওয়া গিয়াছে যে তাহার বয়স  <input type="text" class="verySmall text-center"  value="{{ $age }}">বছর এবং তিনি প্রতিষ্টানে প্রাপ্ত বয়স্ক/কিশোর হিসাবে নিযুক্ত হইবার যুগ্য।
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
                                তাহার সনাক্তকরণের চিহ্ন :<input type="text" class="sinput"  value="{{ $employees->bn_identification_mark }}">
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

                <div style="text-align: center; margin-top: 4rem;">
                    <h4>{{ $jobdescription?->head_title }}</h4>
                    <h5><span style="border-bottom: solid 1px;">{{ $jobdescription?->head_title_bn }}</span></h5>
                </div>
                <table style="widht: 100%;">
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
                <table style="widht: 100%; margin-top: 2rem;">
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
                <table style="width: 100%; margin-top: 10rem;">
                    <tbody>
                        <tr>
                            <td style="width: 33%">
                                <div>
                                    <img  class="mt-4" height="80px" width="auto" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
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
                            <td><input type="text" class="tinput" value="@if ($security?->bn_resign_letter_status=='1') হা @else না @endif"></td>
                        </tr>
                        <tr>
                            <th >২২। সার্ভিস বই আছে কি:</th>
                            <td><input type="text" class="tinput" value="@if ($security?->bn_service_book_status=='1') হা @else না @endif"></td>
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
                                @if($security?->informant_sing !='')
                                <img height="50px" width="150px"  src="{{asset('uploads/informant_sing/'.$security?->informant_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                @endif
                                <span style="border-top: solid 1px;">তথ্যদানকারীর স্বাক্ষর</span>
                            </th>
                            <th style="padding-bottom: 3rem;">
                                @if($security?->data_collector_sing !='')
                                <img height="50px" width="150px"  src="{{asset('uploads/data_collector_sing/'.$security?->data_collector_sing)}}" alt="কোন স্বাক্ষর নেই"><br/>
                                @endif
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
                            <th colspan="2" style=""><p>তথপ্রদানকারীর তথ্য ও সকল কাগজপত্র পর্যবেক্ষন ও সনাক্তকারীদের নিশ্চয়তার ভিত্তিতে তথ্য সমূহ সঠিক/সঠিক নহে বলে প্রতীয়মান হয়েছে।<br>উপরুক্ত তথ্য যাচাইয়ের ক্ষেত্রে ব্যবহৃত মাধ্যম : </p></th>
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
                <div class="text-center" style="margin-top: 2rem;">
                    {{--  <h5><span style="border-bottom: solid 1px;">পৃষ্ঠা-২</span></h5>  --}}
                    <h4><span style="border-bottom: solid 1px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড এ ভর্তি হয়ে চাকুরীকালীন সময়ে পালনীয় দায়িত্ব ও শর্তাবলী</span></h4>
                </div>
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p>
                                    ১।  যোগ্যতা সম্পন্ন প্রত্যেক আবেদনকারীকে ৩,৫০০/- (তিন হাজার পাঁচশত টাকা) ভর্তির ফি (অফেরতযোগ্য) বাবদ জমা দিতে হবে। আবেদন পত্রের সাথে রিক্রুটিং অফিসারের নিকট প্রয়োজনীয় কাগজপত্র (সদ্য উত্তোলনকৃত চেয়ারম্যান সার্টিফিকেটের মূল কপি, জাতীয় পরিচয় পত্রের ফটোকপি, জন্ম নিবন্ধন এর সনদ, শিক্ষাগত যোগ্যতার সনদ, ৪ কপি পাসপোর্ট ও ২ কপি ষ্ট্যাম্প আকারের ছবি) জমা দিয়ে নির্দিষ্ট পদের জন্য ভর্তি হতে হবে।
                                </p>
                                <p>
                                    ২।  ভর্তির পরে আমার নিজ দায়িত্বে আমার স্থায়ী ঠিকানার পুলিশ কর্তৃপক্ষ থেকে প্রাক-পরিচিতি যাচাই পূর্বক পুলিশ ভেরিফিকেশন প্রতিবেদনটি অনতিবিলম্বে এলিট ফোর্স, চট্টগ্রাম অফিসে জমা করতে বাধ্য থাকবো। তবে পরবর্তীতে পুলিশ ভেরিফিকেশন রিপোর্ট এর সাথে আমার দেওয়া তথ্য ভূয়া/মিথ্যা প্রমাণিত হলে আমাকে বিনা নোটিশে চাকুরীচ্যুত করতে পারবেন।
                                </p>
                                <p>
                                    ৩।  আমি অত্র সংস্থায় কমপক্ষে তিন বছর চাকুরী করিতে বাধ্য থাকবো।
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
                                <p>
                                    ১২। কোন প্রহরী চুরি, ডাকাতি, রাহাজানি কিংবা কোন অসামাজিক কাজে লিপ্ত হতে পারবে না। এ রকম কোন কাজে লিপ্ত হলে অথবা অন্য কাউকে সহযোগীতা করার প্রমাণ পাওয়া গেলে তাহলে আর্থিক জরিমানা/দন্ড এবং চাকুরীচ্যুতসহ তার বিরুদ্ধে গণপ্রজাতন্ত্রী বাংলাদেশ সরকারে প্রচলিত আইন অনুসারে প্রয়োজনীয় ব্যবস্থা গ্রহণ করা হবে।
                                </p>
                                <p>
                                    ১৩। যদি কোন প্রহরী চাকুরী হতে অব্যাহতি পেতে চায় তাহলে কমপক্ষে ২ (দুই) মাস পূর্বে তাকে কোম্পানীর কাছে লিখিত দরখাস্ত প্রদান করতে হবে এবং তার স্থলে উপযুক্ত একজন বদলী প্রহরী ভর্তির ব্যবস্থা করতে হবে। অফিস কর্তৃপক্ষ দরখাস্ত গ্রহণের ২ (দুই) মাস পরে দেনা-পাওনা বুঝিয়ে দিয়ে চাকুরী থেকে অব্যাহতি প্রদান করবে যদি কমপক্ষে তার চাকুরী ৩ বছর পূর্ণ হয়। তবে শর্ত থাকে যে তাকে প্রদানকৃত সকল পোশাক পরিচ্ছেদ এলিট ফোর্স, চট্টগ্রাম অফিসে জমা করে ছাড়পত্র গ্রহণ করতে হবে।
                                </p>
                                <p>
                                    ১৪ । এক বার চাকুরী থেকে অব্যাহতি নিয়ে যাওয়ার পর পরবর্তীতে পুনরায় ভর্তি হওয়ার ইচ্ছা প্রকাশ করলে পুনরায় ভর্তি ফি জমা দিয়ে ভর্তি হতে হবে । তবে শর্ত থাকে যে তিন মাসের কম সময়ে পুনঃভর্তি হলে ভর্তির ফি মওকুফ করা যাবে।
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
                                <p style="margin-bottom: 0px !important">
                                    ২৩। ভর্তির পর ৬(ছয়) মাসের মধ্যে ছুটি দেওয়া যাবে না। কেউ বিবাহিত হলে এবং ফ্যামিলি গ্রামের বাড়ীতে থাকলে ৩ মাস পরে ছুটি দেওয়া যেতে পারে। জরুরী প্রয়োজন, দুর্ঘটনা কিংবা কোন বিশেষ প্রয়োজনে অবশ্যই ছুটি বিবেচনা যোগ্য ।
                                </p>
                                <p  style="margin-bottom: 0px !important">
                                    ২৪। প্রহরীগণ বছরে ১২ দিন ছুটি পাওয়ার যোগ্য। তবে ১ বছর চাকুরী শেষে এই ছুটির আংশিক বেতন প্রদানযোগ্য।
                                </p>
                                <p  style="margin-bottom: 0px !important">
                                    ২৫। কোন ব্যক্তি/প্রহরী এলিট সিকিউরিটি সার্ভিসেস লিঃ এ ভর্তি হওয়ার পরে কোন অবস্থাতেই কোন সমিতি অথবা ট্রেড ইউনিয়ন সংগঠন করতে বা এই ধরণের কোন সংগঠনের কর্মকান্ডের সাথে সম্পৃক্ত হতে/থাকতে পারবে না।
                                </p>
                                <p  style="margin-bottom: 0px !important">
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
                            {{--  <img src="{{asset('assets/images/terms1.jpeg')}}" alt=""><br/>  --}}
                        </tr>
                        {{--  <h5><span style="border-bottom: solid 1px;">পৃষ্ঠা-৩</span></h5>  --}}
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <tbody>
                        {{--  <tr style="text-align: center">
                            <img src="{{asset('assets/images/terms2.jpeg')}}" alt="কোন স্বাক্ষর নেই"><br/>
                        </tr>  --}}
                        <tr style="text-align: end">
                            <td>আবেদনকারীর স্বাক্ষর</td><br/>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <tbody>
                        <tr >
                            <th colspan="4"></th>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <div style="text-align: center;"> <h4 style="margin-bottom: 0px;"><span style="border-bottom: solid 1px;">অঙ্গীকারনামা</span></h4></div>
                    <tbody>
                        <tr>
                            <td class="py-1" style="text-align: left; width: 15%;">আমি, নামঃ</td>
                            <td class="py-1" style="width: 20%;"><input type="text" class="tinput"  value="{{ $employees->bn_applicants_name }}"></td>
                            <td class="py-1" style="text-align: center; width: 10%;">পিতাঃ</td>
                            <td class="py-1" style="width: 15%;"><input type="text" class="tinput"  value="{{ $employees->bn_fathers_name }}"></td>
                            <td class="py-1" style="text-align: center; width: 40%;">উপরের  উল্লেখিত ১ থেকে ৩০ পর্যন্ত</td>
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
                                আমি সজ্ঞানে পড়ে, বুঝে ও সকল শর্ত মেনে নিয়ে নিজ ইচ্ছায় আমার স্বাক্ষর প্রদান করলাম। ভর্তিকালীন সময়ে ভর্তির ফি বাবদ
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 10% !important;">নগদ</td>
                            <td style="width: 10% !important;"><input readonly type="text" class="verySmall"  value=""></td>
                            <td style="text-align: center; width: 25% !important;">টাকা প্রদান করলাম।বাকী</td>
                            <td style="width: 10% !important;"><input readonly type="text" class="verySmall"  value=""></td>
                            <td style="text-align: center; width: 45% !important;">টাকা আমার মাসিক বেতন থেকে সমন্বয় করে দিব।</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 5%;">স্বাক্ষীর স্বাক্ষরঃ </td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%;">স্বাক্ষরঃ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value=""></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 5%;"></td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%;">আবেদনকারীর নামঃ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value="{{ $employees->bn_applicants_name }}"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 5%;"></td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%;">তারিখ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value="{{ date('d-M-Y', strtotime($employees->created_at)) }}"></td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    {{--  <p style="text-align: center;">পৃষ্ঠা-৪</p>  --}}
                    <div style="text-align: center;"> <h4 style="margin-top:2px !important;"><span style="border-bottom: solid 1px; margin-top:1px !important">অফিসে ব্যবহারের জন্য</span></h4></div>
                    <tbody>
                        <tr>
                            <td colspan="5" style='text-align:justify;'>
                                আবেদনকারীর শারীরিক, মানসিক ও শিক্ষাগত যোগ্যতা বিবেচিত হওয়ার ফলে এলিট সিকিউরিটি সার্ভিসেস লিঃ এর
                                অধীনে <b>{{ $employees->position?->name_bn }}</b> পদে প্রাথমিকভাবে নির্বাচন করে
                                ভর্তি করা হলো। ভর্তির তারিখ <b>{{ date('d-M-Y', strtotime($employees?->created_at)) }}</b> । ভর্তির ফি সম্পূর্ণ নগদ প্রদানে অপরাগতায় জাতীয় পরিচয়
                                পত্র নম্বর <b>{{ $employees->bn_nid_no }} </b> এর কার্ডটি জমা রাখা হল যা ভর্তির শর্ত পূর্ণ হলে ফেরত প্রদানযোগ্য।
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 10%; padding-top: 50px;">প্রশিক্ষণ কর্মকর্তা </td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%; padding-top: 50px;">জোন কমান্ডার/ভর্তিকারী কর্মকর্তা</td>
                            <td style="width: 10%;"></td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <p style="text-align: center; padding-top: 30px;">ডিজিএম/জেনারেল ম্যানেজার</p>
                    <div style="text-align: center;"> <h4><span style="border-bottom: solid 1px;">আঙ্গুলের ছাপ</span></h4></div>
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
                            <td style="width: 10%; padding-bottom: 40px;">১.কনিষ্ঠ</td>
                            <td style="text-align: end; width: 40%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">১.কনিষ্ঠ</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 20%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">২.অনামিকা</td>
                            <td style="text-align: end; width: 40%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">২.অনামিকা</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 20%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৩.মধ্যমা</td>
                            <td style="text-align: end; width: 40%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৩.মধ্যমা</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 20%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৪.তর্জনী</td>
                            <td style="text-align: end; width: 40%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৪.তর্জনী</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 20%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৫.বৃদ্ধা</td>
                            <td style="text-align: end; width: 40%;"></td>
                            <td style="width: 10%; padding-bottom: 40px;">৫.বৃদ্ধা</td>
                            <td style="width: 20%;"></td>
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
                            <td style="width: 30%;"><input readonly type="text" class="tinput"  value="{{ date('d-M-Y', strtotime($employees->created_at)) }}"></td>
                            <td style="text-align: end; width: 25%;">নামঃ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value=""></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 5%;"></td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%;">নংঃ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value=""></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 5%;"></td>
                            <td style="width: 30%;"></td>
                            <td style="text-align: end; width: 25%;">স্বাক্ষরঃ</td>
                            <td style="width: 10%;"><input readonly type="text" class="tinput"  value=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section>
        <div class="row" style="margin-top: 10rem;">
            <div class="col-9 text-center mb-5" style="margin-bottom: 50px !important;">
                <h5 style="padding-top: 3rem;">ELITE SECURITY SERVICES LIMITED </h5>
                <p style="margin: 1px;">BIO-DATA</p>
                <p style="margin: 1px;"><b style="border-bottom: solid 1px;">{{ $employees->position?->name }}</b></p>
            </div>
            <div class="col-3">
                <img class="tbl_border" height="150px" width="150px"  src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="No Img">
            </div>
        </div>
        <table class="tbl_border" style="width: 100%;">
            <tbody>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">1</th>
                    <th class="tbl_border">Name</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_applicants_name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">2</th>
                    <th class="tbl_border">Designation</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->position?->name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">3</th>
                    <th class="tbl_border">Place of Posting</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_place_of_posting }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">4</th>
                    <th class="tbl_border">Employee ID No</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->admission_id_no }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">5</th>
                    <th class="tbl_border">Height</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_height_foot }} Feet {{ $employees->en_height_inc }} Inch</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">6</th>
                    <th class="tbl_border">Blood Group</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->bloodgroup?->name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">7</th>
                    <th class="tbl_border">Father's Name</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_fathers_name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">8</th>
                    <th class="tbl_border">Mother's Name</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_mothers_name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">9</th>
                    <th class="tbl_border">Next of Kin(NOK)</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_legacy_name }}, ({{ $employees->en_legacy_relation }})</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">10</th>
                    <th class="tbl_border">Present Address</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_pre_post_ofc }} ,  {{ $employees->en_pre_village_name }} ,  {{ $employees->bn_pre_ward?->name }} ,  {{ $employees->bn_union?->name }} ,  {{ $employees->bn_upazilla?->name }} ,  {{ $employees->bn_district?->name }} </th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">11</th>
                    <th class="tbl_border">Permanent Address</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_parm_post_ofc }} ,  {{ $employees->en_parm_village_name }} ,  {{ $employees->bn_parm_ward?->name}} ,  {{ $employees->bn_parm_union?->name }} ,  {{ $employees->bn_parm_upazilla?->name }} ,  {{ $employees->bn_parm_district?->name }} </th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">12</th>
                    <th class="tbl_border">NID/Birth Certificate No</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">@if($employees->en_nid_no) {{ 'NID  :'.$employees->en_nid_no }} @else {{ 'B.C.  :'.$employees->en_birth_certificate }} @endif</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">13</th>
                    <th class="tbl_border">Date of Birth</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ date('d-M-Y', strtotime($employees->bn_dob)) }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">14</th>
                    <th class="tbl_border">Personal & Alt. Phone No</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_parm_phone_my }}  ,  {{ $employees->en_parm_phone_alt }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">15</th>
                    <th class="tbl_border">Educational Qualification</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_edu_qualification }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">16</th>
                    <th class="tbl_border">Experience</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_experience }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">17</th>
                    <th class="tbl_border">Religion</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->religion?->name }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">18</th>
                    <th class="tbl_border">Marital Status</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border"> @if($employees->bn_marital_status=='1') {{ 'Unmarried' }} @else {{ 'Married' }} @endif</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">19</th>
                    <th class="tbl_border">Character Certificate <br> (By Chairman)</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">(Certificate attached)</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">20</th>
                    <th class="tbl_border">Nationality</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_nationality }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">21</th>
                    <th class="tbl_border">Identification Mark(if any)</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">{{ $employees->en_identification_mark }}</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">22</th>
                    <th class="tbl_border">Is any case filed against him <br> in any court of Justice</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">@if($employees->en_is_any_case=='1') {{ 'Yes' }} @elseif($employees->en_is_any_case=='2') {{ 'No' }}@else  @endif</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">23</th>
                    <th class="tbl_border">Had he ever been convicted <br> by the criminal Court</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">@if($employees->en_is_criminal_court=='1') {{ 'Yes' }} @elseif($employees->en_is_criminal_court=='2') {{ 'No' }}@else  @endif</th>
                </tr>
                <tr class="tbl_border" >
                    <th class="tbl_border" style="text-align: center;">24</th>
                    <th class="tbl_border">Any Other Information</th>
                    <th class="tbl_border" style="text-align: center;">:</th>
                    <th class="tbl_border">@if($employees->en_any_other_info=='1') {{ 'Yes' }} @elseif($employees->en_any_other_info=='2') {{ 'No' }}@else  @endif</th>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-12 text-end mt-5" style="margin-top: 50px !important;">
                <p style="margin: 1px;"><b style="border-top: solid 2px;">Signature of the  {{ $employees->position?->name }}</b></p>
            </div>
        </div>
        <p class="mb-0 pb-0">I have checked and verified the above mentioned information and found all correct.</p>
        <p class="mt-0 pt-0"><span style="border-bottom: solid 1px;">Certified by</span> </p>
    </section>
    <section>
        <div class="row" style="margin-top: 10rem;">
            <div class="col-12 text-center mb-5" style="margin-bottom: 50px !important;">
                <h5 style="padding-top: 3rem;"> <span style="border-bottom: solid 1px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড এ ভর্তি ফি সংক্রান্ত</span></h5>
                <p style="margin: 1px;"><b style="border-bottom: solid 1px;">হলফনামা</b></p>
            </div>
        </div>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td>আমি</td>
                    <td colspan="2"><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                    <td>বয়স</td>
                    <td><input type="text" class="tinput" value="{{ $age }}"></td>
                    <td>পিতা</td>
                    <td colspan="2"><input type="text" class="tinput" value="{{ $employees->bn_fathers_name }}"></td>
                </tr>
                <tr>
                    <td>মাতা</td>
                    <td colspan="2"><input readonly type="text" class="tinput" value="{{ $employees->bn_mothers_name }}"></td>
                    <td>গ্রাম</td>
                    <td><input type="text" class="tinput" value="{{ $employees->bn_parm_village_name }}"></td>
                    <td>ডাকঘর</td>
                    <td colspan="2"><input type="text" class="tinput" value="{{ $employees->bn_parm_post_ofc }}"></td>
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
                    <td>নং</td>
                    <td><input readonly type="text" class="tinput" value=""></td>
                    <td>গত</td>
                    <td><input type="text" class="tinput" value=""></td>
                    <td>ইং তারিখে {{ $employees->position?->name_bn }}</td>
                    <td colspan="3">হিসেবে এলিট সিকিউরিটি সার্ভিসেস লিঃ এ ভর্তি হয়েছি।</td>
                </tr>
                <tr>
                    <td colspan="8">
                        আমি স্বজ্ঞানে, সু্স্থ্য মস্তিষ্কে, অন্যের বিনা প্ররোচনায় হলফ পূর্বক ঘোষণা করছি যে, ভর্তি
                        হওয়ার সময় আমি ভর্তি ফি বাবদ {{ $employees->bn_traning_cost }} টাকা মাত্র প্রদান করেছি। আমি আরো ঘোষণা
                        করছি যে, উল্লেখিত ভর্তি ফি ছাড়া অতিরিক্ত কোন অর্থ প্রদান করি নাই এবং তৃতীয় কোন
                        পক্ষের সাথে ভর্তি ফি সংক্রান্ত কোন লেনদেন করি নাই। ভর্তি ফি প্রদানের ব্যাপারে আমার
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
        <div class="row"  style="margin-top: 50px !important;">
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
    </section>
    <section>
        <div class="row" style="margin-top: 13rem;">
            <div class="col-12 text-center mb-5" style="margin-bottom: 50px !important;">
                <h5 style="padding-top: 3rem;"> <span> জনবল ভর্তির প্রাথমিক কার্যক্রম</span></h5>
                {{--  <span class="text-end" style="padding-left: 50px !important;">তারিখ:{{ date('d-m-Y', strtotime($employees->created_at)) }}</span>  --}}
                <p style="margin: 1px;"><b>এলিট সিকিউরিটি সার্ভিসেস লিমিটেড,চট্টগ্রাম ।</b></p>
            </div>
        </div>
        <table style="width: 100%;">
            <tbody>
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
                    <td><input type="text" class="tinput" value="{{ $age }}"></td>
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
                    <td>০৯।</td>
                    <td colspan="2">ভর্তি ফি বাবদ (অফেরতযোগ্য) নগদ {{ $employees->bn_traning_cost }} টাকা দিয়ে বাকি</td>
                    <td><input readonly type="text" class="tinput" value=""></td>
                    <td>টাকা রেখে স্বাক্ষর করলাম</td>
                </tr>
                <tr>
                    <td>১০।</td>
                    <td>প্রার্থীর স্বাক্ষরঃ</td>
                    <td colspan="3"><input readonly type="text" class="tinput" value=""></td>
                </tr>
                <tr>
                    <td>১১।</td>
                    <td>সনাক্তকারী/কাগজপত্র গ্রহনকারী/টাকা গ্রহনকারী/নাম ও স্বাক্ষরঃ</td>
                    <td  colspan="3"><input readonly type="text" class="tinput" value=""></td>
                </tr>
                <tr>
                    <td>১২।</td>
                    <td>স্বাক্ষরঃ-</td>
                    <td> <span>ভর্তিকারী/জোন কমান্ডার</span></td>
                    <td></td>
                    <td>ডিজিএম/জিএম</td>
                </tr>
                <tr>
                    <td>১৩।</td>
                    <td><h4 class="mb-0">‍শপথ বাক্য পাঠঃ-</h4></td>
                    <td>আমি(নাম)</td>
                    <td><input readonly type="text" class="tinput" value="{{ $employees->bn_applicants_name }}"></td>
                    <td>{{ $employees->position?->name_bn }} হিসেবে মহান সৃষ্টিকর্তার
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
                    <td>১৪।</td>
                    <td>মান যাচাইকারী এবং শপথ পরিচালনাকারীর নাম ও স্বাক্ষর</td>
                    <td  colspan="3"><input readonly type="text" class="tinput" value=""></td>
                </tr>
                <tr>
                    <td>১৫।</td>
                    <td colspan="4">প্রশিক্ষনের কালঃ  ------------  হইতে  ------------------  মোট =  ------- দিন</td>
                </tr>
                <tr>
                    <td class="text-start" colspan="5">
                        <p style="margin: 1px; margin-top: 10px !important;"><h5 class="text-center"><span style="border-bottom: solid 2px;">জোন কমান্ডারের মন্তব্যঃ</span></h5></p>
                    </td>
                </tr>
                <tr>
                    <td>১৬।</td>
                    <td colspan="2">উক্ত গার্ডটি নতুন পোষ্টের জন্য ভর্তি করা হলে পোষ্টের নাম লিখুনঃ</td>
                    <td colspan="2"><input readonly type="text" class="tinput" value=""></td>
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
                        <p style="margin: 1px; margin-top: 10px !important; margin-bottom: 10px !important;"><b style="border-top: solid 2px;">জেনারেল কমান্ডারের স্বাক্ষর</b></p>
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
                    <td class="text-end"><p style="margin: 1px; margin-top: 50px !important;"><b style="border-top: solid 2px;">স্টোরম্যানের সীল/স্বাক্ষর</b></p></td>
                </tr>
                <tr>
                    <td>২০।</td>
                    <td>ভর্তি ফি বাবদ নগদ </td>
                    <td><input readonly type="text" class="tinput" value=""></td>
                    <td colspan="2">টাকা সদস্য সচিব থেকে বুঝে গ্রহন করলাম ।</td>
                </tr>
                <tr>
                    <td>তারিখঃ</td>
                    <td><input readonly type="text" class="tinput" value=""></td>
                    <td></td>
                    <td></td>
                    <td class="text-end"><p style="margin: 1px; margin-top: 50px !important;"><b style="border-top: solid 2px;">হিসাব শাখার প্রধান</b></p></td>
                </tr>
            </tbody>
        </table>
    </section>

</section>
<section class="mt-5">
    <div class="row imggl">
        <p>সকল ডকুমেন্ট</p>
        @forelse($employeeDocuments as $ed)
        <div class="col-5 col-sm-3 mb-3 text-center del{{$ed->id}}">
            <input readonly class="form-control mb-1" value="{{$ed->document_caption}}" type="text" name="document_caption[]" placeholder="Document Caption"/>
            <a target="_blank" href="{{asset('uploads/document_img/'.$ed->document_img)}}"><i class="bi bi-eye"></i></a>
        </div>
        @empty
        @endforelse
    </div>
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
