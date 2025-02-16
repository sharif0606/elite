@extends('layout.app')

@section('pageTitle',trans('Create Deduction'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    @media (min-width: 1192px) {
        .repeater.select2 {
            width: 250px !important;
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
                                <div class="col-lg-4 mt-2">
                                    <div class="form-group">
                                        <label for="role_id">Deduction</label>
                                        <select required class="form-control form-select" name="deduction_type" id="deduction_type">
                                            <option value="">Select</option>
                                            <option value="1" {{$did==1?'selected': ''}}>Fine</option>
                                            <option value="2" {{$did==2?'selected': ''}}>Mobile Bill</option>
                                            <option value="3" {{$did==3?'selected': ''}}>Loan</option>
                                            <option value="4" {{$did==4?'selected': ''}}>Cloth</option>
                                            <option value="5" {{$did==5?'selected': ''}}>Jacket</option>
                                            <option value="6" {{$did==6?'selected': ''}}>Hr</option>
                                            <option value="7" {{$did==7?'selected': ''}}>CF</option>
                                            <option value="8" {{$did==8?'selected': ''}}>Medical</option>
                                            <option value="9" {{$did==9?'selected': ''}}>Matterss Pillow Cost</option>
                                            <option value="10" {{$did==10?'selected': ''}}>Tonic Sim</option>
                                            <option value="11" {{$did==11?'selected': ''}}>Over Payment Cutt</option>
                                            <option value="12" {{$did==12?'selected': ''}}>Bank Charge/Exc</option>
                                            <option value="13" {{$did==13?'selected': ''}}>Dress</option>
                                            <option value="14" {{$did==14?'selected': ''}}>stmp</option>
                                            <option value="15" {{$did==15?'selected': ''}}>Excess Mobile</option>
                                            <option value="16" {{$did==16?'selected': ''}}>Mess</option>
                                            {{-- <option value="17" {{$did==17?'selected': ''}}>Absent</option>
                                            <option value="18" {{$did==18?'selected': ''}}>Vacant</option> --}}
                                            <option value="19" {{$did==19?'selected': ''}}>Adv.</option>
                                            <option value="21" {{$did==21?'selected': ''}}>Fuel Bill</option>
                                            <option value="22" {{$did==22?'selected': ''}}>Post Allowance</option>
                                            <option value="23" {{$did==23?'selected': ''}}>Allowance</option>
                                            <option value="24" {{$did==24?'selected': ''}}>Leave</option>
                                            <option value="25" {{$did==25?'selected': ''}}>Arrear</option>
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
                                                <th scope="col" width="20%">{{__('Employee')}}</th>
                                                <th scope="col" width="15%">{{__('Taka')}}</th>
                                                <th scope="col" width="60%">{{__('Remarks')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="deductiorepet">
                                            <tr>
                                                <td>
                                                    <select class="form-control repeater select2" name="employee_id[]" id="employee_id" onchange="getEmpDeduction(this)">
                                                        <option value="0">Select</option>
                                                        @foreach ($employees as $e)
                                                        <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control amount" value="{{ old('amount')}}" name="amount[]" onkeyup=" total_amount();"></td>
                                                <td><input type="text" class="form-control remarks" value="{{ old('remarks')}}" name="remarks[]"></td>
                                                <td>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="d-flex justify-content-end"><strong>Total</strong></td>
                                                <td>
                                                    <input type="text" class="form-control total" readonly>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2 d-flex justify-content-end">
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
    document.getElementById('deduction_type').addEventListener('change', function(e) {
        e.preventDefault();
        this.value = this.dataset.value;
    });
    document.getElementById('deduction_type').dataset.value = document.getElementById('deduction_type').value;
    let counter = 0;

    function addRow() {
        var row = `
    <tr>
        <td>
            <select class="form-control" name="employee_id[]" id="employee_id${counter}" onchange="getEmpDeduction(this)">
                <option value="0">Select</option>
                @foreach ($employees as $e)
                <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control amount" value="{{ old('amount')}}" name="amount[]" onkeyup="total_amount(this)"></td>
        <td><input type="text" class="form-control remarks" value="{{ old('remarks')}}" name="remarks[]"></td>
        <td>
            <span onClick='removeRow(this);' class="add-row text-danger"><i class="bi bi-trash-fill"></i></span>
        </td>
    </tr>
    `;
        $('#deductiorepet').append(row);
        $(`#employee_id${counter}`).select2();
        counter++;
        total_amount(e);
    }

    function total_amount() {
        let total = 0;
        $('.amount').each(function() {
            let value = parseFloat($(this).val()) || 0; // Ensure value is a number
            total += value;
        });
        console.log(total);
        $('.total').val(total);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
            total_amount();
        }
    }

    function getEmpDeduction(e) {
        let employee_id = $(e).val();
        let fine = $('#deduction_type').val();
        let year = $('.year').val();
        let month = $('.month').val();
        if (employee_id) {
            $.ajax({
                url: "{{ route('deduction_asign.get_old_deduction') }}",
                type: "GET",
                dataType: "json",
                data: {
                    'employee_id': employee_id,
                    'fine': fine,
                    'year': year,
                    'month': month
                },
                success: function(response) {

                    if (response.status === 1 && response.data && Object.keys(response.data).length > 0) {
                        var data = response.data;
                        console.log(data);

                        var statusMapping = [{},
                            {
                                amount: data.fine,
                                remarks: data.fine_rmk
                            },
                            {
                                amount: data.mobilebill,
                                remarks: data.mobilebill_rmk
                            },
                            {
                                amount: data.loan,
                                remarks: data.loan_rmk
                            },
                            {
                                amount: data.cloth,
                                remarks: data.cloth_rmk
                            },
                            {
                                amount: data.jacket,
                                remarks: data.jacket_rmk
                            },
                            {
                                amount: data.hr,
                                remarks: data.hr_rmk
                            },
                            {
                                amount: data.c_f,
                                remarks: data.c_f_rmk
                            },
                            {
                                amount: data.medical,
                                remarks: data.medical_rmk
                            },
                            {
                                amount: data.matterss_pillowCost,
                                remarks: data.matterss_pillowCost_rmk
                            },
                            {
                                amount: data.tonic_sim,
                                remarks: data.tonic_sim_rmk
                            },
                            {
                                amount: data.over_paymentCut,
                                remarks: data.over_paymentCut_rmk
                            },
                            {
                                amount: data.bank_charge_exc,
                                remarks: data.bank_charge_exc_rmk
                            },
                            {
                                amount: data.dress,
                                remarks: data.dress_rmk
                            },
                            {
                                amount: data.stmp,
                                remarks: data.stmp_rmk
                            },
                            {
                                amount: data.excess_mobile,
                                remarks: data.excess_mobile_rmk
                            },
                            {
                                amount: data.mess,
                                remarks: data.mess_rmk
                            },
                            {
                                amount: data.absent,
                                remarks: data.absent_rmk
                            },
                            {
                                amount: data.vacant,
                                remarks: data.vacant_rmk
                            },
                            {
                                amount: data.adv,
                                remarks: data.adv_rmk
                            },
                            {
                                amount: data.salary_stop_message
                            },
                            {
                                amount: data.fuel_bill,
                                remarks: data.fuel_bill_rmk
                            }
                        ];

                        var statusData = statusMapping[fine] || {
                            amount: '',
                            remarks: ''
                        };

                        $(e).closest('tr').find('.amount').val(statusData.amount);
                        $(e).closest('tr').find('.remarks').val(statusData.remarks);
                    } else {
                        $(e).closest('tr').find('.amount').val('');
                        $(e).closest('tr').find('.remarks').val('');
                    }
                }

            });
        } else {
            $(e).closest('tr').find('.amount').val('');
            $(e).closest('tr').find('.remarks').val('');
        }
    }
</script>
@endpush