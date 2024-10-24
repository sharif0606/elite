@extends('layout.app')

@section('pageTitle',trans('Product Issue(after)'))
@section('pageSubTitle',trans('Create'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('product_issue.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Name/Id</label>
                                            {{--  <input required class="form-control" type="text" name="employee_id" value="" placeholder="Employee Id">  --}}
                                            <select class="form-select employee_id select2" id="employee_id" name="employee_id">
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
                                            <label for="note">{{__('Issue Date')}}</label>
                                            <input required class="form-control datepicker" type="text" name="issue_date" id="issue_date" placeholder="dd/mm/yyy">
                                            {{--  <input required class="form-control" type="date" name="issue_date" value="" placeholder="Issue Date" >  --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea name="note" id="note" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="manual_employee_id">Manual Employee Id</label>
                                            <input class="form-control" type="text" name="manual_employee_id" value="{{ old('manual_employee_id')}}" placeholder="Manual Employee Id">
                                            @if($errors->has('manual_employee_id'))
                                                <span class="text-danger"> {{ $errors->first('manual_employee_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="bn_applicants_name">Mamual Employee Name(Bangla)</label>
                                            <input type="text" id="bn_applicants_name" value="{{old('bn_applicants_name')}}" class="form-control @error('bn_applicants_name') is-invalid @enderror" placeholder="বাংলা নাম দিন" name="bn_applicants_name">
                                            @if($errors->has('bn_applicants_name'))
                                                <span class="text-danger"> {{ $errors->first('bn_applicants_name') }}</span>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row p-2 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">{{__('Deposit Qty')}}</th>
                                                    <th scope="col">{{__('Deposit Type')}}</th>
                                                    <th scope="col">{{__('Deposite Size')}}</th>
                                                    <th scope="col">{{__('Product')}}</th>
                                                    <th scope="col">{{__('Size')}}</th>
                                                    <th scope="col">{{__('Issue/Qty')}}</th>
                                                    <th scope="col">{{__('Type')}}</th>
                                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="requisition">
                                                @forelse ($product_issue as $pe)
                                                <tr>
                                                    <td>
                                                        <input class="form-control text-center" type="text" name="deposite_product_qty[]" value="0" placeholder="Product Qty">
                                                    </td>
                                                    <td>
                                                        <select name="deposite_type[]" class="form-control @error('type') is-invalid @enderror" id="type">
                                                            <option value="2">Used</option>
                                                            <option value="1">New</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select size_id" id="deposite_size_id" name="deposite_size_id[]">
                                                            <option value="">Select Size</option>
                                                            @forelse ($size as $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @if($errors->has('size_id'))
                                                            <span class="text-danger"> {{ $errors->first('size_id') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select required class="form-select product_id" id="product_id" name="product_id[]">
                                                            <option value="">Select Product</option>
                                                            @forelse ($product as $pr)
                                                            <option value="{{ $pr->id }}" {{ old('product_id',$pe->id)==$pr->id?"selected":""}}>{{ $pr->product_name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @if($errors->has('product_id'))
                                                            <span class="text-danger"> {{ $errors->first('product_id') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select class="form-select size_id" id="size_id" name="size_id[]">
                                                            <option value="">Select Size</option>
                                                            @forelse ($size as $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @if($errors->has('size_id'))
                                                            <span class="text-danger"> {{ $errors->first('size_id') }}</span>
                                                        @endif
                                                    </td>
                                                    <td><input required class="form-control text-center" type="text" name="product_qty[]" value="1" placeholder="Product Qty"></td>
                                                    <td>
                                                        <select name="type[]" class="form-control @error('type') is-invalid @enderror" id="type">
                                                            <option value="1">New</option>
                                                            <option value="2">Used</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse
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
    <tr class="text-center">
        <td>
            <input required class="form-control text-center" type="text" name="deposite_product_qty[]" value="" placeholder="Product Qty">
        </td>
        <td>
            <select name="deposite_type[]" class="form-control @error('type') is-invalid @enderror" id="type">
                <option value="1">New</option>
                <option value="2">Used</option>
            </select>
        </td>
        <td>
            <select class="form-select size_id" id="deposite_size_id" name="deposite_size_id[]">
                <option value="">Select Size</option>
                @forelse ($size as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @empty
                @endforelse
            </select>
            @if($errors->has('deposite_size_id'))
                <span class="text-danger"> {{ $errors->first('deposite_size_id') }}</span>
            @endif
        </td>
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
                <option value="1">New</option>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
      $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
      });
    });
  </script>
@endpush
