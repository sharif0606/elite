@extends('layout.app')

@section('pageTitle',trans('Create Product'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('product.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="category_id">Category<span class="text-danger">*</span></label>
                                            <select class="form-control form-select" name="category_id" id="category_id">
                                                <option value="">Select Category</option>
                                                @forelse($category as $cat)
                                                    <option value="{{$cat->id}}" {{ old('category_id')==$cat->id?"selected":""}}> {{ $cat->name_bn}}</option>
                                                @empty
                                                    <option value="">No Category found</option>
                                                @endforelse
                                            </select>
                                            @if($errors->has('category_id'))
                                                <span class="text-danger"> {{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="product_name">Product Name<span class="text-danger">*</span></label>
                                            <input type="text" id="product_name" class="form-control" value="{{ old('product_name')}}" name="product_name">
                                            @if($errors->has('product_name'))
                                                <span class="text-danger"> {{ $errors->first('product_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="product_name_bn">Product Bangla</label>
                                            <input type="text" id="product_name_bn" class="form-control" value="{{ old('product_name_bn')}}" name="product_name_bn">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            {{--  <input type="text" id="description" class="form-control" value="{{ old('description')}}" name="">  --}}
                                            <textarea name="description" id="description" class="form-control" rows="2"></textarea>
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
