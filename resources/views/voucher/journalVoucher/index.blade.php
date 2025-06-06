@extends('layout.app')
@section('pageTitle',trans('Journal Voucher List'))
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
                    <a class="float-end" href="{{route('journal_voucher.create')}}" style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Voucher No')}}</th>
                                <th scope="col">{{__('Date')}}</th>
                                <th scope="col">{{__('Pay Name')}}</th>
                                <th scope="col">{{__('Purpose')}}</th>
                                <th scope="col">{{__('Amount')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($journalVoucher as $cr)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$cr->voucher_no}}</td>
                                <td>{{date('d/m,Y',strtotime($cr->current_date))}}</td>
                                <td>{{$cr->pay_name}}</td>
                                <td>{{$cr->purpose}}</td>
                                <td>{{$cr->debit_sum}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('journal_voucher.edit',encryptor('encrypt',$cr->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if(currentUser() == 'superadmin' )
                                        <a class="text-danger" href="javascript:void()" onclick="$('#form{{$cr->id}}').submit()">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <form id="form{{$cr->id}}" onsubmit="return confirm('Are you sure to delete this record?')" action="{{route('journal_voucher.destroy',encryptor('encrypt',$cr->id))}}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="7" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{$journalVoucher->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection