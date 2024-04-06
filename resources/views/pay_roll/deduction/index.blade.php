@extends('layout.app')
@section('pageTitle',trans('Deduction Asign List'))
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
                {{--  <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Fine')}}</th>
                                <th scope="col">{{__('Mobile Bill')}}</th>
                                <th scope="col">{{__('Loan')}}</th>
                                <th scope="col">{{__('Cloth')}}</th>
                                <th scope="col">{{__('Jacket')}}</th>
                                <th scope="col">{{__('Hr')}}</th>
                                <th scope="col">{{__('CF')}}</th>
                                <th scope="col">{{__('Medical')}}</th>
                                <th scope="col">{{__('Matterss Pillow Cost')}}</th>
                                <th scope="col">{{__('Tonic Sim')}}</th>
                                <th scope="col">{{__('Over Payment')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deductions as $p)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->fine}}</td>
                                <td>{{$p->mobilebill}}</td>
                                <td>{{$p->loan}}</td>
                                <td>{{$p->cloth}}</td>
                                <td>{{$p->jacket}}</td>
                                <td>{{$p->hr}}</td>
                                <td>{{$p->c_f}}</td>
                                <td>{{$p->medical}}</td>
                                <td>{{$p->matterss_pillowCost}}</td>
                                <td>{{$p->tonic_sim}}</td>
                                <td>{{$p->over_paymentCut}}</td>
                                <td>@if($p->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No Pruduct Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>  --}}
                <div class="row p-2 mt-4">
                    <div class="col-lg-3 mt-4 p-0">
                        <a href="{{route('fineIndex')}}" class="btn btn-primary">Fine List</a>
                    </div>
                    <div class="col-lg-3 mt-4 p-0">
                        <a href="{{route('salarySheetTwo')}}" class="btn btn-primary">Salary Sheet Two</a>
                    </div>
                    <div class="col-lg-3 mt-4 p-0">
                        <a href="{{route('salarySheetThree')}}" class="btn btn-primary">Salary Sheet Three</a>
                    </div>
                    <div class="col-lg-3 mt-4 p-0">
                        <a href="{{route('salarySheetFour')}}" class="btn btn-primary">Salary Sheet Four</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection
