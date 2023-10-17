<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Dutch Bangla Bank Ltd. for August-2023</title>
</head>

<body>
    <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></th>
            <th style="text-align: right; padding-right: 50px;"><b>{{ $invoice_id->bill_date }}</b></th>
        </tr>
    </table>
    <br>
    <div>Invoice No. ESSL/GPH/July-23-01</div>
    <br>
    <div>To</div>
    <div>Manager</div>
    <div><b>{{ $invoice_id->customer?->name }}</b></div>
    <div>{{ $invoice_id->customer?->brance_name }}</div>
    <div>{{ $invoice_id->customer?->billing_address }}</div>
    <br>
    <div><b>Subject: Submission of bill against security services/Security including Armed services for the month of
        {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></div>
    <br>
    <div>Dear Sir</div>
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
                <th width="20%">VAT @ 10%</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($invoice_id->details)
            @foreach ($invoice_id->details as $de)
            <tr style="text-align: center;">
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->jobpost?->name }}</td>
                <td>23,000/-</td>
                <td>2,300/-</td>
                <td style="text-align: right;">25,300/-</td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr style="text-align: center;">
                <td colspan="2"> Grand Total</td>
                <td><b>44,000/-</b></td>
                <td><b>4,400/-</b></td>
                <td style="text-align: right;"><b>48,400/-</b></td>

            </tr>
        </tfoot>
    </table>
    <div>Total Amount(In Words): <b><i>Fourty Eight Thousand Four Hundred taka
                only.</i></b> </div>
    <br>
    <div>The Payment may please be made in Cheques/drafts/cash in favours of <b>'Elite Security Services Limited'</b> or
        <b>A/C No.165 120 000 2281 Dutch Bangla Bank Ltd. Halisahar Branch, Ctg.</b> by
        the 1<sup>st</sup> week of each month.
    </div>
    <br>
    <div>Your Cooperation will be highly appreciated.</div>
    <br><br>
    <i>With thanks & Regards</i>
    <br><br><br><br><br>
    <table width="100%">
        <tr>
            <td style="text-align: left;">
                <div>Abu Rashel Bhuiyan</div>
                <div>Deputy Manager</div>
                <div>Cell:<b>01844-040718</b></div>
            </td>
            <td style="text-align: left; padding-left:80px;">
                <div>Md Mayin Uddin</div>
                <div>Manager</div>
                <div>Cell:<b>01844-040714</b></div>
            </td>
            <td style="text-align: left; padding-left: 80px;">
                <div>Anyp Kumur Mutsuddin</div>
                <div>Senior Manager</div>
                <div>Account & Finance</div>
            </td>
        </tr>
    </table>
</body>

</html>
