@extends('layout.app')
@section('pageTitle','Advance List')
@section('pageSubTitle','All Advance')
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
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('From')}}</label>
                    <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('To')}}</label>
                    <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
                </div>
                <div class="col-lg-1 col-sm-6 d-flex justify-content-end align-items-center">
                    <a class="text-danger" href="{{route('advance.create', ['role' =>currentUser()])}}">
                        <i class="bi bi-plus-square-fill" style="font-size: 1.7rem;"></i>
                    </a>
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-sm btn-info mt-2">Search</button>
                    <a href="{{route('advance.index')}}" class="btn btn-sm btn-danger mt-2">Clear</a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                {{-- <a class="btn btn-sm btn-primary float-end my-2" href="{{route('invoiceGenerate.create')}}"><i class="bi bi-plus-square"></i> Add New</a> --}}
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col" style="width: 80px;">{{__('Month')}}</th>
                        <th scope="col">{{__('Customer Name')}}</th>
                        <th scope="col">{{__('Original Amount')}}</th>
                        <th scope="col" class="text-danger">{{__('Used')}}</th>
                        <th scope="col" class="text-success">{{__('Available')}}</th>
                        <th scope="col" style="width: 100px;">{{__('Advance Date')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $e)
                   
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}{{--$e->id--}}</td>
                        <td>{{ \Carbon\Carbon::parse($e->taken_date)->format('M-y') }}</td>
                        <td>
                            {{ $e->customer?->name }}(Branch-{{$e->branch?->brance_name}})(Atm-{{$e->atm?->atm}})
                        </td>
                        <td>{{ number_format($e->amount, 2) }}</td>
                        <td class="text-danger">
                            @if($e->used_amount > 0)
                                <strong>{{ number_format($e->used_amount, 2) }}</strong>
                            @else
                                0.00
                            @endif
                        </td>
                        <td class="text-success">
                            <strong>{{ number_format($e->remaining_amount ?? $e->amount, 2) }}</strong>
                        </td>
                        <td>{{ $e->taken_date }}</td>
                        <td>
                            @if($e->used_amount > 0)
                                <a href="{{ route('advance-usage.detail', [encryptor('encrypt', $e->id), 'role' => currentUser()]) }}" 
                                    title="View Usage History">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                            @endif
                            <a href="{{ route('advance.edit', $e->id) }}" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('advance.destroy', $e->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" 
                                    title="Delete" style="outline:none;border:none;background: #fff;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                  
                    @empty
                    <tr>
                        <th colspan="15" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-center">{{number_format($payments->sum('amount'),2)}}</th>
                        <th class="text-center">{{number_format($payments->sum('used_amount'),2)}}</th>
                        <th class="text-center">{{ number_format($payments->sum('amount') - $payments->sum('used_amount'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            <div class="pt-2">
                 {{$payments->withQueryString()->links()}} 
            </div>
            
        </div>
    </div>
</div>
<!-- Modal -->

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
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

function getBranch(e) {
    var customerId = $(e).val();
    $('#branch_id').empty().append('<option value="">Loading...</option>');

    $.ajax({
        url: "{{ route('get_ajax_branch') }}",
        type: "GET",
        data: { customerId: customerId },
        success: function (data) {
            $('#branch_id').empty().append('<option value="">Select Branch</option>');
            $.each(data, function (key, value) {
                $('#branch_id').append(`<option value="${value.id}">${value.brance_name}</option>`);
            });
        },
        error: function () {
            $('#branch_id').empty().append('<option value="">Select Branch</option>');
            console.error("Error fetching data from the server.");
        },
    });
}

function getBranchSearch(customerId, branchId = null) {
    $('#branch_id').empty();
    $.ajax({
        url: "{{ route('get_ajax_branch') }}",
        type: "GET",
        dataType: "json",
        data: { customerId: customerId },
        success: function (data) {
            $('#branch_id').append('<option value="0">Select Branch</option>');
            $.each(data, function (key, value) {
                $('#branch_id').append(
                    `<option value="${value.id}" ${branchId == value.id ? 'selected' : ''}>${value.brance_name}</option>`
                );
            });
        },
        error: function () {
            console.error("Error fetching data from the server.");
        },
    });
}
    function vatcalc(v,place){
        if(place=="vat_amount"){
            let rec= $('#received_amount').val() ? parseFloat($('#received_amount').val()) : 0;
            let vat= v ? parseFloat(v) : 0;
            let vamt=(rec*(vat/100));
            $('#'+place).val(vamt.toFixed(2))
        }else{
            let rec=$('#received_amount').val() ? parseFloat($('#received_amount').val()) : 0;
            let vamt=v ? parseFloat(v) : 0;
            let vat=(100*(vamt/rec));
            $('#'+place).val(vat.toFixed(2))
        }
    }
    $(document).ready(function () {
        $('#invList').on('show.bs.modal', function (event) {
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
