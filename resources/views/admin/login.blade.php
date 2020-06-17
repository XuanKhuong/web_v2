@extends('layouts.layoutLoginForm')

@section('content')

<div class="wrap-login100">
    <div class="login100-pic js-tilt" data-tilt>
        <img src="{{ asset('css/css-form-login/images/img-01.png') }}" alt="IMG">
    </div>
    <form class="login100-form validate-form" action="{{ url('/login') }}" method="POST">

        <span class="login100-form-title">
            Admin Login
        </span>
        @if ($errors->has('errorlogin'))
        <div class="alert alert-danger" style="border-radius: 2.25rem;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! $errors->first('errorlogin') !!} <img src="{{ asset('storage/myIcon/sad.png') }}" style="width: 25px; height: 25px;">
        </div>
        @endif
        <div class="wrap-input100 validate-input" data-validate = "Email không hợp lệ!">
            <input class="input100" type="text" id="email" name="email" placeholder="Email" value="{!! old('email') !!}">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
        </div>

        @if ($errors->has('email'))
        <div class="alert alert-danger" style="border-radius: 2.25rem;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! $errors->first('email') !!}
        </div>
        @endif

        <div class="wrap-input100 validate-input" data-validate = "Password là trường bắt buộc!">
            <input class="input100" type="password" id="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
        </div>

        @if ($errors->has('password'))
        <div class="alert alert-danger" style="border-radius: 2.25rem;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! $errors->first('password') !!} 
        </div>
        @endif

        {!! csrf_field() !!}

        <div class="wrap-input100" style="padding: 12px;">
            <input type="checkbox" id="remember" name="remember"> Remember Me
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Login
            </button>
        </div>

        <div class="text-center p-t-12">
            <span class="txt1">
                Forgot
            </span>
            <a class="txt2" href="#">
                Username / Password?
            </a>
        </div>
    </form>
</div>

@endsection


