@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
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
                        <form method="post" action="{{route('invoiceGenerate.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
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
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input class="form-control vat" type="text" name="vat" value="" placeholder="Vat">
                                </div>
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getInvoiceData()" type="button" class="btn btn-primary">Generate Bill</button>
                                </div>
                            </div>
                            <div class="row mt-5 table-responsive-sm">
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
                                    {{--  <tr style="text-align: center;">
                                        <td>02</td>
                                        <td>Security Supervisor</td>
                                        <td>15,600/-</td>
                                        <td>03</td>
                                        <th>23</th>
                                        <td>552</td>
                                        <td>84.78/-</td>
                                        <td>84.78/-</td>
                                        <td>46,800/-</td>
                                    </tr>  --}}
                                    <tfoot>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6" style="text-align: end;">Sub Tatal</th>
                                            <td>
                                                <input readonly type="text" class="form-control sub_total_amount text-center" name="sub_total_amount" value="">
                                                <input class="lessP" type="hidden" name="less_total[]" value="">
                                            </td>
                                        </tr>
                                        <tr id="repeater_less" style="text-align: center;">
                                            <td><span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span></td>
                                            <td colspan="6"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name=""></td>
                                            <td><input class="form-control text-center less_count" type="text" onkeyup="lessCount(this)" placeholder="amount" name=""></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6">Tatal Tk</th>
                                            <td><input readonly type="text" class="form-control text-center total_tk" name="total_tk" value=""></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="6">Vat</th>
                                            <td>3,08,482</td>
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
        var customer=$('.customer_id').val();
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();
        var vat=$('.vat').val();
        let counter = 0;
        $.ajax({
            url: "{{route('get_invoice_data')}}",
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
                        if (value.start_date >= startDate && value.end_date == null) {
                            workingDays = new Date(endDate) - new Date(value.start_date);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                        } else if (value.start_date <= startDate && value.end_date == null) {
                            workingDays = new Date(endDate) - new Date(startDate);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                        } else if (value.start_date <= startDate && value.end_date <= endDate) {
                            workingDays = new Date(value.end_date) - new Date(value.start_date);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                        } else if (value.start_date >= startDate && value.end_date <= endDate) {
                            workingDays = new Date(value.end_date) - new Date(value.start_date);
                            workingDays = Math.ceil(workingDays / (1000 * 60 * 60 * 24));
                        } else {
                            workingDays = '';
                        }

                        if(value.hours=="1"){
                            totalHoures=(8*(value.qty)*workingDays);
                            ratePerHoures=parseFloat(value.rate/(8*30)).toFixed(2);
                        }else{
                            totalHoures=(12*(value.qty)*workingDays);
                            ratePerHoures=parseFloat(value.rate/(12*30)).toFixed(2);
                        }

                        selectElement.append(
                            `<tr style="text-align: center;">
                                <td>${counter + 1}</td>
                                <td>${value.name_bn}</td>
                                <td>${value.rate}</td>
                                <td>${value.qty}</td>
                                <td>${workingDays}</td>
                                <td>${totalHoures}</td>
                                <td>${ratePerHoures}</td>
                                <td>${parseFloat(totalHoures*ratePerHoures).toFixed(2)}
                                    <input class="total_amounts" type="hidden" name="total_amounts[]" value="${parseFloat(totalHoures*ratePerHoures).toFixed(2)}">
                                </td>
                            </tr>`
                        );
                        counter++;
                    });
                    subtotalAmount()

            },
        });
     }
     function subtotalAmount(){
        var subTotal=0;
        $('.total_amounts').each(function(){
            subTotal+=parseFloat($(this).val());
        });
        $('.sub_total_amount').val(subTotal);
    }
     function lessCount(e){
        var totalLess=0;
        $('.less_count').each(function(){
            totalLess+=parseFloat($(this).val());
            //alert(totalLess)
        });
        $('.lessP').val(totalLess);
        var subTotal=$('.sub_total_amount').val();
        var totalLes=$('.lessP').val();
        var totalTaka=subTotal-totalLes
        $('.total_tk').val(totalTaka);
    }
     function addRow(){

        var row=`
        <tr style="text-align: center;">
            <td><span onClick='RemoveRow(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="6"><input class="form-control text-center" type="text" placeholder="Less: 01 duty absent of Receptionist on 17-18/07/2023"></td>
            <td><input class="form-control text-center less_count"  onkeyup="lessCount(this)" type="text" placeholder="amount"></td>
        </tr>
        `;
            $('#repeater_less').after(row);
        }
        function RemoveRow(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
            }
        }
</script>

@endpush
