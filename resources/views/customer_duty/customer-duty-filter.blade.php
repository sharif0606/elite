@extends('layout.app')
@section('pageTitle','Empoyees Duty Report >60 OR < 20')
@section('pageSubTitle','Empoyees Duty Report')
@section('content')
<style>
    .th_color {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row mb-2">
                <div class="col-lg-2">
                    <select required class="form-control year" name="year">
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}" @if(request()->get('year') == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control month selected_month" name="month">
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}" @if(request()->get('month') == $i) selected @endif>{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3">
                    <select required class="form-control month selected_duty" name="duty_qty">
                        <option value="">Select Duty Qty</option>
                        <option value="60" @if(request()->get('duty_qty') == 60) selected @endif>60</option>
                        <option value="20" @if(request()->get('duty_qty') == 20) selected @endif><20</option>
                    </select>
                </div>
                <div class="col-lg-3 d-flex justify-content-end align-items-center">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-danger ms-2" href="{{route('customerduty.index')}}" title="Clear">Clear</a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <!-- Empty div to push the link to the right side -->
                </div>
            </div>
        </form>
        
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="th_color" scope="col">{{__('#SL')}}</th>
                        <th class="th_color" scope="col">{{__('Employee Id')}}</th>
                        <th class="th_color" scope="col">{{__('Name')}}</th>
                        <th class="th_color" scope="col">{{__('Post')}}</th>
                        <th class="th_color" scope="col">{{__('Customer')}}</th>
                        <th class="th_color" scope="col">{{__('Duty Qty')}}</th>
                        <th class="th_color" scope="col">{{__('OT Qty')}}</th>
                        <th class="th_color" scope="col">{{__('Total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customerduty as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->admission_id_no}}</td>
                        <td>{{$e->bn_applicants_name}}</td>
                        <td>{{$e->jpname}}</td>
                        <td>{{$e->customer?->name}}</td>
                        <td>{{$e->duty_qty}}</td>
                        <td>{{$e->ot_qty}}</td>
                        <td>{{$e->total_duty_ot_qty}}</td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>
</div>
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
</script>    
@endpush
