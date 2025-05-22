<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    @media print {
        /* @page {
            margin: 20mm;
        }
        .invoice-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            page-break-before: always;
        }
        .invoice-body {
            margin-top: 220px;
        }
        body {
            margin-top: 200px;
        } */
        .no-print{
            display: none;
        }
    }
</style>

<body>
    <div style="text-align: center;">
        <button class="no-print" onclick="get_print()" style="background-color: transparent; color:green; padding: 5px; border:2px solid green; font-size: 1.3rem;"><i class="bi bi-file-spreadsheet-fill" style="font-size: 1.2rem;"></i>Excel</button>
    </div>
    <div id="result_show">
    @if($headershow==1)
    <div class="invoice-header">
    <div style="text-align: center;"><h2><span style="border-bottom: solid 1px;">INVOICE</span></h2></div>
    <table width="100%">
        <tr>
            <th width="45%" style="text-align: left;"><img src="{{ asset('assets/billcopy/logo.png') }}" height="90px" width="auto" alt="logo" srcset=""></th>

            <td width="55%">
                <h4 style="margin: 0; padding-left: 45px;">House #2, Lane #2, Road #2, Block-K,</h4>
                <h4 style="margin: 0; padding-left: 45px;">Halishahar Housing Estate, Chattogram-4224</h4>
                <h4 style="margin: 0; padding-left: 45px;">Tel: 02333323387, 02333328707</h4>
                <h4 style="margin: 0; padding-left: 45px;">Mobile: 01844-040714, 01844-040717</h4>
                <h4 style="margin: 0; padding-left: 45px;">Email: ctg@elitebd.com</h4>
            </td>
        </tr>
    </table>
    <div style="height: 2px; background-color: red; margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
    <table width="100%">
        <tr>
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            @endif
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
            {{--  <td width="30%" style="text-align: center;">Date : {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d F Y') }}</td>  --}}
        </tr>
    </table>
    </div>
    @else
    <div class="invoice-header">
    <table width="100%"style="padding: 0px 0px 30px 0px;">
        {{-- <tr style="font-size: 20px; position: relative;">
            <td width="20%" style="text-align: left;"></td>
            <td style="position: absolute; top:-30px;" width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            <td width="30%" style="text-align: center;  position: absolute; right:-60px; top:-30px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr> --}}
        <tr>
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            @endif
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table>
    </div>
    @endif
    {{-- <table width="100%" style="margin-top: 2.2in; font-size: 20px;">
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
    </table>
    <br>
    <div>Subject:   <b> Security Service bill for the month of {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('F Y')}}.</b></div>
    <br>
    <div>Dear Sir,</div>
    <br>
    <div>Reference to the above subject, we herewith submitted the security services bill
        and account number at Prime Bank, Halisahar Branch.</div>
    <br> --}}
    <div class="invoice-body">
    @if($headershow==1)
        <table width="100%" style="margin-top: 1rem;">
    @else
        <table width="100%">
    @endif
        <tr>
            <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
            <td style="padding-bottom: 8px;">{{ $invoiceNo ?? '' }}</td>
        </tr>
        <tr>
            <td width="15%">To: @if($branch?->billing_person != '') <br>&nbsp;&nbsp; @else @endif</td>
            <td>
                <p style="padding:0; margin:0;">
                    @if ($invoice_id->customer?->customer_type == 0)
                    <b>{{ $invoice_id->customer?->billing_person }} </b>
                    @else
                        @if($branch?->billing_person)
                            <b>{{ $branch?->billing_person }} </b>
                        @endif
                    @endif
                </p>
                <p style="margin:0;">
                    <b>{{ $invoice_id->customer?->name }}</b> </br>
                    {{-- {{ $invoice_id->customer?->id }} {{ $invoice_id->company_branch_id }} --}}
                    {{-- {{ $branch?->brance_name }}</br>
                    {{ $invoice_id->atm?->atm }} --}}
                </p>
            </td>
            @if($invoice_id->customer?->bin)
            <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
            @endif
        </tr>
        {{-- @if($headershow!=2) --}}
        @if ($invoice_id->customer?->customer_type == 0)
        @else
        <tr>
            <td width="15%"></td>
            <td colspan="2">{{ $branch?->brance_name }}</td>
        </tr>
        {{-- @endif --}}

        <tr>
            <td width="15%"></td>
            <td colspan="2">
                @if ($invoice_id->customer?->customer_type == 0)
                    {!! nl2br(e(str_replace('^', "\n", $invoice_id->customer?->address))) !!}
                @else
                    @if($branch?->billing_address)
                        {!! nl2br(e(str_replace('^', "\n", $branch?->billing_address))) !!}
                    @endif
                @endif
            </td>
        </tr>
        @endif
        @if ($invoice_id->customer?->customer_type == 0)
            @if($invoice_id->customer?->attention)
            <tr>
                <td style="padding-top: 8px;" width="15%">Attention:@if($invoice_id->customer?->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                <td colspan="2" style="padding-top: 8px;"><b>{{ $invoice_id->customer?->attention }}</b><br>{{ $invoice_id->customer?->attention_details }}</td>

            </tr>
            @endif
        @else
            @if($branch?->attention)
            <tr>
                <td style="padding-top: 8px;" width="15%">Attention: @if($branch?->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                <td colspan="2" style="padding-top: 8px;"><b>{{ $branch?->attention }}</b><br>{{ $branch?->attention_details }}</td>
            </tr>
            @endif
        @endif
        <tr>
            <td style="padding-top: 12px;" width="15%"><b>Subject:</b></td>
            @if ($invoice_id->inv_subject != '')
                <td colspan="2" style="padding-top: 12px;"><b>{{$invoice_id->inv_subject}}.</b></td>
            @else
                <td colspan="2" style="padding-top: 12px;"><b>Security Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}.</b></td>
            @endif
        </tr>
        <tr>
            <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
            <td></td>
            <td></td>
        </tr>
    </table>
            <div style="padding-top: 8px; padding-bottom: 8px;">
                @php
                    $header_note = $invoice_id->header_note;
                    $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $header_note);
                @endphp
                {!! $bolded_note !!}
            </div>

            @if ($wasa?->wasadetails)
            <table width="100%" border="1" cellspacing="0" id="invoiceTable">
                <tr>
                    <th width="3%">S.L</th>
                    <th width="8%">ID No</th>
                    <th width="8%">Rank</th>
                    <th width="14%">Area</th>
                    <th width="34%">Name of the Security Person</th>
                    <th width="6%" >Duty </th>
                    <th width="15%" >Account Number</th>
                    <th width="13%">Salary Amount (BDT)</th>
                </tr>
                @foreach ($wasa->wasadetails->sortBy('area') as $de)
                    <tr>
                        <td style="text-align: center;">{{ str_pad(++$loop->index, 2, '0', STR_PAD_LEFT) }}</td>
                        <td style="text-align: center;">{{ $de->employee ? $de->employee->admission_id_no : '' }}</td>
                        <td style="text-align: center;">{{ $de->jobpost ? $de->jobpost->name : '' }}</td>
                        <td style="text-align: center;">{{ $de->area }}</td>
                        <td style="text-align: center;">{{ $de->employee ? $de->employee->en_applicants_name : '' }}</td>
                        <td style="text-align: center;">{{ $de->duty }}</td>
                        <td style="text-align: center;">
                            @if ($de->account_no != '')
                                {{ $de->account_no }}
                            @else
                                {{ $de->employee ? $de->employee->second_ac_no : '' }}
                            @endif
                        </td>
                        <td style="text-align: end;">{{ money_format($de->salary_amount) }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <th></th>
                        <th colspan="6">Sub Total</th>
                        <th style="text-align: right;">{{ money_format($wasa?->sub_total_salary) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="6">Add: Commission {{ (int)$wasa?->add_commission }}%</th>
                        <th style="text-align: right;">{{ money_format($wasa?->add_commission_tk) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="6">{{ (int)$wasa?->vat_on_commission }}% VAT+ {{ (int)$wasa?->ait_on_commission }}% AIT = {{ (int)$wasa?->vat_ait_on_commission }}% on Commission</th>
                        <th style="text-align: right;">{{ money_format($wasa?->vat_ait_on_commission_tk) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="6">VAT {{ (int)$wasa?->vat_on_subtotal }}% on Sub Total</th>
                        <th style="text-align: right;">{{ money_format($wasa?->vat_on_subtotal_tk) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="6">AIT {{ (int)$wasa?->ait_on_subtotal }}% on Sub Total</th>
                        <th style="text-align: right;">{{ money_format($wasa?->ait_on_subtotal_tk) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="6">Grand Total</th>
                        <th style="text-align: right;">{{ money_format($wasa?->grand_total_tk) }}</th>
                    </tr>
                    <tr>
                        <td colspan="8">Total Amount(In Words): <b><i>
                            @php
                            $dueTotal = $wasa?->grand_total_tk;

                            if ($dueTotal > 0) {
                                $textValue = getBangladeshCurrency($dueTotal);
                                echo "$textValue";
                            } else {
                                echo "Zero";
                            }
                        @endphp
                            </i></b></td>

                    </tr>

                </table>
            @elseif ($wasa?->details)
                <table width="100%" border="1" cellspacing="0" id="invoiceTable">
                    <tr>
                        <th >S.L</th>
                        <th >Location</th>
                        <th >Rate Per Guard <br> (Per Month)</th>
                        <th >Period</th>
                        <th>Person</th>
                        <th>Total Amount</th>
                    </tr>
                    <tr>
                        <td style="text-align: center;">01</td>
                        <td style="text-align: center;">
                            {{ $wasa->details->first()->jobpost ? $wasa->details->first()->jobpost->name : '' }}
                            at {{
                                $invoice_id->atm?->atm
                            }}
                        </td>
                        <td style="text-align: center;">
                            {{ $wasa->details->first()->salary_amount ? money_format($wasa->details->first()->salary_amount) : '' }}
                        </td>
                        <td style="text-align: center;">
                            01 (One Month)
                        </td>
                        <td style="text-align: center;">
                            {{ $wasa->details->count() }}
                        </td>
                        <td  style="text-align: end;">
                            {{ money_format($wasa->details->first()->salary_amount * $wasa->details->count()) }}
                        </td>
                    </tr>
                @foreach ($wasa->details as $de)
                    <tr>
                        <td style="text-align: center;">{{ str_pad(++$loop->index +1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td style="text-align: center;">{{ $de->employee ? $de->employee->en_applicants_name : '' }}</td>
                        <td style="text-align: center;">ID No:{{ $de->employee ? $de->employee->admission_id_no : '' }}</td>
                        {{-- <td style="text-align: center;">{{ $de->jobpost ? $de->jobpost->name : '' }}</td> --}}
                        <td style="text-align: center;">
                            Cell: {{ $de->employee ? $de->employee->bn_parm_phone_my : '' }}
                        </td>
                        <td style="text-align: center;">{{ $de->shift==1 ? 'Shift-A' :  ($de->shift== 2 ? 'Shift-B' : 'Shift-C')}}</td>
                        {{-- <td style="text-align: center;">{{ $de->duty }}</td> --}}
                        <td style="text-align: end;">-</td>
                    </tr>
                @endforeach
            {{-- <tr>
                <th></th>
                <th colspan="4">Sub Total</th>
                <th style="text-align: right;">{{ money_format($wasa?->sub_total_salary) }}</th>
            </tr> --}}
            {{-- <tr>
                <th></th>
                <th colspan="4">Add: Commission {{ (int)$wasa?->add_commission }}%</th>
                <th style="text-align: right;">{{ money_format($wasa?->add_commission_tk) }}</th>
            </tr> --}}
            {{-- <tr>
                <th></th>
                <th colspan="4">{{ (int)$wasa?->vat_on_commission }}% VAT+ {{ (int)$wasa?->ait_on_commission }}% AIT = {{ (int)$wasa?->vat_ait_on_commission }}% on Commission</th>
                <th style="text-align: right;">{{ money_format($wasa?->vat_ait_on_commission_tk) }}</th>
            </tr> --}}
            <tr>
                <th></th>
                <th colspan="4">VAT {{ (int)$wasa?->vat_on_subtotal }}%</th>
                <th style="text-align: right;">{{ money_format($wasa?->vat_on_subtotal_tk) }}</th>
            </tr>
            {{-- <tr>
                <th></th>
                <th colspan="4">AIT {{ (int)$wasa?->ait_on_subtotal }}% on Sub Total</th>
                <th style="text-align: right;">{{ money_format($wasa?->ait_on_subtotal_tk) }}</th>
            </tr> --}}
            <tr>
                <th></th>
                <th colspan="4">Total</th>
                <th style="text-align: right;">{{ money_format($wasa?->grand_total_tk) }}</th>
            </tr>
            <tr>
                <td colspan="6">Total Amount(In Words): <b><i>
                    @php
                    $dueTotal = $wasa?->grand_total_tk;

                    if ($dueTotal > 0) {
                        $textValue = getBangladeshCurrency($dueTotal);
                        echo "$textValue";
                    } else {
                        echo "Zero";
                    }
                @endphp
                    </i></b></td>

            </tr>

        </table>
            @endif

    <br>
    <div>
        @php
            $footer_note = $invoice_id->footer_note;
            $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $footer_note);
        @endphp
        {!! $bolded_note !!}
        </div>
    <br><br>
    <p><i><b>With thanks and Regards</b></i></p>
    <br><br>
    @php
        $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
        $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
        $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
    @endphp
    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; ">
        <div style="flex: 1; text-align: left; padding-right: 10px;">
            {{-- Align left side of the body --}}
            @if($headershow==1)
                @if ($footersetting1->signature != '')
                    <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting1->signature) }}" class="my-1" width="100px" alt=""><br>
                @endif
            @endif
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            {{ $footersetting1?->phone }}
        </div>

        <div style="flex: 1; text-align: center; padding-right: 10px;">
            {{-- Align center of the body --}}
            <div style="display: inline-block; text-align: left;">
                @if($headershow==1)
                    @if ($footersetting2->signature != '')
                        <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting2->signature) }}" class="my-1" width="100px" alt=""><br>
                    @endif
                @endif
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                {{ $footersetting2?->phone }}
            </div>
        </div>

        <div style="flex: 1; text-align: right;">
            {{-- Align right side of the body but content left-aligned --}}
            <div style="display: inline-block; text-align: left;">
                @if($headershow==1)
                    @if ($footersetting3->signature != '')
                        <img src="{{ asset('uploads/invoice/signatureImg/'.$footersetting3->signature) }}" class="my-1" width="100px" alt=""><br>
                    @endif
                @endif
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone }}
            </div>
        </div>
    </div>
    {{-- <table width="100%" style="margin-top:1.5rem;">
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
    </table> --}}
</div>
</div>
<div class="full_page"></div>
<div id="my-content-div" class="d-none"></div>
<script src="{{ asset('/assets/js/tableToExcel.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function exportReportToExcel(tableId, filename) {
        let table = document.getElementById(tableId);
        let tableToExport = table.cloneNode(true);

        // Export the table as it is without removing any columns
        TableToExcel.convert(tableToExport, {
            name: `${filename}.xlsx`,
            sheet: {
                name: 'Invoice'
            }
        });

        $("#my-content-div").html("");
        $('.full_page').html("");
    }

    function get_print() {
        $('.full_page').html('<div style="background:rgba(0,0,0,0.5);width:100vw; height:100vh;position:fixed; top:0; left;0"><div class="loader my-5"></div></div>');

        $.get("{{route('invoiceShow7',[encryptor('encrypt',$invoice_id->id),'header' =>$headershow])}}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('invoiceTable', 'Invoice of-{{$invoice_id->customer?->name}}-{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}');
        });
    }
</script>
</body>

</html>
