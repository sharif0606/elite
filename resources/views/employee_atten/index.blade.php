@extends('layout.app')
@section('pageTitle','Empoyees Attendance List')
@section('pageSubTitle','All Attendance')
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('empatten.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Details')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empatten as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>
                            {{--  @if ($e->details)
                            <span><strong>Job Post:</strong> {{$de->jobpost?->name }}</span>
                            <span><strong>Qty:</strong> {{ $de->qty }}</span>
                            <span><strong>Rate:</strong> {{ $de->rate }}</span><br/>
                            @endif  --}}
                        </td>
                        <td>
                            <a href="{{route('empatten.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('empatten.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
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
                {{--  {{$guards->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
