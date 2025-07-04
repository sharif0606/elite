@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
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
                            <input type="hidden" name="zone_id" id="zone_id">
                            <div class="row p-2">
                                <div class="col-12">
                                    <span class="inv-notice text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                        <ul class="inv-info-detail" id="receivedAmountsList">
                                            <li><b>Invoice generated using employee assignment details</b></li>
                                            <li><b>Regular Count: Rate * Total Persons</b></li>
                                            <li><b>From the start date, calculate the total days of that month (days can be adjusted by the input "divided by" ) & divide the rate when (rate > 0 && duty > 0)</b></li>
                                            <li><b>If the condition (rate > 0 && duty > 0) is not true and (Total Persons <= 0), then we calculate Total Hours * Rate per hour = Total Amount</b></li>
                                            <li><b>The 'Working Day' column for Mamiya's invoice does not affect any calculations. The actual working days are stored from the start date, for other invoices</b></li>
                                        </ul>
                                    </span>
                                </div>
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
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="getAtm(this);addCount(this);checkZone(this);">
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
                                    <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date" required>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input required class="form-control vat" onkeyup="changeVat(this)" step="0.01" type="number" name="vat" value="" placeholder="Vat">
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="footerNote" rows="3" placeholder="Please enter Footer Note"></textarea>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Header Note</b></label>
                                    <textarea class="form-control" name="header_note" id="headerNote" rows="3" placeholder="Please enter Header Note"></textarea>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Subject</b></label>
                                    <textarea class="form-control" name="inv_subject" rows="3"></textarea>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label for=""><b>With Bonus</b></label>
                                    <select class="form-select bonus" id="bonus">
                                        <option value="1">Yes</option>
                                        <option value="2" selected>No</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label for=""><b>Bonus For</b></label>
                                    <select class="form-select bonus_for" id="bonus_for">
                                        <option value="">Select</option>
                                        <option value="1">EID Ul FITR</option>
                                        <option value="2">EID Ul AZHA</option>
                                    </select>
                                </div>
                                <div class="col-lg-8 mt-2">
                                </div>
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getInvoiceData()" type="button" class="btn btn-primary">Generate Bill</button>
                                </div>
                            </div>
                            <div class="row mt-5 table-responsive-sm d-none show_click">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>S.L</th>
                                            <th>Service</th>
                                            <th>Rate</th>
                                            <th>Total Person</th>
                                            <th>Bonus</th>
                                            <th>Working Days</th>
                                            <th>Divide By</th>
                                            <th>Duty</th>
                                            <th>Total Hours</th>
                                            <th>Rate per hours</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="show_invoice_data">
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align: center;">
                                            <td class="d-flex">
                                                {{--  <span onClick='decressRowData();' class="add-row text-danger"><i class="bi bi-dash-circle-fill"></i></span>  --}}
                                                <span onClick='incressRowData();' class="text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                            </td>
                                            <th colspan="9" style="text-align: end;">Sub Tatal</th>
                                            <td>
                                                <input readonly type="text" class="form-control sub_total_amount text-center" name="sub_total_amount" value="">
                                                {{--  <input class="lessP" type="hidden" name="less_total[]" value="">  --}}
                                                <input class="addP" type="hidden" name="add_total[]" value="">
                                            </td>
                                        </tr>
                                        <tr id="repeater_less" style="text-align: center;">
                                            {{--  <td>
                                                <span onClick='decressRowData();' class="add-row text-danger"><i class="bi bi-dash-circle-fill"></i></span>
                                                <span onClick='incressRowData();' class="text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                            </td>
                                            <td colspan="7"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name="less_description[]"></td>
                                            <td><input class="form-control text-center less_count" type="text" onkeyup="lessCount(this)" placeholder="amount" name="less_amount[]"></td>  --}}
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="9">Total Tk</th>
                                            <td>
                                                <input readonly type="text" class="form-control text-center total_tk" name="total_tk" value="">
                                                <input class="temporaty_total" type="hidden" name="temporaty_total[]" value="">
                                                {{-- this temporaty_total for switch vat and change vat percent --}}
                                            </td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="9">Vat (<span class="vat_percent"></span> %) || Vat on Subtotal <input type="checkbox" onchange="noVat(this)" class="form-check-input vat_switch" value="0" name="vat_switch"></th>
                                            <td><input readonly type="text" class="form-control text-center vat_taka" name="vat_taka" value=""></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="9">Grand Total</th>
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
        var branch_id=$('.branch_id').val();
        var atm_id=$('.atm_id').val();
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();
        var bonus = $('.bonus').val();
        var bonus_for = $('.bonus_for').val();
        
        var total_bonus = 0;
 

        let workingdayinmonth= new Date(startDate);
        let smonth=workingdayinmonth.getMonth()+1;
        let syear=workingdayinmonth.getFullYear();
            workingdayinmonth= new Date(syear, smonth, 0).getDate();
        let counter = 0;
        $.ajax({
            url: "{{route('get_invoice_data')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id:customer,branch_id:branch_id,atm_id:atm_id,start_date:startDate,end_date:endDate },
            success: function(invoice_data) {
                console.log(invoice_data);
                let selectElement = $('.show_invoice_data');
                    selectElement.empty();
                    $.each(invoice_data, function(index, value) {
                        //console.log("value.start_date:", value.start_date);
                        //console.log("this start date:", startDate);
                        let ATMdata= value.atm>'0'?value.atm:'';
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
                            if(value.start_date == startDate)
                                st_date=value.start_date;
                            else{
                                st_date=startDate;
                            }
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

                        /*=========Bonus Calculation========= */
                        if(bonus == 1){
                            if(value.bonus_type == 1)
                            total_bonus = parseFloat(value.qty)*parseFloat(value.bonus_amount)
                            else
                            total_bonus = parseInt((value.rate*(value.bonus_amount/100))*value.qty);
                        }


                        // if(value.hours=="1"){
                        //     totalHoures=(8*(value.qty)*(workingDays+1));
                        //     ratePerHoures=parseFloat(value.rate/(8*workingdayinmonth));
                        //     // updated new
                        //     rate = (value.rate > 0) ? value.rate : '0';
                        //     person = (value.qty > 0) ? value.qty : '0';
                        //     totalAmount = parseFloat(rate)*parseFloat(person);
                        //     // updated new
                        //     type_houre=8;
                        // }else{
                        //     totalHoures=(12*(value.qty)*(workingDays+1));
                        //     ratePerHoures=parseFloat(value.rate/(12*workingdayinmonth));
                        //     // updated new
                        //     rate = (value.rate > 0) ? value.rate : '0';
                        //     person = (value.qty > 0) ? value.qty : '0';
                        //     totalAmount = parseFloat(rate)*parseFloat(person);
                        //     // updated new
                        //     type_houre=12;
                        // }
                        rate = (value.rate > 0) ? value.rate : '0';
                        person = (value.qty > 0) ? value.qty : '0';
                        totalAmount = parseFloat(rate)*parseFloat(person);
                        // updated new
                        type_houre=value.hours;

                        selectElement.append(
                            `<tr style="text-align: center;">
                                <td>${counter + 1}</td>
                                <td>${value.name} <br/> ${ATMdata}
                                    <input class="" type="hidden" name="job_post_id[]" value="${value.job_post_id}">
                                    <input class="" type="hidden" name="detail_atm_id[]" value="${value.atm_id}">
                                </td>
                                <td>
                                    <input class="form-control input_css rate_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="rate[]" value="${value.rate}">
                                </td>
                                <td>
                                    <input class="form-control input_css employee_qty_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="employee_qty[]" value="${value.qty}">
                                </td>
                                <td>
                                    <input class="form-control input_css bonus_amount text-center" readonly type="text" value="${total_bonus > 0 ? (value.bonus_amount ?? '') : ''}">
                                    <input class="form-control input_css bonus_amount text-center" onkeyup="reCalcultateInvoice(this)" type="hidden" name="bonus_amount[]" value="${total_bonus}">
                                    <input class="bonus_type" type="hidden" name="bonus_type[]" value="${total_bonus>0?value.bonus_type:null}">
                                     <input class="bonus_type" type="hidden" name="bonus_rate[]" value="${total_bonus>0?value.bonus_amount:null}">
                                    <input class="bonus_for" type="hidden" name="bonus_for[]" value="${total_bonus>0?bonus_for:null}">
                                </td>
                                <td>
                                    <input class="form-control input_css text-center" type="text" name="warking_day[]" value="">
                                    <input type="hidden" name="actual_warking_day[]" value="${workingDays+1}">
                                    <input class="" type="hidden" name="st_date[]" value="${st_date}">
                                    <input class="" type="hidden" name="ed_date[]" value="${ed_date}">
                                </td>
                                <td>
                                    <input class="form-control input_css divide_by text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="divide_by[]" value="">
                                </td>
                                <td>
                                    <input class="form-control input_css duty_day_c text-center" onkeyup="reCalcultateInvoice(this)" type="text" name="duty_day[]" value="">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateInvoice(this)" class="form-control input_css total_houres_c" type="text" name="total_houres[]" value="">
                                    <input class="type_houre" type="hidden" name="type_houre[]" value="${type_houre}">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateInvoice(this)" class="form-control input_css rate_per_houres_c" type="text" name="rate_per_houres[]" value="">
                                </td>
                                <td>
                                    <input class="form-control input_css total_amounts text-center" readonly type="text" name="total_amounts[]" value="${total_bonus?total_bonus:totalAmount}">
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
     function subtotalAmount(){
        var subTotal=0;
        $('.total_amounts').each(function(){
            subTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sub_total_amount').val(parseFloat(subTotal).toFixed(2));
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

    function noVat(checkbox) {
        checkbox.value = checkbox.checked ? '1' : '0';
        addCount(checkbox);
    }
    function addCount(e){
        var totalAdd=0;
        let noVatCheck = $('.vat_switch').val();
        console.log(noVatCheck);
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
        if(noVatCheck == 1){
            var totalAddTaka = addSubTotal;
        }else{
            var totalAddTaka=parseFloat(addSubTotal) + parseFloat(totalAdds);
        }
        var totalAfterLess = parseFloat(addSubTotal) + parseFloat(totalAdds);
        $('.total_tk').val(totalAfterLess);
        $('.temporaty_total').val(totalAfterLess);
        var aVatTaka=parseFloat((totalAddTaka*vat)/100).toFixed(2);
        var aGrandTotal=parseFloat(totalAfterLess) + parseFloat(aVatTaka);
        $('.vat_taka').val(aVatTaka);
        $('.vat_percent').text(vat);
        //$('.vat').val(vat);
        $('.grand_total').val(parseFloat(aGrandTotal).toFixed(2));
    }
    function changeVat(e){
        let changeVat=$('.vat').val();
        if(noVatCheck == 1){
            var changeaddSubTotal=$('.sub_total_amount').val();
        }else{
            var changeaddSubTotal=$('.temporaty_total').val();
        }
        var changeaVatTaka=parseFloat((changeaddSubTotal*changeVat)/100).toFixed(2);
        var changeaGrandTotal=parseFloat(changeaddSubTotal) + parseFloat(changeaVatTaka);
        $('.vat_taka').val(changeaVatTaka);
        $('.grand_total').val(parseFloat(changeaGrandTotal).toFixed(2));
        $('.vat_percent').text(changeVat);
        reCalcultateInvoice();
    }
     {{--  function decressRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removedecressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="8"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name="less_description[]"></td>
            <td><input class="form-control text-center less_count" type="text" onkeyup="lessCount(this)" placeholder="less amount" name="less_amount[]"></td>
        </tr>
        `;
            $('#repeater_less').after(row);
        }
        function removedecressRowData(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
                lessCount();
            }
        }  --}}
     function incressRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removeIncressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="8"><input class="form-control text-center" type="text" placeholder="Exaple: Add/Less: 01 duty Receptionist on 17-18/07/2023" name="add_description[]"></td>
            <td><input class="form-control text-center add_count" type="text" onkeyup="addCount(this)" placeholder="add amount" name="add_amount[]"></td>
        </tr>
        `;
            $('#repeater_less').after(row);
        }
        function removeIncressRowData(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
                addCount();
            }
        }
        function reCalcultateInvoice(e) {
            var rate=$(e).closest('tr').find('.rate_c').val();
            var person=$(e).closest('tr').find('.employee_qty_c').val();
            var dutyDay=$(e).closest('tr').find('.duty_day_c').val();
            var totalHour = $(e).closest('tr').find('.total_houres_c').val();
            var ratePerHour = $(e).closest('tr').find('.rate_per_houres_c').val();
            var divideBy = $(e).closest('tr').find('.divide_by').val();

            var startDate=$('.start_date').val();
            let workingdayinMonth= new Date(startDate);
            let smonth=workingdayinMonth.getMonth()+1;
            let syear=workingdayinMonth.getFullYear();
                workingdayinMonth= new Date(syear, smonth, 0).getDate();

            if(dutyDay > 0 && rate > 0){
                if(divideBy > 0){
                    let subTotalAmount=parseFloat((rate/divideBy)*dutyDay).toFixed(2);
                        $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
                        subtotalAmount();
                        addCount();
                }else{
                    let subTotalAmount=parseFloat((rate/workingdayinMonth)*dutyDay).toFixed(2);
                        $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
                        subtotalAmount();
                        addCount();
                }
            }else if(person <= 0) {
                let subTotalAmount=parseFloat(totalHour*ratePerHour).toFixed(2);
                    $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
                    subtotalAmount();
                    addCount();
            }else{
                let subTotalAmount=parseFloat(rate*person).toFixed(2);
                    $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
                    subtotalAmount();
                    addCount();
            }    
        }
</script>

@endpush
