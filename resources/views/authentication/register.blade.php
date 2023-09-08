@extends('layout.auth')

@section('content')
<h4 class="auth-title">Sign Up</h4>
@if(Session::has('response'))
{!!Session::get('response')['message']!!}
@endif
<form action="{{route('register.store')}}" method="post">
    @csrf
    <div class="form-group position-relative has-icon-left mb-3">
        <input name="FullName" value="{{old('FullName')}}" type="text" class="form-control form-control-sm" placeholder="Full Name" required>
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
        @if($errors->has('FullName'))
        <small class="d-block text-danger">
            {{$errors->first('FullName')}}
        </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <select id="country_id" name="country_id" class="form-control form-control-sm" required>
            <option value="">Select Country</option>
            @if(count($countries))
            @foreach($countries as $c)
            <option value="{{ $c->code}}">{{$c->name}}</option>
            @endforeach
            @endif
        </select>
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
        @if($errors->has('country_id'))
        <small class="d-block text-danger">
            {{$errors->first('country_id')}}
        </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <input id="phone" name="PhoneNumber" value="{{old('PhoneNumber')}}" type="tel" class="form-control form-control-sm" required>
        <!-- <span id="validMsg" class="hide">✓ Valid</span>
        <span id="errorMsg" class="hide"></span> -->
        @if($errors->has('PhoneNumber'))
        <small class="d-block text-danger">
            {{$errors->first('PhoneNumber')}}
        </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <input name="EmailAddress" value="{{old('EmailAddress')}}" type="email" class="form-control form-control-sm" placeholder="Email" required>
        <div class="form-control-icon">
            <i class="bi bi-envelope"></i>
        </div>
        @if($errors->has('EmailAddress'))
        <small class="d-block text-danger">
            {{$errors->first('EmailAddress')}}
        </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <input type="password" name="password" class="form-control form-control-sm" placeholder="Password" required>
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        @if($errors->has('password'))
        <small class="d-block text-danger">
            {{$errors->first('password')}}
        </small>
        @endif
    </div>
    <div class="form-group position-relative has-icon-left mb-3">
        <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm Password">
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        @if($errors->has('password_confirmation'))
        <small class="d-block text-danger">
            {{$errors->first('password_confirmation')}}
        </small>
        @endif
    </div>
    <button type="submit" class="btn btn-sm btn-primary btn-block btn-lg shadow-lg mt-3">Sign Up</button>
</form>
<div class="text-center mt-3 text-lg fs-4">
    <p class='text-gray-600'>Already have an account? <a href="{{route('login')}}" class="font-bold">Log
            in</a>.</p>
</div>

@endsection