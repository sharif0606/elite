<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill For month of July 2023 to COATS Bangladesh Limited</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</th>
            <th style="text-align: right; padding-right: 50px;">{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</th>
        </tr>
    </table>
    <br>
    <div>Invoice No. ESSL/July-23-01</div>
    <br>
    <table width="100%">
        <tr>
            <th width="5%" style="text-align: left;">To:</th>
            <th style="text-align: left;">{{ $invoice_id->customer?->name }}</th>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice_id->customer?->brance_name }}</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice_id->customer?->billing_address }}</td>
        </tr>
        <tr>
            <td></td>
            <td>BIN / VAT Registration No: 000268682-0503</td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td width="8%">Attention:</td>
            <td>{{ $invoice_id->customer?->contact_person }}</td>
        </tr>
        <tr>
            <td width="8%"></td>
            <td>{{ $invoice_id->customer?->contact_number }}</td>
        </tr>
    </table>
    <br>
    <div><u><b>Subject: Bill for the month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></u></div>
    <br>
    <div>Dear Sir</div>
    <div style="padding-left: 50px;">Bill for the period covering <b>{{ \Carbon\Carbon::parse($invoice_id->start_date)->format('d F Y') }}</b> to <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('d F Y') }}</b> is submitted herewith
        please:-</div>

    <table width="100%" border="1" cellspacing="0" style="margin-top: 15px;">
        <thead>
            <tr>
                <th width="5%">S/N</th>
                <th width="20%">Service</th>
                <th width="15%">New Rate <br>per 08 hrs</th>
                <th width="15%">Period</th>
                <th width="15%">Total Person</th>
                <th width="20%">Total Amount br (TK)</th>
                <th width="10%">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
            $TotalTk = 0;
            @endphp
            @if ($invoice_id->details)
            @foreach ($invoice_id->details as $de)
            <tr style="text-align: center;">
                <td>{{ ++$loop->index  }}.</td>
                <td>{{ $de->jobpost?->name }}</td>
                <td>{{ $de->rate }}</td>
                <td><b>{{ \Carbon\Carbon::parse($invoice_id->st_date)->format('F Y')}}</b> </td>
                <td>{{ $de->employee_qty }}<br>({{ $de->employee_qty*$de->warking_day }} duties)</td>
                <td style="text-align: center;">{{ $de->rate*$de->employee_qty }}
                    <input type="hidden" class="total_amount" name="" value="{{ $de->rate*$de->employee_qty }}">
                </td>
                <td><input style="outline: none; border: none; appearance: none;" type="text" name="" id=""></td>
            </tr>
            <?php
            $TotalTk += $de->rate * $de->employee_qty;
            ?>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="4" style="text-align: right;">Grand Total= </td>
                <td style="text-align: center;" class="ttotal_amount"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7">Total Amount(In Words): <b><i>
                    @php
                    if ($TotalTk > 0) {
                        $textValue = getBangladeshCurrency($TotalTk);
                        echo "$textValue";
                    } else {
                        echo "Zero";
                    }
                    @endphp
                     only.</i></b> </td>
            </tr>
        </tfoot>
    </table>
    <br>
    <div>{{ $invoice_id->footer_note }}</div>
    <br><br><br><br><br>
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
    <script>
        monthService()
        function monthService(){
            var totalAmount=0;
            $('.total_amount').each(function(){
                totalAmount+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.ttotal_amount').text(totalAmount);
        }
    </script>
</body>

</html>
