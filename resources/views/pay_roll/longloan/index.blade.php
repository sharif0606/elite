@extends('layout.app')
@section('pageTitle',trans('Deduction Long Loan List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                    <a class="btn btn-sm btn-primary float-end" href="{{route('long_loan.create')}}"><i class="bi bi-plus-square"></i></a>
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
                                <th scope="col">{{__('Amount')}}</th>
                                <th scope="col">{{__('Purchase Date')}}</th>
                                <th scope="col">{{__('Per Installment')}}</th>
                                <th scope="col">{{__('Number Of Installment')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($longloan as $p)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->employee?->bn_applicants_name}}({{$p->employee?->admission_id_no}})</td>
                                <td>{{$p->loan_amount}}</td>
                                <td>{{$p->purchase_date}}</td>
                                <td>{{$p->perinstallment_amount}}</td>
                                <td>{{$p->number_of_installment}}</td>
                                <td class="d-flex">
                                    <a href="{{route('long_loan.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="text-danger" href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $p->id }}" onsubmit="return confirm('Are you sure?')" action="{{ route('long_loan.destroy', encryptor('encrypt', $p->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{$longloan->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->
@endsection