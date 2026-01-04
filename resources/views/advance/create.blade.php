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
                                    <label for=""><b>Customer Name</b> <span class="text-danger">*</span></label>
                                    <select required class="form-select select2 customer_id @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" onchange="getBranch(this)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('customer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
                                    <label for=""><b>Taken Date</b> <span class="text-danger">*</span></label>
                                    <input required class="form-control start_date @error('taken_date') is-invalid @enderror" type="date" name="taken_date" value="{{ old('taken_date') }}" placeholder="Taken Date">
                                    @error('taken_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Amount</b> <span class="text-danger">*</span></label>
                                    <input required class="form-control @error('amount') is-invalid @enderror" type="text" name="amount" value="{{ old('amount') }}" placeholder="0.00">
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Payment Mode</b></label>
                                    <select name="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                        <option value="1" {{ old('payment_type', 1) == 1 ? 'selected' : '' }}>Cash</option>
                                        <option value="2" {{ old('payment_type') == 2 ? 'selected' : '' }}>Pay Order</option>
                                        <option value="3" {{ old('payment_type') == 3 ? 'selected' : '' }}>Fund Transfer</option>
                                        <option value="4" {{ old('payment_type') == 4 ? 'selected' : '' }}>Online Pay</option>
                                    </select>
                                    @error('payment_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Deposit Bank</b></label>
                                    <select class="form-control @error('deposit_bank') is-invalid @enderror" name="deposit_bank">
                                        <option value="">Select</option>
                                        @foreach($deposit_bank as $db)
                                            <option value="{{ $db->id }}" {{ old('deposit_bank') == $db->id ? 'selected' : '' }}>
                                                {{ $db->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('deposit_bank')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Bank Name</b></label>
                                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" placeholder="Bank Name">
                                    @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
    // When customer changes, reload branches
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
                alert('Error loading branches.');
            }
        });
    }

    // When branch changes, reload ATMs
    function getAtm(e) {
        var branchId = $(e).val();
        $('#atm_id').empty().append('<option value="">Loading...</option>');

        $.ajax({
            url: "{{ route('get_ajax_atm') }}",
            type: "GET",
            data: { branchId: branchId },
            success: function (data) {
                $('#atm_id').empty().append('<option value="">Select Atm</option>');
                $.each(data, function (key, value) {
                    $('#atm_id').append(`<option value="${value.id}">${value.atm}</option>`);
                });
            },
            error: function () {
                $('#atm_id').empty().append('<option value="">Select Atm</option>');
                alert('Error loading ATMs.');
            }
        });
    }

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
