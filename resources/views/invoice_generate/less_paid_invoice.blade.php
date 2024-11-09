@extends('layout.app')
@section('pageTitle','Less Paid Invoice')
@section('pageSubTitle','invoice')
@section('content')
<style>
    .input_css{
        border: none;
        outline: none;
    }
</style>
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-info my-1" onclick="printDiv('result_show')">Print</button>
                    </div>
                </div>
                <div class="table-responsive" id="result_show">
                    {{-- <table width="100%"style="padding: 2in 0px 30px 0px;">
                        <tr>
                            <td width="40%" style="text-align: left;">Bill for the Month of : <b></b></td>
                            <td width="30%"></td>
                            <td width="30%" style="text-align: right;">Date : <b></b></td>
                        </tr>
                    </table>
                        <div style="padding: 0 0px 0 0px;">
                        <table width="100%">
                            <tr>
                                <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                                <td style="padding-bottom: 8px;">{{ $cusName->invoice_number }}</td>
                            </tr>
                            <tr>
                                <td width="15%"></td>
                                <td colspan="2">
                                    @if ($cusName->customer_type == 0)
                                        {!! nl2br(e(str_replace('^', "\n", $cusName->address))) !!}
                                    @else
                                    @endif
                                </td>
                            </tr>
                            @if ($cusName->customer_type == 0)
                                @if($cusName->attention)
                                <tr>
                                    <td style="padding-top: 8px;" width="15%">Attention:@if($cusName->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                                    <td colspan="2" style="padding-top: 8px;"><b>{{ $cusName->attention }}</b><br>{{ $cusName->attention_details }}</td>
                                    
                                </tr>
                                @endif
                            @else
                            @endif
                            <tr>
                                <td colspan="2" style="padding-top: 12px;"><b>Security Services Bill for the Month of </b></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                                <div style="padding-top: 8px; padding-bottom: 8px;">
                                    header note
                                </div> --}}
                    <style>
                        .input_css{
                            border: none;
                            outline: none;
                        }
                        .tbl_border{
                        border: 1px solid;
                        border-collapse: collapse;
                        }
                    </style>
                    <table id="salaryTable" class="table tbl_border">
                        <tbody class="tbl_border">
                            @php
                                $sl = 1;
                                $totalDue = 0;
                            @endphp
                            <tr class="tbl_border text-center">
                                <th class="tbl_border">S.L</th>
                                <th class="tbl_border">Month</th>
                                <th class="tbl_border">Period</th>
                                <th class="tbl_border">Billing Amount</th>
                                <th class="tbl_border">Receive Amount</th>
                                <th class="tbl_border">Due</th>
                                <th class="tbl_border" style="width: 230px;">Remarks</th>
                            </tr>
                            @foreach ($result as $de)
                                <tr class="tbl_border" style="text-align: center;">
                                    <td  class="tbl_border">{{ $sl++  }}</td>
                                    <td class="tbl_border">{{ \Carbon\Carbon::parse($de->bill_date)->format('d/m/Y') }}</td>
                                    <td class="tbl_border">{{ \Carbon\Carbon::parse($de->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($de->end_date)->format('d/m/Y') }}</td>
                                    <td class="tbl_border" style="text-align: end;">{{ money_format($de->grand_total) }}</td>
                                    <td class="tbl_border" style="text-align: end;">{{ money_format($de->received_amount) }}</td>
                                    <td class="tbl_border" style="text-align: end;">{{ money_format($de->due_amount) }}</td>
                                    <td class="tbl_border"><input type="text" class="input_css" value="" style="width: 230px;"></td>
                                </tr>
                                @php
                                    $totalDue += $de->due_amount;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="tbl_border">
                            <tr class="tbl_border" style="text-align: center;">
                                <td class="tbl_border"></td>
                                <th class="tbl_border" colspan="4">Grand Total</th>
                                <td class="tbl_border" style="text-align: end;"><b>{{ money_format($totalDue) }}</b></td>
                            </tr>
                        </tfoot>
                            
                    </table>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; margin-top:2rem;">
                        @php
                            $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
                            $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
                            $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
                            @endphp
                        <div style="flex: 1; text-align: left; padding-right: 10px;">
                            {{ $footersetting1?->name }} <br>
                            {{ $footersetting1?->designation }} <br>
                            {{ $footersetting1?->phone }}
                        </div>
                        
                        <div style="flex: 1; text-align: center; padding-right: 10px;">
                            <div style="display: inline-block; text-align: left;">
                                {{ $footersetting2?->name }} <br>
                                {{ $footersetting2?->designation }} <br>
                                {{ $footersetting2?->phone }}
                            </div>
                            
                        </div>
                        
                        <div style="flex: 1; text-align: right;">
                            <div style="display: inline-block; text-align: left;">
                                {{ $footersetting3?->name }} <br>
                                {{ $footersetting3?->designation }} <br>
                                {{ $footersetting3?->phone }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function printDivemp(divName) {
            var prtContent = document.getElementById(divName).cloneNode(true);
            
            // Get all inputs within the div and update their values in the cloned content
            var inputs = prtContent.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type === 'text' || inputs[i].type === 'date') {
                    inputs[i].setAttribute('value', inputs[i].value);
                }
            }
            
            // Get all textareas within the div and update their text in the cloned content
            var textareas = prtContent.getElementsByTagName('textarea');
            for (var i = 0; i < textareas.length; i++) {
                textareas[i].innerHTML = textareas[i].value;
            }
            
            // Get all selects within the div and update their selected options in the cloned content
            var selects = prtContent.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                var selectedOption = selects[i].options[selects[i].selectedIndex];
                selectedOption.setAttribute('selected', 'selected');
            }

            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
            WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/pages/employee.css') }}" type="text/css"/>');
            WinPrint.document.write('<style> table tr td, table tr th { font-size:13px !important; } .police-vf-font{font-size: 13px;} .police-vf-foot-font{font-size: 9px;} .red-line {height: 2px !important; background-color: red !important; margin-bottom: 0.5rem;} .black-line {height: 1px !important; background-color: #000 !important; margin-bottom: 0.5rem;} body { background-color: #ffff !important; } .no-print { display: none !important;} </style>');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();

            WinPrint.onload = function () {
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            };
        }
    </script>
@endpush