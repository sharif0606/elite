@extends('layout.auth')

@section('content')
<!-- <h1 class="auth-title">Login</h1> -->
@if(Session::has('response'))
    {!!Session::get('response')['message']!!}
@endif
<form action="{{route('login.check')}}" method="post">
    @csrf
    <div class="form-group position-relative has-icon-left mb-3">
        <input name="PhoneNumber" value="{{old('PhoneNumber')}}" type="text" class="form-control form-control-sm" placeholder="Email">
        <div class="form-control-icon">
            <i class="bi bi-envelope"></i>
        </div>
        @if($errors->has('PhoneNumber'))
            <small class="d-block text-danger">
                {{$errors->first('PhoneNumber')}}
            </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <input type="password" name="password" id="pass_log_id" class="form-control form-control-sm" placeholder="Password">
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <div class="form-control-icon2" style="position:absolute; bottom:4px; right:10px">
            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
        </div>
        @if($errors->has('password'))
            <small class="d-block text-danger">
                {{$errors->first('password')}}
            </small>
        @endif
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Login</button>
</form>
<div class="text-center mt-3 text-lg fs-4">
    <!-- <p class="text-gray-600 m-0">Don't have an account? <a href="{{route('register')}}" class="font-bold">Sign
            up</a>.</p> -->
    <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
</div>

<script>
    $(document).on('click', '.toggle-password', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#pass_log_id");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
</script>
@endsection
