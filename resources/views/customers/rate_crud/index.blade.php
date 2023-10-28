@extends('layout.app')
@section('pageTitle','Rate List')
@section('pageSubTitle','List')
@section('content')
    <section class="section"><!-- Bordered table start -->
        <div class="row">
            <h4 class="text-center m-0">{{ $customerName->name }}</h4>
        </div>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="row pb-1">
                        <div class="col-12">
                            <a class="btn btn-sm btn-primary float-end" href="{{route('customer.rateCreateScreen')}}?customer_id={{$customer_id}}"><i class="bi bi-plus-square"></i> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive"><!-- table bordered -->
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Job Post')}}</th>
                                    <th scope="col">{{__('Rate')}}</th>
                                    <th scope="col">{{__('Ot Rate')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($crate as $index=>$data)
                                <tr>
                                    <th scope="row">{{++$index}}</th>
                                    <td>{{$data->jobpost?->name}}</td>
                                    <td>{{$data->rate}}</td>
                                    <td>{{$data->ot_rate}}</td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route('customerbrance.edit',encryptor('encrypt',$data->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $data->id }})">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <form id="form{{ $data->id }}" action="{{ route('customerbrance.destroy', encryptor('encrypt', $data->id)) }}" method="post">
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
        if (confirm("Are you sure you want to delete this Shop?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
