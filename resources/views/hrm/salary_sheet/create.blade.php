@extends('layout.app')

@section('pageTitle',trans('Salary Sheet'))
@section('pageSubTitle',trans('Create'))

@section('content')
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
                                        <thead class="d-none show_click"">
                                            <tr class="text-center">
                                                <th scope="col" rowspan="2">{{__('SL.No')}}</th>
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
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        selectElement.append(
                            `<tr>
                                <td>${counter + 1}</td>
                                <td>${value.admission_id_no}
                                    <input class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Id">
                                </td>
                                <td>${value.start_date}
                                    <input class="form-control join_date" type="hidden" name="join_date[]" value="" placeholder="Duty Rate">
                                </td>
                                <td>${value.jobpost_name}
                                    <input class="form-control rank" type="hidden" name="rank[]" value="${value.jobpost_id}" placeholder="Rank"></td>
                                <td>${value.en_applicants_name}
                                    <input class="form-control duty_qty" type="hidden" name="duty_qty[]" placeholder="Duty Qty">
                                </td>
                                <td>${value.duty_rate}
                                    <input class="form-control duty_rate" type="hidden" name="duty_rate[]" placeholder="OT Qty">
                                </td>
                                <td>
                                    <input class="form-control duty_rate" type="hidden" name="duty_rate[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control ot_amount OtAmountFc" type="hidden" name="ot_amount[]" placeholder="Ot Amount">
                                </td>
                                <td>${value.ot_qty}
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>${value.ot_rate}
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="hidden" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                </td>
                                <td>
                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
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
        var vat=$('#branch_id').find(":selected").data('vat');
        $('.vat').val(vat);
     }
</script>

@endpush
