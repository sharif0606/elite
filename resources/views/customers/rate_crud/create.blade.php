@extends('layout.app')
@section('pageTitle','Add Rate ')
@section('pageSubTitle','New Rate ')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('customerRate.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h4 class="text-center m-0">{{ $cbran->name }}</h4>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="ot_rate">Job Post</label>
                            <select class="form-select" id="job_post_id" name="job_post_id">
                                <option value="">Select Post</option>
                                @forelse ($jobpost as $job)
                                <option value="{{ $job->id }}">{{ $job->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <input type="hidden" name="customer_id" value="{{$cbran->id}}">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="number" id="rate" value="{{old('rate')}}" class="form-control" placeholder="Rate" name="rate">
                        </div>
                    </div>
                    {{--  <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="ot_rate">OT-Rate</label>
                            <input type="number" id="ot_rate" value="{{old('ot_rate')}}" class="form-control" placeholder="Ot Rate" name="ot_rate">
                        </div>
                    </div>  --}}
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
