@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Four'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .myDIV {
      writing-mode: vertical-lr;
      text-orientation: mixed;
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('salarysheet.salarySheetFourStore')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select onchange="checkSelectBoxes()" class="choices form-select multiple-remove customer_id" multiple="multiple" name="customer_id[]">
                                        <optgroup label="Select Customer">
                                            @forelse ($customer as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                {{-- <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Name Not</b></label>
                                    <select class="choices form-select multiple-remove customer_id_not" multiple="multiple" name="customer_id_not[]" readonly>
                                        <optgroup label="Select Customer">
                                            @forelse ($customer as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <div class="row">
                                        <div class="col-lg-4 mt-2">
                                            <label for=""><b>Salary Year</b></label>
                                            <select onchange="checkSelectBoxes()" required class="form-control year" name="year">
                                                <option value="">Select Year</option>
                                                @for($i=2023;$i<= date('Y');$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            <label for=""><b>Salary Month</b></label>
                                            <select onchange="checkSelectBoxes()" required class="form-control month selected_month" name="month">
                                                <option value="">Select Month</option>
                                                @for($i=1;$i<= 12;$i++)
                                                <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                                @endfor
                                            </select>
                                        </div>
        
                                        <div class="col-lg-4 mt-4 p-0">
                                            <button id="generateButton" onclick="getSalaryData()" type="button" class="btn btn-primary" disabled>Generate Salary</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="d-none show_click">
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rank & Joining date')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Basic')}}</th>
                                                <th scope="col" rowspan="2">{{__('House rent')}}</th>
                                                <th scope="col" rowspan="2">{{__('Medical Allowance')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amt')}}</th>
                                                <th scope="col" rowspan="2">{{__('Post Allow.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Fuel Bill')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Salary')}}</th>
                                                <th scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Payble')}}</th>
                                                <th scope="col" rowspan="2">{{__('SIG OF IND.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Sing of Accounts')}}</th>
                                                <th scope="col" rowspan="2">{{__('Remarks')}}</th>
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>Excess Mobile</th>
                                                <th>fine</th>
                                                <th>Ins</th>
                                                <th>P.F</th>
                                                <th>Mess</th>
                                                <th>Loan</th>
                                                <th>Training Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">

                                        </tbody>
                                        <tfoot>
                                            {{--  <tr>
                                                <td></td>
                                                <td></td>
                                                <td> Total</td>
                                                <td><input onkeyup="reCalcultateSalary(this)" class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></td>
                                                <td></td>
                                            </tr>  --}}
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary" id="submitButton" >Save</button>
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
        {{--  if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }  --}}
        var startDate=$('.year').val()+'-'+$('.month').val()+'-01';
        var endDate=$('.year').val()+'-'+$('.month').val()+'-31';
        var CustomerId=$('.customer_id').val();
        var CustomerIdNot=$('.customer_id_not').val();
        var Year=$('.year').val();
        var Month=$('.month').val();

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_four_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,CustomerIdNot:CustomerIdNot,Year:Year,Month:Month },
            success: function(salary_data) {
                //console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_traning_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_traning_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let joiningDate = new Date(value.joining_date);
                        let threeMonthsLater = new Date(joiningDate);
                        threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);

                        // Deduction calculation
                        let pf = "0";
                        if (new Date() >= threeMonthsLater) {
                            pf = "1000";
                        }
                        let Insurance = "100";
                        let medical = "1500";
                        let grossSalaryAmount = (value.duty_rate > 0) ? value.duty_rate : '0';
                        let basicSalary = ((value.duty_rate*70)/100).toFixed(2);
                        let houseRent = (grossSalaryAmount - basicSalary - medical).toFixed(2);
                        // if (new Date() >= threeMonthsLater) {
                        //     Insurance = (value.insurance > 0) ? value.insurance : '0';
                        // }
                        let Fine = (value.fine > 0) ? value.fine : '0';
                        let em = (value.excess_mobile > 0) ? value.excess_mobile : '0';
                        let mess = (value.mess > 0) ? value.mess : '0';
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        let postAllounce = (value.loan > 0) ? value.loan : '0';
                        let fuelBill = (value.loan > 0) ? value.loan : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(em) + parseFloat(Loan) + parseFloat(mess) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                        let currentMonth = $('.selected_month').val();
                        let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
                        let orRate = value.ot_rate/totalDaysInMonth;
                        let otAmount=(orRate*value.ot_qty).toFixed(2);
                        let grossSalary = ((grossSalaryAmount/totalDaysInMonth)*value.duty_qty).toFixed(2)
                        let totalSalary = parseFloat(grossSalary) + parseFloat(otAmount);
                        let netSalary = '0';
                        if (totalSalary > totalDeduction) {
                            netSalary = parseFloat(totalSalary) - parseFloat(totalDeduction);
                        }
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" placeholder="Date of Joining">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control rank" type="hidden" name="designation_id[]" value="${value.jobpost_id}" placeholder="Desingation">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" type="hidden" name="customer_id_ind[]" value="${value.customer_id}" placeholder="Customer Id">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${basicSalary}" placeholder="Monthlay Salary" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control house_rent" type="text" name="house_rent[]" value="${houseRent}" placeholder="House rent" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control medical_allowance" type="text" name="medical_allowance[]" value="${medical}" placeholder="Medical Allowance" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="${grossSalaryAmount}" placeholder="Duty Amount">
                                </td>
                                <td>${value.duty_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_qty" type="hidden" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
                                </td>
                                <td>${value.ot_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_qty" type="hidden" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input readonly onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="${otAmount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allow" type="text" name="post_allow[]" value="" placeholder="Post Allow.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control fuel_bill" type="text" name="fuel_bill[]" value="" placeholder="Fuel Bill">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_salary" type="text" name="total_salary[]" value="${totalSalary}" placeholder="Total Salary" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_excess_mobile" type="text" name="deduction_excess_mobile[]" value="${em}" placeholder="Excess Mobile">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="${Fine}" placeholder="Fine">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="${Insurance}" placeholder="Ins">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="P.F">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_mess" type="text" name="deduction_mess[]" value="${mess}" placeholder="Mess">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_traning_cost" type="text" name="deduction_traning_cost[]" value="${traningCostPerMonth}" placeholder="Training Cost">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_payble" type="text" name="total_payble[]" value="${netSalary}" placeholder="Total Payble">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature_ind" type="text" name="signature_ind[]" value="" placeholder="SIG OF IND.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature_accounts" type="text" name="signature_accounts[]" value="" placeholder="Sing of Accounts">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control remarks" type="text" name="remarks[]" value="" placeholder="Remarks">
                                </td>
                                {{--  <td>
                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                </td>  --}}
                            </tr>`
                        );
                        counter++;
                    });
            },
        });
        $('.show_click').removeClass('d-none');
     }

     function reCalcultateSalary(e) {

        let grossTotal=$(e).closest('tr').find('.gross_salary').val()?parseFloat($(e).closest('tr').find('.gross_salary').val()):0;
        let Mallownce=$(e).closest('tr').find('.medical_allowance').val()?parseFloat($(e).closest('tr').find('.medical_allowance').val()):0;
        let basicSalary = (grossTotal*70)/100;
        let houseRent = grossTotal-basicSalary-Mallownce;
        $(e).closest('tr').find('.duty_rate').val(parseFloat(basicSalary).toFixed(2));
        $(e).closest('tr').find('.house_rent').val(parseFloat(houseRent).toFixed(2));
        //let dutyRate=$(e).closest('tr').find('.duty_rate').val()?parseFloat($(e).closest('tr').find('.duty_rate').val()):0;
        let otRate=$(e).closest('tr').find('.ot_rate').val()?parseFloat($(e).closest('tr').find('.ot_rate').val()):0;
        let dutyQty=$(e).closest('tr').find('.duty_qty').val()?parseFloat($(e).closest('tr').find('.duty_qty').val()):0;
        let otQty=$(e).closest('tr').find('.ot_qty').val()?parseFloat($(e).closest('tr').find('.ot_qty').val()):0;
        //let Hor=$(e).closest('tr').find('.house_rent').val()?parseFloat($(e).closest('tr').find('.house_rent').val()):0;
        let Pallownce=$(e).closest('tr').find('.post_allow').val()?parseFloat($(e).closest('tr').find('.post_allow').val()):0;
        let fbill=$(e).closest('tr').find('.fuel_bill').val()?parseFloat($(e).closest('tr').find('.fuel_bill').val()):0;
        let currentMonth = $('.selected_month').val();
        let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
        let dutyRateDay=grossTotal/totalDaysInMonth;
        let otRateDay=otRate/totalDaysInMonth;
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));

        let Fine=$(e).closest('tr').find('.deduction_fine').val()?parseFloat($(e).closest('tr').find('.deduction_fine').val()):0;
        let MobileBill=$(e).closest('tr').find('.deduction_excess_mobile').val()?parseFloat($(e).closest('tr').find('.deduction_excess_mobile').val()):0;
        let Loan=$(e).closest('tr').find('.deduction_loan').val()?parseFloat($(e).closest('tr').find('.deduction_loan').val()):0;
        let ins=$(e).closest('tr').find('.deduction_ins').val()?parseFloat($(e).closest('tr').find('.deduction_ins').val()):0;
        let pf=$(e).closest('tr').find('.deduction_p_f').val()?parseFloat($(e).closest('tr').find('.deduction_p_f').val()):0;
        let traningCost=$(e).closest('tr').find('.deduction_traning_cost').val()?parseFloat($(e).closest('tr').find('.deduction_traning_cost').val()):0;
        let mess=$(e).closest('tr').find('.deduction_mess').val()?parseFloat($(e).closest('tr').find('.deduction_mess').val()):0;
        let tg= parseFloat(dutyAmount) + parseFloat(otAmount) + parseFloat(Pallownce) + parseFloat(fbill);
        let td = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(mess) + parseFloat(traningCost) + parseFloat(ins) + parseFloat(pf);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.total_salary').val(parseFloat(tg).toFixed(2));
        $(e).closest('tr').find('.total_payble').val(parseFloat(net).toFixed(2));

    }
</script>
<script>
    function checkSelectBoxes() {
        var customerSelect = document.querySelector('.customer_id');
        var yearSelect = document.querySelector('.year');
        var monthSelect = document.querySelector('.month');

        var generateButton = document.getElementById('generateButton');
        var submitButton = document.getElementById('submitButton');

        if (customerSelect.value && yearSelect.value && monthSelect.value) {
            generateButton.disabled = false;
            submitButton.disabled = false;
        } else {
            generateButton.disabled = true;
            submitButton.disabled = true;
        }
    }
</script>

@endpush
