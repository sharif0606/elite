@extends('layout.app')

@section('pageTitle',trans('One Trip Invoice'))
@section('pageSubTitle',trans('Create'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('oneTripInvoice.store')}}" enctype="multipart/form-data">
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
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="EmployeeAsignGetAtm()">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>ATM Name</b></label>
                                    <select class="form-select atm_id" id="atm_id" name="atm_id">
                                        <option value="0">Select Atm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input required class="form-control add_commission" type="date" name="add_commission" value="" placeholder="Add: Commission">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control vat_on_commission" type="date" name="vat_on_commission" value="" placeholder="VAT on Commission">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input required class="form-control ait_on_commission" step="0.01" type="number" name="ait_on_commission" value="0" placeholder="AIT on Commission">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Service')}}</th>
                                                <th scope="col">{{__('Rate')}}</th>
                                                <th scope="col">{{__('Period')}}</th>
                                                <th scope="col">{{__('Trip')}}</th>
                                                <th scope="col">{{__('Amount')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empassign">
                                            <tr>
                                                <td>
                                                    <input class="form-control" type="text" name="service[]" value="" placeholder="Service">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="rate[]" value="" placeholder="Rate">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="date" name="period[]" value="" placeholder="Period">
                                                </td>
                                                <td><input class="form-control" type="text" name="trip[]" value="1" placeholder="Trip"></td>
                                                <td><input class="form-control" type="text" onkeyup="subtotalAmount();" name="amount[]" value="" placeholder="Amount"></td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <th colspan="4" style="text-align: end;">Sub Tatal</th>
                                                <td>
                                                    <input readonly type="text" class="form-control sub_total_salary" name="sub_total_salary" value="">
                                                </td>
                                                <td></td>
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
    function subtotalAmount(){
        var subTotal=0;
        $('.salary_amount').each(function(){
            subTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sub_total_salary').val(parseFloat(subTotal).toFixed(2));
    }
    function addRow(){
    var row=`
    <tr>
        <td>
            <input class="form-control" type="text" name="service[]" value="" placeholder="Service">
        </td>
        <td>
            <input class="form-control" type="text" name="rate[]" value="" placeholder="Rate">
        </td>
        <td>
            <input class="form-control" type="date" name="period[]" value="" placeholder="Period">
        </td>
        <td><input class="form-control" type="text" name="trip[]" value="1" placeholder="Trip"></td>
        <td><input class="form-control" type="text" onkeyup="subtotalAmount();" name="amount[]" value="" placeholder="Amount"></td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
            {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
        </td>
    </tr>
    `;
        $('#empassign').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
            subtotalAmount();
        }
    }

</script>
<script>
    function EmployeeAsignGetAtm() {
        let branchId=$('.branch_id').val();
        $.ajax({
            url: "{{ route('get_ajax_atm') }}",
            type: "GET",
            dataType: "json",
            data: { branchId: branchId },
            success: function (data) {
                //console.log(data)
                var d = $('.atm_id:last').empty();
                $('.atm_id').append('<option data-vat="0" value="0">Select ATM</option>');
                //$('#atm_id').append('<option value="1">All ATM</option>');
                $.each(data, function(key, value) {
                    $('.atm_id:last').append('<option value="' + value.id + '">' + value.atm + '</option>');
                });
            },
            error: function () {
                console.error("Error fetching data from the server.");
            },
        });
    }
</script>
{{--  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>  --}}
@endpush
