@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Two'))
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
                        <form method="post" action="{{route('salarysheet.salarySheetTwoStore')}}" enctype="multipart/form-data">
                            @csrf
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
                                    <select required class="form-control month" name="month">
                                        <option value="">Select Month</option>
                                        @for($i=1;$i<= 12;$i++)
                                        <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                {{--  <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input onkeyup="reCalcultateSalary(this)" required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input onkeyup="reCalcultateSalary(this)" required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>  --}}
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getSalaryData()" type="button" class="btn btn-primary">Generate Salary</button>
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
                                                <th scope="col" rowspan="2">{{__('Designation')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Payment Type')}}</th>
                                                <th scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Working Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Taka')}}</th>
                                                <th scope="col" rowspan="2">{{__('Weekly Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amount')}}</th>
                                                <th scope="col" rowspan="2">{{__('HT/Ribon Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gun Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('Extra Alice')}}</th>
                                                <th scope="col" rowspan="2">{{__('Arrear')}}</th>
                                                <th scope="col" rowspan="2">{{__('Bonus')}}</th>
                                                <th scope="col" rowspan="2">{{__('Donation')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="16">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Signature')}}</th>
                                                <th scope="col" rowspan="2">{{__('Zone')}}</th>
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>Mattress & Pillow Cost</th>
                                                <th>Tonic Sim</th>
                                                <th>Over Payment Cutt</th>
                                                <th>Fine</th>
                                                <th>Loan</th>
                                                <th>Long Loan</th>
                                                <th>Cloth</th>
                                                <th>HR</th>
                                                <th>Jacket</th>
                                                <th>Stamp</th>
                                                <th>Training Cost</th>
                                                <th>C/F</th>
                                                <th>Medical</th>
                                                <th>Ins</th>
                                                <th>P/F</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">

                                        </tbody>
                                        <tfoot class="d-none show_click">
                                            <tr>
                                               <th colspan="6" class="text-end"> Total</th>
                                               <th><input class="form-control ratOfSalaryTotal" type="text" disabled></th>
                                               <th><input class="form-control prevDaysTotal" type="text" disabled></th>
                                               <th><input class="form-control netTotal" type="text" disabled></th>
                                               <th><input class="form-control weaklyLeveTotal" type="text" disabled></th>
                                               <th><input class="form-control otDayTotal" type="text" disabled></th>
                                               <th><input class="form-control otRateTotal" type="text" disabled></th>
                                               <th><input class="form-control otAmountTotal" type="text" disabled></th>
                                               <th><input class="form-control htRibonAliceTotal" type="text" disabled></th>
                                               <th><input class="form-control gunAliceTotal" type="text" disabled></th>
                                               <th><input class="form-control leaveTotal" type="text" disabled></th>
                                               <th><input class="form-control extraAliceTotal" type="text" disabled></th>
                                               <th><input class="form-control arrearTotal" type="text" disabled></th>
                                               <th><input class="form-control bonusTotal" type="text" disabled></th>
                                               <th><input class="form-control donationTotal" type="text" disabled></th>
                                               <th><input class="form-control grossTotal" type="text" disabled></th>
                                               <th><input class="form-control deMettersPillowCostTotal" type="text" disabled></th>
                                               <th><input class="form-control deTonicSimTotal" type="text" disabled></th>
                                               <th><input class="form-control deOverPayCuttTotal" type="text" disabled></th>
                                               <th><input class="form-control deFineTotal" type="text" disabled></th>
                                               <th><input class="form-control deLoonTotal" type="text" disabled></th>
                                               <th><input class="form-control deLongLoonTotal" type="text" disabled></th>
                                               <th><input class="form-control deClothTotal" type="text" disabled></th>
                                               <th><input class="form-control deHrTotal" type="text" disabled></th>
                                               <th><input class="form-control deJacketTotal" type="text" disabled></th>
                                               <th><input class="form-control deStmpTotal" type="text" disabled></th>
                                               <th><input class="form-control deTrainingTotal" type="text" disabled></th>
                                               <th><input class="form-control deCfTotal" type="text" disabled></th>
                                               <th><input class="form-control deMedicalTotal" type="text" disabled></th>
                                               <th><input class="form-control deInsTotal" type="text" disabled></th>
                                               <th><input class="form-control dePfTotal" type="text" disabled></th>
                                               <th><input class="form-control deDeductTotal" type="text" disabled></th>
                                               <th><input class="form-control netSalaryTotal" type="text" disabled></th>
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

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,CustomerIdNot:CustomerIdNot },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    var old_emp = '';
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_traning_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_traning_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let joiningDate = new Date(value.joining_date);
                        let sixMonthsLater = new Date(joiningDate);
                        sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);

                        let pf = "0";
                        if (new Date() >= sixMonthsLater) {
                            pf = "200";
                        }
                        let Insurance = "0";
                        if (new Date() >= sixMonthsLater) {
                            Insurance = (value.insurance > 0) ? value.insurance : '0';
                        }
                        let Fine = (value.fine > 0) ? value.fine : '0';
                        let pillCost = (value.matterss_pillowCost > 0) ? value.matterss_pillowCost : '0';
                        let paCutt = (value.over_paymentCut > 0) ? value.over_paymentCut : '0';
                        let Tsim = (value.tonic_sim > 0) ? value.tonic_sim : '0';
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        let LongLoan = (value.perinstallment_amount > 0) ? value.perinstallment_amount : '0';
                        let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(Cf) + parseFloat(Medical) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance) + parseFloat(pillCost) + parseFloat(Tsim) + parseFloat(paCutt);
                        let netSalary = '0';
                        if (grossAmoun > totalDeduction) {
                            netSalary = parseFloat(grossAmoun) - parseFloat(totalDeduction);
                        }
                        if(old_emp == value.admission_id_no){
                            var customerName =`<span>${value.customer_name}</span><input style="width:100px;" class="form-control" type="hidden" name="joining_date[]" value="${value.joining_date}">`;
                            var en_applicants_name = value.customer_branch;
                            var mpcCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_matterss_pillowCost[]" value="0" readonly>`
                            var tonicsimCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_tonic_sim[]" value="0" readonly>`
                            var opcCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_over_paymentCut[]" value="0" readonly>`
                            var fineCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_fine[]" value="0" readonly>`
                            var loonCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_loan[]" value="0" readonly>`
                            var longLoonCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_longLoan[]" value="0" readonly>`
                            var clothCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_cloth[]" value="0" readonly>`
                            var hrCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_hr[]" value="0" readonly>`
                            var jacketCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_jacket[]" value="0" readonly>`
                            var stmCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_stamp[]" value="0" readonly>`
                            var trainingCostCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_traningCost[]" value="0" readonly>`
                            var cfCondition=` <input style="width:100px;" class="form-control" type="text" name="deduction_c_f[]" value="0" readonly>`
                            var medicalCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_medical[]" value="0" readonly>`
                            var insCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_ins[]" value="0" readonly>`
                            var pfCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_p_f[]" value="0" readonly>`
                            var deTotalCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_total[]" value="0" readonly>`
                            var netSalaryCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="${Math.round(grossAmoun)}" readonly>`
                        }else{
                            var en_applicants_name=`<input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">`
                            var customerName =`<input style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" readonly>`;
                            var mpcCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_matterss_pillowCost" type="text" name="deduction_matterss_pillowCost[]" value="" placeholder="Mattress & Pillow Cost">`
                            var tonicsimCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_tonic_sim" type="text" name="deduction_tonic_sim[]" value="" placeholder="Tonic Sim">`
                            var opcCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_over_paymentCut" type="text" name="deduction_over_paymentCut[]" value="" placeholder="Over Payment Cutt">`
                            var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="${Fine}" placeholder="Fine">`
                            var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                            var longLoonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_longLoan" type="text" name="deduction_longLoan[]" value="${LongLoan}" placeholder="Long Loan">`
                            var clothCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_cloth" type="text" name="deduction_cloth[]" value="${Cloth}" placeholder="Cloth">`
                            var hrCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_hr" type="text" name="deduction_hr[]" value="${Hr}" placeholder="HR">`
                            var jacketCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_jacket" type="text" name="deduction_jacket[]" value="${Jacket}" placeholder="Jacket">`
                            var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="" placeholder="Stamp">`
                            var trainingCostCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_traningcost" type="text" name="deduction_traningCost[]" value="${traningCostPerMonth}" placeholder="Training Cost">`
                            var cfCondition=` <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_c_f" type="text" name="deduction_c_f[]" value="${Cf}" placeholder="C/F">`
                            var medicalCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_medical" type="text" name="deduction_medical[]" value="${Medical}" placeholder="Medical">`
                            var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="${Insurance}" placeholder="Ins">`
                            var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="P/F">`
                            var deTotalCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="${totalDeduction}" placeholder="Total">`
                            var netSalaryCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="${Math.round(netSalary)}" placeholder="Net Salary">`
                        }
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>${customerName}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input class="form-control rank" type="hidden" name="designation_id[]" value="${value.jobpost_id}" placeholder="Desingation">
                                    <input type="hidden" name="customer_id_ind[]" value="${value.customer_id}">
                                    <input type="hidden" name="customer_branch_id[]" value="${value.branch_id}">
                                    <input type="hidden" name="customer_atm_id[]" value="${value.atm_id}">
                                </td>
                                <td>${en_applicants_name}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control payment_type" type="text" name="payment_type[]" value="online" placeholder="Payment Type">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" readonly class="form-control duty_qty" type="text" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" readonly class="form-control duty_amount" type="text" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control weekly_leave" type="text" name="weekly_leave[]" value="" placeholder="Weekly Leave">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" readonly class="form-control ot_qty" type="text" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" readonly class="form-control ot_amount" type="text" name="ot_amount[]" value="${value.ot_amount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ht_ribon_alice" type="text" name="ht_ribon_alice[]" value="" placeholder="HT/Ribon Alice">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gun_alice" type="text" name="gun_alice[]" value="" placeholder="Gun Alice">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave" type="text" name="leave[]" value="" placeholder="Leave">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control extra_alice" type="text" name="extra_alice[]" value="" placeholder="Extra Alice">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control arrear" type="text" name="arrear[]" value="" placeholder="Arrear">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control bonus" type="text" name="bonus[]" value="" placeholder="Bonus">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control donation" type="text" name="donation[]" value="" placeholder="Donation">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="" placeholder="Gross Salary">
                                </td>
                                <td>${mpcCondition}</td>
                                <td>${tonicsimCondition}</td>
                                <td>${opcCondition}</td>
                                <td>${fineCondition}</td>
                                <td>${loonCondition}</td>
                                <td>${longLoonCondition}</td>
                                <td>${clothCondition}</td>
                                <td>${hrCondition}</td>
                                <td>${jacketCondition}</td>
                                <td>${stmCondition}</td>
                                <td>${trainingCostCondition}</td>
                                <td>${cfCondition}</td>
                                <td>${medicalCondition}</td>
                                <td>${insCondition}</td>
                                <td>${pfCondition}</td>
                                <td>${deTotalCondition}</td>
                                <td>${netSalaryCondition}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature" type="text" name="signature[]" value="" placeholder="Signature">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control zone" type="text" name="zone[]" value="" placeholder="Zone">
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
        let fixedOt=$(e).closest('tr').find('.fixed_ot').val()?parseFloat($(e).closest('tr').find('.fixed_ot').val()):0;
        let allownce=$(e).closest('tr').find('.allownce').val()?parseFloat($(e).closest('tr').find('.allownce').val()):0;
        let arrear=$(e).closest('tr').find('.arrear').val()?parseFloat($(e).closest('tr').find('.arrear').val()):0;
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth() + 1;
        let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let dutyRateDay=dutyRate/totalDaysInMonth;
        let otRateDay=otRate/totalDaysInMonth;
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));

        let Fine=$(e).closest('tr').find('.deduction_fine').val()?parseFloat($(e).closest('tr').find('.deduction_fine').val()):0;
        let Loan=$(e).closest('tr').find('.deduction_loan').val()?parseFloat($(e).closest('tr').find('.deduction_loan').val()):0;
        let LongLoan=$(e).closest('tr').find('.deduction_long_loan').val()?parseFloat($(e).closest('tr').find('.deduction_long_loan').val()):0;
        let Cloth=$(e).closest('tr').find('.deduction_cloth').val()?parseFloat($(e).closest('tr').find('.deduction_cloth').val()):0;
        let Jacket=$(e).closest('tr').find('.deduction_jacket').val()?parseFloat($(e).closest('tr').find('.deduction_jacket').val()):0;
        let Hr=$(e).closest('tr').find('.deduction_hr').val()?parseFloat($(e).closest('tr').find('.deduction_hr').val()):0;
        let traningCost=$(e).closest('tr').find('.deduction_traningcost').val()?parseFloat($(e).closest('tr').find('.deduction_traningcost').val()):0;
        let Cf=$(e).closest('tr').find('.deduction_c_f').val()?parseFloat($(e).closest('tr').find('.deduction_c_f').val()):0;
        let medical=$(e).closest('tr').find('.deduction_medical').val()?parseFloat($(e).closest('tr').find('.deduction_medical').val()):0;
        let ins=$(e).closest('tr').find('.deduction_ins').val()?parseFloat($(e).closest('tr').find('.deduction_ins').val()):0;
        let pf=$(e).closest('tr').find('.deduction_p_f').val()?parseFloat($(e).closest('tr').find('.deduction_p_f').val()):0;
        let stamp=$(e).closest('tr').find('.deduction_stamp').val()?parseFloat($(e).closest('tr').find('.deduction_stamp').val()):0;
        let detotal=$(e).closest('tr').find('.deduction_total').val()?parseFloat($(e).closest('tr').find('.deduction_total').val()):0;
        let tg= parseFloat(dutyAmount) + parseFloat(otAmount) + parseFloat(fixedOt) + parseFloat(allownce) + parseFloat(arrear);
        let td = parseFloat(Fine) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(traningCost) + parseFloat(Cf) + parseFloat(medical) + parseFloat(ins) + parseFloat(pf) + parseFloat(stamp);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.gross_salary').val(parseFloat(tg).toFixed(2));
        $(e).closest('tr').find('.net_salary').val(Math.round(parseFloat(net)));
        total_calculate();
    }
    function total_calculate() {
        var ratOfSalaryTotal = 0; var prevDaysTotal = 0; var netTotal = 0; var weaklyLeveTotal = 0; var otDayTotal = 0; var otRateTotal = 0; var otAmountTotal = 0; var htRibonAliceTotal = 0; var gunAliceTotal = 0; var leaveTotal = 0;  var extraAliceTotal = 0; var arrearTotal = 0; var bonusTotal = 0; var donationTotal = 0;  var grossTotal = 0; var deMettersPillowCostTotal = 0; var deTonicSimTotal = 0; var deOverPayCuttTotal = 0; var deFineTotal = 0;  var deLoonTotal = 0; var deLongLoonTotal = 0;  var deClothTotal = 0; var deHrTotal = 0; var deJacketTotal = 0; var deStmpTotal = 0; var deTrainingTotal = 0; var deCfTotal = 0; var deMedicalTotal = 0; var deInsTotal = 0; var dePfTotal = 0; var deDeductTotal = 0; var netSalaryTotal = 0;

        $('.duty_rate').each(function() {
            ratOfSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_qty').each(function() {
            prevDaysTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_amount').each(function() {
            netTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.weekly_leave').each(function() {
            weaklyLeveTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
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
        $('.ht_ribon_alice').each(function() {
            htRibonAliceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.gun_alice').each(function() {
            gunAliceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.leave').each(function() {
            leaveTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.extra_alice').each(function() {
            extraAliceTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.arrear').each(function() {
            arrearTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.bonus').each(function() {
            bonusTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.donation').each(function() {
            donationTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.gross_salary').each(function() {
            grossTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_matterss_pillowCost').each(function() {
            deMettersPillowCostTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_tonic_sim').each(function() {
            deTonicSimTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_over_paymentCut').each(function() {
            deOverPayCuttTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_fine').each(function() {
            deFineTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_loan').each(function() {
            deLoonTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_longLoan').each(function() {
            deLongLoonTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_cloth').each(function() {
            deClothTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_hr').each(function() {
            deHrTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_jacket').each(function() {
            deJacketTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_stamp').each(function() {
            deStmpTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_traningcost').each(function() {
            deTrainingTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_c_f').each(function() {
            deCfTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_medical').each(function() {
            deMedicalTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_ins').each(function() {
            deInsTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_p_f').each(function() {
            dePfTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_total').each(function() {
            deDeductTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.net_salary').each(function() {
            netSalaryTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        
        $('.ratOfSalaryTotal').val(parseFloat(ratOfSalaryTotal).toFixed(2));
        $('.prevDaysTotal').val(parseFloat(prevDaysTotal));
        $('.netTotal').val(parseFloat(netTotal).toFixed(2));
        $('.weaklyLeveTotal').val(parseFloat(weaklyLeveTotal).toFixed(2));
        $('.otDayTotal').val(parseFloat(otDayTotal));
        $('.otRateTotal').val(parseFloat(otRateTotal).toFixed(2));
        $('.otAmountTotal').val(parseFloat(otAmountTotal).toFixed(2));
        $('.htRibonAliceTotal').val(parseFloat(htRibonAliceTotal).toFixed(2));
        $('.gunAliceTotal').val(parseFloat(gunAliceTotal).toFixed(2));
        $('.leaveTotal').val(parseFloat(leaveTotal).toFixed(2));
        $('.extraAliceTotal').val(parseFloat(extraAliceTotal).toFixed(2));
        $('.arrearTotal').val(parseFloat(arrearTotal).toFixed(2));
        $('.bonusTotal').val(parseFloat(bonusTotal).toFixed(2));
        $('.donationTotal').val(parseFloat(donationTotal).toFixed(2));
        $('.grossTotal').val(parseFloat(grossTotal).toFixed(2));
        $('.deMettersPillowCostTotal').val(parseFloat(deMettersPillowCostTotal).toFixed(2));
        $('.deTonicSimTotal').val(parseFloat(deTonicSimTotal).toFixed(2));
        $('.deOverPayCuttTotal').val(parseFloat(deOverPayCuttTotal).toFixed(2));
        $('.deFineTotal').val(parseFloat(deFineTotal).toFixed(2));
        $('.deLoonTotal').val(parseFloat(deLoonTotal).toFixed(2));
        $('.deLongLoonTotal').val(parseFloat(deLongLoonTotal).toFixed(2));
        $('.deClothTotal').val(parseFloat(deClothTotal).toFixed(2));
        $('.deHrTotal').val(parseFloat(deHrTotal).toFixed(2));
        $('.deJacketTotal').val(parseFloat(deJacketTotal).toFixed(2));
        $('.deStmpTotal').val(parseFloat(deStmpTotal).toFixed(2));
        $('.deTrainingTotal').val(parseFloat(deTrainingTotal).toFixed(2));
        $('.deCfTotal').val(parseFloat(deCfTotal).toFixed(2));
        $('.deMedicalTotal').val(parseFloat(deMedicalTotal).toFixed(2));
        $('.deInsTotal').val(parseFloat(deInsTotal).toFixed(2));
        $('.dePfTotal').val(parseFloat(dePfTotal).toFixed(2));
        $('.deDeductTotal').val(parseFloat(deDeductTotal).toFixed(2));
        $('.netSalaryTotal').val(parseFloat(netSalaryTotal).toFixed(2));
    }
</script>

@endpush
