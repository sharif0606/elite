@extends('layout.app')

@section('pageTitle',trans('Guard Assign Update'))
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
                        <form method="post" action="{{route('guard.update',[encryptor('encrypt',$guard->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}" {{ $guard->customer_id==$c->id?"selected":""}}>{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Job Post')}}</th>
                                                <th scope="col">{{__('Qty')}}</th>
                                                <th scope="col">{{__('Rate')}}</th>
                                                <th scope="col">{{__('Start Date')}}</th>
                                                <th scope="col">{{__('End Date')}}</th>
                                                <th scope="col">{{__('Hours')}}</th>
                                                <th scope="col">{{__('Employee Payment')}}</th>
                                                <th scope="col">{{__('Ot-Rate')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="guardassing">
                                            @if ($guard->details)
                                            @foreach ($guard->details as $d)
                                            <tr>
                                                <td>
                                                    <select class="form-select" id="job_post_id" name="job_post_id[]">
                                                        <option value="">Select Post</option>
                                                        @forelse ($jobpost as $job)
                                                        <option value="{{ $job->id }}" {{ $d->job_post_id==$job->id?"selected":""}}>{{ $job->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="qty[]" value="{{ $d->qty }}" placeholder="qty"></td>
                                                <td><input class="form-control" type="text" name="rate[]" value="{{ $d->rate }}" placeholder="rate"></td>
                                                <td><input class="form-control" type="date" name="start_date[]" value="{{ $d->start_date }}" placeholder="Start Date"></td>
                                                <td><input class="form-control" type="date" name="end_date[]" value="{{ $d->end_date }}" placeholder="End Date"></td>
                                                <td>
                                                    <select name="hours[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
                                                        <option value="1">8 Hour's</option>
                                                        <option value="2">12 Hour's</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="employee_payment[]" value="" placeholder="Employee Payment"></td>
                                                <td><input class="form-control" type="text" name="ot_rate[]" value="" placeholder="OT-Rate"></td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
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
        <select class="form-select" id="job_post_id" name="job_post_id[]">
            <option value="">Select Post</option>
            @forelse ($jobpost as $job)
            <option value="{{ $job->id }}">{{ $job->name }}</option>
            @empty
            @endforelse
        </select>
    </td>
    <td><input class="form-control" type="text" name="qty[]" value="" placeholder="qty"></td>
    <td><input class="form-control" type="text" name="rate[]" value="" placeholder="rate"></td>
    <td><input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date"></td>
    <td><input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date"></td>
    <td>
        <select name="hours[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
            <option value="1">8 Hour's</option>
            <option value="2">12 Hour's</option>
        </select>
    </td>
    <td><input class="form-control" type="text" name="employee_payment[]" value="" placeholder="Employee Payment"></td>
    <td><input class="form-control" type="text" name="ot_rate[]" value="" placeholder="OT-Rate"></td>
    <td>
        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
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
