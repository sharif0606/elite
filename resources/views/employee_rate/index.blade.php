@extends('layout.app')
@section('pageTitle','Employee Rate List')
@section('pageSubTitle','All Rate Employee')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('employeeRate.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center bg-primary text-white">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emRate as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">{{$e->customer?->name}}</td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job Post</th>
                                        <th>Houres</th>
                                        <th>Rate</th>
                                        <th>OT-Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{$de->jobpost?->name }}</td>
                                        <td>@if($de->hours==1) 8 Hour's @else 12 Hour's @endif</td>
                                        <td>{{ $de->duty_rate }}</td>
                                        <td>{{ $de->ot_rate }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('employeeRate.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('employeeRate.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
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
                {{--  {{$empasin->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
