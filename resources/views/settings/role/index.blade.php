@extends('layout.app')
@section('title',trans('Role'))
@section('page',trans('List'))
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- table bordered -->
            <div class="table-responsive"><div>
                <a class="float-end" href="{{route('role.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
            </div>
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th scope="col">{{__('#SL')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Identity')}}</th>
                            <th class="white-space-nowrap">{{__('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                        <tr class="text-center">
                            <td scope="row">{{ ++$loop->index }}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->identity}}</td>
                            <td class="white-space-nowrap">
                                <a href="{{route('role.edit',encryptor('encrypt',$p->id))}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{route('permission.list',encryptor('encrypt',$p->id))}}">
                                    <i class="bi bi-unlock"></i>
                                </a>
                                <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <form id="form{{$p->id}}" action="{{route('role.destroy',encryptor('encrypt',$p->id))}}" method="post">
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
            </div>
        </div>
    </div>
</div>
@endsection
