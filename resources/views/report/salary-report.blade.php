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
                        <option value="{{ $i }}" {{old('year')== $i? 'selected' : ''}}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for=""><b>Salary Month</b></label>
                    <select required class="form-control form-select month selected_month" name="month" required>
                        <option value="">Select Month</option>
                        @for($i=1;$i<= 12;$i++)
                        <option value="{{ $i }}" {{old('month')== $i? 'selected' : ''}}>{{ date('F',strtotime("2022-$i-01")) }}</option>
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
                            <option value="{{ $p->id }}" {{ old('job_post_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>

                            @empty
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="billdate">{{__('Salary Format')}}</label>
                    <select name="type" class="form-control form-select" required>
                        <option value="">Select</option>
                        <option value="0" {{old('type')== '0'? 'selected' : ''}}>Office Staff</option>
                        <option value="1" {{old('type')== '1'? 'selected' : ''}}>Out Station</option>
                        <option value="2" {{old('type')== '2'? 'selected' : ''}}>In Station</option>
                        <option value="3" {{old('type')== '3'? 'selected' : ''}}>Peon</option>
                        <option value="4" {{old('type')== '4'? 'selected' : ''}}>Robi Tower</option>
                        <option value="5" {{old('type')== '5'? 'selected' : ''}}>Ever Care</option>
                        <option value="6" {{old('type')== '6'? 'selected' : ''}}>Linde BD</option>
                        <option value="7" {{old('type')== '7'? 'selected' : ''}}>Mas Intimates</option>
                        <option value="8" {{old('type')== '8'? 'selected' : ''}}>Mas Sumantra</option>
                        <option value="9" {{old('type')== '9'? 'selected' : ''}}>Portlink Unit 1</option>
                        <option value="10" {{old('type')== '10'? 'selected' : ''}}>Portlink Unit 2</option>
                        <option value="11" {{old('type')== '11'? 'selected' : ''}}>RSB</option>
                        <option value="12" {{old('type')== '12'? 'selected' : ''}}>Top Way</option>
                        <option value="13" {{old('type')== '13'? 'selected' : ''}}>RSGT PCT</option>
                        <option value="14" {{old('type')== '14'? 'selected' : ''}}>RSGT SCY</option>
                        <option value="15" {{old('type')== '15'? 'selected' : ''}}>Office Staff Prime</option>
                        <option value="16" {{old('type')== '16'? 'selected' : ''}}>Office Staff Others</option>
                        <option value="17" {{old('type')== '17'? 'selected' : ''}}>Stop Salary List</option>
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
