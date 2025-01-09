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
                                    <select class="form-select customer_id" onchange="showBranch(this.value);getEmployees(this)" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}" {{ $c->id==$custduty->customer_id?"selected":"" }}>{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="customer_select_message text-danger"></p>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="showAtm(this.value)">
                                        <option value="">Select Branch</option>
                                        @forelse ($branch as $b)
                                        <option class="branch_hide branch_hide{{$b->customer_id}}" value="{{ $b->id }}" {{ $b->id==$custduty->branch_id?"selected":"" }}>{{ $b->brance_name }}</option>
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
                                        <option class="atm_hide atm_hide{{$b->branch_id}}" value="{{ $b->id }}" {{ $b->id==$custduty->atm_id?"selected":"" }}>{{ $b->atm }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
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
                                                <th scope="col">{{__('Hours')}}</th>
                                                <th scope="col">{{__('Duty Rate')}}</th>
                                                <th scope="col">{{__('OT-Rate')}}</th>
                                                <th scope="col">{{__('Duty Qty')}}</th>
                                                <th scope="col">{{__('OT Qty')}}</th>
                                                <th scope="col" rowspan="2">{{__('Absent')}}</th>
                                                <th scope="col" rowspan="2">{{__('Vacant')}}</th>
                                                <th scope="col" rowspan="2">{{__('Holiday/ festival')}}</th>
                                                <th scope="col" colspan="3">{{__('Leave')}}</th>
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
                                                    <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" value="{{ $d->employee?->admission_id_no }}" placeholder="Employee Id" style="width:150px;">
                                                    <div class="employee_data" id="employee_data" style="color:green;font-size:14px;">{{ $d->employee?->bn_applicants_name }} -{{ $d->employee?->position?->name }}</div>
                                                    {{-- <input class="job_post_id" type="hidden" name="job_post_id[]" value=""> --}}
                                                    <input class="employee_id_primary" type="hidden" name="employee_id[]" value="{{ old('employee_id',$d->employee?->id) }}">
                                                </td>
                                                <td>
                                                    <select class="form-select" value="" name="job_post_id[]" style="width:150px" onchange="getDutyOtRate(this)" disabled>
                                                        <option value="0">Select</option>
                                                        @foreach ($jobposts as $job)
                                                        <option data-jobpostid='{{ $job->id }}' value="{{ $job->id }}" {{ $job->id==$d->job_post_id?"selected":"" }}>{{ $job->name }}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </td>
                                                <td>
                                                    {{-- <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px;" onchange="getDutyOtRateHourWise(this)">
                                                        <option value="1" {{ 1==$d->hours?"selected":"" }}>8 hours</option>
                                                    <option value="2" {{ 2==$d->hours?"selected":"" }}>12 hours</option>
                                                    </select> --}}
                                                    <select class="form-select job_post_hour" name="job_post_hour[]" style="width:100px;" onchange="getDutyOtRateHourWise(this)">
                                                        @forelse ($hours as $hour)
                                                        <option value="{{ $hour->id }}"
                                                            {{ $hour->id == $d->hours ? 'selected' : '' }}>
                                                            {{ $hour->hour }} Hour's
                                                        </option>
                                                        @empty
                                                        <option value="">No hours available</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" class="form-control duty_rate" type="text" name="duty_rate[]" value="{{ old('duty_rate',$d->duty_rate) }}" placeholder="Duty Rate" style="width:120px;">
                                                </td>
                                                <td><input onkeyup="CalculateAmount(this)" class="form-control ot_rate" type="text" name="ot_rate[]" value="{{ old('ot_rate',$d->ot_rate) }}" placeholder="Ot Rate" style="width:120px;"></td>
                                                <td>
                                                    <input class="form-control duty_qty" onkeyup="CalculateAmount(this)" onclick="checkOthersCustomerDuty(this)" type="text" name="duty_qty[]" value="{{ old('duty_qty',$d->duty_qty) }}" placeholder="Duty Qty" style="width:60px;">
                                                </td>
                                                <td>
                                                    <input class="form-control ot_qty" onkeyup="CalculateAmount(this)" type="text" name="ot_qty[]" value="{{ old('ot_qty',$d->ot_qty) }}" placeholder="OT Qty" style="width:60px;">
                                                </td>

                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="{{ old('absent',$d->absent) }}" placeholder="Absent">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="{{ old('vacant',$d->vacant) }}" placeholder="Vacant">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="{{ old('holiday_festival',$d->holiday_festival) }}" placeholder="Holiday/ festival">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="{{ old('leave_cl',$d->leave_cl) }}" placeholder="Leave CL">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="{{ old('leave_sl',$d->leave_sl) }}" placeholder="Leave SL">
                                                </td>
                                                <td>
                                                    <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="{{ old('leave_el',$d->leave_el) }}" placeholder="Leave EL">
                                                </td>


                                                <td>
                                                    <input readonly class="form-control duty_amount DutyAmountF" type="text" name="duty_amount[]" value="{{ old('duty_amount',$d->duty_amount) }}" placeholder="Duty Amount" style="width:120px;">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control ot_amount OtAmountFc" type="text" name="ot_amount[]" value="{{ old('ot_amount',$d->ot_amount) }}" placeholder="Ot Amount" style="width:120px;">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control total_amount TotalAmu" type="text" name="total_amount[]" value="{{ old('total_amount',$d->total_amount) }}" placeholder="Total Amount" style="width:120px;">
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
                                                <th colspan="5" class="text-center"> Total</th>
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
    /* call on load page */
    $(document).ready(function() {
        $('.branch_hide').hide();
        $('.atm_hide').hide();
    })
    let old_customer_id = 0;

    function showBranch(value) {
        let customer = value;
        console.log(customer);
        $('.branch_hide').hide();
        $('.branch_hide' + customer).show();
        if (old_customer_id != customer) {
            $('#branch_id').prop('selectedIndex', 0);
            $('#atm_id').prop('selectedIndex', 0);
            old_customer_id = customer;
        }
    }
    let old_branch_id = 0;

    function showAtm(value) {
        let branch = value;
        $('.atm_hide').hide();
        $('.atm_hide' + branch).show();
        if (old_branch_id != branch) {
            $('#atm_id').prop('selectedIndex', 0);
            old_branch_id = branch;
        }
    }
</script>
<script>
    function DetailsShow() {
        var startdate = $('.startDate').val();
        var enddate = $('.endDate').val();
        $('.startDateDetail').val(startdate);
        $('.endDateDetail').val(enddate);
        console.log(startdate);
    }

    window.onload = function() {
        // Get all input fields with class 'employee_id'
        var employeeInputs = document.querySelectorAll('.employee_id');
        
        // Loop through each input and call getEmployees
        employeeInputs.forEach(function(inputElement) {
            getEmployees(inputElement);
        });
    };


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
                data: {
                    id: employee_id
                },
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

    function getDutyOtRate(e) {
        let positionid = $(e).closest('tr').find('.job_post_id option:selected').data('jobpostid');
        var customerId = $('.customer_id').val();
        var branchId = $('.branch_id').val();
        //console.log('Customer'.customerId);
        //console.log(customerId);
        $.ajax({
            url: "{{ route('get_employeedata') }}",
            type: "GET",
            dataType: "json",
            data: {
                'customer_id': customerId,
                'job_post_id': positionid,
                'branch_id': branchId
            },
            success: function(data) {
                //console.log(data);
                var dutyRate = data.duty_rate;
                var otRate = data.ot_rate;
                var dutyHour = data.hours;
                console.log(dutyHour)
                $(e).closest('tr').find('.job_post_hour option').prop('selected', false).filter('[value="' + dutyHour + '"]').prop('selected', true);
                $(e).closest('tr').find('.duty_rate').val(dutyRate);
                $(e).closest('tr').find('.ot_rate').val(otRate);
                CalculateAmount(e);
            },
        });
    }

    function getDutyOtRateHourWise(e) {
        let positionid = $(e).closest('tr').find('.job_post_id').val();
        var customerId = $('.customer_id').val();
        var branchId = $('.branch_id').val();
        var dutyHour = $(e).closest('tr').find('.job_post_hour').val();
        //console.log('Customer'.customerId);
        console.log(dutyHour);
        $.ajax({
            url: "{{ route('get_employeedata_hourewise') }}",
            type: "GET",
            dataType: "json",
            data: {
                'customer_id': customerId,
                'job_post_id': positionid,
                'job_post_hour': dutyHour,
                'branch_id': branchId
            },
            success: function(data) {
                //console.log(data);
                var dutyRate = data.duty_rate;
                var otRate = data.ot_rate;
                console.log(dutyRate)
                $(e).closest('tr').find('.duty_rate').val(dutyRate);
                $(e).closest('tr').find('.ot_rate').val(otRate);
                CalculateAmount(e);
            },
        });
    }

    function checkOthersCustomerDuty(e) {
        var employee = $(e).closest('tr').find('.employee_id_primary').val();
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        $.ajax({
            url: "{{ route('get_employee_others_duty') }}",
            type: "GET",
            dataType: "json",
            data: {
                'employee_id': employee,
                'start_date': startDate,
                'end_date': endDate
            },
            success: function(data) {
                if (data.length > 0) {
                    // Construct the message
                    var message = "<span style='border-bottom: solid 2px; color: yellow;'>Employee duties found:</span><br>";
                    $.each(data, function(index, duty) {
                        message += "Customer: " + duty.customer_name + (duty.customer_branch ? ', ' + duty.customer_branch : '') + "<br>" +
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

    function CalculateAmount(e) {
        var divideByDayTotal = 0;
        var dutyRateDay = 0;
        var otRateDay = 0;
        var customer_id = $('.customer_id').val();
        let dutyRate = $(e).closest('tr').find('.duty_rate').val() ? parseFloat($(e).closest('tr').find('.duty_rate').val()) : 0;
        let otRate = $(e).closest('tr').find('.ot_rate').val() ? parseFloat($(e).closest('tr').find('.ot_rate').val()) : 0;
        let dutyQty = $(e).closest('tr').find('.duty_qty').val() ? parseFloat($(e).closest('tr').find('.duty_qty').val()) : 0;
        let otQty = $(e).closest('tr').find('.ot_qty').val() ? parseFloat($(e).closest('tr').find('.ot_qty').val()) : 0;
        //let currentDate = new Date();
        //let currentMonth = currentDate.getMonth() + 1;
        //let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let currentDate = $('.startDate').val();
        let currentMonth = new Date(currentDate).getMonth() + 1;
        let totalDaysInMonth = new Date(new Date(currentDate).getFullYear(), currentMonth, 0).getDate();
        // evercare setting
        if (totalDaysInMonth == 29) {
            var divideByDayTotal = (totalDaysInMonth - 5);
        } else {
            var divideByDayTotal = (totalDaysInMonth - 4);
        }
        // evercare setting
        if (customer_id == 21) {
            var dutyRateDay = dutyRate / divideByDayTotal;
            var otRateDay = otRate / divideByDayTotal;
        } else {
            var dutyRateDay = dutyRate / totalDaysInMonth;
            var otRateDay = otRate / totalDaysInMonth;
        }
        let dutyAmount = parseFloat(dutyRateDay * dutyQty);
        let otAmount = parseFloat(otRateDay * otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));
        $(e).closest('tr').find('.total_amount').val(parseFloat(otAmount + dutyAmount).toFixed(2));

        var totalDuty = 0;
        var totalOt = 0;
        var dutyAmountTotal = 0;
        var otAmountFi = 0;
        var totalAmountFi = 0;
        $('.duty_qty').each(function() {
            totalDuty += parseFloat($(this).val());
        });
        $('.ot_qty').each(function() {
            totalOt += parseFloat($(this).val());
        });
        $('.DutyAmountF').each(function() {
            dutyAmountTotal += parseFloat($(this).val());
        });
        $('.OtAmountFc').each(function() {
            otAmountFi += parseFloat($(this).val());
        });
        $('.TotalAmu').each(function() {
            totalAmountFi += parseFloat($(this).val());
        });
        $('.totalDutyP').val(totalDuty);
        $('.totalOtP').val(totalOt);
        $('.totalDutyAmount').val(dutyAmountTotal);
        $('.totalOtAmount').val(otAmountFi);
        $('.totalAmountPa').val(totalAmountFi);

    }

    function totalAmount() {

    }
</script>
<script>
    function addRow() {
        var row = `
    <tr>
        <td>
            <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" value="" placeholder="Employee Id" style="width:150px;">
            <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
            {{--<input class="job_post_id" type="text" name="job_post_id[]" value="">--}}
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
                {{--<option value="1" {{ 1==$d->hours?"selected":"" }}>8 hours</option>
                <option value="2" {{ 2==$d->hours?"selected":"" }}>12 hours</option>--}}
                @forelse ($hours as $hour)
                    <option value="{{ $hour->id }}"{{ $hour->id == $d->hours ? 'selected' : '' }}>{{ $hour->hour }} Hour's</option>
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
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control absent" type="text" name="absent[]" value="" placeholder="Absent">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control vacant" type="text" name="vacant[]" value="" placeholder="Vacant">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control holiday_festival" type="text" name="holiday_festival[]" value="" placeholder="Holiday/ festival">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_cl" type="text" name="leave_cl[]" value="" placeholder="Leave CL">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_sl" type="text" name="leave_sl[]" value="" placeholder="Leave SL">
        </td>
        <td>
            <input onkeyup="CalculateAmount(this)" style="width:100px;" class="form-control leave_el" type="text" name="leave_el[]" value="" placeholder="Leave EL">
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