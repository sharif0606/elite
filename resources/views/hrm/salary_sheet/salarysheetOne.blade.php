@extends('layout.app')

@section('pageTitle',trans('Salary Sheet One'))
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
                        <form method="post" action="{{route('salarysheet.salarySheetOneStore')}}" enctype="multipart/form-data">
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
                                    <select required class="form-control month" name="month">
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
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2">{{__('Online Payment')}}</th>
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2">{{__('Designation')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT/Hrs')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                                <th scope="col" rowspan="2">{{__('Fixed OT')}}</th>
                                                <th scope="col" rowspan="2">{{__('Allownce')}}</th>
                                                <th scope="col" rowspan="2">{{__('Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('Arrear')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="14">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('SIGN OF IND.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Remark')}}</th>
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>Fine</th>
                                                <th>Mobile bill</th>
                                                <th>Loan</th>
                                                <th>Long Loan</th>
                                                <th>Cloth</th>
                                                <th>Jacket</th>
                                                <th>HR</th>
                                                <th>Training Cost</th>
                                                <th>C/F</th>
                                                <th>Medical</th>
                                                <th>Ins</th>
                                                <th>P/F</th>
                                                <th>Revenue Stamp</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">

                                        </tbody>
                                        <tfoot>
                                            {{--  <tr>
                                                <td></td>
                                                <td></td>
                                                <td> Total</td>
                                                <td><input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></td>
                                                <td><input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></td>
                                                <td></td>
                                            </tr>  --}}
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
        var Year=$('.year').val();
        var Month=$('.month').val();
        //console.log(startDate);

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,CustomerIdNot:CustomerIdNot,Year:Year,Month:Month },
            success: function(salary_data) {
                //console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        //console.log(value);
                        let traningCost=value.bn_traning_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_traning_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let joiningDate = new Date(value.joining_date);
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
                        let MobileBill = (value.mobilebill > 0) ? value.mobilebill : '0';
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        let LongLoan = (value.perinstallment_amount > 0) ? value.perinstallment_amount : '0';
                        let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(Cf) + parseFloat(Medical) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                        let netSalary = '0';
                        if (grossAmoun > totalDeduction) {
                            netSalary = parseFloat(grossAmoun) - parseFloat(totalDeduction);
                        }
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control online_payment" type="text" name="online_payment[]" value="Online" placeholder="Online Payment">
                                </td>
                                <td>${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Employee Id">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" type="hidden" name="customer_id_ind[]" value="${value.customer_id}" placeholder="Customer Id">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" placeholder="Date of Joining">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control rank" type="hidden" name="designation[]" value="${value.jobpost_id}" placeholder="Desingation">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_qty" type="text" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_amount" type="text" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_qty" type="text" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="${value.ot_amount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control fixed_ot" type="text" name="fixed_ot[]" value="" placeholder="Fixed Ot">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control allownce" type="text" name="allownce[]" value="" placeholder="Allownce">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave" type="text" name="leave[]" value="" placeholder="Leave">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control arrear" type="text" name="arrear[]" value="" placeholder="Arrear">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="${value.grossAmount}" placeholder="Gross Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="${Fine}" placeholder="Fine">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_mobilebill" type="text" name="deduction_mobilebill[]" value="${MobileBill}" placeholder="Mobile bill">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_long_loan" type="text" name="deduction_long_loan[]" value="${LongLoan}" placeholder="Long Loan">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_cloth" type="text" name="deduction_cloth[]" value="${Cloth}" placeholder="Cloth">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_jacket" type="text" name="deduction_jacket[]" value="${Jacket}" placeholder="Jacket">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_hr" type="text" name="deduction_hr[]" value="${Hr}" placeholder="HR">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_traningcost" type="text" name="deduction_traningcost[]" value="${traningCostPerMonth}" placeholder="Training Cost">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_c_f" type="text" name="deduction_c_f[]" value="${Cf}" placeholder="C/F">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_medical" type="text" name="deduction_medical[]" value="${Medical}" placeholder="Medical">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="${Insurance}" placeholder="Ins">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="P/F">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_revenue_stamp" type="text" name="deduction_revenue_stamp[]" value="" placeholder="Revenue Stamp">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="${totalDeduction}" placeholder="Total">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="${netSalary}" placeholder="Net Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control sing_of_ind" type="text" name="sing_of_ind[]" value="" placeholder="SIGN OF IND">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control remark" type="text" name="remark[]" value="" placeholder="Remark">
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
        let MobileBill=$(e).closest('tr').find('.deduction_mobilebill').val()?parseFloat($(e).closest('tr').find('.deduction_mobilebill').val()):0;
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
        let stamp=$(e).closest('tr').find('.deduction_revenue_stamp').val()?parseFloat($(e).closest('tr').find('.deduction_revenue_stamp').val()):0;
        let detotal=$(e).closest('tr').find('.deduction_total').val()?parseFloat($(e).closest('tr').find('.deduction_total').val()):0;
        let tg= parseFloat(dutyAmount) + parseFloat(otAmount) + parseFloat(fixedOt) + parseFloat(allownce) + parseFloat(arrear);
        let td = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(traningCost) + parseFloat(Cf) + parseFloat(medical) + parseFloat(ins) + parseFloat(pf) + parseFloat(stamp);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.gross_salary').val(parseFloat(tg).toFixed(2));
        $(e).closest('tr').find('.net_salary').val(parseFloat(net).toFixed(2));

    }
</script>

@endpush
