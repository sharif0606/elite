@extends('layout.app')
@section('pageTitle','Guards List')
@section('pageSubTitle','All Guards')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('guard.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer Name')}}</th>
                        {{--  <th scope="col">{{__('Job Post')}}</th>
                        <th scope="col">{{__('Qty')}}</th>
                        <th scope="col">{{__('Rate')}}</th>
                        <th scope="col">{{__('Start Date')}}</th>
                        <th scope="col">{{__('End Date')}}</th>  --}}
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guards as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->customer?->name}}</td>
                        <td>
                            <a href="{{route('guard.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        {{--  <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->customer?->name}}</td>
                        <td>{{$e->contact}}</td>
                        <td>
                            <strong>Name:</strong> {{$e->contact_person}}<br/>
                            <strong>Contact:</strong> {{$e->contact_number}}
                        </td>
                        <td>{{$e->address}}</td>
                        <td class="d-flex">
                            <a href="{{route('guard.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>  --}}
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{--  {{$guards->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
