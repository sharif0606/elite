@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Three'))
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
                        <form method="post" action="{{route('salarysheet.salarySheetThreeStore')}}" enctype="multipart/form-data">
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
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rank')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Joining Date')}}</th>
                                                <th scope="col" rowspan="2">{{__('Basic')}}</th>
                                                <th scope="col" rowspan="2">{{__('House rent (50%)')}}</th>
                                                <th scope="col" rowspan="2">{{__('Medical')}}</th>
                                                <th scope="col" rowspan="2">{{__('Trans. Conve.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Wages')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Working Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Pre. Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Absent')}}</th>
                                                <th scope="col" rowspan="2">{{__('Vacant')}}</th>
                                                <th scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                                <th scope="col" colspan="3">{{__('Leave')}}</th>
                                                <th scope="col" colspan="7">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Wages')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT hour')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT rate(Basic*2)')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amt.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total Payable')}}</th>
                                                <th scope="col" rowspan="2">{{__('Signature')}}</th>
                                            </tr>
                                            <tr>
                                                <th>CL</th>
                                                <th>SL</th>
                                                <th>EL</th>
                                                <th>Absent</th>
                                                <th>Vacant</th>
                                                <th>H.rent</th>
                                                <th>PF</th>
                                                <th>Adv.</th>
                                                <th>Stm</th>
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
        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,CustomerIdNot:CustomerIdNot },
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
                        let sixMonthsLater = new Date(joiningDate);
                        sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);
                        var currentDate = new Date();
                        var month = parseInt($(".month").val());
                        var currentYear = currentDate.getFullYear();
                        var totalDays = new Date(currentYear, month, 0).getDate();
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
                        let Ab = (value.absent > 0) ? value.absent : '0';
                        let Va = (value.vacant > 0) ? value.vacant : '0';
                        let Ad = (value.adv > 0) ? value.adv : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let hR = (value.duty_rate > 0) ? ((value.duty_rate)*50)/100 : '0';
                        let otR = (value.duty_rate > 0) ? ((value.duty_rate)*2) : '0';
                        let otP = (value.ot_qty > 0) ? parseFloat(otR/(value.ot_qty)).toFixed(2) : '0';
                        let totalDeduction = parseFloat(Hr) + parseFloat(Ab) + parseFloat(Va) + parseFloat(Ad) + parseFloat(pf);
                        let netSalary = '0';
                        if (grossAmoun > totalDeduction) {
                            netSalary = parseFloat(grossAmoun) - parseFloat(totalDeduction);
                        }
                        let gr = parseFloat(value.duty_rate) + parseFloat(hR);
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
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
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" placeholder="Joining Date">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control house_rent" type="text" name="house_rent[]" value="${hR}" placeholder="House rent (50%)">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control medical" type="text" name="medical[]" value="" placeholder="Medical">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control trans_conve" type="text" name="trans_conve[]" value="" placeholder="Trans. Conve.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_wages" type="text" name="gross_wages[]" value="${gr}" placeholder="Gross Wages">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_workingDay" type="text" name="total_workingDay[]" value="${totalDays}" placeholder="Total Working Days">
                                </td>
                                <td>${value.duty_qty}
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control present_day" type="hidden" name="present_day[]" value="${value.duty_qty}" placeholder="Pre. Days">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="" placeholder="Absent">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="" placeholder="Vacant">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="" placeholder="Holiday/ festival">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="" placeholder="Leave CL">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="" placeholder="Leave SL">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="" placeholder="Leave EL">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_absent" type="text" name="deduction_absent[]" value="${Ab}" placeholder="Absent">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_vacant" type="text" name="deduction_vacant[]" value="${Va}" placeholder="Vacant">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_h_rent" type="text" name="deduction_h_rent[]" value="${Hr}" placeholder="H.rent">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="PF">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_adv" type="text" name="deduction_adv[]" value="${Ad}" placeholder="Adv">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_stm" type="text" name="deduction_stm[]" value="" placeholder="Stm">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="${totalDeduction}" placeholder="Total">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_wages" type="text" name="net_wages[]" value="${netSalary}" placeholder="Net Wages">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_hour" type="text" name="ot_hour[]" value="${value.ot_qty}" placeholder="OT hour">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate_basicDuble" type="text" name="ot_rate_basicDuble[]" value="${otR}" placeholder="OT rate(Basic*2)">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_amt" type="text" name="ot_amt[]" value="${otP}" placeholder="OT Amt.">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control total_payable" type="text" name="total_payable[]" value="" placeholder="Total Payable">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control signature" type="text" name="signature[]" value="" placeholder="Signature">
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
        let hore=$(e).closest('tr').find('.house_rent').val()?parseFloat($(e).closest('tr').find('.house_rent').val()):0;
        let medi=$(e).closest('tr').find('.medical').val()?parseFloat($(e).closest('tr').find('.medical').val()):0;
        let trcon=$(e).closest('tr').find('.trans_conve').val()?parseFloat($(e).closest('tr').find('.trans_conve').val()):0;
        let fixedOt=$(e).closest('tr').find('.fixed_ot').val()?parseFloat($(e).closest('tr').find('.fixed_ot').val()):0;
        let allownce=$(e).closest('tr').find('.allownce').val()?parseFloat($(e).closest('tr').find('.allownce').val()):0;
        let arrear=$(e).closest('tr').find('.arrear').val()?parseFloat($(e).closest('tr').find('.arrear').val()):0;
        let grw = parseFloat(dutyRate) + parseFloat(hore) + parseFloat(medi) + parseFloat(trcon);
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth() + 1;
        let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let dutyRateDay=dutyRate/totalDaysInMonth;
        //let otRateDay=otRate/totalDaysInMonth;
        //let dutyAmount=parseFloat(dutyRateDay*dutyQty);
       // let otAmount=parseFloat(otRateDay*otQty);
        //$(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.gross_wages').val(parseFloat(grw).toFixed(2));
       // $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));

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
        let tg= parseFloat(fixedOt) + parseFloat(allownce) + parseFloat(arrear);
        let td = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(traningCost) + parseFloat(Cf) + parseFloat(medical) + parseFloat(ins) + parseFloat(pf) + parseFloat(stamp);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.gross_salary').val(parseFloat(tg).toFixed(2));
        $(e).closest('tr').find('.net_salary').val(parseFloat(net).toFixed(2));

    }
</script>

@endpush
