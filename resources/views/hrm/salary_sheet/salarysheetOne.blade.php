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
                                                <td><input style="width:100px;" class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></td>
                                                <td><input style="width:100px;" class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></td>
                                                <td><input style="width:100px;" class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                                <td><input style="width:100px;" class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></td>
                                                <td><input style="width:100px;" class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></td>
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
        //console.log(CustomerId);

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
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>
                                    <input style="width:100px;" class="form-control online_payment" type="text" name="online_payment[]" value="" placeholder="Online Payment">
                                </td>
                                <td>${value.admission_id_no}
                                    <input style="width:100px;" class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>
                                    <input readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" placeholder="Date of Joining">
                                </td>
                                <td>
                                    <input style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input style="width:100px;" class="form-control rank" type="hidden" name="designation[]" value="${value.jobpost_id}" placeholder="Desingation">
                                </td>
                                <td>
                                    <input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                </td>
                                <td>${value.duty_rate}
                                    <input style="width:100px;" class="form-control duty_rate" type="hidden" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>${value.duty_qty}
                                    <input style="width:100px;" class="form-control duty_qty" type="hidden" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
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
                                    <input style="width:100px;" class="form-control fixed_ot" type="text" name="fixed_ot[]" value="" placeholder="Fixed Ot">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control allownce" type="text" name="allownce[]" value="" placeholder="Allownce">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control leave" type="text" name="leave[]" value="" placeholder="Leave">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control arrear" type="text" name="arrear[]" value="" placeholder="Arrear">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="" placeholder="Gross Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="" placeholder="Fine">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_mobilebill" type="text" name="deduction_mobilebill[]" value="" placeholder="Mobile bill">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="" placeholder="Loan">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_long_loan" type="text" name="deduction_long_loan[]" value="" placeholder="Long Loan">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_cloth" type="text" name="deduction_cloth[]" value="" placeholder="Cloth">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_jacket" type="text" name="deduction_jacket[]" value="" placeholder="Jacket">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_hr" type="text" name="deduction_hr[]" value="" placeholder="HR">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_traningcost" type="text" name="deduction_traningcost[]" value="" placeholder="Training Cost">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_c_f" type="text" name="deduction_c_f[]" value="" placeholder="C/F">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_medical" type="text" name="deduction_medical[]" value="" placeholder="Medical">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="" placeholder="Ins">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="" placeholder="P/F">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_revenue_stamp" type="text" name="deduction_revenue_stamp[]" value="" placeholder="Revenue Stamp">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="" placeholder="Total">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="" placeholder="Net Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control sing_of_ind" type="text" name="sing_of_ind[]" value="" placeholder="SIGN OF IND">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="" placeholder="Remark">
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
