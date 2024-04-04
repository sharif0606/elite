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
                <div class="table-responsive">
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
                                {{--  <td><img width="50px" src="{{asset('uploads/users/'.$p->image)}}" alt=""></td>

                                <!-- or <td>{{ $p->status == 1?"Active":"Inactive" }}</td>-->
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.users.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{$p->id}}" action="{{route(currentUser().'.users.destroy',encryptor('encrypt',$p->id))}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>  --}}
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
</section>
<!-- Bordered table end -->


@endsection
