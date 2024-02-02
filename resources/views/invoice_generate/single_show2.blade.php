<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>

</head>
<body>
    <div style="text-align: center;"><h2>INVOICE</h2></div>
    <table width="100%">
        <tr>
            <th width="50%" style="text-align: left;"><img src="{{ asset('assets/billcopy/logo.png') }}" height="100px" width="280px" alt="logo" srcset=""></th>

            <td width="50%">
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
        </tr>
    </table>
    <div style="padding: 0 70px 0 80px;">

        <table width="100%">
            <tr>
                <td width="15%">Invoice No:</td>
                <td>{{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</td>
            </tr>
            <tr>
                <td width="15%">To:</td>
                <td><b>Manager</b></td>
                @if($invoice_id->customer?->bin)
                <td width="40%" style="text-align: center;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO- : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
                @endif
            </tr>
            <tr>
                <td width="15%"></td>
                <td><b>{{ $invoice_id->customer?->name }}</b></td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>{{ $branch?->brance_name }}</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>{{ $branch?->billing_address }}</td>
            </tr>
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
                    Reference to the above subject, We herewith submitted the security services bill along with Chalan
                    copy.
                </div>

        <table border="1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>Service</th>
                    <th>Rate</th>
                    <th>Period</th>
                    <th>Person</th>
                    <th>Bill Amount</th>
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
                            <td>{{ $de->rate }}</td>
                            <td>{{ \Carbon\Carbon::parse($de->st_date)->format('d') }}-{{ \Carbon\Carbon::parse($de->ed_date)->format('d/m/Y') }}</td>
                            <td>{{ $de->employee_qty }}</td>
                            <td>{{ money_format(($de->rate)*($de->employee_qty)) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                @if($invoice_id->vat>0)
                    <tr style="text-align: center;">
                        <td></td>
                        <td colspan="4">Sub Total</td>
                        <td>{{ money_format($invoice_id->sub_total_amount) }}</td>
                    </tr>
                    @if ($invoice_id->less)
                    @php $totalAddLess=0; @endphp
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
                    <tr style="text-align: center;">
                        <td></td>
                        <td colspan="4">Vat@ {{ $invoice_id->vat }} %</td>
                        <td>{{ money_format(($invoice_id->sub_total_amount*$invoice_id->vat)/100) }}</td>
                    </tr>
                @endif
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="4">Total</th>
                    <td>{{ money_format((($invoice_id->sub_total_amount*$invoice_id->vat)/100)+$invoice_id->sub_total_amount +$totalAddLess) }}</td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p>Total Amount In Words:<b>
                @php
                $dueTotal = (($invoice_id->sub_total_amount*($invoice_id->vat)/100))+$invoice_id->sub_total_amount+$totalAddLess;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue";
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
