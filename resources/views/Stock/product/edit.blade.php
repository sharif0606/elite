@extends('layout.app')

@section('pageTitle',trans('Update Product'))
@section('pageSubTitle',trans('Update'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('product.update',encryptor('encrypt',$product->id))}}">
                                @csrf
                                @method('PATCH')
                                {{--  <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$product->id)}}">  --}}
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="category_id">Category<span class="text-danger">*</span></label>
                                            <select class="form-control form-select" name="category_id" id="category_id">
                                                <option value="">Select category</option>
                                                @forelse($category as $d)
                                                    <option value="{{$d->id}}" {{ old('category_id',$product->category_id)==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No category found</option>
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
                                            <input type="text" id="product_name" class="form-control" value="{{ old('product_name',$product->product_name)}}" name="product_name">
                                            @if($errors->has('product_name'))
                                                <span class="text-danger"> {{ $errors->first('product_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="product_name_bn">Product Bangla</label>
                                            <input type="text" id="product_name_bn" class="form-control" value="{{ old('product_name_bn',$product->product_name_bn)}}" name="product_name_bn">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="2">{{ $product->description }}</textarea>
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
