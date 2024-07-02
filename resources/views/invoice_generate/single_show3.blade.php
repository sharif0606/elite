<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
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
    {{-- <table width="100%"style="padding: 2in 0px 30px 0px;">
        <tr style="font-size: 20px;">
            <td width="20%" style="text-align: left;"></td>
            <td width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
            <td width="30%" style="text-align: center;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table> --}}
    <div style="padding: 0 70px 0 80px;">

        <table width="100%">
            <tr>
                <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                <td style="padding-bottom: 8px;">{{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</td>
            </tr>
            <tr>
                <td width="15%">To:</td>
                <td>
                    @if($branch?->billing_person)
                    <b>{{ $branch?->billing_person }} </b><br/>
                    @endif
                    <b>{{ $invoice_id->customer?->name }}</b>
                </td>
                @if($invoice_id->customer?->bin)
                <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
                @endif
            </tr>
            <tr>
                <td width="15%"></td>
                <td colspan="2">{{ $branch?->brance_name }}</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td colspan="2">{!! nl2br(e(str_replace('^', "\n", $branch?->billing_address))) !!}</td>
            </tr>
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
            <tr>
                <td width="15%"><b>Subject:</b></td>
                <td><b>Security Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                <td></td>
            </tr>
        </table>
                <div>
                    Reference to the above subject, We herewith submitted the security services bill for the period covering
                    <b>{{ \Carbon\Carbon::parse($invoice_id->start_date)->format('d F Y') }} to {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('d F Y') }}</b>.
                </div>

        <table border="1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>Service</th>
                    <th>Rate</th>
                    <th>Total Person</th>
                    <th>Working Days</th>
                    <th>Total Hours</th>
                    <th>Rate per hours</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($invoice_id->details)
                @foreach ($invoice_id->details as $de)
                <tr style="text-align: center;">
                    <td >{{ ++$loop->index  }}</td>
                    <td>{{ $de->jobpost?->name }}</td>
                    <td>{{ $de->rate }}</td>
                    <td>{{ $de->employee_qty }}</td>
                    <td>{{ $de->warking_day }}</td>
                    <td>{{ $de->total_houres }}</td>
                    <td>{{ $de->rate_per_houres }}</td>
                    <td>{{ $de->total_amounts }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="6">Sub Total</th>
                    <td>{{ money_format($invoice_id->sub_total_amount) }}</td>
                </tr>
                @if ($invoice_id->less)
                @foreach ($invoice_id->less as $le)
                <tr style="text-align: center;">
                    <td></td>
                    <td colspan="6">{{ $le->description }}</td>
                    <td>{{ $le->amount }}</td>
                </tr>
                @endforeach
                @endif
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="6">Total</th>
                    <td>{{ money_format($invoice_id->total_tk)}}</td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p>
                Total Amount In Words: <b>
                    @php
                    $dueTotal = $invoice_id->total_tk;

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
    </table>
</body>
</html>
