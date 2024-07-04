<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>

</head>
<body style="font-size: 16px !important;">
    @if($headershow==1)
    <div style="text-align: center;"><h2>INVOICE</h2></div>
    <table width="100%">
        <tr>
            <th width="45%" style="text-align: left;"><img src="{{ asset('assets/billcopy/logo.png') }}" height="100px" width="280px" alt="logo" srcset=""></th>

            <td width="55%">
                <h3>
                    House #2, Lane #2, Road #2, Block-K,<br>
                Halishahar Housing Estate, Chattogram-4224 <br>
                Tel: 02333323387, 02333328707 <br>
                Mobile: 01844-040714, 01844-040717 <br>
                Email: ctg@elitebd.com
                </h3>
            </td>
        </tr>
    </table>
    <hr style="height: 1px; background-color: red;">
    <table width="100%"style="padding-left: 55px;">
        <tr>
            <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
            <td width="30%"></td>
            <td width="30%" style="text-align: center;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
            {{--  <td width="30%" style="text-align: center;">Date : {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d F Y') }}</td>  --}}
        </tr>
    </table>
    @else
    <table width="100%"style="padding: 2in 0px 30px 0px;">
        <tr style="font-size: 20px; position: relative;">
            <td width="20%" style="text-align: left;"></td>
            <td style="position: absolute; top:-30px;" width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
            <td width="30%" style="text-align: center;  position: absolute; right:-60px; top:-30px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table>
    @endif
    <div style="padding: 0 0px 0 0px;">
       
        <table width="100%">
            <tr>
                <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                <td style="padding-bottom: 8px;">{{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</td>
            </tr>
            <tr>
                <td width="15%">To:</td>
                <td>
                    @if ($invoice_id->customer?->customer_type == 0)
                        <b>{{ $invoice_id->customer?->billing_person }} </b><br/>
                    @else
                        @if($branch?->billing_person)
                            <b>{{ $branch?->billing_person }} </b><br/>
                        @endif
                    @endif
                    <b>{{ $invoice_id->customer?->name }}</b>
                </td>
                @if($invoice_id->customer?->bin)
                <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
                @endif
            </tr>
            <tr>
                <td width="15%"></td>
                <td colspan="2">
                    @if ($invoice_id->customer?->customer_type == 0)
                    @else
                        {{ $branch?->brance_name }}
                    @endif
                </td>
            </tr>
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
                    <td style="padding-top: 8px;" width="15%">Attention:</td>
                    <td style="padding-top: 8px;"><b>{{ $invoice_id->customer?->attention }}</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">{{ $invoice_id->customer?->attention_details }}</td>
                </tr>
                @endif
            @else
                @if($branch?->attention)
                <tr>
                    <td style="padding-top: 8px;" width="15%">Attention:</td>
                    <td style="padding-top: 8px;"><b>{{ $branch?->attention }}</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">{{ $branch?->attention_details }}</td>
                </tr>
                @endif
            @endif
            
            <tr>
                <td style="padding-top: 12px;" width="15%"><b>Subject:</b></td>
                <td colspan="2" style="padding-top: 12px;"><b>Security Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
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

        <table border="1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>Service</th>
                    <th>Rate</th>
                    <th>Period</th>
                    <th>Person</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($invoice_id->details)
                    @foreach ($invoice_id->details as $de)
                        <tr style="text-align: center;">
                            <td >{{ ++$loop->index  }}</td>
                            <td>{{ $de->jobpost?->name }}
                                <br/>
                                {{ $de->atms?->atm }}
                            </td>
                            <td>{{ $de->rate }} <br/>
                                @if($de->type_houre )
                                    ({{ $de->type_houre }} hours Rate)
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($de->st_date)->format('d') }}-{{ \Carbon\Carbon::parse($de->ed_date)->format('d/m/Y') }}</td>
                            <td>{{ $de->employee_qty }}</td>
                            <td>{{ money_format(($de->rate)*($de->employee_qty)) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                @php $totalAddLess=0; @endphp
                @if($invoice_id->vat>0)
                    <tr style="text-align: center;">
                        <td></td>
                        <td colspan="4">Sub Total</td>
                        <td>{{ money_format($invoice_id->sub_total_amount) }}</td>
                    </tr>
                @endif
                {{--  @if ($invoice_id->less)  --}}
                @if (isset($invoice_id->less) && $invoice_id->less)
                    @foreach ($invoice_id->less as $le)
                        <tr style="text-align: center;">
                            <td></td>
                            <td colspan="4">{{ $le->description }}</td>
                            <td>{{ $le->amount }}</td>
                        </tr>
                        @php $totalAddLess += $le->amount; @endphp
                    @endforeach
                @endif
                {{--  <tr style="text-align: center;" class="d-none">
                    <td></td>
                    <th colspan="4">Total</th>
                    <td>{{ money_format($invoice_id->total_tk)}}</td>
                </tr>  --}}
                @if($invoice_id->vat>0)
                    <tr style="text-align: center;">
                        <td></td>
                        <td colspan="4">Vat@ {{ $invoice_id->vat }} %</td>
                        <td>{{ money_format(($invoice_id->sub_total_amount*$invoice_id->vat)/100) }}</td>
                    </tr>
                @endif
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="4">Total</th>
                    <td>{{ money_format((($invoice_id->sub_total_amount*$invoice_id->vat)/100)+$invoice_id->sub_total_amount + $totalAddLess) }}</td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p>Total Amount In Words:<b>
                @php
                $dueTotal = (($invoice_id->sub_total_amount*($invoice_id->vat)/100))+$invoice_id->sub_total_amount + $totalAddLess;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue"."only";
                } else {
                    echo "Zero";
                }
            @endphp
                </b> <br>
                {{ $invoice_id->footer_note }}
            </p>
            Your Cooperation will be highly appreciated.
            <p><i><b>With thanks of Regards</b></i></p>
        </div>
    </div>
    <table width="100%" style="padding-top: 5px;">
        <tr style="text-align: left;">
            @php
            $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
            $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
            $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
            @endphp
            {{--  <td>
                {{ $footersetting1?->name }} <br>
                {{ $footersetting1?->designation }} <br>
                Cell: {{ $footersetting1?->phone  }}
            </td>
            <td style="text-align: left; float: center;">
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                Cell: {{ $footersetting2?->phone  }}
            </td>
            <td  style="text-align: left; float: right;">
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone  }}
            </td>  --}}

        </tr>
    </table>
    <div style="text-align: center;">
        <div style="width: 200px; float: left; text-align: left;">
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            Cell: {{ $footersetting1?->phone  }}
        </div>
        <div style="width: 200px; float: right; text-align: left;">
            {{ $footersetting3?->name }} <br>
            {{ $footersetting3?->designation }} <br>
            {{ $footersetting3?->phone  }}
        </div>
        <div style="width: 200px; margin-left: auto; margin-right: auto; text-align: left;">
            {{ $footersetting2?->name }} <br>
            {{ $footersetting2?->designation }} <br>
            Cell: {{ $footersetting2?->phone  }}
        </div>
    </div>
</body>
</html>
