@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
@section('pageSubTitle',trans('Update'))

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
                        <form method="post" action="{{route('WasaInviceUpdate',[encryptor('encrypt',$inv->id)])}}" enctype="multipart/form-data"> 
                            @csrf
                            @method('POST')
                            <input type="hidden" name="zone_id" id="zone_id" value="{{$invWasa->customer?->zone_id}}">
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label> :  {{ $invWasa->customer?->name }}
                                    <input readonly class="form-control customer_id" id="customer_id" type="hidden" name="customer_id" value="{{ $invWasa->customer_id }}">
                                    <input class="" type="hidden" name="vat_on_subtotal" value="{{ $invWasa->vat_on_subtotal }}">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input required class="form-control" type="date" name="bill_date" value="{{$invWasa->bill_date}}" placeholder="Bill Date">
                                </div>
                                <div class="col-lg-3 mt-2 d-none">
                                    <label for=""><b>Star Date</b></label>
                                    <input class="form-control" type="date" name="start_date" value="{{$invWasa->start_date}}">
                                </div>
                                <div class="col-lg-3 mt-2 d-none">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control" type="date" name="end_date" value="{{$invWasa->end_date}}">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Header Note</b></label>
                                    <textarea class="form-control" name="header_note" id="" cols="30" rows="3" placeholder="Please enter header Note">
                                        @if ($inv->header_note != '')
                                            {{$inv->header_note}}
                                        @else
                                            Reference to the above subject, we herewith submitted the security services bill and account number at Prime Bank, Halisahar Branch.
                                        @endif
                                    </textarea>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="" cols="30" rows="3" placeholder="Please enter Footer Note">
                                        @if ($inv->footer_note != '')
                                            {{$inv->footer_note}}
                                        @else
                                            The payment may please be made in Cheques/Drafts/Cash in favor of "Elite Security Services Limited" by 1st week of each month.
                                        @endif
                                    </textarea>
                                </div>
                                
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('#SL')}}</th>
                                                <th scope="col">{{__('ATM')}}</th>
                                                <th scope="col">{{__('Employee ID No')}}</th>
                                                <th scope="col">{{__('Rank')}}</th>
                                                <th scope="col">{{__('Area')}}</th>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Rate')}}</th>
                                                <th scope="col">{{__('Duty')}}</th>
                                                <th scope="col">{{__('Account No')}}</th>
                                                <th scope="col">{{__('Salary')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empasinassing">
                                            @foreach ($invWasaDetail as $d)
                                                <tr>
                                                    <td scope="row">{{ ++$loop->index }}</td>
                                                    <td>{{ $d->atms?->atm }}
                                                        <input class="" type="hidden" name="atm_id[]" value="{{ $d->atm_id }}">
                                                    </td>
                                                    <td>{{ $d->employee?->admission_id_no }}
                                                        <input class="" type="hidden" name="employee_id[]" value="{{ $d->employee_id}}">
                                                    </td>
                                                    <td>{{ $d->jobpost?->name }}
                                                        <input class="" type="hidden" name="job_post_id[]" value="{{ $d->job_post_id }}">
                                                    </td>
                                                    <td><input readonly class="form-control input_css" type="text" name="area[]" value="{{ $d->area }}" placeholder="Area"></td>
                                                    <td><input readonly class="form-control input_css employee_name" type="text" value="{{ $d->employee?->en_applicants_name }}" placeholder="Employee Name"></td>
                                                    <td><input required class="form-control input_css" type="text" name="duty_rate[]" value="{{ (int)$d->duty_rate }}"></td>
                                                    <td><input required class="form-control input_css" type="text" name="duty[]" value="{{ $d->duty }}" placeholder="Duty"></td>
                                                    <td><input readonly class="form-control input_css account_no" type="text" name="account_no[]" value="{{ $d->account_no }}" placeholder="Account No"></td>
                                                    <td><input class="form-control input_css salary_amount" type="text" name="salary_amount[]" value="{{ $d->salary_amount }}" placeholder="Salary Amount"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8" style="text-align: end;">Sub Tatal</th>
                                                <td>
                                                    <input readonly type="text" class="form-control sub_total_salary" name="sub_total_salary" value="{{ $invWasa->sub_total_salary }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8">Add: Commission {{ $invWasa->add_commission }}%</th>
                                                <td>
                                                    <input readonly type="text" class="form-control add_commission_tk" name="add_commission_tk" value="{{ number_format($invWasa->add_commission_tk, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="add_commission_percentage" value="{{ $invWasa->add_commission }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8">(<span class="vat_percent">{{ $invWasa->vat_on_commission }}</span> %) VAT + (<span class="vat_percent">{{ $invWasa->ait_on_commission }}</span> %)AIT = {{ $invWasa->vat_ait_on_commission }}% Commision</th>
                                                <td>
                                                    <input readonly type="text" class="form-control vat_ait_commission_tk" name="vat_ait_commission_tk" value="{{ number_format($invWasa->vat_ait_on_commission_tk, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="vat_ait_commission_percentage" value="{{ $invWasa->vat_ait_on_commission}}">
                                                    <input class="" type="hidden" name="vat_commission_percentage" value="{{ $invWasa->vat_on_commission }}">
                                                    <input class="" type="hidden" name="vat_commission_percentage_tk" value="{{ $invWasa->vat_on_commission_tk }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage" value="{{ $invWasa->ait_on_commission }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage_tk" value="{{ $invWasa->ait_on_commission_tk }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8">(<span class="vat_percent">{{ $invWasa->ait_on_subtotal }}</span> %) VAT on Sub Total</th>
                                                <td><input readonly type="text" class="form-control vat_tk_subtotal" name="vat_tk_subtotal" value="{{ number_format($invWasa->vat_on_subtotal_tk, 2, '.', '') }}"></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8">(<span class="vat_percent">{{ $invWasa->ait_on_subtotal }}</span> %) AIT on Sub Total</th>
                                                <td>
                                                    <input readonly type="text" class="form-control ait_tk_subtotal" name="ait_tk_subtotal" value="{{ number_format($invWasa->ait_on_subtotal_tk, 2, '.', '') }}">
                                                    <input class="" type="hidden" name="ait_on_subtotal" value="{{ $invWasa->ait_on_subtotal }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="8">Grand Total</th>
                                                <td><input readonly type="text" class="form-control grand_total_tk" name="grand_total_tk" value="{{ number_format($invWasa->grand_total_tk, 2, '.', '') }}"></td>
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
</script>
@endpush
