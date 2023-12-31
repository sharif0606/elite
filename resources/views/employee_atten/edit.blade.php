@extends('layout.app')

@section('pageTitle',trans('Employee Assign Update'))
@section('pageSubTitle',trans('Edit'))

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
                        <form method="post" action="{{route('empasign.update',[encryptor('encrypt',$employee->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Date</b></label>
                                    <input class="form-control" type="date" name="date" value="" placeholder="Date">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Employee')}}</th>
                                                <th scope="col">{{__('Customer')}}</th>
                                                <th scope="col">{{__('Start Date')}}</th>
                                                <th scope="col">{{__('End Date')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="guardassing">
                                            <tr>
                                                <td>
                                                    <select class="form-select" id="employee_id" name="employee_id[]">
                                                        <option value="">Select Employee</option>
                                                        @forelse ($employee as $emp)
                                                        <option value="{{ $emp->id }}">{{ $emp->bn_applicants_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" id="customer_id" name="customer_id[]">
                                                        <option value="">Select Customer</option>
                                                        @forelse ($customer as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date"></td>
                                                <td><input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date"></td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    function addRow(){

var row=`
<tr>
    <td>
        <select class="form-select" id="employee_id" name="employee_id[]">
            <option value="">Select Employee</option>
            @forelse ($employee as $emp)
            <option value="{{ $emp->id }}">{{ $emp->bn_applicants_name }}</option>
            @empty
            @endforelse
        </select>
    </td>
    <td>
        <select class="form-select" id="customer_id" name="customer_id[]">
            <option value="">Select Customer</option>
            @forelse ($customer as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
            @empty
            @endforelse
        </select>
    </td>
    <td><input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date"></td>
    <td><input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date"></td>
    <td>
        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  
        {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span> --}}
    </td>
</tr>
`;
    $('#guardassing').append(row);
}

function RemoveRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>

@endpush
