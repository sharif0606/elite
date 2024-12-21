@extends('layout.app')
@section('title',trans('Users'))
@section('page',trans('List'))
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">

            <!-- table bordered -->
            <div class="table-responsive"><div>
                <a class="float-end" href="{{route('user.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
            </div>
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th scope="col">{{__('#SL')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Email')}}</th>
                            <th scope="col">{{__('Contact')}}</th>
                            <th scope="col">{{__('Role')}}</th>
                            <th scope="col">{{__('Image')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th class="white-space-nowrap">{{__('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                        <tr class="text-center">
                            <td scope="row">{{ ++$loop->index }}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->email}}</td>
                            <td>{{$p->contact_no_en}}</td>
                            <td>{{$p->role?->type}}</td>
                            <td><img width="50px" src="{{asset('public/uploads/users/'.$p->image)}}" alt=""></td>
                            <td>@if($p->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>
                            <!-- or <td>{{ $p->status == 1?"Active":"Inactive" }}</td>-->
                            <td class="white-space-nowrap">
                                <a href="{{route('user.edit',encryptor('encrypt',$p->id))}}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form id="form{{$p->id}}" action="{{route('user.destroy',encryptor('encrypt',$p->id))}}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="8" class="text-center">No Pruduct Found</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pt-2">
                {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
