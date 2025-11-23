@extends('layout.app')

@section('pageTitle',trans('Advance'))
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
                        <form method="post" action="{{route('advance.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select required class="form-select select2 customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="getAtm(this),addCount(this)">
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
                                    <label for=""><b>Taken Date</b></label>
                                    <input required class="form-control start_date" type="date" name="taken_date" value="" placeholder="Taken Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Amount</b></label>
                                    <input required class="form-control" type="text" name="amount">
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

        if (!$('.customer_id').val()) {
            $('.customer_id').focus();
            return false;
        }
        var customer=$('.customer_id').val();
        var branch_id=$('.branch_id').val();
        var atm_id=$('.atm_id').val();
       

        $('.show_click').removeClass('d-none');
        var vat=$('#branch_id').find(":selected").data('vat');
     }
    
        
</script>

@endpush
