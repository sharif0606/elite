@extends('layout.app')

@section('pageTitle', trans('Portlink Assign Update'))
@section('pageSubTitle', trans('Edit'))

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
                            <form method="post"
                                action="{{ route('portlinkAssaign.update', [encryptor('encrypt', $empasin->id), 'role' => currentUser()]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row p-2 mt-4">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Customer Name</b></label>
                                        <select class="form-select customer_id" id="customer_id" name="customer_id">
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                                    <th scope="col">{{ __('Rate') }}</th>
                                                    <th scope="col">{{ __('Commission') }}</th>
                                                    <th scope="col">{{ __('Start Date') }}</th>
                                                    <th scope="col">{{ __('End Date') }}</th>
                                                    <th scope="col">{{ __('Hours') }}</th>
                                                    <th class="white-space-nowrap">{{ __('ACTION') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="empasinassing">
                                                @if ($empasin->details)
                                                    @foreach ($empasin->details as $d)
                                                        <tr>
                                                            <td>
                                                                <select class="select2 form-select job_post_id" id="job_post_id{{$d->id}}" name="job_post_id[]">
                                                                    <option value="">Select Post</option>
                                                                    @forelse ($jobpost as $job)
                                                                        <option value="{{ $job->id }}"
                                                                            {{ $d->job_post_id == $job->id ? 'selected' : '' }}>
                                                                            {{ $job->name }}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </td>
                                                            <td><input class="form-control" type="text" name="qty[]" value="{{ $d->qty }}" placeholder="qty" required></td>
                                                            <td><input class="form-control rate" type="text" name="rate[]" value="{{ $d->rate }}" placeholder="rate" required></td>
                                                            <td><input class="form-control commission" type="text" name="commission[]" value="{{ $d->commission }}" placeholder="commission" required></td>
                                                            <td><input required class="form-control" type="date" name="start_date[]" value="{{ $d->start_date }}" placeholder="Start Date"></td>
                                                            <td><input class="form-control" type="date" name="end_date[]" value="{{ $d->end_date }}" placeholder="End Date"></td>
                                                            <td>
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
                                                            <td>
                                                                <span onClick='RemoveRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                                <span onClick='addRow()' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-2">
                                    <button type="submit" class="btn btn-info">Update</button>
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
        let counter = 0;
        function addRow() {
            var row = `
                    <tr>
                        <td>
                            <select class="form-select job_post_id" id="job_post_id${counter}" name="job_post_id[]" onchange="getRate(this)">
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
                        <td><input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date" required></td>
                        <td><input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date"></td>
                        <td>
                            <select name="hours[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
                                @forelse ($hours as $hour)
                                    <option value="{{ $hour->id }}">{{ $hour->hour }} Hour's</option>
                                @empty
                                    <option value="">No hours available</option>
                                @endforelse
                            </select>
                        </td>
                        <td>
                            <span onClick='RemoveRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                            {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
                        </td>
                    </tr>
                    `;
            $('#empasinassing').append(row);
            $(`#job_post_id${counter}`).select2();
            counter++;
        }

        function RemoveRow(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('tr').remove();
            }
        }
    </script>
@endpush
