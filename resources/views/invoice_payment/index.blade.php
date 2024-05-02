@extends('layout.app')
@section('pageTitle','Invoice Payment List')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                {{-- <a class="btn btn-sm btn-primary float-end my-2" href="{{route('invoiceGenerate.create')}}"><i class="bi bi-plus-square"></i> Add New</a> --}}
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Inv')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Amount')}}</th>
                        <th scope="col">{{__('Vat')}}</th>
                        <th scope="col">{{__('Vat Amount')}}</th>
                        <th scope="col">{{__('Pay Mode')}}</th>
                        <th scope="col">{{__('Bank Name')}}</th>
                        <th scope="col">{{__('PO No')}}</th>
                        <th scope="col">{{__('PO Date')}}</th>
                        <th scope="col">{{__('Pay Date')}}</th>
                        <th scope="col">{{__('Deposit Date')}}</th>
                        <th scope="col">{{__('Remarks')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $pm=[1=>"Cash","Pay Order","Fund Transfer"]; @endphp
                    @forelse($payments as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{ $e->invoice_id }}</td>
                        <td>{{ $e->customer?->name }}</td>
                        <td>{{ $e->received_amount }}</td>
                        <td>{{ $e->vat }}</td>
                        <td>{{ $e->vat_amount }}</td>
                        <td>{{ $pm[$e->payment_type] }}</td>
                        <td>{{ $e->bank_name }}</td>
                        <td>{{ $e->po_no }}</td>
                        <td>{{ $e->po_date }}</td>
                        <td>{{ $e->pay_date }}</td>
                        <td>{{ $e->deposit_date }}</td>
                        <td>{{ $e->remarks }}</td>
                        <td>
                            <a href="{{route('invoiceGenerate.edit',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                 {{$payments->links()}} 
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
