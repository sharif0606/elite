@extends('layout.app')
@section('pageTitle','Empoyees Attendance List')
@section('pageSubTitle','All Attendance')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <div>
            <a class="btn btn-sm btn-primary float-end my-2" href="{{route('customerduty.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
        </div>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr class="bg-primary text-white">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customerduty as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">{{$e->customer?->name}}</td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Job Post</th>
                                        <th>Duty Rate</th>
                                        <th>Duty Qty</th>
                                        <th>Duty Amount</th>
                                        <th>Ot Rate</th>
                                        <th>Ot Qty</th>
                                        <th>Ot Amount</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
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
