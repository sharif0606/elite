<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE FORCE | @yield('siteTitle', 'Certificate')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
    <link href="https://fonts.maateen.me/adorsho-lipi/font.css" rel="stylesheet">
    <style>
        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
        body {
            font-family: 'AdorshoLipi', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* background-color: #f0f0f0; */
        }
        .certificate-container {
            position: relative;
            width: 975px;
            height: auto;
            background: url("{{ asset('assets/billcopy/certificateborder.png')}}") no-repeat center center;
            background-size: cover;
            padding: 50px;
            box-sizing: border-box;
        }
        .bg-jolchap {
            background: url("{{ asset('assets/billcopy/jolchap.png') }}") repeat;
            background-size: 25% calc(100%); /* Adjust the height to divide into 4 parts */
            background-repeat: repeat-x; /* Repeat vertically */
            height: 100%; /* Make sure the container is full height */
            opacity: 80%;
        }
        
        .certificate-content {
            position: relative;
            text-align: center;
            /* padding: 20px; */
            border-radius: 10px;
        }
        .sinput, .ssinput {
            outline: 0;
            border-style: dotted;
            border-width: 0 0 1px;
            border-color: #000;
            background-color: transparent;
        }
        .sinput {
            width: 17%;
        }
        .ssinput {
            width: 8%;
        }
        th {
            padding-top: 15px;
        }
        table {
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 5px;
        }
        .certificate-content h1, .certificate-content h2 {
            margin: 0;
        }
        .certificate-content h1 {
            font-weight: bolder;
        }
        .certificate-content h2 {
            font-weight: bolder;
            margin-bottom: 20px;
        }
        .btn {
    --bs-btn-padding-x: 0.75rem;
    --bs-btn-padding-y: 0.375rem;
    --bs-btn-font-family: ;
    --bs-btn-font-size: 1rem;
    --bs-btn-font-weight: 400;
    --bs-btn-line-height: 1.5;
    --bs-btn-color: #607080;
    --bs-btn-bg: transparent;
    --bs-btn-border-width: 1px;
    --bs-btn-border-color: transparent;
    --bs-btn-border-radius: 0.25rem;
    --bs-btn-box-shadow: inset 0 1px 0 hsla(0,0%,100%,.15),0 1px 1px rgba(0,0,0,.075);
    --bs-btn-disabled-opacity: 0.65;
    --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb),.5);
    background-color: var(--bs-btn-bg);
    border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
    border-radius: var(--bs-btn-border-radius);
    color: var(--bs-btn-color);
    cursor: pointer;
    display: inline-block;
    font-family: var(--bs-btn-font-family);
    font-size: var(--bs-btn-font-size);
    font-weight: var(--bs-btn-font-weight);
    line-height: var(--bs-btn-line-height);
    padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
    text-align: center;
    text-decoration: none;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    vertical-align: middle;
    --bs-btn-color: #fff;
    --bs-btn-bg: #435ebe;
    --bs-btn-border-color: #435ebe;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #3950a2;
    --bs-btn-hover-border-color: #364b98;
    --bs-btn-focus-shadow-rgb: 95,118,200;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #364b98;
    --bs-btn-active-border-color: #32478f;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0,0,0,.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #435ebe;
    --bs-btn-disabled-border-color: #435ebe;
}
    </style>
</head>
<body>
    <div style="position:absolute; right:1rem; top: 1rem;">
        <button class="no-print btn" type="button" onclick="window.print()" > 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2h3a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1h3a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
              </svg>
            Print
        </button>
        <a class="no-print" href="{{ route('employee.additionalFile') }}" target="_blank">
            <button class="btn btn-sm">file</button>
        </a>
    </div>
    <div class="certificate-container">
        <div class="certificate-content">
            <h1 style="margin-top: .5rem;">এলিট সিকিউরিটি সার্ভিসেস লিঃ</h1>
            <img src="{{ asset('assets/billcopy/logo.png') }}" height="100px;" alt="">
            <h2>নিরাপত্তা প্রশিক্ষণ সনদ পত্র</h2>
            <div style="width: 90%; margin: auto;">
                <table class="bg-jolchap" style="width:100%;">
                    <tr>
                        <th style="text-align: left; width: 15%;">আইডি নং :</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->admission_id_no}}</td>
                        <th style="text-align: center; width: 15%; ">পদবীঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->position?->name_bn}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; width: 15%;">নামঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_applicants_name}}</td>
                        <th style="text-align: center; width: 15%;">পিতাঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_fathers_name}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; width: 15%;">গ্রামঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_parm_village_name}}</td>
                        <th style="text-align: center; width: 15%;">পোস্টঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_parm_post_ofc}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; width: 15%;">থানা/উপজেলাঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_parm_upazilla?->name_bn}}</td>
                        <th style="text-align: center; width: 15%;">জেলাঃ</th>
                        <td style="text-align: center; border-bottom: dotted 1px; width: 35%;">{{$emp->bn_parm_district?->name_bn}}</td>
                    </tr>
                </table>
                <div style="width: 95%; text-align: center; margin: auto;">
                    <p style="line-height: 1.9; font-size: 14px;">
                        গত <input type="text" class="sinput" value=""> ইং তারিখে এলিট লিঃ এ  সার্ভিসেস যোগদান করেছেন। তাহার শিক্ষাগত যোগ্যতা <input type="text" class="sinput"> শ্রেণী পাস এবং তিনি অপর পৃষ্ঠায় বর্ণিত বিষয়ে কোম্পানীর ট্রেনিং একাডেমি থেকে <input type="text" class="ssinput"> দিন এর প্রশিক্ষণ কোর্স<br>(<input type="text" class="sinput"> ইং হতে <input type="text" class="sinput">) ইং পর্যন্ত সাফল্যের সাথে সম্পন্ন করেছেন।
                    </p>
                    {{-- <p style="line-height: 1.9; font-size: 14px;">
                        গত <input type="text" class="sinput" value="{{ !is_null($emp->joining_date) ? date('d-M-Y', strtotime($emp->joining_date)) : '' }}"> ইং তারিখে এলিট লিঃ এ  সার্ভিসেস যোগদান করেছেন। তাহার শিক্ষাগত যোগ্যতা <input type="text" class="sinput"> শ্রেণী পাস এবং তিনি অপর পৃষ্ঠায় বর্ণিত বিষয়ে কোম্পানীর ট্রেনিং একাডেমি থেকে <input type="text" class="ssinput"> দিন এর প্রশিক্ষণ কোর্স(<input type="text" class="sinput"> ইং হতে <input type="text" class="sinput">) ইং পর্যন্ত সাফল্যের সাথে সম্পন্ন করেছেন।
                    </p> --}}
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 2rem; margin-bottom: .9rem;">
                    <div>
                        <span style="border-top: dotted 1px;">প্রধান প্রশিক্ষক</span>
                    </div>
                    <div>
                        <span style="border-top: dotted 1px;">ব্যবস্থাপনা পরিচালক</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>