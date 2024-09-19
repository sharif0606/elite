@extends('layout.app')
@section('pageTitle',trans('Release'))
@section('pageSubTitle',trans('release'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form action="">
                    <div class="row">
                        <div class="text-center">
                            <h5 class="mb-2">ছাড়পত্র</h5>
                            <h5 class="mb-4">এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h5>
                        </div>
                        <div class="col-3">
                            <label for="">Employee ID</label>
                            <input type="text" class="form-control" name="addmission_id_no" value="{{$emp->admission_id_no}}" readonly>
                            <input type="hidden" class="form-control" name="employee_id" value="{{$emp->id}}">
                        </div>
                        <div class="col-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="employee_id" value="{{$emp->bn_applicants_name}}" readonly>
                        </div>
                        <div class="col-3">
                            <label for="">Joining Date</label>
                            <input type="date" class="form-control joining_date" name="joining_date" value="{{$emp->joining_date}}">
                        </div>
                        <div class="col-3">
                            <label for="">Job Post</label>
                            <input type="text" class="form-control" name="job_post" value="{{$emp->position?->name_bn}}">
                        </div>
                        <div class="col-3">
                            <label for="">Resign Date</label>
                            <input type="date" class="form-control resign_date" onchange="profidentFund(this);" name="resign_date" value="" required>
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
                            @foreach ($data as $d)
                                <tr class="text-center">
                                    <td>{{++$loop->index}}</td>
                                    <td class="text-start">{{$d->product?->product_name}}<input type="hidden" class="form-control" name="issue_item_id[]" value="{{$d->product_id}}"></td>
                                    <td><input type="text" class="form-control text-center issue_qty" name="issue_qty[]" value="{{abs($d->product_qty)}}" readonly></td>
                                    <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-center receive_qty" name="receive_qty[]"></td>
                                    <td><input type="number" class="form-control text-center not_receive_qty" name="not_receive_qty[]" readonly></td>
                                    <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-end not_receive_qty_amount" name="not_receive_qty_amount[]"></td>
                                    <td><input type="text" class="form-control" name="comment[]"></td>
                                </tr>
                            @endforeach
                            <tr class="text-center">
                                <td></td>
                                <td class="text-start">ধোলাই খরচ বাবদ <input type="hidden" name="wash_cost" value="ধোলাই খরচ বাবদ"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="number" onkeyup="issueCalc(this);" class="form-control text-end not_receive_qty_amount" name="wash_cost_amount[]"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">মোট কর্তনকৃত টাকা=</th>
                                <td><input type="number" class="form-control text-end amount_deducted" name="amount_deducted[]"></td>
                            </tr>
                        </table>
                        <div class="row mb-5">
                            <div class="col-12">
                                <label for="">নোট</label>
                                <textarea class="form-control" name="others_note" rows="2"></textarea>
                            </div>
                            <div class="col-2">
                                <label for="">জমাকারীর মোবাইল নং</label>
                                <input type="number" class="form-control" name="issue_submiter_mobile">
                            </div>
                            <div class="col-5">
                                <label for="">গ্রাহক কর্তৃপক্ষ মন্তব্য</label>
                                <input type="text" class="form-control" name="cus_authority_comment">
                            </div>
                            <div class="col-5">
                                <label for="">জোন কমান্ডার মন্তব্য</label>
                                <input type="text" class="form-control" name="zone_commander_comment">
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-2">হিসাবের বিবরণ</h5>
                        </div>
                        <table class="table table-bordered" width="100%">
                            <tr class="text-center">
                                <th>ক্রমিক নং</th>
                                <th width="60%">বিবরণ</th>
                                <th width="18%">টাকা</th>
                                <th width="15%">মন্তব্য</th>
                            </tr>
                            <tr>
                                <td class="text-center">১।</td>
                                <td>
                                    <textarea name="due_salary" class="form-control" rows="2">বকেয়া বেতন</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end" name="due_salary_amount"></td>
                                <td><input type="text" class="form-control" name="due_salary_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center">২।</td>
                                <td>
                                    <textarea name="pf_a" class="form-control" rows="2">(ক) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১০  ইং পর্যন্ত) মাসিক ৫০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_a_amount" name="pf_a_amount"></td>
                                <td><input type="text" class="form-control" name="pf_a_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>
                                    <textarea name="pf_b" class="form-control" rows="2">(খ) প্রভিডেন্ট ফান্ড (ডিসেম্বর-২০১৭ ইং পর্যন্ত) মাসিক ১০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_b_amount" name="pf_b_amount"></td>
                                <td><input type="text" class="form-control" name="pf_b_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>
                                    <textarea name="pf_c" class="form-control" rows="2">(গ) প্রভিডেন্ট ফান্ড (জানুয়ারী -২০১৮ ইং থেকে চলিত) মাসিক ২০০/- টাকা এবং লভ্যাংশ ২০/- টাকা হারে (লভ্যাংশ  পাবে কমপক্ষে ৬ মাস চাকুরী করলে)</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end pf_c_amount" name="pf_c_amount"></td>
                                <td><input type="text" class="form-control" name="pf_c_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৩।</td>
                                <td>
                                    <textarea name="leave" class="form-control" rows="2">ছুটির টাকা (কমপক্ষে ৬ মাস চাকুরী করলে)</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end" name="leave_amount"></td>
                                <td><input type="text" class="form-control" name="leave_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৪।</td>
                                <td>
                                    <textarea name="addmission" class="form-control" rows="2">ভর্তির নগদ জামানত বাবদ ১০০০/- ফেরত যোগ্য যদি ৩০/০৬/২০০৯ তারিখের পূর্বে ভর্তি হয়ে থাকে।  তার পরের ভর্তির ফি বাবদ অফেরতযোগ্য  (চুক্তি মোতাবেক)</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end addmission_amount" name="addmission_amount"></td>
                                <td><input type="text" class="form-control" name="addmission_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center">৫।</td>
                                <td>
                                    <textarea name="others" class="form-control" rows="2">অন্যান্য</textarea>
                                </td>
                                <td><input type="text" class="form-control text-end" name="others_amount"></td>
                                <td><input type="text" class="form-control" name="others_comment"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>মোট হিসাব =</td>
                                <td><input type="text" class="form-control text-end" name="subtotal"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>কর্তনকৃত টাকা =</td>
                                <td><input type="text" class="form-control text-end final_deducted" name="final_deducted"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>চূড়ান্ত পাওনা =</td>
                                <td><input type="text" class="form-control text-end" name="final_total"></td>
                                <td></td>
                            </tr>
                        </table>
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
    }
   
</script>
<script>
    function profidentFund(e) {
        let joiningDate = new Date($('.joining_date').val());
        let resignDate = new Date($(e).val());
        let jamanotDate = new Date('2009-06-30');
        let pfActOneStart = new Date('2010-12-31'); // Start date for PF A
        let pfActOne = new Date('2017-12-31'); // End date for PF A
        let pfActTwoStart = new Date('2017-12-31'); // Start date for PF B
        let pfActTwoEnd = new Date('2018-01-01'); // End date for PF B
        let pfActThreeStart = new Date('2018-01-01'); // Start date for PF C
    
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
    
        if (joiningDate <= pfActOneStart) {
            let endPfA = resignDate < pfActOneStart ? resignDate : pfActOne;
            let monthsInPfA = calculateMonths(joiningDate, endPfA);
            pf_a_amount = monthsInPfA * 70;
        }
    
        if (joiningDate <= pfActTwoStart) {
            // Calculate months for PF B (from pfActTwoStart to pfActTwoEnd)
            //let startPfB = pfActOneStart;
            let endPfB = resignDate > pfActOneStart ? resignDate : pfActTwoStart;
            if(endPfB < pfActThreeStart){
                if(endPfB < pfActOneStart){
                    endPfB=pfActOneStart
                    let monthsInPfB = calculateMonths(joiningDate, endPfB);
                    pf_b_amount = monthsInPfB * 120;
                }else{
                    endPfB=resignDate
                    let monthsInPfB = calculateMonths(joiningDate, endPfB);
                    pf_b_amount = monthsInPfB * 120;
                }
            }else{
                endPfB = pfActThreeStart
                if(joiningDate < pfActOneStart){
                    let monthsInPfB = calculateMonths(pfActOneStart, endPfB);
                    pf_b_amount = monthsInPfB * 120;
                }else{
                    let monthsInPfB = calculateMonths(joiningDate, endPfB);
                    pf_b_amount = monthsInPfB * 120;
                }
                //console.log(monthsInPfB);
            }
            //console.log(endPfB);
            
        }
    
        if (joiningDate <= resignDate) {
            // Calculate months for PF C (from pfActThreeStart to resignDate)
            let startPfC = pfActThreeStart;
            let monthsInPfC = calculateMonths(startPfC, resignDate);
            pf_c_amount = monthsInPfC * 240;
        }
    
        // Debugging logs to check the calculated values
        console.log('PF A Amount:', pf_a_amount);
        console.log('PF B Amount:', pf_b_amount);
        console.log('PF C Amount:', pf_c_amount);
    
        $('.pf_a_amount').val(pf_a_amount);
        $('.pf_b_amount').val(pf_b_amount);
        $('.pf_c_amount').val(pf_c_amount);
    
        if (joiningDate < jamanotDate) {
            $('.addmission_amount').val(1000);
        } else {
            $('.addmission_amount').val(0);
        }
    }
</script>
    
@endpush