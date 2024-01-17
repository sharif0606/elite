@extends('layout.app')
@section('content')
{{--  <div>
    <a href="#" class="btn btn-info no-print"> Go To Dashboard</a>
    <button type="button" class="btn btn-info no-print" onclick="printDiv('result_show')">Print</button>
</div>  --}}
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
                    {{--  <img  class="mt-5" height="80px" width="140px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">  --}}
                </div>
                <div class="col-6 col-sm-6" style="padding-left: 10px;">
                    <div style="text-align: center;">
                        <h5 style="padding-top: 5px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                        <p class="text-center m-0 p-0">ভর্তি ফরম:সকল অস্থায়ী পদের জন্য</p>
                        <p class="text-center m-0 p-0">বাড়ি নং-২,লেইন নং-২,রোড নং-২,ব্লক-''কে''</p>
                        <p class="text-center m-0 p-0">হালিশহর হাউজিং এষ্টেট,চট্টগ্রাম-৪২২৪</p>
                    </div>
                </div>
                <div class="col-3" style="padding-left: 10px;">
                    {{--  <img height="150px" width="150px"  src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">  --}}
                </div>
            </div>
            <div class="row">
                <div class="col-1">Cliant Name</div>
                <div class="col-2"><input type="text" class="tinput"  value="{{ $empasin->customer?->name }}"></div>
                <div class="col-1">Branch</div>
                <div class="col-2"><input type="text" class="tinput"  value="{{ $empasin->branch?->brance_name }}"></div>
                {{--  <div class="col-1">Atm</div>  --}}
                {{--  <div class="col-2"><input type="text" class="tinput"  value="{{ $empasin->atms?->atm }}"></div>  --}}
            </div>
            <div class="row">
                <div class="col-1">Address</div>
                <div class="col-2"><input type="text" class="tinput"  value="{{ $empasin->customer?->address }}"></div>
            </div>
            <div class="row p-3">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th >SL No</th>
                            <th>Job Post</th>
                            <th>QTY</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Rate</th>
                            <th>{{__('Hours')}}</th>
                            <th>Total Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($empasin->details)
                        @foreach ($empasin->details as $de)
                        <tr class="text-center">
                            <td >{{ ++$loop->index  }}</td>
                            <td>{{ $de->jobpost?->name }}
                                @if($de->atms?->atm)
                                    (ATM:{{ $de->atms?->atm }})
                                @endif
                                </td>
                            <td>{{ $de->qty }}</td>
                            <td>{{ \Carbon\Carbon::parse($de->start_date)->format('d F Y') }}</td>
                            <td>{{ $de->end_date }}</td>
                            <td>{{ $de->rate }}</td>
                            <td>@if($de->hours==1) 8 Hour's @else 12 Hour's @endif</td>
                            <td>{{ $de->qty*$de->rate }}</td>
                        </tr>
                        @endforeach
                        @endif
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
