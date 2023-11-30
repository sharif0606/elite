@extends('layout.app')
@section('pageTitle','Invoice List')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <div>
            <a class="btn btn-sm btn-primary float-end my-2" href="{{route('invoiceGenerate.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
        </div>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr class="bg-primary text-white">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Start Date')}}</th>
                        <th scope="col">{{__('End Date')}}</th>
                        <th scope="col">{{__('Bill Date')}}</th>
                        <th scope="col">{{__('Grand Total')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{ $e->customer?->name }}</td>
                        <td>{{ $e->start_date }}</td>
                        <td>{{ $e->end_date }}</td>
                        <td>{{ $e->bill_date }}</td>
                        <td>{{ $e->grand_total }}</td>
                        <td>
                            <a href="{{route('invoiceGenerate.show',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{--  <a href="{{route('invoiceGenerate.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
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
                {{--  {{$guards->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
