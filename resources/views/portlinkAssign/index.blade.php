@extends('layout.app')
@section('pageTitle','Portlink Assign List')
@section('pageSubTitle','Portlink Assign')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row mb-2">
                <div class="col-lg-3 col-sm-6">
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
                <div class="col-lg-2 col-sm-6 ps-0 ">
                    <div class="form-group d-flex">
                        <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                        <a class="btn btn-sm btn-danger ms-2" href="{{route('portlinkAssaign.index')}}" title="Clear">Clear</a>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-6">
                    <!-- Empty div to push the link to the right side -->
                </div>
                <div class="col-lg-2 col-sm-6 d-flex justify-content-end align-items-center">
                    <a class="text-danger" href="{{route('portlinkAssaign.create', ['role' =>currentUser()])}}">
                        <i class="bi bi-plus-square-fill" style="font-size: 1.7rem;"></i>
                    </a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empasin as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">
                            {{$e->customer?->name}}
                        </td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job Post</th>
                                        <th>Qty</th>
                                        <th>Hour</th>
                                        <th>Rate</th>
                                        <th>Commission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{$de->jobpost?->name }}
                                            @if($de->atms?->atm )
                                            (ATM: {{ $de->atms?->atm }})
                                            @endif
                                            </td>
                                        <td>{{ $de->qty }}</td>
                                        <td>{{ $de->hours_emp?->hour }}</td>
                                        <td>{{ $de->rate }}</td>
                                        <td>{{ $de->commission }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            {{-- <a href="{{route('portlinkAssaign.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a> --}}
                            <a href="{{route('portlinkAssaign.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $e->id }})">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" action="{{ route('portlinkAssaign.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="4" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                 {{$empasin->withQueryString()->links()}} 
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
