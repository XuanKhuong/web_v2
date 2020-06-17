@extends('layouts.layoutLoginForm')

@section('header')

<style type="text/css">
	.ip-block{
		display: block
	}

	.ip-none{
		display: none
	}

	.switch {
		position: relative;
		display: inline-block;
		width: 42px;
    	height: 24px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 16px;
    	width: 16px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(19px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>

@endsection

@section('content')

<div class="wrap-login100">
	<div class="login100-pic js-tilt" data-tilt>
		<img src="{{ asset('css/css-form-login/images/img-01.png') }}" alt="IMG">
	</div>

	<form class="login100-form validate-form" action="{{ route('myRegister.postRegister') }}" method="POST">
		@csrf
		<span class="login100-form-title" id="">
			ĐĂNG KÝ TÀI KHOẢN <br> & GIAN HÀNG
		</span>

		@if ($errors->has('errorlogin'))
		<div class="alert alert-danger" style="border-radius: 2.25rem;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! $errors->first('errorlogin') !!} <img src="{{ asset('storage/myIcon/sad.png') }}" style="width: 25px; height: 25px;">
		</div>
		@endif

		<div class="wrap-input100 validate-input" data-validate = "Tên là trường bắt buộc!">
			<input class="input100" type="text" name="name" placeholder="Name">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-user" aria-hidden="true"></i>
			</span>
		</div>

		@if ($errors->has('name'))
		<div class="alert alert-danger" style="border-radius: 2.25rem;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! $errors->first('name') !!}
		</div>
		@endif

		<div class="wrap-input100 validate-input" data-validate = "Email không đúng định dạng!">
			<input class="input100" type="text" name="email" placeholder="Email">
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

		<div class="wrap-input100 validate-input" data-validate = "Password là trường bắt buộc">
			<input class="input100" type="password" name="password" placeholder="Password">
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

		<div class="wrap-input100 validate-input" data-validate = "Tên gian hàng là trường bắt buộc!">
			<input class="input100" type="text" name="stall_name" placeholder="Tên gian hàng">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-home" aria-hidden="true"></i>
			</span>
		</div>

		@if ($errors->has('stall_name'))
		<div class="alert alert-danger" style="border-radius: 2.25rem;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! $errors->first('stall_name') !!}
		</div>
		@endif

		<div class="wrap-input100 validate-input" data-validate = "Địa chỉ là trường bắt buộc">
			<input class="input100" type="text" name="address" placeholder="Địa chỉ gian hàng">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-plane" aria-hidden="true"></i>
			</span>
		</div>

		@if ($errors->has('address'))
		<div class="alert alert-danger" style="border-radius: 2.25rem;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! $errors->first('address') !!}
		</div>
		@endif

		<div class="wrap-input100 validate-input">
			<input class="input100" type="number" name="phone" placeholder="Số điện thoại liên hệ">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-phone-square" aria-hidden="true"></i>
			</span>
		</div>

		@if ($errors->has('phone'))
		<div class="alert alert-danger" style="border-radius: 2.25rem;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! $errors->first('phone') !!}
		</div>
		@endif

		<div class="wrap-input100">
			<input class="input100" type="hidden" name="create_stall" value="true">
		</div>

		<div class="container-login100-form-btn">
			<button class="login100-form-btn">
				Đăng ký tài khoản
			</button>
		</div>

		<div class="text-center p-t-12">
			<span class="txt1">
				Trở về 
			</span>
			<a class="txt2" href="{!! '/login' !!}">
				đăng nhập
			</a>
		</div>
	</form>
</div>

@endsection


