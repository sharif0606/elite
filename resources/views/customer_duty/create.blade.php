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
                                    <select class="form-select customer_id select2" id="customer_id" name="customer_id" onchange="showBranch(this.value);getEmployees(this);/*showjobPost(this)*/">
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
                                        <!-- <option value="">Select Branch</option>
                                        @forelse ($branch as $b)
                                            <option class="branch_hide branch_hide{{$b->customer_id}}" value="{{ $b->id }}">{{ $b->brance_name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse -->
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
                                    <input class="form-control startDate" onblur="DetailsShow()" type="date" name="start_date" placeholder="Start Date" value="{{ request('start_date', old('start_date')) }}">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control endDate" onblur="DetailsShow()" type="date" name="end_date" placeholder="End Date" value="{{ request('end_date', old('end_date')) }}">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col" rowspan="2">{{__('Employee ID')}}</th>
                                                <th scope="col" rowspan="2">{{__('Job Post')}}</th>
                                                <th scope="col" rowspan="2">{{__('Hours')}}</th>
                                                <th scope="col" rowspan="2">{{__('Duty Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT-Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('Duty Qty')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Qty')}}</th>
                                                <th scope="col" rowspan="2">{{__('Absent')}}</th>
                                                <th scope="col" rowspan="2">{{__('Vacant')}}</th>
                                                <th scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                                <th scope="col" colspan="3">{{__('Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('Duty Amount')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Amount')}}</th>
                                                <th scope="col" rowspan="2">{{__('Total')}}</th>
                                                <th scope="col" rowspan="2">{{__('Start Date')}}</th>
                                                <th scope="col" rowspan="2">{{__('End Date')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                            <tr>
                                                <th>CL</th>
                                                <th>SL</th>
                                                <th>EL</th>
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
                                                    <select class="form-select job_post_id select2" name="job_post_id[]" style="width:150px" onchange="getDutyOtRate(this)">
                                                        {{-- <option value="0">Select</option>
                                                        @foreach ($jobposts as $job)
                                                            <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}">{{ $job->name }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </td>
                                                <td>
                                                    {{-- <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px" onchange="getDutyOtRateHourWise(this)">
                                                        <option value="1">8 hours</option>
                                                        <option value="2">12 hours</option>
                                                    </select> --}}
                                                    <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px" onchange="getDutyOtRateHourWise(this)">
                                                        <option value="0">Select</option>        
                                                        @forelse ($hours as $hour)
                                                                <option value="{{ $hour->id }}">
                                                                    {{ $hour->hour }} Hour's
                                                                </option>
                                                            @empty
                                                                <option value="">No hours available</option>
                                                            @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="Duty Rate" style="width:120px;">
                                                </td>
                                                <td><input onkeyup="CalculateAmount(this)" class="form-control ot_rate" type="text" name="ot_rate[]" value="" placeholder="Ot Rate" style="width:120px;"></td>
                                                <td>
                                                    <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" onclick="checkOthersCustomerDuty(this)" type="text" name="duty_qty[]" value="0" placeholder="Duty Qty" style="width:60px;">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="text" name="ot_qty[]" value="0" placeholder="OT Qty" style="width:60px;">
                                                </td>

                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="0" placeholder="Absent">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="0" placeholder="Vacant">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="0" placeholder="Holiday/ festival">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="0" placeholder="Leave CL">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="0" placeholder="Leave SL">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="0" placeholder="Leave EL">
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
                                                <th colspan="5" class="text-end"> Total</th>
                                                <th><input readonly class="form-control totalDutyP" type="text" name="total_duty" placeholder="Duty"></th>
                                                <th><input readonly class="form-control totalOtP" type="text" name="total_ot" placeholder="Ot"></th>
                                                <th><input readonly class="form-control totalAb" type="text" name="total_ab" placeholder="Absent"></th>
                                                <th><input readonly class="form-control totalV" type="text" name="total_v" placeholder="Vacant"></th>
                                                <th><input readonly class="form-control totalHf" type="text" name="total_hf" placeholder="Holiday/Festival"></th>
                                                <th><input readonly class="form-control totalCl" type="text" name="total_cl" placeholder="CL"></th>
                                                <th><input readonly class="form-control totalSl" type="text" name="total_sl" placeholder="SL"></th>
                                                <th><input readonly class="form-control totalEl" type="text" name="total_el" placeholder="EL"></th>

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
        if (!value) {
            $('#branch_id').html('<option value="">Select Branch</option>');
            return;
        }
        /*let customer = value;
        console.log(customer);
         $('.branch_hide').hide();
         $('.branch_hide'+customer).show();
         if(old_customer_id!=customer){
            $('#branch_id').prop('selectedIndex', 0);
            $('#atm_id').prop('selectedIndex', 0);
             old_customer_id=customer;
         }*/

        $.ajax({
            url: '{{ route("get.branch") }}', // Or your route URL
            method: 'GET',
            data: { customer_id: value },
            success: function (response) {
                let $branchSelect = $('#branch_id');
                $branchSelect.empty(); // Clear current options
                $branchSelect.append('<option value="">Select Branch</option>');

                if (response.length > 0) {
                    response.forEach(function (branch) {
                        $branchSelect.append(`<option value="${branch.id}">${branch.brance_name}</option>`);
                    });
                } else {
                    $branchSelect.append('<option value="">No Data Found</option>');
                }
            },
            error: function () {
                alert('Failed to fetch branches');
            }
        });

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

    function getEmployees(e) {
    let customer_id = $('.customer_id');
    let branch_id = $('.branch_id option:selected').val();
    let atm_id = $('.atm_id option:selected').val();
    let customer_select_message = $('.customer_select_message');
    let employee_id = $(e).closest('tr').find('.employee_id').val();
    let employee_data = $(e).closest('tr').find('.employee_data');
    let job_post_id = $(e).closest('tr').find('.job_post_id');
    let employee_id_primary = $(e).closest('tr').find('.employee_id_primary');

    // Validate customer selection
    if (!customer_id.val()) {
        customer_id.focus();
        customer_select_message.html('Please select a customer');
        return false;
    }

    // If employee_id exists
    if (employee_id) {
        $.ajax({
            url: "{{ route('empatt.getEmployee') }}",
            type: "GET",
            dataType: "json",
            data: { id: employee_id },
            success: function(data) {
                if (data.length > 0) {
                    let employee = data[0];
                    employee_data.html(employee.bn_applicants_name);
                    job_post_id.find(`option[value="${employee.bn_jobpost_id}"]`).attr('selected', 'selected');
                    employee_id_primary.val(employee.id);

                    // Fetch job post details, passing employee_id
                    fetchJobPostDetails(customer_id.val(), branch_id, atm_id, employee.id, e);
                } else {
                    employee_data.html('');
                    employee_data.append(data.msg);
                }

                getDutyOtRate(e); // Assuming this function is defined elsewhere
            },
            error: function() {
                console.error("Error fetching employee data.");
            }
        });
    } else {
        // Clear fields if no employee_id
        employee_data.html('');
        $(e).closest('tr').find('.employee_name, .employee_contact').val('');
    }
}

function fetchJobPostDetails(customerId, branchId, atmId, employeeId, e) {
    $.ajax({
        url: "{{ route('emp.getEmployeeRate') }}",
        type: "GET",
        dataType: "json",
        data: {
            customer_id: customerId,
            branch_id: branchId,
            atm_id: atmId,
            employee_id: employeeId // Include employee_id here
        },
        success: function(data) {
            $(e).closest('tr').find('.job_post_id').html(data);
        },
        error: function() {
            console.error("Error fetching job post details.");
        }
    });
}



    function getDutyOtRate(e){
        let positionid = $(e).closest('tr').find('.job_post_id option:selected').data('jobpostid');
        let employee_id = $(e).closest('tr').find('.employee_id_primary').val();
        var customerId = $('.customer_id').val();
        var branchId = $('.branch_id').val();
        //console.log('Customer'.customerId);
        //console.log(customerId);
        $.ajax({
            url:"{{ route('get_employeedata') }}",
            type: "GET",
            dataType: "json",
            data: { 'customer_id':customerId,'job_post_id':positionid,'branch_id':branchId,'employee_id':employee_id },
            success: function(data) {
                console.log(data);
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
                console.log(data);
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
                    message +=  "Customer: " + duty.customer_name + (duty.customer_branch ? ', ' + duty.customer_branch : '') + "<br>" +
                                "General Duty: " + duty.general + "<br>" +
                                "OT Duty: " + duty.overtime + "<br>" +
                                "Total Amount: " + duty.total + "<br>";
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
        let absent=$(e).closest('tr').find('.absent').val()?parseFloat($(e).closest('tr').find('.absent').val()):0;
        let vacant=$(e).closest('tr').find('.vacant').val()?parseFloat($(e).closest('tr').find('.vacant').val()):0;
        let holiday_festival=$(e).closest('tr').find('.holiday_festival').val()?parseFloat($(e).closest('tr').find('.holiday_festival').val()):0;
        let leave_cl=$(e).closest('tr').find('.leave_cl').val()?parseFloat($(e).closest('tr').find('.leave_cl').val()):0;
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
            var otRateDay=otRate/totalDaysInMonth;//5000/28
        }
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
      
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));
        $(e).closest('tr').find('.total_amount').val(parseFloat(otAmount+dutyAmount).toFixed(2));

        var totalDuty=0;
        var totalOt=0;
        var totalAb=0;
        var totalV=0;
        var totalHf=0;
        var totalCl=0;
        var totalSl=0;
        var totalEl=0;
        var dutyAmountTotal=0;
        var otAmountFi=0;
        var totalAmountFi=0;
        $('.duty_qty').each(function(){
            totalDuty+=parseFloat($(this).val());
        });
        $('.ot_qty').each(function(){
            totalOt+=parseFloat($(this).val());
        });
        $('.absent').each(function(){
            totalAb+=parseFloat($(this).val());
        });
        $('.vacant').each(function(){
            totalV+=parseFloat($(this).val());
        });
        $('.holiday_festival').each(function(){
            totalHf+=parseFloat($(this).val());
        });
        $('.leave_cl').each(function(){
            totalCl+=parseFloat($(this).val());
        });
        $('.leave_sl').each(function(){
            totalSl+=parseFloat($(this).val());
        });
        $('.leave_el').each(function(){
            totalEl+=parseFloat($(this).val());
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
        $('.totalAb').val(totalAb);
        $('.totalV').val(totalV);
   
        $('.totalHf').val(totalHf);
        $('.totalCl').val(totalCl);
        $('.totalSl').val(totalSl);
        $('.totalEl').val(totalEl);
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
            <select class="form-select job_post_id select2" value="" name="job_post_id[]" style="width:150px;" onchange="getDutyOtRate(this)">
                {{--<option value="0">Select</option>
                @foreach ($jobposts as $job)
                    <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach--}}
            </select>
        </td>
        <td>
            <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px;" onchange="getDutyOtRateHourWise(this)">
                {{--<option value="1">8 hours</option>
                <option value="2">12 hours</option>--}}
                @forelse ($hours as $hour)
                <option value="{{ $hour->id }}">{{ $hour->hour }} Hour's</option>
                @empty
                <option value="">No hours available</option>
                @endforelse
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
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="0" placeholder="Absent">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="0" placeholder="Vacant">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="0" placeholder="Holiday/ festival">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="0" placeholder="Leave CL">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="0" placeholder="Leave SL">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="0" placeholder="Leave EL">
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
    $('#customerduty tr:last .select2').select2();
    DetailsShow();
}

function removeRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>

@endpush
