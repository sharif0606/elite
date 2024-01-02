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
                        <form method="post" action="{{route('WasaInviceStore')}}" enctype="multipart/form-data">
                        {{--  <form method="post" action="{{route('WasaInviceStore',[encryptor('encrypt',$empasin?->id)])}}" enctype="multipart/form-data">  --}}
                            @csrf
                            @method('POST')
                            <div class="row p-2 mt-4">
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Customer Name</b></label> :  {{ $customer->name }}
                                    <input readonly class="form-control customer_id" id="customer_id" type="hidden" name="customer_id" value="{{ $customer->id }}">
                                    <input class="" type="hidden" name="vat_on_subtotal" value="{{ $empasin->vat_on_subtotal }}">
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for=""><b>Branch Name</b></label> : {{ $branch?->brance_name }}
                                    <input readonly class="form-control branch_id" id="branch_id" type="hidden" name="branch_id" value="{{ $customer->id }}">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input required class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for=""><b>Footer Note</b></label>
                                    <textarea class="form-control" name="footer_note" id="" cols="30" rows="2" placeholder="Please enter Footer Note">The payment may please be made in Cheques/Drafts/Cash in favor of "Elite Security Services Limited" by the 1st week of each month.
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
                                                <th scope="col">{{__('Duty')}}</th>
                                                <th scope="col">{{__('Account No')}}</th>
                                                <th scope="col">{{__('Salary')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empasinassing">
                                            @if ($empasin->details)
                                            @foreach ($empasin->details as $d)
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
                                                <td><input readonly class="form-control input_css employee_name" type="text" value="{{ $d->employee_name }}" placeholder="Employee Name"></td>
                                                <td><input required class="form-control input_css" type="text" name="duty[]" value="{{ $d->duty }}" placeholder="Duty"></td>
                                                <td><input readonly class="form-control input_css account_no" type="text" value="{{ $d->account_no }}" placeholder="Account No"></td>
                                                <td><input class="form-control input_css salary_amount" type="text" name="salary_amount[]" value="{{ $d->salary_amount }}" placeholder="Salary Amount"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7" style="text-align: end;">Sub Tatal</th>
                                                <td>
                                                    <input readonly type="text" class="form-control sub_total_salary" name="sub_total_salary" value="{{ $empasin->sub_total_salary }}">
                                                </td>
                                            </tr>
                                            @php
                                                $comissionTk=($empasin->sub_total_salary)*($empasin->add_commission/100);
                                                $vatAit=(($empasin->vat_on_commission+$empasin->ait_on_commission)/100);
                                                $vatAitTakaCommision=($comissionTk*$vatAit);
                                                $VatTkCommission=$comissionTk*($empasin->vat_on_commission/100);
                                                $AitTkCommission=$comissionTk*($empasin->ait_on_commission/100);
                                                $vatOnSubtotal=($empasin->sub_total_salary)*($empasin->vat_on_subtotal/100);
                                                $aitOnSubtotal=($empasin->sub_total_salary)*($empasin->ait_on_subtotal/100);
                                                $grandTotal=($empasin->sub_total_salary+$comissionTk+$vatAitTakaCommision+$vatOnSubtotal+$aitOnSubtotal);
                                            @endphp
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">Add: Commission {{ $empasin->add_commission }}%</th>
                                                <td>
                                                    <input readonly type="text" class="form-control add_commission_tk" name="add_commission_tk" value="{{ $comissionTk }} ">
                                                    <input class="" type="hidden" name="add_commission_percentage" value="{{ $empasin->add_commission }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent">{{ $empasin->vat_on_commission }}</span> %) VAT + (<span class="vat_percent">{{ $empasin->ait_on_commission }}</span> %)AIT = {{ $empasin->vat_on_commission+$empasin->ait_on_commission }}% Commision</th>
                                                <td>
                                                    <input readonly type="text" class="form-control vat_ait_commission_tk" name="vat_ait_commission_tk" value="{{ $vatAitTakaCommision }}">
                                                    <input class="" type="hidden" name="vat_ait_commission_percentage" value="{{ $empasin->vat_on_commission+$empasin->ait_on_commission}}">
                                                    <input class="" type="hidden" name="vat_commission_percentage" value="{{ $empasin->vat_on_commission }}">
                                                    <input class="" type="hidden" name="vat_commission_percentage_tk" value="{{ $VatTkCommission }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage" value="{{ $empasin->ait_on_commission }}">
                                                    <input class="" type="hidden" name="ait_commission_percentage_tk" value="{{ $AitTkCommission }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent">{{ $empasin->vat_on_subtotal }}</span> %) VAT on Sub Total</th>
                                                <td><input readonly type="text" class="form-control vat_tk_subtotal" name="vat_tk_subtotal" value="{{ $vatOnSubtotal }}"></td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">(<span class="vat_percent">{{ $empasin->ait_on_subtotal }}</span> %) AIT on Sub Total</th>
                                                <td>
                                                    <input readonly type="text" class="form-control ait_tk_subtotal" name="ait_tk_subtotal" value="{{ $aitOnSubtotal }}">
                                                    <input class="" type="hidden" name="ait_on_subtotal" value="{{ $empasin->ait_on_subtotal }}">
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td></td>
                                                <th colspan="7">Grand Total</th>
                                                <td><input readonly type="text" class="form-control grand_total_tk" name="grand_total_tk" value="{{ $grandTotal }}"></td>
                                            </tr>
                                            {{--  <tr>
                                                <td colspan="9">Total Amount in Word: </td>
                                            </tr>  --}}
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
</script>
@endpush
