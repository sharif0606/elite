@extends('layout.app')

@section('pageTitle', trans('Advance'))
@section('pageSubTitle', trans('Edit'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post"
                              action="{{ route('advance.update', $advance->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row p-2 mt-4">

                                {{-- Customer --}}
                                <div class="col-lg-4 mt-2">
                                    <label><b>Customer Name</b></label>
                                    <select required class="form-select select2 customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                                        <option value="">Select Customer</option>
                                        @foreach ($customer as $c)
                                            <option value="{{ $c->id }}" {{ $advance->customer_id == $c->id ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Branch --}}
                                <div class="col-lg-4 mt-2">
                                    <label><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="getAtm(this)">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $b)
                                            <option value="{{ $b->id }}" {{ $advance->branch_id == $b->id ? 'selected' : '' }}>
                                                {{ $b->brance_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ATM --}}
                                <div class="col-lg-4 mt-2">
                                    <label><b>ATM</b></label>
                                    <select class="form-select atm_id" id="atm_id" name="atm_id">
                                        <option value="">Select ATM</option>
                                        @foreach ($atms as $a)
                                            <option value="{{ $a->id }}" {{ $advance->atm_id == $a->id ? 'selected' : '' }}>
                                                {{ $a->atm }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 mt-2">
                                    <label><b>Taken Date</b></label>
                                    <input required class="form-control" type="date" name="taken_date" value="{{ $advance->taken_date }}">
                                </div>

                                <div class="col-lg-3 mt-2">
                                    <label><b>Amount</b></label>
                                    <input required class="form-control" type="text" name="amount" value="{{ $advance->amount }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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
                $('#atm_id').empty().append('<option value="">Select ATM</option>');
                $.each(data, function (key, value) {
                    $('#atm_id').append(`<option value="${value.id}">${value.atm}</option>`);
                });
            },
            error: function () {
                alert('Error loading ATMs.');
            }
        });
    }
</script>
@endpush
