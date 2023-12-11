@extends('layout.landing')

@section('pageTitle',trans('Change Password'))
@section('pageSubTitle',trans('Change Password'))
@push('styles')
<style>
    .form-group,form-control{
        font-size: 14px;;
    }
</style>
@endpush

@section('content')
@include('layout.nav.user')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form" style="margin:30px 0px">
    <div class="container">
        <div class="row match-height" style="background:#eee;">
            <div class="col-12">
            <h4>Change Password</h4>
                <form class="form" method="post" action="{{route('change_password.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="oldpassword">Old Password</label>
                                <input type="password" id="oldpassword" class="form-control" name="oldpassword">
                                @if($errors->has('oldpassword'))
                                <span class="text-danger"> {{ $errors->first('oldpassword') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password">
                                @if($errors->has('password'))
                                <span class="text-danger"> {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" id="cpassword" class="form-control" name="cpassword">
                                @if($errors->has('cpassword'))
                                <span class="text-danger"> {{ $errors->first('cpassword') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary me-1 mb-1">Save</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection
