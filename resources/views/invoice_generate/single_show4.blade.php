<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Dutch Bangla Bank Ltd. for August-2023</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
        <tr>
            <th width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></th>
            <th style="text-align: right; padding-right: 50px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></th>
        </tr>
    </table>
    <br>
    <div>Invoice No. ESSL/GPH/July-23-01</div>
    <br>
    <div>To</div>
    <div>Manager</div>
    <div><b>{{ $invoice_id->customer?->name }}</b></div>
    <div>{{ $branch?->brance_name }}</div>
    <div>{{ $branch?->billing_address }}</div>
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
                <th width="20%">VAT @ {{ $invoice_id->vat }}%</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($invoice_id->details)
            @foreach ($invoice_id->details as $de)
            <tr style="text-align: center;">
                <td>{{ ++$loop->index  }}</td>
                <td>{{ $de->jobpost?->name }}</td>
                <td>{{ ($de->rate*$de->employee_qty) }}
                    <input type="hidden" class="month_service" name="" value="{{ $de->rate*$de->employee_qty }}">
                </td>
                <td>
                    @php
                        $totalSalary=$de->rate*$de->employee_qty;
                        $vatAmount=(($totalSalary*$invoice_id->vat)/100);
                    @endphp
                    {{ $vatAmount }}
                    <input type="hidden" class="vat_amount" name="" value="{{ $vatAmount }}">
                </td>
                <td style="text-align: center;">{{ money_format($totalSalary+$vatAmount) }}
                    <input type="hidden" class="total_amount" name="" value="{{ $totalSalary+$vatAmount }}">
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr style="text-align: center;">
                <td colspan="2"> Grand Total</td>
                <td><b class="tmonth_s"></b></td>
                <td><b class="tvat_amount"></b></td>
                <td style="text-align: center;"><b class="ttotal_amount"></b></td>

            </tr>
        </tfoot>
    </table>
{{ $textValue }}
    <br>
    <div>{{ $invoice_id->footer_note }}</div>
    <br>
    <div>Your Cooperation will be highly appreciated.</div>
    <br><br>
    <i>With thanks & Regards</i>
    <br>
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
        monthService();
        function monthService(){
            var monthSer=0;
            var vatAmount=0;
            var totalAmount=0;
            $('.month_service').each(function(){
                monthSer+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.tmonth_s').text(monthSer);

            $('.vat_amount').each(function(){
                vatAmount+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.tvat_amount').text(vatAmount.toFixed(2));

            $('.total_amount').each(function(){
                totalAmount+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            });
            $('.ttotal_amount').text(totalAmount.toFixed(2));
            $(".dueTotal").val(totalAmount.toFixed(2));
        }
    </script>
</body>

</html>
