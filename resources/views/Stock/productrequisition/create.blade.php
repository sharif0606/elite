@extends('layout.app')

@section('pageTitle',trans('Product Requisition'))
@section('pageSubTitle',trans('Create'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route(currentUser().'.requisition.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Id</label>
                                            {{--  <input required class="form-control" type="text" name="employee_id" value="" placeholder="Employee Id">  --}}
                                            <select required class="form-select employee_id select2" id="employee_id" name="employee_id">
                                                <option value="">Select Employee</option>
                                                @forelse ($employee as $em)
                                                <option value="{{ $em->id }}">{{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if($errors->has('employee_id'))
                                                <span class="text-danger"> {{ $errors->first('employee_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label- for="note">{{__('Issue Date')}}</label->
                                            <input required class="form-control" type="date" name="issue_date" value="" placeholder="Issue Date">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea name="note" id="note" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-2 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">{{__('Product')}}</th>
                                                    <th scope="col">{{__('Size')}}</th>
                                                    <th scope="col">{{__('Qty')}}</th>
                                                    <th scope="col">{{__('Type')}}</th>
                                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="requisition">
                                                <tr>
                                                    <td>
                                                        <select required class="form-select product_id" id="product_id" name="product_id[]">
                                                            <option value="">Select Product</option>
                                                            @forelse ($product as $pr)
                                                            <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @if($errors->has('product_id'))
                                                            <span class="text-danger"> {{ $errors->first('product_id') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select required class="form-select size_id" id="size_id" name="size_id[]">
                                                            <option value="">Select Product</option>
                                                            @forelse ($size as $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @if($errors->has('size_id'))
                                                            <span class="text-danger"> {{ $errors->first('size_id') }}</span>
                                                        @endif
                                                    </td>
                                                    <td><input required class="form-control" type="text" name="product_qty[]" value="" placeholder="Product Qty"></td>
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
            <select required class="form-select product_id" id="product_id" name="product_id[]">
                <option value="">Select Product</option>
                @forelse ($product as $pr)
                <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                @empty
                @endforelse
            </select>
            @if($errors->has('product_id'))
                <span class="text-danger"> {{ $errors->first('product_id') }}</span>
            @endif
        </td>
        <td>
            <select required class="form-select size_id" id="size_id" name="size_id[]">
                <option value="">Select Product</option>
                @forelse ($size as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @empty
                @endforelse
            </select>
            @if($errors->has('size_id'))
                <span class="text-danger"> {{ $errors->first('size_id') }}</span>
            @endif
        </td>
        <td><input required class="form-control" type="text" name="product_qty[]" value="" placeholder="Product Qty"></td>
        <td>
            <select name="type[]" class="form-control @error('type') is-invalid @enderror" id="type">
                <option value="1">Intact</option>
                <option value="2">Used</option>
            </select>
        </td>
        <td>
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
            {{--<span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>--}}
        </td>
    </tr>
    `;
        $('#requisition').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }

</script>

@endpush
