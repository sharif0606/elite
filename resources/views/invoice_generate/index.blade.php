@extends('layout.app')
@section('pageTitle','Invoice List')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('invoiceGenerate.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <button type="button" class="btn btn-sm btn-primary float-end my-2 mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-plus-square"></i> Add Different</button>
                {{--  <a class="btn btn-sm btn-primary float-end my-2 mx-2" href="{{route('wasaEmployeeAsign.createInvoice')}}"><i class="bi bi-plus-square"></i> Add Wasa</a>  --}}
                <thead>
                    <tr class="text-center">
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
                        <td>{{ $e->customer?->name }}
                            @if($e->branch_id)
                            ({{ $e->branch?->brance_name }})
                            @endif
                        </td>
                        <td>{{ $e->start_date }}</td>
                        <td>{{ $e->end_date }}</td>
                        <td>{{ $e->bill_date }}</td>
                        <td>{{ $e->grand_total }}</td>
                        <td>
                            <a href="{{route('invoiceGenerate.show',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{--  <a href="{{route('invoiceGenerate.edit',[encryptor('encrypt',$e->id)])}}">
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="{{route('wasaEmployeeAsign.createInvoice')}}">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Wasa or One Trip</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                {{--  <label for=""><b>Customer Name</b></label>  --}}
                <select required class="form-select customer_id" id="customer_id" name="customer_id" onchange="getBranch(this)">
                    <option value="">Select Customer</option>
                    @forelse ($customer as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @empty
                    @endforelse
                </select>
                <br/>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Go</button>
              </div>
              <div class="modal-footer">
                <a class="btn btn-sm btn-primary my-2" href="{{route('oneTripInvoice.create')}}"><i class="bi bi-plus-square"></i> One Trip</a>
              </div>
        </form>
    </div>
  </div>
</div>
@endsection
