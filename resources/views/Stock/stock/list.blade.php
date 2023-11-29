@extends('layout.app')
@section('pageTitle',trans('Product Stock List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Size')}}</th>
                                <th scope="col">{{__('Qty')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $d)
                            <tr class="text-center">
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->product_name}}</td>
                                <td>{{$d->name}}</td>
                                <td>{{$d->qty}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.stock.individual',encryptor('encrypt',$d->product_id))}}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
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
@endsection
