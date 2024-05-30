@extends('layout.app')

@section('pageTitle',trans('Customer Duty/Employee Attend'))
@section('pageSubTitle',trans('Create'))

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
                        <form method="post" action="{{route('customerduty.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id" onchange="showBranch(this.value);getEmployees(this)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    {{--  <span class="customer_select_message"></span>  --}}
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="showAtm(this.value)">
                                        <option value="">Select Branch</option>
                                        @forelse ($branch as $b)
                                            <option class="branch_hide branch_hide{{$b->customer_id}}" value="{{ $b->id }}">{{ $b->brance_name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Atm</b></label>
                                    <select class="form-select atm_id" id="atm_id" name="atm_id">
                                        <option value="">Select Atm</option>
                                        @forelse ($atm as $b)
                                            <option class="atm_hide atm_hide{{$b->branch_id}}" value="{{ $b->id }}">{{ $b->atm }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control startDate" onblur="DetailsShow()" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control endDate" onblur="DetailsShow()" type="date" name="end_date" value="" placeholder="End Date">
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
                                                <th scope="col">{{__('Hours')}}</th>
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
                                            <tr>
                                                <td>
                                                    <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)"  value="" placeholder="Employee Id" style="width:150px;">
                                                    <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
                                                    <input class="employee_id_primary" type="hidden" name="employee_id[]" value="">
                                                </td>
                                                <td>
                                                    <select class="form-select job_post_id" name="job_post_id[]" style="width:150px" onchange="getDutyOtRate(this)">
                                                        <option value="0">Select</option>
                                                        @foreach ($jobposts as $job)
                                                            <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}">{{ $job->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px" onchange="getDutyOtRateHourWise(this)">
                                                        <option value="1">8 hours</option>
                                                        <option value="2">12 hours</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate" style="width:120px;">
                                                </td>
                                                <td><input onkeyup="CalculateAmount(this)" class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate" style="width:120px;"></td>
                                                <td>
                                                    <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" onclick="checkOthersCustomerDuty(this)" type="number" name="duty_qty[]" value="0" placeholder="Duty Qty" style="width:60px;">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="number" name="ot_qty[]" value="0" placeholder="OT Qty" style="width:60px;">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" value="0" placeholder="Duty Amount" style="width:120px;">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" value="0" placeholder="Ot Amount" style="width:120px;">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control total_amount TotalAmu" type="text" name="total_amount[]" value="0" placeholder="Total Amount" style="width:120px;">
                                                </td>
                                                <td>
                                                    <input class="form-control startDateDetail" type="date" name="start_date_details[]" value="" placeholder="Start Date">
                                                </td>
                                                <td>
                                                    <input class="form-control endDateDetail" type="date" name="end_date_details[]" value="" placeholder="End Date">
                                                </td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-center"> Total</th>
                                                <th><input readonly class="form-control totalDutyP" type="text" name="total_duty" placeholder="Total Duty"></th>
                                                <th><input readonly class="form-control totalOtP" type="text" name="total_ot" placeholder="Total Ot"></th>
                                                <th><input readonly class="form-control totalDutyAmount" type="text" name="total_duty_amount" placeholder="Duty Amount"></th>
                                                <th><input readonly class="form-control totalOtAmount" type="text" name="total_ot_amount" placeholder="Ot Amount"></th>
                                                <th><input readonly class="form-control totalAmountPa" type="text" name="finall_amount" placeholder="Total"></th>
                                                <th></th>
                                                <th></th>
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
    /* call on load page */
    $(document).ready(function(){
       $('.branch_hide').hide();
       $('.atm_hide').hide();
   })
   let old_customer_id=0;
   function showBranch(value){
        let customer = value;
        console.log(customer);
         $('.branch_hide').hide();
         $('.branch_hide'+customer).show();
         if(old_customer_id!=customer){
            $('#branch_id').prop('selectedIndex', 0);
            $('#atm_id').prop('selectedIndex', 0);
             old_customer_id=customer;
         }
    }
   let old_branch_id=0;
   function showAtm(value){
        let branch = value;
         $('.atm_hide').hide();
         $('.atm_hide'+branch).show();
         if(old_branch_id!=branch){
            $('#atm_id').prop('selectedIndex', 0);
             old_branch_id=branch;
         }
    }
</script>
<script>
    function DetailsShow(){
        var startdate = $('.startDate').val();
        var enddate = $('.endDate').val();
        $('.startDateDetail').val(startdate);
        $('.endDateDetail').val(enddate);
       // console.log(startdate);
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
        var branchId = $('.branch_id').val();
        //console.log('Customer'.customerId);
        //console.log(customerId);
        $.ajax({
            url:"{{ route('get_employeedata') }}",
            type: "GET",
            dataType: "json",
            data: { 'customer_id':customerId,'job_post_id':positionid,'branch_id':branchId },
            success: function(data) {
                //console.log(data);
                var dutyRate=data.duty_rate;
                var otRate=data.ot_rate;
                var dutyHour=data.hours;
                console.log(dutyHour)
                $(e).closest('tr').find('.job_post_hour option').prop('selected', false).filter('[value="' + dutyHour + '"]').prop('selected', true);
                $(e).closest('tr').find('.duty_rate').val(dutyRate);
                $(e).closest('tr').find('.ot_rate').val(otRate);
                CalculateAmount(e);
            },
        });
    }
    function getDutyOtRateHourWise(e){
        let positionid = $(e).closest('tr').find('.job_post_id').val();
        var customerId = $('.customer_id').val();
        var branchId = $('.branch_id').val();
        var dutyHour = $(e).closest('tr').find('.job_post_hour').val();
        //console.log('Customer'.customerId);
        //console.log(dutyHour);
        $.ajax({
            url:"{{ route('get_employeedata_hourewise') }}",
            type: "GET",
            dataType: "json",
            data: { 'customer_id':customerId,'job_post_id':positionid, 'job_post_hour':dutyHour,'branch_id':branchId },
            success: function(data) {
                //console.log(data);
                var dutyRate=data.duty_rate;
                var otRate=data.ot_rate;
                //console.log(dutyRate)
                $(e).closest('tr').find('.duty_rate').val(dutyRate);
                $(e).closest('tr').find('.ot_rate').val(otRate);
                CalculateAmount(e);
            },
        });
    }
    function checkOthersCustomerDuty(e){
        var employee = $(e).closest('tr').find('.employee_id_primary').val();
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        $.ajax({
            url:"{{ route('get_employee_others_duty') }}",
            type: "GET",
            dataType: "json",
            data: { 'employee_id':employee,'start_date':startDate, 'end_date':endDate },
            success: function(data) {
                if (data.length > 0) {
                    // Construct the message
                    var message = "<span style='border-bottom: solid 2px; color: yellow;'>Employee duties found:</span><br>";
                    $.each(data, function(index, duty) {
                    message +=  "Customer: " + duty.customer_name + "<br>" +
                                "General Duty: " + duty.general + "<br>" +
                                "OT Duty: " + duty.overtime + "<br>";
                    });
                    toastr.success(message);
                } else {
                    toastr.info("No duties found for the employee.");
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An error occurred while processing your request.";
                toastr.error(errorMessage);
            }
        });
    }

    function CalculateAmount(e){
        var divideByDayTotal = 0;
        var dutyRateDay=0;
        var otRateDay=0;
        var customer_id = $('.customer_id').val();
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
        // evercare setting
        if(totalDaysInMonth == 29){
            var divideByDayTotal = (totalDaysInMonth - 5);
        }else{
            var divideByDayTotal = (totalDaysInMonth - 4);
        }
        // evercare setting
        if(customer_id == 21){
            var dutyRateDay=dutyRate/divideByDayTotal;
            var otRateDay=otRate/divideByDayTotal;
        }else{
            var dutyRateDay=dutyRate/totalDaysInMonth;
            var otRateDay=otRate/totalDaysInMonth;
        }
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
            <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" value="" placeholder="Employee Id" style="width:150px;">
            <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
            <input class="employee_id_primary" type="hidden" name="employee_id[]" value="">
        </td>
        <td>
            <select class="form-select job_post_id" value="" name="job_post_id[]" style="width:150px;" onchange="getDutyOtRate(this)">
                <option value="0">Select</option>
                @foreach ($jobposts as $job)
                    <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px;" onchange="getDutyOtRateHourWise(this)">
                <option value="1">8 hours</option>
                <option value="2">12 hours</option>
            </select>
        </td>
        <td>
            <input readonly class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate" style="width:120px;">
        </td>
        <td><input readonly class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate" style="width:120px;"></td>
        <td>
            <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" onclick="checkOthersCustomerDuty(this)" type="text" name="duty_qty[]" value="0" placeholder="Duty Qty" style="width:60px;">
        </td>
        <td>
            <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="text" name="ot_qty[]" value="0" placeholder="OT Qty" style="width:60px;">
        </td>
        <td>
            <input readonly class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" value="0" placeholder="Duty Amount" style="width:120px;">
        </td>
        <td>
            <input readonly class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" value="0" placeholder="Ot Amount" style="width:120px;">
        </td>
        <td>
            <input readonly class="form-control total_amount TotalAmu" type="text" name="total_amount[]" value="0" placeholder="Total Amount" style="width:120px;">
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
