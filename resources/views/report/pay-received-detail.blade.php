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
                        <label for="">From Date</label>
                        <input type="date" class="form-control" value="{{ request('fdate')}}" name="fdate">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">To Date</label>
                        <input type="date" class="form-control" value="{{ request('tdate')}}" name="tdate">
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
                        <label for="">Payment Method</label>
                        <select name="payment_type" class="form-select" >
                            <option value="">Select</option>
                            <option value="1">Cash</option>
                            <option value="2">Pay Order</option>
                            <option value="3">Fund Transfer</option>
                            <option value="4">Online Pay</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Customer Branch</label>
                        <select name="branch_id" class="select2 form-select">
                            <option value="">Select Branch</option>
                            @foreach ($branch as $b)
                                <option value="{{$b->id}}" {{request('branch_id')== $b->id? 'selected' : ''}}>{{$b->brance_name}}</option>
                            @endforeach
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
        
        <!-- table bordered -->
        <div class="text-end">
            <button type="button" class="btn btn-sm btn-info" onclick="printDiv('result_show')">Print</button>
            <button type="button" class="btn btn-sm btn-success my-1" onclick="get_print()"><i class="bi bi-filetype-xlsx"></i> Excel</button>
        </div>
        <div class="table-responsive" id="result_show">
            <div class="text-center">
                <h5 class="m-0">Customer wise received details</h5>
                <p class="m-0 p-0">{{$customer->name}}</p>
                <span>{{$customer->zone?->name}}</span>
            </div>
            <table id="paymentTable" class="table table-bordered mb-0">
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
                        <th scope="col">{{__('Branch')}}</th>
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
                        <td>{{ !is_null($e->pay_date) ? date('d-M-Y', strtotime($e->pay_date)) : '' }}</td>
                        <td>{{ !is_null($e->rcv_date) ? date('d-M-Y', strtotime($e->rcv_date)) : '' }}</td>
                        <td>{{ !is_null($e->deposit_date) ? date('d-M-Y', strtotime($e->deposit_date)) : '' }}</td>
                        <td>{{ !is_null($e->po_date) ? date('d-M-Y', strtotime($e->po_date)) : '' }}</td>
                        <td>{{$e->po_no}}</td>
                        <td>
                            @if ($e->payment_type == 1)
                                Cash
                            @elseif ($e->payment_type == 2)
                                Pay Order
                            @elseif ($e->payment_type == 3)
                                Fund Transfer
                            @elseif ($e->payment_type == 4)
                                Online Pay
                            @else
                            @endif
                        </td>
                        <td>{{$e->invoice?->branch?->brance_name}}</td>
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
<div class="full_page"></div>
<div id="my-content-div" class="d-none"></div>
@endsection
@push('scripts')
<script src="{{ asset('/assets/js/tableToExcel.js') }}"></script>
<script>
    function exportReportToExcel(tableId, filename) {
        let table = document.getElementById(tableId);
        let tableToExport = table.cloneNode(true);

        TableToExcel.convert(tableToExport, {
            name: `${filename}.xlsx`,
            sheet: {
                name: 'Payment'
            }
        });

        $("#my-content-div").html("");
        $('.full_page').html("");
    }
    function get_print() {
        $('.full_page').html('<div style="background:rgba(0,0,0,0.5);width:100vw; height:100vh;position:fixed; top:0; left;0"><div class="loader my-5"></div></div>');

        $.get("{{route('report.payment_receive_detail',$customer->id)}}{{ ltrim(Request()->fullUrl(),Request()->url()) }}", function (data) {
            $("#my-content-div").html(data);
        }).then(function () {
            // Export all columns
            exportReportToExcel('paymentTable', 'Payment of-{{$customer->name}}');
        });
    }
</script>
@endpush