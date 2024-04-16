@extends('layout.app')

@section('pageTitle',trans('Salary Sheet Five(General)'))
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
                                        <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <label for=""><b>End Date</b></label>
                                        <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
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
                                            <tr class="text-center myDIV" id="">
                                                <th scope="col" rowspan="2" class="myDIV">{{__('SL.No')}}</th>
                                                <th scope="col" rowspan="2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rank')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Rate of Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Pre.Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT days')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Taka')}}</th>
                                                <th scope="col" rowspan="2">{{__('Post Allowance')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="8-">{{__('DEDUCTION')}}</th>
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
                                        <tfoot>
                                            {{--  <tr>
                                                <td></td>
                                                <td></td>
                                                <td> Total</td>
                                                <td><input class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></td>
                                                <td><input class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></td>
                                                <td><input class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                                <td><input class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></td>
                                                <td><input class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></td>
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
                    $.each(salary_data, function(index, value) {
                        let traningCost=value.bn_traning_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_traning_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        //console.log(traningCostPerMonth);
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
                        let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let BankCharge = (value.bank_charge_exc > 0) ? value.bank_charge_exc : '0';
                        let Dress = (value.dress > 0) ? value.dress : '0';
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control join_date" type="text" name="join_date[]" value="${value.joining_date}" placeholder="Duty Rate">
                                </td>
                                <td>
                                    <input style="width:150px;" class="form-control rank" type="text" name="rank[]" value="${value.jobpost_name}" placeholder="Rank"></td>
                                <td>
                                    <input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                </td>
                                <td>${value.duty_rate}
                                    <input class="form-control duty_rate" type="hidden" name="duty_rate[]" value="${value.duty_rate}" placeholder="OT Qty">
                                </td>
                                <td>${value.duty_qty}
                                    <input style="width:100px;" class="form-control duty_qty" type="hidden" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Qty">
                                </td>
                                <td>${value.duty_amount}
                                    <input style="width:100px;" class="form-control duty_amount" type="hidden" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>${value.ot_qty}
                                    <input style="width:100px;" class="form-control ot_qty" type="hidden" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>${value.ot_rate}
                                    <input style="width:100px;" class="form-control ot_rate" type="hidden" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>${value.ot_amount}
                                    <input style="width:100px;" class="form-control ot_amount" type="hidden" name="ot_amount[]" value="${value.ot_amount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control post_allowance" type="text" name="post_allowance[]" placeholder="Post Allowance">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" placeholder="Gross Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_dress" type="text" value="${Dress}" name="deduction_dress[]" placeholder="Dress">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_fine" type="text" value="${Fine}" name="deduction_fine[]" placeholder="Fine">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_banck_charge" type="text" value="${BankCharge}" name="deduction_banck_charge[]" placeholder="Bank Charge/Exc">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_ins" type="text" value="${Insurance}" name="deduction_ins[]" placeholder="ins">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_pf" type="text" name="deduction_pf[]" value="${pf}" placeholder="P.F">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_stamp" type="text" name="deduction_stamp[]" value="10" placeholder="stamp">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_training_cost" type="text" value="${traningCostPerMonth}" name="deduction_training_cost[]" placeholder="Training Cost">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_payable" type="text" name="total_payable[]" placeholder="Total Payable Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control sing_ind" type="text" name="sing_ind[]" placeholder="SIGN OF IND.">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control sing_account" type="text" name="sing_account[]" placeholder="Sign of Account">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control remark" type="text" name="remark[]" placeholder="Remark">
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
</script>

@endpush
