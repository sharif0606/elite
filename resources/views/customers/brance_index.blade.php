@extends('layout.app')
@section('pageTitle','Brance Details List')
@section('pageSubTitle','List')
@section('content')
    <section class="section"><!-- Bordered table start -->
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="row pb-1">
                        <div class="col-12">
                            <a class="btn btn-sm btn-primary float-end" href="{{route('customer.createScreen')}}?customer_id={{$customer_id}}"><i class="bi bi-plus-square"></i> Add</a>
                        </div>
                    </div>

                    <div class="table-responsive"><!-- table bordered -->
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Brance Name')}}</th>
                                    <th scope="col">{{__('Contact Person Name')}}</th>
                                    <th scope="col">{{__('Contact Phone')}}</th>
                                    <th scope="col">{{__('Billing Person Name')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cbrance as $index=>$data)
                                <tr>
                                    <th scope="row">{{++$index}}</th>
                                    <td>{{$data->brance_name}}</td>
                                    <td>{{$data->contact_persone}}</td>
                                    <td>{{$data->contact_phone}}</td>
                                    <td>{{$data->billing_person_name}}</td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route('customerbrance.edit',encryptor('encrypt',$data->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
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
