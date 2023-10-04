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
                                    <label for=""><b>Vat</b></label>
                                    <input class="form-control" type="text" name="vat" value="" placeholder="Vat">
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
                                            <th>Vat</th>
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
                                            <th colspan="7">Sub Tatal</th>
                                            <td>3,11,904/-</td>
                                        </tr>
                                        <tr id="repeater_less" style="text-align: center;">
                                            <td><span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span></td>
                                            <td colspan="7"><input class="form-control text-center" type="text" placeholder="Exaple: Less: 01 duty absent of Receptionist on 17-18/07/2023" name=""></td>
                                            <td><input class="form-control text-center" type="text" placeholder="amount" name=""></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td></td>
                                            <th colspan="7">Tatal</th>
                                            <td>3,08,482/-</td>
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
        $.ajax({
            url: "{{route('get_invoice_data')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id:customer,start_date:startDate,end_date:endDate },
            success: function(invoice_data) {
                console.log(invoice_data);
                let selectElement = $('.show_invoice_data');
                    selectElement.empty();
                $.each(invoice_data, function (index, value) {

                    selectElement.append(
                        `<tr style="text-align: center;">
                            <td>${value.id}</td>
                            <td>${value.name_bn}</td>
                            <td>${value.rate}</td>
                            <td>${value.qty}</td>
                            <td>${value.working_days}</td>
                            <td>${value.total_hours}</td>
                            <td>${value.rate_per_hour}</td>
                            <td>${value.vat}</td>
                            <td>${value.total_amount}</td>
                        </tr>`);
                });

            },
        });
     }
     function addRow(){

        var row=`
        <tr style="text-align: center;">
            <td><span onClick='RemoveRow(this);' class="add-row text-danger"><i class="bi bi-trash"></i></span></td>
            <td colspan="7"><input class="form-control text-center" type="text" placeholder="Less: 01 duty absent of Receptionist on 17-18/07/2023"></td>
            <td><input class="form-control text-center" type="text" placeholder="amount"></td>
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
