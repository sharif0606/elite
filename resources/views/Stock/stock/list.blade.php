@extends('layout.app')
@section('pageTitle',trans('Product Stock List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <form class="form" method="get" action="">
        <div class="row">
            <div class="col-4 py-1">
                <label for="fdate">{{__('From Date')}}</label>
                <input type="date" id="fdate" class="form-control" value="{{request()->get('fdate')}}" name="fdate">
            </div>
            <div class="col-4 py-1">
                <label for="fdate">{{__('To Date')}}</label>
                <input type="date" id="tdate" class="form-control" value="{{ request()->get('tdate')}}" name="tdate">
            </div>
            <div class="col-4 py-1">
                <label for="product">{{__('Product Name')}}</label>
                <select name="product" class="choices form-select">
                    <option value="">Select</option>
                    @forelse ($product as $p)
                        <option value="{{$p->id}}" {{ old(request()->get('product'))==$p->id?"selected":""}}>{{$p->product_name}}</option>
                    @empty
                        <option value="">No Data Found</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-6 d-flex justify-content-end">
                <button type="submit" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>

            </div>
            <div class="col-6 d-flex justify-content-Start">
                <button type="#" class="btn pbtn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Reset')}}</button>

            </div>
        </div>
        <div class="row" id="table-bordered">
            <div class="text-end">
                <button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
            </div>
            <div class="col-12">
                <div class="card" id="result_show">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" rowspan="2">{{__('#SL')}}</th>
                                    <th scope="col" rowspan="2">{{__('Product')}}</th>
                                    <th scope="col" colspan="2">{{__('Qty')}}</th>
                                    <th scope="col" rowspan="2">{{__('Total')}}</th>
                                    <th class="white-space-nowrap" rowspan="2">{{__('Action') }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th scope="col">New</th>
                                    <th scope="col">Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product as $d)
                                <tr class="text-center">
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$d->product_name}}</td>
                                    @php
                                    $stocks = $d->stock;

                                    // Apply date filter if present
                                    if (request()->get('fdate')) {
                                        $from = request()->get('fdate');
                                        $to = request()->get('tdate') ?? date('Y-m-d');

                                        $stocks = $stocks->whereBetween('entry_date', [$from, $to]);
                                    }

                                    $newQty = $stocks->where('type', 1)->sum('product_qty');
                                    $usedQty = $stocks->where('type', 2)->sum('product_qty');
                                    @endphp
                                    <td>{{ $newQty }}</td>
                                    <td>{{ $usedQty  }}</td>
                                    <td>
                                        @if(request()->get('fdate'))
                                            {{$d->stock?->whereBetween('entry_date', [request()->get('fdate'),request()->get('tdate') ?? date('Y-m-d')])->sum('product_qty')}}</td>
                                        @else
                                            {{$d->stock?->sum('product_qty')}}
                                        @endif
                                    </td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route('stock.individual',encryptor('encrypt',$d->id))}}">
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
                    {{--  <div class="my-3">
                        {!! $stock->links()!!}
                    </div>  --}}
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
