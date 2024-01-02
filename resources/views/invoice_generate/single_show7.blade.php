<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }}. for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>
</head>

<body>
    <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
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
        {{--  <tr>
            <td></td>
            <td>Chattogram.</td>
        </tr>  --}}
    </table>
    <br>
    <div>Subject:   <b> Security Service bill for the month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}.</b></div>
    <br>
    <div>Dear Sir,</div>
    <br>
    <div>Reference to the above subject, we herewith submitted the security services bill
        and account number at Prime Bank, Halisahar Branch.</div>
    <br>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <th width="3%">S.L</th>
            <th width="8%">ID No</th>
            <th width="8%">Rank</th>
            <th width="14%">Area</th>
            <th width="34%">Name of the Security Person</th>
            <th width="6%" >Duty </th>
            <th width="15%" >Account Number</th>
            <th width="13%">Salary Amount</th>
        </tr>
            @if ($wasa->wasadetails)
            @foreach ($wasa->wasadetails as $de)
            <tr>
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->employee?->admission_id_no }}</td>
                <td>{{ $de->jobpost?->name }}</td>
                <td>{{ $de->area }}</td>
                <td>{{ $de->employee?->en_applicants_name }}</td>
                <td>{{ $de->duty }}</td>
                <td>{{ $de->employee?->bn_ac_no }}</td>
                <td style="text-align: end;">{{ $de->salary_amount }}</td>
            </tr>
            @endforeach
            @endif
        <tr>
            <th></th>
            <th colspan="6">Sub Total</th>
            <th style="text-align: right;">{{ $wasa->sub_total_salary }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">Add: Commission {{ $wasa->add_commission }}%</th>
            <th style="text-align: right;">{{ $wasa->add_commission_tk }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">{{ $wasa->vat_on_commission }}% VAT+ {{ $wasa->ait_on_commission }}% AIT = {{ $wasa->vat_ait_on_commission }}% on Commission</th>
            <th style="text-align: right;">{{ $wasa->vat_ait_on_commission_tk }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">VAT {{ $wasa->vat_on_subtotal }}% on Sub Total</th>
            <th style="text-align: right;">{{ $wasa->vat_on_subtotal_tk }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">AIT {{ $wasa->ait_on_subtotal }}% on Sub Total</th>
            <th style="text-align: right;">{{ $wasa->ait_on_subtotal_tk }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan="6">Grand Total</th>
            <th style="text-align: right;">{{ $wasa->grand_total_tk }}</th>
        </tr>
        <tr>
            <td colspan="8">Total Amount(In Words): <b><i>
                @php
                $dueTotal = $wasa->grand_total_tk;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue";
                } else {
                    echo "Zero";
                }
            @endphp
                only.</i></b></td>

        </tr>

    </table>

    <br>
    <div>{{ $invoice_id->footer_note }}.</div>
    <br><br>
    <i>With thanks & Regards</i>
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
