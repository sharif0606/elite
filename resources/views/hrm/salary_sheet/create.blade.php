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
                                <div class="col-lg-3 mt-2">
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
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                {{--  <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getSalaryData()" type="button" class="btn btn-primary">Generate Salary</button>
                                </div>  --}}
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
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
                                                <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>
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
                                        <tbody id="salarySheet">
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" name="employee_id[]" value="" placeholder="Employee Id">
                                                    <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
                                                    <input class="job_post_id" type="hidden" name="job_post_id[]" value="">
                                                </td>
                                                <td>
                                                    <input class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate">
                                                </td>
                                                <td><input class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate"></td>
                                                <td>
                                                    <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" type="number" name="duty_qty[]" placeholder="Duty Qty">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="number" name="ot_qty[]" placeholder="OT Qty">
                                                </td>
                                                <td>
                                                    <input class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" placeholder="Duty Amount">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" placeholder="Ot Amount">
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
                                                <td>
                                                    <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
                                                </td>
                                                <td>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
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

        if (!$('.customer_id').val()) {
            $('.customer_id').focus();
            return false;
        }
        if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }
        var customer=$('.customer_id').val();
        var branch_id=$('.branch_id').val();
        var atm_id=$('.atm_id').val();
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();

        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
            workingdayinmonth= new Date(syear, smonth, 0).getDate();
        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id:customer,branch_id:branch_id,atm_id:atm_id,start_date:startDate,end_date:endDate },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.show_invoice_data');
                    selectElement.empty();
                    $.each(salary_data, function(index, value) {
                        //console.log("value.start_date:", value.start_date);
                        //console.log("this start date:", startDate);
                        let workingDays;
                        let totalHoures;
                        let ratePerHoures;
                        let st_date;
                        let ed_date;
                        if (value.start_date >= startDate && value.end_date == null) {
                            workingDays = new Date(endDate) - new Date(value.start_date);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                            st_date=value.start_date;
                            ed_date=endDate;
                        } else if (value.start_date <= startDate && value.end_date == null) {
                            workingDays = new Date(endDate) - new Date(startDate);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                            st_date=startDate;
                            ed_date=endDate;
                        } else if (value.start_date <= startDate && value.end_date <= endDate) {
                            workingDays = new Date(value.end_date) - new Date(startDate);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                            st_date=value.start_date;
                            ed_date=value.end_date;
                        } else if (value.start_date >= startDate && value.end_date <= endDate) {
                            workingDays = new Date(value.end_date) - new Date(value.start_date);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                            st_date=value.start_date;
                            ed_date=value.end_date;
                        } else {
                            workingDays = '';
                            st_date='';
                            ed_date='';
                        }

                        if(value.hours=="1"){
                            totalHoures=(8*(value.qty)*(workingDays+1));
                            ratePerHoures=parseFloat(value.rate/(8*workingdayinmonth));
                            type_houre=8;
                        }else{
                            totalHoures=(12*(value.qty)*(workingDays+1));
                            ratePerHoures=parseFloat(value.rate/(12*workingdayinmonth));
                            type_houre=12;
                        }

                        selectElement.append(
                            `<tr style="text-align: center;">
                                <td>${counter + 1}</td>
                                <td>${value.name}
                                    <input class="" type="hidden" name="job_post_id[]" value="${value.job_post_id}">
                                </td>
                                <td>
                                    <input class="form-control input_css rate_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="rate[]" value="${value.rate}">
                                </td>
                                <td>
                                    <input class="form-control input_css employee_qty_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="employee_qty[]" value="${value.qty}">
                                </td>
                                <td>
                                    <input class="form-control input_css warking_day_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="warking_day[]" value="${workingDays+1}">
                                    <input class="" type="hidden" name="st_date[]" value="${st_date}">
                                    <input class="" type="hidden" name="ed_date[]" value="${ed_date}">
                                    <input class="" type="hidden" name="atm_id[]" value="${value.atm_id}">
                                </td>
                                <td>
                                    <input readonly class="form-control input_css total_houres_c" type="text" name="total_houres[]" value="${totalHoures}">
                                    <input class="type_houre" type="hidden" name="" value="${type_houre}">
                                </td>
                                <td>
                                    <input readonly class="form-control input_css rate_per_houres_c" type="text" name="rate_per_houres[]" value="${parseFloat(ratePerHoures).toFixed(2)}">
                                </td>
                                <td>
                                    <input class="form-control input_css total_amounts text-center" readonly type="text" name="total_amounts[]" value="${parseFloat(totalHoures*ratePerHoures).toFixed(2)}">
                                </td>
                            </tr>`
                        );
                        counter++;
                    });
                    subtotalAmount();
                    addCount();

            },
        });
        $('.show_click').removeClass('d-none');
        var vat=$('#branch_id').find(":selected").data('vat');
        $('.vat').val(vat);
     }
     function subtotalAmount(){
        var subTotal=0;
        $('.total_amounts').each(function(){
            subTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sub_total_amount').val(parseFloat(subTotal).toFixed(2));
    }
</script>
<script>
    function addRow(){
        var rowCount = $('#salarySheet tr').length;

var row=`
    <tr>
        <td>${rowCount+1}</td>
        <td>
            <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" name="employee_id[]" value="" placeholder="Employee Id">
            <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
            <input class="job_post_id" type="hidden" name="job_post_id[]" value="">
        </td>
        <td>
            <input class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate">
        </td>
        <td><input class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate"></td>
        <td>
            <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" type="number" name="duty_qty[]" placeholder="Duty Qty">
        </td>
        <td>
            <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="number" name="ot_qty[]" placeholder="OT Qty">
        </td>
        <td>
            <input class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" placeholder="Duty Amount">
        </td>
        <td>
            <input class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" placeholder="Ot Amount">
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
        <td>
            <input class="form-control total_amount TotalAmu" type="text" name="total_amount[]" placeholder="">
        </td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        </td>
    </tr>
`;
    $('#salarySheet').append(row);
}

function removeRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>

@endpush
