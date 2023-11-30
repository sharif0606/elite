@extends('layout.app')
@section('pageTitle','Customer List')
@section('pageSubTitle','All Customer')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div>
            <a class="btn btn-sm btn-primary float-end my-2" href="{{route('customer.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr class="bg-primary text-white">
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Contact')}}</th>
                        {{--  <th scope="col">{{__('Contact Person')}}</th>  --}}
                        <th scope="col">{{__('Address')}}</th>
                        <th class="white-space-nowrap" width="80px">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->name}}</td>
                        <td>{{$e->contact}}</td>
                        {{--  <td>
                            <strong>Name:</strong> {{$e->contact_person}}<br/>
                            <strong>Contact:</strong> {{$e->contact_number}}
                        </td>  --}}
                        <td>{{$e->address}}</td>
                        <td class="d-flex">
                            <a href="{{route('customer.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('customer.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a title="Branch" href="{{route('customerbrance.index')}}?customer_id={{encryptor('encrypt',$e->id)}}">
                                <i class="bi bi-list"></i>
                            </a>
                            <a title="Rate" href="{{route('customerRate.index')}}?customer_id={{encryptor('encrypt',$e->id)}}">
                                <i class="bi bi-aspect-ratio"></i>
                            </a>
                            <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $e->id }})">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" action="{{ route('customer.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                            {{--  <a class="btn btn-sm btn-primary float-end ms-2" href="{{route('securityGuards',encryptor('encrypt',$e->id))}}">
                                Certificate
                            </a>  --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{$customers->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Data?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
