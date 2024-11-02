@extends('layout.app')
@section('pageTitle','Salary Report Details')
@section('pageSubTitle','report')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="{{route('report.salary_report_details')}}">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Year</b></label>
                    <select required class="form-control form-select year" name="year" required>
                        <option value="">Select Year</option>
                        @for($i=2023;$i<= date('Y');$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Month</b></label>
                    <select required class="form-control form-select month selected_month" name="month" required>
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6 mt-2 d-none">
                    <label for=""><b>Customer Name</b></label>
                    <select class="choices form-select multiple-remove customer_id" multiple="multiple" name="customer_id[]" id="customerSelect">
                        <optgroup label="Select Customer">
                            @forelse ($customer as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @empty
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="form-group col-lg-6 mt-2 d-none">
                    <label for=""><b>Customer Branch</b></label>
                    <select class="select2 multiselect form-select customer_branch_id" name="branch_id[]" multiple="multiple" id="customerBranch">
                    </select>
                </div>
                <div class="form-group col-lg-6 mt-2 d-none">
                    <label for=""><b>Job Post</b></label>
                    <select class="choices form-select multiple-remove job_post_id" multiple="multiple" name="job_post_id[]">
                        <optgroup label="Select Customer">
                            @forelse ($jobposts as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @empty
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="billdate">{{__('Salary Format')}}</label>
                    <select name="type" class="form-control form-select" required>
                        <option value="">Select</option>
                        <option value="0">Office Staff</option>
                        <option value="1">Out Station</option>
                        <option value="2">In Station</option>
                        <option value="3">Peon</option>
                        <option value="4">Robi Tower</option>
                        <option value="5">Ever Care</option>
                        <option value="6">Linde BD</option>
                        <option value="7">Mas Intimats</option>
                        <option value="8">Mas Sumantra</option>
                        <option value="9">Portlink</option>
                        <option value="10">RSB</option>
                        <option value="11">Top Way</option>
                        <option value="12">RSGT</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-sm btn-success btn-block mt-4">{{__('Show')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push("scripts")
<script>
    $(document).ready(function() {
        $('#customerSelect').change(function() {
            var selectedCustomers = $(this).val();

            if (selectedCustomers.length > 0) {
                $.ajax({
                    url: "{{route('get_ajax_salary_branch')}}",
                    type: "GET",
                    dataType: "json",
                    data: { customer_ids:selectedCustomers },
                    success: function(data) {
                        console.log(data);
                        let optBranch = `<option value="">Select Branch</option>`;
                        if (data.length > 0) {
                            data.forEach(item => {
                                optBranch += `<option value="${item.id}">${item.brance_name}</option>`;
                            });
                        }
                        $('#customerBranch').html(optBranch).promise().done(function() {
                            $('.multiselect').select2();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            } else {
                console.log("No customers selected.");
            }
        });
    });
</script>
@endpush
