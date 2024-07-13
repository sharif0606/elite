@extends('layout.app')
@section('pageTitle','List')
@section('pageSubTitle','Wasa Assign Employee')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('wasaEmployeeAsign.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Month')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wasaemployee as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">{{$e->customer?->name}}</td>
                        <td scope="row">{{ date('M-Y', strtotime($e->end_date)) }}</td>
                        <td>
                            @if ($e->details)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Rank</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    <tr>
                                        <td>{{ $de->employee?->admission_id_no }}</td>
                                        <td>{{ $de->employee_name }}</td>
                                        <td>{{$de->jobpost?->name }}</td>
                                        <td>{{ $de->salary_amount }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            {{-- <a href="{{route('wasaEmployeeAsign.show',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a> --}}
                            <a href="{{route('wasaEmployeeAsign.edit',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $e->id }})">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" action="{{ route('wasaEmployeeAsign.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
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
                {{--  {{$empasin->links()}}  --}}
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
