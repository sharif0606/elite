@extends('layout.app')
@section('pageTitle',trans('Users List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                @include('layout.message')
                <div>
                    @if(currentUser() == 'superadmin')
                    <a class="btn btn-sm btn-primary float-end" href="{{route(currentUser().'.admin.create')}}"><i class="bi bi-pencil-square"></i></a>
                    @else
                    <a class="btn btn-sm btn-primary float-end" href="{{route(currentUser().'.client.create')}}"><i class="bi bi-pencil-square"></i></a>
                    @endif
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Contact')}}</th>
                                <th scope="col">{{__('Image')}}</th>
                                <th scope="col">{{__('Role')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $p)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->name}}</td>
                                <td>{{$p->email}}</td>
                                <td>{{$p->contact_no}}</td>
                                <td><img width="50px" src="{{asset('uploads/admin/'.$p->image)}}" alt=""></td>
                                <td>{{optional($p->role)->identity}}</td>
                                <td>@if($p->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>
                                <td class="white-space-nowrap">
                                    @if(currentUser() == 'superadmin')
                                    <a href="{{route(currentUser().'.admin.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @else
                                    <a href="{{route(currentUser().'.client.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @endif
                                    @if(currentUser() == 'superadmin')
                                    <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{$p->id}}" action="{{route(currentUser().'.admin.destroy',encryptor('encrypt',$p->id))}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                    @endif
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection