{{--  @extends('layout.app')
@section('content')  --}}
<div>
    <a href="#" class="btn no-print" onclick="history.back()"> Go To Back</a>
    <button type="button" class="btn btn-info no-print" onclick="printDiv('result_show')">Print</button>
</div>
<!DOCTYPE html>
<html lang="en" id="result_show">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//db.onlinewebfonts.com/c/1d48b2cf83cd3bb825583f7eefd80149?family=AdmiralScriptW01-Regular" rel="stylesheet" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
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
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
        }
        input:focus {
            border-color: green;
            font-family: Montserrat !important;
        }


        .gfg {
            border-collapse:separate;
            border-spacing:0 25px;
        }
        .gfg2 {
            border-collapse:separate;
            border-spacing:0 25px;
            }

        .gfg3 {
            border-collapse:separate;
            border-spacing:0 30px;
        }

        .gfg4 {
            border-collapse:separate;
            border-spacing:0 10px;
        }
        .gfg5 {
            border-collapse:separate;
            border-spacing:0 40px;
        }
        .dtable,td, th{

            border-collapse: collapse;
        }

        .photo{

            margin: auto;
            padding-top: 1.3rem;


        }
        .pdiv{
            position: relative;
            background-color: rgb(240, 235, 235) !important;
            padding: 10px;
        }
        .pdiv p{
            font-family: 'Times New Roman', Times, serif !important;
        }
        .pbox{
            width: 120px;
            height: 114px;
            /* border-style: solid;
            border-radius: 1rem;
            border-width: 2px;
            border-color: #3939b3; */
            text-align: center;
            position: absolute;
            bottom: 9px;
            right: 150px;
            background-color: rgb(248, 239, 239);
            padding-bottom: 6px;
            padding-top: 26px;
        }
        .font{
            font-family: AdmiralScriptW01-Regular;
        }


        /* .section-heading{
            font-family: Montserrat !important;
        } */
        body{
            {{--  background-color: rgb(252, 245, 245);  --}}
            font-family: Montserrat !important;
        }
        .binput {
            width: 100%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;

        }
        .sinput {
            width: 100%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
        }
        .finput {
            width: 30%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
        }
        .bottominput {
            width: 80%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
        }
        .bottom2input {
            width: 32%;
            outline: 0;
            border-style: dashed;
            border-width: 0 0 1px;
            border-color: blue;
            background-color: transparent;
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

    <div class="bg1"  style="width:800px; margin:0 auto;">
        <div style="text-align: center;">
            {{--  <img src="{{ asset('assets/billcopy/logo.png') }}" width="88%" height= auto; alt="">  --}}
        </div>
        <div style="margin-bottom: 1.5rem;">
            <h1 style="text-align: center; margin-top:0;">Customer's All Information</h1>
        </div>

        <div class="pdiv">
            <div class="tbl1">
                <p style="margin: 0px; font-weight:bold;"><em>এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</em></p>
                <p style="margin: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <p style="margin: 0px; font-weight:bold;"><em>House #2, Lane #2, Road #2, Block-K,</em></p>
                <p style="margin: 0px; font-weight:bold;"><em>Halishahar Housing Estate, Chattogram-4224</em></p>
                <p style="margin: 0px; font-weight:bold;"><em>Tel: 02333323387, 02333328707</em></p>
                <p style="margin: 0px; font-weight:bold;"><em>Mobile: 01844-040714, 01844-040717</em></p>
                <p style="margin: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <p style="margin: 0px; font-weight:bold;"><em>Email: ctg@elitebd.com</em></p>
            </div>
            <div class="pbox">
                <td><img src="{{ asset('assets/billcopy/logo.png') }}" width="210px" height="110px" alt=""></td>
            </div>
        </div>
        <form action="">
            <table class = "gfg" style="width:100%">
                <tbody >
                    <tr>
                        <td style="text-align: left;">Customer's Name:</td>
                        <td colspan="3"><input type="text" class="tinput"  value="{{ $customer->name }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Contact Number:</th>
                        <td colspan="3"><input type="text" class="tinput"  value="{{ $customer->contact }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Address:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $customer->address }}"></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <h4 class="section-heading" style="margin-top: 2rem; margin-bottom: 0;"><b>Branch INFORMATION</b></h4>
            </div>
        </form>
        @if ($customer->branch)
        @foreach ($customer->branch as $br)
        <form action="">
            <div style="text-align: center;">
                <h4 class="section-heading">Branch: <b style="color: red;">{{ $br->brance_name }}</b></h4>
            </div>
            <table class = "gfg" style="width:100%">
                <tbody >
                    <tr>
                        <td style="text-align: left;">Contact Person Name:</th>
                        <td colspan="3"><input type="text" class="tinput"  value="{{ $br->contact_person }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Contact Mobile No:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->contact_number }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Billing Person Name:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->billing_person }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Vat(%):</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->vat }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Take Home:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->take_home }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Royalty:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->royal_tea }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">AIT:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->ait }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Received By Ctg:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $br->received_by_city }}"></td>
                    </tr>
                    @if ($br->atms)
                    @foreach ($br->atms as $at)
                    <tr>
                        <td style="text-align: left;">ATM:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ $at->atm }}"></td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td style="text-align: left;">Agreement Date:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ \Carbon\Carbon::parse($br->agreement_date)->format('d F Y') }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Renew Date:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ \Carbon\Carbon::parse($br->renew_date)->format('d F Y') }}"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Validity Date:</td>
                        <td colspan="3"><input type="text" class="tinput" value="{{ \Carbon\Carbon::parse($br->validity_date)->format('d F Y') }}"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        @endforeach
        @endif
        <div>
            <h4 class="" style="margin-bottom: 0;"><b>Rate</b></h4>
        </div>
        @if ($customer->customerRate)
        @foreach ($customer->customerRate as $rate)
        <form action="">
            <table class = "gfg2" style=" width:100%">
                <tr>
                    <td style="text-align: left;">Job Post :</td>
                    <td ><input type="text" class="tinput" value="{{ $rate->jobpost?->name }}"></td>
                    <td style="text-align: left; padding-left:5px;">Rate:</td>
                    <td ><input type="text" class="tinput" value="{{ $rate->rate }}"></td>
                </tr>
            </table>
        </form>
        @endforeach
        @endif
    </div>
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

</body>
</html>
{{--  @endsection  --}}
