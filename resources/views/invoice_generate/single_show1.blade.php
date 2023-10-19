<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
{{--  <button type="button" class="btn btn-info no-print" onclick="printDiv('result_show')">Print</button>  --}}
<body id="result_show">
    <div style="text-align: center;"><h2>BILL COPY</h2></div>
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
            <td width="40%" style="text-align: left;">Bill for Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}</b></td>
            <td width="30%"></td>
            <td width="30%" style="text-align: center;">Date : {{ $invoice_id->bill_date }}</td>
        </tr>
    </table>
    <div style="padding: 0 70px 0 80px;">

        <table width="100%">
            <tr>
                <td width="15%">Invoice No:</td>
                <td>ESSL/Mamiya/23/07-01</td>
            </tr>
            <tr>
                <td width="15%">To:</td>
                <td><b>{{ $invoice_id->customer?->name }}</b></td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>{{ $invoice_id->customer?->brance_name }}</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>{{ $invoice_id->customer?->billing_address }}</td>
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
                Reference to the above subject, We herewith submitted the security services bill for the period
                covering <b>{{ \Carbon\Carbon::parse($invoice_id->start_date)->format('d F Y') }} to {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('d F Y') }}.</b>
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
                    <th colspan="6">Sub Tatal</th>
                    <td>{{ money_format($invoice_id->sub_total_amount) }}</td>
                </tr>
                @if ($invoice_id->less)
                @foreach ($invoice_id->less as $le)
                <tr style="text-align: center;">
                    <td></td>
                    <td colspan="6">{{ $le->less_description }}</td>
                    <td>{{ $le->less_amount }}</td>
                </tr>
                @endforeach
                @endif
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="6">Tatal</th>
                    <td>{{ money_format($invoice_id->total_tk)}}</td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p>
                Total Amount in Words: <b>
                    @php
                    $dueTotal = $invoice_id->total_tk;

                    if ($dueTotal > 0) {
                        $textValue = getBangladeshCurrency($dueTotal);
                        echo "$textValue";
                    } else {
                        echo "Zero";
                    }
                @endphp
                .</b> <br>
                The payment may please be made in Cheques/Drafts/Cash in favor of <b>"Elite Security Services Limited"</b>
                by the 1<sup>st</sup> week of each month.
            </p>
            Your Cooperation will be highly appreciated.
            <p><i><b>With thanks of Regards</b></i></p>
        </div>
    </div>
    <table width="100%" style="padding-top: 5px;">
        <tr style="text-align: center;">
            <td>
                Md. Abu Rashel <br>
                Deputy Manager <br>
                Cell: 01844-040718
            </td>
            <td>
                Md. Mayan Uddin <br>
                 Manager <br>
                Cell: 01844-040714
            </td>
            <td>
                Anup Kumar Mutsddi <br>
                Senior Manager <br>
                (Accounts & Finance)
            </td>
        </tr>
    </table>
    <script>
        function printDiv(divName) {
            var prtContent = document.getElementById(divName);
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.onload =function(){
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            }
        }
    </script>
</body>
</html>
