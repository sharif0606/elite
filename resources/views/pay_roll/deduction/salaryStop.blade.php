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
                                        <select required class="form-control form-select year" name="year">
                                            <option value="">Select Year</option>
                                            @for($i=2023;$i<= date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Salary Month</b></label>
                                        <select required class="form-control form-select month" name="month">
                                            <option value="">Select Month</option>
                                            @for($i=1;$i<= 12;$i++)
                                            <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2 d-none">
                                        <div class="form-group">
                                            <label for="role_id">Deduction</label>
                                            <select class="form-control form-select" name="deduction_type" id="deduction_type">
                                                <option value="20">Salary Stop</option>
                                            </select>
                                            @if($errors->has('deduction'))
                                                <span class="text-danger"> {{ $errors->first('deduction') }}</span>
                                            @endif
                                        </div>
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
                                                        <select class="form-control select2" name="employee_id[]" id="employee_id" onchange="getEmpDeduction(this)">
                                                            <option value="0">Select</option>
                                                            @foreach ($employees as $e)
                                                            <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control salary_off_msg" value="{{ old('salary_stop_message')}}" name="salary_stop_message[]">
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
    let counter = 0;
    function addRow(){
    var row=`
    <tr>
        <td>
            <select class="form-control" name="employee_id[]" id="employee_id${counter}" onchange="getEmpDeduction(this)">
                <option value="0">Select</option>
                @foreach ($employees as $e)
                <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control salary_off_msg" value="{{ old('salary_stop_message')}}" name="salary_stop_message[]">
        </td>
        <td>
            <span onClick='removeRow(this);' class="add-row text-danger"><i class="bi bi-trash-fill"></i></span>
        </td>
    </tr>
    `;
        $('#deductiorepet').append(row);
        $(`#employee_id${counter}`).select2();
        counter++;
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }
    function getEmpDeduction(e){
        let employee_id = $(e).val();
        let fine = $('#deduction_type').val();
        let year = $('.year').val();
        let month = $('.month').val();
        if(employee_id){
            $.ajax({
                url:"{{ route('deduction_asign.get_old_deduction') }}",
                type: "GET",
                dataType: "json",
                data: { 'employee_id':employee_id,'fine':fine,'year':year,'month':month },
                success: function(response) {

                    if (response.status === 1 && response.data && Object.keys(response.data).length > 0) {
                        var data = response.data;

                        var statusMapping = [
                            {},
                            { amount: data.fine, remarks: data.fine_rmk },
                            { amount: data.mobilebill, remarks: data.mobilebill_rmk },
                            { amount: data.loan, remarks: data.loan_rmk },
                            { amount: data.cloth, remarks: data.cloth_rmk },
                            { amount: data.jacket, remarks: data.jacket_rmk },
                            { amount: data.hr, remarks: data.hr_rmk },
                            { amount: data.c_f, remarks: data.c_f_rmk },
                            { amount: data.medical, remarks: data.medical_rmk },
                            { amount: data.matterss_pillowCost, remarks: data.matterss_pillowCost_rmk },
                            { amount: data.tonic_sim, remarks: data.tonic_sim_rmk },
                            { amount: data.over_paymentCut, remarks: data.over_paymentCut_rmk },
                            { amount: data.bank_charge_exc, remarks: data.bank_charge_exc_rmk },
                            { amount: data.dress, remarks: data.dress_rmk },
                            { amount: data.stmp, remarks: data.stmp_rmk },
                            { amount: data.excess_mobile, remarks: data.excess_mobile_rmk },
                            { amount: data.mess, remarks: data.mess_rmk },
                            { amount: data.absent, remarks: data.absent_rmk },
                            { amount: data.vacant, remarks: data.vacant_rmk },
                            { amount: data.adv, remarks: data.adv_rmk },
                            { remarks: data.salary_stop_message }
                        ];

                        var statusData = statusMapping[fine] || { amount: '', remarks: '' };

                        $(e).closest('tr').find('.salary_off_msg').val(statusData.remarks);
                    } else {
                        $(e).closest('tr').find('.salary_off_msg').val('');
                    }
                }

            });
        } else {
            $(e).closest('tr').find('.salary_off_msg').val('');
        }
    }
</script>
@endpush
