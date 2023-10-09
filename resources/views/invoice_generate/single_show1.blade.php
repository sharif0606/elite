<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
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
            <td width="30%" style="text-align: center;">Date...................</td>
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
                <td><b>Mamiya-OP (Bangladesh) Ltd</b></td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>Plot No. 33-46, Sector-03, CEPZ, South Halishahar</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td>Chattogram-1223, Bangladesh.</td>
            </tr>
            <tr>
                <td width="15%"><b>Subject:</b></td>
                <td><b>Security Services Bill for the Month of July-2023</b></td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                <td></td>
            </tr>
        </table>
                <div>
                    Reference to the above subject, We herewith submitted the security services bill for the period
                    covering <b>21<sup>st</sup> June 2023 to 20<sup>th</sup> July-2023.</b>
                </div>

        <table border="1" width="100%" cellspacing="0">
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
            <tr style="text-align: center;">
                <td>01</td>
                <td>Security In-Charg</td>
                <td>20,076/-</td>
                <td>01</td>
                <th>23</th>
                <td>184</td>
                <td>109.10/-</td>
                <td>20,076/-</td>
            </tr>
            <tr style="text-align: center;">
                <td>02</td>
                <td>Security Supervisor</td>
                <td>15,600/-</td>
                <td>03</td>
                <th>23</th>
                <td>552</td>
                <td>84.78/-</td>
                <td>46,800/-</td>
            </tr>
            <tr style="text-align: center;">
                <td>03</td>
                <td>Receptionist</td>
                <td>14,676/-</td>
                <td>01</td>
                <th>23</th>
                <td>184</td>
                <td>79.76/-</td>
                <td>14,676/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <th colspan="6">Sub Tatal</th>
                <td>3,11,904/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <td colspan="6">Less: 02 duty absent of in-charge on 08-09/07/2023</td>
                <td>1,338/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <td colspan="6">Less: 02 duty absent of Receptionist on 17-18/07/2023</td>
                <td>978/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <td colspan="6">Less: 02 duty absent of Security Guard (B Grade) on 28-29/06/2023</td>
                <td>706/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <td colspan="6">Less: 02 duty absent of Security Guard (Female) on 19/07/2023</td>
                <td>400/-</td>
            </tr>
            <tr style="text-align: center;">
                <td></td>
                <th colspan="6">Tatal</th>
                <td>{{ money_format($invoice_id->grand_total)}}</td>
            </tr>
        </table>
        <div>
            <p>
                Total Amount in Words: <b>
                    @php
                    $dueTotal = $invoice_id->grand_total;

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
</body>
</html>
