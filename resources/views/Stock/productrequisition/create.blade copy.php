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
                                            <label for="product_qty">Qty</label>
                                            <input required class="form-control" type="text" name="product_qty" value="" placeholder="Product Qty">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Id</label>
                                            <input required class="form-control" type="text" name="employee_id" value="" placeholder="Employee Id">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Product Type</label>
                                            <select name="type" class="form-control @error('hours') is-invalid @enderror" id="hours">
                                                <option value="1">Intact</option>
                                                <option value="2">Used</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="issue_date">Issue Date</label>
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
