@extends('layout.app')
@section('pageTitle','Invoice Due Report')
@section('pageSubTitle','Due')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('From Date')}}</label>
                    <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="fdate">{{__('To Date')}}</label>
                    <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="billdate">{{__('Bill Date')}}</label>
                    <input type="date" class="form-control" value="{{ request('bill_date')}}" name="bill_date">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="lcNo">{{__('Customer')}}</label>
                    <select name="customer_id" class="select2 form-select">
                        <option value="">Select</option>
                        @forelse ($customer as $d)
                            <option value="{{$d->id}}" {{ request('customer_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                        @empty
                            <option value="">No Data Found</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6 d-flex justify-content-end">
                    <button type="#" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>
                </div>
                <div class="col-6 d-flex justify-content-Start">
                    <a href="{{route('report.inv_due')}}" class="btn pbtn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Clear')}}</a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="text-end">
            <button type="button" class="btn btn-sm btn-info" onclick="printDiv('result_show')">Print</button>
        </div>
        <div class="table-responsive" id="result_show">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Start Date')}}</th>
                        <th scope="col">{{__('End Date')}}</th>
                        <th scope="col">{{__('Bill Date')}}</th>
                        <th scope="col">{{__('Grand Total')}}</th>
                        <th scope="col">{{__('Due')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalGrand=0;
                        $totalDue=0;
                    @endphp
                    @forelse($invoice as $e)
                        @php $due=($e->grand_total - ($e->payment->sum('received_amount') + $e->payment->sum('vat_amount'))); @endphp
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
                    </tr>
                    @php
                        $totalGrand +=$e->grand_total;
                        $totalDue +=$due;
                    @endphp
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th colspan="5" class="text-end">Total</th>
                        <th>{{$totalGrand}}</th>
                        <th>{{$totalDue}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

