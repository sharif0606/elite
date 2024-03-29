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
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
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
                                    <input style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input style="width:100px;" class="form-control rank" type="hidden" name="designation[]" value="${value.jobpost_id}" placeholder="Desingation">
                                </td>
                                <td>
                                    <input style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name">
                                </td>
                                <td>
                                    <input readonly style="width:100px;" class="form-control joining_date" type="text" name="joining_date[]" value="${value.joining_date}" placeholder="Joining Date">
                                </td>
                                <td>${value.duty_rate}
                                    <input style="width:100px;" class="form-control duty_rate" type="hidden" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control house_rent" type="text" name="house_rent[]" value="" placeholder="House rent (50%)">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control medical" type="text" name="medical[]" value="" placeholder="Medical">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control trans_conve" type="text" name="trans_conve[]" value="" placeholder="Trans. Conve.">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control gross_wages" type="text" name="gross_wages[]" value="" placeholder="Gross Wages">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_workingDay" type="text" name="total_workingDay[]" value="" placeholder="Total Working Days">
                                </td>
                                <td>${value.duty_qty}
                                    <input style="width:100px;" class="form-control present_day" type="hidden" name="present_day[]" value="${value.duty_qty}" placeholder="Pre. Days">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control absent" type="text" name="absent[]" value="" placeholder="Absent">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="" placeholder="Vacant">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="" placeholder="Holiday/ festival">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="" placeholder="Leave CL">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="" placeholder="Leave SL">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="" placeholder="Leave EL">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_absent" type="text" name="deduction_absent[]" value="" placeholder="Absent">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_vacant" type="text" name="deduction_vacant[]" value="" placeholder="Vacant">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_h_rent" type="text" name="deduction_h_rent[]" value="" placeholder="H.rent">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="" placeholder="PF">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_adv" type="text" name="deduction_adv[]" value="" placeholder="Adv">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_stm" type="text" name="deduction_stm[]" value="" placeholder="Stm">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="" placeholder="Total">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control net_wages" type="text" name="net_wages[]" value="" placeholder="Net Wages">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control ot_hour" type="text" name="ot_hour[]" value="" placeholder="OT hour">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control ot_rate_basicDuble" type="text" name="ot_rate_basicDuble[]" value="" placeholder="OT rate(Basic*2)">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control ot_amt" type="text" name="ot_amt[]" value="" placeholder="OT Amt.">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control total_payable" type="text" name="total_payable[]" value="" placeholder="Total Payable">
                                </td>
                                <td>
                                    <input style="width:100px;" class="form-control signature" type="text" name="signature[]" value="" placeholder="Signature">
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
