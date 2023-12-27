@extends('layout.app')

@section('pageTitle',trans('Default Employee Assign'))
@section('pageSubTitle',trans('Create'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('wasaEmployeeAsign.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select required class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label>
                                    <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="branch_change()">
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
                                                <th scope="col">{{__('ATM')}}</th>
                                                <th scope="col">{{__('ID No')}}</th>
                                                <th scope="col">{{__('Rank')}}</th>
                                                <th scope="col">{{__('Area')}}</th>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Duty')}}</th>
                                                <th scope="col">{{__('Account No')}}</th>
                                                <th scope="col">{{__('Salary')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empassign">
                                            <tr>
                                                <td>
                                                    <select class="form-select atm_id" id="atm_id" name="atm_id[]">
                                                        <option value="0">Select Atm</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select employee_id select2" id="employee_id" name="employee_id[]" onchange="getEmployees(this)">
                                                        <option value="">Select</option>
                                                        @forelse ($employee as $em)
                                                        <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ $em->admission_id_no }}</option>
                                                        {{--  <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ ' ('.$em->admission_id_no.')'.$em->en_applicants_name }}</option>  --}}
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select job_post_id" id="job_post_id" name="job_post_id[]" onchange="getRate(this)">
                                                        <option value="">Select Post</option>
                                                        @forelse ($jobpost as $job)
                                                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="area[]" value="" placeholder="Area"></td>
                                                <td><input class="form-control employee_name" type="text" name="employee_name[]" value="" placeholder="Employee Name"></td>
                                                <td><input required class="form-control" type="text" name="duty[]" value="<?= date('t') ?>" placeholder="Duty"></td>
                                                <td><input class="form-control account_no" type="text" name="account_no[]" value="" placeholder="Account No"></td>
                                                <td><input class="form-control" type="text" name="salary_amount[]" value="" placeholder="Salary Amount"></td>
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
@push("scripts")
<script>
    function getEmployees(e){
       // if (!$('.customer_id').val()) {
        //    $('.customer_id').focus();
       //     return false;
       // }
        var employee_id=$(e).closest('tr').find('.employee_id').val();
        console.log(employee_id);
        var customerId = document.getElementById('customer_id').value;
        if(employee_id){
            $.ajax({
                url:"{{ route('wasaGetEmployee') }}",
                type: "GET",
                dataType: "json",
                data: { 'id':employee_id },
                success: function(data) {
                    console.log(data);
                    if(data.length>0){
                        var id = data[0].id;
                        var name = data[0].en_applicants_name;
                        var ac_no = data[0].bn_ac_no;
                        var contact = data[0].bn_parm_phone_my;
                        var positionid=data[0].bn_jobpost_id;
                        var positionName = data[0].position.name;
                        var positionId = data[0].position.id;
                        console.log(positionName);
                        $(e).closest('tr').find('.job_post_id').val(positionId).prop('selected', true);
                        $(e).closest('tr').find('.employee_name').val(name);
                        $(e).closest('tr').find('.account_no').val(ac_no);
                    }
                },
            });
        } else {
            $(e).closest('tr').find('.employee_name').val('');
            $(e).closest('tr').find('.job_post_id').val('');
            $(e).closest('tr').find('.account_no').val('');
        }
    }

    function addRow(){
    var row=`
    <tr class="new_rows">
        <td>
            <select class="form-select atm_id" id="atm_id" name="atm_id[]">
                <option value="0">Select Atm</option>
            </select>
        </td>
        <td>
            <select class="form-select employee_id select2" id="employee_id" name="employee_id[]" onchange="getEmployees(this)">
                <option value="">Select</option>
                @forelse ($employee as $em)
                <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ $em->admission_id_no }}</option>
                {{--  <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ ' ('.$em->admission_id_no.')'.$em->en_applicants_name }}</option>  --}}
                @empty
                @endforelse
            </select>
        </td>
        <td>
            <select class="form-select job_post_id" id="job_post_id" name="job_post_id[]" onchange="getRate(this)">
                <option value="">Select Post</option>
                @forelse ($jobpost as $job)
                <option value="{{ $job->id }}">{{ $job->name }}</option>
                @empty
                @endforelse
            </select>
        </td>
        <td><input class="form-control" type="text" name="area[]" value="" placeholder="Area"></td>
        <td><input class="form-control employee_name" type="text" name="employee_name[]" value="" placeholder="Employee Name"></td>
        <td><input required class="form-control" type="text" name="duty[]" value="<?= date('t') ?>" placeholder="Duty"></td>
        <td><input class="form-control account_no" type="text" name="account_no[]" value="" placeholder="Account No"></td>
        <td><input class="form-control" type="text" name="salary_amount[]" value="" placeholder="Salary Amount"></td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
            <span onClick='addRow(),EmployeeAsignGetAtm();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
        </td>
    </tr>
    `;
        $('#empassign').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }

</script>
<script>
    function branch_change(){
        $('.new_rows').remove();
        $('#empassign').find(':input').not(':button, :submit, :reset, :hidden, .not-hide').val('');
        EmployeeAsignGetAtm()
    }
    function EmployeeAsignGetAtm() {
        let branchId=$('.branch_id').val();
        $.ajax({
            url: "{{ route('get_ajax_atm') }}",
            type: "GET",
            dataType: "json",
            data: { branchId: branchId },
            success: function (data) {
                //console.log(data)
                var d = $('.atm_id:last').empty();
                $('.atm_id:last').append('<option data-vat="0" value="0">Select ATM</option>');
                //$('#atm_id').append('<option value="1">All ATM</option>');
                $.each(data, function(key, value) {
                    $('.atm_id:last').append('<option value="' + value.id + '">' + value.atm + '</option>');
                });
            },
            error: function () {
                console.error("Error fetching data from the server.");
            },
        });
    }
</script>
{{--  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>  --}}
@endpush
