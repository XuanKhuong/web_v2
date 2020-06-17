@extends('layouts.layoutAdmin')

@section('head_css')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">

@endsection

@section('content')
<!-- page title area end -->
<div class="main-content-inner">
	<div class="row">
		<div class="col-lg-12 mt-5" style="position: relative; height: 300px;">
			<img src="{{ asset('storage/user_img/cover_img.jpg') }}" style="z-index: 1; border-radius: 5px; background-size: cover; max-height: 500px; width: 100%;">
			@if (Auth::user()->thumbnail != null)
			<img class="img-fluid mr-4" src="storage/{!! $user->thumbnail !!}" alt="image" style="border-radius: 50%;width: 200px;height: 200px;z-index: 2;position: absolute;bottom: -42px;left: 48px;">
			@endif
			@if (Auth::user()->thumbnail == null)
			<img class="img-fluid mr-4" src="{{ asset('storage/img-profile/user01.png') }}" alt="image" style="border-radius: 50%;width: 200px;height: 200px;z-index: 2;position: absolute;bottom: -42px;left: 48px;">
			@endif
		</div>
	</div>
	<div class="row" style="min-height: 400px;">
		<div class="col-lg-12 mt-5">
			<div class="card">
				<div class="card-body">
					<div class="media mb-5">
						<div class="media-body">
							<h4 class="mb-3">{!! $user->name !!} &nbsp;<a href="#" title="edit information" 
								@if (Auth::user()->admin)
								data-route="{{ route('admin.edit', Auth::user()->id) }}"
								@else
								data-route="{{ route('customer.edit', Auth::user()->id) }}"
								@endif 
								data-toggle="modal" class="edit-info"><i class="fa fa-cog"></i></a></h4>
							<h6><i class="fa fa-envelope-o"></i>:&nbsp; &nbsp; {!! $user->email !!}</h6> <br>
							<h6><i class="fa fa-phone-square"></i>:&nbsp; &nbsp; {!! $user->phone !!}</h6> <br>
							<h6><i class="fa fa-heartbeat"></i>:&nbsp; &nbsp; {!! $user->old !!} years old</h6> <br>
							<h6><i class="fa fa-road"></i>:&nbsp; &nbsp; {!! $user->address !!}</h6> <br>
							<h6><i class="fa fa-transgender"></i>:&nbsp; &nbsp; {!! $user->gender !!}</h6> <br>
							@if(isset($stall->stall_name))
							
								<h6><strong>Quản lý gian hàng: </strong>{!! $stall->stall_name !!}</h6>

							@endif 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-edit">
	<div class="modal-dialog" style="max-width: 700px;">
		<div class="modal-content">

			<form id="form_edit"
			@if (Auth::user()->admin)
			action="{{ route('admin.update', Auth::user()->id) }}"
			@else
			action="{{ route('customer.update', Auth::user()->id) }}"
			@endif
			method="POST" role="form" enctype="multipart/form-data">
				<!-- enctype="multipart/form-data" -->
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5">
							<div id="thumbbox" style="width: 250px;height: 250px;margin-top: 5%;margin-bottom: 5%;margin-left: 5%;">
								<img alt="Thumb image" id="thumbimage" style="width: 100%; height: 100%;" />
							</div>
							<div id="myfileupload">
								<input type="file" id="uploadfile" name="ImageUpload" onchange="readURL(this);" />
								<!--      Name  mà server request về sẽ là ImageUpload-->
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="id_edit" id="id_edit" class="id_edit" >
							</div>
							<div class="form-group">
								<label for="">Tên</label>
								<input type="text" class="form-control name_edit" id="name_edit" name="name_edit" >
							</div>
							<div class="form-group">
								<label for="">SĐT</label>
								<input type="number" class="form-control phone_edit" id="phone_edit" name="phone_edit">
							</div>
							<div class="form-group">
								<label for="">Tuổi</label>
								<input type="number" class="form-control old_edit" id="old_edit" name="old_edit">
							</div>
							<div class="form-group">
								<label for="">Địa chỉ</label>
								<input type="text" class="form-control address_edit" id="address_edit" name="address_edit">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input type="text" class="form-control email_edit" id="email_edit" name="email_edit">
							</div>
							<div class="form-group">
								<label for="">Giới tính</label><br>
								<input type="radio" class="nam" id="nam" name="gender" checked="checked"> Nam &nbsp; &nbsp; &nbsp;
								<input type="radio" class="nu" id="nu" name="gender"> Nữ
							</div>
							<div class="form-group">
								<label for="">Tên gian hàng</label><br>
								<input type="text" class="form-control stall_name_edit" id="stall_name_edit" name="stall_name_edit" >
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" class="save-edit">Edit</button>

				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('footer')

@if (Auth::user()->admin)
	<script type="text/javascript" src="js/profile.js"></script>
@endif
@if (Auth::user()->employee)
	<script type="text/javascript" src="js/profile-employee.js"></script>
@endif
@if (Auth::user()->customer)
	<script type="text/javascript" src="js/profile-customer.js"></script>
@endif

<script type="text/javascript">
	function  readURL(input,thumbimage) {
   if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
   	var  reader = new FileReader();
   	reader.onload = function (e) {
   		$("#thumbimage").attr('src', e.target.result);
   	}
   	reader.readAsDataURL(input.files[0]);
   }
    else  { // Sử dụng cho IE
    	$("#thumbimage").attr('src', input.value);

    }
    $("#thumbimage").show();
    $('.filename').text($("#uploadfile").val());
    $('.Choicefile').css('background', '#C4C4C4');
    $('.Choicefile').css('cursor', 'default');
    $(".removeimg").show();
    $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

}
$(document).ready(function () {
   $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
   	$("#uploadfile").click();

   });
   $(".removeimg").click(function () {//Xóa hình  ảnh đang xem
   	$("#thumbimage").attr('src', '').hide();
   	$("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
   	$(".removeimg").hide();
      $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
      	$("#uploadfile").click();
      });
      $('.Choicefile').css('background','#0877D8');
      $('.Choicefile').css('cursor', 'pointer');
      $(".filename").text("");
  });
})
</script>

@endsection
