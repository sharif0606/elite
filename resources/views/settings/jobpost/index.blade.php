@extends('layout.app')
@section('pageTitle',trans('Job-Post List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <div>
                    <a class="float-end" href="{{route('jobpost.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Serial')}}</th>
                                <th scope="col">{{__('Name bn')}}</th>
                                <th scope="col">{{__('Billable')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobpost as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->name}}</td>
                                <td>{{$d->serial}}</td>
                                <td>{{$d->name_bn}}</td>
                                <td> @if($d->bill_able==0) No @else Yes @endif</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('jobpost.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a title="Description" href="{{route('jobpost.description',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form id="form{{$d->id}}" action="{{route('jobpost.destroy',encryptor('encrypt',$d->id))}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No Job-Post Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{$jobpost->withQueryString()->links()}} 
                   </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection

