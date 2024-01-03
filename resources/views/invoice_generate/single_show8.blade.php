<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }}. for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y') }}</title>
</head>

<body>
    <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y') }}</th>
            <th style="text-align: right; padding-right: 50px;">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</th>
        </tr>
    </table>
    <br><br><br>
    <div>To</div>
    {{--  <div>Manager and Branch In-Charge</div>  --}}
    <div>{{ $invoice_id->customer?->name }}.</div>
    <div>{{ $invoice_id->customer?->address }}</div>
    {{--  <div>Chattogram.</div>  --}}
    <br>
    <div>Dear Sir</div>
    <div style="padding-left: 50px;">Monthly CIT bill for the period covering <b>{{ \Carbon\Carbon::parse($invoice_id->start_date)->format('d F Y') }} to {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('d F Y') }}</b> is
        submitted
        herewith please.
    </div>

    <table width="100%" border="1" cellspacing="0" style="margin-top: 15px;">
        <thead>
            <tr>
                <th width="5%">S/N</th>
                <th width="25">Service</th>
                <th width="15">Rate</th>
                <th width="15%">Period</th>
                <th width="15">Trip</th>
                <th width="25%">Amount(Tk.)</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @if ($onetrip->onetripdetails)
            @foreach ($onetrip->onetripdetails as $de)
            <tr>
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->service }}</td>
                <td>{{ $de->rate }}</td>
                <td>{{ \Carbon\Carbon::parse($de->period)->format('d/m/Y')}}</td>
                <td>{{ $de->trip }}</td>
                <td style="text-align: end;"><b>{{ $de->amount}}</b></td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right;"> <b>Sub Total=</b> </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip->sub_total_amount) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right; font-weight: bold;"> Vat@ {{ $onetrip->vat }} %= </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip->vat_taka) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right;"> <b>Grand Total=</b> </td>
                <td style="text-align: right;font-weight: bold;">{{ money_format($onetrip->grand_total) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <div>Total Amount(In Words): <b><i>
        @php
        $dueTotal = $onetrip->grand_total;

        if ($dueTotal > 0) {
            $textValue = getBangladeshCurrency($dueTotal);
            echo "$textValue";
        } else {
            echo "Zero";
        }
    @endphp
        Only.</i></b></div>
    <br>
    <div>{{ $invoice_id->footer_note }}. </div>
    <br><br><br><br><br>
    <table width="100%">
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
    </table>

</body>

</html>
