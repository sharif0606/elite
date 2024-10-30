@extends('layout.app')

@section('pageTitle', trans('Portlink Assign'))
@section('pageSubTitle', trans('Create'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('portlinkAssaign.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-2 mt-4">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Customer Name</b></label>
                                        <select class="select2 form-select customer_id" id="customer_id" name="customer_id">
                                            <option value="">Select Customer</option>
                                            @forelse ($customer as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <!-- table bordered -->
                                <div class="row p-2 mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" width="25%">{{ __('Job Post') }}</th>
                                                    <th scope="col">{{ __('Qty') }}</th>
                                                    <th scope="col">{{ __('Rate (Person)') }}</th>
                                                    <th scope="col">{{ __('Commission (Person)') }}</th>
                                                    <th scope="col">{{ __('Start Date') }}</th>
                                                    <th scope="col">{{ __('End Date') }}</th>
                                                    <th scope="col">{{ __('Hours') }}</th>
                                                    <th class="white-space-nowrap">{{ __('ACTION') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="empassign">
                                                <tr>
                                                    <td>
                                                        <select class="select2 form-select job_post_id" id="job_post_id" name="job_post_id[]">
                                                            <option value="">Select Post</option>
                                                                @forelse ($jobpost as $job)
                                                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                                                @empty
                                                                @endforelse
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" type="text" name="qty[]" value="" placeholder="qty" required></td>
                                                    <td><input class="form-control rate" type="text" name="rate[]" value="" placeholder="rate" required></td>
                                                    <td><input class="form-control commission" type="text" name="commission[]" value="" placeholder="commission" required></td>
                                                    <td><input required class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date"></td>
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
                                                        {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                        <span onClick='addRow(),EmployeeAsignGetAtm();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
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
        let counter = 0;
        function addRow() {
            var row = `
                <tr class="new_rows">
                    <td>
                        <select class="form-select job_post_id" id="job_post_id${counter}" name="job_post_id[]" onchange="getRate(this)">
                            <option value="">Select Post</option>
                            @forelse ($jobpost as $job)
                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </td>
                    <td><input class="form-control" type="text" name="qty[]" value="" placeholder="qty"></td>
                    <td><input class="form-control rate" type="text" name="rate[]" value="" placeholder="rate"></td>
                    <td><input class="form-control commission" type="text" name="commission[]" value="" placeholder="commission" required></td>
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
                `;
            $('#empassign').append(row);
            $(`#job_post_id${counter}`).select2();
            counter++;
        }

        function removeRow(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
            }
        }
    </script>
@endpush
