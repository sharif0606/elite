@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
@section('pageSubTitle',trans('Crate'))

@section('content')
<style>
    .input_css{
        border: none;
        outline: none;
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('islamiBankInvoice.store')}}" enctype="multipart/form-data">
                        {{--  <form method="post" action="{{route('WasaInviceStore',[encryptor('encrypt',$IBBLAssign?->id)])}}" enctype="multipart/form-data">  --}}
                            @csrf
                            @method('POST')
                            <input type="hidden" name="zone_id" id="zone_id" value="{{ $IBBLAssign->branch->zone_id ?? $IBBLAssign->customer->zone_id}}">
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for="">Customer Name</label> : <span class="form-control"> <strong>{{ $IBBLAssign->customer->name }}</strong> </span>
                                    <input readonly class="form-control customer_id" id="customer_id" type="hidden" name="customer_id" value="{{ $IBBLAssign->customer_id }}">
                                    <input class="" type="hidden" name="vat_on_subtotal" value="{{ $IBBLAssign->vat_on_subtotal }}">
                                </div>
                                 <div class="col-md-4 mt-2">
                                    <label for="">Branch Name</label> :
                                    <select class="form-select branch_id select2" id="branch_id" name="branch_id" onchange="getAtms()"> required
                                        <option value="">Select Branch</option>
                                        @foreach ($branch as $b)
                                            <option value="{{ $b->id }}">{{ $b->brance_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">ATM</label> :
                                    <select  class="select2 form-select atm_id" name="atm_id" required >
                                        <option value="">Select ATM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <button type="button" class="btn btn-primary mt-2 d-flex justify-content-center text-center" onclick="getEmployee()">Get Employee</button>
                                </div>
                            </div>
                            {{-- main form --}}
                            <div class="main-form d-none">

                            <div class="row">
                                <div class="row mt-4">
                                    <div class="offset-lg-4 col-lg-4 mt-2">
                                        <label for=""><b>Bill Date</b></label>
                                        <input required class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                    </div>
                                </div>
                                <div class="offset-lg-2 col-lg-3 mt-2">
                                    <label for=""><b>Star Date</b></label>
                                    <input class="form-control" type="date" name="start_date" value="{{ $IBBLAssign->start_date }}" required>
                                </div>
                                <div class="offset-lg-2 col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control" type="date" name="end_date" value="{{ $IBBLAssign->end_date }}">
                                </div>
                                <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Header Note</b></label>
                                    <textarea class="form-control" name="header_note" id="" cols="30" rows="3" placeholder="Please enter header Note">Reference to the above subject, we herewith submitted the security services bill.
                                    </textarea>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="" cols="30" rows="3" placeholder="Please enter Footer Note">The payment may please be made in Cheques/Drafts/Cash in favor of "Elite Security Services Limited" by 1st week of each month.
                                    </textarea>
                                </div>

                                </div>

                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('#SL')}}</th>
                                                <th scope="col">{{__('Employee ID No')}}</th>
                                                <th scope="col">{{__('Rank')}}</th>
                                                {{-- <th scope="col">{{__('Area')}}</th> --}}
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Mobile')}}</th>
                                                <th scope="col">{{__('Duty')}}</th>
                                                {{-- <th scope="col">{{__('Account No')}}</th> --}}
                                                <th scope="col">{{__('Salary')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="IBBLAssignassing">
                                            @if ($IBBLAssign->details)
                                            @php
                                                $total_salary = 0;
                                            @endphp
                                            @foreach ($IBBLAssign->details as $d)
                                            <tr>

                                                @php
                                                    $salary = 0;
                                                    $ot_salary = 0;

                                                    // get salary from employeeRateDetails
                                                    // $salaryData = DB::table('employee_rates')
                                                    // ->join('employee_rate_details','employee_rate_details.employee_rate_id','employee_rates.id')
                                                    // ->select('employee_rate_details.*','employee_rates.customer_id','employee_rates.branch_id','employee_rates.atm_id')
                                                    // ->where('employee_rates.customer_id', $IBBLAssign->customer_id)
                                                    // ->where('employee_rates.branch_id', $IBBLAssign->company_branch_id)
                                                    // ->where('employee_rate_details.employee_id', $d->employee_id)
                                                    // ->where('employee_rate_details.atm_id', $IBBLAssign->atm_id)
                                                    // ->first();

                                                    // echo $IBBLAssign->company_branch_id;
                                                    // echo "<br>";
                                                    // echo $d->employee_id;
                                                    // echo "<br>";
                                                    // print_r($salaryData);

                                                    $salaryData = DB::table('employee_assign_details')
                                                    ->join("employee_assigns","employee_assigns.id","employee_assign_details.employee_assign_id")
                                                    ->where("customer_id", 66)
                                                    ->first();
                                                    if($salaryData){
                                                        $salary = $salaryData->rate;
                                                        // $ot_salary = $salaryData->ot_rate;
                                                        $total_salary += $salary;
                                                    }
                                                    // else{
                                                    //     $salary = $de->duty_rate;
                                                    //     $ot_salary = $de->ot_rate;
                                                    // }

                                                @endphp

                                                <td scope="row">{{ ++$loop->index }}</td>
                                                <td>{{ $d->employee?->admission_id_no }}
                                                    <input class="" type="hidden" name="employee_id[]" value="{{ $d->employee_id}}">
                                                </td>
                                                <td>{{ $d->jobpost?->name }}
                                                    <input class="" type="hidden" name="job_post_id[]" value="{{ $d->job_post_id }}">
                                                </td>
                                                {{-- <td><input readonly class="form-control input_css" type="text" name="area[]" value="{{ $d->area }}" placeholder="Area"></td> --}}
                                                <td><input readonly class="form-control input_css employee_name" type="text" value="{{ $d->employee?->en_applicants_name }}" placeholder="Employee Name"></td>
                                                <td><input required class="form-control input_css" type="text" name="duty_rate[]" value="{{ $d->employee?->bn_parm_phone_my }}"></td>
                                                <td><input required class="form-control input_css" type="text" name="duty[]" value="{{ $d->duty }}" placeholder="Duty"></td>
                                                {{-- <td><input readonly class="form-control input_css account_no" type="text" name="account_no[]" value="{{ $d->account_no }}" placeholder="Account No"></td> --}}
                                                <td><input class="form-control input_css salary_amount" type="text" name="salary_amount[]" value="{{ $salary  }}" placeholder="Salary Amount"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">Sub Tatal</th>
                                                <td>
                                                    <input readonly type="text" class="form-control sub_total_salary" name="sub_total_salary" value="{{ $total_salary }}">
                                                </td>
                                            </tr>
                                            @php
                                            // vat

                                            // total;

                                            // $vat = $total_salary * ($IBBLAssign->vat_on_subtotal/100);
                                            // $grandTotal = $total_salary + $vat;

                                                $comissionTk=($total_salary)*($IBBLAssign->add_commission/100);
                                                $vatAit=(($IBBLAssign->vat_on_commission+$IBBLAssign->ait_on_commission)/100);
                                                $vatAitTakaCommision=($comissionTk*$vatAit);
                                                $VatTkCommission=$comissionTk*($IBBLAssign->vat_on_commission/100);
                                                $AitTkCommission=$comissionTk*($IBBLAssign->ait_on_commission/100);
                                                $vatOnSubtotal=($total_salary)*($IBBLAssign->vat_on_subtotal/100);
                                                $aitOnSubtotal=($total_salary)*($IBBLAssign->ait_on_subtotal/100);
                                                $grandTotal=($total_salary+$comissionTk+$vatAitTakaCommision+$vatOnSubtotal+$aitOnSubtotal);
                                            @endphp
                                            {{-- <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">Add: Commission {{ $IBBLAssign->add_commission }}%</th>
                                                <td>
                                                    <input readonly type="text" class="form-control add_commission_tk" name="add_commission_tk" value="{{ number_format($comissionTk, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="add_commission_percentage" value="{{ $IBBLAssign->add_commission }}">
                                                </td>
                                            </tr> --}}
                                            {{-- <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">(<span class="vat_percent">{{ $IBBLAssign->vat_on_commission }}</span> %) VAT + (<span class="vat_percent">{{ $IBBLAssign->ait_on_commission }}</span> %)AIT = {{ $IBBLAssign->vat_on_commission+$IBBLAssign->ait_on_commission }}% Commision</th>
                                                <td>
                                                    <input readonly type="text" class="form-control vat_ait_commission_tk" name="vat_ait_commission_tk" value="{{ number_format($vatAitTakaCommision, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="vat_ait_commission_percentage" value="{{ $IBBLAssign->vat_on_commission+$IBBLAssign->ait_on_commission}}">
                                                    <input class="" type="hidden" name="vat_commission_percentage" value="{{ $IBBLAssign->vat_on_commission }}">
                                                    <input class="" type="hidden" name="vat_commission_percentage_tk" value="{{ $VatTkCommission }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage" value="{{ $IBBLAssign->ait_on_commission }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage_tk" value="{{ $AitTkCommission }}">
                                                </td>
                                            </tr> --}}
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">(<span class="vat_percent">0</span> %) VAT on Sub Total</th>
                                                <td><input readonly type="text" class="form-control vat_tk_subtotal" name="vat_tk_subtotal" value="0"></td>
                                            </tr>
                                            {{-- <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">(<span class="vat_percent">{{ $IBBLAssign->ait_on_subtotal }}</span> %) AIT on Sub Total</th>
                                                <td>
                                                    <input readonly type="text" class="form-control ait_tk_subtotal" name="ait_tk_subtotal" value="{{ number_format($aitOnSubtotal, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="ait_on_subtotal" value="{{ $IBBLAssign->ait_on_subtotal }}">
                                                </td>
                                            </tr> --}}
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="5" style="text-align: end;">Total</th>
                                                <td><input readonly type="text" class="form-control grand_total_tk" name="grand_total_tk" value="0"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Save</button>
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
function getAtms(){
        let branchId = $('.branch_id').val();
        $.ajax({
            url: "{{ route('get_ajax_atm') }}",
            type: "GET",
            dataType: "json",
            data: { branchId: branchId },
            success: function(data){
                console.log('atm',data);
                $('.atm_id').empty();
                $('.atm_id').append('<option value="">Select ATM</option>');
                $.each(data, function(key, value){
                    $('.atm_id').append('<option value="' + value.id + '">' + value.atm + '</option>');
                });
            },
            error: function(){
                console.log('error');
            }
        });
    }

    function getEmployee(){
        let customerId = $('.customer_id').val();
        let branchId = $('.branch_id').val();
        let atmId = $('.atm_id').val();

        $.ajax({
            url: "{{ route('islamiBankGetEmployee') }}",
            type: "GET",
            dataType: "json",
            data: { customerId: customerId, branchId: branchId, atmId: atmId },
            success: function(data){
                if(data.status){

                    if(!data.details){
                        alert("No data Founds");
                        return;
                    }
                    $('.main-form').removeClass('d-none');
                    $('#IBBLAssignassing').empty();
                    if(data.details){
                        $.each(data.details, function(index, d){
                            $('#IBBLAssignassing').append(`
                                <tr>
                                    <td scope="row">${index + 1}</td>
                                    <td>
                                        ${d.employee.admission_id_no ?? ''}
                                        <input type="hidden" name="employee_id[]" value="${d.employee_id}">
                                    </td>
                                    <td>
                                        ${d.job_post.name ?? ''}
                                        <input type="hidden" name="job_post_id[]" value="${d.job_post.id}">
                                    </td>
                                    <td>
                                        <input readonly class="form-control input_css employee_name" type="text" value="${d.employee.en_applicants_name}" placeholder="Employee Name">
                                    </td>
                                    <td>
                                        <input required class="form-control input_css" type="text" name="duty_rate[]" value="${d.employee.bn_parm_phone_my}">
                                    </td>
                                    <td>
                                        <input required class="form-control input_css" type="text" name="duty[]" value="${d.duty}" placeholder="Duty">
                                        <input  class="form-control input_css" type="hidden" name="shift[]" value="${d.shift}" placeholder="Shift">
                                    </td>
                                    <td>
                                        <input class="form-control input_css salary_amount" type="text" name="salary_amount[]" value="${data.salary}" placeholder="Salary Amount">
                                    </td>
                                </tr>
                            `);
                        });
                        var salary = data?.data?.salary;
                        var sub_total_salary = data?.data?.salary;
                        alert(data?.data?.vat_on_subtotal);
                        $('.vat_percent').text(data?.data?.vat_on_subtotal);
                        $('.vat_tk_subtotal').val(data?.vat_on_subtotal );
                        $('.grand_total_tk').val(data?.grand_total);
                    }
                }
            }

        });
    }

    function onChangeSubTotalSalary(){
        var sub_total_salary = $('.sub_total_salary').val();
        var vat_on_subtotal = $('.vat_percent').val();
        var vat_on_subtotal_amount = (sub_total_salary * vat_on_subtotal) / 100;
        $('.vat_tk_subtotal').val(vat_on_subtotal_amount);
    }

    function onChangeVatOnSubtotal(){
        var vat_on_subtotal = $('.vat_percent').val();
        var vat_on_subtotal_amount = (sub_total_salary * vat_on_subtotal) / 100;
        $('.vat_tk_subtotal').val(vat_on_subtotal_amount);
    }
</script>
@endpush