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
                    <a class="float-start btn btn-sm bg-danger text-white" href="{{route('deduction_asign.index')}}">Return Index</a>
                    <a class="float-end text-danger" href="{{route('deduction_asign.deductionCreate',['deduction_id' => 8])}}"><i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i></a>
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
                                <th scope="col">{{__('Month')}}</th>
                                <th scope="col">{{__('Medical')}}</th>
                                <th scope="col">{{__('Remarks')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deductions as $p)
                            @php $mt=array("","January","February","March","April","May","June","July","August","September","October","November","December");
                                $month = $p->month;
                                $getMonth = isset($mt[$month])?$mt[$month]:0;
                            @endphp
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->employee?->bn_applicants_name}}({{$p->employee?->admission_id_no}})</td>
                                <td>{{$getMonth}}--{{$p->year}}</td>
                                <td>{{$p->medical}}</td>
                                <td>{{$p->medical_rmk}}</td>
                                <td>
                                    <a class="text-danger" href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $p->id }}" onsubmit="return confirm('Are you sure?')" action="{{ route('deduction_asign.destroy', encryptor('encrypt', $p->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="6" class="text-center">No Data Found</th>
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
