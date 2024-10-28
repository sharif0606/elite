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
                                    <select required class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this); getNote(this);">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="EmployeeAsignGetAtm(); getBillingRate(this);">
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
                                    <input required class="form-control start_date" type="date" name="start_date" value="" placeholder="">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input required class="form-control end_date" type="date" name="end_date" value="" placeholder="">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input required class="form-control vat" step="0.01" type="number" onkeyup="VatTk()" name="vat" value="0" placeholder="VAT">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input required class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
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
                                                    <input class="form-control" type="text" name="service[]" value="CIT Service" placeholder="Service">
                                                </td>
                                                <td>
                                                    <input class="form-control rate" onkeyup="totalCalc(this);" step="0.01" type="number" name="rate[]" value="" placeholder="Rate" readonly>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="date" name="period[]" value="" placeholder="Period">
                                                </td>
                                                <td><input class="form-control trip" onkeyup="totalCalc(this);" type="text" name="trip[]" value="" placeholder="Trip"></td>
                                                <td><input class="form-control amount" step="0.01" type="number" onkeyup="subtotalAmount(),VatTk();" name="amount[]" value="" placeholder="Amount"></td>
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
                                                    <input readonly type="text" class="form-control sub_total_amount" name="sub_total_amount" value="">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th colspan="4" style="text-align: end;">Vat@ <span class="vat_percent"></span> %</th>
                                                <td>
                                                    <input readonly type="text" class="form-control vat_taka" name="vat_taka" value="">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th colspan="4" style="text-align: end;">Grand Total=</th>
                                                <td>
                                                    <input readonly type="text" class="form-control grand_total" name="grand_total" value="">
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
    function getNote(e) {
        var oldCustomer = 0;
        let customerId = $(e).val();
        $('#headerNote').val('');
        $('#footerNote').val('');
        
        if(customerId != oldCustomer){
            $('.old_tr_remove').closest('tr').remove();
            $('.rate').closest('tr').find('.rate').val('');
            $('.rate').closest('tr').find('.trip').val('');
            $('.rate').closest('tr').find('.amount').val('');
            subtotalAmount();
            VatTk();
        }
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
                oldCustomer = data.id;
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function getBillingRate(e){
        var billRate=$('#branch_id').find(":selected").data('billingrate');
        $('.rate').val(billRate);
        totalCalc();
    }

    function totalCalc(e) {
        $('.rate').each(function() {
            var $row = $(this).closest('tr');
            
            var rate = $row.find('.rate').val() ? parseFloat($row.find('.rate').val()) : 0;
            var trip = $row.find('.trip').val() ? parseFloat($row.find('.trip').val()) : 0;
            var subtotal = rate * trip;
            $row.find('.amount').val(parseFloat(subtotal).toFixed(2));
        });
        subtotalAmount();
        VatTk();
    }
    function subtotalAmount(){
        var subTotal=0;
        $('.amount').each(function(){
            subTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sub_total_amount').val(parseFloat(subTotal).toFixed(2));
    }
    function VatTk(){
        let vat=$('.vat').val();
        var subtotal=$('.sub_total_amount').val();
        var vatTk=parseFloat((subtotal*vat)/100).toFixed(2);
        var grandTotal=parseFloat(subtotal) + parseFloat(vatTk);
        $('.vat_taka').val(vatTk);
        $('.grand_total').val(parseFloat(grandTotal).toFixed(2));
        $('.vat_percent').text(vat);
    }
    function addRow(){
    var billRate=$('#branch_id').find(":selected").data('billingrate');
    var row=`
    <tr>
        <td>
            <input class="form-control" type="text" name="service[]" value="CIT Service" placeholder="Service">
        </td>
        <td>
            <input class="form-control old_tr_remove rate" onkeyup="totalCalc(this);" step="0.01" type="number" name="rate[]" value="${billRate}" placeholder="Rate" readonly>
        </td>
        <td>
            <input class="form-control" type="date" name="period[]" value="" placeholder="Period">
        </td>
        <td><input class="form-control trip" onkeyup="totalCalc(this);" type="text" name="trip[]" value="" placeholder="Trip"></td>
        <td><input class="form-control amount" step="0.01" type="number" onkeyup="subtotalAmount(),VatTk();" name="amount[]" value="" placeholder="Amount"></td>
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
            totalCalc();
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
