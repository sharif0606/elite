@extends('layout.app')

@section('pageTitle',trans('Wasa Invoice Generate'))
@section('pageSubTitle',trans('Crate'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('wasaEmployeeAsign.update',[encryptor('encrypt',$empasin?->id)])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label> :  {{ $customer->name }}
                                    <input readonly class="form-control customer_id" id="customer_id" type="hidden" name="customer_id" value="{{ $customer->id }}">
                                    {{--  <select class="form-select customer_id" id="customer_id" name="customer_id">
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    </select>  --}}
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label> : {{ $branch?->brance_name }}
                                    <input readonly class="form-control branch_id" id="branch_id" type="hidden" name="branch_id" value="{{ $customer->id }}">
                                    {{--  <select class="form-select branch_id" id="branch_id" name="branch_id" onchange="getAtm(this)">
                                        <option value="0">Select Branch</option>
                                        <option value="{{ $branch?->id }}">{{ $branch?->brance_name }}</option>
                                    </select>  --}}
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input required class="form-control vat" step="0.01" type="number" name="vat" value="" placeholder="Vat">
                                </div>
                                {{--  <div class="col-lg-4 mt-2">
                                    <label for=""><b>Atm</b></label>
                                    <select class="form-select atm_id" id="atm_id" name="atm_id">
                                        <option value="{{ $atm->id }}">{{ $atm->atm }}</option>
                                    </select>
                                </div>  --}}
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('#SL')}}</th>
                                                <th scope="col">{{__('ATM')}}</th>
                                                <th scope="col">{{__('Employee ID No')}}</th>
                                                <th scope="col">{{__('Rank')}}</th>
                                                <th scope="col">{{__('Area')}}</th>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Duty')}}</th>
                                                <th scope="col">{{__('Account No')}}</th>
                                                <th scope="col">{{__('Salary')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empasinassing">
                                            @if ($empasin->details)
                                            @foreach ($empasin->details as $d)
                                            <tr>
                                                <td scope="row">{{ ++$loop->index }}</td>
                                                <td>
                                                    <select class="form-select atm_id" id="atm_id" name="atm_id[]">
                                                        <option value="0">Select Atm</option>
                                                        @forelse ($atm as $a)
                                                        <option value="{{ $a->id }}" {{ $d->atm_id==$a->id?"selected":""}}>{{ $a->atm }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select employee_id select2" id="employee_id" name="employee_id[]" onchange="getEmployees(this)">
                                                        <option value="">Select</option>
                                                        @forelse ($employee as $em)
                                                        <option value="{{ $em->id }}" {{ ($d->employee_id == $em->id ? 'selected' : '') }}>{{ $em->admission_id_no }}</option>
                                                        {{--  <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ ' ('.$em->admission_id_no.')'.$em->en_applicants_name }}</option>  --}}
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select job_post_id" id="job_post_id" name="job_post_id[]" onchange="getRate(this)">
                                                        <option value="">Select Post</option>
                                                        @forelse ($jobpost as $job)
                                                        <option value="{{ $job->id }}" {{ $d->job_post_id==$job->id?"selected":""}}>{{ $job->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="area[]" value="{{ $d->area }}" placeholder="Area"></td>
                                                <td><input class="form-control employee_name" type="text" name="employee_name[]" value="{{ $d->employee_name }}" placeholder="Employee Name"></td>
                                                <td><input required class="form-control" type="text" name="duty[]" value="{{ $d->duty }}" placeholder="Duty"></td>
                                                <td><input class="form-control account_no" type="text" name="account_no[]" value="{{ $d->account_no }}" placeholder="Account No"></td>
                                                <td><input class="form-control" type="text" name="salary_amount[]" value="{{ $d->salary_amount }}" placeholder="Salary Amount"></td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                    <span onClick='addRow(),EmployeeAsignGetAtm();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7" style="text-align: end;">Sub Tatal</th>
                                                <td>
                                                    <input readonly type="text" class="form-control sub_total_amount text-center" name="sub_total_amount" value="">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">Add: Commission 5%</th>
                                                <td>
                                                    <input readonly type="text" class="form-control text-center total_tk" name="total_tk" value="">
                                                    <input class="temporaty_total" type="hidden" name="temporaty_total[]" value="">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent"></span> %) Vat + (<span class="vat_percent"></span> %)AIT = 20% Commision</th>
                                                <td><input readonly type="text" class="form-control text-center vat_taka" name="vat_taka" value=""></td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent"></span> %) Vat on Sub Total</th>
                                                <td><input readonly type="text" class="form-control text-center vat_taka" name="vat_taka" value=""></td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent"></span> %) AIT on Sub Total</th>
                                                <td><input readonly type="text" class="form-control text-center vat_taka" name="vat_taka" value=""></td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">Grand Total</th>
                                                <td><input readonly type="text" class="form-control text-center grand_total" name="grand_total" value=""></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Total Amount in Word: </td>
                                            </tr>
                                        </tfoot>
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
        $('#empasinassing').append(row);
    }

function RemoveRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>
<script>
    function EmployeeAsignGetAtm(e) {
        let branchId=$('.branch_id').val();
        $.ajax({
            url: "{{ route('get_ajax_atm') }}",
            type: "GET",
            dataType: "json",
            data: { branchId: branchId },
            success: function (data) {
                //console.log(data)
                //var d = $('.atm_id').empty();
                //$('.atm_id').append('<option data-vat="0" value="0">Select ATM</option>');
                //$('#atm_id').append('<option value="1">All ATM</option>');
                $.each(data, function(key, value) {
                    $('.atm_id').append('<option value="' + value.id + '">' + value.atm + '</option>');
                });
            },
            error: function () {
                console.error("Error fetching data from the server.");
            },
        });
    }
</script>
@endpush
