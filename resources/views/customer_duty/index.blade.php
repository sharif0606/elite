@extends('layout.app')
@section('pageTitle','Empoyees Attendance List')
@section('pageSubTitle','All Attendance')
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
                <div class="col-lg-12 d-flex justify-content-end align-items-center">
                    <a class="text-danger" href="{{route('customerduty.create', ['role' =>currentUser()])}}">
                        <i class="bi bi-plus-square-fill" style="font-size: 1.7rem;"></i>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <select name="customer_id" class="select2 form-select" onchange="getBranch(this);">
                            <option value="">Select Customer</option>
                            @forelse ($customer as $d)
                                <option value="{{$d->id}}" {{ request('customer_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                            @empty
                                <option value="">No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="form-group">
                        <select name="branch_id" class="select2 form-select" id="branch_id">
                            <option value="">Select Branch</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control year" name="year">
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control month selected_month" name="month">
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3">
                    <select required class="form-control month selected_duty" name="duty_qty">
                        <option value="">Select Duty Qty</option>
                        <option value=">60">>60</option>
                        <option value="<20">>20</option>
                    </select>
                </div>
                <div class="col-lg-12 d-flex justify-content-end align-items-center">
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
                        <th class="th_color" scope="col">{{__('Customer')}}</th>
                        <th class="th_color" scope="col">{{__('Details')}}</th>
                        <th class="th_color">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customerduty as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row"><span><b>{{$e->customer?->name}}</b></span><br>
                            <span>{{ date('d-M-Y', strtotime($e->start_date)) }} <b>to</b> {{ date('d-M-Y', strtotime($e->end_date)) }}</span><br>
                            <span>{{$e->customer_branch?->brance_name}}</span></td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr style="background-color: rgb(166, 166, 207) !important;">
                                        <th style=" color: rgb(15, 15, 15) !important;">Employee ID</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Employee</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Job Post</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Rate</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Qty</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Amount</th>
                                        <th style=" color: #0f0f0f !important;">Ot Rate</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Ot Qty</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Ot Amount</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{$de->employee?->admission_id_no }}</td>
                                        <td>{{$de->employee?->bn_applicants_name }}</td>
                                        <td>{{$de->jobpost?->name }}</td>
                                        <td>{{ $de->duty_rate }}</td>
                                        <td>{{ $de->duty_qty }}</td>
                                        <td>{{ $de->duty_amount }}</td>
                                        <td>{{ $de->ot_rate }}</td>
                                        <td>{{ $de->ot_qty }}</td>
                                        <td>{{ $de->ot_amount }}</td>
                                        <td>{{ $de->total_amount }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            {{--  <a href="{{route('customerduty.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>  --}}
                            <a href="{{route('customerduty.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger" href="javascript:void()" onclick="$('#form{{$e->id}}').submit()">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" onsubmit="return confirm('Are you sure?')" action="{{ route('customerduty.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
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
                 {{$customerduty->withQueryString()->links()}} 
            </div>
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
