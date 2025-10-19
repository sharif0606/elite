@extends('layout.app')
@section('pageTitle','Client Wise Invoice Payment List')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form method="get" action="">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Customer</label>
                    <select name="customer_id" id="customer_id" class="select2 form-select" onchange="getBranch(this);">
                        <option value="">Select Customer</option>
                        @forelse ($customer as $c)
                        <option value="{{$c->id}}" {{request()->customer_id==$c->id?'selected':''}}>{{$c->name}}</option>
                        @empty

                        @endforelse
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="lcNo">{{__('Branch')}}</label>
                    <div class="form-group">
                        <select class="select2 form-select branch_id" id="branch_id" name="branch_id">
                            <option value="">Select Branch</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="">Pay Mode</label>
                    <select name="payment_type" class="form-control form-select">
                        <option value="">Select</option>
                        <option value="1" {{request()->payment_type==1?'selected':''}}>Cash</option>
                        <option value="2" {{request()->payment_type==2?'selected':''}}>Pay Order</option>
                        <option value="3" {{request()->payment_type==3?'selected':''}}>Fund Transfer</option>
                        <option value="4" {{request()->payment_type==3?'selected':''}}>Online Pay</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="">PO No</label>
                    <input type="text" name="po_no" class="form-control" value="{{ request()->po_no }}">
                </div>
                {{--<div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">PO Date</label>
                    <input type="date" name="po_date" class="form-control" value="{{ request()->po_date }}">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <label for="">Pay Date</label>
                <input type="date" value="{{ request()->pay_date }}" name="pay_date" class="form-control">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <label for="">Receive Date</label>
                <input type="date" name="rcv_date" class="form-control" value="{{ request()->rcv_date }}">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <label for="">Deposit Date</label>
                <input type="date" name="deposit_date" class="form-control" value="{{ request()->deposit_date }}">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <label for="fdate">{{__('From Bill Date')}}</label>
                <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <label for="fdate">{{__('To Bill Date')}}</label>
                <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
            </div>--}}
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <div class="form-group">
                    <label for="">Received By</label>
                    <select class="form-control" name="received_by_city">
                        <option value="">Select</option>
                        <option value="1" @if(request()->get('received_by_city') == 1) selected @endif>Ctg</option>
                        <option value="2" @if(request()->get('received_by_city') == 2) selected @endif>Head Office</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <div class="form-group">
                    <label for="">Vat Deducted</label>
                    <select class="form-control" name="vat_deducted">
                        <option value="">Select</option>
                        <option value="1" @if(request()->get('vat_deducted') == 1) selected @endif>Yes</option>
                        <option value="2" @if(request()->get('vat_deducted') == 2) selected @endif>No</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <div class="form-group">
                    <label for="">AIT Deducted</label>
                    <select class="form-control" name="ait_deducted">
                        <option value="">Select</option>
                        <option value="1" @if(request()->get('ait_deducted') == 1) selected @endif>Yes</option>
                        <option value="2" @if(request()->get('ait_deducted') == 2) selected @endif>No</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="paid_status">
                        <option value="">Select</option>
                        <option value="1" @if(request()->get('paid_status') == 1) selected @endif>Paid</option>
                        <option value="2" @if(request()->get('paid_status') == 2) selected @endif>Unpaid</option>
                        <option value="3" @if(request()->get('paid_status') == 3) selected @endif>Due</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 py-3">
                <button type="submit" class="btn btn-sm btn-info mt-2">Search</button>
                <a href="{{route('invoice-payment.client_wise_detail_invoice_report')}}" class="btn btn-sm btn-danger mt-2">Clear</a>
            </div>
    </div>
    </form>
    <!-- table bordered -->
    <div class="table-responsive">
        @if ($payments && $payments->count() > 0)
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th scope="col">{{__('#SL')}}</th>
                    <th scope="col">{{__('Customer')}}</th>
                    <th scope="col">{{__('Months')}}</th>
                    <th scope="col">{{__('Billing amount')}}</th>
                    <th scope="col">{{__('Received amount')}}</th>
                    <th scope="col">{{__('Vat %')}}</th>
                    <th scope="col">{{__('Ait %')}}</th>
                    <th scope="col">{{__('Less Paid/Due')}}</th>
                    <th scope="col" style="width: 90px;">{{__('Pay Mode')}}</th>
                    <th scope="col" style="width: 100px;">{{__('Bank Name')}}</th>
                    <th scope="col">{{__('PO No')}}</th>
                    <th scope="col" style="width: 80px;">{{__('PO Date')}}</th>
                    <th scope="col" style="width: 100px;">{{__('Deposit Bank')}}</th>
                    <th scope="col" style="width: 80px;">{{__('Deposit Date')}}</th>
                    <th scope="col">{{__('Remarks')}}</th>
                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                </tr>
            </thead>
            <tbody>
                @php $pm=[1=>"Cash","Pay Order","Fund Transfer","Online Pay"]; @endphp
                @foreach($payments as $e)
                <tr class="text-center">
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>
                        {{ $e->customer?->name }}
                        @if($e->branch?->brance_name)
                        ({{ $e->branch?->brance_name }})
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($e->invoice?->end_date)->format('M-y') }}</td>
                    <td>{{ $e->received_amount + $e->vat_amount + $e->ait_amount + $e->fine_deduction + $e->paid_by_client + $e->less_paid_honor}}</td>
                    <td>{{ $e->received_amount }}</td>
                    <td>{{ $e->vat > 0 ? (int) $e->vat . '%' : '' }}</td>
                    <td>{{ $e->ait > 0 ? (int) $e->ait . '%' : '' }}</td>
                    <td>{{ $e->less_paid > 0 ? $e->less_paid : '' }}</td>
                    <td>{{ $pm[$e->payment_type] }}</td>
                    <td>{{ $e->bank_name }}</td>
                    <td>{{ $e->po_no }}</td>
                    <td>{{ $e->po_date }}</td>
                    <td>@if($e->deposit_bank==1) DBBL @else PBL @endif</td>
                    <td>{{ $e->deposit_date }}</td>
                    <td>{{ $e->remarks }}</td>
                    <td>
                        <a href="{{ route('invoice-payment.edit', [encryptor('encrypt', $e->id)]) }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pt-2">
            {{ $payments->withQueryString()->links() }}
        </div>
        @else
        <p class="text-center">Please select a customer to view payment details.</p>
        @endif
    </div>

</div>
</div>
<!-- Modal -->

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const customerId = getQueryParam('customer_id');
        const branchId = getQueryParam('branch_id');

        if (customerId) {
            //$('#customer_id').val(customerId).trigger('change');
            // Load branches and pre-select if branchId is present
            getBranchSearch(customerId, branchId);
        }
    });

    function getBranchSearch(customerId, branchId = null) {
        $('#branch_id').empty();
        $.ajax({
            url: "{{ route('get_ajax_branch') }}",
            type: "GET",
            dataType: "json",
            data: {
                customerId: customerId
            },
            success: function(data) {
                $('#branch_id').append('<option value="0">Select Branch</option>');
                $.each(data, function(key, value) {
                    $('#branch_id').append(
                        `<option value="${value.id}" ${branchId == value.id ? 'selected' : ''}>${value.brance_name}</option>`
                    );
                });
            },
            error: function() {
                console.error("Error fetching data from the server.");
            },
        });
    }

    function vatcalc(v, place) {
        if (place == "vat_amount") {
            let rec = $('#received_amount').val() ? parseFloat($('#received_amount').val()) : 0;
            let vat = v ? parseFloat(v) : 0;
            let vamt = (rec * (vat / 100));
            $('#' + place).val(vamt.toFixed(2))
        } else {
            let rec = $('#received_amount').val() ? parseFloat($('#received_amount').val()) : 0;
            let vamt = v ? parseFloat(v) : 0;
            let vat = (100 * (vamt / rec));
            $('#' + place).val(vat.toFixed(2))
        }
    }
    $(document).ready(function() {
        $('#invList').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var invId = button.data('inv-id');
            var cusName = button.data('customer-name');
            var cusID = button.data('customer-8775');
            var Amount = button.data('total-amount');
            // Set the values in the modal
            var modal = $(this);
            modal.find('#inv_id').val(invId);
            modal.find('#name').text(cusName);
            modal.find('#customer_id').text(cusID);
            modal.find('#totalAmount').text(Amount);
        });
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endpush