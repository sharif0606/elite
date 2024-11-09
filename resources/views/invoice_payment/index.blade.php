@extends('layout.app')
@section('pageTitle','Invoice Payment List')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form method="get" action="">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Customer</label>
                    <select name="customer_id" class="select2 form-control">
                        <option value="">Select Customer</option>
                        @forelse ($customer as $c)
                            <option value="{{$c->id}}" {{request()->customer_id==$c->id?'selected':''}}>{{$c->name}}</option>
                        @empty
                            
                        @endforelse
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Pay Mode</label>
                    <select name="payment_type" class="form-control form-select">
                        <option value="">Select</option>
                        <option value="1" {{request()->payment_type==1?'selected':''}}>Cash</option>
                        <option value="2" {{request()->payment_type==2?'selected':''}}>Pay Order</option>
                        <option value="3" {{request()->payment_type==3?'selected':''}}>Fund Transfer</option>
                        <option value="4" {{request()->payment_type==3?'selected':''}}>Online Pay</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">PO No</label>
                    <input type="text" name="po_no" class="form-control" value="{{ request()->po_no }}">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">PO Date</label>
                    <input type="date" name="po_date" class="form-control" value="{{ request()->po_date }}">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Pay Date</label>
                    <input type="date" value="{{ request()->pay_date }}" name="pay_date" class="form-control">
                </div>
                {{-- <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Receive Date</label>
                    <input type="date" name="rcv_date" class="form-control" value="{{ request()->rcv_date }}">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Deposit Date</label>
                    <input type="date" name="deposit_date" class="form-control" value="{{ request()->deposit_date }}">
                </div> --}}
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('From Bill Date')}}</label>
                    <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('To Bill Date')}}</label>
                    <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-info">Search</button>
                    <a href="{{route('invoice-payment.index')}}" class="btn btn-danger">Clear</a>
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
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Amount')}}</th>
                        <th scope="col">{{__('Vat')}}</th>
                        <th scope="col">{{__('Less Paid')}}</th>
                        <th scope="col">{{__('Pay Mode')}}</th>
                        <th scope="col">{{__('Bank Name')}}</th>
                        <th scope="col">{{__('PO No')}}</th>
                        {{-- <th scope="col">{{__('PO Date')}}</th> --}}
                        <th scope="col">{{__('Pay Date')}}</th>
                        {{-- <th scope="col">{{__('Receive Date')}}</th>
                        <th scope="col">{{__('Deposit Date')}}</th> --}}
                        <th scope="col">{{__('Remarks')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $pm=[1=>"Cash","Pay Order","Fund Transfer","Online Pay"]; @endphp
                    @forelse($payments as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{ $e->customer?->name }}({{$e->invoice?->branch?->brance_name}}) <input type="hidden" value="{{ $e->invoice_id }}"></td>
                        <td>{{ $e->received_amount }}</td>
                        <td>
                            @if ($e->vat > 0)
                                {{(int) $e->vat }}%
                            @endif
                        </td>
                        <td>
                            @if ($e->less_paid > 0)
                                {{$e->less_paid }}
                            @endif
                        </td>
                        <td>{{ $pm[$e->payment_type] }}</td>
                        <td>{{ $e->bank_name }}</td>
                        <td>{{ $e->po_no }}</td>
                        {{-- <td>{{ $e->po_date }}</td> --}}
                        <td>{{ $e->pay_date }}</td>
                        {{-- <td>{{ $e->rcv_date }}</td>
                        <td>{{ $e->deposit_date }}</td> --}}
                        <td>{{ $e->remarks }}</td>
                        <td>
                            <a href="{{route('invoice-payment.edit',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="11" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
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
</script>
@endpush
