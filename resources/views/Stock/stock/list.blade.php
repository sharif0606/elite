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
                                {{--  <th scope="col">{{__('Type')}}</th>  --}}
                                {{--  <th class="white-space-nowrap">{{__('Action') }}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $d)
                            <tr class="text-center">
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->product?->product_name}}</td>
                                <td>{{$d->size?->name}}</td>
                                {{--  <td>@if ($d->type==2) Used @else Intact @endif</td>  --}}
                                {{--  <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.product_stockin.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $d->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $d->id }}" action="{{ route(currentUser().'.product_stockin.destroy', encryptor('encrypt', $d->id)) }}" method="post">
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
@endsection
