@extends('layout.app')

@section('pageTitle',trans('Invoice Payment Update'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .last-receive, .last-po, .due-details {
        position: relative;
        display: inline-block;
    }

    .last-amount, .last-ponum {
        display: none;
        position: absolute;
        left: 10px;
        top: 100%;
        margin-top: 3px;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        padding: 10px;
        list-style: none;
        z-index: 1;
        width: max-content;
    }
    
    .modal-body .select2{

    }

    .due-amount {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 3px;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        padding: 10px;
        list-style: none;
        z-index: 1;
        width: max-content;
    }
    .last-receive:hover .last-amount {
        display: block;
    }
    .last-po:hover .last-ponum {
        display: block;
    }
    .due-details:hover .due-amount {
        display: block;
    }

</style>
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
                                <input type="hidden" id="customer_id" name="customer_id" value="{{$ivp->invoice?->customer_id}}">
                                <input type="hidden" id="branch_id" name="branch_id" value="{{$ivp->invoice?->branch_id}}">
                                <input type="hidden" id="zone_id" name="zone_id" value="{{$ivp->invoice?->zone_id}}">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Customer Name: {{ $ivp->customer?->name }} @if ($ivp->invoice?->branch?->brance_name != ''), {{ $ivp->invoice?->branch?->brance_name }} @endif</th>
                                                <th> 
                                                    Billable Amount: <span class="text-danger">{{ money_format(($ivp->invoice?->grand_total + $paidFromThisId) - $totalPaid->total_sum)}}</span>
                                                    <span class="due-details text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                                        <ul class="due-amount">
                                                            <li>Sub Total: 
                                                                @if ($ivp->invoice?->vat_switch != 1)
                                                                    <span>{{$ivp->invoice?->total_tk}}</span>
                                                                @else
                                                                    <span>{{$ivp->invoice?->sub_total_amount}}</span>
                                                                @endif
                                                            </li>
                                                            <li>Vat: <span>{{$ivp->invoice?->vat_taka}}</span></li>
                                                        </ul>
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Received Amount</label>
                                    <span class="last-receive text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                        @php
                                            $months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                        @endphp
                                        <ul class="last-amount" id="receivedAmountsList">
                                            <li><b>Last 3 Receive Amounts</b></li>
                                            @foreach ($lastRec as $monthIndex => $received_amount)
                                                <li>{{ $months[$monthIndex] }} {{ $received_amount }}</li>
                                            @endforeach
                                        </ul>
                                    </span>
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
                                    <input type="text" id="paid_by_client" onkeyup="billTotal(); aitcalc(this.value,'ait_amount');"  name="paid_by_client" value="{{ $ivp->paid_by_client }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Discount</label>
                                    <input type="text" id="less_paid_honor" onkeyup="billTotal();" name="less_paid_honor" value="{{ $ivp->less_paid_honor }}" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Less Paid</label>
                                    <input type="text" id="less_paid" name="less_paid" value="{{ $ivp->less_paid }}" class="form-control error-less-paid" readonly>
                                    <span class="error-message-less-paid" style="color: red; display: none;"></span>
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
                                    <label for="">Deposit Bank</label>
                                    <input type="text" name="deposit_bank" onchange="paymethod()" value="{{ $ivp->deposit_bank }}" class="form-control deposit_bank error-msg-deposit">
                                    <span class="error-message-deposit" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Bank Name</label>
                                    <input type="text" name="bank_name" onchange="paymethod()" class="form-control po_bank error-msg" value="{{ $ivp->bank_name }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-2">
                                    <label for="">PO No</label>
                                    <span class="last-po text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                        <ul class="last-ponum" id="receivedPoNumber">
                                            <li><b>Last 3 Po Number</b></li>
                                            @foreach ($lasPo as $p)
                                                <li>{{ $months[$p->month] }} {{ $p->po_no }}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                    <input type="text" name="po_no" onchange="paymethod()" onblur="checkDuplicatePo(this)" class="form-control po_num error-msg" value="{{ $ivp->po_no }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-2">
                                    <label for="">PO Date</label>
                                    <input type="date" name="po_date" onchange="paymethod()" class="form-control po_date error-msg" value="{{ $ivp->po_date }}">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-2">
                                    <label for="">Pay Date</label>
                                    <input type="date" value="{{ $ivp->pay_date }}" name="pay_date" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Receive Date</label>
                                    <input type="date" name="rcv_date" onchange="paymethod()" class="form-control receive_date error-msg-rec" value="{{ $ivp->rcv_date }}">
                                    <span class="error-message-rec" style="color: red; display: none;"></span>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Deposit Date</label>
                                    <input type="date" name="deposit_date" onchange="paymethod()" class="form-control deposit_date error-msg-deposit" value="{{ $ivp->deposit_date }}">
                                    <span class="error-message-deposit" style="color: red; display: none;"></span>
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
    // function aitcalc(v,place){
    //     if(place=="ait_amount"){
    //         let rec= $('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
    //         let ait= v ? parseFloat(v) : 0;
    //         let aamt=(rec*(ait/100));
    //         $('#'+place).val(aamt.toFixed(2))
    //     }else{
    //         let rec=$('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
    //         let aamt=v ? parseFloat(v) : 0;
    //         let ait=(100*(aamt/rec));
    //         $('#'+place).val(ait.toFixed(2))
    //     }
    //     billTotal();
    // }
    function aitcalc(v,place){
        let paidByClient = $('#paid_by_client').val() ? parseFloat($('#paid_by_client').val()) : 0;
        if(paidByClient > 0){
            if(place=="ait_amount"){
                let recBefore= $('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
                let ait= $('#ait').val() ? parseFloat($('#ait').val()) : 0;
                let rec= parseFloat(recBefore) - parseFloat(paidByClient);
                let aamt=(rec*(ait/100));
                $('#ait_amount').val(aamt.toFixed(2))
            }else{
                let recBefore= $('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
                let aamt= $('#ait_amount').val() ? parseFloat($('#ait_amount').val()) : 0;
                let rec= parseFloat(recBefore) - parseFloat(paidByClient);
                let ait=(100*(aamt/rec));
                $('#ait').val(ait.toFixed(2))
            }
        }else{
            if(place=="ait_amount"){
                let rec=$('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
                let ait= $('#ait').val() ? parseFloat($('#ait').val()) : 0;
                let aamt=(rec*(ait/100));
                $('#ait_amount').val(aamt.toFixed(2))
            }else{
                let rec=$('#subAmountInput').val() ? parseFloat($('#subAmountInput').val()) : 0;
                let aamt= $('#ait_amount').val() ? parseFloat($('#ait_amount').val()) : 0;
                let ait=(100*(aamt/rec));
                $('#ait').val(ait.toFixed(2))
            }
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
        $('#less_paid').val(lessPaid.toFixed(2));
        console.log(dueAmount);
        less_paid_amount();
    }
    function paymethod(){
        let pmethod = document.querySelector('select[name="payment_type"]').value;
        let poBank = $('.po_bank').val();
        let poNo = $('.po_num').val();
        let poDate = $('.po_date').val();
        let depositBank = $('.deposit_bank').val();
        let depositDate = $('.deposit_date').val();
        let receiveDate = $('.receive_date').val();
        var errorMessage = $('.error-msg').next('.error-message');
        var errorMessageDeposit = $('.error-msg-deposit').next('.error-message-deposit');
        var recErrorMessage = $('.error-msg-rec').next('.error-message-rec');
        if(pmethod == 2){
                errorMessageDeposit.hide();
                recErrorMessage.hide();
            if(poNo == '' || poDate == '' || poBank == ''){
                errorMessage.text('This field is required').css('color', 'red').show();
                $('#buttonDisable').attr('disabled',true)
            }else{
                errorMessage.hide();
                $('#buttonDisable').removeAttr('disabled',false)
            }
        }else if(pmethod == 4 || pmethod == 3){
                errorMessage.hide();
                recErrorMessage.hide();
            if(depositBank == '' || depositDate == ''){
                errorMessageDeposit.text('This field is required').css('color', 'red').show();
                $('#buttonDisable').attr('disabled',true)
            }else{
                errorMessageDeposit.hide();
                $('#buttonDisable').removeAttr('disabled',false)
            }
        }else{
            if(receiveDate == ''){
                recErrorMessage.text('This field is required').css('color', 'red').show();
                $('#buttonDisable').attr('disabled',true)
            }else{
                recErrorMessage.hide();
                $('#buttonDisable').removeAttr('disabled',false)
            }
            errorMessage.hide();
            errorMessageDeposit.hide();
            // $('.po_bank').val('')
            //$('.po_num').val('')
            $('.po_date').val('');
            //$('#buttonDisable').removeAttr('disabled',false)
        }
    }

    function less_paid_amount(){
        let lessPaid =$('#less_paid').val() ? parseFloat($('#less_paid').val()) : 0;
        var errorMessage = $('.error-less-paid').next('.error-message-less-paid');
        if(lessPaid < 0){
            errorMessage.text('Positive value or 0 required').css('color', 'red').show();
            $('#buttonDisable').attr('disabled',true)
        }else{
            errorMessage.hide();
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
