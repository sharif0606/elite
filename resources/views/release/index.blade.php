@extends('layout.app')
@section('pageTitle',trans('Release List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                    <a class="btn btn-sm btn-primary float-end" href="{{route('relEmployee.create')}}"><i class="bi bi-plus-square"></i></a>
                </div>
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Employee Name')}}</th>
                                <th scope="col">{{__('Resign Date')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->employee?->bn_applicants_name}}({{$d->employee?->admission_id_no}})</td>
                                <td>{{$d->resign_date}}</td>
                                <td>
                                    <a href="{{route('long_loan.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
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
    </div>
</section>
@endsection