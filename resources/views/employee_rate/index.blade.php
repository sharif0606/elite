@extends('layout.app')
@section('pageTitle','Employee Salary List')
@section('pageSubTitle','All')
@section('content')
<style>
    th {
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
                <div class="col-lg-2 col-sm-6 ps-0 ">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-danger ms-2" href="{{route('employeeRate.index')}}" title="Clear">Clear</a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <!-- Empty div to push the link to the right side -->
                </div>
                <div class="col-lg-2 col-sm-6 d-flex justify-content-end align-items-center">
                    <a class="text-danger" href="{{route('employeeRate.create', ['role' =>currentUser()])}}">
                        <i class="bi bi-plus-square-fill" style="font-size: 1.7rem;"></i>
                    </a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emRate as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">
                            <span><b>{{$e->customer?->name}}</b></span><br>
                            <span>{{$e->customer_branch?->brance_name}}</span></td>
                        </td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job Post</th>
                                        <th>Houres</th>
                                        <th>Salary</th>
                                        <th>OT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{$de->jobpost?->name }}</td>
                                        {{-- <td>@if($de->hours==1) 8 Hour's @else 12 Hour's @endif</td> --}}
                                        <td>{{$de->hour?->hour}} Hour's</td>
                                        <td>{{ $de->duty_rate }}</td>
                                        <td>{{ $de->ot_rate }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('employeeRate.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('employeeRate.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger" href="javascript:void()" onclick="$('#form{{$e->id}}').submit()">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" onsubmit="return confirm('Are you sure?')" action="{{ route('employeeRate.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                 {{$emRate->withQueryString()->links()}} 
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