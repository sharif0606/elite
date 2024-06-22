@extends('layout.app')
@section('pageTitle','Payment Received')
@section('pageSubTitle','payment')
@section('content')
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row mb-2">
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <select name="customer_id" class="select2 form-select">
                            <option value="">Select Customer</option>
                            @forelse ($customer as $d)
                                <option value="{{$d->id}}" {{ request('customer_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                            @empty
                                <option value="">No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <select name="zone_id" class="select2 form-select">
                            <option value="">Select zone</option>
                            @forelse ($zone as $d)
                                <option value="{{$d->id}}" {{ request('zone_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                            @empty
                                <option value="">No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <select name="customer_type" class="form-select">
                            <option value="">Customer Type</option>
                            <option value="0">Institution</option>
                            <option value="1">Bank</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 ps-0 ">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-warning ms-2" href="{{route('report.payment_receive')}}" title="Clear">Clear</a>
                   </div>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        {{-- <div class="text-end">
            <button type="button" class="btn btn-sm btn-info" onclick="printDiv('result_show')">Print</button>
        </div> --}}
        <div class="table-responsive" id="result_show">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Zone')}}</th>
                        <th scope="col">{{__('Received Amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $e)
                     <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>
                            <a href="{{route('report.payment_receive_detail',$e->customer_id)}}">
                                {{ $e->customer?->name }}
                                @if($e->branch_id)
                                ({{ $e->branch?->brance_name }})
                                @endif
                            </a>
                        </td>
                        <td>{{ $e->customer?->zone?->name }}</td>
                        <td>{{ $e->received_amount }}</td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="4" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection