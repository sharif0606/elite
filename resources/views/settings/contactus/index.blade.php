@extends('layout.app')
@section('pageTitle',trans('Contact Us List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                @include('layout.message')
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Subject')}}</th>
                                <th scope="col">{{__('Message')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_contactus as $con)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$con->name}}</td>
                                <td>{{$con->email}}</td>
                                <td>{{$con->subject}}</td>
                                <td>{{$con->message}}</td>
                                <td class="white-space-nowrap">
                                    @if(currentUser() == 'salesexecutive' || currentUser() == 'superadmin')
                                    <!-- <a href="{{route(currentUser().'.contactus.edit',encryptor('encrypt',$con->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
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
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection