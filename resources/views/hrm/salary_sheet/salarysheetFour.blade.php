@extends('layout.app')

@section('pageTitle',trans('Office Staff Salary'))
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
    .table {
        width: 100%;
        overflow-x: auto; /* Ensures the table can be scrolled horizontally */
    }

    .table thead th.fixed,
    .table tbody td.fixed {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }

    .table thead th.fixed-2,
    .table tbody td.fixed-2 {
        position: sticky;
        left: 28px; /* Ensure this matches the total width of the preceding column(s) */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }

    .table thead th.fixed-3,
    .table tbody td.fixed-3 {
        position: sticky;
        left: 71px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table thead th.fixed-4,
    .table tbody td.fixed-4 {
        position: sticky;
        left: 176px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table thead th.fixed-5,
    .table tbody td.fixed-5 {
        position: sticky;
        left: 333px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table tbody tr.selected-row td.fixed,
    .table tbody tr.selected-row td.fixed-2,
    .table tbody tr.selected-row td.fixed-3,
    .table tbody tr.selected-row td.fixed-4,
    .table tbody tr.selected-row td.fixed-5 {
        background-color: rgb(189, 245, 189); /* Match selected-row background color */
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
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="d-none show_click">
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2" class="fixed">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-3">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-4">{{__('Rank & Joining date')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-5">{{__('Name')}}</th>
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
                                        <tfoot class="d-none show_click">
                                            <tr>
                                               <th colspan="5" class="text-end"> Total</th>
                                               <th><input class="form-control ratOfSalaryTotal" type="text" disabled></th>
                                               <th><input class="form-control houseRentTotal" type="text" disabled></th>
                                               <th><input class="form-control mediAllownTotal" type="text" disabled></th>
                                               <th><input class="form-control grossSalaryTotal" type="text" disabled></th>
                                               <th><input class="form-control presDaysTotal" type="text" disabled></th>
                                               <th><input class="form-control otDayTotal" type="text" disabled></th>
                                               <th><input class="form-control otRateTotal" type="text" disabled></th>
                                               <th><input class="form-control otAmountTotal" type="text" disabled></th>
                                               <th><input class="form-control postAllowTotal" type="text" disabled></th>
                                               <th><input class="form-control fuelBillTotal" type="text" disabled></th>
                                               <th><input class="form-control salaryTotal" type="text" disabled></th>
                                               <th><input class="form-control deMobileExTotal" type="text" disabled></th>
                                               <th><input class="form-control deFineTotal" type="text" disabled></th>
                                               <th><input class="form-control deInsTotal" type="text" disabled></th>
                                               <th><input class="form-control dePfTotal" type="text" disabled></th>
                                               <th><input class="form-control deMessTotal" type="text" disabled></th>
                                               <th><input class="form-control deLoonTotal" type="text" disabled></th>
                                               <th><input class="form-control deTrainingTotal" type="text" disabled></th>
                                               <th><input class="form-control payableTotal" type="text" disabled></th>
                                           </tr> 
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
    // Add event listeners for focusing and blurring inputs
    $('.salarySheet').on('focus', 'input', function() {
        $(this).closest('tr').addClass('selected-row');
    }).on('blur', 'input', function() {
        $(this).closest('tr').removeClass('selected-row');
    });
</script>
<script>
    function getSalaryData(e){
        var startDate=$('.year').val()+'-'+$('.month').val()+'-01';
        var endDate=$('.year').val()+'-'+$('.month').val()+'-31';
        var Year=$('.year').val();
        var Month=$('.month').val();

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_four_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,Year:Year,Month:Month },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_remaining_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_remaining_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let postAllowance= (value.bn_post_allowance > 0) ? value.bn_post_allowance : '0';
                        let joiningDate = new Date(value.salary_joining_date);
                        let threeMonthsLater = new Date(joiningDate);
                        threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);

                        // Deduction calculation
                        let pf = "0";
                        if (new Date() >= threeMonthsLater) {
                            pf = "1000";
                        }
                        let Insurance = "100";
                        let medical = "1500";
                        let grossSalaryAmount = (value.gross_salary > 0) ? value.gross_salary : '0';
                        let otSalaryAmount = (value.ot_salary > 0) ? value.ot_salary : '0';
                        let basicSalary = ((value.gross_salary*70)/100).toFixed(2);
                        let houseRent = (grossSalaryAmount - basicSalary - medical).toFixed(2);
                        // if (new Date() >= threeMonthsLater) {
                        //     Insurance = (value.insurance > 0) ? value.insurance : '0';
                        // }
                        let Fine = (value.fine > 0) ? value.fine : '0';
                        let RemarksArray = [
                            (value.loan_rmk) ? value.loan_rmk : '',
                            (value.salary_stop_message) ? value.salary_stop_message : ''
                        ];
                        let Remarks = RemarksArray.filter(item => item !== '').join(', ');
                        let em = (value.excess_mobile > 0) ? value.excess_mobile : '0';
                        let mess = (value.mess > 0) ? value.mess : '0';
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        // there fuel is allownce. it will add with total salary
                        let fuelBill = (value.fuel_bill > 0) ? value.fuel_bill : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(em) + parseFloat(Loan) + parseFloat(mess) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                        selectElement.append(
                            `<tr>
                                <td class="fixed">${counter + 1}</td>
                                <td class="fixed-2">${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td class="fixed-3">
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.salary_joining_date}" placeholder="Date of Joining">
                                </td>
                                <td class="fixed-4">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input class="form-control rank" type="hidden" name="designation_id[]" value="${value.jobpost_id}" placeholder="Desingation">
                                </td>
                                <td class="fixed-5">
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
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_qty" type="text" name="duty_qty[]" value="0" placeholder="Duty Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_qty" type="text" name="ot_qty[]" value="0" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${otSalaryAmount}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input readonly onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="0" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allow" type="text" name="post_allow[]" value="${postAllowance}" placeholder="Post Allow.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control fuel_bill" type="text" name="fuel_bill[]" value="${fuelBill}" placeholder="Fuel Bill">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_salary" type="text" name="total_salary[]" value="0" placeholder="Total Salary" readonly>
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
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_payble" type="text" name="total_payble[]" value="0" placeholder="Total Payble">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature_ind" type="text" name="signature_ind[]" value="" placeholder="SIG OF IND.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature_accounts" type="text" name="signature_accounts[]" value="" placeholder="Sing of Accounts">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control remarks" type="text" name="remarks[]" value="${Remarks}" placeholder="Remarks">
                                </td>
                                {{--  <td>
                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                </td>  --}}
                            </tr>`
                        );
                        counter++;
                        total_calculate()
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
        //let otRateDay=otRate/totalDaysInMonth;
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRate*otQty);
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
        $(e).closest('tr').find('.total_payble').val(Math.round(parseFloat(net)));
        total_calculate();
    }
    function total_calculate() {
        var ratOfSalaryTotal = 0, houseRentTotal = 0, mediAllownTotal = 0, grossSalaryTotal = 0, presDaysTotal = 0, otDayTotal = 0, otRateTotal = 0, otAmountTotal = 0, postAllowTotal = 0, fuelBillTotal = 0, salaryTotal = 0, deMobileExTotal = 0, deFineTotal = 0, deInsTotal = 0, dePfTotal = 0, deMessTotal = 0, deLoonTotal = 0, deTrainingTotal = 0, payableTotal = 0;

        $('.duty_rate').each(function() {
            ratOfSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.house_rent').each(function() {
            houseRentTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.medical_allowance').each(function() {
            mediAllownTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.gross_salary').each(function() {
            grossSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_qty').each(function() {
            presDaysTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
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
        $('.post_allow').each(function() {
            postAllowTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.fuel_bill').each(function() {
            fuelBillTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_salary').each(function() {
            salaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_excess_mobile').each(function() {
            deMobileExTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_fine').each(function() {
            deFineTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_ins').each(function() {
            deInsTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_p_f').each(function() {
            dePfTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_mess').each(function() {
            deMessTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_loan').each(function() {
            deLoonTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_traning_cost').each(function() {
            deTrainingTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_payble').each(function() {
            payableTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        
        $('.ratOfSalaryTotal').val(parseFloat(ratOfSalaryTotal).toFixed(2));
        $('.houseRentTotal').val(parseFloat(houseRentTotal).toFixed(2));
        $('.mediAllownTotal').val(parseFloat(mediAllownTotal).toFixed(2));
        $('.grossSalaryTotal').val(parseFloat(grossSalaryTotal).toFixed(2));
        $('.presDaysTotal').val(parseFloat(presDaysTotal));
        $('.otDayTotal').val(parseFloat(otDayTotal));
        $('.otRateTotal').val(parseFloat(otRateTotal).toFixed(2));
        $('.otAmountTotal').val(parseFloat(otAmountTotal).toFixed(2));
        $('.postAllowTotal').val(parseFloat(postAllowTotal).toFixed(2));
        $('.fuelBillTotal').val(parseFloat(fuelBillTotal).toFixed(2));
        $('.salaryTotal').val(parseFloat(salaryTotal).toFixed(2));
        $('.deMobileExTotal').val(parseFloat(deMobileExTotal).toFixed(2));
        $('.deFineTotal').val(parseFloat(deFineTotal).toFixed(2));
        $('.deInsTotal').val(parseFloat(deInsTotal).toFixed(2));
        $('.dePfTotal').val(parseFloat(dePfTotal).toFixed(2));
        $('.deMessTotal').val(parseFloat(deMessTotal).toFixed(2));
        $('.deLoonTotal').val(parseFloat(deLoonTotal).toFixed(2));
        $('.deTrainingTotal').val(parseFloat(deTrainingTotal).toFixed(2));
        $('.payableTotal').val(parseFloat(payableTotal).toFixed(2));
    }
</script>
<script>
    function checkSelectBoxes() {
        var yearSelect = document.querySelector('.year');
        var monthSelect = document.querySelector('.month');

        var generateButton = document.getElementById('generateButton');
        var submitButton = document.getElementById('submitButton');

        if (yearSelect.value && monthSelect.value) {
            generateButton.disabled = false;
            submitButton.disabled = false;
        } else {
            generateButton.disabled = true;
            submitButton.disabled = true;
        }
    }
</script>

@endpush
