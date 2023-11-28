@extends('layout.app')
@section('pageTitle',trans('Product Requisition List'))
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
                    <a class="float-end" href="{{route(currentUser().'.requisition.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                {{--  <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Size')}}</th>
                                <th scope="col">{{__('Qty')}}</th>  --}}
                                <th scope="col">{{__('Employee Id')}}</th>
                                <th scope="col">{{__('Entry Date')}}</th>
                                {{--  <th scope="col">{{__('Type')}}</th>  --}}
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisition as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                {{--  <td>{{$d->product?->product_name}}</td>
                                <td>{{$d->size?->name}}</td>
                                <td>{{$d->product_qty}}</td>  --}}
                                <td>{{$d->employee?->bn_applicants_name}}</td>
                                <td>{{$d->issue_date}}</td>
                                {{--  <td>@if ($d->type==2) Used @else Intact @endif</td>  --}}
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.requisition.show',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{--  <a href="{{route(currentUser().'.requisition.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>  --}}
                                    {{--  <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $d->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>  --}}
                                    <form id="form{{ $d->id }}" action="{{ route(currentUser().'.requisition.destroy', encryptor('encrypt', $d->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No Data Found</th>
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
