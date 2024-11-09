<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cusName->name }} for </title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">

</head>
<body style="font-size: 16px !important;">
    <table width="100%"style="padding: 2in 0px 30px 0px;">
        <tr>
            <td width="40%" style="text-align: left;">Bill for the Month of : <b></b></td>
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b></b></td>
        </tr>
    </table>
        <div style="padding: 0 0px 0 0px;">
        <table width="100%">
            <tr>
                <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                <td style="padding-bottom: 8px;">{{ $cusName->invoice_number }}</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td colspan="2">
                    @if ($cusName->customer_type == 0)
                        {!! nl2br(e(str_replace('^', "\n", $cusName->address))) !!}
                    @else
                    @endif
                </td>
            </tr>
            @if ($cusName->customer_type == 0)
                @if($cusName->attention)
                <tr>
                    <td style="padding-top: 8px;" width="15%">Attention:@if($cusName->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                    <td colspan="2" style="padding-top: 8px;"><b>{{ $cusName->attention }}</b><br>{{ $cusName->attention_details }}</td>
                    
                </tr>
                @endif
            @else
            @endif
            <tr>
                <td colspan="2" style="padding-top: 12px;"><b>Security Services Bill for the Month of </b></td>
            </tr>
            <tr>
                <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                <td></td>
                <td></td>
            </tr>
        </table>
                <div style="padding-top: 8px; padding-bottom: 8px;">
                    header note
                </div>
        <table border="1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>Month</th>
                    <th>Period</th>
                    <th>Billing Amount</th>
                    <th>Receive Amount</th>
                    <th>Due</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                    $totalDue = 0;
                @endphp
                @foreach ($result as $de)
                    <tr style="text-align: center;">
                        <td >{{ $sl++  }}</td>
                        <td>{{ \Carbon\Carbon::parse($de->bill_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($de->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($de->end_date)->format('d/m/Y') }}</td>
                        <td style="text-align: end;">{{ money_format($de->grand_total) }}</td>
                        <td style="text-align: end;">{{ money_format($de->received_amount) }}</td>
                        <td style="text-align: end;">{{ money_format($de->due_amount) }}</td>
                    </tr>
                    @php
                        $totalDue += $de->due_amount;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="4">Grand Total</th>
                    <td style="text-align: end;"><b>{{ money_format($totalDue) }}</b></td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p>Total Amount In Words:<b>
                @php
                $dueTotal = $totalDue;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue";
                } else {
                    echo "Zero";
                }
            @endphp
            </p>
            Your Cooperation will be highly appreciated.
            <p><i><b>With thanks and Regards</b></i></p>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; margin-top:2rem;">
        @php
            $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
            $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
            $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
            @endphp
        <div style="flex: 1; text-align: left; padding-right: 10px;">
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            {{ $footersetting1?->phone }}
        </div>
        
        <div style="flex: 1; text-align: center; padding-right: 10px;">
            <div style="display: inline-block; text-align: left;">
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                {{ $footersetting2?->phone }}
            </div>
            
        </div>
        
        <div style="flex: 1; text-align: right;">
            <div style="display: inline-block; text-align: left;">
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone }}
            </div>
        </div>
    </div>
</body>
</html>
