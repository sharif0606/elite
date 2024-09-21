@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}">
<div class="container">
    <ul class="nav nav-pills mt-3 mb-5" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link step-1-tab active" id="step-1-tab" data-toggle="pill" href="#step-1" role="tab" aria-controls="step-1" aria-selected="true"><span>ছাড়পত্র</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link step-2-tab" id="step-2-tab" data-toggle="pill" href="#step-2" role="tab" aria-controls="step-2" aria-selected="false"><span>হিসাবের বিবরণ</span></a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="step-1" role="tabpanel" aria-labelledby="step-1-tab">
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16"><g fill="currentColor"><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/><path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z"/></g></svg></a>           
            </div>
            <style>

                .tbl_border{
                border: 1px solid rgb(46, 46, 46);
                border-collapse: collapse;
                }
            </style>
            <div id="result_show">
                
                <div class="row p-3">
                    <div class="col-3">
                        <img class="mt-2" height="65px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
                    </div>
                    <div class="col-8">
                        <div style="text-align: center;">
                            <h5 style="padding-top: 5px;">ছাড়পত্র</h5>
                            <h5 style="padding-top: 5px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                            <p class="text-center m-0 p-0">বাড়ি নং-২, লেইন নং-২, রোড নং-২ ব্লক-কে হালিশহর হাউজিং এস্টেড চট্টগ্রাম-৪২২৪</p>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <p>১। আইডি নং <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->employee?->admission_id_no}}</span> পদবী <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->employee?->position?->name_bn}}</span> নামঃ <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->employee?->bn_applicants_name}}</span> ভর্তির তারিখঃ <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->employee?->joining_date}}</span> পোস্টের নামঃ <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->employee?->position?->name_bn}}</span> অব্যহতির কারণ ব্যক্তিগত অনুরোধে এবং স্বইচ্ছায়/পারিবারিক সমস্যা/ শৃঙ্খলাজনিত কারণে/অসুস্থতা/বার্ধক্যজনিত/বিদেশগমন/অযোগ্যতার কারণে <span style="border-bottom: 2px dashed; font-weight:bold;">{{$emRel->resign_date}}</span> ইং তারিখঅব্যহতি দেয়া হইলো। তার নিন্ম বর্ণিত পোশাকগুলো অফিসে জমা করা হইলো:-</p>
                    </div>
                </div>
                <div class="row px-4">
                    <table class="tbl_border" style="width:100%">
                        <tr class="text-center tbl_border">
                            <th class="tbl_border" rowspan="2">ক্রমিক নং</th>
                            <th class="tbl_border" rowspan="2" width="25%">পোষাকের নাম</th>
                            <th class="tbl_border" rowspan="2">ইস্যু সংখ্যা</th>
                            <th class="tbl_border" rowspan="2">জমার সংখ্যা</th>
                            <th class="tbl_border" colspan="2">জমা না করার সংখ্যা ও উহার মূল্য</th>
                            <th class="tbl_border" rowspan="2" width="25%">মন্তব্য</th>
                        </tr>
                        <tr class="text-center tbl_border">
                            <th class="tbl_border">সংখ্যা</th>
                            <th class="tbl_border">টাকা</th>
                        </tr>
                        @foreach ($relDetail as $d)
                            <tr class="text-center tbl_border">
                                <td class="tbl_border">{{++$loop->index}}</td>
                                <td class="text-start tbl_border">{{$d->product?->product_name}}</td>
                                <td class="tbl_border">{{abs($d->issue_qty)}}</td>
                                <td class="tbl_border">{{$d->receive_qty}}</td>
                                <td class="tbl_border">{{$d->not_receive_qty}}</td>
                                <td class="tbl_border">{{$d->not_receive_qty_amount}}</td>
                                <td class="tbl_border">{{$d->comment}}</td>
                            </tr>
                        @endforeach
                        <tr class="text-center tbl_border">
                            <td class="tbl_border"></td>
                            <td class="text-start tbl_border">{{$emRel->wash_cost}}</td>
                            <td class="tbl_border"></td>
                            <td class="tbl_border"></td>
                            <td class="tbl_border"></td>
                            <td class="tbl_border">{{$emRel->wash_cost_amount}}</td>
                            <td class="tbl_border"></td>
                        </tr>
                        <tr class="tbl_border">
                            <th colspan="5" class="text-end tbl_border">মোট কর্তনকৃত টাকা=</th>
                            <td class="tbl_border text-center">{{$emRel->amount_deducted}}</td>
                        </tr>
                    </table>
                    <div><p class="p-0 m-0">{{$emRel->others_note}}</p></div>
                </div>
                <div class="row p-3 ">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <span style="border-top: 2px solid;">জমাকারীর স্বাক্ষর</span><br>
                            <span>জমাকারীর মোবাইল নং <b>{{$emRel->issue_submiter_mobile}}</b></span>
                        </div>
                        <div class="">
                            <span style="border-top: 2px solid">জমাগ্রহণকারীর স্বাক্ষর</span><br>
                            <span>ষ্টোর শাখা</span>
                        </div>
                    </div>
                </div>
                <div class="row px-4">
                    <p class="p-0 m-0">২। নিন্মেবর্ণিত ব্যক্তিবর্গ থেকে ছাড়পত্র নিতে হবে।</p>
                    <table class="tbl_border" style="width:100%">
                        <tr class="text-center tbl_border">
                            <th class="tbl_border" width="10%">ক্রমিক নং</th>
                            <th class="tbl_border"></th>
                            <th class="tbl_border" width="40%">মন্তব্য</th>
                            <th class="tbl_border">স্বাক্ষর</th>
                        </tr>
                        <tr class="text-center tbl_border">
                            <td class="tbl_border">ক।</td>
                            <td class="text-start tbl_border">গ্রাহক কর্তৃপক্ষ</td>
                            <td class="text-start tbl_border">{{$emRel->cus_authority_comment}}</td>
                            <td class="tbl_border"></td>
                        </tr>
                        <tr class="text-center tbl_border">
                            <td class="tbl_border">খ।</td>
                            <td class="text-start tbl_border">জোন কমান্ডার</td>
                            <td class="text-start tbl_border">{{$emRel->zone_commander_comment}}</td>
                            <td class="tbl_border"></td>
                        </tr>
                    </table>
                </div>
                <div class="row p-3 mt-5">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <span style="border-top: 2px solid;">সপারিশকারী</span>
                        </div>
                        <div class="">
                            <span style="border-top: 2px solid">অনুমোদনকারী</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="tab-pane fade" id="step-2" role="tabpanel" aria-labelledby="step-2-tab">
            <style>
                .tbl_two_border {
                    border: 1px solid rgb(46, 46, 46);
                    border-collapse: collapse;
                    padding: 8px; /* Add padding inside th and td */
                }
            </style>
            <div class="text-center m-2">
                <a href="#" class="no_print" title="print" onclick="printDivemp('result_show_two')"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16"><g fill="currentColor"><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/><path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.701 19.701 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.187-.012.395-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95a11.642 11.642 0 0 0-1.997.406a11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193a11.666 11.666 0 0 1-.51-.858a20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z"/></g></svg></a>           
            </div>
            <div id="result_show_two">
                <div class="row p-3">
                    <div class="text-center">
                        <h5 class="mb-2">হিসাবের বিবরণ</h5>
                    </div>
                    <table class="tbl_two_border" style="width:100%">
                        <tr class="text-center tbl_two_border">
                            <th>ক্রমিক নং</th>
                            <th class="tbl_two_border" width="63%">বিবরণ</th>
                            <th class="tbl_two_border" width="12%">টাকা</th>
                            <th class="tbl_two_border" width="15%">মন্তব্য</th>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border">১।</td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->due_salary != '')
                                    {{$emRel->due_salary}}
                                @else
                                    বকেয়া বেতন
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->due_salary_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->due_salary_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border">২।</td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->pf_a != '')
                                    {{$emRel->pf_a}}
                                @else
                                    (ক) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১০  ইং পর্যন্ত) মাসিক ৫০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->pf_a_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->pf_a_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border"></td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->pf_b != '')
                                    {{$emRel->pf_b}}
                                @else
                                    (খ) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১৭ ইং পর্যন্ত) মাসিক ১০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->pf_b_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->pf_b_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border"></td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->pf_c != '')
                                    {{$emRel->pf_c}}
                                @else
                                    (গ) প্রভিডেন্ট ফান্ড (জানুয়ারী -২০১৮ ইং থেকে চলিত) মাসিক ২০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->pf_c_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->pf_c_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border">৩।</td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->leave != '')
                                    {{$emRel->leave}}
                                @else
                                    ছুটির টাকা (কমপক্ষে ৬ মাস চাকুরী করলে)
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->leave_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->leave_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border">৪।</td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->addmission != '')
                                    {{$emRel->addmission}}
                                @else
                                    ভর্তির নগদ জামানত বাবদ ১০০০/- ফেরত যোগ্য যদি ৩০/০৬/২০০৯ তারিখের পূর্বে ভর্তি হয়ে থাকে।  তার পরের ভর্তির ফি বাবদ অফেরতযোগ্য  (চুক্তি মোতাবেক)
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->addmission_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->addmission_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border">৫।</td>
                            <td class="text-left tbl_two_border">
                                @if($emRel->others != '')
                                    {{$emRel->others}}
                                @else
                                    অন্যান্য
                                @endif
                            </td>
                            <td class="tbl_two_border text-end">{{$emRel->others_amount}}</td>
                            <td class="tbl_two_border">{{$emRel->others_comment}}</td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border"></td>
                            <td class="tbl_two_border">মোট হিসাব =</td>
                            <td class="tbl_two_border text-end">{{$emRel->subtotal}}</td>
                            <td class="tbl_two_border"></td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border"></td>
                            <td class="tbl_two_border">কর্তনকৃত টাকা =</td>
                            <td class="tbl_two_border text-end">{{$emRel->final_deducted}}</td>
                            <td class="tbl_two_border"></td>
                        </tr>
                        <tr class="tbl_two_border">
                            <td class="text-center tbl_two_border"></td>
                            <td class="tbl_two_border">চূড়ান্ত পাওনা =</td>
                            <td class="tbl_two_border text-end">{{$emRel->final_total}}</td>
                            <td class="tbl_two_border"></td>
                        </tr>
                    </table>
                    <p class="p-0 mx-0 mt-2">চাকুরী থেকে অব্যহতি পাওয়ার পর, উল্লেখিত কর্তনকৃত অংকের টাকা বাদ দিয়ে আমার চূড়ান্ত হিসাবের সমূদয় পাওনা সজ্ঞানে বুঝে গ্রহণ করে স্বাক্ষর করলাম এবং পরবর্তীতে আমার কোনো দাবী থাকলো না।</p>
                </div>
                <div class="row p-3 mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <span>তারিখঃ</span>
                        </div>
                        <div class="">
                            <span >স্বাক্ষর (অব্যহতিকারীর)</span><span style="border-bottom: 2px dashed;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="row p-3 mt-5">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <span style="border-top: 2px solid;">গ্রহণকারীর/জোন কমান্ডার</span>
                        </div>
                        <div class="">
                            <span style="border-top: 2px solid">অডিটর/প্রদানকারী</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('.nav-item a').click(function(e) {
    var currentTab = $(this).attr('href');
    var prevTab = $('.tab-content .tab-pane.show').attr('id');
    
    $('#' + prevTab).removeClass('show active');
    $('#' + prevTab + '-tab').removeClass('active');
    $(currentTab).addClass('show active');
    $(currentTab + '-tab').addClass('active');
    e.preventDefault();
  });

function printDivemp(divName) {
    var prtContent = document.getElementById(divName);
    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
    WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}" type="text/css"/>');
    WinPrint.document.write('<style> table tr td,table tr th{font-size:13px !important;} .tbl_two_border{border: 1px solid rgb(46, 46, 46); border-collapse: collapse; padding: 8px;} </style>');
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
