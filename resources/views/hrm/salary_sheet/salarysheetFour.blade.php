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
                        <form method="post" action="{{route('salarySheet.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                {{--  <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
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
                                    <label for=""><b>Start Date</b></label>
                                    <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
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
        if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate },
            success: function(salary_data) {
                //console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
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
                                <td>
                                    <input style="width:100px;" class="form-control house_rent" type="text" name="house_rent[]" value="" placeholder="House rent">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control medical_allowance" type="text" name="medical_allowance[]" value="" placeholder="Medical Allowance">
                                </td>
                                <td>${value.duty_amount}
                                    <input style="width:100px;" class="form-control duty_amount" type="hidden" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>${value.duty_qty}
                                    <input style="width:100px;" class="form-control duty_qty" type="hidden" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
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
                                    <input style="width:100px;" class="form-control post_allow" type="text" name="post_allow[]" value="" placeholder="Post Allow.">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control fuel_bill" type="text" name="fuel_bill[]" value="" placeholder="Fuel Bill">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_salary" type="text" name="total_salary[]" value="" placeholder="Total Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_excess_mobile" type="text" name="deduction_excess_mobile[]" value="" placeholder="Excess Mobile">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="" placeholder="Fine">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="" placeholder="Ins">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="" placeholder="P.F">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_mess" type="text" name="deduction_mess[]" value="" placeholder="Mess">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="" placeholder="Loan">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_traning_cost" type="text" name="deduction_traning_cost[]" value="" placeholder="Training Cost">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_payble" type="text" name="total_payble[]" value="" placeholder="Total Payble">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control signature_ind" type="text" name="signature_ind[]" value="" placeholder="SIG OF IND.">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control signature_accounts" type="text" name="signature_accounts[]" value="" placeholder="Sing of Accounts">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control remarks" type="text" name="remarks[]" value="" placeholder="Remarks">
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
