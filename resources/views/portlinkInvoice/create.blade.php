@extends('layout.app')

@section('pageTitle',trans('Portlink Invoice'))
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
                        <form method="post" action="{{route('invoiceGenerate.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2">
                                {{-- <div class="col-12">
                                    <span class="inv-notice text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                        <ul class="inv-info-detail" id="receivedAmountsList">
                                            <li><b>Invoice generated using employee assignment details</b></li>
                                            <li><b>Regular Count: Rate * Total Persons</b></li>
                                            <li><b>From the start date, calculate the total days of that month (days can be adjusted by the input "divided by" ) & divide the rate when (rate > 0 && duty > 0)</b></li>
                                            <li><b>If the condition (rate > 0 && duty > 0) is not true and (Total Persons <= 0), then we calculate Total Hours * Rate per hour = Total Amount</b></li>
                                            <li><b>The 'Working Day' column for Mamiya's invoice does not affect any calculations. The actual working days are stored from the start date, for other invoices</b></li>
                                        </ul>
                                    </span>
                                </div> --}}
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select required class="select2 form-select customer_id" id="customer_id" name="customer_id" onchange="getNote(this);">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                            <option data-zone="{{$c->zone_id}}" data-ctype="{{$c->customer_type}}" data-ins-vat="{{$c->vat}}" value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date" required>
                                </div>
                                <div class="col-lg-2 mt-2">
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
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getInvoiceData()" type="button" class="btn btn-primary">Generate Bill</button>
                                </div>
                            </div>
                            <div class="row mt-5 table-responsive-sm d-none show_click">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>SL</th>
                                            <th>Type of Service</th>
                                            <th>Salary & Others</th>
                                            <th>Commission</th>
                                            <th>Rate + Commission</th>
                                            <th>Person</th>
                                            <th>Duty</th>
                                            <th>Total Salary & Others (BDT)</th>
                                            <th>Total Commission (BDT)</th>
                                            <th>Total Bill</th>
                                        </tr>
                                    </thead>
                                    <tbody class="show_invoice_data">
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align: center;">
                                            <td colspan="2" style="text-align: left;">
                                                <span onClick='incressRowData();' class="text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                <span onClick='incressSupervisoRowData();' class="text-info mx-2"><i class="bi bi-plus-square-fill"></i></span>
                                                <span onClick='incressGuardRowData();' class="text-danger"><i class="bi bi-plus-square-fill"></i></span>
                                            </td>
                                            <th colspan="4" style="text-align: end;" width="37%">Sub Tatal</th>
                                            <td width="8%"></td>
                                            <td><input type="text" class="form-control text-center sub_total_salary" readonly></td>
                                            <td><input type="text" class="form-control text-center sub_total_commission" readonly></td>
                                            <td>
                                                <input readonly type="text" class="form-control sub_total_amount text-center" name="sub_total_amount" value="">
                                            </td>
                                        </tr>
                                        <tr id="repeater_less" style="text-align: center;"></tr>
                                        <tr id="supervisor" style="text-align: center;"></tr>
                                        <tr id="guard" style="text-align: center;"></tr>
                                        <tr style="text-align: end;">
                                            <td></td>
                                            <th colspan="5">Total Tk</th>
                                            <td></td>
                                            <td><input type="text" class="form-control text-center" readonly></td>
                                            <td><input type="text" class="form-control text-center" readonly></td>
                                            <td>
                                                <input type="text" class="form-control text-center total_tk" name="total_tk" value="" readonly>
                                                <input class="temporaty_total" type="hidden" name="temporaty_total[]" value="">
                                            </td>
                                        </tr>
                                        <tr style="text-align: end;">
                                            <td></td>
                                            <th colspan="5">Vat (<span class="vat_percent"></span> %)</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="text" class="form-control text-center vat_taka" name="vat_taka" value="" readonly></td>
                                        </tr>
                                        <tr style="text-align: end;">
                                            <td></td>
                                            <th colspan="5">Grand Total</th>
                                            <td></td>
                                            <td><input type="text" class="form-control text-center" readonly></td>
                                            <td><input type="text" class="form-control text-center" readonly></td>
                                            <td><input readonly type="text" class="form-control text-center grand_total" name="grand_total" value=""></td>
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
        if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }
        var customer=$('.customer_id').val();
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();

        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
            workingdayinmonth= new Date(syear, smonth, 0).getDate();
        let counter = 0;
        $.ajax({
            url: "{{route('get_port_invoice_data')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id:customer,start_date:startDate,end_date:endDate },
            success: function(invoice_data) {
                console.log(invoice_data);
                let selectElement = $('.show_invoice_data');
                    selectElement.empty();
                    $.each(invoice_data, function(index, value) {
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

                        rate = (value.rate > 0) ? value.rate : '0';
                        person = (value.qty > 0) ? value.qty : '0';
                        commission = (value.commission > 0) ? value.commission : '0';
                        ratePlusCommission = parseFloat(rate) + parseFloat(commission);
                        totalAmount = parseFloat(rate)*parseFloat(person);
                        // updated new
                        type_houre=value.hours;

                        selectElement.append(
                            `<tr style="text-align: center;">
                                <td>${counter + 1}</td>
                                <td>${value.name}
                                    <input class="" type="hidden" name="job_post_id[]" value="${value.job_post_id}">
                                </td>
                                <td>${value.rate}
                                    <input class="form-control input_css rate_c text-center" type="hidden" name="rate[]" value="${value.rate}" readonly>
                                </td>
                                <td>${value.commission}
                                    <input class="form-control input_css commission text-center" type="hidden" name="commission[]" value="${value.commission}" readonly>
                                </td>
                                <td>${ratePlusCommission}
                                    <input class="form-control input_css rate_with_commission text-center" type="hidden" name="rate_with_commission[]" value="${ratePlusCommission}" readonly>
                                </td>
                                <td>${value.qty}
                                    <input class="form-control input_css employee_qty_c text-center" type="hidden" name="employee_qty[]" value="${value.qty}" readonly>
                                </td>
                                <td>
                                    <input class="form-control input_css duty_day_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="duty_day[]" value="">
                                    <input type="hidden" name="actual_warking_day[]" value="${workingDays+1}">
                                    <input class="" type="hidden" name="st_date[]" value="${st_date}">
                                    <input class="" type="hidden" name="ed_date[]" value="${ed_date}">
                                    <input class="form-control input_css divide_by text-center" type="hidden" name="divide_by[]" value="${type_houre}">
                                    <input class="type_houre" type="hidden" name="type_houre[]" value="${type_houre}">
                                </td>
                                <td>
                                    <input class="form-control text-center input_css net_salary_amount" type="text" name="net_salary_amount[]" value="" readonly>
                                </td>
                                <td>
                                    <input class="form-control text-center input_css net_commission_amount" type="text" name="net_commission_amount[]" value="" readonly>
                                </td>
                                <td>
                                    <input class="form-control text-center input_css total_amounts" type="text" name="total_amounts[]" value="" readonly>
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
        var insVat=$('#customer_id').find(":selected").data('ins-vat');
        var customerType=$('#customer_id').find(":selected").data('ctype');
        if(customerType == 0){
            $('.vat').val(insVat);
        }else{
            $('.vat').val(vat);
        }
     }
     
     {{--  function lessCount(e){
        var totalLess=0;
        $('.less_count').each(function(){
            totalLess+= isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            //alert(totalLess)
        });
        //console.log(totalLess)
        $('.lessP').val(totalLess);
        var subTotal=$('.sub_total_amount').val();
        var totalLes=$('.lessP').val();
        var vat=isNaN(parseFloat($('.vat').val()))?0:parseFloat($('.vat').val());
        var totalTaka=parseFloat(subTotal-totalLes).toFixed(2);
        $('.total_tk').val(totalTaka);
        $('.temporaty_total').val(totalTaka);
        var vatTaka=parseFloat((totalTaka*vat)/100).toFixed(2);
        var grandTotal=parseFloat(totalTaka) + parseFloat(vatTaka);
        $('.vat_taka').val(vatTaka);
        $('.grand_total').val(parseFloat(grandTotal).toFixed(2));
    }  --}}
     function addCount(e){
        var totalAdd=0;
        $('.add_count').each(function(){
            totalAdd+= isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
            //alert(totalAdd)
        });
        //console.log(totalAdd)
        $('.addP').val(totalAdd);
        var addSubTotal=$('.sub_total_amount').val();
        var totalAdds=$('.addP').val();
        //var vat=isNaN(parseFloat($('.vat').val()))?0:parseFloat($('.vat').val());
        //var vat=$('#branch_id').find(":selected").data('vat');
        var vat=$('.vat').val();
        //console.log(vat);
        var totalAddTaka=parseFloat(addSubTotal) + parseFloat(totalAdds);
        $('.total_tk').val(totalAddTaka);
        $('.temporaty_total').val(totalAddTaka);
        var aVatTaka=parseFloat((totalAddTaka*vat)/100).toFixed(2);
        var aGrandTotal=parseFloat(totalAddTaka) + parseFloat(aVatTaka);
        $('.vat_taka').val(aVatTaka);
        $('.vat_percent').text(vat);
        //$('.vat').val(vat);
        $('.grand_total').val(parseFloat(aGrandTotal).toFixed(2));
    }
    function changeVat(e){
        let changeVat=$('.vat').val();
        var changeaddSubTotal=$('.temporaty_total').val();
        var changeaVatTaka=parseFloat((changeaddSubTotal*changeVat)/100).toFixed(2);
        var changeaGrandTotal=parseFloat(changeaddSubTotal) + parseFloat(changeaVatTaka);
        $('.vat_taka').val(changeaVatTaka);
        $('.grand_total').val(parseFloat(changeaGrandTotal).toFixed(2));
        $('.vat_percent').text(changeVat);
        reCalcultateInvoice();
    }
    function incressRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removeIncressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="5"><input class="form-control text-center" type="text" placeholder="Exaple: Add/Less: 01 duty Receptionist on 17-18/07/2023" name="add_description[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" placeholder="hour" name="add_hour[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="add_rate_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="add_comission_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="add_amount[]" readonly></td>
        </tr>
        `;
        $('#repeater_less').after(row);
    }

    function incressSupervisoRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removeIncressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="5"><input class="form-control text-center" type="text" value="Deduction:" name="supervisor_deduction_description[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" placeholder="hour" name="hour_supervisor[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="supervisor_rate_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="supervisor_comission_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="supervisor_amount[]" readonly></td>
        </tr>
        `;
        $('#supervisor').after(row);
    }
    function incressGuardRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removeIncressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="5"><input class="form-control text-center" type="text" value="Deduction:" name="guard_deduction_description[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" placeholder="hour" name="hour_guard[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="guard_rate_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="guard_comission_amount[]" readonly></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" name="guard_amount[]" readonly></td>
        </tr>
        `;
        $('#guard').after(row);
    }
    function removeIncressRowData(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
            addCount();
        }
    }
    function reCalcultateInvoice(e) {
        var rate=$(e).closest('tr').find('.rate_c').val();
        var commission=$(e).closest('tr').find('.commission').val();
        var dutyDay=$(e).closest('tr').find('.duty_day_c').val();
        var divideBy = $(e).closest('tr').find('.divide_by').val();

        var startDate=$('.start_date').val();
        let workingdayinMonth= new Date(startDate);
        let smonth=workingdayinMonth.getMonth()+1;
        let syear=workingdayinMonth.getFullYear();
            workingdayinMonth= new Date(syear, smonth, 0).getDate();

        let salary = parseFloat((rate/workingdayinMonth)*dutyDay).toFixed(2);
        let salaryCommission = parseFloat((commission/workingdayinMonth)*dutyDay).toFixed(2);
        let subTotalAmount = parseFloat(salary+salaryCommission).toFixed(2);

        $(e).closest('tr').find('.net_salary_amount').val(salary);  
        $(e).closest('tr').find('.net_commission_amount').val(salaryCommission);  
        $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
        subtotalAmount();
    }
    function subtotalAmount(){
        var subSalary=0;
        var subCommission=0;
        var subTotal=0;
        $('.net_salary_amount').each(function(){
            subSalary+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.net_commission_amount').each(function(){
            subCommission+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_amounts').each(function(){
            subTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sub_total_salary').val(parseFloat(subSalary).toFixed(2));
        $('.sub_total_commission').val(parseFloat(subCommission).toFixed(2));
        $('.sub_total_amount').val(parseFloat(subTotal).toFixed(2));
    }
</script>
@endpush