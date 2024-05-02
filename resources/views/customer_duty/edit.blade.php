@extends('layout.app')

@section('pageTitle',trans('Customer Duty/Employee Attend Update'))
@section('pageSubTitle',trans('Update'))

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('customerduty.update', [encryptor('encrypt',$custduty->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer</b></label>
                                    <select class="form-select customer_id" onchange="getEmployees(this)" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}" {{ $c->id==$custduty->customer_id?"selected":"" }}>{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="customer_select_message text-danger"></p>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control startDate" onblur="DetailsShow()" type="date" name="start_date" value="{{ old('start_date',$custduty->start_date) }}" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control endDate" onblur="DetailsShow()" type="date" name="end_date" value="{{ old('end_date',$custduty->end_date) }}" placeholder="End Date">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Employee ID')}}</th>
                                                <th scope="col">{{__('Job Post')}}</th>
                                                <th scope="col">{{__('Duty Rate')}}</th>
                                                <th scope="col">{{__('OT-Rate')}}</th>
                                                <th scope="col">{{__('Duty Qty')}}</th>
                                                <th scope="col">{{__('OT Qty')}}</th>
                                                <th scope="col">{{__('Duty Amount')}}</th>
                                                <th scope="col">{{__('OT Amount')}}</th>
                                                <th scope="col">{{__('Total')}}</th>
                                                <th scope="col">{{__('Start Date')}}</th>
                                                <th scope="col">{{__('End Date')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customerduty">
                                            @if ($custduty->details)
                                            @foreach ($custduty->details as $d)
                                            <tr>
                                                <td>
                                                    <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" value="{{ $d->employee?->admission_id_no }}" placeholder="Employee Id">
                                                    <div class="employee_data" id="employee_data" style="color:green;font-size:14px;">{{ $d->employee?->bn_applicants_name }} -{{ $d->employee?->position?->name }}</div>
                                                    {{-- <input class="job_post_id" type="hidden" name="job_post_id[]" value=""> --}}
                                                    <input class="employee_id_primary" type="hidden" name="employee_id[]" value="{{ old('employee_id',$d->employee?->id) }}">
                                                </td>
                                                <td>
                                                    <select class="form-select job_post_id" value="" name="job_post_id[]" style="width:150px" onchange="getDutyOtRate(this)">
                                                        <option value="0">Select</option>
                                                        @foreach ($jobposts as $job)
                                                            <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}" {{ $job->id==$d->job_post_id?"selected":"" }}>{{ $job->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input readonly class="form-control duty_rate" type="text" name="duty_rate[]" value="{{ old('duty_rate',$d->duty_rate) }}" placeholder="Duty Rate">
                                                </td>
                                                <td><input readonly class="form-control ot_rate" type="text" name="ot_rate[]" value="{{ old('ot_rate',$d->ot_rate) }}" placeholder="Ot Rate"></td>
                                                <td>
                                                    <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" type="number" name="duty_qty[]" value="{{ old('duty_qty',$d->duty_qty) }}" placeholder="Duty Qty">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="number" name="ot_qty[]" value="{{ old('ot_qty',$d->ot_qty) }}" placeholder="OT Qty">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" value="{{ old('duty_amount',$d->duty_amount) }}" placeholder="Duty Amount">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" value="{{ old('ot_amount',$d->ot_amount) }}" placeholder="Ot Amount">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control total_amount TotalAmu" type="text" name="total_amount[]" value="{{ old('total_amount',$d->total_amount) }}" placeholder="Total Amount">
                                                </td>
                                                <td>
                                                    <input class="form-control startDateDetail" type="date" name="start_date_details[]" value="{{ old('start_date',$d->start_date) }}" placeholder="Start Date">
                                                </td>
                                                <td>
                                                    <input class="form-control endDateDetail" type="date" name="end_date_details[]" value="{{ old('end_date',$d->end_date) }}" placeholder="End Date">
                                                </td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-center"> Total</th>
                                                <th><input readonly class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty" value="{{ old('total_duty',$custduty->total_duty) }}"></th>
                                                <th><input readonly class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot" value="{{ old('total_ot',$custduty->total_ot) }}"></th>
                                                <th><input readonly class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount" value="{{ old('total_duty_amount',$custduty->total_duty_amount) }}"></th>
                                                <th><input readonly class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount" value="{{ old('total_ot_amount',$custduty->total_ot_amount) }}"></th>
                                                <th><input readonly class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total" value="{{ old('finall_amount',$custduty->finall_amount) }}"></th>
                                                <th></th>
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
    function DetailsShow(){
        var startdate = $('.startDate').val();
        var enddate = $('.endDate').val();
        $('.startDateDetail').val(startdate);
        $('.endDateDetail').val(enddate);
        console.log(startdate);
    }

    function getEmployees(e){
        var customer_id = $('.customer_id');
        var customer_select_message = $('.customer_select_message');
        if (!customer_id.val()) {
            customer_id.focus();
            customer_select_message.html('Please select a customer');
            return false;
        }
        //customer_id.on('change', function() {
         //   if ($(this).val()) {
         //       customer_select_message.hide();
        //    } else {
         //       customer_select_message.html('Please select a customer').show();
        //    }
        //});
        var pa = '<div style="color:red">Invalid Employee ID</div>';
        $(e).closest('tr').find('.employee_data').html('');
        var message=$(e).closest('tr').find('.employee_data').append(pa);

        var employee_id=$(e).closest('tr').find('.employee_id').val();
        //console.log('E='+employee_id);
        var customerId = document.getElementById('customer_id').value;
        if(employee_id){
            $.ajax({
                url:"{{ route('empatt.getEmployee') }}",
                type: "GET",
                dataType: "json",
                data: { 'id':employee_id },
                success: function(data) {
                   // console.log(data);
                    //console.log(employee_id);
                    if(data.length>0){
                        //console.log(data);
                        var id = data[0].id;
                        var name = data[0].bn_applicants_name;
                        var contact = data[0].bn_parm_phone_my;
                        var position=data[0].position.name;
                        var positionid=data[0].bn_jobpost_id;
                        //console.log('Position'.positionid);
                        $(e).closest('tr').find('.employee_data').html(name);
                        // Select the corresponding option in the select element
                        $(e).closest('tr').find('.job_post_id option[value="' + positionid + '"]').attr('selected', 'selected');
                        //$(e).closest('tr').find('.job_post_id').val(positionid);
                        $(e).closest('tr').find('.employee_id_primary').val(id);
                    }
                    getDutyOtRate(e);
                },
            });
        } else {
            $(e).closest('tr').find('.employee_name').val('');
            $(e).closest('tr').find('.employee_contact').val('');
            $(e).closest('tr').find('.employee_data').html('');
        }
    }

    function getDutyOtRate(e){
        let positionid = $(e).closest('tr').find('.job_post_id option:selected').data('jobpostid');
        var customerId = $('.customer_id').val();
        //console.log('Customer'.customerId);
        //console.log(customerId);
        $.ajax({
            url:"{{ route('get_employeedata') }}",
            type: "GET",
            dataType: "json",
            data: { 'customer_id':customerId,'job_post_id':positionid },
            success: function(data) {
                //console.log(data);
                var dutyRate=data.duty_rate;
                var otRate=data.ot_rate;
                //console.log(dutyRate)
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
        //let currentDate = new Date();
        //let currentMonth = currentDate.getMonth() + 1;
        //let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let currentDate = $('.startDate').val();
        let currentMonth = new Date(currentDate).getMonth() + 1;
        let totalDaysInMonth = new Date(new Date(currentDate).getFullYear(), currentMonth, 0).getDate();
        let dutyRateDay=dutyRate/totalDaysInMonth;
        let otRateDay=otRate/totalDaysInMonth;
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));
        $(e).closest('tr').find('.total_amount').val(parseFloat(otAmount+dutyAmount).toFixed(2));

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


</script>
<script>
function addRow(){
    var row=`
    <tr>
        <td>
            <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" value="" placeholder="Employee Id">
            <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
            <input class="job_post_id" type="hidden" name="job_post_id[]" value="">
            <input class="employee_id_primary" type="hidden" name="employee_id[]" value="">
        </td>
        <td>
            <select class="form-select job_post_id" value="" name="job_post_id[]" style="width:150px" onchange="getDutyOtRate(this)">
                <option value="0">Select</option>
                @foreach ($jobposts as $job)
                    <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input readonly class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate">
        </td>
        <td><input readonly class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate"></td>
        <td>
            <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" type="text" name="duty_qty[]" value="0" placeholder="Duty Qty">
        </td>
        <td>
            <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="text" name="ot_qty[]" value="0" placeholder="OT Qty">
        </td>
        <td>
            <input readonly class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" value="0" placeholder="Duty Amount">
        </td>
        <td>
            <input readonly class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" value="0" placeholder="Ot Amount">
        </td>
        <td>
            <input readonly class="form-control total_amount TotalAmu" type="text" name="total_amount[]" value="0" placeholder="Total Amount">
        </td>
        <td>
            <input class="form-control startDateDetail" type="date" name="start_date_details[]" value="" placeholder="Start Date">
        </td>
        <td>
            <input class="form-control endDateDetail" type="date" name="end_date_details[]" value="" placeholder="End Date">
        </td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
            {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
        </td>
    </tr>
    `;
    $('#customerduty').append(row);
    DetailsShow();
}

function removeRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>

@endpush
