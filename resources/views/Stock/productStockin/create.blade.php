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
                            <form class="form" method="post" action="{{route('product_stockin.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="product_id">Product<span class="text-danger">*</span></label>
                                            <select required class="form-select product_id" id="product_id" name="product_id">
                                                <option value="">Select Product</option>
                                                @forelse ($product as $pr)
                                                <option value="{{ $pr->id }}">{{ $pr->product_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if($errors->has('product_id'))
                                                <span class="text-danger"> {{ $errors->first('product_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="size_id">Product Size<span class="text-danger">*</span></label>
                                            <select required class="form-select size_id" id="size_id" name="size_id">
                                                <option value="">Select Product</option>
                                                @forelse ($size as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if($errors->has('size_id'))
                                                <span class="text-danger"> {{ $errors->first('size_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="entry_date">Qty</label>
                                            <input required class="form-control" type="text" name="product_qty" value="" placeholder="Product Qty">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="type">Product Type</label>
                                            <select name="type" class="form-control @error('hours') is-invalid @enderror" onclick="getEmployee()" id="type">
                                                <option value="1">New</option>
                                                <option value="2">Used</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 d-none employee_id" id="employee_id">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Id</label>
                                            <select class="form-select" name="employee_id">
                                                <option value="">Select Employee</option>
                                                @forelse ($employee as $em)
                                                <option value="{{ $em->id }}">{{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="entry_date">Entry Date</label>
                                            <input required class="form-control" type="date" name="entry_date" value="" placeholder="Entry Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

                                    </div>
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
        function getEmployee() {
            var Type = document.querySelector('select[name="type"]').value;
            if (Type === "2") {
                $('.employee_id').removeClass('d-none');
            } else {
                $('.employee_id').addClass('d-none');
            }
        }
    </script>
@endpush
