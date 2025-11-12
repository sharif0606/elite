@extends('layout.app')

@section('pageTitle', trans('Midas Employee Assign'))
@section('pageSubTitle', trans('Edit'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{ route('employee_assign.update', encryptor('encrypt', $empasin->id)) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id"
                                        onchange="getBranch(this)">
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id"
                                        onchange="branch_change()">
                                        <option value="{{ $branch?->id }}">{{ $branch?->brance_name }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Editable Employee Assign Details -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>{{ __('Job Post') }}</th>
                                                <th style="width:50px">{{ __('Qty') }}</th>
                                                <th>{{ __('Home Salary') }}</th>
                                                <th>{{ __('Material') }}</th>
                                                <th>{{ __('Reliver') }}</th>
                                                <th>{{ __('OverHead & Service') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Rate (Person)') }}</th>
                                                <th>{{ __('Bonus Type') }}</th>
                                                <th>{{ __('Bonus Amount') }}</th>
                                                <th>{{ __('Start Date') }}</th>
                                                <th>{{ __('End Date') }}</th>
                                                <th scope="col">{{ __('Hours') }}</th>
                                                <th class="white-space-nowrap">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empassign">
                                            @foreach($empasin->details as $detail)
                                            <tr>
                                                <td>
                                                    <select class="form-select job_post_id select2" name="job_post_id[]" onchange="getRate(this)">
                                                        <option value="">Select Post</option>
                                                        @foreach ($jobpost as $job)
                                                            <option value="{{ $job->id }}" {{ $detail->job_post_id == $job->id ? 'selected' : '' }}>
                                                                {{ $job->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="qty[]" value="{{ $detail->qty }}" required></td>
                                                <td><input class="form-control" type="text" name="take_home_salary[]" value="{{ $detail->take_home_salary }}"></td>
                                                <td><input class="form-control" type="text" name="material_support_cost[]" value="{{ $detail->material_support_cost }}"></td>
                                                <td><input class="form-control" type="text" name="reliver_cost[]" value="{{ $detail->reliver_cost }}"></td>
                                                <td><input class="form-control" type="text" name="overhead_service_charge[]" value="{{ $detail->overhead_service_charge }}"></td>
                                                <td>
                                                    <select class="form-control" name="type[]">
                                                        <option value="">Select</option>
                                                        <option value="1" {{ $detail->type == 1 ? 'selected' : '' }}>Fixed</option>
                                                        <option value="2" {{ $detail->type == 2 ? 'selected' : '' }}>OT</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control rate" type="text" name="rate[]" value="{{ $detail->rate }}"></td>
                                                <td>
                                                    <select name="bonus_type[]" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" {{ $detail->bonus_type == 1 ? 'selected' : '' }}>Flat</option>
                                                        <option value="2" {{ $detail->bonus_type == 2 ? 'selected' : '' }}>Ratio</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="bonus_amount[]" value="{{ $detail->bonus_amount }}"></td>
                                                <td><input class="form-control" type="date" name="start_date[]" value="{{ $detail->start_date }}"></td>
                                                <td><input class="form-control" type="date" name="end_date[]" value="{{ $detail->end_date }}"></td>
                                                <td>
                                                    <select name="hours[]"
                                                        class="form-control @error('hours') is-invalid @enderror"
                                                        id="hours">
                                                        @forelse ($hours as $hour)
                                                            <option value="{{ $hour->id }}"
                                                                {{ $hour->id == $detail->hours ? 'selected' : '' }}>
                                                                {{ $hour->hour }} Hour's
                                                            </option>
                                                        @empty
                                                            <option value="">No hours available</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Update</button>
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
                            <td><input class="form-control" type="text" name="material_support_cost[]"
                                    value="0" placeholder="Material Support Cost" required></td>
                            <td><input class="form-control" type="text" name="reliver_cost[]"
                                    value="0" placeholder="Reliver_cost" required></td>
                            <td><input class="form-control" type="text" name="overhead_service_charge[]"
                                    value="0" placeholder="overhead_service_charge" required></td>
                            <td>
                                <select class="form-control" name="type[]" required>
                                    <option value="">Select</option>
                                    <option value="1">Fixed</option>
                                    <option value="2">OT</option>
                                </select>
                            </td>
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
                            {{--<td>
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
                            </td>--}}
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
    </script>
@endpush
