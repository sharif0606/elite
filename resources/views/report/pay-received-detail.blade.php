@extends('layout.app')
@section('pageTitle','Payment Received Details')
@section('pageSubTitle','pay detail')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row mb-2">
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Payment Date</label>
                        <input type="date" class="form-control" name="pay_date">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Receive Date</label>
                        <input type="date" class="form-control" name="rec_date">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Deposit Date</label>
                        <input type="date" class="form-control" name="deposit_date">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">PO Date</label>
                        <input type="date" class="form-control" name="po_date">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">PO NO</label>
                        <input type="text" class="form-control" name="po_no" placeholder="Po number">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" placeholder="bank name">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Payment Method</label>
                        <select name="payment_type" class="form-select" >
                            <option value="">Select</option>
                            <option value="1">Cash</option>
                            <option value="2">Pay Order</option>
                            <option value="3">Fund Transfer</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 ps-0 ">
                    <div class="form-group d-flex" style="margin-top: 1.3rem;">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-warning ms-2" href="{{route('report.payment_receive_detail',$customer->id)}}" title="Clear">Clear</a>
                   </div>
                </div>
            </div>
        </form>
        <div class="text-center">
            <h5 class="m-0">Customer wise received details</h5>
            <p class="m-0 p-0">{{$customer->name}}</p>
            <span>{{$customer->zone?->name}}</span>
        </div>
        <!-- table bordered -->
        {{-- <div class="text-end">
            <button type="button" class="btn btn-sm btn-info" onclick="printDiv('result_show')">Print</button>
        </div> --}}
        <div class="table-responsive" id="result_show">
            <table class="table table-bordered mb-0">
                @php
                    $vatAmountTotal = 0;
                    $aitAmountTotal = 0;
                    $fineAmountTotal = 0;
                    $receiveTotal = 0;
                @endphp
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Payment Date')}}</th>
                        <th scope="col">{{__('Received Date')}}</th>
                        <th scope="col">{{__('Deposit Date')}}</th>
                        <th scope="col">{{__('PO Date')}}</th>
                        <th scope="col">{{__('PO No')}}</th>
                        <th scope="col">{{__('Payment Method')}}</th>
                        <th scope="col">{{__('Bank')}}</th>
                        <th scope="col">{{__('VAT')}}</th>
                        <th scope="col">{{__('Vat Amount')}}</th>
                        <th scope="col">{{__('AIT')}}</th>
                        <th scope="col">{{__('AIT Amount')}}</th>
                        <th scope="col">{{__('Fine Deduction')}}</th>
                        <th scope="col">{{__('Received Amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $e)
                     <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->pay_date}}</td>
                        <td>{{$e->rcv_date}}</td>
                        <td>{{$e->deposit_date}}</td>
                        <td>{{$e->po_date}}</td>
                        <td>{{$e->po_no}}</td>
                        <td>
                            @if ($e->payment_type == 1)
                                Cash
                            @elseif ($e->payment_type == 2)
                                Pay Order
                            @else
                                Fund Transfer
                            @endif
                        </td>
                        <td>{{$e->bank_name}}</td>
                        <td>{{$e->vat}}</td>
                        <td>{{$e->vat_amount}}</td>
                        <td>{{$e->ait}}</td>
                        <td>{{$e->ait_amount}}</td>
                        <td>{{$e->fine_deduction}}</td>
                        <td>{{$e->received_amount}}</td>
                    </tr>
                    @php
                        $vatAmountTotal += $e->vat_amount;
                        $aitAmountTotal += $e->ait_amount;
                        $fineAmountTotal += $e->fine_deduction;
                        $receiveTotal += $e->received_amount;
                    @endphp
                    @empty
                    <tr>
                        <th colspan="14" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th colspan="9" class="text-center">Total</th>
                        <th>{{$vatAmountTotal}}</th>
                        <th></th>
                        <th>{{$aitAmountTotal}}</th>
                        <th>{{$fineAmountTotal}}</th>
                        <th>{{$receiveTotal}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection