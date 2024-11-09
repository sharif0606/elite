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
                                @if ($ivp->invoice?->vat_switch != 1)
                                    <input id="subAmountInput" type="hidden" value="{{$ivp->invoice?->total_tk}}">
                                @else
                                    <input id="subAmountInput" type="hidden" value="{{$ivp->invoice?->sub_total_amount}}">
                                @endif
                                <input id="totalDue" type="hidden" value="{{($ivp->invoice?->grand_total + $paidFromThisId) - $totalPaid->total_sum}}">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Customer Name: {{ $ivp->customer?->name }} @if ($ivp->invoice?->branch?->brance_name != ''), {{ $ivp->invoice?->branch?->brance_name }} @endif</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Received Amount</label>
                                    <input type="text" id="received_amount" onkeyup="billTotal();" name="received_amount" class="form-control" value="{{ $ivp->received_amount }}">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">VAT</label>
                                    <input type="text" onkeyup="vatcalc(this.value,'vat_amount')" id="vat" name="vat" value="{{ $ivp->vat }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">VAT Amount</label>
                                    <input type="text" onkeyup="vatcalc(this.value,'vat')" id="vat_amount" name="vat_amount" value="{{ $ivp->vat_amount }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">AIT</label>
                                    <input type="text" onkeyup="aitcalc(this.value,'ait_amount')" id="ait"  name="ait" value="{{ $ivp->ait }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">AIT Deduction</label>
                                    <input type="text" onkeyup="aitcalc(this.value,'ait')" id="ait_amount"  name="ait_amount" value="{{ $ivp->ait_amount }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Fine Deduction</label>
                                    <input type="text" id="fine_deduction" onkeyup="billTotal();"  name="fine_deduction" value="{{ $ivp->fine_deduction }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Salary paid by client</label>
                                    <input type="text" id="paid_by_client" onkeyup="billTotal();"  name="paid_by_client" value="{{ $ivp->paid_by_client }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Discount</label>
                                    <input type="text" id="less_paid_honor" onkeyup="billTotal();" name="less_paid_honor" value="{{ $ivp->less_paid_honor }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Less Paid</label>
                                    <input type="text" id="less_paid" name="less_paid" value="{{ $ivp->less_paid }}" class="form-control" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Payment Mode</label>
                                    <select name="payment_type" class="form-control form-select" onchange="paymethod()">
                                        <option value="1" {{$ivp->payment_type==1?'selected':''}}>Cash</option>
                                        <option value="2" {{$ivp->payment_type==2?'selected':''}}>Pay Order</option>
                                        <option value="3" {{$ivp->payment_type==3?'selected':''}}>Fund Transfer</option>
                                        <option value="4" {{$ivp->payment_type==4?'selected':''}}>Online Pay</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Bank Name</label>
                                    <input type="text" name="bank_name" onchange="paymethod()" class="form-control po_bank error-msg" value="{{ $ivp->bank_name }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">PO No</label>
                                    <input type="text" name="po_no" onchange="paymethod()" onblur="checkDuplicatePo(this)" class="form-control po_num error-msg" value="{{ $ivp->po_no }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">PO Date</label>
                                    <input type="date" name="po_date" onchange="paymethod()" class="form-control po_date error-msg" value="{{ $ivp->po_date }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Pay Date</label>
                                    <input type="date" value="{{ $ivp->pay_date }}" name="pay_date" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Receive Date</label>
                                    <input type="date" name="rcv_date" class="form-control" value="{{ $ivp->rcv_date }}">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Deposit Date</label>
                                    <input type="date" name="deposit_date" class="form-control" value="{{ $ivp->deposit_date }}">
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control">{{ $ivp->remarks }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" id="buttonDisable" class="btn btn-info">Update</button>
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
    // function paymethod(){
    //     let pmethod = document.querySelector('select[name="payment_type"]').value;
    //     let poBank = $('.po_bank').val();
    //     let poNo = $('.po_num').val();
    //     let poDate = $('.po_date').val();
    //     var errorMessage = $('.error-msg').next('.error-message');
    //     if(pmethod == 2){
    //         if(poNo == '' || poDate == '' || poBank == ''){
    //             errorMessage.text('This field is required').css('color', 'red').show();
    //             $('#buttonDisable').attr('disabled',true)
    //             $('.po_bank').attr('required',true)
    //             $('.po_num').attr('required',true)
    //             $('.po_num').attr('required',true)
    //         }else{
    //             errorMessage.hide();
    //             $('#buttonDisable').removeAttr('disabled',false)
    //             $('.po_bank').attr('required',false)
    //             $('.po_num').attr('required',false)
    //             $('.po_num').attr('required',false)
    //         }
    //     }else{
    //         errorMessage.hide();
    //         $('.po_bank').val('')
    //         $('.po_num').val('')
    //         $('.po_date').val('');
    //         $('#buttonDisable').removeAttr('disabled',false)
    //         $('.po_bank').attr('required',false)
    //         $('.po_num').attr('required',false)
    //         $('.po_num').attr('required',false)
    //     }
    // }
    function vatcalc(v,place){
        if(place=="vat_amount"){
            let rec= $('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
            let vat= v ? parseFloat(v) : 0;
            let vamt=(rec*(vat/100));
            $('#'+place).val(vamt.toFixed(2))
        }else{
            let rec=$('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
            let vamt=v ? parseFloat(v) : 0;
            let vat=(100*(vamt/rec));
            $('#'+place).val(vat.toFixed(2))
        }
        billTotal();
    }
    function aitcalc(v,place){
        if(place=="ait_amount"){
            let rec= $('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
            let ait= v ? parseFloat(v) : 0;
            let aamt=(rec*(ait/100));
            $('#'+place).val(aamt.toFixed(2))
        }else{
            let rec=$('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
            let aamt=v ? parseFloat(v) : 0;
            let ait=(100*(aamt/rec));
            $('#'+place).val(ait.toFixed(2))
        }
        billTotal();
    }

    function billTotal(){
        let dueAmount = $('#totalDue').val() ? parseFloat($('#totalDue').val()) : 0;
        let received = $('#received_amount').val() ? parseFloat($('#received_amount').val()) : 0;
        let vatDeduct = $('#vat_amount').val() ? parseFloat($('#vat_amount').val()) : 0;
        let aitDeduct = $('#ait_amount').val() ? parseFloat($('#ait_amount').val()) : 0;
        let fineDeduct = $('#fine_deduction').val() ? parseFloat($('#fine_deduction').val()) : 0;
        let lessPaidHonor = $('#less_paid_honor').val() ? parseFloat($('#less_paid_honor').val()) : 0;
        let paidByClient = $('#paid_by_client').val() ? parseFloat($('#paid_by_client').val()) : 0;
        let lessPaid = parseFloat(dueAmount) - (parseFloat(received) + parseFloat(vatDeduct) + parseFloat(aitDeduct) + parseFloat(fineDeduct) + parseFloat(lessPaidHonor) + parseFloat(paidByClient));
       console.log(dueAmount);
       console.log(received);
       console.log(vatDeduct);
       console.log(aitDeduct);
       console.log(fineDeduct);
       console.log(lessPaidHonor);
       console.log(paidByClient);
        $('#less_paid').val(lessPaid);
    }
    function paymethod(){
        let pmethod = document.querySelector('select[name="payment_type"]').value;
        let poBank = $('.po_bank').val();
        let poNo = $('.po_num').val();
        let poDate = $('.po_date').val();
        var errorMessage = $('.error-msg').next('.error-message');
        if(pmethod == 2 || pmethod == 4){
            if(poNo == '' || poDate == '' || poBank == ''){
                errorMessage.text('This field is required').css('color', 'red').show();
                $('#buttonDisable').attr('disabled',true)
            }else{
                errorMessage.hide();
                $('#buttonDisable').removeAttr('disabled',false)
            }
        }else{
            errorMessage.hide();
            // $('.po_bank').val('')
            //$('.po_num').val('')
            $('.po_date').val('');
            $('#buttonDisable').removeAttr('disabled',false)
        }
    }
    function checkDuplicatePo(e){
        var po = $(e).val();
        if(po != ''){
            $.ajax({
                url:"{{ route('checking_duplicate_po') }}",
                type: "GET",
                dataType: "json",
                data: { 'po_no':po,},
                success: function(data) {
                    //console.log(data);
                    if (data.length > 0) {
                        // Construct the message
                        var message = "<span style='border-bottom: solid 2px; color: yellow;'>Duplicate Po found:</span><br>";
                        $.each(data, function(index, po) {
                        message +=  "Customer: " + po.customer_name + (po.customer_branch ? ', ' + po.customer_branch : '') + "<br>" +
                                    "Receive Amount: " + po.receive + "<br>";
                        });
                        toastr.success(message);
                    } else {
                        toastr.info("No duplicate po found");
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An error occurred while processing your request.";
                    toastr.error(errorMessage);
                }
            });
        }
    }
</script>

@endpush
