@extends('layout.app')
@section('pageTitle','Update Customer ')
@section('pageSubTitle','Edit Customer ')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('customer.update', [encryptor('encrypt',$customer->id),'role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <h5 class="text-center m-0">Customer details</h5>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input type="text" id="name" value="{{old('name',$customer->name)}}" class="form-control" placeholder="Customer Name" name="name">
                        </div>
                    </div>
                    {{--  <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="brance_name">Brance Name</label>
                            <input type="text" id="brance_name" value="{{old('brance_name',$customer->brance_name)}}" class="form-control @error('brance_name') is-invalid @enderror" placeholder="Brance Name" name="brance_name">
                            @if($errors->has('brance_name'))
                                <span class="text-danger"> {{ $errors->first('brance_name') }}</span>
                            @endif
                        </div>
                    </div>  --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input type="text" id="contact" value="{{old('contact',$customer->contact)}}" class="form-control" placeholder="Contact Number" name="contact">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="file_upload_name">File Upload Name</label>
                            <input type="text" id="file_upload_name" value="{{old('file_upload_name',$customer->file_upload_name)}}" class="form-control" placeholder="" name="file_upload_name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{--  <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact_person">Contact Person Name</label>
                            <input type="text" id="contact_person" value="{{old('contact_person',$customer->contact_person)}}" class="form-control" placeholder="Contact Person" name="contact_person">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact_number">Contact Mobile No.</label>
                            <input type="text" id="contact_number" value="{{old('contact_number',$customer->contact_number)}}" class="form-control" placeholder="Contact Mobile no." name="contact_number">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="billing_person">Billing Person Name</label>
                            <input type="text" id="billing_person" value="{{old('billing_person',$customer->billing_person)}}" class="form-control" placeholder="Billing Person Name" name="billing_person">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="agreement_date">Agreement Date</label>
                            <input type="date" id="agreement_date" value="{{old('agreement_date',$customer->agreement_date)}}" class="form-control" placeholder="" name="agreement_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="renew_date">Renew Date</label>
                            <input type="date" id="renew_date" value="{{old('renew_date',$customer->renew_date)}}" class="form-control" placeholder="" name="renew_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="validity_date">Validity Date</label>
                            <input type="date" id="validity_date" value="{{old('validity_date',$customer->validity_date)}}" class="form-control" placeholder="" name="validity_date">
                        </div>
                    </div>  --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="file_upload">Upload File</label>
                            <input type="file" id="file_upload" value="{{old('file_upload')}}" class="form-control" placeholder="" name="file_upload">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="bin">Bin</label>
                            <input type="text" id="bin" value="{{old('bin',$customer->bin)}}" class="form-control" placeholder="Bin" name="bin">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input type="text" id="invoice_number" value="{{old('invoice_number',$customer->invoice_number)}}" class="form-control" placeholder="Invoice Number" name="invoice_number">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" rows="5" placeholder="Full Address" name="address">{{old('address',$customer->address)}}</textarea>
                        </div>
                    </div>
                    {{--  <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="billing_address">Billing Address</label>
                            <textarea class="form-control" id="billing_address" rows="5" placeholder="Billing Address" name="billing_address">{{old('billing_address',$customer->billing_address)}}</textarea>
                        </div>
                    </div>  --}}
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" value=""  data-height="110" data-default-file="{{ asset('uploads/logo') }}/{{ $customer->logo }}" class="form-control dropify">
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    /* call on load page */
    $(document).ready(function(){
        $('.district').hide();
        $('.upazila').hide();
    })

    function show_upazila(e){
         $('.district').hide();
         $('.district'+e).show();
    }
    function show_unions(e){
         $('.upazila').hide();
         $('.upazila'+e).show();
    }


</script>

<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush
