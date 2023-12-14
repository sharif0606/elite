@extends('layout.app')
@section('pageTitle',trans('Product Damage List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="row pb-1">
                    <div class="col-10">
                        <form action="" method="get">
                            <div class="row">
                                <div class="input-group input-group-sm d-flex justify-content-between" >
                                    <div class="d-flex" style="width: 350px;">
                                        <select required class="form-select product_id select2" id="product_id" name="product_id">
                                            <option value="">Select Product</option>
                                            @forelse ($product as $pr)
                                            <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <div class="input-group-append" style="margin-left: 6px;">
                                            <button type="submit" class="btn btn-info">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                        <div class="input-group-append" style="margin-left: -2px;">
                                            <a class="btn btn-warning ms-2" href="{{route('productdamage.index')}}" title="Clear"><i class="bi bi-arrow-clockwise"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="float-end" href="{{route('productdamage.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                    </div>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Size')}}</th>
                                <th scope="col">{{__('Qty')}}</th>
                                <th scope="col">{{__('Entry Date')}}</th>
                                <th scope="col">{{__('Type')}}</th>
                                {{--  <th class="white-space-nowrap">{{__('Action') }}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($damage as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->product?->product_name}}</td>
                                <td>{{$d->size?->name}}</td>
                                <td>{{$d->product_qty}}</td>
                                <td>{{$d->entry_date}}</td>
                                <td>@if ($d->type==2) Used @else New @endif</td>
                                {{--  <td class="white-space-nowrap">
                                    <a href="{{route('productdamage.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $d->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $d->id }}" action="{{ route('productdamage.destroy', encryptor('encrypt', $d->id)) }}" method="post">
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
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Row?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
