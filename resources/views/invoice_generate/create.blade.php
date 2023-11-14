@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .input_css{
        border: none;
        outline: none;
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
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select required class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
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
                                    <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                </div>
                                {{--  <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input class="form-control vat" type="number" name="vat" value="" placeholder="Vat">
                                </div>  --}}
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="" cols="30" rows="5" placeholder="Please enter Footer Note"></textarea>
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
                                            <th>Working Days</th>
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
                                            <th colspan="6" style="text-align: end;">Sub Tatal</th>
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
                                            <td colspan="6"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name="less_description[]"></td>
                                            <td><input class="form-control text-center less_count" type="text" onkeyup="lessCount(this)" placeholder="amount" name="less_amount[]"></td>  --}}
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6">Tatal Tk</th>
                                            <td>
                                                <input readonly type="text" class="form-control text-center total_tk" name="total_tk" value="">
                                                <input class="temporaty_total" type="hidden" name="temporaty_total[]" value="">
                                            </td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6">Vat</th>
                                            <td><input readonly type="text" class="form-control text-center vat_taka" name="vat_taka" value=""></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6">Grand Total</th>
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
                //console.log(invoice_data);
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

                        if(value.hours=="1"){
                            totalHoures=(8*(value.qty)*(workingDays+1));
                            ratePerHoures=parseFloat(value.rate/(8*workingdayinmonth)).toFixed(2);
                            type_houre=8;
                        }else{
                            totalHoures=(12*(value.qty)*(workingDays+1));
                            ratePerHoures=parseFloat(value.rate/(12*workingdayinmonth)).toFixed(2);
                            type_houre=12;
                        }

                        selectElement.append(
                            `<tr style="text-align: center;">
                                <td>${counter + 1}</td>
                                <td>${value.name}
                                    <input class="" type="hidden" name="job_post_id[]" value="${value.job_post_id}">
                                </td>
                                <td>
                                    <input class="form-control input_css rate_c" onkeyup="reCalcultateInvoice(this)" type="text" name="rate[]" value="${value.rate}">
                                </td>
                                <td>
                                    <input class="form-control input_css employee_qty_c" onkeyup="reCalcultateInvoice(this)" type="text" name="employee_qty[]" value="${value.qty}">
                                </td>
                                <td>
                                    <input class="form-control input_css warking_day_c" onkeyup="reCalcultateInvoice(this)" type="text" name="warking_day[]" value="${workingDays+1}">
                                    <input class="" type="hidden" name="st_date[]" value="${st_date}">
                                    <input class="" type="hidden" name="ed_date[]" value="${ed_date}">
                                </td>
                                <td>
                                    <input readonly class="form-control input_css total_houres_c" type="text" name="total_houres[]" value="${totalHoures}">
                                    <input class="type_houre" type="hidden" name="" value="${type_houre}">
                                </td>
                                <td>
                                    <input readonly class="form-control input_css rate_per_houres_c" type="text" name="rate_per_houres[]" value="${ratePerHoures}">
                                </td>
                                <td>
                                    <input class="form-control input_css total_amounts" readonly type="text" name="total_amounts[]" value="${parseFloat(totalHoures*ratePerHoures).toFixed(2)}">
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
        var vat=$('#branch_id').find(":selected").data('vat');
        var totalAddTaka=parseFloat(addSubTotal) + parseFloat(totalAdds);
        $('.total_tk').val(totalAddTaka);
        $('.temporaty_total').val(totalAddTaka);
        var aVatTaka=parseFloat((totalAddTaka*vat)/100).toFixed(2);
        var aGrandTotal=parseFloat(totalAddTaka) + parseFloat(aVatTaka);
        $('.vat_taka').val(aVatTaka);
        $('.grand_total').val(parseFloat(aGrandTotal).toFixed(2));
    }
     {{--  function decressRowData(){
        var row=`
        <tr style="text-align: center;">
            <td><span onClick='removedecressRowData(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="6"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name="less_description[]"></td>
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
            <td colspan="6"><input class="form-control text-center" type="text" placeholder="Exaple: Add/Less: 01 duty Receptionist on 17-18/07/2023" name="add_description[]"></td>
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
            var workingDay=$(e).closest('tr').find('.warking_day_c').val();
            var totalHours=$(e).closest('tr').find('.total_houres_c').val();
            var ratePerHoures=$(e).closest('tr').find('.rate_per_houres_c').val();
            var typeHours=$(e).closest('tr').find('.type_houre').val(); //8 or 12
            var reTotalHoure=(workingDay*typeHours*person);
            //var reratePerHoures=((rate/workingDay)/typeHours);
            //var reRatePerHoures = parseFloat(reratePerHoures).toFixed(2);
            $(e).closest('tr').find('.total_houres_c').val(reTotalHoure);
            //$(e).closest('tr').find('.rate_per_houres_c').val(reRatePerHoures);

            var startDate=$('.start_date').val();
            let workingdayinMonth= new Date(startDate);
            let smonth=workingdayinMonth.getMonth()+1;
            let syear=workingdayinMonth.getFullYear();
                workingdayinMonth= new Date(syear, smonth, 0).getDate();
                ratePerHoure=parseFloat(rate/(typeHours*workingdayinMonth)).toFixed(2);
                $(e).closest('tr').find('.rate_per_houres_c').val(ratePerHoure);
            let subTotalAmount=parseFloat((rate/workingdayinMonth)*(person*workingDay)).toFixed(2);
                $(e).closest('tr').find('.total_amounts').val(subTotalAmount);
                subtotalAmount();
                addCount();
        }
</script>

@endpush
