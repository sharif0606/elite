@extends('layout.app')
@section('pageTitle',trans('Deduction Medical List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                <a class="btn btn-sm btn-primary float-end" href="{{route('deduction_asign.create')}}"><i class="bi bi-plus-square"></i></a>
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
                                <th scope="col">{{__('Employee ID')}}</th>
                                <th scope="col">{{__('Medical')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deductions as $p)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->employee?->bn_applicants_name}}</td>
                                <td>{{$p->employee?->admission_id_no}}</td>
                                <td>{{$p->medical}}</td>
                                <td></td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">No Data Found</th>
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
