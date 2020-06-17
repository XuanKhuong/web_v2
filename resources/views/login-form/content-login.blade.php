@extends('layouts.layoutLoginForm')

@section('content')

<div class="wrap-login100">
	<div class="login100-pic js-tilt" data-tilt>
		<img src="{{ asset('css/css-form-login/images/img-01.png') }}" alt="IMG">
	</div>
	<form class="login100-form validate-form" action="{{ route('login.postLogin') }}" method="POST">

		<span class="login100-form-title">
			Đăng nhập
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
			<input type="checkbox" id="remember" name="remember"> Nhớ tài khoản
		</div>

		<div class="container-login100-form-btn">
			<button class="login100-form-btn">
				Login
			</button>
		</div>

		<div class="text-center p-t-12">
			<span class="txt1">
				Quên
			</span>
			<a class="txt2 forgot-pass" style="cursor: pointer;">
				Tên đăng nhập / mật khẩu?
			</a>
		</div>

		<div class="text-center p-t-12">
			<a class="txt2" href="{{ route('myRegister.getRegister') }}">
				Tạo tài khoản
				<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
			</a>
		</div>
	</form>
</div>

<div class="modal fade" id="cartInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<form id="form-forgot-pass">
			<div class="modal-content">
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title" id="exampleModalLabel">
						Fill In Your Email
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="well form-horizontal" id="form-bill">
						<fieldset>
							<div class="form-group">
								<label class=" control-label">Email</label>
								<div class=" inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email-info" name="email" placeholder="Email" class="form-control" required="true" type="text"></div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="modal-footer border-top-0 d-flex justify-content-between">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success"
					>Send</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section('footer')

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function(){
		$('body').delegate('.forgot-pass','click',function(e){
			$('#cartInfo').modal('show');
		});

		$('body').delegate('#form-forgot-pass','submit',function(e){
			var email = $('#email-info').val();
			@for ($i = 0; $i < 9; $i++)
			var num = Math.floor(Math.random(8));
			@endfor
			alert(num);
			$.ajax({
				type: 'post',
				url: '/reset/'+email,
			})
		});
	})
</script>

@endsection