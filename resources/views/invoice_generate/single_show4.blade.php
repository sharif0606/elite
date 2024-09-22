<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    @if($headershow==1)
    <div style="text-align: center;"><h2><span style="border-bottom: solid 1px;">INVOICE</span></h2></div>
    <table width="100%">
        <tr>
            <th width="45%" style="text-align: left;"><img src="{{ asset('assets/billcopy/logo.png') }}" height="90px" width="auto" alt="logo" srcset=""></th>

            <td width="55%">
                <h4 style="margin: 0; padding-left: 45px;">House #2, Lane #2, Road #2, Block-K,</h4>
                <h4 style="margin: 0; padding-left: 45px;">Halishahar Housing Estate, Chattogram-4224</h4>
                <h4 style="margin: 0; padding-left: 45px;">Tel: 02333323387, 02333328707</h4>
                <h4 style="margin: 0; padding-left: 45px;">Mobile: 01844-040714, 01844-040717</h4>
                <h4 style="margin: 0; padding-left: 45px;">Email: ctg@elitebd.com</h4>
            </td>
        </tr>
    </table>
    <div style="height: 2px; background-color: red; margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
    <table width="100%">
        <tr>
            <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
            {{--  <td width="30%" style="text-align: center;">Date : {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d F Y') }}</td>  --}}
        </tr>
    </table>
    @else
    <table width="100%"style="padding: 2in 0px 30px 0px;">
        {{-- <tr style="font-size: 20px; position: relative;">
            <td width="20%" style="text-align: left;"></td>
            <td style="position: absolute; top:-30px;" width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            <td width="30%" style="text-align: center;  position: absolute; right:-60px; top:-30px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr> --}}
        <tr>
            <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table>
    @endif
    {{-- <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></th>
            <th style="text-align: right; padding-right: 50px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></th>
        </tr>
    </table> --}}
    @if($headershow==1)
        <table width="100%" style="margin-top: 1rem;">
    @else
        <table width="100%">
    @endif
        <tr>
            <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
            <td style="padding-bottom: 8px;">{{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('y') }}/{{ $invoice_id->id }}</td>
        </tr>
        <tr>
            <td width="15%">To: <br>&nbsp;&nbsp;</td>
            <td>
                <p style="padding:0; margin:0;">
                    @if ($invoice_id->customer?->customer_type == 0)
                    <b>{{ $invoice_id->customer?->billing_person }} </b>
                    @else
                        @if($branch?->billing_person)
                            <b>{{ $branch?->billing_person }} </b>
                        @endif
                    @endif
                </p>
                <p style="margin:0;">
                    <b>{{ $invoice_id->customer?->name }}</b>
                </p>
            </td>
            @if($invoice_id->customer?->bin)
            <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
            @endif
        </tr>
        @if ($invoice_id->customer?->customer_type == 0)
        @else
        <tr>
            <td width="15%"></td>
            <td colspan="2">{{ $branch?->brance_name }}</td>
        </tr>
        @endif
        <tr>
            <td width="15%"></td>
            <td colspan="2">
                @if ($invoice_id->customer?->customer_type == 0)
                    {!! nl2br(e(str_replace('^', "\n", $invoice_id->customer?->address))) !!}
                @else
                    @if($branch?->billing_address)
                        {!! nl2br(e(str_replace('^', "\n", $branch?->billing_address))) !!}
                    @endif
                @endif
            </td>
        </tr>
        @if ($invoice_id->customer?->customer_type == 0)
            @if($invoice_id->customer?->attention)
            <tr>
                <td style="padding-top: 8px;" width="15%">Attention:@if($invoice_id->customer?->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                <td colspan="2" style="padding-top: 8px;"><b>{{ $invoice_id->customer?->attention }}</b><br>{{ $invoice_id->customer?->attention_details }}</td>
                
            </tr>
            @endif
        @else
            @if($branch?->attention)
            <tr>
                <td style="padding-top: 8px;" width="15%">Attention: @if($branch?->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                <td colspan="2" style="padding-top: 8px;"><b>{{ $branch?->attention }}</b><br>{{ $branch?->attention_details }}</td>
            </tr>
            @endif
        @endif
        <tr>
            <td width="15%"><b>Subject:</b></td>
            <td><b>Submission of bill against security services/Security including Armed services for the month of {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}.</b></td>
        </tr>
        <tr>
            <td width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
            <td></td>
        </tr>
    </table>
    {{-- <br>
    <div>Invoice No. {{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</div>
    <br>
    <div>To</div>
    <div>Manager</div>
    <div><b>{{ $invoice_id->customer?->name }}</b></div>
    <div>{{ $branch?->brance_name }}</div>
    <div>{{ $branch?->billing_address }}</div>
    <br>
    <div><b>Subject: Submission of bill against security services/Security including Armed services for the month of
        {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></div>
    <br>
    <div>Dear Sir</div> --}}
    <div>You are requested to pay the security bill/security including Armed services Bill for the month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}
        for providing security including service/security/including Armed services of your branch in favour of Elite
        Security Services Ltd.
    </div>

    <table width="100%" border="1" cellspacing="0" style="margin-top: 15px;">
        <thead>
            <tr>
                <th width="5%">SL</th>
                <th width="35%">Description</th>
                <th width="20%">Monthly Service Charge</th>
                <th width="20%">VAT @ {{ $invoice_id->vat }}%</th>
                <th width="20%">Total (BDT)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $TotalTk = 0;
            $totalVat = 0;
            $totalMontly = 0;
            @endphp
            @if ($invoice_id->details)
            @foreach ($invoice_id->details as $de)
            <tr style="text-align: center;">
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->jobpost?->name }}</td>
                <td>{{ money_format($de->total_amounts) }}
                    <input type="hidden" class="month_service" name="" value="{{ money_format($de->total_amounts) }}">
                </td>
                <td>
                    @php
                        $totalSalary=$de->total_amounts;
                        $vatAmount=(($totalSalary*$invoice_id->vat)/100);
                        $grandTotal=$totalSalary+$vatAmount;
                        $totalVat += $vatAmount;
                        $totalMontly += $totalSalary;
                    @endphp
                    {{ money_format($vatAmount) }}
                    <input type="hidden" class="vat_amount" name="" value="{{ money_format($vatAmount) }}">
                </td>
                <td style="text-align: end;">{{ money_format($totalSalary+$vatAmount) }}
                    <input type="hidden" class="total_amount" name="" value="{{ money_format($totalSalary+$vatAmount) }}">
                </td>
            </tr>
            <?php $TotalTk += $grandTotal; ?>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr style="text-align: center;">
                <td colspan="2"> <b>Grand Total</b></td>
                <td><b>{{money_format($totalMontly)}}</b></td>
                <td><b>{{money_format($totalVat)}}</b></td>
                <td style="text-align: end;"><b>{{ money_format($TotalTk)}}</b></td>

            </tr>
        </tfoot>
    </table>
    <p>
        Total Amount In Words: <b>
            @php
            if ($TotalTk > 0) {
                $textValue = getBangladeshCurrency($TotalTk);
                echo "$textValue";
            } else {
                echo "Zero";
            }
            @endphp.
            </b> <br><br>
            @php
                $footer_note = $invoice_id->footer_note;
                $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $footer_note);
            @endphp
            {!! $bolded_note !!}
    </p>
    <br>
    <div>Your Cooperation will be highly appreciated.</div>
    <br><br>
    <i>With thanks and Regards</i>
    <br>
    {{-- <table width="100%" style="padding-top: 5px; margin-top:1.5rem;">
        <tr style="text-align: center;">
            @php
            $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
            $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
            $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
            @endphp
            <td>
                {{ $footersetting1?->name }} <br>
                {{ $footersetting1?->designation }} <br>
                Cell: {{ $footersetting1?->phone  }}
            </td>
            <td>
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                Cell: {{ $footersetting2?->phone  }}
            </td>
            <td>
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone  }}
            </td>
        </tr>
    </table> --}}
    @php
        $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
        $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
        $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
    @endphp
    <div style="text-align: center; margin-top:2rem;">
        <div style="width: 200px; float: left; text-align: left;">
            @if ($footersetting1->signature != '')
                <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting1->signature)}}" class="my-1" width="100px" alt=""><br>
            @endif
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            {{ $footersetting1?->phone  }}
        </div>
        <div style="width: 200px; float: right; text-align: left;">
            @if ($footersetting3->signature != '')
                <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting3->signature)}}" class="my-1" width="100px" alt=""><br>
            @endif
            {{ $footersetting3?->name }} <br>
            {{ $footersetting3?->designation }} <br>
            {{ $footersetting3?->phone  }}
        </div>
        <div style="width: 200px; margin-left: auto; margin-right: auto; text-align: left;">
            @if ($footersetting2->signature != '')
                <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting2->signature)}}" class="my-1" width="100px" alt=""><br>
            @endif
            {{ $footersetting2?->name }} <br>
            {{ $footersetting2?->designation }} <br>
            {{ $footersetting2?->phone  }}
        </div>
    </div>
    <script>
        monthService();
        function monthService(){
            var monthSer=0;
            var vatAmount=0;
            var totalAmount=0;
            $('.month_service').each(function(){
                monthSer+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.tmonth_s').text(monthSer.toFixed(2));

            $('.vat_amount').each(function(){
                vatAmount+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.tvat_amount').text(vatAmount.toFixed(2));

            $('.total_amount').each(function(){
                totalAmount+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.ttotal_amount').text(totalAmount.toFixed(2));
            $(".dueTotal").val(totalAmount.toFixed(2));
        }
    </script>
</body>

</html>
