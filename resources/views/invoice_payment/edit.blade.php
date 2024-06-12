@extends('layout.app')

@section('pageTitle',trans('Invoice Generate Update'))
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
                        <form method="post" action="{{route('invoice-payment.update', [encryptor('encrypt',$ivp->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Customer Name: {{ $ivp->customer?->name }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Received Amount</label>
                                    <input type="text" id="received_amount" name="received_amount" class="form-control" value="{{ $ivp->received_amount }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">VAT</label>
                                    <input type="text" onkeyup="vatcalc(this.value,'vat_amount')" id="vat" name="vat" value="{{ $ivp->vat }}" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">VAT Amount</label>
                                    <input type="text" onkeyup="vatcalc(this.value,'vat')" id="vat_amount" name="vat_amount" value="{{ $ivp->vat_amount }}" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">AIT</label>
                                    <input type="text" onkeyup="aitcalc(this.value,'ait_amount')" id="ait"  name="ait" value="{{ $ivp->ait }}" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">AIT Deduction</label>
                                    <input type="text" onkeyup="aitcalc(this.value,'ait')" id="ait_amount"  name="ait_amount" value="{{ $ivp->ait_amount }}" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Fine Deduction</label>
                                    <input type="text"  name="fine_deduction" value="{{ $ivp->fine_deduction }}" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Payment Mode</label>
                                    <select name="payment_type" class="form-control" onchange="paymethod()">
                                        <option value="1" {{$ivp->payment_type==1?'selected':''}}>Cash</option>
                                        <option value="2" {{$ivp->payment_type==2?'selected':''}}>Pay Order</option>
                                        <option value="3" {{$ivp->payment_type==3?'selected':''}}>Fund Transfer</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Bank Name</label>
                                    <input type="text" name="bank_name" onchange="paymethod()" class="form-control po_bank error-msg" value="{{ $ivp->bank_name }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">PO No</label>
                                    <input type="text" name="po_no" onchange="paymethod()" class="form-control po_num error-msg" value="{{ $ivp->po_no }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">PO Date</label>
                                    <input type="date" name="po_date" onchange="paymethod()" class="form-control po_date error-msg" value="{{ $ivp->po_date }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Pay Date</label>
                                    <input type="date" value="{{ $ivp->pay_date }}" name="pay_date" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Receive Date</label>
                                    <input type="date" name="rcv_date" class="form-control" value="{{ $ivp->rcv_date }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Deposit Date</label>
                                    <input type="date" name="deposit_date" class="form-control" value="{{ $ivp->deposit_date }}">
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control">{{ $ivp->remarks }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" id="buttonDisable" class="btn btn-primary">Save</button>
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
    function paymethod(){
        let pmethod = document.querySelector('select[name="payment_type"]').value;
        let poBank = $('.po_bank').val();
        let poNo = $('.po_num').val();
        let poDate = $('.po_date').val();
        var errorMessage = $('.error-msg').next('.error-message');
        if(pmethod == 2){
            if(poNo == '' || poDate == '' || poBank == ''){
                errorMessage.text('This field is required').css('color', 'red').show();
                $('#buttonDisable').attr('disabled',true)
                $('.po_bank').attr('required',true)
                $('.po_num').attr('required',true)
                $('.po_num').attr('required',true)
            }else{
                errorMessage.hide();
                $('#buttonDisable').removeAttr('disabled',false)
                $('.po_bank').attr('required',false)
                $('.po_num').attr('required',false)
                $('.po_num').attr('required',false)
            }
        }else{
            errorMessage.hide();
            $('.po_bank').val('')
            $('.po_num').val('')
            $('.po_date').val('');
            $('#buttonDisable').removeAttr('disabled',false)
            $('.po_bank').attr('required',false)
            $('.po_num').attr('required',false)
            $('.po_num').attr('required',false)
        }
    }
</script>

@endpush
