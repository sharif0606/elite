@extends('layout.app')

@section('pageTitle', trans('MTBL Employee Assign'))
@section('pageSubTitle', trans('Create'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('employee_assign.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-2 mt-4">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Customer Name</b></label>
                                        <select class="form-select customer_id select2" id="customer_id" name="customer_id">
                                            <option value="">Select Customer</option>
                                            @forelse ($customer as $c)
                                                <option value="{{ $c->id }}" @if(request()->get('customer_id') == $c->id) selected @endif>{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Branch Name</b></label>
                                        <select class="form-select branch_id" id="branch_id" name="branch_id"
                                            onchange="branch_change()">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- table bordered -->
                                <div class="row p-2 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">{{ __('Job Post') }}</th>
                                                    <th scope="col" style="width:50px">{{ __('Qty') }}</th>
                                                    <th scope="col">{{ __('Take Home Salary') }}</th>
                                                    <th scope="col">{{ __('Agency Commission') }}</th>
                                                    <th scope="col">{{ __('Rate (Person)') }}</th>
                                                    <th scope="col">{{__('Bonus Type')}}</th>
                                                    <th scope="col">{{__('Bonus Amount')}}</th>
                                                    <th scope="col">{{ __('Start Date') }}</th>
                                                    <th scope="col">{{ __('End Date') }}</th>
                                                    <th scope="col">{{ __('Hours') }}</th>
                                                    <th class="white-space-nowrap">{{ __('ACTION') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="empassign">
                                                <tr>
                                                    <td>
                                                        <select class="form-select job_post_id select2" id="job_post_id"
                                                            name="job_post_id[]" onchange="getRate(this)" style="width:100px">
                                                            <option value="">Select Post</option>
                                                            @forelse ($jobpost as $job)
                                                                <option value="{{ $job->id }}">{{ $job->name }}
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" type="text" name="qty[]"
                                                    placeholder="qty" required style="width:50px"></td>
                                                    <td><input class="form-control" type="text" name="take_home_salary[]"
                                                            value="0" placeholder="Take Home Salary" required></td>
                                                    <td><input class="form-control" type="text" name="agency_com[]"
                                                            value="0" placeholder="Material Support Cost" required></td>
                                                    <td><input class="form-control rate" type="text" name="rate[]"
                                                            value="" placeholder="rate" required></td>
                                                    <td>
                                                        <select name="bonus_type[]" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="1">Flat</option>
                                                            <option value="2">Ratio</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="bonus_amount[]">
                                                    </td>
                                                    <td><input required class="form-control" type="date"
                                                            name="start_date[]" value="" placeholder="Start Date">
                                                    </td>
                                                    <td><input class="form-control" type="date" name="end_date[]"
                                                            value="" placeholder="End Date"></td>
                                                    <td>
                                                        <select name="hours[]"
                                                            class="form-control @error('hours') is-invalid @enderror"
                                                            id="hours">
                                                            @forelse ($hours as $hour)
                                                                <option value="{{ $hour->id }}">
                                                                    {{ $hour->hour }} Hour's
                                                                </option>
                                                            @empty
                                                                <option value="">No hours available</option>
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                        <span onClick='addRow(),EmployeeAsignGetAtm();'
                                                            class="add-row text-primary"><i
                                                                class="bi bi-plus-square-fill"></i></span>
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
@push('scripts')
    {{--  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>  --}}
    <script>
        function addRow() {
            var row = $(`
                        <tr class="new_rows">
                            <td>
                                <select class="form-select job_post_id" name="job_post_id[]" onchange="getRate(this)">
                                    <option value="">Select Post</option>
                                    @forelse ($jobpost as $job)
                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </td>
                            <td><input class="form-control" type="text" name="qty[]" value="" placeholder="qty"></td>
                            <td><input class="form-control" type="text" name="take_home_salary[]"
                                    value="0" placeholder="Take Home Salary" required></td>
                            <td><input class="form-control" type="text" name="agency_com[]"
                                    value="0" placeholder="Material Support Cost" required></td>
                            <td><input class="form-control rate" type="text" name="rate[]" value="" placeholder="rate"></td>
                            <td>
                                <select name="bonus_type[]" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Flat</option>
                                    <option value="2">Ratio</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="bonus_amount[]">
                            </td>
                            <td><input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date"></td>
                            <td><input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date"></td>
                            <td>
                                <select name="hours[]"
                                                                                class="form-control @error('hours') is-invalid @enderror"
                                                                                id="hours">
                                                                                @forelse ($hours as $hour)
                                                                                    <option value="{{ $hour->id }}">
                                                                                        {{ $hour->hour }} Hour's
                                                                                    </option>
                                                                                @empty
                                                                                    <option value="">No hours available</option>
                                                                                @endforelse
                                </select>
                            </td>
                            <td>
                                <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
                            </td>
                        </tr>
                    `);
            $('#empassign').append(row);
            // Reinitialize select2 only on the newly added job_post_id
            row.find('.job_post_id').select2();
        }
        $('.job_post_id').select2();
        function removeRow(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
            }
        }
    </script>
    <script>
        function branch_change() {
            $('.new_rows').remove();
            $('#empassign').find(':input').not(':button, :submit, :reset, :hidden, .not-hide').val('');
        }
        $(document).ready(function() {
            // Your code here
            let customerSelect = $('#customer_id');
            if (customerSelect.val()) {
                getBranch(customerSelect[0]); // Trigger your branch function
            }
        });


    </script>
@endpush
