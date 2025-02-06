@extends('layout.app')

@section('pageTitle',trans('Salary Sheet One'))
@section('pageSubTitle',trans('Update'))

@section('content')
<style>
    .myDIV {
      writing-mode: vertical-lr;
      text-orientation: mixed;
    }
    .selected-row {
        background-color: rgb(189, 245, 189);
    }
    .table {
        width: 100%;
        overflow-x: auto; /* Ensures the table can be scrolled horizontally */
    }

    .table thead th.fixed,
    .table tbody td.fixed {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }

    .table thead th.fixed-2,
    .table tbody td.fixed-2 {
        position: sticky;
        left: 28px; /* Ensure this matches the total width of the preceding column(s) */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }

    .table thead th.fixed-3,
    .table tbody td.fixed-3 {
        position: sticky;
        left: 71px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table thead th.fixed-4,
    .table tbody td.fixed-4 {
        position: sticky;
        left: 176px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table thead th.fixed-5,
    .table tbody td.fixed-5 {
        position: sticky;
        left: 333px; /* Cumulative width of previous columns */
        z-index: 2;
        background-color: white;
        border-left: 1px solid #ddd;
    }
    .table tbody tr.selected-row td.fixed,
    .table tbody tr.selected-row td.fixed-2,
    .table tbody tr.selected-row td.fixed-3,
    .table tbody tr.selected-row td.fixed-4,
    .table tbody tr.selected-row td.fixed-5 {
        background-color: rgb(189, 245, 189); /* Match selected-row background color */
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('salarysheet.salarySheetOneUpdate',[encryptor('encrypt',$salary->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row p-2 mt-4">
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Name</b></label>
                                    <select class="choices form-select multiple-remove customer_id" multiple="multiple" name="customer_id[]" id="customerSelect">
                                        <optgroup label="Select Customer">
                                            @forelse ($customer as $c)
                                            <option value="{{ $c->id }}" {{ in_array($c->id, $selectedCustomerIds) ? 'selected' : '' }}>{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Name Not</b></label>
                                    <select class="choices form-select multiple-remove customer_id_not" multiple="multiple" name="customer_id_not[]">
                                        <optgroup label="Select Customer">
                                            @forelse ($customer as $c)
                                            <option value="{{ $c->id }}" {{ in_array($c->id, $selectedCustomerIdsNot) ? 'selected' : '' }}>{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for=""><b>Customer Branch</b></label>
                                    <select class="select2 multiselect form-select customer_branch_id" name="branch_id[]" multiple="multiple" id="customerBranch">
                                        @foreach ($branch as $brn)
                                            <option value="{{ $brn->id }}" {{ in_array($brn->id, $branchIds) ? 'selected' : '' }}>{{ $brn->brance_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Salary Year</b></label>
                                    <select required class="form-control year" name="year">
                                        <option value="">Select Year</option>
                                        @for($i=2023;$i<= date('Y');$i++)
                                        <option value="{{ $i }}" {{$salary->year== $i? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Salary Month</b></label>
                                    <select required class="form-control month selected_month" name="month">
                                        <option value="">Select Month</option>
                                        @for($i=1;$i<= 12;$i++)
                                        <option value="{{ $i }}" {{$salary->month== $i ? 'selected' : '' }}>{{ date('F',strtotime("2022-$i-01")) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-lg-3 mt-4 p-0 d-none">
                                    <button onclick="getSalaryData()" type="button" class="btn btn-primary">Generate Salary</button>
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr class="text-center" id="">
                                                <th scope="col" rowspan="2" class="fixed">{{__('S/N')}}</th>
                                                <th scope="col" rowspan="2">{{__('Online Payment')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-2">{{__('ID No')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-3">{{__('Date of Joining')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-4">{{__('Designation')}}</th>
                                                <th scope="col" rowspan="2" class="fixed-5">{{__('Name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Name_of_bank')}}</th>
                                                <th scope="col" rowspan="2">{{__('branch_name')}}</th>
                                                <th scope="col" rowspan="2">{{__('Monthly Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('Days')}}</th>
                                                <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT/Hrs')}}</th>
                                                <th scope="col" rowspan="2">{{__('OT Rate')}}</th>
                                                <th scope="col" rowspan="2">{{__('Tk')}}</th>
                                                <th scope="col" rowspan="2">{{__('Fixed OT')}}</th>
                                                <th scope="col" rowspan="2">{{__('Allownce')}}</th>
                                                <th scope="col" rowspan="2">{{__('Leave')}}</th>
                                                <th scope="col" rowspan="2">{{__('Arrear')}}</th>
                                                <th scope="col" rowspan="2">{{__('Gross Salary')}}</th>
                                                <th scope="col" colspan="14">{{__('DEDUCTION')}}</th>
                                                <th scope="col" rowspan="2">{{__('Net Salary')}}</th>
                                                <th scope="col" rowspan="2">{{__('SIGN OF IND.')}}</th>
                                                <th scope="col" rowspan="2">{{__('Remark')}}</th>
                                                {{--  <th class="white-space-nowrap" rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>Fine</th>
                                                <th>Mobile bill</th>
                                                <th>Loan</th>
                                                <th>Long Loan</th>
                                                <th>Cloth</th>
                                                <th>Jacket</th>
                                                <th>HR</th>
                                                <th>Training Cost</th>
                                                <th>C/F</th>
                                                <th>Medical</th>
                                                <th>Ins</th>
                                                <th>P/F</th>
                                                <th>Revenue Stamp</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="salarySheet">
                                            @php
                                                $old_emp = '';
                                            @endphp
                                            @foreach ($salaryDetail as $d)
                                            @php
                                                if($old_emp == $d->employee?->admission_id_no){
                                                    $fineCon='<input style="width:100px;" class="form-control" type="text" name="deduction_fine[]" value="0">';
                                                    $mobileCon='<input style="width:100px;" class="form-control" type="text" name="deduction_mobilebill[]" value="0" >';
                                                    $loonCon='<input style="width:100px;" class="form-control" type="text" name="deduction_loan[]" value="0">';
                                                    $longLoonCon='<input style="width:100px;" class="form-control" type="text" name="deduction_long_loan[]" value="0">';
                                                    $clothCon='<input style="width:100px;" class="form-control" type="text" name="deduction_cloth[]" value="0" >';
                                                    $jacketCon='<input style="width:100px;" class="form-control" type="text" name="deduction_jacket[]" value="0" >';
                                                    $hrCon='<input style="width:100px;" class="form-control" type="text" name="deduction_hr[]" value="0" >';
                                                    $trainingCon='<input style="width:100px;" class="form-control" type="text" name="deduction_traningcost[]" value="0">';
                                                    $cfCon='<input style="width:100px;" class="form-control" type="text" name="deduction_c_f[]" value="0">';
                                                    $medicalCon='<input style="width:100px;" class="form-control" type="text" name="deduction_medical[]" value="0">';
                                                    $insCon='<input style="width:100px;" class="form-control" type="text" name="deduction_ins[]" value="0">';
                                                    $pfCon='<input style="width:100px;" class="form-control" type="text" name="deduction_p_f[]" value="0">';
                                                    $stmCon='<input style="width:100px;" class="form-control" type="text" name="deduction_revenue_stamp[]" value="0">';
                                                    $deTotalCon='<input style="width:100px;" class="form-control" type="text" name="deduction_total[]" value="0">';
                                                    $netSalaryCon='<input style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="'.$d->net_salary.'">';
                                                    $pAllowanCon='<input style="width:100px;" class="form-control" type="text" name="allownce[]" value="0">';
                                                } else {
                                                    $fineCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="'.$d->deduction_fine.'" placeholder="Fine">';
                                                    $mobileCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_mobilebill" type="text" name="deduction_mobilebill[]" value="'.$d->deduction_mobilebill.'" placeholder="Mobile bill">';
                                                    $loonCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="'.$d->deduction_loan.'" placeholder="Loan">';
                                                    $longLoonCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_long_loan" type="text" name="deduction_long_loan[]" value="'.$d->deduction_long_loan.'" placeholder="Long Loan">';
                                                    $clothCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_cloth" type="text" name="deduction_cloth[]" value="'.$d->deduction_cloth.'" placeholder="Cloth">';
                                                    $jacketCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_jacket" type="text" name="deduction_jacket[]" value="'.$d->deduction_jacket.'" placeholder="Jacket">';
                                                    $hrCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_hr" type="text" name="deduction_hr[]" value="'.$d->deduction_hr.'" placeholder="HR">';
                                                    $trainingCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_traningcost" type="text" name="deduction_traningcost[]" value="'.$d->deduction_traningcost.'" placeholder="Training Cost">';
                                                    $cfCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_c_f" type="text" name="deduction_c_f[]" value="'.$d->deduction_c_f.'" placeholder="C/F">';
                                                    $medicalCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_medical" type="text" name="deduction_medical[]" value="'.$d->deduction_medical.'" placeholder="Medical">';
                                                    $insCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="'.$d->deduction_ins.'" placeholder="Ins">';
                                                    $pfCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="'.$d->deduction_p_f.'" placeholder="P/F">';
                                                    $stmCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_revenue_stamp" type="text" name="deduction_revenue_stamp[]" value="'.$d->deduction_revenue_stamp.'" placeholder="Revenue Stamp">';
                                                    $deTotalCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="'.$d->deduction_total.'" placeholder="Total">';
                                                    $netSalaryCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="'.$d->net_salary.'" placeholder="Net Salary">';
                                                    $pAllowanCon='<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control allownce" type="text" name="allownce[]" value="'.$d->allownce.'" placeholder="Allownce">'; 
                                                }
                                            @endphp
                                        
                                                <tr>
                                                    <td  class="fixed">{{++$loop->index}}</td>
                                                    <td ><input style="width:100px;" class="form-control online_payment" type="text" name="online_payment[]" value="Online" placeholder="Online Payment"></td>
                                                    <td class="fixed-2">{{$d->employee?->admission_id_no}}<input class="form-control employee_id" type="hidden" name="employee_id[]" value="{{$d->employee_id}}"></td>
                                                    <td class="fixed-3"><input readonly style="width:100px;" class="form-control salary_joining_date" type="text" name="salary_joining_date[]" value="{{$d->employee?->salary_joining_date}}" placeholder="Date of Joining"></td>
                                                    <td class="fixed-4">
                                                        <input style="width:150px;" class="form-control rank" type="text" value="{{$d->position?->name}}" placeholder="Rank">
                                                        <input type="hidden" name="designation_id[]" value="{{$d->designation_id}}" placeholder="Jobpost Id">
                                                        <input type="hidden" name="customer_id_ind[]" value="{{$d->customer_id}}">
                                                        <input type="hidden" name="customer_branch_id[]" value="{{$d->branch_id}}">
                                                        <input type="hidden" name="customer_atm_id[]" value="{{$d->atm_id}}">
                                                    </td>
                                                    <td class="fixed-5"><input style="width:200px;" readonly class="form-control" type="text" value="{{$d->employee?->en_applicants_name}}" placeholder="Name"></td>
                                                    <td>{{$d->customer?->name}}</td>
                                                    <td>{{$d->branches?->brance_name}}</td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="{{$d->duty_rate}}" placeholder="Monthlay Salary">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_qty" type="text" name="duty_qty[]" value="{{$d->duty_qty}}" placeholder="Duty Rate">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_amount" type="text" name="duty_amount[]" value="{{$d->duty_amount}}" placeholder="Duty Amount">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_qty" type="text" name="ot_qty[]" value="{{$d->ot_qty}}" placeholder="Ot Qty">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="{{$d->ot_rate}}" placeholder="Ot Rate">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="{{$d->ot_amount}}" placeholder="Ot Amount">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control fixed_ot" type="text" name="fixed_ot[]" value="{{$d->fixed_ot}}" placeholder="Fixed Ot">
                                                    </td>
                                                    <td>
                                                        {!! $pAllowanCon !!}
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave" type="text" name="leave[]" value="{{$d->leave}}" placeholder="Leave">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control arrear" type="text" name="arrear[]" value="{{$d->arrear}}" placeholder="Arrear">
                                                    </td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="{{$d->gross_salary}}" placeholder="Gross Salary">
                                                    </td>
                                                    <td>{!! $fineCon !!}</td>
                                                    <td>{!! $mobileCon !!}</td>
                                                    <td>{!! $loonCon !!}</td>
                                                    <td>{!! $longLoonCon !!}</td>
                                                    <td>{!! $clothCon !!}</td>
                                                    <td>{!! $jacketCon !!}</td>
                                                    <td>{!! $hrCon !!}</td>
                                                    <td>{!! $trainingCon !!}</td>
                                                    <td>{!! $cfCon !!}</td>
                                                    <td>{!! $medicalCon !!}</td>
                                                    <td>{!! $insCon !!}</td>
                                                    <td>{!! $pfCon !!}</td>
                                                    <td>{!! $stmCon !!}</td>
                                                    <td>{!! $deTotalCon !!}</td>
                                                    <td>{!! $netSalaryCon !!}</td>
                                                    <td>
                                                        <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control sing_of_ind" type="text" name="sing_of_ind[]" value="" placeholder="SIGN OF IND">
                                                    </td>
                                                    <td><input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="{{$d->remark}}"></td>
                                                </tr>
                                                @php
                                                    $old_emp = $d->employee?->admission_id_no;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot class="d-none show_click">
                                            <tr>
                                                <td colspan="8" class="text-end"> Total</td>
                                                <td><input readonly style="width:100px;" class="form-control total_slry" type="text" name="total_slry" placeholder="Monthly Salary"></td>
                                                <td><input readonly style="width:100px;" class="form-control tdq" type="text" name="total_ot" placeholder="Total Days"></td>
                                                <td><input style="width:100px;" class="form-control dam" type="text" name="total_duty_amount" placeholder="Duty Amount"></td>
                                                <td><input style="width:100px;" class="form-control otq" type="text" name="otq" placeholder="Duty Amount"></td>
                                                <td><input style="width:100px;" class="form-control otr" type="text" name="otr" placeholder="Duty Amount"></td>
                                                <td><input style="width:100px;" class="form-control ota" type="text" name="ota" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control fx" type="text" name="fx" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control al" type="text" name="al" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control le" type="text" name="le" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control arr" type="text" name="arr" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control grs" type="text" name="grs" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control fi" type="text" name="fi" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control mb" type="text" name="mb" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dl" type="text" name="dl" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dll" type="text" name="dll" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dc" type="text" name="dc" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dj" type="text" name="dj" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dh" type="text" name="dh" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dtr" type="text" name="dtr" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dcf" type="text" name="dcf" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dem" type="text" name="dem" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control din" type="text" name="din" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dpf" type="text" name="dpf" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dst" type="text" name="dst" placeholder="Amount"></td>
                                                <td><input style="width:100px;" class="form-control dto" type="text" name="dto" placeholder="Total"></td>
                                                <td><input style="width:100px;" class="form-control nts" type="text" name="nts" placeholder="Total"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-info">Update</button>
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
    $('.salarySheet').on('focus', 'input', function() {
        $(this).closest('tr').addClass('selected-row');
    }).on('blur', 'input', function() {
        $(this).closest('tr').removeClass('selected-row');
    });
</script>
<script>
    $(document).ready(function() {
        $('#customerSelect').change(function() {
            var selectedCustomers = $(this).val();

            if (selectedCustomers.length > 0) {
                $.ajax({
                    url: "{{route('salarysheet.get_ajax_salary_branch')}}",
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
    function getSalaryData(e){
        {{--  if (!$('.start_date').val()) {
            $('.start_date').focus();
            return false;
        }
        if (!$('.end_date').val()) {
            $('.end_date').focus();
            return false;
        }  --}}
        var startDate=$('.year').val()+'-'+$('.month').val()+'-01';
        var endDate=$('.year').val()+'-'+$('.month').val()+'-31';
        var CustomerId=$('.customer_id').val();
        var CustomerBranchId=$('.customer_branch_id').val();
        var CustomerIdNot=$('.customer_id_not').val();
        var Year=$('.year').val();
        var Month=$('.month').val();
        //console.log(startDate);

        let counter = 0;
        $.ajax({
            url: "{{route('get_salary_data')}}",
            type: "GET",
            dataType: "json",
            data: { start_date:startDate,end_date:endDate,customer_id:CustomerId,customer_branch_id:CustomerBranchId,CustomerIdNot:CustomerIdNot,Year:Year,Month:Month },
            success: function(salary_data) {
                console.log(salary_data);
                let selectElement = $('.salarySheet');
                    selectElement.empty();
                    var old_emp = '';
                    $.each(salary_data, function(index, value) {
                        //console.log(value);
                        let traningCost=value.bn_remaining_cost;
                        let traningCostMonth=value.bn_traning_cost_byMonth;
                        let traningCostPerMonth=parseFloat((value.bn_remaining_cost)/(value.bn_traning_cost_byMonth)).toFixed(2);
                        let remaining=value.bn_remaining_cost;
                        let postAllowance= (value.bn_post_allowance > 0) ? value.bn_post_allowance : '0';
                        let joiningDate = new Date(value.salary_joining_date);
                        let sixMonthsLater = new Date(joiningDate);
                        sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);

                        let pf = "0";
                        if (new Date() >= sixMonthsLater) {
                            pf = "200";
                        }
                        let Insurance = "0";
                        if (new Date() >= sixMonthsLater) {
                            Insurance = (value.insurance > 0) ? value.insurance : '0';
                        }
                        let Fine = (value.fine > 0) ? value.fine : '0';
                        //let Remarks = (value.remarks) ? value.remarks : '';
                        let RemarksArray = [
                            (value.loan_rmk) ? value.loan_rmk : '',
                            (value.salary_stop_message) ? value.salary_stop_message : ''
                        ];
                        let Remarks = RemarksArray.filter(item => item !== '').join(', ');
                        let MobileBill = (value.mobilebill > 0) ? value.mobilebill : '0';
                        let Loan = (value.loan > 0) ? value.loan : '0';
                        let LongLoan = (value.perinstallment_amount > 0) ? value.perinstallment_amount : '0';
                        let Cloth = (value.cloth > 0) ? value.cloth : '0';
                        let Jacket = (value.jacket > 0) ? value.jacket : '0';
                        let Hr = (value.hr > 0) ? value.hr : '0';
                        let Cf = (value.c_f > 0) ? value.c_f : '0';
                        let Stmp = (value.stmp > 0) ? value.stmp : '0';
                        let Medical = (value.medical > 0) ? value.medical : '0';
                        let grossAmoun = (value.grossAmount > 0) ? value.grossAmount : '0';
                        let totalDeduction = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(Cf) + parseFloat(Medical) + parseFloat(traningCostPerMonth) + parseFloat(pf) + parseFloat(Insurance);
                        let netSalary = '0';
                        if (grossAmoun > totalDeduction) {
                            netSalary = parseFloat(grossAmoun) - parseFloat(totalDeduction);
                        }
                        if(old_emp == value.admission_id_no){
                            var fineCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_fine[]" value="0" readonly>`
                            var mobileCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_mobilebill[]" value="0" readonly>`
                            var loonCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_loan[]" value="0" readonly>`
                            var longLoonCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_long_loan[]" value="0" readonly>`
                            var clothCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_cloth[]" value="0" readonly>`
                            var jacketCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_jacket[]" value="0" readonly>`
                            var hrCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_hr[]" value="0" readonly>`
                            var trainingCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_traningcost[]" value="0" readonly>`
                            var cfCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_c_f[]" value="0" readonly>`
                            var medicalCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_medical[]" value="0" readonly>`
                            var insCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_ins[]" value="0" readonly>`
                            var pfCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_p_f[]" value="0" readonly>`
                            var stmCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_revenue_stamp[]" value="0" readonly>`
                            var deTotalCondition=`<input style="width:100px;" class="form-control" type="text" name="deduction_total[]" value="0" readonly>`
                            var netSalaryCondition=`<input style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="${Math.round(grossAmoun)}" readonly>`
                            var pAllowance=`<input style="width:100px;" class="form-control" type="hidden" name="allownce[]" value="">`
                        }else{
                            var fineCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_fine" type="text" name="deduction_fine[]" value="${Fine}" placeholder="Fine">`
                            var mobileCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_mobilebill" type="text" name="deduction_mobilebill[]" value="${MobileBill}" placeholder="Mobile bill">`
                            var loonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_loan" type="text" name="deduction_loan[]" value="${Loan}" placeholder="Loan">`
                            var longLoonCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_long_loan" type="text" name="deduction_long_loan[]" value="${LongLoan}" placeholder="Long Loan">`
                            var clothCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_cloth" type="text" name="deduction_cloth[]" value="${Cloth}" placeholder="Cloth">`
                            var jacketCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_jacket" type="text" name="deduction_jacket[]" value="${Jacket}" placeholder="Jacket">`
                            var hrCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_hr" type="text" name="deduction_hr[]" value="${Hr}" placeholder="HR">`
                            var trainingCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_traningcost" type="text" name="deduction_traningcost[]" value="${traningCostPerMonth}" placeholder="Training Cost">`
                            var cfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_c_f" type="text" name="deduction_c_f[]" value="${Cf}" placeholder="C/F">`
                            var medicalCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_medical" type="text" name="deduction_medical[]" value="${Medical}" placeholder="Medical">`
                            var insCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_ins" type="text" name="deduction_ins[]" value="${Insurance}" placeholder="Ins">`
                            var pfCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_p_f" type="text" name="deduction_p_f[]" value="${pf}" placeholder="P/F">`
                            var stmCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_revenue_stamp" type="text" name="deduction_revenue_stamp[]" value="${Stmp}" placeholder="Revenue Stamp">`
                            var deTotalCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control deduction_total" type="text" name="deduction_total[]" value="${totalDeduction}" placeholder="Total">`
                            var netSalaryCondition=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control net_salary" type="text" name="net_salary[]" value="${Math.round(netSalary)}" placeholder="Net Salary">`
                            var pAllowance=`<input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control allownce" type="text" name="allownce[]" value="${postAllowance}" placeholder="Allownce">`
                        }
                        selectElement.append(
                            `<tr>
                                <td class="fixed">${counter + 1}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control online_payment" type="text" name="online_payment[]" value="Online" placeholder="Online Payment">
                                </td>
                                <td class="fixed-2">${value.admission_id_no}
                                    <input class="form-control employee_id" type="hidden" name="employee_id[]" value="${value.employee_id}" placeholder="Employee Id">
                                    <input class="ever_care_customer_id" type="hidden" name="customer_id_ind[]" value="${value.customer_id}">
                                    <input type="hidden" name="customer_branch_id[]" value="${value.branch_id}">
                                    <input type="hidden" name="customer_atm_id[]" value="${value.atm_id}">
                                </td>
                                <td class="fixed-3"><input readonly style="width:100px;" class="form-control salary_joining_date" type="text" name="salary_joining_date[]" value="${value.salary_joining_date}" placeholder="Date of Joining"></td>
                                <td class="fixed-4">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:150px;" readonly class="form-control" type="text" value="${value.jobpost_name}" placeholder="Name">
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control rank" type="hidden" name="designation_id[]" value="${value.jobpost_id}" placeholder="Desingation">
                                </td>
                                <td class="fixed-5"><input onkeyup="reCalcultateSalary(this)" style="width:200px;" readonly class="form-control" type="text" value="${value.en_applicants_name}" placeholder="Name"></td>
                                <td width="300px"> ${value.customer_name}</td>
                                <td width="300px"> ${value.customer_branch}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control duty_rate" type="text" name="duty_rate[]" value="${value.duty_rate}" placeholder="Monthlay Salary">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_qty" type="text" name="duty_qty[]" value="${value.duty_qty}" placeholder="Duty Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control duty_amount" type="text" name="duty_amount[]" value="${value.duty_amount}" placeholder="Duty Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_qty" type="text" name="ot_qty[]" value="${value.ot_qty}" placeholder="Ot Qty">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control ot_rate" type="text" name="ot_rate[]" value="${value.ot_rate}" placeholder="Ot Rate">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" readonly style="width:100px;" class="form-control ot_amount" type="text" name="ot_amount[]" value="${value.ot_amount}" placeholder="Ot Amount">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control fixed_ot" type="text" name="fixed_ot[]" value="" placeholder="Fixed Ot">
                                </td>
                                <td>
                                    ${pAllowance}
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control leave" type="text" name="leave[]" value="" placeholder="Leave">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control arrear" type="text" name="arrear[]" value="" placeholder="Arrear">
                                </td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control gross_salary" type="text" name="gross_salary[]" value="${value.grossAmount}" placeholder="Gross Salary">
                                </td>
                                <td>${fineCondition}</td>
                                <td>${mobileCondition}</td>
                                <td>${loonCondition}</td>
                                <td>${longLoonCondition}</td>
                                <td>${clothCondition}</td>
                                <td>${jacketCondition}</td>
                                <td>${hrCondition}</td>
                                <td>${trainingCondition}</td>
                                <td>${cfCondition}</td>
                                <td>${medicalCondition}</td>
                                <td>${insCondition}</td>
                                <td>${pfCondition}</td>
                                <td>${stmCondition}</td>
                                <td>${deTotalCondition}</td>
                                <td>${netSalaryCondition}</td>
                                <td>
                                    <input onkeyup="reCalcultateSalary(this)" style="width:100px;" class="form-control sing_of_ind" type="text" name="sing_of_ind[]" value="" placeholder="SIGN OF IND">
                                </td>
                                <td><input style="width:100px;" class="form-control remark" type="text" name="remark[]" value="${Remarks}"></td>
                                {{--  <td>
                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                </td>  --}}
                            </tr>`
                        );
                        counter++;
                        total_calculate();
                        old_emp= value.admission_id_no;
                    });
                    // Add event listeners for focusing and blurring inputs
                    $('.salarySheet').on('focus', 'input', function() {
                        $(this).closest('tr').addClass('selected-row');
                    }).on('blur', 'input', function() {
                        $(this).closest('tr').removeClass('selected-row');
                    });
            },
        });
        $('.show_click').removeClass('d-none');
     }

     function reCalcultateSalary(e) {
        var divideByDayTotal = 0;
        var dutyRateDay=0;
        var otRateDay=0;
        var customer_id = $(e).closest('tr').find('.ever_care_customer_id').val()?parseFloat($(e).closest('tr').find('.ever_care_customer_id').val()):0;

        let dutyRate=$(e).closest('tr').find('.duty_rate').val()?parseFloat($(e).closest('tr').find('.duty_rate').val()):0;
        let otRate=$(e).closest('tr').find('.ot_rate').val()?parseFloat($(e).closest('tr').find('.ot_rate').val()):0;
        let dutyQty=$(e).closest('tr').find('.duty_qty').val()?parseFloat($(e).closest('tr').find('.duty_qty').val()):0;
        let otQty=$(e).closest('tr').find('.ot_qty').val()?parseFloat($(e).closest('tr').find('.ot_qty').val()):0;
        let fixedOt=$(e).closest('tr').find('.fixed_ot').val()?parseFloat($(e).closest('tr').find('.fixed_ot').val()):0;
        let allownce=$(e).closest('tr').find('.allownce').val()?parseFloat($(e).closest('tr').find('.allownce').val()):0;
        let arrear=$(e).closest('tr').find('.arrear').val()?parseFloat($(e).closest('tr').find('.arrear').val()):0;
        let currentDate = new Date();
        //let currentMonth = currentDate.getMonth() + 1;
        //let totalDaysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        let currentMonth = $('.selected_month').val();
        let totalDaysInMonth = new Date(new Date().getFullYear(), currentMonth, 0).getDate();
        // evercare setting
        if(totalDaysInMonth == 29){
            var divideByDayTotal = (totalDaysInMonth - 5);
        }else{
            var divideByDayTotal = (totalDaysInMonth - 4);
        }
        // evercare setting
        if(customer_id == 21){
            var dutyRateDay=dutyRate/divideByDayTotal;
            var otRateDay=otRate/divideByDayTotal;
        }else{
            var dutyRateDay=dutyRate/totalDaysInMonth;
            var otRateDay=otRate/totalDaysInMonth;
        }
        let dutyAmount=parseFloat(dutyRateDay*dutyQty);
        let otAmount=parseFloat(otRateDay*otQty);
        $(e).closest('tr').find('.duty_amount').val(parseFloat(dutyAmount).toFixed(2));
        $(e).closest('tr').find('.ot_amount').val(parseFloat(otAmount).toFixed(2));

        let Fine=$(e).closest('tr').find('.deduction_fine').val()?parseFloat($(e).closest('tr').find('.deduction_fine').val()):0;
        let MobileBill=$(e).closest('tr').find('.deduction_mobilebill').val()?parseFloat($(e).closest('tr').find('.deduction_mobilebill').val()):0;
        let Loan=$(e).closest('tr').find('.deduction_loan').val()?parseFloat($(e).closest('tr').find('.deduction_loan').val()):0;
        let LongLoan=$(e).closest('tr').find('.deduction_long_loan').val()?parseFloat($(e).closest('tr').find('.deduction_long_loan').val()):0;
        let Cloth=$(e).closest('tr').find('.deduction_cloth').val()?parseFloat($(e).closest('tr').find('.deduction_cloth').val()):0;
        let Jacket=$(e).closest('tr').find('.deduction_jacket').val()?parseFloat($(e).closest('tr').find('.deduction_jacket').val()):0;
        let Hr=$(e).closest('tr').find('.deduction_hr').val()?parseFloat($(e).closest('tr').find('.deduction_hr').val()):0;
        let traningCost=$(e).closest('tr').find('.deduction_traningcost').val()?parseFloat($(e).closest('tr').find('.deduction_traningcost').val()):0;
        let Cf=$(e).closest('tr').find('.deduction_c_f').val()?parseFloat($(e).closest('tr').find('.deduction_c_f').val()):0;
        let medical=$(e).closest('tr').find('.deduction_medical').val()?parseFloat($(e).closest('tr').find('.deduction_medical').val()):0;
        let ins=$(e).closest('tr').find('.deduction_ins').val()?parseFloat($(e).closest('tr').find('.deduction_ins').val()):0;
        let pf=$(e).closest('tr').find('.deduction_p_f').val()?parseFloat($(e).closest('tr').find('.deduction_p_f').val()):0;
        let stamp=$(e).closest('tr').find('.deduction_revenue_stamp').val()?parseFloat($(e).closest('tr').find('.deduction_revenue_stamp').val()):0;
        let detotal=$(e).closest('tr').find('.deduction_total').val()?parseFloat($(e).closest('tr').find('.deduction_total').val()):0;
        let tg= parseFloat(dutyAmount) + parseFloat(otAmount) + parseFloat(fixedOt) + parseFloat(allownce) + parseFloat(arrear);
        let td = parseFloat(Fine) + parseFloat(MobileBill) + parseFloat(Loan) + parseFloat(LongLoan) + parseFloat(Cloth) + parseFloat(Jacket) + parseFloat(Hr) + parseFloat(traningCost) + parseFloat(Cf) + parseFloat(medical) + parseFloat(ins) + parseFloat(pf) + parseFloat(stamp);
        let net = parseFloat(tg) - parseFloat(td);
        $(e).closest('tr').find('.deduction_total').val(parseFloat(td).toFixed(2));
        $(e).closest('tr').find('.gross_salary').val(parseFloat(tg).toFixed(2));
        $(e).closest('tr').find('.net_salary').val(Math.round(parseFloat(net)));
        total_calculate();

    }
    function total_calculate() {
        var totalSlry = 0;
        var dq = 0; var da = 0; var otq = 0; var otr = 0; var ota = 0; var fx = 0; var al = 0; var le = 0; var arr = 0; var grs = 0; var fi = 0; var mb = 0; var dl = 0; var dll = 0; var dc = 0; var dj = 0; var dh = 0; var dtr = 0; var dcf = 0; var dem = 0; var din = 0; var dpf = 0; var dst = 0; var dto = 0; var nts = 0;
        $('.duty_rate').each(function() {
            totalSlry+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_qty').each(function() {
            dq+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.duty_amount').each(function() {
            da+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_qty').each(function() {
            otq+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_rate').each(function() {
            otr+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.ot_amount').each(function() {
            ota+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.fixed_ot').each(function() {
            fx+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.allownce').each(function() {
            al+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.leave').each(function() {
            le+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.arrear').each(function() {
            arr+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.gross_salary').each(function() {
            grs+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_fine').each(function() {
            fi+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_mobilebill').each(function() {
            mb+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_loan').each(function() {
            dl+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_long_loan').each(function() {
            dll+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_cloth').each(function() {
            dc+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_jacket').each(function() {
            dj+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_hr').each(function() {
            dh+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_traningcost').each(function() {
            dtr+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_c_f').each(function() {
            dcf+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_medical').each(function() {
            dem+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_ins').each(function() {
            din+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_p_f').each(function() {
            dpf+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_revenue_stamp').each(function() {
            dst+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.deduction_total').each(function() {
            dto+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.net_salary').each(function() {
            nts+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.total_slry').val(parseFloat(totalSlry).toFixed(2));
        $('.nts').val(parseFloat(nts).toFixed(2));
        $('.tdq').val(parseFloat(dq).toFixed(2));
        $('.otq').val(parseFloat(otq).toFixed(2));
        $('.otr').val(parseFloat(otr).toFixed(2));
        $('.ota').val(parseFloat(ota).toFixed(2));
        $('.dam').val(parseFloat(da).toFixed(2));
        $('.dh').val(parseFloat(dh).toFixed(2));
        $('.fx').val(parseFloat(fx).toFixed(2));
        $('.al').val(parseFloat(al).toFixed(2));
        $('.le').val(parseFloat(le).toFixed(2));
        $('.arr').val(parseFloat(arr).toFixed(2));
        $('.grs').val(parseFloat(grs).toFixed(2));
        $('.fi').val(parseFloat(fi).toFixed(2));
        $('.mb').val(parseFloat(mb).toFixed(2));
        $('.din').val(parseFloat(din).toFixed(2));
        $('.dto').val(parseFloat(dto).toFixed(2));
        $('.dl').val(parseFloat(dl).toFixed(2));
        $('.dll').val(parseFloat(dll).toFixed(2));
        $('.dc').val(parseFloat(dc).toFixed(2));
        $('.dj').val(parseFloat(dj).toFixed(2));
        $('.dtr').val(parseFloat(dtr).toFixed(2));
        $('.dcf').val(parseFloat(dcf).toFixed(2));
        $('.dem').val(parseFloat(dem).toFixed(2));
        $('.dst').val(parseFloat(dst).toFixed(2));
        $('.dpf').val(parseFloat(dpf).toFixed(2));
       // console.log(totalSlry);

    }
</script>

@endpush
