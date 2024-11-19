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
    {{-- <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</th>
            <th style="text-align: right; padding-right: 50px;">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</th>
        </tr>
    </table>
    <br>
    <div>Invoice No. {{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</div>
    <br>
    <table width="100%">
        <tr>
            <td width="5%" style="text-align: left;">To:</th>

            <td style="text-align: left;">Secretary
                </th>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice_id->customer?->name }}</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice_id->customer?->address }}</td>
        </tr>
    </table>
    <br>
    <div>Subject:   <b> Security Service bill for the month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}.</b></div>
    <br>
    <div>Dear Sir,</div>
    <br>
    <div>Reference to the above subject, we herewith submitted the security services bill
        and account number at Prime Bank, Halisahar Branch.</div>
    <br> --}}
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
            <td style="padding-top: 12px;" width="15%"><b>Subject:</b></td>
            @if ($invoice_id->inv_subject != '')
                <td colspan="2" style="padding-top: 12px;"><b>{{$invoice_id->inv_subject}}.</b></td>
            @else
                <td colspan="2" style="padding-top: 12px;"><b>Security Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}.</b></td>
            @endif
        </tr>
        <tr>
            <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
            <td></td>
            <td></td>
        </tr>
    </table>
            <div style="padding-top: 8px; padding-bottom: 8px;">
                @php
                    $header_note = $invoice_id->header_note;
                    $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $header_note);
                @endphp
                {!! $bolded_note !!}
            </div>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <th width="3%">S.L</th>
            <th width="8%">ID No</th>
            <th width="8%">Rank</th>
            <th width="14%">Area</th>
            <th width="34%">Name of the Security Person</th>
            <th width="6%" >Duty </th>
            <th width="15%" >Account Number</th>
            <th width="13%">Salary Amount (BDT)</th>
        </tr>
            @if ($wasa?->wasadetails)
                @foreach ($wasa->wasadetails->sortBy('area') as $de)
                    <tr>
                        <td style="text-align: center;">{{ ++$loop->index }}</td>
                        <td style="text-align: center;">{{ $de->employee ? $de->employee->admission_id_no : '' }}</td>
                        <td style="text-align: center;">{{ $de->jobpost ? $de->jobpost->name : '' }}</td>
                        <td style="text-align: center;">{{ $de->area }}</td>
                        <td style="text-align: center;">{{ $de->employee ? $de->employee->en_applicants_name : '' }}</td>
                        <td style="text-align: center;">{{ $de->duty }}</td>
                        <td style="text-align: center;">
                            @if ($de->account_no != '')
                                {{ $de->account_no }}
                            @else
                                {{ $de->employee ? $de->employee->second_ac_no : '' }}
                            @endif
                        </td>
                        <td style="text-align: end;">{{ money_format($de->salary_amount) }}</td>
                    </tr>
                @endforeach
            @endif
        <tr>
            <th></th>
            <th colspan="6">Sub Total</th>
            <th style="text-align: right;">{{ money_format($wasa?->sub_total_salary) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">Add: Commission {{ (int)$wasa?->add_commission }}%</th>
            <th style="text-align: right;">{{ money_format($wasa?->add_commission_tk) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">{{ (int)$wasa?->vat_on_commission }}% VAT+ {{ (int)$wasa?->ait_on_commission }}% AIT = {{ (int)$wasa?->vat_ait_on_commission }}% on Commission</th>
            <th style="text-align: right;">{{ money_format($wasa?->vat_ait_on_commission_tk) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">VAT {{ (int)$wasa?->vat_on_subtotal }}% on Sub Total</th>
            <th style="text-align: right;">{{ money_format($wasa?->vat_on_subtotal_tk) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">AIT {{ (int)$wasa?->ait_on_subtotal }}% on Sub Total</th>
            <th style="text-align: right;">{{ money_format($wasa?->ait_on_subtotal_tk) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">Grand Total</th>
            <th style="text-align: right;">{{ money_format($wasa?->grand_total_tk) }}</th>
        </tr>
        <tr>
            <td colspan="8">Total Amount(In Words): <b><i>
                @php
                $dueTotal = $wasa?->grand_total_tk;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue";
                } else {
                    echo "Zero";
                }
            @endphp
                </i></b></td>

        </tr>

    </table>

    <br>
    <div>
        @php
            $footer_note = $invoice_id->footer_note;
            $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $footer_note);
        @endphp
        {!! $bolded_note !!}
        .</div>
    <br><br>
    <i>With thanks and Regards</i>
    <br><br>
    @php
        $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
        $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
        $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
    @endphp
    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; ">
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
</body>

</html>
