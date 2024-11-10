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
                        <button type="button" class="btn btn-info my-1" onclick="printDivemp('result_show')">Print</button>
                    </div>
                </div>
                <div class="table-responsive" id="result_show">
                <table width="100%">
                    <tr>
                        <th width="45%" style="text-align: left;"><img src="{{ asset('assets/billcopy/logo.png') }}" height="80px" width="auto" alt="logo" srcset=""></th>

                        <td width="55%">
                            <h6 style="margin: 0; padding-left: 45px;">House #2, Lane #2, Road #2, Block-K,</h6>
                            <h6 style="margin: 0; padding-left: 45px;">Halishahar Housing Estate, Chattogram-4224</h6>
                            <h6 style="margin: 0; padding-left: 45px;">Tel: 02333323387, 02333328707</h6>
                            <h6 style="margin: 0; padding-left: 45px;">Mobile: 01844-040714, 01844-040717</h6>
                            <h6 style="margin: 0; padding-left: 45px;">Email: ctg@elitebd.com</h6>
                        </td>
                    </tr>
                </table>
                <div style="height: 2px; background-color: red; margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
                <table width="100%">
                    <tr>
                        @if ($inv->inv_subject != '')
                            <td width="40%" style="text-align: left;"></td>
                        @else
                            <td width="40%" style="text-align: left;">Bill for the Month of : <b>{{ \Carbon\Carbon::parse($inv->end_date)->format('F Y')}}</b></td>
                        @endif
                        <td width="30%"></td>
                        <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($inv->bill_date)->format('d/m/Y') }}</b></td>
                    </tr>
                </table>
                <div style="padding: 0 0px 0 0px; margin-top: 1rem;">
                <table width="100%">
                    <tr>
                        <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                        <td style="padding-bottom: 8px;">{{ $inv->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($inv->end_date)->format('y') }}/{{ $inv->id }}</td>
                    </tr>
                    <tr>
                        <td width="15%">To: @if($branch?->billing_person != '') <br>&nbsp;&nbsp; @else @endif</td>
                        <td>
                            <p style="padding:0; margin:0;">
                                @if ($inv->customer?->customer_type == 0)
                                <b>{{ $inv->customer?->billing_person }} </b>
                                @else
                                    @if($branch?->billing_person)
                                        <b>{{ $branch?->billing_person }} </b>
                                    @endif
                                @endif
                            </p>
                            <p style="margin:0;">
                                <b>{{ $inv->customer?->name }}</b>
                            </p>
                        </td>
                        @if($inv->customer?->bin)
                        <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $inv->customer?->bin }}</b></span></td>
                        @endif
                    </tr>
                    @if ($inv->customer?->customer_type == 0)
                    @else
                    <tr>
                        <td width="15%"></td>
                        <td colspan="2">{{ $branch?->brance_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td width="15%"></td>
                        <td colspan="2">
                            @if ($inv->customer?->customer_type == 0)
                                {!! nl2br(e(str_replace('^', "\n", $inv->customer?->address))) !!}
                            @else
                                @if($branch?->billing_address)
                                    {!! nl2br(e(str_replace('^', "\n", $branch?->billing_address))) !!}
                                @endif
                            @endif
                        </td>
                    </tr>
                    @if ($inv->customer?->customer_type == 0)
                        @if($inv->customer?->attention)
                        <tr>
                            <td style="padding-top: 8px;" width="15%">Attention:@if($inv->customer?->attention_details != '')<br>&nbsp;&nbsp; @endif</td>
                            <td colspan="2" style="padding-top: 8px;"><b>{{ $inv->customer?->attention }}</b><br>{{ $inv->customer?->attention_details }}</td>
                            
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
                        @if ($inv->inv_subject != '')
                            <td colspan="2" style="padding-top: 12px;"><b>{{$inv->inv_subject}}.</b></td>
                        @else
                            <td colspan="2" style="padding-top: 12px;"><b style="border-bottom: 2px solid;">Regarding payment of outstanding bills for Security Service provided until {{ \Carbon\Carbon::parse($inv->end_date)->format('F Y')}}.</b></td>
                        @endif
                    </tr>
                    <tr>
                        <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="padding-top: 8px; padding-bottom: 8px;">
                    {{ $inv->header_note }}
                </div>
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
                                $totalBill = 0;
                                $totalRec = 0;
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
                                    <td class="tbl_border">{{ \Carbon\Carbon::parse($de->bill_date)->format('M-Y') }}</td>
                                    <td class="tbl_border">{{ \Carbon\Carbon::parse($de->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($de->end_date)->format('d/m/Y') }}</td>
                                    <td class="tbl_border" style="text-align: center;">{{ money_format($de->grand_total) }}</td>
                                    <td class="tbl_border" style="text-align: center;">{{ money_format($de->received_amount) }}</td>
                                    <td class="tbl_border" style="text-align: center;">{{ money_format($de->due_amount) }}</td>
                                    <td class="tbl_border"><input type="text" class="input_css" value="" style="width: 230px;"></td>
                                </tr>
                                @php
                                    $totalBill += $de->grand_total;
                                    $totalRec += $de->received_amount;
                                    $totalDue += $de->due_amount;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="tbl_border">
                            <tr class="tbl_border" style="text-align: center;">
                                <td class="tbl_border"></td>
                                <th class="tbl_border" colspan="2">Grand Total</th>
                                <td class="tbl_border" style="text-align: center;"><b>{{ money_format($totalBill) }}</b></td>
                                <td class="tbl_border" style="text-align: center;"><b>{{ money_format($totalRec) }}</b></td>
                                <td class="tbl_border" style="text-align: center;"><b>{{ money_format($totalDue) }}</b></td>
                            </tr>
                        </tfoot>
                            
                    </table>
                    <div class="">
                        <p class="p-0 mb-4">As such, you are requested to please pay all our outstanding due amount of <b>Tk {{ money_format($totalDue) }}</b> within <input type="text" class="input_css" value="{{ \Carbon\Carbon::parse($inv->bill_date)->format('d/m/Y') }}" style="width: 72px;"> and oblige thereby.</p>
                        <p>With best regards</p>
                    </div>
                    {{-- <div class="mt-5 fixed-bottom"> --}}
                    <div class="mt-5">
                        <span><b>Showmic Paul</b></span><br>
                        <span>Senior Executive (Accounts & IT)</span><br>
                        <span>Cell: 01844-040717</span>
                    </div>
                    {{-- <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; margin-top:2rem;">
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
                    </div> --}}
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
            WinPrint.document.write('<style> table tr td, table tr th { font-size:13px !important; color: #000 !important; } h6 {color: #000 !important;} .red-line {height: 2px !important; background-color: red !important; margin-bottom: 0.5rem;} .black-line {height: 1px !important; background-color: #000 !important; margin-bottom: 0.5rem;} body { background-color: #ffff !important; color: #000 !important; } .no-print { display: none !important;} </style>');
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