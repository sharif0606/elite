@extends('layout.app')

@section('pageTitle',trans('Salary Stop'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    @media (min-width: 1192px){
        .select2{
            width: 550px !important;
        }
    }
</style>
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route('deduction_asign.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Salary Year</b></label>
                                        <select required class="form-control year" name="year">
                                            <option value="">Select Year</option>
                                            @for($i=2023;$i<= date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Salary Month</b></label>
                                        <select required class="form-control month" name="month">
                                            <option value="">Select Month</option>
                                            @for($i=1;$i<= 12;$i++)
                                            <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" width=45%>{{__('Employee')}}</th>
                                                    <th scope="col" width=45%>{{__('Salary stop message')}}</th>
                                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="deductiorepet">
                                                <tr>
                                                    <td>
                                                        <select class="form-control select2" name="employee_id[]" id="employee_id">
                                                            <option value="0">Select</option>
                                                            @foreach ($employees as $e)
                                                            <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" value="{{ old('salary_stop_message')}}" name="salary_stop_message[]">
                                                    </td>
                                                    <td>
                                                        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                                    </div>
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
    function addRow(){
    var row=`
    <tr>
        <td>
            <select class="form-control" name="employee_id[]" id="employee_id">
                <option value="0">Select</option>
                @foreach ($employees as $e)
                <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control" value="{{ old('salary_stop_message')}}" name="salary_stop_message[]">
        </td>
        <td>
            <span onClick='removeRow(this);' class="add-row text-danger"><i class="bi bi-trash-fill"></i></span>
        </td>
    </tr>
    `;
        $('#deductiorepet').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }
</script>
@endpush
