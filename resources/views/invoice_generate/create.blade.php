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
            success: function(data) {
                console.log(data);

            },
        });
     }
</script>

@endpush
