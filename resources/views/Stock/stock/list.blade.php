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
                        <option value="{{$p->id}}" {{ request()->get('product')==$p->id?"selected":""}}>{{$p->product_name}}</option>
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
                <a href="{{route('stock.index')}}" class="btn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Reset')}}</a>

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
                                    <th scope="col" colspan="6">{{__('Stock Details')}}</th>
                                    <th class="white-space-nowrap" rowspan="2">{{__('Action') }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th scope="col" colspan="2">{{__('New')}}</th>
                                    <th scope="col" colspan="2">{{__('Used')}}</th>
                                    <th scope="col" colspan="2">{{__('Total')}}</th>
                                </tr>
                                <tr class="text-center">
                                    <th></th>
                                    <th></th>
                                    <th scope="col">{{__('In')}}</th>
                                    <th scope="col">{{__('Out')}}</th>
                                    <th scope="col">{{__('In')}}</th>
                                    <th scope="col">{{__('Out')}}</th>
                                    <th scope="col">{{__('In')}}</th>
                                    <th scope="col">{{__('Available')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product as $d)
                                <tr class="text-center">
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$d->product_name}}</td>
                                    @php
                                    $allStocks = $d->stock; // All stock for available calculation
                                    $stocks = $d->stock; // For In/Out display

                                    // Apply date filter if present
                                    if (request()->get('fdate')) {
                                        $from = request()->get('fdate');
                                        $to = request()->get('tdate') ?? date('Y-m-d');
                                        
                                        // Filter stocks for In/Out display (movements within date range)
                                        $stocks = $stocks->filter(function($stock) use ($from, $to) {
                                            $entryDate = $stock->entry_date;
                                            return $entryDate >= $from && $entryDate <= $to;
                                        });
                                        
                                        // For available stock, use all stock up to the end date
                                        $allStocks = $allStocks->filter(function($stock) use ($to) {
                                            $entryDate = $stock->entry_date;
                                            return $entryDate <= $to;
                                        });
                                    }

                                    // Calculate Stock In and Stock Out for display (within date range if filtered)
                                    // Stock In: sum of positive product_qty values (stock added)
                                    // Stock Out: absolute value of sum of negative product_qty values (stock issued)
                                    
                                    // New Stock (type = 1) - for display
                                    $newStocks = $stocks->where('type', 1);
                                    $newStockIn = $newStocks->where('product_qty', '>', 0)->sum('product_qty');
                                    $newStockOut = abs($newStocks->where('product_qty', '<', 0)->sum('product_qty'));
                                    
                                    // Used Stock (type = 2) - for display
                                    $usedStocks = $stocks->where('type', 2);
                                    $usedStockIn = $usedStocks->where('product_qty', '>', 0)->sum('product_qty');
                                    $usedStockOut = abs($usedStocks->where('product_qty', '<', 0)->sum('product_qty'));
                                    
                                    // Calculate Available Stock from ALL stock (up to end date if filtered)
                                    $allNewStocks = $allStocks->where('type', 1);
                                    $allNewStockIn = $allNewStocks->where('product_qty', '>', 0)->sum('product_qty');
                                    $allNewStockOut = abs($allNewStocks->where('product_qty', '<', 0)->sum('product_qty'));
                                    $newAvailable = max(0, $allNewStockIn - $allNewStockOut);
                                    
                                    $allUsedStocks = $allStocks->where('type', 2);
                                    $allUsedStockIn = $allUsedStocks->where('product_qty', '>', 0)->sum('product_qty');
                                    $allUsedStockOut = abs($allUsedStocks->where('product_qty', '<', 0)->sum('product_qty'));
                                    $usedAvailable = max(0, $allUsedStockIn - $allUsedStockOut);
                                    
                                    // Total Stock
                                    $totalStockIn = $newStockIn + $usedStockIn;
                                    $totalStockOut = $newStockOut + $usedStockOut;
                                    $totalAvailable = $newAvailable + $usedAvailable;
                                    @endphp
                                    <td>{{ number_format($newStockIn, 0) }}</td>
                                    <td>{{ number_format($newStockOut, 0) }}</td>
                                    <td>{{ number_format($usedStockIn, 0) }}</td>
                                    <td>{{ number_format($usedStockOut, 0) }}</td>
                                    <td>{{ number_format($totalStockIn, 0) }}</td>
                                    <td class="{{ $totalAvailable <= 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                        {{ number_format($totalAvailable, 0) }}
                                    </td>
                                    <td class="white-space-nowrap">
                                        @php
                                            $urlParams = [];
                                            if (request()->get('fdate')) {
                                                $urlParams['fdate'] = request()->get('fdate');
                                            }
                                            if (request()->get('tdate')) {
                                                $urlParams['tdate'] = request()->get('tdate');
                                            }
                                            $url = route('stock.individual', encryptor('encrypt', $d->id));
                                            if (!empty($urlParams)) {
                                                $url .= '?' . http_build_query($urlParams);
                                            }
                                        @endphp
                                        <a href="{{ $url }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="10" class="text-center">No Product Found</th>
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
