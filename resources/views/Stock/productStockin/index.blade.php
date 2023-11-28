@extends('layout.app')
@section('pageTitle',trans('Product Stock In List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <div>
                    <a class="float-end" href="{{route(currentUser().'.product_stockin.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
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
                            @forelse($stockin as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->product?->product_name}}</td>
                                <td>{{$d->size?->name}}</td>
                                <td>{{$d->product_qty}}</td>
                                <td>{{$d->entry_date}}</td>
                                <td>@if ($d->type==2) Used @else Intact @endif</td>
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
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Row?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
