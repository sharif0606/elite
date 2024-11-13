@extends('layout.app')

@section('pageTitle', trans('South Bangla Assign'))
@section('pageSubTitle', trans('Create'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('southBanglaAssaign.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-2 mt-4">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Customer Name</b></label>
                                        <select class="select2 form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this);">
                                            <option value="">Select Customer</option>
                                            @forelse ($customer as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Branch Name</b></label>
                                        <select class="form-select branch_id" id="branch_id" name="branch_id">
                                            <option value="">Select Branch</option>
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
                                                    <th scope="col">{{ __('Duty Rate') }}</th>
                                                    <th scope="col">{{ __('Service Rate') }}</th>
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
                                                    <td><input class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="rate" required></td>
                                                    <td><input class="form-control service_rate" type="text" name="service_rate[]" value="" placeholder="service" required></td>
                                                    <td>
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
                    <td><input class="form-control duty_rate" type="text" name="duty_rate[]" value="" placeholder="rate"></td>
                    <td><input class="form-control service_rate" type="text" name="service_rate[]" value="" placeholder="service" required></td>
                    <td>
                        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
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
