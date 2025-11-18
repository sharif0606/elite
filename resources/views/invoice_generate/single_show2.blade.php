<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice_id->customer?->name }} for {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">

</head>
<body style="font-size: 16px !important;">
    @if($headershow==1)
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
    {{-- <hr class="hrcs" style="height: 1px; background-color: red;"> --}}
    {{-- <table width="100%"style="padding-left: 55px;">
        <tr>
            <td width="40%" style="text-align: left;">
                @if( $invoice_id->detail?->bonus_amount > 0)
                @else
                Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b>
                @endif
            </td>
            <td width="30%"></td>
            <td width="30%" style="text-align: center;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table> --}}
    <table width="100%">
        <tr>
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">
                    @if( $invoice_id->detail?->bonus_amount > 0)
                    Festival Bonus <b>({{$invoice_id->detail?->bonus_for==1?'EID UL FITR':'EID UL ADHA'}})</b> for the Year of <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('Y')}}</b>
                    @else
                    Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b>
                    @endif
                </td>
            @endif
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
            {{--  <td width="30%" style="text-align: center;">Date : {{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d F Y') }}</td>  --}}
        </tr>
    </table>
    @else
    <table width="100%"style="padding: 2in 0px 30px 0px;">
        {{-- <tr style="font-size: 20px; position: relative;">
            <td width="20%" style="text-align: left;"></td>
            <td style="position: absolute; top:-30px;" width="50%"><b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b></td>
            <td width="30%" style="text-align: center;  position: absolute; right:-60px; top:-30px;"><b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr> --}}
        <tr>
            @if ($invoice_id->inv_subject != '')
                <td width="40%" style="text-align: left;"></td>
            @else
                <td width="40%" style="text-align: left;">
                    {{--$invoice_id->details--}}
                    @if( $invoice_id->detail?->bonus_amount > 0)
                    Festival Bonus <b>({{$invoice_id->detail?->bonus_for==1?'EID UL FITR':'EID UL ADHA'}})</b> <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('Y')}}</b>
                    @else
                    Bill for the Month of : <b>{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}</b>
                    @endif  
                </td>
            @endif
            <td width="30%"></td>
            <td width="30%" style="text-align: right;">Date : <b>{{ \Carbon\Carbon::parse($invoice_id->bill_date)->format('d/m/Y') }}</b></td>
        </tr>
    </table>
    @endif
    @if($headershow==1)
        <div style="padding: 0 0px 0 0px; margin-top: 1rem;">
    @else
        <div style="padding: 0 0px 0 0px;">
    @endif
        <table width="100%">
            <tr>
                <td style="padding-bottom: 8px;" width="15%">Invoice No:</td>
                <td style="padding-bottom: 8px;">{{ $invoice_id->customer?->invoice_number }}/{{ \Carbon\Carbon::parse($invoice_id->end_date)->format('y') }}/{{ $invoice_id->id }}</td>
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
                        <b>{{ $invoice_id->customer?->name }}</b>
                    </p>
                </td>
                @if($invoice_id->customer?->bin)
                <td  width="40%" style="text-align: center; padding-bottom: 5px;"> <span style="padding: 7px; border: 2px solid; border-radius: 5px;">BIN NO : <b>{{ $invoice_id->customer?->bin }}</b></span></td>
                @endif
            </tr>
            @if ($invoice_id->customer?->customer_type == 0)
            @else
            <tr>
                <td width="15%"></td>
                <td colspan="2">{{ $branch?->brance_name }}</td>
            </tr>
            @endif
            {{$invoice_id->customer?->customer_type}}
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
                    <td colspan="2" style="padding-top: 12px;">
                        @if( $invoice_id->detail?->bonus_amount > 0)
                        Festival Bonus  Bill for ({{$invoice_id->detail?->bonus_for==1?'EID UL FITR':'EID UL ADHA'}}) of security personnel.
                        @else
                        <b>Security Services Bill for the Month of {{ \Carbon\Carbon::parse($invoice_id->end_date)->format('F Y')}}.</b>
                        @endif
                    </td>
                @endif
            </tr>
            <tr>
                <td style="padding-top: 8px;" width="15%" style="padding:5px 0 0px 0;">Dear Sir,</td>
                <td></td>
                <td></td>
            </tr>
        </table>
                <div style="padding-top: 8px; padding-bottom: 8px;">
                    @if( $invoice_id->detail?->bonus_amount > 0)
                    Reference to the above subject, We herewith submit the security services festival bonus bill along with Chalan copy.
                    @else
                    {{ $invoice_id->header_note }}
                    @endif
                </div>

        <table border="1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>Service</th>
                    @if($invoice_id->customer_id == 74)
                    <th>Take Home Salary</th>
                    <th>Material Support Cost</th>
                    <th>Reliever Cost</th>
                    <th>OverHead & Service Charge</th>
                    @endif

                    @if($invoice_id->customer_id == 13)
                    <th>Take Home Salary</th>
                    <th>Agency Commission</th>
                    <th>Person</th>
                    @else
                    <th>{{ $invoice_id->customer_id == 74 ? 'Total Rate' : 'Rate' }} {{ $invoice_id->customer?->inv_vat_note }}</th>
                    <th>Period</th>
                    <th>Person</th>
                    @endif
                    
                    @if( $invoice_id->detail?->bonus_amount > 0)
                    <th>Bonus Rate</th>
                    @endif
                    <th>Total Amount (BDT)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                @endphp
                @if ($invoice_id->details)
                    @foreach ($invoice_id->details as $de)
                        @if ($de->rate > 0 || $de->employee_qty > 0)
                            <tr style="text-align: center;">
                                <td >{{ $sl++  }}</td>
                                <td>{{ $de->jobpost?->name }}
                                    <br/>
                                    {{ $de->atms?->atm }}
                                </td>
                                @if($invoice_id->customer_id == 74)
                                <td>{{$de->take_home_salary}}</td>
                                <td>{{$de->material_support_cost}}</td>
                                <td>{{$de->reliver_cost}}</td>
                                <td>{{$de->overhead_service_charge}}</td>
                                @endif
                                @if($invoice_id->customer_id == 13)
                                <td>{{$de->take_home_salary}}</td>
                                <td>{{$de->agency_com}}</td>
                                @endif
                                @if($invoice_id->customer_id !=13)
                                <td>
                                    @if($invoice_id->customer_id == 74 && $de->type==2 )
                                    {{$de->rate_per_houres}} Per Hour
                                    @else
                                        {{ $de->rate }} <br/>
                                        @if ($de->divide_by == 1)
                                            (Per shift)
                                        @else
                                            @if($de->type_houre )
                                                ({{ (int)$de->hours?->hour }} hourly shift per month)
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>
                                @if($de->bonus_amount > 0)
                                -
                                @else
                                    @php
                                        $start = \Carbon\Carbon::parse($de->st_date);
                                        $end   = \Carbon\Carbon::parse($de->ed_date);
                                    @endphp
                                    @if($start->isSameDay($end))
                                        {{ $start->format('d/m/Y') }}
                                    @else
                                        {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}
                                    @endif
                                @endif
                                </td>
                                @endif
                                <td>
                                    @if($invoice_id->customer_id == 74 && $de->type==2)
                                        {{$de->total_houres}} hrs
                                    @else
                                        {{ $de->employee_qty }}<br>
                                        @if ($de->duty_day > 0 && $de->total_houres > 0)
                                            @if ($de->duty_day > 1)
                                                ({{ (int) $de->duty_day }} duties)
                                            @else
                                                ({{ (int) $de->duty_day }} duty)
                                            @endif
                                        @elseif($de->duty_day > 0 && $de->total_houres == '')
                                            @if ($de->duty_day > 1)
                                                ({{ (int) $de->duty_day }} duties)
                                            @else
                                                ({{ (int) $de->duty_day }} duty)
                                            @endif
                                        @elseif($de->duty_day == '' && $de->total_houres > 0)
                                            ({{ (int) $de->total_houres }} duty hours)
                                        @else
                                        @endif
                                    @endif
                                </td>
                                
                                @if($de->bonus_amount > 0)
                                <td>
                                    {{$de->bonus_type == 2 ? $de->bonus_rate.'%':$de->bonus_rate}}
                                </td>
                                @endif
                              
                                <td style="text-align: end;">{{ money_format($de->total_amounts) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                @php $totalAddLess=0; @endphp
                @if($invoice_id->sub_total_amount)
                    <tr style="text-align: center;">
                        <td></td>
                        @if($invoice_id->customer_id == 74)
                        <th colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:8}}">Sub Total</th>
                        @else
                        <th colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:4}}">Sub Total</th>
                        @endif
                        <td style="text-align: end;"><b>{{ money_format($invoice_id->sub_total_amount) }}</b></td>
                    </tr>
                @endif
                {{--  @if ($invoice_id->less)  --}}
                @if (isset($invoice_id->less) && $invoice_id->less)
                    @foreach ($invoice_id->less as $le)
                        <tr style="text-align: center;">
                            <td></td>

                            <td colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:4}}">{{ $le->description }}</td>
                            <td style="text-align: end;"><b>{{ money_format($le->amount) }}</b></td>
                        </tr>
                        @php $totalAddLess += $le->amount; @endphp
                    @endforeach
                @endif
                @if ($totalAddLess != 0)
                    <tr style="text-align: center;">
                    <td></td>
                    <th colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:4}}">Total</th>
                    <td style="text-align: end;"><b>{{ money_format($invoice_id->total_tk)}}</b></td>
                </tr> 
                @endif
                @if($invoice_id->vat>0)
                    <tr style="text-align: center;">
                        <td></td>
                        <td colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:4}}">Vat@ {{ $invoice_id->vat }} %</td>
                        <td style="text-align: end;">{{ money_format($invoice_id->vat_taka) }}</td>
                    </tr>
                <tr style="text-align: center;">
                    <td></td>
                    <th colspan="{{$invoice_id->detail?->bonus_amount > 0 ?5:4}}">Grand Total</th>
                    <td style="text-align: end;"><b>{{ money_format($invoice_id->grand_total) }}</b></td>
                </tr>
                @endif
            </tfoot>
        </table>
        <div>
            <p>Total Amount In Words:<b>
                @php
                $dueTotal = $invoice_id->grand_total;

                if ($dueTotal > 0) {
                    $textValue = getBangladeshCurrency($dueTotal);
                    echo "$textValue";
                } else {
                    echo "Zero";
                }
            @endphp
                </b> <br><br>
                @php
                    $footer_note = $invoice_id->footer_note;
                    $bolded_note = preg_replace('/"(.*?)"/', '<b>"$1"</b>', $footer_note);
                @endphp
                {!! $bolded_note !!}
            </p>
            Your Cooperation will be highly appreciated.
            <p><i><b>With thanks and Regards</b></i></p>
        </div>
    </div>
    <table width="100%" style="padding-top: 5px;">
        <tr style="text-align: left;">
            @php
            $footersetting1= App\Models\Settings\InvoiceSetting::where('id',1)->first();
            $footersetting2= App\Models\Settings\InvoiceSetting::where('id',2)->first();
            $footersetting3= App\Models\Settings\InvoiceSetting::where('id',3)->first();
            @endphp
            {{--  <td>
                {{ $footersetting1?->name }} <br>
                {{ $footersetting1?->designation }} <br>
                Cell: {{ $footersetting1?->phone  }}
            </td>
            <td style="text-align: left; float: center;">
                {{ $footersetting2?->name }} <br>
                {{ $footersetting2?->designation }} <br>
                Cell: {{ $footersetting2?->phone  }}
            </td>
            <td  style="text-align: left; float: right;">
                {{ $footersetting3?->name }} <br>
                {{ $footersetting3?->designation }} <br>
                {{ $footersetting3?->phone  }}
            </td>  --}}

        </tr>
    </table>
    @if($headershow==1)
        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left;">
    @else
        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; text-align: left; margin-top:2rem;">
    @endif
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
    
    {{-- <div style="text-align: center; margin-top:2rem;">
        <div style="width: 200px; float: left; text-align: left;">
            @if($headershow==1)
                @if ($footersetting1->signature != '')
                    <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting1->signature)}}" class="my-1" width="100px" alt=""><br>
                @endif
            @endif
            {{ $footersetting1?->name }} <br>
            {{ $footersetting1?->designation }} <br>
            {{ $footersetting1?->phone  }}
        </div>
        <div style="width: 200px; float: right; text-align: left;">
            @if($headershow==1)
                @if ($footersetting3->signature != '')
                    <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting3->signature)}}" class="my-1" width="100px" alt=""><br>
                @endif
            @endif
            {{ $footersetting3?->name }} <br>
            {{ $footersetting3?->designation }} <br>
            {{ $footersetting3?->phone  }}
        </div>
        <div style="width: 200px; margin-left: auto; margin-right: auto; text-align: left;">
            @if($headershow==1)
                @if ($footersetting2->signature != '')
                    <img src="{{asset('uploads/invoice/signatureImg/'.$footersetting2->signature)}}" class="my-1" width="100px" alt=""><br>
                @endif
            @endif
            {{ $footersetting2?->name }} <br>
            {{ $footersetting2?->designation }} <br>
            {{ $footersetting2?->phone  }}
        </div>
    </div> --}}
</body>
</html>
