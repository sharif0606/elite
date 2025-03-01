<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
</head>

<body>
    {{-- <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y') }}</th>
            <th style="text-align: right; padding-right: 50px;">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</th>
        </tr>
    </table>
    <br><br><br>
    <div>To</div>
    <div>{{ $invoice_id->customer?->name }}.</div>
    <div>{{ $invoice_id->customer?->address }}</div>
    <br>
    <div>Dear Sir</div>
    <div style="padding-left: 50px;">Monthly CIT bill for the period covering <b>{{ \Carbon\Carbon::parse($invoice_id->start_date)->format('d F Y') }} to {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('d F Y') }}</b> is
        submitted
        herewith please.
    </div> --}}
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
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            @endif
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
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            @endif
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table>
    @endif
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
            <td width="15%">To: @if($branch?->billing_person != '') <br>&nbsp;&nbsp; @else @endif</td>
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
                <p style="margin:0;"><b>{{ $invoice_id->customer?->name }}</b></p>
                
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
            <td style="padding-top: 12px;" width="15%"><b>Subject:</b></td>
            @if ($invoice_id->inv_subject != '')
                <td colspan="2" style="padding-top: 12px;"><b>{{$invoice_id->inv_subject}}.</b></td>
            @else
                <td colspan="2" style="padding-top: 12px;"><b>CIT Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}.</b></td>
            @endif
        </tr>
        <tr>
            <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
            <td></td>
            <td></td>
        </tr>
    </table>
            <div style="padding-top: 8px; padding-bottom: 8px;">
                {{ $invoice_id->header_note }}
            </div>

    <table width="100%" border="1" cellspacing="0" style="margin-top: 15px;">
        <thead>
            <tr>
                <th width="5%">S/N</th>
                <th width="25">Service</th>
                <th width="15">Rate</th>
                <th width="15%">Period</th>
                <th width="15">Trip</th>
                <th width="25%">Amount (BDT)</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @if ($onetrip?->onetripdetails)
            @foreach ($onetrip->onetripdetails as $de)
            <tr>
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->service }}</td>
                <td>{{ money_format($de->rate) }}</td>
                <td>{{ \Carbon\Carbon::parse($de->period)->format('d/m/Y')}}</td>
                <td>{{ $de->trip }}</td>
                <td style="text-align: end;"><b>{{ money_format($de->amount)}}</b></td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right;"> <b>Sub Total=</b> </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip?->sub_total_amount) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right; font-weight: bold;"> Vat@ {{ $onetrip?->vat }} %= </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip?->vat_taka) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right;"> <b>Grand Total=</b> </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip?->grand_total) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <div>Total Amount(In Words): <b><i>
        @php
        $dueTotal = $onetrip?->grand_total;

        if ($dueTotal > 0) {
            $textValue = getBangladeshCurrency($dueTotal);
            echo "$textValue";
        } else {
            echo "Zero";
        }
    @endphp
        .</i></b></div>
    <br>
    <div>
        @php
            $footer_note = $invoice_id->footer_note;
            $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $footer_note);
        @endphp
        {!! $bolded_note !!}
    . </div>
    <br><br>
    {{-- <table width="100%" style="margin-top:1.5rem;">
        <tr>
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
    @if($headershow==1)
        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left;">
    @else
        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; margin-top:2rem;">
    @endif
        <div style="flex: 1; text-align: left; padding-right: 10px;">
            {{-- Align left side of the body --}}
            @if($headershow==1)
                @if ($footersetting1->signature != '')
                    <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting1->signature) }}" class="my-1" width="100px" alt=""><br>
                @endif
            @endif
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            {{ $footersetting1?->phone }}
        </div>
        
        <div style="flex: 1; text-align: center; padding-right: 10px;">
            {{-- Align center of the body --}}
            <div style="display: inline-block; text-align: left;">
                @if($headershow==1)
                    @if ($footersetting2->signature != '')
                        <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting2->signature) }}" class="my-1" width="100px" alt=""><br>
                    @endif
                @endif
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                {{ $footersetting2?->phone }}
            </div>
        </div>
        
        <div style="flex: 1; text-align: right;">
            {{-- Align right side of the body but content left-aligned --}}
            <div style="display: inline-block; text-align: left;">
                @if($headershow==1)
                    @if ($footersetting3->signature != '')
                        <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting3->signature) }}" class="my-1" width="100px" alt=""><br>
                    @endif
                @endif
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone }}
            </div>
        </div>
    </div>
</body>

</html>
