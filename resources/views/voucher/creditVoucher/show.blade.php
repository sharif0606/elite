<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE FORCE | @yield('siteTitle', 'VOUCHER')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
    <link href="https://fonts.maateen.me/adorsho-lipi/font.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
        .tinput {
            width: 100%;
            outline: 0;
            border-style: solid;
            border-width: 1px 0 0;
            border-color: #4F709C;
            background-color: transparent;
        }
        .sinput {
            width: 60%;
            outline: 0;
            border-style: dotted;
            border-width: 0 0 1px;
            border-color: #4F709C;
            background-color: transparent;
        }
        input:focus {
            border-color: #4F709C;
            font-family: Montserrat !important;
        }


        
        .tbl_table{
            border: solid 1px;
            border-color: #000;
            border-collapse: collapse;
        }
        .tbl_mini_table{
            border: solid 1px;
            border-collapse: collapse;
            text-align: center;
            font-size: 9px;
        }
        .tbl_table_border_right{
            border-right: solid 1px;
            border-color: #000;
            border-collapse: collapse;
        }
        body{
            font-family: 'AdorshoLipi', sans-serif;
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
<body >
    
    <div>
        <a href="{{route('dashboard', ['role' =>currentUser()])}}" class="btn no-print"> Go To Dashboard</a>
        <button class="no-print btn" type="button" onclick="window.print()" style="float:right"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
              </svg>
            Print
        </button>
    </div>
    <div class="bg1"  style="width:1000px; margin:0 auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left; width: 20%;"><img src="{{ asset('assets/images/logo/logo.png')}}" width="200px;" height="auto" alt=""></th>
                    <th style="text-align: center; width: 60%;">
                        <h3 style="margin: 0px 0px 0px 0px">খরচ/ব্যয় পরিশোধের বিল ভাউচার</h3>
                        <h3 style="margin: 0px 0px 6px 0px">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড, চট্টগ্রাম</h3>
                    </th>
                    <th style="width: 20%;"></th>
                </tr>
            </thead>
        </table>
        <table style="width: 100%; margin-bottom: .5rem;">
            <thead>
                <tr>
                    <th style="text-align: left; width: 10%;">নামঃ </th>
                    <td style="text-align: left; width: 35%;">{{$creditVoucher->pay_name}}</td>
                    <th style="text-align: left; width: 25%;">পদবীঃ <input type="text" class="sinput"></th>
                    <th style="width: 10%;">তারিখঃ</th>
                    <td style="width: 20%;"><span style="border-bottom: dashed 1px;">
                        @if ($creditVoucher->current_date != '')
                            {{ date('d-M-Y', strtotime($creditVoucher->current_date)) }}
                        @else
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="text-align: left;">Purpose:</th>
                    <td colspan="2" style="text-align: left;">{{$creditVoucher->purpose}}</td>
                    <th >Account:</th>
                    <td style="text-align: left;">
                        @if($crevoucherbkdn)
                            @foreach($crevoucherbkdn as $bk)
                                @if($bk->particulars=="Received from")
                                    {{$bk->account_code}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                </tr>
            </thead>
        </table>
        <div style="height: 550px;">
            <table class="tbl_table" style="width: 100%;">
                @php
                    $totalAmount = 0;
                @endphp
                <thead>
                    <tr class="tbl_table" style="text-align: center;">
                        <th class="tbl_table" style="width: 13%;">ক্রমিক নং</th>
                        <th class="tbl_table" style="width: 60%;">খরচের বিবরণ</th>
                        <th class="tbl_table" style="width: 20%;">টাকার অংক</th>
                        <th class="tbl_table" style="width: 7%;">পঃ</th>
                    </tr>
                </thead>
                <tbody style="height: 300px;">
                    @foreach ($crevoucherbkdn as $bk)
                    @if ($bk->credit != 0)
                        <tr style="vertical-align: top; height: 0;">
                            <th class="tbl_table_border_right" style="text-align: center; padding-left: 5px;">{{ +$loop->index }}</th>
                            <th class="tbl_table_border_right" style="text-align: left;">{{$bk->account_code}}</th>
                            <th class="tbl_table_border_right" style="text-align: right;">{{money_format($bk->credit)}}</th>
                            <th class="tbl_table_border_right" style="text-align: right;"></th>
                        </tr>
                        @php
                            $totalAmount =+ $bk->credit;
                        @endphp
                    @endif
                    @endforeach
                    {{-- this tr needed for vertical alignment --}}
                    <tr>
                        <th class="tbl_table_border_right" style="text-align: left; padding-left: 5px;"></th>
                        <th class="tbl_table_border_right" style="text-align: left;"></th>
                        <th class="tbl_table_border_right" style="text-align: right;"></th>
                        <th class="tbl_table_border_right" style="text-align: right;"></th>
                    </tr>
                    {{-- this tr needed for vertical alignment --}}
                </tbody>
                <tfoot>
                    <th class="tbl_table tbl_table_border_right" style="padding-left: 5px;"></th>
                    <th class="tbl_table tbl_table_border_right" style="text-align: right; padding-right:5px;">মোট টাকা=</th>
                    <th class="tbl_table tbl_table_border_right" style="text-align: right;">{{money_format($totalAmount)}}/-</th>
                    <th class="tbl_table tbl_table_border_right"></th>
                </tfoot>
            </table>
            <div style="margin-top: 10px;">
                <span style="width:13%;"><b>কথায়:</b></span>
                <span style="width:87%; border-bottom: dashed 1px;">
                    @if ($totalAmount != 0)
                        @php
                            if ($totalAmount > 0) {
                                $textValue = getBangladeshCurrency($totalAmount);
                                echo "$textValue";
                            } else {
                                echo "Zero";
                            }
                        @endphp
                    @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                </span>
            </div>
            <div style="margin-top: 2.6rem; display: flex;">
                <div style="width:50%;">
                    <span style="border-top: solid 1px;"><b>খরোচকরীর স্বাক্ষর</b></span>
                </div>
                <div style="width:50%; text-align:right;">
                    <span style="border-top: solid 1px;"><b>অনুমোদনকারী স্বাক্ষর</b></span>
                </div>
            </div>
            <div style="margin-top: 2.3rem; display: flex;">
                <div style="width:50%;">
                    <span style="border-top: solid 1px;"><b>গ্রহণকারীর স্বাক্ষর</b></span>
                </div>
                <div style="width:50%; text-align:right;">
                    <span style="border-top: solid 1px;"><b>পরিশোধকারীর স্বাক্ষর</b></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>