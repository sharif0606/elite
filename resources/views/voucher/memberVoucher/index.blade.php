@extends('layout.app')
@section('pageTitle',trans('Member Voucher List'))
@section('pageSubTitle',trans('Member Voucher List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div>
                    <a class="float-end" href="{{route('member_voucher.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
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
                            @forelse($memberVoucher as $cr)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$cr->voucher_no}}</td>
                                <td>{{date('d/m,Y',strtotime($cr->current_date))}}</td>
                                <td>{{$cr->pay_name}}</td>
                                <td>{{$cr->purpose}}</td>
                                <td>{{$cr->debit_sum}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('member_voucher.edit',encryptor('encrypt',$cr->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="7" class="text-center">No Data Found</th>
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