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
                        <form method="post" action="{{route('salarysheet.salarySheetFiveStore')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
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
                                                <th scope="col" rowspan="2" class="myDIV fixed">{{__('SL.No')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-3">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-4">{{__('Rank')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-5">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name_of_bank')}}</th>
                                                <th scope="col" rowspan="2">{{__('branch_name')}}</th>
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
                                                <th scope="col" rowspan="2">{{__('Divide By')}}</th>
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
                                                <th colspan="7" class="text-end"> Total</th>
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
                    let appliedDeductions = {}; // Object to track applied deductions
                    var old_emp = '';
                    if(salary_data){
                        $.each(salary_data, function(index, value) {
                            let traningCost=value.bn_remaining_cost;
                            let traningCostMonth=value.bn_traning_cost_byMonth;
                            let traningCostPerMonth=parseFloat((value.bn_remaining_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                            /* If Month Wise Post Allownace found For Any Employee bn_post_allowance from employee will not apply  */
                            let deduction_post_allowance = (value.post_allowance > 0) ? value.post_allowance : '0';
                            let postAllowance= (value.bn_post_allowance > 0) ? value.bn_post_allowance : '0';
                           
                            
                            //console.log(traningCostPerMonth);
                            let joiningDate = new Date(value.salary_joining_date);
                            let sixMonthsLater = new Date(joiningDate);
                            sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);
                            // Deduction calculation
                            let pf = 0;
                            let Insurance = 0;
                            
                            /*if (new Date() >= sixMonthsLater && value.charge_status ==0) {
                                pf = (value.p_f > 0) ? value.p_f : '0';
                            }else{
                                pf = 0;
                            }
                            let Insurance = "0";
                            if (new Date() >= sixMonthsLater && value.charge_status ==0) {
                                Insurance = (value.insurance > 0) ? value.insurance : '0';
                            }else{
                                Insurance = 0;
                            }*/
                            let Fine = (value.fine > 0) ? value.fine : '0';
                            //let Remarks = (value.remarks) ? value.remarks : '';
                            let RemarksArray = [
                                (value.loan_rmk) ? value.loan_rmk : '',
                                (value.salary_stop_message) ? value.salary_stop_message : ''
                            ];
                            let Remarks = RemarksArray.filter(item => item !== '').join(', ');
                            let Loan = (value.loan > 0) ? value.loan : '0';//comping form employee table old line now used lo
                            //if (value.charge_status ==0) {
                                Loan += (value.perinstallment_amount > 0) ? value.perinstallment_amount : '0';
                            //}
                            let Cloth = (value.cloth > 0) ? value.cloth : '0';
                            let Jacket = (value.jacket > 0) ? value.jacket : '0';
                            let Hr = (value.hr > 0) ? value.hr : '0';
                            let Cf = (value.c_f > 0) ? value.c_f : '0';
                            let Stmp = (value.stmp > 0) ? value.stmp : '0';
                            let Medical = (value.medical > 0) ? value.medical : '0';
                            let BankCharge = (value.bank_charge_exc > 0) ? value.bank_charge_exc : '0';
                            let Dress = (value.dress > 0) ? value.dress : '0';
                            let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                           
                            let netSalary = 0;
                            let currentMonth = $('.selected_month').val();
                            let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
                           

                            // Check if deductions are already applied for this employee
                            if (!appliedDeductions[value.admission_id_no]) {
                                if (value.charge_status == 0) {
                                    /* This Value Will Deduct From first Of Month New Rule Decement 1/24 */
                                    if(value.cinsurance > 0 && value.insurance == 0)
                                    Insurance = (value.cinsurance > 0) ? value.cinsurance : '0';
                                    else if(value.insurance > 0 && value.cinsurance == 0)
                                    Insurance = (value.insurance > 0) ? value.insurance : '0';
                                    else if(value.cinsurance > 0 && value.insurance > 0)
                                    Insurance = (value.insurance > 0) ? value.insurance : '0';
                                    else
                                    Insurance = 0;

                                    
                                    if(value.cstamp > 0)
                                    Stmp = (value.cstamp > 0) ? value.cstamp : '0';
                                    else if(value.stamp > 0)
                                    Stmp = (value.stamp > 0) ? value.stamp : '0';
                                    else{
                                        Stmp = 0;
                                    }
                                    
                                    traningCostPerMonth = traningCostPerMonth;
                                    Fine = Fine;
                                    Loan = Loan;

                                }else{
                                    Insurance = 0;
                                    Stmp = 0;
                                    traningCostPerMonth = 0;
                                }
                               
                               
                                if (new Date() >= sixMonthsLater && value.charge_status == 0) {
                                   
                                    if(value.cpf > 0 && value.p_f == 0)
                                    pf = (value.cpf > 0) ? value.cpf : '0';
                                    else if(value.p_f > 0 && value.cpf == 0)
                                    pf = (value.p_f > 0) ? value.p_f : '0';
                                    else if(value.cpf > 0 && value.p_f > 0)
                                    pf = (value.p_f > 0) ? value.p_f : '0';
                                    else
                                    pf = 0;
                                    
                                    if(deduction_post_allowance > 0){
                                        postAllowance = deduction_post_allowance
                                    }else{
                                        postAllowance= postAllowance;
                                    }
                                    Dress = Dress;
                                    BankCharge = BankCharge;
                                   
                                    
                                }else {
                                    pf = 0; // No further deductions
                                    postAllowance = 0;
                                    Dress = 0;
                                    //Fine = 0;
                                    BankCharge = 0;
                                    //Loan = 0;
                                }
                                // Mark deductions as applied
                                appliedDeductions[value.admission_id_no] = true;
                            } else {
                                pf = 0; // No further deductions
                                Insurance = 0;
                                Dress = 0;
                                Fine = 0;
                                BankCharge = 0;
                                Stmp = 0;
                                traningCostPerMonth = 0;
                                Loan = 0;
                            }
                            let totalDeduction = parseFloat(Fine) + parseFloat(Stmp) + parseFloat(Dress) + parseFloat(Loan) + parseFloat(BankCharge) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                            if (grossAmoun > totalDeduction) {
                                netSalary = Math.round(parseFloat(grossAmoun) - parseFloat(totalDeduction));
                                netSalary += Math.round(parseFloat(postAllowance).toFixed(2));
                            }
                            // if(old_emp == value.admission_id_no){
                                if(value.duty_qty > 0 && value.ot_qty == 0){
                                var dressCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">`
                                var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">`
                                var backChargeCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">`
                                var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">`
                                var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">`
                                var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="${Stmp}" placeholder="stamp">`
                                var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                                var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                                var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${netSalary}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly>`
                                var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="${postAllowance}">`
                                
                            }else if(value.ot_qty > 0 && value.duty_qty == 0){
                                var dressCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">`
                                var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">`
                                var backChargeCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">`
                                var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">`
                                var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">`
                                var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="${Stmp}" placeholder="stamp">`
                                var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                                var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                                var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${netSalary}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly>`
                                var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="${postAllowance}">`
                            }else if(value.duty_qty > 0 && value.ot_qty > 0){
                                var dressCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">`
                                var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">`
                                var backChargeCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">`
                                var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">`
                                var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">`
                                var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="${Stmp}" placeholder="stamp">`
                                var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                                var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                                var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${netSalary}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly>`
                                var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="${postAllowance}">`
                            }else{
                               
                                var dressCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">`
                                var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">`
                                var backChargeCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">`
                                var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">`
                                var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">`
                                var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="${Stmp}" placeholder="stamp">`
                                var trainingChargCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">`
                                var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                                var payableCondtion=`<input style="width:100px;" class="form-control total_payable" value="${netSalary+parseFloat(postAllowance).toFixed(2)}" type="text" name="total_payable[]" placeholder="Total Payable Salary" readonly>`
                                var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" value="${postAllowance}">`
                            }

                            selectElement.append(
                                `<tr>
                                    <td class="fixed">${counter + 1}</td>
                                    <td class="fixed-2">${value.admission_id_no}
                                        <input onkeyup="reCalcultateSalary(this)" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                    </td>
                                    <td class="fixed-3">
                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control join_date" type="text" name="join_date[]" value="${value.salary_joining_date}" placeholder="Duty Rate">
                                    </td>
                                    <td class="fixed-4">
                                        <input onkeyup="reCalcultateSalary(this)" style="width:150px;" class="form-control rank" type="text" value="${value.jobpost_name}" placeholder="Rank">
                                        <input type="hidden" name="designation_id[]" value="${value.job_post_id}" placeholder="Jobpost Id">
                                        <input type="hidden" name="customer_id_ind[]" value="${value.customer_id}">
                                        <input type="hidden" name="customer_branch_id[]" value="${value.branch_id}">
                                        <input type="hidden" name="customer_atm_id[]" value="${value.atm_id}">
                                        <input class="deduction_total" type="hidden" name="deduction_total[]" value="${totalDeduction}">
                                        <input type="hidden" name="long_loan_id[]" value="${value.long_loan_id}">
                                    </td>
                                    <td class="fixed-5">
                                        <input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                    </td>
                                    <td width="300px"> ${value.customer_name}</td>
                                    <td width="300px"> ${value.customer_branch}</td>
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
                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" value="${(parseFloat(value.grossAmount)+parseFloat(postAllowance)).toFixed(2)}" type="text" name="gross_salary[]" placeholder="Gross Salary">
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
                                    <td><input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="${Remarks}"></td>
                                    <td>
                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control divided_by" type="text" name="divided_by[]" value="${totalDaysInMonth}">
                                    </td>
                                    {{--  <td>
                                        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                    </td>  --}}
                                </tr>`
                            );
                            counter++;
                            total_calculate();
                            old_emp= value.admission_id_no;
                        });
                    }
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
