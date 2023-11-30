@extends('layout.app')

@section('pageTitle',trans('Product Stock In'))
@section('pageSubTitle',trans('Create'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route(currentUser().'.product_stockin.store')}}" enctype="multipart/form-data">
                            @csrf
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Product')}}</th>
                                                <th scope="col">{{__('Size')}}</th>
                                                <th scope="col">{{__('Qty')}}</th>
                                                <th scope="col">{{__('Entry Date')}}</th>
                                                <th scope="col">{{__('Type')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="stockEntry">
                                            <tr>
                                                <td>
                                                    <select class="form-select product_id" id="product_id" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse ($product as $pr)
                                                        <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select size_id" id="size_id" name="size_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse ($size as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="product_qty[]" value="" placeholder="product_qty"></td>
                                                <td><input required class="form-control" type="date" name="entry_date[]" value="" placeholder="Entry Date"></td>
                                                <td>
                                                    <select name="type[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
                                                        <option value="1">Intact</option>
                                                        <option value="2">Used</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
    function addRow(){
    var row=`
    <tr>
        <td>
            <select class="form-select product_id" id="product_id" name="product_id[]">
                <option value="">Select Product</option>
                @forelse ($product as $pr)
                <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                @empty
                @endforelse
            </select>
        </td>
        <td>
            <select class="form-select size_id" id="size_id" name="size_id[]">
                <option value="">Select Product</option>
                @forelse ($size as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @empty
                @endforelse
            </select>
        </td>
        <td><input class="form-control" type="text" name="product_qty[]" value="" placeholder="product_qty"></td>
        <td><input required class="form-control" type="date" name="entry_date[]" value="" placeholder="Entry Date"></td>
        <td>
            <select name="type[]" class="form-control @error('hours') is-invalid @enderror" id="hours">
                <option value="1">Intact</option>
                <option value="2">Used</option>
            </select>
        </td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
            {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
        </td>
    </tr>
    `;
        $('#stockEntry').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }

</script>

@endpush
