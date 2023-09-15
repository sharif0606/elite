@extends('layout.app')

@section('pageTitle',trans('Employee Attendance'))
@section('pageSubTitle',trans('Create'))

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
                        <form method="post" action="{{route('empatten.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer</b></label>
                                    <select class="form-select" id="customer_id" name="customer_id[]">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control" type="date" name="start_date[]" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control" type="date" name="end_date[]" value="" placeholder="End Date">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Employee ID')}}</th>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Contact')}}</th>
                                                <th scope="col">{{__('Duty')}}</th>
                                                <th scope="col">{{__('OT')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="guardassing">
                                            <tr>
                                                <td>
                                                    <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" name="employee_id" value="" placeholder="Employee Id">
                                                </td>
                                                <td>
                                                    <input readonly class="form-control employee_name" type="text" name="employee_name[]" value="" placeholder="Name">
                                                    <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
                                                </td>
                                                <td><input readonly class="form-control employee_contact" type="text" name="employee_contact[]" value="" placeholder="Contact"></td>
                                                <td>
                                                    <input class="form-control" type="text" name="qty_duty[]" value="" placeholder="Duty">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="total_ot[]" value="" placeholder="OT">
                                                </td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
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

        var pa = '<div style="color:red">Invalid Employee ID</div>';
        $(e).closest('tr').find('.employee_data').html('');
        var message=$(e).closest('tr').find('.employee_data').append(pa);

        var employee_id=$(e).closest('tr').find('.employee_id').val();
        if(employee_id){
            $.ajax({
                url:"{{ route('empatt.getEmployee') }}",
                type: "GET",
                dataType: "json",
                data: { 'id':employee_id },
                success: function(data) {
                    if(data.length>0){
                        console.log(data);
                        var id = data[0].id;
                        var name = data[0].bn_applicants_name;
                        var contact = data[0].bn_parm_phone_my;

                        $(e).closest('tr').find('.employee_data').html('');
                        $(e).closest('tr').find('.employee_name').val(name);
                        $(e).closest('tr').find('.employee_contact').val(contact);
                    }
                },
            });
        } else {
            $(e).closest('tr').find('.employee_name').val('');
            $(e).closest('tr').find('.employee_contact').val('');
            $(e).closest('tr').find('.employee_data').html('');
        }
    }

</script>
<script>
    function addRow(){

var row=`
<tr>
    <td>
        <input class="form-control employee_id" type="text" onkeyup="getEmployees(this)" name="employee_id" value="" placeholder="Employee Id">
    </td>
    <td>
        <input readonly class="form-control employee_name" type="text" name="employee_name[]" value="" placeholder="Name">
        <div class="employee_data" id="employee_data" style="color:green;font-size:14px;"></div>
    </td>
    <td><input readonly class="form-control employee_contact" type="text" name="employee_contact[]" value="" placeholder="Contact"></td>
    <td>
        <input class="form-control" type="text" name="qty_duty[]" value="" placeholder="Duty">
    </td>
    <td>
        <input class="form-control" type="text" name="total_ot[]" value="" placeholder="OT">
    </td>
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
