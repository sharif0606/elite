@extends('layout.app')
@section('pageTitle',trans('Release'))
@section('pageSubTitle',trans('Update'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{route('relEmployee.update', [encryptor('encrypt',$emRel->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="text-center">
                            <h5 class="mb-2">ছাড়পত্র</h5>
                            <h5 class="mb-4">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                        </div>
                        <div class="col-3">
                            <label for="">Employee ID</label>
                            <input type="text" class="form-control" name="addmission_id_no" value="{{$emRel->employee?->admission_id_no}}" readonly>
                            <input type="hidden" class="form-control" name="employee_id" value="{{$emRel->employee_id}}">
                        </div>
                        <div class="col-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control" value="{{$emRel->employee?->bn_applicants_name}}" readonly>
                        </div>
                        <div class="col-3">
                            <label for="">Joining Date</label>
                            <input type="date" class="form-control joining_date" name="joining_date" value="{{$emRel->employee?->joining_date}}">
                        </div>
                        <div class="col-3">
                            <label for="">Job Post</label>
                            <input type="text" class="form-control" name="job_post" value="{{$emRel->employee?->position?->name_bn}}">
                        </div>
                        <div class="col-3">
                            <label for="">Post Name</label>
                            <input type="text" class="form-control" name="appoint_customer_name" value="{{$emRel->appoint_customer_name}}" required>
                        </div>
                        <div class="col-3">
                            <label for="">Resign Date</label>
                            <input type="date" class="form-control resign_date" onchange="profidentFund(this);" name="resign_date" value="{{$emRel->resign_date}}" required>
                        </div>
                        <table class="table table-bordered" width="100%">
                            <tr class="text-center">
                                <th rowspan="2">ক্রমিক নং</th>
                                <th rowspan="2" width="25%">পোষাকের নাম</th>
                                <th rowspan="2">ইস্যু সংখ্যা</th>
                                <th rowspan="2">জমার সংখ্যা</th>
                                <th colspan="2">জমা না করার সংখ্যা ও উহার মূল্য</th>
                                <th rowspan="2" width="25%">মন্তব্য</th>
                            </tr>
                            <tr class="text-center">
                                <th>সংখ্যা</th>
                                <th>টাকা</th>
                            </tr>
                            @foreach ($relDetail as $d)
                                <tr class="text-center">
                                    <td>{{++$loop->index}}</td>
                                    <td class="text-start">{{$d->product?->product_name}}<input type="hidden" class="form-control" name="issue_item_id[]" value="{{$d->issue_item_id}}"></td>
                                    <td><input type="text" class="form-control text-center issue_qty" name="issue_qty[]" value="{{abs($d->issue_qty)}}" readonly></td>
                                    <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-center receive_qty" name="receive_qty[]" value="{{$d->receive_qty}}"></td>
                                    <td><input type="number" class="form-control text-center not_receive_qty" name="not_receive_qty[]" value="{{$d->not_receive_qty}}" readonly></td>
                                    <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-end not_receive_qty_amount" name="not_receive_qty_amount[]" value="{{$d->not_receive_qty_amount}}"></td>
                                    <td><input type="text" class="form-control" name="comment[]" value="{{$d->comment}}"></td>
                                </tr>
                            @endforeach
                            <tr class="text-center">
                                <td></td>
                                <td class="text-start"><textarea class="form-control" name="others_issue"  rows="2">@if($emRel->others_issue != '') {{$emRel->others_issue}} @else() অন্যান্য @endif</textarea></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-end not_receive_qty_amount" name="others_issue_amount" value="{{$emRel->others_issue_amount}}"></td>
                                <td></td>
                            </tr>
                            <tr class="text-center">
                                <td></td>
                                <td class="text-start">ধোলাই খরচ বাবদ <input type="hidden" name="wash_cost" value="{{$emRel->wash_cost}}"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-end not_receive_qty_amount" name="wash_cost_amount" value="{{$emRel->wash_cost_amount}}"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">মোট কর্তনকৃত টাকা=</th>
                                <td><input type="number" class="form-control text-end amount_deducted" name="amount_deducted" value="{{$emRel->amount_deducted}}"></td>
                            </tr>
                        </table>
                        <div class="row mb-5">
                            <div class="col-12">
                                <label for="">নোট</label>
                                <textarea class="form-control" name="others_note" rows="2">{{$emRel->others_note}}</textarea>
                            </div>
                            <div class="col-2">
                                <label for="">জমাকারীর মোবাইল নং</label>
                                <input type="number" class="form-control" name="issue_submiter_mobile" value="{{$emRel->issue_submiter_mobile}}">
                            </div>
                            <div class="col-3">
                                <label for="">জমাকারীর স্বাক্ষর</label>
                                <input type="file" class="form-control" name="issue_submiter_sign">
                                <img width="80px" height="40px" class="float-first" src="{{asset('uploads/release/submiter/'.$emRel->issue_submiter_sign)}}" alt="">
                            </div>
                            <div class="col-3">
                                <label for="">জমাগ্রহণকারীর স্বাক্ষর</label>
                                <input type="file" class="form-control" name="issue_receiver_sign">
                                <img width="80px" height="40px" class="float-first" src="{{asset('uploads/release/receiver/'.$emRel->issue_receiver_sign)}}" alt="">
                            </div>
                            <div class="col-5">
                                <label for="">গ্রাহক কর্তৃপক্ষ মন্তব্য</label>
                                <input type="text" class="form-control" name="cus_authority_comment" value="{{$emRel->cus_authority_comment}}">
                            </div>
                            <div class="col-5">
                                <label for="">জোন কমান্ডার মন্তব্য</label>
                                <input type="text" class="form-control" name="zone_commander_comment" value="{{$emRel->zone_commander_comment}}">
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-2">হিসাবের বিবরণ</h5>
                        </div>
                        <table class="table table-bordered" width="100%">
                            <tr class="text-center">
                                <th>ক্রমিক নং</th>
                                <th width="60%" colspan="2">বিবরণ</th>
                                <th width="18%">টাকা</th>
                                <th width="15%">মন্তব্য</th>
                            </tr>
                            <tr>
                                <td class="text-center">১।</td>
                                <td class="text-left" colspan="2">
                                    <textarea name="due_salary" class="form-control" rows="2">
                                        @if($emRel->due_salary != '')
                                            {{$emRel->due_salary}}
                                        @else
                                            বকেয়া বেতন
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end due_salary_amount" onkeyup="pfCollection(this);" name="due_salary_amount" value="{{$emRel->due_salary_amount}}" ></td>
                                <td><input type="text" class="form-control" name="due_salary_comment" value="{{$emRel->due_salary_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center">২।</td>
                                <td class="text-left" colspan="2">
                                    <textarea name="pf_a" class="form-control pf_a" rows="4">
                                        @if($emRel->pf_a != '')
                                            {{$emRel->pf_a}}
                                        @else
                                            (ক) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১০  ইং পর্যন্ত) মাসিক ৫০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_a_amount" onkeyup="pfCollection(this);" name="pf_a_amount" value="{{$emRel->pf_a_amount}}"></td>
                                <td><input type="text" class="form-control" name="pf_a_comment" value="{{$emRel->pf_a_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-left" colspan="2">
                                    <textarea name="pf_b" class="form-control pf_b" rows="4">
                                        @if($emRel->pf_b != '')
                                            {{$emRel->pf_b}}
                                        @else
                                            (খ) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১৭ ইং পর্যন্ত) মাসিক ১০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_b_amount" onkeyup="pfCollection(this);" name="pf_b_amount" value="{{$emRel->pf_b_amount}}"></td>
                                <td><input type="text" class="form-control" name="pf_b_comment" value="{{$emRel->pf_b_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-left" colspan="2">
                                    <textarea name="pf_c" class="form-control pf_c" rows="4">
                                        @if($emRel->pf_c != '')
                                            {{$emRel->pf_c}}
                                        @else
                                            (গ) প্রভিডেন্ট ফান্ড (জানুয়ারী -২০১৮ ইং থেকে চলিত) মাসিক ২০০/- টাকা এবং লভ্যাংশ ৪০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_c_amount" onkeyup="pfCollection(this);" name="pf_c_amount" value="{{$emRel->pf_c_amount}}"></td>
                                <td><input type="text" class="form-control" name="pf_c_comment" value="{{$emRel->pf_c_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৩।</td>
                                <td class="text-left" colspan="2">
                                    <textarea name="leave" class="form-control" rows="2">
                                        @if($emRel->leave != '')
                                            {{$emRel->leave}}
                                        @else
                                            ছুটির টাকা (কমপক্ষে ৬ মাস চাকুরী করলে)
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end leave_amount" onkeyup="pfCollection(this);" name="leave_amount" value="{{$emRel->leave_amount}}"></td>
                                <td><input type="text" class="form-control" name="leave_comment" value="{{$emRel->leave_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৪।</td>
                                <td class="text-left" colspan="2">
                                    <textarea name="addmission" class="form-control" rows="2">
                                        @if($emRel->addmission != '')
                                            {{$emRel->addmission}}
                                        @else
                                           ভর্তির নগদ জামানত বাবদ ১০০০/- ফেরত যোগ্য যদি ৩০/০৬/২০০৯ তারিখের পূর্বে ভর্তি হয়ে থাকে।  তার পরের ভর্তির ফি বাবদ অফেরতযোগ্য  (চুক্তি মোতাবেক)
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end addmission_amount" onkeyup="pfCollection(this);" name="addmission_amount" value="{{$emRel->addmission_amount}}"></td>
                                <td><input type="text" class="form-control" name="addmission_comment" value="{{$emRel->addmission_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৫।</td>
                                <td class="text-left" colspan="2">
                                    <textarea name="others" class="form-control" rows="2">
                                        @if($emRel->others != '')
                                            {{$emRel->others}}
                                        @else
                                           অন্যান্য
                                        @endif
                                    </textarea>
                                </td>
                                <td><input type="text" class="form-control text-end others_amount" onkeyup="pfCollection(this);" name="others_amount" value="{{$emRel->others_amount}}"></td>
                                <td><input type="text" class="form-control" name="others_comment" value="{{$emRel->others_comment}}"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td colspan="2">মোট হিসাব =</td>
                                <td><input type="text" class="form-control text-end subtotal_amount" name="subtotal" value="{{$emRel->subtotal}}" readonly></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>কর্তনকৃত টাকা =</td>
                                <td><input type="text" class="form-control" name="final_deducted_note" value="{{$emRel->final_deducted_note}}" placeholder="কর্তনকৃত টাকা"></td>
                                <td><input type="text" class="form-control text-end final_deducted" name="final_deducted" value="{{$emRel->final_deducted}}" readonly></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td colspan="2">চূড়ান্ত পাওনা =</td>
                                <td><input type="text" class="form-control text-end final_total" name="final_total" value="{{$emRel->final_total}}" readonly></td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-info">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    function issueCalc(e){
      let issueQty = $(e).closest('tr').find('.issue_qty').val()?parseFloat($(e).closest('tr').find('.issue_qty').val()):0;
      let receiveQty = $(e).closest('tr').find('.receive_qty').val()?parseFloat($(e).closest('tr').find('.receive_qty').val()):0;
      if(receiveQty > issueQty){
        alert("You cannot receive more than" + issueQty);
        $(e).closest('tr').find('.receive_qty').val(issueQty);
        $(e).closest('tr').find('.not_receive_qty').val(0);
      }else{
          let notReceiveQty= issueQty - receiveQty;
          $(e).closest('tr').find('.not_receive_qty').val(notReceiveQty);
      }
      total_issue_calc();
    }
    function total_issue_calc(){
        var notReceiveTotal = 0;
        $('.not_receive_qty_amount').each(function() {
            notReceiveTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.amount_deducted').val(parseFloat(notReceiveTotal).toFixed(2));
        $('.final_deducted').val(parseFloat(notReceiveTotal).toFixed(2));
        pfCollection();
    }
   
</script>
<script>
    function profidentFund(e) {
        let joiningDate = new Date($('.joining_date').val());
        let resignDate = new Date($(e).val());
        let pfaMessage = $('.pf_a').val()? $('.pf_a').val():'';
        let pfbMessage = $('.pf_b').val()? $('.pf_b').val():'';
        let pfcMessage = $('.pf_c').val()? $('.pf_c').val():'';
        let jamanotDate = new Date('2009-06-30');
        let pfActOneEnd = new Date('2010-12-31'); 
        let pfActOne = new Date('2017-12-31'); 
        let pfActTwoStart = new Date('2011-01-01'); 
        let pfActTwoEnd = new Date('2017-12-31');
        let pfActThreeStart = new Date('2018-01-01');
    
        // Ensure that joiningDate and resignDate are valid
        if (isNaN(joiningDate) || isNaN(resignDate)) {
            console.log('Invalid dates detected');
            return;
        }
    
        function calculateMonths(startDate, endDate) {
            let years = endDate.getFullYear() - startDate.getFullYear();
            let months = (years * 12) + (endDate.getMonth() - startDate.getMonth());
    
            // Adjust for the day of the month
            if (endDate.getDate() < startDate.getDate()) {
                months--; // If end day is earlier in the month than the start day, subtract a month
            }
            
            return months > 0 ? months : 0; // Ensure no negative months
        }
    
        let pf_a_amount = 0, pf_b_amount = 0, pf_c_amount = 0;
    
        //(ক) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১০  ইং পর্যন্ত) মাসিক ৫০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে
        if (joiningDate < pfActOneEnd) {
            let endPfA = resignDate <= pfActOneEnd ? resignDate : pfActOneEnd;
            let monthsInPfA = calculateMonths(joiningDate, endPfA);
            pf_a_amount = monthsInPfA * 70;
            pfaMessage = pfaMessage + '\n' + new Date(joiningDate).toLocaleDateString() + '--' + new Date(endPfA).toLocaleDateString() + '=' + monthsInPfA + '*' + '70';
        }

        //this is for
        //(খ) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১৭ ইং পর্যন্ত) মাসিক ১০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
        if (joiningDate <= pfActTwoEnd) {
            // pfActOneEnd = 31-12-2010
            // pfActTwoStart = 01-01-2011
            // pfActThreeStart = 01-01-2018
            let endPfB = resignDate > pfActTwoStart ? resignDate : joiningDate;
            if(endPfB < pfActThreeStart){
                if(endPfB < pfActOneEnd){
                    endPfB=pfActOneEnd
                    let monthsInPfB = calculateMonths(joiningDate, endPfB);
                    if(monthsInPfB >= 6){
                        pf_b_amount = monthsInPfB * 120;
                        pfbMessage = pfbMessage + '\n' + new Date(joiningDate).toLocaleDateString() + '--' + new Date(endPfB).toLocaleDateString() + '=' + monthsInPfB + '*' + '120';
                    }else{
                        pf_b_amount = 0;
                    }
                }else{
                    endPfB=resignDate
                    if(joiningDate < pfActOneEnd){
                        let monthsInPfB = calculateMonths(pfActTwoStart, endPfB);
                        if(monthsInPfB >= 6){
                            pf_b_amount = monthsInPfB * 120;
                            pfbMessage = pfbMessage + '\n' + new Date(pfActOneEnd).toLocaleDateString() + '--' + new Date(endPfB).toLocaleDateString() + '=' + monthsInPfB + '*' + '120';
                        }else{
                            pf_b_amount = 0;
                        }
                    }else{
                        let monthsInPfB = calculateMonths(joiningDate, endPfB);
                        if(monthsInPfB >= 6){
                            pf_b_amount = monthsInPfB * 120;
                            pfbMessage = pfbMessage + '\n' + new Date(joiningDate).toLocaleDateString() + '--' + new Date(endPfB).toLocaleDateString() + '=' + monthsInPfB + '*' + '120';
                        }else{
                            pf_b_amount = 0;
                        }
                    }
                }
            }else{
                endPfB = pfActTwoEnd
                if(joiningDate < pfActOneEnd){
                    let monthsInPfB = calculateMonths(pfActTwoStart, endPfB);
                    if(monthsInPfB >= 6){
                        pf_b_amount = monthsInPfB * 120;
                        pfbMessage = pfbMessage + '\n' + new Date(pfActTwoStart).toLocaleDateString() + '--' + new Date(endPfB).toLocaleDateString() + '=' + monthsInPfB + '*' + '120';
                    }else{
                        pf_b_amount = 0;
                    }
                }else{
                    let monthsInPfB = calculateMonths(joiningDate, endPfB);
                    if(monthsInPfB >= 6){
                        pf_b_amount = monthsInPfB * 120;
                        pfbMessage = pfbMessage + '\n' + new Date(joiningDate).toLocaleDateString() + '--' + new Date(endPfB).toLocaleDateString() + '=' + monthsInPfB + '*' + '120';
                    }else{
                        pf_b_amount = 0;
                    }
                }
            }
            
        }

        //(গ) প্রভিডেন্ট ফান্ড (জানুয়ারী -২০১৮ ইং থেকে চলিত) মাসিক ২০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)
        if (joiningDate <= pfActThreeStart) {
            // pfActOneEnd = 31-12-2010
            // pfActTwoStart = 01-01-2011
            // pfActThreeStart = 01-01-2018
            let endPfC = resignDate > pfActThreeStart ? resignDate : joiningDate;
            let monthsInPfC = calculateMonths(pfActThreeStart, endPfC);
            //var getExactDate = new Date(pfActTwoStart);
            //getExactDate.setDate(getExactDate.getDate() + 1);
            if(monthsInPfC >= 6){
                pf_c_amount = monthsInPfC * 240;
                pfcMessage = pfcMessage + '\n' + new Date(pfActThreeStart).toLocaleDateString() + '--' + new Date(endPfC).toLocaleDateString() + '=' + monthsInPfC + '*' + '240';
            }else{
                pf_c_amount = 0;
            }
        }else if(joiningDate > pfActThreeStart){
            let endPfC = resignDate;
            let monthsInPfC = calculateMonths(joiningDate, endPfC);
            if(monthsInPfC >= 6){
                pf_c_amount = monthsInPfC * 240;
                pfcMessage = pfcMessage + '\n' + new Date(joiningDate).toLocaleDateString() + '--' + new Date(endPfC).toLocaleDateString() + '=' + monthsInPfC + '*' + '240';
            }else{
                pf_c_amount = 0;
            }
        }
        //console.log('PF A Amount:', pf_a_amount);
    
        $('.pf_a_amount').val(pf_a_amount);
        $('.pf_b_amount').val(pf_b_amount);
        $('.pf_c_amount').val(pf_c_amount);
        $('.pf_a').val(pfaMessage);
        $('.pf_b').val(pfbMessage);
        $('.pf_c').val(pfcMessage);
    
        if (joiningDate < jamanotDate) {
            $('.addmission_amount').val(1000);
        } else {
            $('.addmission_amount').val(0);
        }

        pfCollection();
    }

    function pfCollection(e) {
        let dueSalary = $('.due_salary_amount').val() ? parseFloat($('.due_salary_amount').val()) : 0;
        let pfA = $('.pf_a_amount').val() ? parseFloat($('.pf_a_amount').val()) : 0;
        let pfB = $('.pf_b_amount').val() ? parseFloat($('.pf_b_amount').val()) : 0;
        let pfC = $('.pf_c_amount').val() ? parseFloat($('.pf_c_amount').val()) : 0;
        let leaveAmount = $('.leave_amount').val() ? parseFloat($('.leave_amount').val()) : 0;
        let addmissionAmount = $('.addmission_amount').val() ? parseFloat($('.addmission_amount').val()) : 0;
        let otherAmount = $('.others_amount').val() ? parseFloat($('.others_amount').val()) : 0;
        let deductedAmount = $('.final_deducted').val() ? parseFloat($('.final_deducted').val()) : 0;

        let subTotal = dueSalary + pfA + pfB + pfC + leaveAmount + addmissionAmount + otherAmount;
        let total = subTotal - deductedAmount;

        $('.subtotal_amount').val(subTotal.toFixed(2));
        $('.final_total').val(total.toFixed(2));
    }
</script>
    
@endpush