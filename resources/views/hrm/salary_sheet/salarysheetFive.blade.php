@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Five(General)'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .myDIV {
      writing-mode: vertical-lr;
      text-orientation: mixed;
    }
    .selected-row {
        background-color: rgb(189, 245, 189);
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('salarysheet.salarySheetFiveStore')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="row p-2 mt-4">
                                    <div class="form-group col-lg-6 mt-2">
                                        <label for=""><b>Customer Name</b></label>
                                        <select class="choices form-select multiple-remove customer_id" multiple="multiple" name="customer_id[]">
                                            <optgroup label="Select Customer">
                                                @forelse ($customer as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @empty
                                                @endforelse
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 mt-2">
                                        <label for=""><b>Customer Name Not</b></label>
                                        <select class="choices form-select multiple-remove customer_id_not" multiple="multiple" name="customer_id_not[]">
                                            <optgroup label="Select Customer">
                                                @forelse ($customer as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @empty
                                                @endforelse
                                            </optgroup>
                                        </select>
                                    </div>
                                    {{--  <div class="col-lg-4 mt-2">
                                        <label for=""><b>Branch Name</b></label>
                                        <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="getAtm(this)">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Atm</b></label>
                                        <select class="form-select atm_id" id="atm_id" name="atm_id">
                                            <option value="">Select Atm</option>
                                        </select>
                                    </div>  --}}
                                    {{--  <div class="col-lg-3 mt-2">
                                        <label for=""><b>Start Date</b></label>
                                        <input onkeyup="reCalcultateSalary(this)" required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <label for=""><b>End Date</b></label>
                                        <input onkeyup="reCalcultateSalary(this)" required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                    </div>  --}}
                                    <div class="col-lg-3 mt-2">
                                        <label for=""><b>Salary Year</b></label>
                                        <select required class="form-control year" name="year">
                                            <option value="">Select Year</option>
                                            @for($i=2023;$i<= date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <label for=""><b>Salary Month</b></label>
                                        <select required class="form-control month selected_month" name="month">
                                            <option value="">Select Month</option>
                                            @for($i=1;$i<= 12;$i++)
                                            <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getSalaryData()" type="button" class="btn btn-primary">Generate Salary</button>
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="d-none show_click">
                                            <tr class="text-center myDIV" id="">
                                                <th scope="col" rowspan="2" class="myDIV">{{__('SL.No')}}</th>
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rank')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Divide By')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rate of Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Pre.Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Taka')}}</th>
                                                <th scope="col" rowspan="2">{{__('Post Allowance')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="8">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Payable Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('SIGN OF IND.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Sign of Account')}}</th>
                                                <th scope="col" rowspan="2">{{__('Remark')}}</th>
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>Dress</th>
                                                <th>Fine</th>
                                                <th>Bank Charge/Exc</th>
                                                <th>ins</th>
                                                <th>P.F</th>
                                                <th>stamp</th>
                                                <th>Training Cost</th>
                                                <th>Loan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">

                                        </tbody>
                                        <tfoot class="d-none show_click">
                                             <tr>
                                                <th colspan="6" class="text-end"> Total</th>
                                                <th><input class="form-control ratOfSalaryTotal" type="text" disabled></th>
                                                <th><input class="form-control prevDaysTotal" type="text" style="width:60px;" disabled></th>
                                                <th><input class="form-control netTotal" type="text" disabled></th>
                                                <th><input class="form-control otDayTotal" type="text" style="width:60px;" disabled></th>
                                                <th><input class="form-control otRateTotal" type="text" disabled></th>
                                                <th><input class="form-control otAmountTotal" type="text" disabled></th>
                                                <th><input class="form-control postAlownceTotal" type="text" disabled></th>
                                                <th><input class="form-control grossTotal" type="text" disabled></th>
                                                <th><input class="form-control deDressTotal" type="text" disabled></th>
                                                <th><input class="form-control deFineTotal" type="text" disabled></th>
                                                <th><input class="form-control deBankChargeTotal" type="text" disabled></th>
                                                <th><input class="form-control deInsTotal" type="text" disabled></th>
                                                <th><input class="form-control dePfTotal" type="text" disabled></th>
                                                <th><input class="form-control deStmpTotal" type="text" disabled></th>
                                                <th><input class="form-control deTrainingTotal" type="text" disabled></th>
                                                <th><input class="form-control deLoonTotal" type="text" disabled></th>
                                                <th><input class="form-control payableTotal" type="text" disabled></th>
                                            </tr> 
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
    function getSalaryData(e){
        var startDate=$('.year').val()+'-'+$('.month').val()+'-01';
        var endDate=$('.year').val()+'-'+$('.month').val()+'-31';
        var CustomerId=$('.customer_id').val();
        var CustomerIdNot=$('.customer_id_not').val();
        var Year=$('.year').val();
        var Month=$('.month').val();

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,CustomerIdNot:CustomerIdNot,Year:Year,Month:Month },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    var old_emp = '';
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_remaining_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_remaining_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let postAllowance=value.bn_post_allowance;
                        //console.log(traningCostPerMonth);
                        let joiningDate = new Date(value.salary_joining_date);
                        let sixMonthsLater = new Date(joiningDate);
                        sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);
                        // Deduction calculation
                        let pf = "0";
                        if (new Date() >= sixMonthsLater) {
                            pf = "200";
                        }
                        let Insurance = "0";
                        if (new Date() >= sixMonthsLater) {
                            Insurance = (value.insurance > 0) ? value.insurance : '0';
                        }
                        let Fine = (value.fine > 0) ? value.fine : '0';
                        //let Remarks = (value.remarks) ? value.remarks : '';
                        let RemarksArray = [
                            (value.loan_rmk) ? value.loan_rmk : '',
                            (value.salary_stop_message) ? value.salary_stop_message : ''
                        ];
                        let Remarks = RemarksArray.filter(item => item !== '').join(', ');
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Stmp = (value.stmp > 0) ? value.stmp : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let BankCharge = (value.bank_charge_exc > 0) ? value.bank_charge_exc : '0';
                        let Dress = (value.dress > 0) ? value.dress : '0';
                        let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(Dress) + parseFloat(Loan) + parseFloat(BankCharge) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                        let netSalary = '0';
                        let currentMonth = $('.selected_month').val();
                        let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
                        if (grossAmoun > totalDeduction) {
                            netSalary = Math.round(parseFloat(grossAmoun) - parseFloat(totalDeduction));
                        }
                        if(old_emp == value.admission_id_no){
                            var customerName =`<span>${value.customer_name}</span><input style="width:100px;" class="form-control" type="hidden" name="join_date[]" value="${value.salary_joining_date}">`;
                            var en_applicants_name = value.customer_branch;
                            var dressCondition=`<input style="width:100px;" class="form-control" type="text" value="0" name="deduction_dress[]" readonly>`
                            var fineCondition=`<input style="width:100px;" class="form-control" type="text" value="0" name="deduction_fine[]" readonly>`
                            var backChargeCondition=`<input style="width:100px;" class="form-control" type="text" value="0" name="deduction_banck_charge[]" readonly>`
                            var insCondition=`<input style="width:100px;" class="form-control" type="text" value="0" name="deduction_ins[]" readonly>`
                            var pfCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_pf[]" value="0" readonly>`
                            var stmCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_stamp[]" value="0" readonly>`
                            var trainingChargCondition=`<input style="width:100px;" class="form-control" type="text" value="0" name="deduction_training_cost[]" readonly>`
                            var loonCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_loan[]" value="0" readonly>`
                            var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${Math.round(grossAmoun)}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly readonly>`
                            var remarkCondition=`<input style="width:100px;" class="form-control remark" type="hidden" name="remark[]" value="">`;
                            var pAllowance=`<input style="width:100px;" class="form-control" type="hidden" name="post_allowance[]">`
                        }else{
                            var customerName=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control join_date" type="text" name="join_date[]" value="${value.salary_joining_date}" placeholder="Duty Rate">`
                            var en_applicants_name=`<input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">`
                            var dressCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">`
                            var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">`
                            var backChargeCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">`
                            var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">`
                            var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">`
                            var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="${Stmp}" placeholder="stamp">`
                            var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                            var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                            var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${netSalary}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly>`
                            var remarkCondition=`<input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="${Remarks}">`;
                            var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="${postAllowance}">`
                        }
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>${customerName}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" class="form-control rank" type="text" value="${value.jobpost_name}" placeholder="Rank">
                                    <input type="hidden" name="designation_id[]" value="${value.job_post_id}" placeholder="Jobpost Id">
                                    <input type="hidden" name="customer_id_ind[]" value="${value.customer_id}">
                                    <input type="hidden" name="customer_branch_id[]" value="${value.branch_id}">
                                    <input type="hidden" name="customer_atm_id[]" value="${value.atm_id}">
                                    <input class="deduction_total" type="hidden" name="deduction_total[]" value="${totalDeduction}">
                                </td>
                                <td> ${en_applicants_name}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control divided_by" type="text" name="divided_by[]" value="${totalDaysInMonth}">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="OT Qty">
                                </td>
                                <td>${value.duty_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_qty" type="hidden" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_amount" type="text" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>${value.ot_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_qty" type="hidden" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="${value.ot_amount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    ${pAllowance}
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" value="${value.grossAmount}" type="text" name="gross_salary[]" placeholder="Gross Salary">
                                </td>
                                <td>${dressCondition}</td>
                                <td>${fineCondition}</td>
                                <td>${backChargeCondition}</td>
                                <td>${insCondition}</td>
                                <td>${pfCondition}</td>
                                <td>${stmCondition}</td>
                                <td>${trainingChargCondition}</td>
                                <td>${loonCondition}</td>
                                <td>${payableCondtion}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control sing_ind" type="text" name="sing_ind[]" placeholder="SIGN OF IND.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control sing_account" type="text" name="sing_account[]" placeholder="Sign of Account">
                                </td>
                                <td>${remarkCondition}</td>
                                {{--  <td>
                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                </td>  --}}
                            </tr>`
                        );
                        counter++;
                        total_calculate();
                        old_emp= value.admission_id_no;
                    });
                    // Add event listeners for focusing and blurring inputs
                    $('.salarySheet').on('focus', 'input', function() {
                        $(this).closest('tr').addClass('selected-row');
                    }).on('blur', 'input', function() {
                        $(this).closest('tr').removeClass('selected-row');
                    });
            },
        });
        $('.show_click').removeClass('d-none');
     }

     function reCalcultateSalary(e) {
        let dutyRate=$(e).closest('tr').find('.duty_rate').val()?parseFloat($(e).closest('tr').find('.duty_rate').val()):0;
        let otRate=$(e).closest('tr').find('.ot_rate').val()?parseFloat($(e).closest('tr').find('.ot_rate').val()):0;
        let dutyQty=$(e).closest('tr').find('.duty_qty').val()?parseFloat($(e).closest('tr').find('.duty_qty').val()):0;
        let otQty=$(e).closest('tr').find('.ot_qty').val()?parseFloat($(e).closest('tr').find('.ot_qty').val()):0;
        let allownce=$(e).closest('tr').find('.post_allowance').val()?parseFloat($(e).closest('tr').find('.post_allowance').val()):0;
        let currentDate = new Date();
        //let currentMonth = currentDate.getMonth() + 1;
        //let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let currentMonth = $('.selected_month').val();
        // let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
        let totalDaysInMonth = $(e).closest('tr').find('.divided_by').val()?parseFloat($(e).closest('tr').find('.divided_by').val()):30;
        let dutyRateDay=dutyRate/totalDaysInMonth;
        let otRateDay=otRate/totalDaysInMonth;
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));

        let Fine=$(e).closest('tr').find('.deduction_fine').val()?parseFloat($(e).closest('tr').find('.deduction_fine').val()):0;
        let Loan=$(e).closest('tr').find('.deduction_loan').val()?parseFloat($(e).closest('tr').find('.deduction_loan').val()):0;
        let Hr=$(e).closest('tr').find('.deduction_hr').val()?parseFloat($(e).closest('tr').find('.deduction_hr').val()):0;
        let traningCost=$(e).closest('tr').find('.deduction_training_cost').val()?parseFloat($(e).closest('tr').find('.deduction_training_cost').val()):0;
        let ins=$(e).closest('tr').find('.deduction_ins').val()?parseFloat($(e).closest('tr').find('.deduction_ins').val()):0;
        let pf=$(e).closest('tr').find('.deduction_pf').val()?parseFloat($(e).closest('tr').find('.deduction_pf').val()):0;
        let stamp=$(e).closest('tr').find('.deduction_stamp').val()?parseFloat($(e).closest('tr').find('.deduction_stamp').val()):0;
        let dress=$(e).closest('tr').find('.deduction_dress').val()?parseFloat($(e).closest('tr').find('.deduction_dress').val()):0;
        let bank=$(e).closest('tr').find('.deduction_banck_charge').val()?parseFloat($(e).closest('tr').find('.deduction_banck_charge').val()):0;
        let detotal=$(e).closest('tr').find('.deduction_total').val()?parseFloat($(e).closest('tr').find('.deduction_total').val()):0;
        let tg= parseFloat(dutyAmount) + parseFloat(otAmount) + parseFloat(allownce);
        let td = parseFloat(Fine) + parseFloat(Loan) + parseFloat(Hr) + parseFloat(dress)+ parseFloat(bank) + parseFloat(traningCost) + parseFloat(ins) + parseFloat(pf) + parseFloat(stamp);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.gross_salary').val(parseFloat(tg).toFixed(2));
        //$(e).closest('tr').find('.total_payable').val(parseFloat(net).toFixed(2));
        $(e).closest('tr').find('.total_payable').val(Math.round(parseFloat(net)));
        total_calculate();
    }
    function total_calculate() {
        var payableTotal = 0;
        var ratOfSalaryTotal = 0; var prevDaysTotal = 0; var netTotal = 0; var otDayTotal = 0; var otRateTotal = 0; var otAmountTotal = 0; var postAlownceTotal = 0; var grossTotal = 0; var deDressTotal = 0; var deFineTotal = 0; var deBankChargeTotal = 0; var deInsTotal = 0; var dePfTotal = 0; var deStmpTotal = 0; var deTrainingTotal = 0; var deLoonTotal = 0;
        $('.duty_rate').each(function() {
            ratOfSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_qty').each(function() {
            prevDaysTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_amount').each(function() {
            netTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_qty').each(function() {
            otDayTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_rate').each(function() {
            otRateTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_amount').each(function() {
            otAmountTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.post_allowance').each(function() {
            postAlownceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.gross_salary').each(function() {
            grossTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_dress').each(function() {
            deDressTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_fine').each(function() {
            deFineTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_banck_charge').each(function() {
            deBankChargeTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_ins').each(function() {
            deInsTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_pf').each(function() {
            dePfTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_stamp').each(function() {
            deStmpTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_training_cost').each(function() {
            deTrainingTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_loan').each(function() {
            deLoonTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_payable').each(function() {
            payableTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        
        
        $('.ratOfSalaryTotal').val(parseFloat(ratOfSalaryTotal).toFixed(2));
        $('.prevDaysTotal').val(parseFloat(prevDaysTotal));
        $('.netTotal').val(parseFloat(netTotal).toFixed(2));
        $('.otDayTotal').val(parseFloat(otDayTotal));
        $('.otRateTotal').val(parseFloat(otRateTotal).toFixed(2));
        $('.otAmountTotal').val(parseFloat(otAmountTotal).toFixed(2));
        $('.postAlownceTotal').val(parseFloat(postAlownceTotal).toFixed(2));
        $('.grossTotal').val(parseFloat(grossTotal).toFixed(2));
        $('.deDressTotal').val(parseFloat(deDressTotal).toFixed(2));
        $('.deFineTotal').val(parseFloat(deFineTotal).toFixed(2));
        $('.deBankChargeTotal').val(parseFloat(deBankChargeTotal).toFixed(2));
        $('.deInsTotal').val(parseFloat(deInsTotal).toFixed(2));
        $('.dePfTotal').val(parseFloat(dePfTotal).toFixed(2));
        $('.deStmpTotal').val(parseFloat(deStmpTotal).toFixed(2));
        $('.deTrainingTotal').val(parseFloat(deTrainingTotal).toFixed(2));
        $('.deLoonTotal').val(parseFloat(deLoonTotal).toFixed(2));
        $('.payableTotal').val(parseFloat(payableTotal).toFixed(2));
       // console.log(totalSlry);

    }
</script>

@endpush
