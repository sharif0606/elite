@extends('layout.app')

@section('pageTitle',trans('Employee Salary Update'))
@section('pageSubTitle',trans('Edit'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p class="text-center text-danger">** Please Posting Employee Salary Post Wise and Employee Wise Seperately Dont Mix either it Will Not Work **</p>
                        <form method="post" action="{{route('employeeRate.update',[encryptor('encrypt',$emprate->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="form-select customer_id select2" id="customer_id" name="customer_id" onchange="showBranch(this.value)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}" {{ $emprate->customer_id==$c->id?"selected":""}}>{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="showAtm(this.value)">
                                        <option value="">Select Branch</option>
                                        @forelse ($branch as $b)
                                        <option class="branch_hide branch_hide{{$b->customer_id}}" value="{{ $b->id }}" {{ $b->id==$emprate->branch_id?"selected":"" }}>{{ $b->brance_name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Atm</b></label>
                                    <select class="form-select atm_id" id="atm_id" name="atm_id">
                                        <option value="">Select Atm</option>
                                        @forelse ($atm as $b)
                                        <option class="atm_hide atm_hide{{$b->branch_id}}" value="{{ $b->id }}" {{ $b->id==$emprate->atm_id?"selected":"" }}>{{ $b->atm }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
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
                                                <th scope="col">{{__('Employee ID')}}</th>
                                                <th scope="col">{{__('Job Post')}}</th>
                                                <th scope="col">{{__('Hours')}}</th>
                                                <th scope="col">{{__('Salary (Person)')}}</th>
                                                <th scope="col">{{__('OT(Person)')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="emprateassing">
                                            @if ($emprate->details)
                                            @foreach ($emprate->details as $d)
                                            <tr>
                                                <td>
                                                    @if($d->employee_id)
                                                    <select class="form-select employee_id select2" id="employee_id" name="employee_id[]">
                                                        <option value="">Select Employee</option>
                                                        @forelse ($employee as $em)
                                                        <option value="{{ $em->id }}" {{ $d->employee_id==$em->id?"selected":""}}>
                                                            {{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}
                                                        </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class="form-select" id="job_post_id" name="job_post_id[]">
                                                        <option value="">Select Post</option>
                                                        @forelse ($jobpost as $job)
                                                        <option value="{{ $job->id }}" {{ $d->job_post_id==$job->id?"selected":""}}>{{ $job->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    {{-- <select name="hours[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
                                                        <option value="1" {{ $d->hours=='1'?"selected":""}}>8 Hour's</option>
                                                    <option value="2" {{ $d->hours=='2'?"selected":""}}>12 Hour's</option>
                                                    </select> --}}
                                                    <select name="hours[]"
                                                        class="form-control @error('hours') is-invalid @enderror"
                                                        id="hours">
                                                        @forelse ($hours as $hour)
                                                        <option value="{{ $hour->id }}"
                                                            {{ $hour->id == $d->hours ? 'selected' : '' }}>
                                                            {{ $hour->hour }} Hour's
                                                        </option>
                                                        @empty
                                                        <option value="">No hours available</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="duty_rate[]" value="{{ $d->duty_rate }}" placeholder="Duty-rate" required></td>
                                                <td><input class="form-control" type="text" name="ot_rate[]" value="{{ $d->ot_rate }}" placeholder="Ot-rate" required></td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
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
    /* call on load page */
    $(document).ready(function() {
        $('.branch_hide').hide();
        $('.atm_hide').hide();
    })
    let old_customer_id = 0;

    function showBranch(value) {
        let customer = value;
        console.log(customer);
        $('.branch_hide').hide();
        $('.branch_hide' + customer).show();
        if (old_customer_id != customer) {
            $('#branch_id').prop('selectedIndex', 0);
            $('#atm_id').prop('selectedIndex', 0);
            old_customer_id = customer;
        }
    }
    let old_branch_id = 0;

    function showAtm(value) {
        let branch = value;
        $('.atm_hide').hide();
        $('.atm_hide' + branch).show();
        if (old_branch_id != branch) {
            $('#atm_id').prop('selectedIndex', 0);
            old_branch_id = branch;
        }
    }
</script>
<script>
    function addRow() {

        var row = `
<tr>
    <td>
        <select class="form-select employee_id select2" id="employee_id" name="employee_id[]">
            <option value="">Select Employee</option>
            @forelse ($employee as $em)
            <option value="{{ $em->id }}">
                {{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}
            </option>
            @empty
            @endforelse
        </select>
    </td>
    <td>
        <select class="form-select" id="job_post_id" name="job_post_id[]">
            <option value="">Select Post</option>
            @forelse ($jobpost as $job)
            <option value="{{ $job->id }}">{{ $job->name }}</option>
            @empty
            @endforelse
        </select>
    </td>
    <td>
        <select name="hours[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
            {{--<option value="1" {{ $d->hours=='1'?"selected":""}}>8 Hour's</option>
            <option value="2" {{ $d->hours=='2'?"selected":""}}>12 Hour's</option>--}}
            @forelse ($hours as $hour)
            <option value="{{ $hour->id }}">{{ $hour->hour }} Hour's</option>
            @empty
            <option value="">No hours available</option>
            @endforelse
        </select>
    </td>
    <td><input class="form-control" type="text" name="duty_rate[]" value="" placeholder="Duty-rate" required></td>
    <td><input class="form-control" type="text" name="ot_rate[]" value="" placeholder="Ot-rate" required></td>
    <td>
        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
    </td>
</tr>
`;
        $('#emprateassing').append(row);
        // Reinitialize Select2 for dynamically added elements
        $('.select2').select2();
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }
</script>

@endpush