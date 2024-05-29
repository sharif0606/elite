@extends('layout.app')
@section('pageTitle','Empoyees Attendance List')
@section('pageSubTitle','All Attendance')
@section('content')
<style>
    .th_color {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-striped">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('customerduty.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center">
                        <th class="th_color" scope="col">{{__('#SL')}}</th>
                        <th class="th_color" scope="col">{{__('Customer')}}</th>
                        <th class="th_color" scope="col">{{__('Details')}}</th>
                        <th class="th_color">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customerduty as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row"><span><b>{{$e->customer?->name}}</b></span><br>
                            <span>{{ date('d-M-Y', strtotime($e->start_date)) }} <b>to</b> {{ date('d-M-Y', strtotime($e->end_date)) }}</span><br>
                            <span>{{$e->customer_branch?->brance_name}}</span></td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr style="background-color: rgb(166, 166, 207) !important;">
                                        <th style=" color: rgb(15, 15, 15) !important;">Employee ID</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Employee</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Job Post</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Rate</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Qty</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Duty Amount</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Ot Rate</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Ot Qty</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Ot Amount</th>
                                        <th style=" color: rgb(15, 15, 15) !important;">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{$de->employee?->admission_id_no }}</td>
                                        <td>{{$de->employee?->bn_applicants_name }}</td>
                                        <td>{{$de->jobpost?->name }}</td>
                                        <td>{{ $de->duty_rate }}</td>
                                        <td>{{ $de->duty_qty }}</td>
                                        <td>{{ $de->duty_amount }}</td>
                                        <td>{{ $de->ot_rate }}</td>
                                        <td>{{ $de->ot_qty }}</td>
                                        <td>{{ $de->ot_amount }}</td>
                                        <td>{{ $de->total_amount }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            {{--  <a href="{{route('customerduty.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>  --}}
                            <a href="{{route('customerduty.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
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
                {{--  {{$customerduty->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
