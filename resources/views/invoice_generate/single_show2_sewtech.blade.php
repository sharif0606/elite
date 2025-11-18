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

        <table border="1" width="100%" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: center; padding: 8px;">S.L</th>
                    <th style="text-align: left; padding: 8px;">Particulars</th>
                    <th style="text-align: center; padding: 8px;">Total Bill<br>(BDT)</th>
                    <th style="text-align: center; padding: 8px;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                    $totalSalaryBill = 0;
                    $totalChargePF = 0;
                    $netBillAmount = 0;
                    $deductionAmount = 0;
                    
                    // Get all less items and details items
                    $lessItems = $invoice_id->less ?? collect();
                    $detailsItems = $invoice_id->details ?? collect();
                    
                    // Combine both less and details items
                    // Priority: details items first (they have rate/duty_day), then less items
                    $itemsToProcess = collect();
                    $processedDescriptions = [];
                    
                    // First, add all details items (convert to similar format)
                    foreach ($detailsItems as $detail) {
                        $detailDesc = strtolower(trim($detail->jobpost?->name ?? 'Service'));
                        $itemObj = (object)[
                            'description' => $detail->jobpost?->name ?? 'Service',
                            'amount' => $detail->total_amounts ?? 0,
                            'id' => $detail->id ?? null,
                            'rate' => $detail->rate ?? 0,
                            'employee_qty' => $detail->employee_qty ?? 0,
                            'duty_day' => $detail->duty_day ?? 0,
                            'original_detail' => $detail, // Store original detail for calculations
                        ];
                        $itemsToProcess->push($itemObj);
                        $processedDescriptions[] = $detailDesc;
                    }
                    
                    // Then, add less items that don't duplicate details items
                    foreach ($lessItems as $lessItem) {
                        $lessDesc = strtolower(trim($lessItem->description ?? ''));
                        // Only add if not already processed from details
                        if (!in_array($lessDesc, $processedDescriptions)) {
                            $itemsToProcess->push($lessItem);
                            $processedDescriptions[] = $lessDesc;
                        }
                    }
                    
                    // Define the order of items based on the image
                    $orderedItems = [];
                    $otherItems = [];
                    
                    foreach ($itemsToProcess as $item) {
                        $desc = strtolower(trim($item->description ?? ''));
                        
                        if (strpos($desc, 'paid in wages') !== false || (strpos($desc, 'wages') !== false && strpos($desc, 'backup') === false && strpos($desc, 'service') === false)) {
                            if (!isset($orderedItems['wages'])) {
                                $orderedItems['wages'] = $item;
                            } else {
                                $otherItems[] = $item;
                            }
                        } elseif (strpos($desc, 'additional backup guard') !== false || (strpos($desc, 'backup guard') !== false) || (strpos($desc, 'backup') !== false && strpos($desc, 'wages') !== false)) {
                            $orderedItems['backup'] = $item;
                        } elseif (strpos($desc, 'employee advance') !== false || strpos($desc, 'loan') !== false || strpos($desc, 'tanning') !== false || strpos($desc, 'advance') !== false) {
                            $orderedItems['advance'] = $item;
                        } elseif (strpos($desc, 'service charge') !== false || (strpos($desc, 'service') !== false && strpos($desc, 'charge') !== false)) {
                            $orderedItems['service_charge'] = $item;
                        } elseif (strpos($desc, 'insurance') !== false) {
                            $orderedItems['insurance'] = $item;
                        } elseif (strpos($desc, 'uniform') !== false) {
                            $orderedItems['uniform'] = $item;
                        } elseif (strpos($desc, 'provident fund') !== false && (strpos($desc, 'supervisor') !== false || strpos($desc, 'sup') !== false)) {
                            $orderedItems['pf_supervisor'] = $item;
                        } elseif (strpos($desc, 'provident fund') !== false && (strpos($desc, 'guard') !== false)) {
                            $orderedItems['pf_guard'] = $item;
                        } elseif (strpos($desc, 'deduction commission') !== false || strpos($desc, 'vacant post') !== false || strpos($desc, 'deduction') !== false) {
                            // For deductions, allow multiple entries
                            if (!isset($orderedItems['deduction'])) {
                                $orderedItems['deduction'] = $item;
                            } else {
                                $otherItems[] = $item;
                            }
                        } else {
                            $otherItems[] = $item;
                        }
                    }
                @endphp
                
                {{-- Row 1: Paid in Wages --}}
                @if(isset($orderedItems['wages']))
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $orderedItems['wages']->description }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($orderedItems['wages']->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalSalaryBill += $orderedItems['wages']->amount; @endphp
                @endif
                
                {{-- Row 2: Additional Backup Guard Wages --}}
                @if(isset($orderedItems['backup']))
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $orderedItems['backup']->description }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($orderedItems['backup']->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalSalaryBill += $orderedItems['backup']->amount; @endphp
                @endif
                
                {{-- Row 3: Employee Advance/Loan/Tanning Fee --}}
                @if(isset($orderedItems['advance']))
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $orderedItems['advance']->description }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($orderedItems['advance']->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalSalaryBill += $orderedItems['advance']->amount; @endphp
                @endif
                
                {{-- Subtotal: Total Bill for Salary --}}
                @php
                    // Count how many salary items we've displayed
                    $salaryItemsCount = 0;
                    if(isset($orderedItems['wages'])) $salaryItemsCount++;
                    if(isset($orderedItems['backup'])) $salaryItemsCount++;
                    if(isset($orderedItems['advance'])) $salaryItemsCount++;
                @endphp
                @if($salaryItemsCount > 0)
                    <tr style="background-color: #f0f0f0;">
                        <td style="text-align: center; padding: 8px;"></td>
                        <td style="text-align: left; padding: 8px;"><b>Total Bill for Salary</b></td>
                        <td style="text-align: right; padding: 8px;"><b>{{ money_format($totalSalaryBill) }}</b></td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                @endif
                
                {{-- Row 4: Total Service charge --}}
                @if(isset($orderedItems['service_charge']))
                    @php
                        $item = $orderedItems['service_charge'];
                        $desc = $item->description ?? '';
                        
                        // Get rate and duty_day from item or original_detail
                        $rate = $item->rate ?? 0;
                        $dutyDay = $item->duty_day ?? ($item->employee_qty ?? 0);
                        
                        // If rate/duty_day not available, try to get from original_detail
                        if (($rate == 0 || $dutyDay == 0) && isset($item->original_detail)) {
                            $rate = $item->original_detail->rate ?? $rate;
                            $dutyDay = $item->original_detail->duty_day ?? ($item->original_detail->employee_qty ?? $dutyDay);
                        }
                        
                        // If still not available and we have details, try to find matching detail
                        // For service charge, we might need to sum up or find the right detail record
                        if (($rate == 0 || $dutyDay == 0) && isset($invoice_id->details)) {
                            $totalRate = 0;
                            $totalDutyDay = 0;
                            $foundDetails = 0;
                            foreach ($invoice_id->details as $detail) {
                                $detailDesc = strtolower(trim($detail->jobpost?->name ?? ''));
                                if (strpos($detailDesc, 'service charge') !== false || strpos($detailDesc, 'service') !== false) {
                                    $detailRate = $detail->rate ?? 0;
                                    $detailDutyDay = $detail->duty_day ?? ($detail->employee_qty ?? 0);
                                    if ($detailRate > 0 || $detailDutyDay > 0) {
                                        // If we find a detail with both rate and duty_day, use it
                                        if ($detailRate > 0 && $detailDutyDay > 0) {
                                            $rate = $detailRate;
                                            $dutyDay = $detailDutyDay;
                                            break;
                                        }
                                        // Otherwise accumulate
                                        $totalRate += $detailRate;
                                        $totalDutyDay += $detailDutyDay;
                                        $foundDetails++;
                                    }
                                }
                            }
                            // If we accumulated values, use averages or totals
                            if ($rate == 0 && $dutyDay == 0 && $foundDetails > 0) {
                                $rate = $totalRate > 0 ? ($totalRate / $foundDetails) : 0;
                                $dutyDay = $totalDutyDay > 0 ? $totalDutyDay : 0;
                            }
                        }
                        
                        // Fallback: Calculate duty_day from amount / rate if duty_day is 0 or 1.0 (default value)
                        if ($rate > 0 && ($dutyDay == 0 || $dutyDay == 1.0) && $item->amount > 0) {
                            $calculatedDutyDay = $item->amount / $rate;
                            // Only use calculated value if it makes sense (greater than 0.1)
                            if ($calculatedDutyDay > 0.1) {
                                $dutyDay = $calculatedDutyDay;
                            }
                        }
                        
                        $calcText = '';
                        // Only add calculation if description doesn't already have it and we have rate/duty_day
                        if (strpos($desc, '(') === false && $rate > 0 && $dutyDay > 0) {
                            // Format: rate x duty_day (e.g., 2650.00 x 21.5)
                            $calcText = ' (' . number_format($rate, 2) . ' x ' . number_format($dutyDay, 1) . ')';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $desc }}{{ $calcText }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalChargePF += $item->amount; @endphp
                @endif
                
                {{-- Row 5: Insurance Amount --}}
                @if(isset($orderedItems['insurance']))
                    @php
                        $item = $orderedItems['insurance'];
                        $desc = $item->description ?? '';
                        
                        // Get rate and duty_day from item or original_detail
                        $rate = $item->rate ?? 0;
                        $dutyDay = $item->duty_day ?? ($item->employee_qty ?? 0);
                        
                        // If rate/duty_day not available, try to get from original_detail
                        if (($rate == 0 || $dutyDay == 0) && isset($item->original_detail)) {
                            $rate = $item->original_detail->rate ?? $rate;
                            $dutyDay = $item->original_detail->duty_day ?? ($item->original_detail->employee_qty ?? $dutyDay);
                        }
                        
                        // If still not available and we have details, try to find matching detail
                        if (($rate == 0 || $dutyDay == 0) && isset($invoice_id->details)) {
                            $totalRate = 0;
                            $totalDutyDay = 0;
                            $foundDetails = 0;
                            foreach ($invoice_id->details as $detail) {
                                $detailDesc = strtolower(trim($detail->jobpost?->name ?? ''));
                                if (strpos($detailDesc, 'insurance') !== false) {
                                    $detailRate = $detail->rate ?? 0;
                                    $detailDutyDay = $detail->duty_day ?? ($detail->employee_qty ?? 0);
                                    if ($detailRate > 0 || $detailDutyDay > 0) {
                                        // If we find a detail with both rate and duty_day, use it
                                        if ($detailRate > 0 && $detailDutyDay > 0) {
                                            $rate = $detailRate;
                                            $dutyDay = $detailDutyDay;
                                            break;
                                        }
                                        // Otherwise accumulate
                                        $totalRate += $detailRate;
                                        $totalDutyDay += $detailDutyDay;
                                        $foundDetails++;
                                    }
                                }
                            }
                            // If we accumulated values, use averages or totals
                            if ($rate == 0 && $dutyDay == 0 && $foundDetails > 0) {
                                $rate = $totalRate > 0 ? ($totalRate / $foundDetails) : 0;
                                $dutyDay = $totalDutyDay > 0 ? $totalDutyDay : 0;
                            }
                        }
                        
                        // Fallback: Calculate duty_day from amount / rate if duty_day is 0 or 1.0 (default value)
                        if ($rate > 0 && ($dutyDay == 0 || $dutyDay == 1.0) && $item->amount > 0) {
                            $calculatedDutyDay = $item->amount / $rate;
                            // Only use calculated value if it makes sense (greater than 0.1)
                            if ($calculatedDutyDay > 0.1) {
                                $dutyDay = $calculatedDutyDay;
                            }
                        }
                        
                        $calcText = '';
                        // Only add calculation if description doesn't already have it and we have rate/duty_day
                        if (strpos($desc, '(') === false && $rate > 0 && $dutyDay > 0) {
                            // Format: rate x duty_day (e.g., 60.00 x 21.5)
                            $calcText = ' (' . number_format($rate, 2) . ' x ' . number_format($dutyDay, 1) . ')';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $desc }}{{ $calcText }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalChargePF += $item->amount; @endphp
                @endif
                
                {{-- Row 6: Uniform Charge --}}
                @if(isset($orderedItems['uniform']))
                    @php
                        $item = $orderedItems['uniform'];
                        $desc = $item->description ?? '';
                        
                        // Get rate and duty_day from item or original_detail
                        $rate = $item->rate ?? 0;
                        $dutyDay = $item->duty_day ?? ($item->employee_qty ?? 0);
                        
                        // If rate/duty_day not available, try to get from original_detail
                        if (($rate == 0 || $dutyDay == 0) && isset($item->original_detail)) {
                            $rate = $item->original_detail->rate ?? $rate;
                            $dutyDay = $item->original_detail->duty_day ?? ($item->original_detail->employee_qty ?? $dutyDay);
                        }
                        
                        // If still not available and we have details, try to find matching detail
                        if (($rate == 0 || $dutyDay == 0) && isset($invoice_id->details)) {
                            $totalRate = 0;
                            $totalDutyDay = 0;
                            $foundDetails = 0;
                            foreach ($invoice_id->details as $detail) {
                                $detailDesc = strtolower(trim($detail->jobpost?->name ?? ''));
                                if (strpos($detailDesc, 'uniform') !== false) {
                                    $detailRate = $detail->rate ?? 0;
                                    $detailDutyDay = $detail->duty_day ?? ($detail->employee_qty ?? 0);
                                    if ($detailRate > 0 || $detailDutyDay > 0) {
                                        // If we find a detail with both rate and duty_day, use it
                                        if ($detailRate > 0 && $detailDutyDay > 0) {
                                            $rate = $detailRate;
                                            $dutyDay = $detailDutyDay;
                                            break;
                                        }
                                        // Otherwise accumulate
                                        $totalRate += $detailRate;
                                        $totalDutyDay += $detailDutyDay;
                                        $foundDetails++;
                                    }
                                }
                            }
                            // If we accumulated values, use averages or totals
                            if ($rate == 0 && $dutyDay == 0 && $foundDetails > 0) {
                                $rate = $totalRate > 0 ? ($totalRate / $foundDetails) : 0;
                                $dutyDay = $totalDutyDay > 0 ? $totalDutyDay : 0;
                            }
                        }
                        
                        // Fallback: Calculate duty_day from amount / rate if duty_day is 0 or 1.0 (default value)
                        if ($rate > 0 && ($dutyDay == 0 || $dutyDay == 1.0) && $item->amount > 0) {
                            $calculatedDutyDay = $item->amount / $rate;
                            // Only use calculated value if it makes sense (greater than 0.1)
                            if ($calculatedDutyDay > 0.1) {
                                $dutyDay = $calculatedDutyDay;
                            }
                        }
                        
                        $calcText = '';
                        // Only add calculation if description doesn't already have it and we have rate/duty_day
                        if (strpos($desc, '(') === false && $rate > 0 && $dutyDay > 0) {
                            // Format: rate x duty_day (e.g., 600.00 x 21.5)
                            $calcText = ' (' . number_format($rate, 2) . ' x ' . number_format($dutyDay, 1) . ')';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $desc }}{{ $calcText }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalChargePF += $item->amount; @endphp
                @endif
                
                {{-- Row 7: Provident Fund for Supervisor --}}
                @if(isset($orderedItems['pf_supervisor']))
                    @php
                        $item = $orderedItems['pf_supervisor'];
                        $desc = $item->description ?? '';
                        
                        // Get rate and duty_day from item or original_detail
                        $rate = $item->rate ?? 0;
                        $dutyDay = $item->duty_day ?? ($item->employee_qty ?? 0);
                        
                        // If rate/duty_day not available, try to get from original_detail
                        if (($rate == 0 || $dutyDay == 0) && isset($item->original_detail)) {
                            $rate = $item->original_detail->rate ?? $rate;
                            $dutyDay = $item->original_detail->duty_day ?? ($item->original_detail->employee_qty ?? $dutyDay);
                        }
                        
                        // If still not available and we have details, try to find matching detail
                        if (($rate == 0 || $dutyDay == 0) && isset($invoice_id->details)) {
                            $totalRate = 0;
                            $totalDutyDay = 0;
                            $foundDetails = 0;
                            foreach ($invoice_id->details as $detail) {
                                $detailDesc = strtolower(trim($detail->jobpost?->name ?? ''));
                                if (strpos($detailDesc, 'provident fund') !== false && (strpos($detailDesc, 'supervisor') !== false || strpos($detailDesc, 'sup') !== false)) {
                                    $detailRate = $detail->rate ?? 0;
                                    $detailDutyDay = $detail->duty_day ?? ($detail->employee_qty ?? 0);
                                    if ($detailRate > 0 || $detailDutyDay > 0) {
                                        // If we find a detail with both rate and duty_day, use it
                                        if ($detailRate > 0 && $detailDutyDay > 0) {
                                            $rate = $detailRate;
                                            $dutyDay = $detailDutyDay;
                                            break;
                                        }
                                        // Otherwise accumulate
                                        $totalRate += $detailRate;
                                        $totalDutyDay += $detailDutyDay;
                                        $foundDetails++;
                                    }
                                }
                            }
                            // If we accumulated values, use averages or totals
                            if ($rate == 0 && $dutyDay == 0 && $foundDetails > 0) {
                                $rate = $totalRate > 0 ? ($totalRate / $foundDetails) : 0;
                                $dutyDay = $totalDutyDay > 0 ? $totalDutyDay : 0;
                            }
                        }
                        
                        $calcText = '';
                        // For PF, check if description already has calculation in parentheses
                        // PF descriptions might have complex calculations like "(8550 /100*8.33) = 712 (712 x 02)"
                        // So we check if it ends with a calculation pattern
                        if (strpos($desc, '(') !== false && strpos($desc, ' x ') !== false) {
                            // Already has calculation, don't add
                            $calcText = '';
                        } elseif ($rate > 0 && $dutyDay > 0) {
                            // Format: rate x duty_day (e.g., 712 x 2)
                            $calcText = ' (' . number_format($rate, 0) . ' x ' . number_format($dutyDay, 0) . ')';
                        } elseif ($item->amount > 0 && $dutyDay > 0) {
                            // If rate not available, calculate unit amount
                            $unitAmount = $item->amount / ($dutyDay > 0 ? $dutyDay : 1);
                            $calcText = ' (' . number_format($unitAmount, 0) . ' x ' . number_format($dutyDay, 0) . ')';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $desc }}{{ $calcText }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalChargePF += $item->amount; @endphp
                @endif
                
                {{-- Row 8: Provident Fund for Guard --}}
                @if(isset($orderedItems['pf_guard']))
                    @php
                        $item = $orderedItems['pf_guard'];
                        $desc = $item->description ?? '';
                        
                        // Get rate and duty_day from item or original_detail
                        $rate = $item->rate ?? 0;
                        $dutyDay = $item->duty_day ?? ($item->employee_qty ?? 0);
                        
                        // If rate/duty_day not available, try to get from original_detail
                        if (($rate == 0 || $dutyDay == 0) && isset($item->original_detail)) {
                            $rate = $item->original_detail->rate ?? $rate;
                            $dutyDay = $item->original_detail->duty_day ?? ($item->original_detail->employee_qty ?? $dutyDay);
                        }
                        
                        // If still not available and we have details, try to find matching detail
                        if (($rate == 0 || $dutyDay == 0) && isset($invoice_id->details)) {
                            $totalRate = 0;
                            $totalDutyDay = 0;
                            $foundDetails = 0;
                            foreach ($invoice_id->details as $detail) {
                                $detailDesc = strtolower(trim($detail->jobpost?->name ?? ''));
                                if (strpos($detailDesc, 'provident fund') !== false && strpos($detailDesc, 'guard') !== false) {
                                    $detailRate = $detail->rate ?? 0;
                                    $detailDutyDay = $detail->duty_day ?? ($detail->employee_qty ?? 0);
                                    if ($detailRate > 0 || $detailDutyDay > 0) {
                                        // If we find a detail with both rate and duty_day, use it
                                        if ($detailRate > 0 && $detailDutyDay > 0) {
                                            $rate = $detailRate;
                                            $dutyDay = $detailDutyDay;
                                            break;
                                        }
                                        // Otherwise accumulate
                                        $totalRate += $detailRate;
                                        $totalDutyDay += $detailDutyDay;
                                        $foundDetails++;
                                    }
                                }
                            }
                            // If we accumulated values, use averages or totals
                            if ($rate == 0 && $dutyDay == 0 && $foundDetails > 0) {
                                $rate = $totalRate > 0 ? ($totalRate / $foundDetails) : 0;
                                $dutyDay = $totalDutyDay > 0 ? $totalDutyDay : 0;
                            }
                        }
                        
                        $calcText = '';
                        // For PF, check if description already has calculation in parentheses
                        // PF descriptions might have complex calculations like "(6950 /100*8.33) = 579 (579 x 10)"
                        // So we check if it ends with a calculation pattern
                        if (strpos($desc, '(') !== false && strpos($desc, ' x ') !== false) {
                            // Already has calculation, don't add
                            $calcText = '';
                        } elseif ($rate > 0 && $dutyDay > 0) {
                            // Format: rate x duty_day (e.g., 579 x 10)
                            $calcText = ' (' . number_format($rate, 0) . ' x ' . number_format($dutyDay, 0) . ')';
                        } elseif ($item->amount > 0 && $dutyDay > 0) {
                            // If rate not available, calculate unit amount
                            $unitAmount = $item->amount / ($dutyDay > 0 ? $dutyDay : 1);
                            $calcText = ' (' . number_format($unitAmount, 0) . ' x ' . number_format($dutyDay, 0) . ')';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $desc }}{{ $calcText }}</td>
                        <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $totalChargePF += $item->amount; @endphp
                @endif
                
                {{-- Display any other items that don't match the pattern (but are not deductions) --}}
                @foreach($otherItems as $item)
                    @php
                        $desc = strtolower(trim($item->description ?? ''));
                        $isDeduction = (strpos($desc, 'deduction') !== false || strpos($desc, 'vacant') !== false);
                    @endphp
                    @if(!$isDeduction)
                        <tr>
                            <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                            <td style="text-align: left; padding: 8px;">{{ $item->description }}</td>
                            <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                        @php 
                            // Add to charge/PF totals
                            $totalChargePF += $item->amount;
                        @endphp
                    @endif
                @endforeach
                
                {{-- Subtotal: Total Bill (Total bill for salary + Total charge + PF) --}}
                @php 
                    $totalBillBeforeDeduction = $totalSalaryBill + $totalChargePF;
                    // Count charge/PF items displayed
                    $chargePFItemsCount = 0;
                    if(isset($orderedItems['service_charge'])) $chargePFItemsCount++;
                    if(isset($orderedItems['insurance'])) $chargePFItemsCount++;
                    if(isset($orderedItems['uniform'])) $chargePFItemsCount++;
                    if(isset($orderedItems['pf_supervisor'])) $chargePFItemsCount++;
                    if(isset($orderedItems['pf_guard'])) $chargePFItemsCount++;
                    // Also count otherItems that are not deductions
                    foreach($otherItems as $item) {
                        $desc = strtolower(trim($item->description ?? ''));
                        $isDeduction = (strpos($desc, 'deduction') !== false || strpos($desc, 'vacant') !== false);
                        if (!$isDeduction) {
                            $chargePFItemsCount++;
                        }
                    }
                @endphp
                @if(($salaryItemsCount > 0 || $totalSalaryBill > 0) && ($chargePFItemsCount > 0 || $totalChargePF > 0))
                    <tr style="background-color: #f0f0f0;">
                        <td style="text-align: center; padding: 8px;"></td>
                        <td style="text-align: left; padding: 8px;"><b>Total Bill (Total bill for salary + Total charge + PF)</b></td>
                        <td style="text-align: right; padding: 8px;"><b>{{ money_format($totalBillBeforeDeduction) }}</b></td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                @endif
                
                {{-- Row 9: Deduction commission for vacant post --}}
                @php
                    // Initialize deductionAmount if not already set
                    if (!isset($deductionAmount)) {
                        $deductionAmount = 0;
                    }
                @endphp
                @if(isset($orderedItems['deduction']))
                    <tr>
                        <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                        <td style="text-align: left; padding: 8px;">{{ $orderedItems['deduction']->description }}</td>
                        <td style="text-align: right; padding: 8px;">{{ $orderedItems['deduction']->amount > 0 ? money_format($orderedItems['deduction']->amount) : '' }}</td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $deductionAmount += $orderedItems['deduction']->amount; @endphp
                @endif
                
                {{-- Check otherItems for deductions --}}
                @foreach($otherItems as $item)
                    @php
                        $desc = strtolower(trim($item->description ?? ''));
                        $isDeduction = (strpos($desc, 'deduction') !== false || strpos($desc, 'vacant') !== false);
                    @endphp
                    @if($isDeduction)
                        <tr>
                            <td style="text-align: center; padding: 8px;">{{ $sl++ }}</td>
                            <td style="text-align: left; padding: 8px;">{{ $item->description }}</td>
                            <td style="text-align: right; padding: 8px;">{{ $item->amount > 0 ? money_format($item->amount) : '' }}</td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                        @php $deductionAmount += $item->amount; @endphp
                    @endif
                @endforeach
                
                {{-- Fallback: If we have items but nothing displayed, show all items --}}
                @php
                    // Count items that were actually displayed
                    $itemsDisplayed = 0;
                    if(isset($orderedItems['wages'])) $itemsDisplayed++;
                    if(isset($orderedItems['backup'])) $itemsDisplayed++;
                    if(isset($orderedItems['advance'])) $itemsDisplayed++;
                    if(isset($orderedItems['service_charge'])) $itemsDisplayed++;
                    if(isset($orderedItems['insurance'])) $itemsDisplayed++;
                    if(isset($orderedItems['uniform'])) $itemsDisplayed++;
                    if(isset($orderedItems['pf_supervisor'])) $itemsDisplayed++;
                    if(isset($orderedItems['pf_guard'])) $itemsDisplayed++;
                    // Count non-deduction otherItems
                    foreach($otherItems as $item) {
                        $desc = strtolower(trim($item->description ?? ''));
                        $isDeduction = (strpos($desc, 'deduction') !== false || strpos($desc, 'vacant') !== false);
                        if (!$isDeduction) {
                            $itemsDisplayed++;
                        }
                    }
                @endphp
                @if($itemsToProcess->count() > 0 && $itemsDisplayed == 0)
                    @php
                        $fallbackSl = 1;
                        $fallbackSalaryTotal = 0;
                        $fallbackChargeTotal = 0;
                        $deductionItems = [];
                        $nonDeductionItems = [];
                    @endphp
                    {{-- Separate deductions from other items --}}
                    @foreach($itemsToProcess as $item)
                        @php
                            $desc = strtolower(trim($item->description ?? ''));
                            $isDeduction = (strpos($desc, 'deduction') !== false || strpos($desc, 'vacant') !== false);
                        @endphp
                        @if($isDeduction)
                            @php $deductionItems[] = $item; @endphp
                        @else
                            @php $nonDeductionItems[] = $item; @endphp
                        @endif
                    @endforeach
                    
                    {{-- Display non-deduction items first --}}
                    @foreach($nonDeductionItems as $index => $item)
                        <tr>
                            <td style="text-align: center; padding: 8px;">{{ $fallbackSl++ }}</td>
                            <td style="text-align: left; padding: 8px;">{{ $item->description }}</td>
                            <td style="text-align: right; padding: 8px;">{{ money_format($item->amount) }}</td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                        @php 
                            // First 3 items are salary, rest are charges
                            if ($index < 3) {
                                $fallbackSalaryTotal += $item->amount;
                                $totalSalaryBill += $item->amount;
                            } else {
                                $fallbackChargeTotal += $item->amount;
                                $totalChargePF += $item->amount;
                            }
                        @endphp
                    @endforeach
                    
                    {{-- Show subtotals for fallback --}}
                    @if($fallbackSalaryTotal > 0)
                        <tr style="background-color: #f0f0f0;">
                            <td style="text-align: center; padding: 8px;"></td>
                            <td style="text-align: left; padding: 8px;"><b>Total Bill for Salary</b></td>
                            <td style="text-align: right; padding: 8px;"><b>{{ money_format($fallbackSalaryTotal) }}</b></td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                    @endif
                    
                    @php $totalBillBeforeDeduction = $totalSalaryBill + $totalChargePF; @endphp
                    @if($totalBillBeforeDeduction > 0)
                        <tr style="background-color: #f0f0f0;">
                            <td style="text-align: center; padding: 8px;"></td>
                            <td style="text-align: left; padding: 8px;"><b>Total Bill (Total bill for salary + Total charge + PF)</b></td>
                            <td style="text-align: right; padding: 8px;"><b>{{ money_format($totalBillBeforeDeduction) }}</b></td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                    @endif
                    
                    {{-- Show deductions --}}
                    @foreach($deductionItems as $item)
                        <tr>
                            <td style="text-align: center; padding: 8px;">{{ $fallbackSl++ }}</td>
                            <td style="text-align: left; padding: 8px;">{{ $item->description }}</td>
                            <td style="text-align: right; padding: 8px;">{{ $item->amount > 0 ? money_format($item->amount) : '' }}</td>
                            <td style="text-align: center; padding: 8px;"></td>
                        </tr>
                        @php $deductionAmount += $item->amount; @endphp
                    @endforeach
                @endif
                
                {{-- Calculate Net Bill Amount --}}
                @php 
                    if (!isset($totalBillBeforeDeduction)) {
                        $totalBillBeforeDeduction = $totalSalaryBill + $totalChargePF;
                    }
                    if (!isset($deductionAmount)) {
                        $deductionAmount = 0;
                    }
                    $netBillAmount = $totalBillBeforeDeduction - $deductionAmount;
                @endphp
                
                {{-- Final Total: Net Bill Amount --}}
                @if($netBillAmount > 0 || $deductionAmount > 0 || $totalBillBeforeDeduction > 0)
                    <tr style="background-color: #e0e0e0;">
                        <td style="text-align: center; padding: 8px;"></td>
                        <td style="text-align: left; padding: 8px;"><b>Net Bill Amount</b></td>
                        <td style="text-align: right; padding: 8px;"><b>{{ money_format($netBillAmount > 0 ? $netBillAmount : ($invoice_id->grand_total ?? 0)) }}</b></td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php if($netBillAmount <= 0 && isset($invoice_id->grand_total)) { $netBillAmount = $invoice_id->grand_total; } @endphp
                @elseif($invoice_id->grand_total > 0)
                    {{-- Fallback to grand_total if netBillAmount is 0 --}}
                    <tr style="background-color: #e0e0e0;">
                        <td style="text-align: center; padding: 8px;"></td>
                        <td style="text-align: left; padding: 8px;"><b>Net Bill Amount</b></td>
                        <td style="text-align: right; padding: 8px;"><b>{{ money_format($invoice_id->grand_total) }}</b></td>
                        <td style="text-align: center; padding: 8px;"></td>
                    </tr>
                    @php $netBillAmount = $invoice_id->grand_total; @endphp
                @endif
            </tbody>
        </table>
        <div>
            <p>Total Amount In Words:<b>
                @php
                $dueTotal = $netBillAmount > 0 ? $netBillAmount : ($invoice_id->grand_total ?? 0);

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
