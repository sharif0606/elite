@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Three'))
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
        left: 226px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table thead th.fixed-5,
    .table tbody td.fixed-5 {
        position: sticky;
        left: 429px; /* Cumulative width of previous columns */
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
                        <form method="post" action="{{route('salarysheet.salarySheetThreeStore')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="choices form-select multiple-remove customer_id" multiple="multiple" name="customer_id[]" id="customerSelect">
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
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Branch</b></label>
                                    <select class="select2 multiselect form-select customer_branch_id" name="branch_id[]" multiple="multiple" id="customerBranch">
                                    </select>
                                </div>
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
                                    <select required class="form-control month selectedMonth" name="month">
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
                                    <table class="table table-bordered mb-0" >
                                        <thead class="d-none show_click">
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2" class="fixed">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-3">{{__('Rank')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-4">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-5">{{__('Joining Date')}}</th>
                                                <th scope="col" rowspan="2">{{__('Basic')}}</th>
                                                <th scope="col" rowspan="2">{{__('House rent (50%)')}}</th>
                                                <th scope="col" rowspan="2">{{__('Medical')}}</th>
                                                <th scope="col" rowspan="2">{{__('Trans. Conve.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Food Allownce')}}</th>
                                                <th scope="col" rowspan="2">{{__('Post Allowance')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Wages')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Working Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Absent')}}</th>
                                                <th scope="col" rowspan="2">{{__('Vacant')}}</th>
                                                <th scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                                <th scope="col" colspan="3">{{__('Leave')}}</th>
                                                <th scope="col" colspan="8">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Wages')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT hour')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT rate (basic*30)/208')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amt.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Payable')}}</th>
                                                <th scope="col" rowspan="2">{{__('Signature')}}</th>
                                                <th scope="col" rowspan="2">{{__('Remarks')}}</th>
                                            </tr>
                                            <tr>
                                                <th>CL</th>
                                                <th>SL</th>
                                                <th>EL</th>
                                                <th data-title="(basic/30)*absent day">Absent</th>
                                                <th data-title="(basic/30)*vacant day">Vacant</th>
                                                <th>H.rent</th>
                                                <th data-title="(basic*7.5%) after one year of joining date">PF</th>
                                                <th>Adv.</th>
                                                <th>Training Cost</th>
                                                <th>Stm</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">

                                        </tbody>
                                        <tfoot class="d-none show_click">
                                            <tr>
                                               <th colspan="5" class="text-end">Total</th>
                                               <th><input class="form-control ratOfSalaryTotal" type="text" disabled></th>
                                               <th><input class="form-control houseRentTotal" type="text" disabled></th>
                                               <th><input class="form-control medicalTotal" type="text" disabled></th>
                                               <th><input class="form-control transConveTotal" type="text" disabled></th>
                                               <th><input class="form-control foodAllownceTotal" type="text" disabled></th>
                                               <th><input class="form-control postAllowanceTotal" type="text" disabled></th>
                                               <th><input class="form-control grossTotal" type="text" disabled></th>
                                               <th><input class="form-control workingTotal" type="text" style="width:60px;" disabled></th>
                                               <th><input class="form-control preDaysTotal" type="text" style="width:60px;" disabled></th>
                                               <th><input class="form-control absentTotal" type="text" disabled></th>
                                               <th><input class="form-control vacantTotal" type="text" disabled></th>
                                               <th><input class="form-control hollyFesTotal" type="text" disabled></th>
                                               <th><input class="form-control leClTotal" type="text" disabled></th>
                                               <th><input class="form-control leSlTotal" type="text" disabled></th>
                                               <th><input class="form-control leElTotal" type="text" disabled></th>
                                               <th><input class="form-control deAbsentTotal" type="text" disabled></th>
                                               <th><input class="form-control deVacantTotal" type="text" disabled></th>
                                               <th><input class="form-control deHrentTotal" type="text" disabled></th>
                                               <th><input class="form-control dePfTotal" type="text" disabled></th>
                                               <th><input class="form-control deAdvTotal" type="text" disabled></th>
                                               <th><input class="form-control deTrainingTotal" type="text" disabled></th>
                                               <th><input class="form-control deStmpTotal" type="text" disabled></th>
                                               <th><input class="form-control detotalDeduc" type="text" disabled></th>
                                               <th><input class="form-control netWageTotal" type="text" disabled></th>
                                               <th><input class="form-control otDayTotal" type="text" style="width:60px;" disabled></th>
                                               <th><input class="form-control otRateTotal" type="text" disabled></th>
                                               <th><input class="form-control otAmountTotal" type="text" disabled></th>
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
    $(document).ready(function() {
        $('#customerSelect').change(function() {
            var selectedCustomers = $(this).val();

            if (selectedCustomers.length > 0) {
                $.ajax({
                    url: "{{route('salarysheet.get_ajax_salary_branch')}}",
                    type: "GET",
                    dataType: "json",
                    data: { customer_ids:selectedCustomers },
                    success: function(data) {
                        console.log(data);
                        let optBranch = `<option value="">Select Branch</option>`;
                        if (data.length > 0) {
                            data.forEach(item => {
                                optBranch += `<option value="${item.id}">${item.brance_name}</option>`;
                            });
                        }
                        $('#customerBranch').html(optBranch).promise().done(function() {
                            $('.multiselect').select2();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            } else {
                console.log("No customers selected.");
            }
        });
    });
    function getSalaryData(e){
        var startDate=$('.year').val()+'-'+$('.month').val()+'-01';
        var endDate=$('.year').val()+'-'+$('.month').val()+'-31';
        var CustomerId=$('.customer_id').val();
        var CustomerBranchId=$('.customer_branch_id').val();
        var CustomerIdNot=$('.customer_id_not').val();
        var Year=$('.year').val();
        var Month=$('.month').val();
        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,customer_branch_id:CustomerBranchId,CustomerIdNot:CustomerIdNot,Year:Year,Month:Month },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    var old_emp = '';
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_remaining_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_remaining_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let foodAllowance= (value.bn_food_allowance > 0) ? value.bn_food_allowance : '0';
                        let joiningDate = new Date(value.salary_joining_date);
                        let sixMonthsLater = new Date(joiningDate);
                        sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 12);
                        var currentDate = new Date();
                        var month = parseInt($(".month").val());
                        var currentYear = currentDate.getFullYear();
                        var totalDays = new Date(currentYear, month, 0).getDate();
                        // Deduction calculation
                        let pf = "0";
                        if (new Date() >= sixMonthsLater && value.charge_status ==0) {
                            if(value.customer_id == 27){
                                pf = (value.cpf > 0) ? Math.round((value.duty_rate * value.cpf) / 100) : 0;
                            }else{
                                pf = (value.p_f > 0) ? value.p_f : '0';
                            }
                        }else{
                            pf = 0;
                        }
                        let Insurance = "0";
                        if (/*new Date() >= sixMonthsLater && */ value.charge_status ==0) {
                            Insurance = (value.insurance > 0) ? value.insurance : '0';
                        }else{
                            Insurance = 0;
                        }
                        //remarks
                        let RemarksArray = [
                            (value.loan_rmk) ? value.loan_rmk : '',
                            (value.salary_stop_message) ? value.salary_stop_message : ''
                        ];
                        let Remarks = RemarksArray.filter(item => item !== '').join(', ');
                        // let Fine = (value.fine > 0) ? value.fine : '0';
                        // let pillCost = (value.matterss_pillowCost > 0) ? value.matterss_pillowCost : '0';
                        // let paCutt = (value.over_paymentCut > 0) ? value.over_paymentCut : '0';
                        // let Tsim = (value.tonic_sim > 0) ? value.tonic_sim : '0';
                        // let Loan = (value.loan > 0) ? value.loan : '0';
                        // let LongLoan = (value.perinstallment_amount > 0) ? value.perinstallment_amount : '0';
                        // let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        // let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        // let Ab = (value.absent > 0) ? value.absent : '0';
                        // let Va = (value.vacant > 0) ? value.vacant : '0';
                        // let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Medical = (value.cmedical > 0) ? value.cmedical : '0';
                        let Trans = (value.ctrans_conve > 0) ? value.ctrans_conve : '0';
                        let Food = (value.cfood_allowance > 0) ? value.cfood_allowance : '0';
                        // let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Ad = (value.adv > 0) ? value.adv : '0';
                        let Stmp = (value.stmp > 0) ? value.stmp : '0';
                        let hR = (value.duty_rate > 0) ? ((value.duty_rate)*50)/100 : '0';
                        let otR = (value.duty_rate > 0) ? (((value.duty_rate)*2)/208).toFixed(2) : '0';
                        let otP = (value.ot_qty > 0) ? parseFloat(otR*(value.ot_qty)).toFixed(2) : '0';
                        let totalDeduction = parseFloat(Hr) + parseFloat(Stmp) + parseFloat(Ad) + parseFloat(pf);
                        let gr = parseFloat(value.duty_rate) + parseFloat(hR);
                        let netSalary = '0';
                        if (gr > totalDeduction) {
                            netSalary = Math.round(parseFloat(gr) - parseFloat(totalDeduction));
                        }
                        /* Leave Field From Customer Duty */
                        let absent = (value.absent > 0) ? value.absent : '0';
                        let vacant = (value.vacant > 0) ? value.vacant : '0';
                        let holiday_festival = (value.holiday_festival > 0) ? value.holiday_festival : '0';
                        let leave_cl = (value.leave_cl > 0) ? value.leave_cl : '0';
                        let leave_sl = (value.leave_sl > 0) ? value.leave_sl : '0';
                        let leave_el = (value.leave_el > 0) ? value.leave_el : '0';

                        // if(old_emp == value.admission_id_no){
                        if(value.duty_qty == 0){
                            var customerName =`<span>${value.customer_name}</span><input style="width:100px;" class="form-control" type="hidden" name="joining_date[]" value="${value.salary_joining_date}">`;
                            var en_applicants_name = value.customer_branch;
                            var food=`<input style="width:100px;" class="form-control" type="hidden" name="food_allownce[]" value="0" readonly>`;
                            var post_allowance=`<input style="width:100px;" class="form-control" type="text" name="post_allowance[]" value="0" readonly>`;
                            var absentCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_absent[]" value="0" readonly>`
                            var vacantCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_vacant[]" value="0" readonly>`
                            var hrentCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_h_rent[]" value="0" readonly>`
                            var pfCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_p_f[]" value="0" readonly>`
                            var advCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_adv[]" value="0" readonly>`
                             var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                            var stmCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_stm[]" value="0" readonly>`
                            var deTotalCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_total[]" value="0" readonly>`
                            var netSalaryCondition=`<input style="width:100px;" class="form-control net_wages" type="text" name="net_wages[]" value="${Math.round(gr)}" readonly>`
                            var remarkCondition=`<input style="width:100px;" class="form-control remark" type="hidden" name="remark[]" value="">`;
                        }else{
                            var customerName =`<input onkeyup="reCalcultateSalary(this)"  style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.salary_joining_date}" readonly>`;
                            var en_applicants_name=`<input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">`
                            var food=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control food_allownce" type="text" name="food_allownce[]" value="${Food}">`;
                            var post_allowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="0">`;
                            var absentCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_absent" type="text" name="deduction_absent[]" value="${Math.trunc(absent)}" placeholder="Absent" readonly>`
                            var vacantCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_vacant" type="text" name="deduction_vacant[]" value="${Math.trunc(vacant)}" placeholder="Vacant" readonly>`
                            var hrentCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_h_rent" type="text" name="deduction_h_rent[]" value="${Hr}" placeholder="H.rent">`
                            var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="PF" readonly>`
                            var advCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_adv" type="text" name="deduction_adv[]" value="${Ad}" placeholder="Adv">`
                             var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                            var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stm" type="text" name="deduction_stm[]" value="${Stmp}" placeholder="Stm">`
                            var deTotalCondition=`<input style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="${totalDeduction}" placeholder="Total" readonly>`
                            var netSalaryCondition=`<input style="width:100px;" class="form-control net_wages" type="text" name="net_wages[]" value="${Math.round(netSalary)}" placeholder="Net Wages" readonly>`
                            var remarkCondition=`<input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="${Remarks}">`;
                        }
                        selectElement.append(
                            `<tr>
                                <td class="fixed">${counter + 1}</td>
                                <td class="fixed-2">${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td class="fixed-3">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input class="form-control rank" type="hidden" name="designation_id[]" value="${value.jobpost_id}" placeholder="Desingation">
                                    <input type="hidden" name="customer_id_ind[]" value="${value.customer_id}">
                                    <input type="hidden" name="customer_branch_id[]" value="${value.branch_id}">
                                    <input type="hidden" name="customer_atm_id[]" value="${value.atm_id}">
                                </td>
                                <td class="fixed-4">${en_applicants_name}</td>
                                <td class="fixed-5">${customerName}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control house_rent" type="text" name="house_rent[]" value="${hR}" placeholder="House rent (50%)">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control medical" type="text" name="medical[]" value="${Medical}" placeholder="Medical">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control trans_conve" type="text" name="trans_conve[]" value="${Trans}" placeholder="Trans. Conve.">
                                </td>
                                <td>${food}</td>
                                 <td>${post_allowance}</td>
                                <td>
                                    <input style="width:100px;" class="form-control gross_wages" type="text" name="gross_wages[]" value="${gr}" placeholder="Gross Wages" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_workingDay" type="number" name="total_workingDay[]" value="${value.duty_qty}" placeholder="Total Working Days" readonly>
                                </td>
                                <td>${value.duty_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control present_day" type="hidden" name="present_day[]" value="${value.duty_qty}" placeholder="Pre. Days">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="${Math.trunc(absent)}" placeholder="Absent" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="${Math.trunc(vacant)}" placeholder="Vacant" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="${Math.trunc(holiday_festival)}" placeholder="Holiday/ festival" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="${Math.trunc(leave_cl)}" placeholder="Leave CL" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="${Math.trunc(leave_sl)}" placeholder="Leave SL" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="${Math.trunc(leave_el)}" placeholder="Leave EL" readonly>
                                </td>
                                <td>${absentCondition}</td>
                                <td>${vacantCondition}</td>
                                <td>${hrentCondition}</td>
                                <td>${pfCondition}</td>
                                <td>${advCondition}</td>
                                <td>${trainingChargCondition}</td>
                                <td>${stmCondition}</td>
                                <td>${deTotalCondition}</td>
                                <td>${netSalaryCondition}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_hour" type="text" name="ot_hour[]" value="${value.ot_qty}" placeholder="OT hour">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate_basicDuble" type="text" name="ot_rate_basicDuble[]" value="${otR}" placeholder="OT rate(Basic*2)">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control ot_amt" type="text" name="ot_amt[]" value="${otP}" placeholder="OT Amt." readonly>
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_payable" type="text" name="total_payable[]" value="" placeholder="Total Payable" readonly>
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature" type="text" name="signature[]" value="" placeholder="Signature">
                                </td>
                                <td>${remarkCondition}</td>
                            </tr>`
                        );
                        // Call reCalculateSalary on all inputs explicitly
                        $(`.salarySheet tr:last input`).each(function () {
                            reCalcultateSalary(this);
                        });
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
        let hore= (dutyRate*50)/100;
        let medi=$(e).closest('tr').find('.medical').val()?parseFloat($(e).closest('tr').find('.medical').val()):0;
        let trcon=$(e).closest('tr').find('.trans_conve').val()?parseFloat($(e).closest('tr').find('.trans_conve').val()):0;
        let foodallow=$(e).closest('tr').find('.food_allownce').val()?parseFloat($(e).closest('tr').find('.food_allownce').val()):0;
        let post_allow=$(e).closest('tr').find('.post_allowance').val()?parseFloat($(e).closest('tr').find('.post_allowance').val()):0;
        let grw = parseFloat(dutyRate) + parseFloat(hore) + parseFloat(medi) + parseFloat(trcon) + parseFloat(foodallow) + parseFloat(post_allow);
        $(e).closest('tr').find('.house_rent').val(parseFloat(hore).toFixed(2));
        $(e).closest('tr').find('.gross_wages').val(parseFloat(grw).toFixed(2));

        let presentTotal=$(e).closest('tr').find('.present_day').val()?parseFloat($(e).closest('tr').find('.present_day').val()):0;
        let absenttTotal=$(e).closest('tr').find('.absent').val()?parseFloat($(e).closest('tr').find('.absent').val()):0;
        let vacantTotal=$(e).closest('tr').find('.vacant').val()?parseFloat($(e).closest('tr').find('.vacant').val()):0;
        let holyTotal=$(e).closest('tr').find('.holiday_festival').val()?parseFloat($(e).closest('tr').find('.holiday_festival').val()):0;
        let levelClTotal=$(e).closest('tr').find('.leave_cl').val()?parseFloat($(e).closest('tr').find('.leave_cl').val()):0;
        let levelSlTotal=$(e).closest('tr').find('.leave_sl').val()?parseFloat($(e).closest('tr').find('.leave_sl').val()):0;
        let levelElTotal=$(e).closest('tr').find('.leave_el').val()?parseFloat($(e).closest('tr').find('.leave_el').val()):0;
        let totalWorkingDay = parseFloat(presentTotal) + parseFloat(absenttTotal) + parseFloat(vacantTotal) + parseFloat(holyTotal) + parseFloat(levelClTotal) + parseFloat(levelSlTotal) + parseFloat(levelElTotal);
        let absentDeduction = (dutyRate/30)*absenttTotal;
        let vacantDeduction = (grw/totalWorkingDay)*vacantTotal;
        $(e).closest('tr').find('.total_workingDay').val(parseFloat(totalWorkingDay));
        $(e).closest('tr').find('.deduction_absent').val(parseFloat(absentDeduction).toFixed(2));
        $(e).closest('tr').find('.deduction_vacant').val(parseFloat(vacantDeduction).toFixed(2));

        let deductionAbsent=$(e).closest('tr').find('.deduction_absent').val()?parseFloat($(e).closest('tr').find('.deduction_absent').val()):0;
        let deductionVacant=$(e).closest('tr').find('.deduction_vacant').val()?parseFloat($(e).closest('tr').find('.deduction_vacant').val()):0;
        let deductionHr=$(e).closest('tr').find('.deduction_h_rent').val()?parseFloat($(e).closest('tr').find('.deduction_h_rent').val()):0;
        let deductionAdv=$(e).closest('tr').find('.deduction_adv').val()?parseFloat($(e).closest('tr').find('.deduction_adv').val()):0;
        let deductionTrainingCost=$(e).closest('tr').find('.deduction_training_cost').val()?parseFloat($(e).closest('tr').find('.deduction_training_cost').val()):0;
        let deductionPf=$(e).closest('tr').find('.deduction_p_f').val()?parseFloat($(e).closest('tr').find('.deduction_p_f').val()):0;
        let stamp=$(e).closest('tr').find('.deduction_stm').val()?parseFloat($(e).closest('tr').find('.deduction_stm').val()):0;
        let totalDeduction = parseFloat(deductionAbsent) + parseFloat(deductionVacant) + parseFloat(deductionHr) + parseFloat(deductionAdv) + parseFloat(deductionTrainingCost) + parseFloat(deductionPf) + parseFloat(stamp);
        let net = parseFloat(grw) - parseFloat(totalDeduction);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(totalDeduction).toFixed(2));
        $(e).closest('tr').find('.net_wages').val(parseFloat(net).toFixed(2));


        let otHour=$(e).closest('tr').find('.ot_hour').val()?parseFloat($(e).closest('tr').find('.ot_hour').val()):0;
        let otRate=$(e).closest('tr').find('.ot_rate_basicDuble').val()?parseFloat($(e).closest('tr').find('.ot_rate_basicDuble').val()):0;
        let otAmount = otRate*otHour;
        $(e).closest('tr').find('.net_wages').val(Math.round(parseFloat(net)));

        $(e).closest('tr').find('.ot_amt').val(parseFloat(otAmount).toFixed(2));
        let payableTotal = net+otAmount;
        $(e).closest('tr').find('.total_payable').val(Math.round(parseFloat(payableTotal)));
        total_calculate();
    }
    function total_calculate() {
        var payableTotal = 0;
        var ratOfSalaryTotal = 0; var houseRentTotal = 0; var medicalTotal = 0; var transConveTotal=0; foodAllownceTotal=0; var postAllowanceTotal = 0;var grossTotal=0; var workingTotal=0; var preDaysTotal = 0; var absentTotal=0; var vacantTotal=0; var hollyFesTotal=0; var leClTotal=0; var leSlTotal=0; var leElTotal=0; var deAbsentTotal=0; var deVacantTotal=0; var deHrentTotal=0; var dePfTotal=0; var deAdvTotal=0; var deTrainingTotal = 0; var deStmpTotal=0; var detotalDeduc=0; var netWageTotal = 0; var otDayTotal = 0; var otRateTotal = 0; var otAmountTotal = 0;
        $('.duty_rate').each(function() {
            ratOfSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.house_rent').each(function() {
            houseRentTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.medical').each(function() {
            medicalTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.trans_conve').each(function() {
            transConveTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.food_allownce').each(function() {
            foodAllownceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.post_allowance').each(function() {
            postAllowanceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        
        $('.gross_wages').each(function() {
            grossTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_workingDay').each(function() {
            workingTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.present_day').each(function() {
            preDaysTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.absent').each(function() {
            absentTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.vacant').each(function() {
            vacantTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.holiday_festival').each(function() {
            hollyFesTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.leave_cl').each(function() {
            leClTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.leave_sl').each(function() {
            leSlTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.leave_el').each(function() {
            leElTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_absent').each(function() {
            deAbsentTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_vacant').each(function() {
            deVacantTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_h_rent').each(function() {
            deHrentTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_p_f').each(function() {
            dePfTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_adv').each(function() {
            deAdvTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_training_cost').each(function() {
            deTrainingTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_stm').each(function() {
            deStmpTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_total').each(function() {
            detotalDeduc+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.net_wages').each(function() {
            netWageTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_hour').each(function() {
            otDayTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_rate_basicDuble').each(function() {
            otRateTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_amt').each(function() {
            otAmountTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_payable').each(function() {
            payableTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        
        
        $('.ratOfSalaryTotal').val(parseFloat(ratOfSalaryTotal).toFixed(2));
        $('.houseRentTotal').val(parseFloat(houseRentTotal).toFixed(2));
        $('.medicalTotal').val(parseFloat(medicalTotal).toFixed(2));
        $('.transConveTotal').val(parseFloat(transConveTotal).toFixed(2));
        $('.foodAllownceTotal').val(parseFloat(foodAllownceTotal).toFixed(2));
        $('.postAllowanceTotal').val(parseFloat(postAllowanceTotal).toFixed(2));
        $('.grossTotal').val(parseFloat(grossTotal).toFixed(2));
        $('.workingTotal').val(parseFloat(workingTotal));
        $('.preDaysTotal').val(parseFloat(preDaysTotal));
        $('.absentTotal').val(parseFloat(absentTotal));
        $('.vacantTotal').val(parseFloat(vacantTotal));
        $('.hollyFesTotal').val(parseFloat(hollyFesTotal));
        $('.leClTotal').val(parseFloat(leClTotal));
        $('.leSlTotal').val(parseFloat(leSlTotal));
        $('.leElTotal').val(parseFloat(leElTotal));
        $('.deAbsentTotal').val(parseFloat(deAbsentTotal).toFixed(2));
        $('.deVacantTotal').val(parseFloat(deVacantTotal).toFixed(2));
        $('.deHrentTotal').val(parseFloat(deHrentTotal).toFixed(2));
        $('.dePfTotal').val(parseFloat(dePfTotal).toFixed(2));
        $('.deAdvTotal').val(parseFloat(deAdvTotal).toFixed(2));
        $('.deTrainingTotal').val(parseFloat(deTrainingTotal).toFixed(2));
        $('.deStmpTotal').val(parseFloat(deStmpTotal).toFixed(2));
        $('.detotalDeduc').val(parseFloat(detotalDeduc).toFixed(2));
        $('.netWageTotal').val(parseFloat(netWageTotal).toFixed(2));
        $('.otDayTotal').val(parseFloat(otDayTotal));
        $('.otRateTotal').val(parseFloat(otRateTotal).toFixed(2));
        $('.otAmountTotal').val(parseFloat(otAmountTotal).toFixed(2));
        $('.payableTotal').val(parseFloat(payableTotal).toFixed(2));
       // console.log(totalSlry);

    }
</script>

@endpush
