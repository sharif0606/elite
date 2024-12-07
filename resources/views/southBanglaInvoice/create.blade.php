@extends('layout.app')

@section('pageTitle',trans('South Bangla Invoice'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .input_css{
        border: none;
        outline: none;
    }
    .inv-notice, .due-details {
        position: relative;
        display: inline-block;
    }

    .inv-info-detail {
        display: none;
        position: absolute;
        left: 8px;
        top: 100%;
        margin-top: 1px;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        padding: 8px 22px 8px 22px;
        /* list-style: none; */
        z-index: 1;
        width: max-content;
        font-size: 1rem;
        background-color: rgb(39, 185, 243);
        color: white;
    }
    .inv-notice:hover .inv-info-detail {
        display: block;
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('southBanglaInvoice.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="zone_id" id="zone_id">
                            <div class="row p-2">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select required class="select2 form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this); checkZone(this); getNote(this);">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                            <option data-zone="{{$c->zone_id}}" data-ctype="{{$c->customer_type}}" data-ins-vat="{{$c->vat}}" value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for=""><b>Branch</b></label>
                                        <select class="form-select branch_id" id="branch_id" name="branch_id">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input required class="form-control start_date" type="date" onchange="getDivideBy(this);" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date" required>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input required class="form-control vat" onkeyup="changeVat(this)" step="0.01" type="number" name="vat" value="" placeholder="Vat">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="footerNote" rows="3" placeholder="Please enter Footer Note"></textarea>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Header Note</b></label>
                                    <textarea class="form-control" name="header_note" id="headerNote" rows="3" placeholder="Please enter Header Note"></textarea>
                                </div>
                            </div>
                            <div class="row mt-5 table-responsive-sm">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="20%">Staff details</th>
                                            <th width="15%">Category</th>
                                            <th width="10%">Days</th>
                                            <th>Net Payment to staff (Tk)</th>
                                            <th>Service charge (Tk)</th>
                                            <th>Total (Tk)</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inv-repeat">
                                        <tr style="text-align: center;">
                                            <th>
                                                <input type="text" class="form-control" onblur="getInvoiceData(this)" placeholder="employee ID">
                                                <div class="employee_data" style="color:green;font-size:14px;"></div>
                                                <input type="hidden" class="form-control employee_id" name="employee_id[]">
                                            </th>
                                            <td>
                                                {{-- <input type="text" class="form-control text-center job_post" value="" placeholder="designation" readonly> --}}
                                                {{-- <input type="hidden" class="form-control text-center job_post_id" name="job_post_id[]"> --}}
                                                <select class="form-control text-center job_post" name="job_post_id[]" required onchange="getEmployeeRate(this)">
                                                </select>

                                                <input type="hidden" class="form-control text-center pay_rate" name="rate[]">
                                                <input type="hidden" class="form-control text-center service_rate" name="service[]">
                                                <input type="hidden" class="form-control text-center divide_by" onkeyup="reCalculateInvoice(this)" name="divide_by[]">
                                            </td>
                                            <td><input type="text" class="form-control text-center duty_day" onkeyup="reCalculateInvoice(this)" name="duty_day[]" placeholder="duty"></td>
                                            <td><input type="text" class="form-control total text-center net_payment_amount" name="net_payment_amount[]" value="" readonly></td>
                                            <td><input type="text" class="form-control total text-center net_service_amount" name="net_service_amount[]" value="" readonly></td>
                                            <td><input type="text" class="form-control total text-center total_amounts" name="total_amounts[]" value="" readonly></td>
                                            <td><input type="text" class="form-control total text-center remarks" name="remarks[]" value=""></td>
                                            <td style="text-align: center;">
                                                <span onClick='incressRowData();' class="text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align: center;">
                                            <th colspan="3" style="text-align: center;" width="37%">Tatal (TK)</th>
                                            <td><input type="text" class="form-control text-center net_payment" name="net_payment" readonly></td>
                                            <td><input type="text" class="form-control text-center net_service" name="net_service" readonly></td>
                                            <td><input type="text" class="form-control total_with_service text-center" name="total" value="" readonly></td>
                                            <td></td>
                                            <td style="text-align: center;"></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th colspan="3">Vat (<span class="vat_percent"></span> %)</th>
                                            <td></td>
                                            <td><input type="text" class="form-control text-center vat_taka" name="vat_taka" value="" readonly></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th colspan="3">Grand Total</th>
                                            <td></td>
                                            <td><input type="text" class="form-control text-center grand_total" name="grand_total" value="" readonly></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
    function getNote(e) {
        let customerId = $(e).val();
        $('#headerNote').val('');
        $('#footerNote').val('');
        
        $.ajax({
            url: "{{route('get_customer_header_footer')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id: customerId },
            success: function(data) {
                console.log(data);
                
                let defaultHeader = 'Reference to the above subject, We herewith submitted the security services bill along with Chalan copy.';
                let defaultFooter = 'The payment may please be made in Cheques/Drafts/Cash in favor of "Elite Security Services Limited" by the 1st week of each month.';
                
                let header = data.header_note !== null ? data.header_note : defaultHeader;
                let footer = data.footer_note !== null ? data.footer_note : defaultFooter;
                
                $('#headerNote').val(header);
                $('#footerNote').val(footer);
                //oldCustomer = data.id;
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function checkZone(e){
        let customer_zone=$('#customer_id').find(":selected").data('zone');
        let branch_zone=$('#branch_id').find(":selected").data('zone');
        if(branch_zone)
            $('#zone_id').val(branch_zone);
        else
            $('#zone_id').val(customer_zone);
    }
    function getInvoiceData(e){

        if (!$('.customer_id').val()) {
            $('.customer_id').focus();
            return false;
        }
        if (!$('.branch_id').val()) {
            $('.branch_id').focus();
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
        var branch=$('.branch_id').val();
        var employee=$(e).val();
        var startDate=$('.start_date').val();

        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
            workingdayinmonth= new Date(syear, smonth, 0).getDate();
        var pa = '<div style="color:red">Not Found</div>';
        $(e).closest('tr').find('.employee_data').html('');
        var message=$(e).closest('tr').find('.employee_data').append(pa);

        if(employee){
            $.ajax({
                url: "{{route('get_south_bangla_designation')}}",
                type: "GET",
                dataType: "json",
                data: { customer_id:customer, branch_id:branch, employee_id:employee },
                success: function(data) {
                    console.log(data);
                    $(e).closest('tr').find('.divide_by').val(workingdayinmonth);
                    if(data.employee){
                        //if(data.designation.duty_rate > 0){
                            let category = '<option value="" selected>Select Designation</option>';
                            data.designation.forEach(function (item) {
                                category += `<option value="${item.job_post_id}">${item.name}</option>`;
                            });
                            $(e).closest('tr').find('.job_post').html(category); // Insert before pay_rate input
                            /*if (data.employee.en_applicants_name) {
                                $(e).closest('tr').find('.employee_data').html(data.employee.en_applicants_name);
                            } else if (data.employee.bn_applicants_name) {
                                $(e).closest('tr').find('.employee_data').html(data.employee.bn_applicants_name);
                            } else {
                                $(e).closest('tr').find('.employee_data').html('N/A');
                            }*/
                            $(e).closest('tr').find('.employee_id').val(data.employee.id);
                            /*$(e).closest('tr').find('.job_post').val(data.employee.post_name);
                            $(e).closest('tr').find('.job_post_id').val(data.employee.bn_jobpost_id);
                            $(e).closest('tr').find('.pay_rate').val(data.rate.duty_rate);
                            $(e).closest('tr').find('.service_rate').val(data.rate.service_rate);*/
                        //}
                    }
                },
            });
        }else{
            $(e).closest('tr').find('.job_post').val('');
            $(e).closest('tr').find('.employee_data').html('');
        }
        var vat=$('#branch_id').find(":selected").data('vat');
        var insVat=$('#customer_id').find(":selected").data('ins-vat');
        var customerType=$('#customer_id').find(":selected").data('ctype');
        if(customerType == 0){
            $('.vat').val(insVat);
        }else{
            $('.vat').val(vat);
        }
     }
     function getEmployeeRate(e) {
        if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }
        let customer = $('.customer_id').val();
        let branch = $('.branch_id').val();
        let employee =  $(e).closest('tr').find('.employee_id').val();
        let job_post = $(e).val(); // Gets the selected value from the dropdown
        var startDate=$('.start_date').val();
    
        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
        workingdayinmonth= new Date(syear, smonth, 0).getDate();

        $.ajax({
            url: "{{route('get_south_bangla_invoice_data')}}",
            type: "GET",
            dataType: "json",
            data: {
                customer_id: customer,
                branch_id: branch,
                employee_id: employee,
                job_post: job_post
            },
            success: function(data) {
                console.log(data);
                $(e).closest('tr').find('.divide_by').val(workingdayinmonth);
                if (data.employee.en_applicants_name) {
                        $(e).closest('tr').find('.employee_data').html(data.employee.en_applicants_name);
                    } else if (data.employee.bn_applicants_name) {
                        $(e).closest('tr').find('.employee_data').html(data.employee.bn_applicants_name);
                    } else {
                        $(e).closest('tr').find('.employee_data').html('N/A');
                    }
                    $(e).closest('tr').find('.pay_rate').val(data.rate.duty_rate);
                    $(e).closest('tr').find('.service_rate').val(data.rate.service_rate);
                    reCalculateInvoice();
            },
            error: function(xhr, status, error) {
                console.error("Error occurred:", error);
            }
        });
    }

     function getDivideBy(e){
        var startDate=$(e).val();
        console.log(startDate);
        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
            workingdayinmonth= new Date(syear, smonth, 0).getDate();
        $('.divide_by').val(workingdayinmonth);
        reCalculateInvoice();
     }
    
    function incressRowData(){
        var row=`
            <tr style="text-align: center;">
                <th>
                    <input type="text" class="form-control" onblur="getInvoiceData(this)" placeholder="employee ID">
                    <div class="employee_data" style="color:green;font-size:14px;"></div>
                    <input type="hidden" class="form-control employee_id" name="employee_id[]">
                </th>
                <td>
                    <!--<input type="text" class="form-control text-center job_post" value="" placeholder="designation" readonly>
                    <input type="hidden" class="form-control text-center job_post_id" name="job_post_id[]">-->
                    <select class="form-control text-center job_post" name="job_post_id[]" required onchange="getEmployeeRate(this)"></select>
                    <input type="hidden" class="form-control text-center pay_rate" name="rate[]">
                    <input type="hidden" class="form-control text-center service_rate" name="service[]">
                    <input type="hidden" class="form-control text-center divide_by" onkeyup="reCalculateInvoice(this)" name="divide_by[]">
                </td>
                <td><input type="text" class="form-control text-center duty_day" onkeyup="reCalculateInvoice(this)" name="duty_day[]" placeholder="duty"></td>
                <td><input type="text" class="form-control total text-center net_payment_amount" name="net_payment_amount[]" value="" readonly></td>
                <td><input type="text" class="form-control total text-center net_service_amount" name="net_service_amount[]" value="" readonly></td>
                <td><input type="text" class="form-control total text-center total_amounts" name="total_amounts[]" value="" readonly></td>
                <td><input type="text" class="form-control total text-center remarks" name="remarks[]" value=""></td>
                <td style="text-align: center;">
                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                </td>
            </tr>
            `;
        $('#inv-repeat').append(row);
    }
    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
            subtotalAmount();
            reCalculateInvoice();
        }
    }
    // function reCalculateInvoice(e) {
    //     if (!$('.start_date').val()) {
    //         $('.start_date').focus();
    //         return false;
    //     }
    //     var rate = parseFloat($(e).closest('tr').find('.pay_rate').val()) || 0;
    //     var serviceRate = parseFloat($(e).closest('tr').find('.service_rate').val()) || 0;
    //     var dutyDay = parseFloat($(e).closest('tr').find('.duty_day').val()) || 0;
    //     var divideBy = parseFloat($(e).closest('tr').find('.divide_by').val()) || 1;

    //     let salary = parseFloat((rate / divideBy) * dutyDay).toFixed(2);
    //     let serviceCharge = parseFloat((serviceRate / divideBy) * dutyDay).toFixed(2);
    //     let subTotalAmount = (parseFloat(salary) + parseFloat(serviceCharge)).toFixed(2);
    //     console.log(salary);
    //     console.log(serviceRate);

    //     $(e).closest('tr').find('.net_payment_amount').val(salary);  
    //     $(e).closest('tr').find('.net_service_amount').val(serviceCharge);  
    //     $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
        
    //     subtotalAmount();
    // }
    function reCalculateInvoice() {
        $('.divide_by').each(function() {
            var $row = $(this).closest('tr');
            
            var rate = parseFloat($row.find('.pay_rate').val()) || 0;
            var serviceRate = parseFloat($row.find('.service_rate').val()) || 0;
            var dutyDay = parseFloat($row.find('.duty_day').val()) || 0;
            var divideBy = parseFloat($row.find('.divide_by').val()) || 1;

            var salary = parseFloat((rate / divideBy) * dutyDay).toFixed(2);
            var serviceCharge = parseFloat((serviceRate / divideBy) * dutyDay).toFixed(2);
            var subTotalAmount = (parseFloat(salary) + parseFloat(serviceCharge)).toFixed(2);

            $row.find('.net_payment_amount').val(salary);
            $row.find('.net_service_amount').val(serviceCharge);
            $row.find('.total_amounts').val(subTotalAmount);
        });

        subtotalAmount(); // Ensure this is defined and handles the recalculation of any totals outside the table rows.
    }

    function subtotalAmount(){
        var netPay=0;
        var netService=0;
        $('.net_payment_amount').each(function(){
            netPay+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.net_service_amount').each(function(){
            netService+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });

        let netWithService = parseFloat(netPay) + parseFloat(netService);

        $('.net_payment').val(parseFloat(netPay).toFixed(2));
        $('.net_service').val(parseFloat(netService).toFixed(2));
        $('.total_with_service').val(parseFloat(netWithService).toFixed(2));

        changeVat();
    }

    function changeVat(e){
        let changeVat=$('.vat').val();
        var changeaddSubTotal=$('.net_service').val();
        var changeaVatTaka=parseFloat((changeaddSubTotal*changeVat)/100).toFixed(2);
        var changeaGrandTotal=parseFloat(changeaddSubTotal) + parseFloat(changeaVatTaka);
        $('.vat_taka').val(changeaVatTaka);
        $('.grand_total').val(Math.round(changeaGrandTotal) + '.00');
        $('.vat_percent').text(changeVat);
    }
</script>
@endpush