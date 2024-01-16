<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <div style="font-size: 20px; text-align: right; margin-top: 2.2in;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></div>
    <div style="text-align: center; font-size: 28px; ">
        <b><u>Invoice</u> {{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('y') }}/{{ $invoice_id->id }}</b>
    </div>
    <table width="100%">
        <tr>
            <td width="5%" style="text-align: left;">To:</td>

            <td style="text-align: left; font-size: 20px;"><b>{{ $invoice_id->customer?->name }}</b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice_id->customer?->billing_address }}</td>
        </tr>
    </table>
    <br><br>
    <div><b>Bill for the Month of: {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></div>
    <table width="100%" border="1" cellspacing="0">
        <thead>
            <tr>
                <th width="5%">S/N</th>
                <th width="25%">Service</th>
                <th width="20%">Rate 08 Hrs Per Month (BD Taka)</th>
                <th width="20%">Period</th>
                <th width="15%">Total No of Persons</th>
                <th width="15%">Amount(BD Taka)</th>
            </tr>
        </thead>
        <tbody>
            @if ($invoice_id->details)
            @foreach ($invoice_id->details as $de)
                <tr style="text-align: center;">
                    <td>{{ ++$loop->index  }}.</td>
                    <td style="text-align: left; padding-left: 15px;">{{ $de->jobpost?->name }}</td>
                    <td>{{ $de->rate }}</td>
                    <td>{{ \Carbon\Carbon::parse($de->st_date)->format('d') }}-{{ \Carbon\Carbon::parse($de->ed_date)->format('d/m/Y') }}</td>
                    <td>{{ $de->employee_qty }}</td>
                    <td style="text-align: right;"><b>{{ money_format($de->rate*$de->employee_qty) }}
                        <input type="hidden" class="total_amount" name="" value="{{ $de->rate*$de->employee_qty }}">
                        </b></td>
                </tr>
            @endforeach
            @endif
        </tbody>
        <tr style="font-weight: bold; text-align: right;">
            <td colspan="5">Grand Total = </td>
            <td class="ttotal_amount"></td>
        </tr>
    </table>
    {{--  <div>Total Amount(In Words): <b><i>One Lac Seventy Thousand taka only.</i></b></div>  --}}
    <br>
    <div>{{ $invoice_id->footer_note }}
    </div>
    <br>
    <div>Your Cooperation will be highly appreciated.</div>
    <br><br>
    With thanks & Regards
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
