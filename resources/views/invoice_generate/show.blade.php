@extends('layout.app')
@section('content')
{{--  <div>
    <a href="#" class="btn btn-info no-print"> Go To Dashboard</a>
    <button type="button" class="btn btn-info no-print" onclick="printDiv('result_show')">Print</button>
</div>  --}}
<section id="result_show">
    <section>
        <div class="container">
            <div class="row p-3">
                <div class="col-3">
                    {{--  <img  class="mt-5" height="80px" width="140px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">  --}}
                </div>
                <div class="col-6 col-sm-6" style="padding-left: 10px;">
                    <div style="text-align: center;">
                        <h5 style="padding-top: 5px;">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                        <p class="text-center m-0 p-0">বাড়ি নং-২,লেইন নং-২,রোড নং-২,ব্লক-''কে''</p>
                        <p class="text-center m-0 p-0">হালিশহর হাউজিং এষ্টেট,চট্টগ্রাম-৪২২৪</p>
                    </div>
                </div>
                <div class="col-3" style="padding-left: 10px;">
                    {{--  <img height="150px" width="150px"  src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="কোন ছবি পাওয়া যায় নি">  --}}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <input type="checkbox" class="check_header" id="check_header" name="check_header" value="1">
                    <label for="check_header"> show Header part check</label>
                </div>
            </div>
            <div class="row">
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow1',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_1.png')}}" alt="No Image Found">
                    </a>
                </div>
                {{--  <div id="imageContainer" class="col-4 text-center mb-2">
                    <a id="invoiceLink" onclick="goSingleShow();" class="invoiceLink" href="#">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_1.png') }}" alt="No Image Found">
                    </a>
                </div>  --}}
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow2',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_2.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow3',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_3.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow4',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_4.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow5',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_5.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow6',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/Screenshot_6.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow7',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/wasa1.png')}}" alt="No Image Found">
                    </a>
                </div>
                <div class="col-4 text-center mb-2">
                    <a href="{{route('invoiceShow8',[encryptor('encrypt',$invoice_id->id),'header' =>'0'])}}" class="invoiceshow">
                        <img class="img-thumbnail" height="300px" width="350px" src="{{ asset('assets/billcopy/onetrip.png')}}" alt="No Image Found">
                    </a>
                </div>
            </div>
        </div>
    </section>

</section>
<script>
    $('.check_header').click(function(){
        if($(this).prop('checked')){
            $('.invoiceshow').each(function(){
                const url = new URL($(this).prop('href'));
                $(this).prop('href',url.origin+url.pathname+"?header=1")
            })
        }else{
            $('.invoiceshow').each(function(){
                const url = new URL($(this).prop('href'));
                $(this).prop('href',url.origin+url.pathname+"?header=0")
            })
        }
    })
        {{--  let checkField=$('.check_header').val();
        "invoiceshow"
        //let checkField=$('.check_header').prop('checked');
        console.log(checkField);
        //var checkField=$('.check_header').val();
        if (checkField=='1') {
            var route = "{{ route('invoiceShow1',[encryptor('encrypt',$invoice_id->id)]) }}";

            //$('.invoiceLink').attr('href', route);
            $('.invoiceLink').click(function(){
                window.location=$(this).attr('href', route);
            })
        } else {
            'ok'
            //window.location=$(this).attr('href', route);
        }

    }  --}}
</script>

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
