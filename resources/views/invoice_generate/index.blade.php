@extends('layout.app')
@section('pageTitle','Invoice List')
@section('pageSubTitle','All Invoice')
@section('content')
<style>
    .last-receive, .due-details {
        position: relative;
        display: inline-block;
    }

    .last-amount {
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
    .due-details:hover .due-amount {
        display: block;
    }

</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('invoiceGenerate.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <button type="button" class="btn btn-sm btn-primary float-end my-2 mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-plus-square"></i> Add Different</button>
                {{--  <a class="btn btn-sm btn-primary float-end my-2 mx-2" href="{{route('wasaEmployeeAsign.createInvoice')}}"><i class="bi bi-plus-square"></i> Add Wasa</a>  --}}
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Start Date')}}</th>
                        <th scope="col">{{__('End Date')}}</th>
                        <th scope="col">{{__('Bill Date')}}</th>
                        <th scope="col">{{__('Grand Total')}}</th>
                        <th scope="col">{{__('Due')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($invoice as $e)
                        @php $due=($e->grand_total - ($e->payment->sum('received_amount') + $e->payment->sum('vat_amount') + $e->payment->sum('ait_amount') + $e->payment->sum('fine_deduction'))); @endphp
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{ $e->customer?->name }}
                            @if($e->branch_id)
                            ({{ $e->branch?->brance_name }})
                            @endif
                        </td>
                        <td>{{ $e->start_date }}</td>
                        <td>{{ $e->end_date }}</td>
                        <td>{{ $e->bill_date }}</td>
                        <td>{{ $e->grand_total }}</td>
                        <td>{{ $due }}</td>
                        <td>
                            <a href="{{route('invoiceGenerate.show',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{--  <a href="{{route('invoiceGenerate.edit',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>  --}}
                            @if ($due > 0)
                            @php
                                $d=App\Models\Crm\InvoicePayment::select(DB::raw("sum(received_amount) as `received_amount`"),DB::raw("YEAR(pay_date) year, MONTH(pay_date) month"))->groupby("year","month")->where("customer_id", $e->customer_id)->latest()->take(3)->pluck("received_amount","month");
                            @endphp
                                <button class="btn p-0 m-0" type="button" style="background-color: none; border:none;"
                                    data-bs-toggle="modal" data-bs-target="#invList"
                                    data-inv-id="{{ $e->id }}"
                                    data-zone-id="{{ $e->zone_id }}"
                                    data-customer-name="{{ $e->customer?->name }}"
                                    data-customer-id="{{ $e->customer?->id }}"
                                    data-sub-total-amount="{{ $e->sub_total_amount }}"
                                    data-vat-amount="{{ $e->vat_taka }}"
                                    data-total-amount="{{ $due }}"
                                    data-received-amounts='@json($d)'>
                                    <span class="text-danger"><i class="bi bi-currency-dollar" style="font-size:1rem; color:rgb(246, 50, 35);"></i></span>
                                </button>
                            @endif
                            
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                 {{$invoice->links()}} 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="invList" tabindex="-1" role="dialog" aria-labelledby="balanceTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form method="post" id="invUpdate"  action="{{route('invoice-payment.store')}}">
            @csrf
            <div class="modal-content">
                <div class="modal-header py-1">
                    <h5 class="modal-title" id="batchTitle">Collection</h5>
                    <button type="button" class="close text-danger" data-bs-dismiss="modal"  aria-label="Close">
                        <i class="bi bi-x-lg" style="font-size: 1.5rem;"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inv_id" name="invId">
                    <input type="hidden" id="customer_id" name="customer_id">
                    <input type="hidden" id="zone_id" name="zone_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="bg-light">
                                        <th>Customer Name:</th>
                                        <td id="name"></td>
                                        <th>
                                            Due Amount:
                                            
                                        </th>
                                        <td id="totalAmount"></td>
                                        <td><span class="due-details text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                            <ul class="due-amount">
                                                <li>Sub Total: <span id="subAmount"></span><input id="subAmountInput" type="hidden"></li>
                                                <li>Vat: <span id="vatAmount"></span> </li>
                                            </ul>
                                        </span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Received Amount</label>
                            <span class="last-receive text-info fs-4 px-2"><i class="bi bi-info-circle-fill"></i>
                                <ul class="last-amount" id="receivedAmountsList"></ul>
                            </span>
                            <input type="text" id="received_amount" name="received_amount" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">VAT</label>
                            <input type="text" onkeyup="vatcalc(this.value,'vat_amount')" id="vat" name="vat" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">VAT Deduction</label>
                            <input type="text" onkeyup="vatcalc(this.value,'vat')" id="vat_amount" name="vat_amount" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">AIT</label>
                            <input type="text" onkeyup="aitcalc(this.value,'ait_amount')" id="ait"  name="ait" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">AIT Deduction</label>
                            <input type="text" onkeyup="aitcalc(this.value,'ait')" id="ait_amount"  name="ait_amount" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">Fine Deduction</label>
                            <input type="text"  name="fine_deduction" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">Payment Mode</label>
                            <select name="payment_type" class="form-control" onchange="paymethod()">
                                <option value="1">Cash</option>
                                <option value="2">Pay Order</option>
                                <option value="3">Fund Transfer</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Bank Name</label>
                            <input type="text" name="bank_name" onchange="paymethod()" class="form-control po_bank error-msg">
                            <span class="error-message" style="color: red; display: none;"></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="">PO No</label>
                            <input type="text" name="po_no" onchange="paymethod()" class="form-control po_num error-msg">
                            <span class="error-message" style="color: red; display: none;"></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="">PO Date</label>
                            <input type="date" name="po_date" onchange="paymethod()" class="form-control po_date error-msg">
                            <span class="error-message" style="color: red; display: none;"></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Pay Date</label>
                            <input type="date" value="{{date('Y-m-d')}}" name="pay_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">Receive Date</label>
                            <input type="date" name="rcv_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="">Deposit Date</label>
                            <input type="date" name="deposit_date" class="form-control">
                        </div>
                        <div class="col-sm-12">
                            <label for="">Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" id="buttonDisable" class="btn btn-sm btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="{{route('wasaEmployeeAsign.createInvoice')}}">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Wasa or One Trip</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                {{--  <label for=""><b>Customer Name</b></label>  --}}
                <select required class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                    <option value="">Select Customer</option>
                    @forelse ($customer as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @empty
                    @endforelse
                </select>
                <br/>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Go</button>
              </div>
              <div class="modal-footer">
                <a class="btn btn-sm btn-primary my-2" href="{{route('oneTripInvoice.create')}}"><i class="bi bi-plus-square"></i> One Trip</a>
              </div>
        </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
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
    }
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
            }else{
                errorMessage.hide();
                $('#buttonDisable').removeAttr('disabled',false)
            }
        }else{
            errorMessage.hide();
            $('.po_bank').val('')
            $('.po_num').val('')
            $('.po_date').val('');
            $('#buttonDisable').removeAttr('disabled',false)
        }
    }
    // $(document).ready(function () {
    //     $('#invList').on('show.bs.modal', function (event) {
    //         var button = $(event.relatedTarget);
    //         var invId = button.data('inv-id');
    //         var cusName = button.data('customer-name');
    //         var cusID = button.data('customer-id');
    //         var zone = button.data('zone-id');
    //         var Amount = button.data('total-amount');
    //         // Set the values in the modal
    //         var modal = $(this);
    //         modal.find('#inv_id').val(invId);
    //         modal.find('#name').text(cusName);
    //         modal.find('#customer_id').val(cusID);
    //         modal.find('#zone_id').val(zone);
    //         modal.find('#totalAmount').text(Amount);
    //     });
    // });
    $(document).ready(function () {
    $('#invList').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var invId = button.data('inv-id');
        var cusName = button.data('customer-name');
        var cusID = button.data('customer-id');
        var zone = button.data('zone-id');
        var Amount = button.data('total-amount');
        var subAmount = button.data('sub-total-amount');
        var vatAmount = button.data('vat-amount');
        var receivedAmounts = button.attr('data-received-amounts');
        // Try to parse the received amounts
        var amountsArray = [];
        try {
            amountsArray = JSON.parse(receivedAmounts);
        } catch (e) {
            console.error("Error parsing received amounts: ", e);
        }
        
        // amountsArray = amountsArray.filter(function(amount) {
        //     return amount !== null && amount !== '';
        // });

        // Set the values in the modal
        var modal = $(this);
        modal.find('#inv_id').val(invId);
        modal.find('#name').text(cusName);
        modal.find('#customer_id').val(cusID);
        modal.find('#zone_id').val(zone);
        modal.find('#totalAmount').text(Amount);
        modal.find('#subAmount').text(subAmount);
        modal.find('#subAmountInput').val(subAmount);
        modal.find('#vatAmount').text(vatAmount);

        var receivedAmountsList = modal.find('#receivedAmountsList');
        receivedAmountsList.empty(); // Clear any existing items
        let month=new Array("","January","February","March","April","May","June","July","August","September","October","November","December");
        if (Object.keys(amountsArray).length > 0) {
            receivedAmountsList.append('<li><strong>Last 3 Received Amounts:</strong></li>');
            Object.entries(amountsArray).forEach(function(k) {
                receivedAmountsList.append('<li>' + month[k[0]] +'--'+k[1] + '</li>');
            });
        } else {
            receivedAmountsList.append('<li>No recent received amounts available.</li>');
        }
    });
});

</script>
@endpush
