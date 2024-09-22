@extends('layout.app')

@section('pageTitle',trans('Update Invoice Settiongs'))
@section('pageSubTitle',trans('Update'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route('invoicesetting.update',encryptor('encrypt',$invoicesettings->id))}}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$invoicesettings->id)}}">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" value="{{ old('name',$invoicesettings->name)}}" name="name">
                                            @if($errors->has('name'))
                                                <span class="text-danger"> {{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="designation">{{__('Designation')}}</label>
                                            <input type="text" id="designation" class="form-control" value="{{ old('designation',$invoicesettings->designation)}}" name="designation">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">{{__('Phone')}}</label>
                                            <input type="text" id="phone" class="form-control" value="{{ old('phone',$invoicesettings->phone)}}" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">{{__('Signature')}}<span class="text-danger ms-3">png signature for better output</span></label>
                                            <input type="file" class="form-control" value="" name="signature_img" onchange="pview(this)">
                                            <img src="{{asset('uploads/invoice/signatureImg/'.$invoicesettings->signature)}}" id="photo_p" class="my-1" width="100px" alt="">
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
@push('scripts')
<script>
	function pview(e){
		document.getElementById('photo_p').src=window.URL.createObjectURL(e.files[0]);
	}
</script>
@endpush
