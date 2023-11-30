@extends('layout.app')
@section('pageTitle',trans('Category List'))
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
                    <a class="float-end" href="{{route(currentUser().'.category.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Name bn')}}</th>
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category as $d)
                            <tr class="text-center">
                                <td scope="row">{{ ++$loop->index }}</td>
                                <td>{{$d->name}}</td>
                                <td>{{$d->name_bn}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.category.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{--  <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $d->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $d->id }}" action="{{ route(currentUser().'.category.destroy', encryptor('encrypt', $d->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>  --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No category Found</th>
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
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Row?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
