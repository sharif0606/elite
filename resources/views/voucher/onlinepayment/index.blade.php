@extends('layout.app')
@section('pageTitle',trans('Member Payment List'))
@section('pageSubTitle',trans('Member Payment List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Date')}}</th>
                                <th scope="col">{{__('Member')}}</th>
                                <th scope="col">{{__('txnid')}}</th>
                                <th scope="col">{{__('Pay Amount')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $cr)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{date('d M,Y',strtotime($cr->created_at))}}</td>
                                <td>{{$cr->member?->given_name}} {{$cr->member?->surname}}</td>
                                <td>{{$cr->txnid}}</td>
                                <td>{{$cr->amount}}</td>
                                <td class="white-space-nowrap">
                                    <a title="accept" href="{{route('admin.onlinepayment.update_status',[encryptor('encrypt',$cr->id),3])}}">
                                        <i class="bi bi-check-circle"></i> Accept
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