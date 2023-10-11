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
                        <form method="post" action="{{route('customerduty.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer</b></label>
                                    <select class="form-select customer_id" onchange="getEmployees(this)" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="customer_select_message text-danger"></p>
                                </div>
                                {{--  <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control" type="date" name="end_date" value="" placeholder="End Date">
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
                                        <tbody id="customerduty">
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
{{--  <script>
    function getEmployees(e){

        var customer_id = $('.customer_id');
        if (!customer_id.val()) {
            customer_id.focus();
            $('.customer_select_message').html('Please select a customer');
            return false;
        }
        customer_id.on('change', function() {
            if ($(this).val()) {
                $('.customer_select_message').hide();
            } else {
                $('.customer_select_message').html('Please select a customer').show();
            }
        });

        var pa = '<div style="color:red">Invalid Employee ID</div>';
        $(e).closest('tr').find('.employee_data').html('');
        var message=$(e).closest('tr').find('.employee_data').append(pa);

        var employee_id=$(e).closest('tr').find('.employee_id').val();
        var customerId = document.getElementById('customer_id').value;
        if(employee_id){
            $.ajax({
                url:"{{ route('empatt.getEmployee') }}",
                type: "GET",
                dataType: "json",
                data: { 'id':employee_id },
                success: function(data) {
                    if(data.length>0){
                        console.log(data);
                        var id = data[0].id;
                        var name = data[0].bn_applicants_name;
                        var contact = data[0].bn_parm_phone_my;
                        var position=data[0].position.name;
                        var positionid=data[0].bn_jobpost_id;

                        $(e).closest('tr').find('.employee_data').html(name+'-'+position);
                        $(e).closest('tr').find('.job_post_id').val(positionid);
                    }
                    getDutyOtRate(e,customerId,positionid);
                },
            });
        } else {
            $(e).closest('tr').find('.employee_name').val('');
            $(e).closest('tr').find('.employee_contact').val('');
            $(e).closest('tr').find('.employee_data').html('');
        }
    }

    function getDutyOtRate(e,customerId,positionid){
        $.ajax({
            url:"{{ route('get_employeedata') }}",
            type: "GET",
            dataType: "json",
            data: { 'customer_id':customerId,'job_post_id':positionid },
            success: function(data) {
                console.log(data);
                var dutyRate=data.duty_rate;
                var otRate=data.ot_rate;
                console.log(dutyRate)
                $(e).closest('tr').find('.duty_rate').val(dutyRate);
                $(e).closest('tr').find('.ot_rate').val(otRate);

            },
        });
    }

    function CalculateAmount(e){
        let dutyRate=$(e).closest('tr').find('.duty_rate').val()?parseFloat($(e).closest('tr').find('.duty_rate').val()):0;
        let otRate=$(e).closest('tr').find('.ot_rate').val()?parseFloat($(e).closest('tr').find('.ot_rate').val()):0;
        let dutyQty=$(e).closest('tr').find('.duty_qty').val()?parseFloat($(e).closest('tr').find('.duty_qty').val()):0;
        let otQty=$(e).closest('tr').find('.ot_qty').val()?parseFloat($(e).closest('tr').find('.ot_qty').val()):0;
        let dutyAmount=parseFloat(dutyRate*dutyQty);
        let otAmount=parseFloat(otRate*otQty);
        $(e).closest('tr').find('.duty_amount').val(dutyAmount);
        $(e).closest('tr').find('.ot_amount').val(otAmount);
        $(e).closest('tr').find('.total_amount').val(otAmount+dutyAmount);

        var totalDuty=0;
        var totalOt=0;
        var dutyAmountTotal=0;
        var otAmountFi=0;
        var totalAmountFi=0;
        $('.duty_qty').each(function(){
            totalDuty+=parseFloat($(this).val());
        });
        $('.ot_qty').each(function(){
            totalOt+=parseFloat($(this).val());
        });
        $('.DutyAmountF').each(function(){
            dutyAmountTotal+=parseFloat($(this).val());
        });
        $('.OtAmountFc').each(function(){
            otAmountFi+=parseFloat($(this).val());
        });
        $('.TotalAmu').each(function(){
            totalAmountFi+=parseFloat($(this).val());
        });
        $('.totalDutyP').val(totalDuty);
        $('.totalOtP').val(totalOt);
        $('.totalDutyAmount').val(dutyAmountTotal);
        $('.totalOtAmount').val(otAmountFi);
        $('.totalAmountPa').val(totalAmountFi);

    }

    function totalAmount(){

    }


</script>  --}}
<script>
    function addRow(){
        var rowCount = $('#customerduty tr').length;

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
    $('#customerduty').append(row);
}

function removeRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>

@endpush
