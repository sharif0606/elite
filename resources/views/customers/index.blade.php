@extends('layout.app')
@section('pageTitle','Customer List')
@section('pageSubTitle','All Customer')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row mb-2">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <select name="customer_id" class="select2 form-select" onchange="getBranch(this);">
                            <option value="">Select Customer</option>
                            @forelse ($customer as $d)
                            <option value="{{$d->id}}" {{ request('customer_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                            @empty
                            <option value="">No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <select class="form-control" name="received_by_city" required>
                            <option value="">Received By</option>
                            <option value="1">Ctg</option>
                            <option value="2">Head Office</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 ps-0 ">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-danger ms-2" href="{{route('customer.index')}}" title="Clear">Clear</a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <!-- Empty div to push the link to the right side -->
                </div>
                <div class="col-lg-2 col-sm-6 d-flex justify-content-end align-items-center">
                    <a class="text-danger" href="{{route('customer.create', ['role' =>currentUser()])}}">
                        <i class="bi bi-plus-square-fill" style="font-size: 1.7rem;"></i>
                    </a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                {{-- <a class="btn btn-sm btn-primary float-end my-2" href="{{route('customer.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a> --}}
                <thead>
                    <tr>
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Received By')}}</th>
                        <th scope="col">{{__('Contact')}}</th>
                        {{-- <th scope="col">{{__('Contact Person')}}</th> --}}
                        {{-- <th scope="col">{{__('Address')}}</th> --}}
                        <th scope="col">{{__('Zone')}}</th>
                        <th class="white-space-nowrap" width="80px">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $e)
                    <tr>
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->name}}</td>
                        <td>
                            @if($e->received_by_city == 1) Ctg  @endif
                            @if($e->received_by_city == 2) Head Office @endif
                        </td>
                        <td>{{$e->contact}}</td>
                        {{-- <td>
                            <strong>Name:</strong> {{$e->contact_person}}<br />
                        <strong>Contact:</strong> {{$e->contact_number}}
                        </td> --}}
                        {{-- <td>{{$e->address}}</td> --}}
                        <td>{{$e->zone?->name}}</td>
                        <td class="d-flex">
                            <a class="mx-1" href="{{route('customer.show',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a class="mx-1" href="{{route('customer.edit',[encryptor('encrypt',$e->id),'page' => request('page', 1)])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="mx-1" title="Branch" href="{{route('customerbrance.index')}}?customer_id={{encryptor('encrypt',$e->id)}}">
                                <i class="bi bi-list"></i>
                            </a>
                            <a class="mx-1" title="Rate" href="{{route('customerRate.index')}}?customer_id={{encryptor('encrypt',$e->id)}}">
                                <i class="bi bi-aspect-ratio"></i>
                            </a>
                            <a class="text-danger mx-1" href="javascript:void(0)" onclick="confirmDelete({{ $e->id }})">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" action="{{ route('customer.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                            {{-- <a class="btn btn-sm btn-primary float-end ms-2" href="{{route('securityGuards',encryptor('encrypt',$e->id))}}">
                            Certificate
                            </a> --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="5" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{$data->links()}}
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