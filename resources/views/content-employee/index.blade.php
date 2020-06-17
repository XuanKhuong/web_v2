@extends('layouts.layoutAdmin')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">

@endsection

@section('content')

<div class="page-title-area">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<div class="breadcrumbs-area clearfix">
				<h4 class="page-title pull-left">Dashboard</h4>
				<ul class="breadcrumbs pull-left">
					<li><a href="index.html">Home</a></li>
					<li><span>Employees</span></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 clearfix">
			<div class="user-profile pull-right">
				@if (Auth::user()->thumbnail != null)
				<img class="avatar user-thumb" src="storage/{!! Auth::user()->thumbnail !!}" alt="avatar" style="border-radius: 50%; width: 35px; height: 35px;">
				@endif
				@if (Auth::user()->thumbnail == null)
				<img class="avatar user-thumb" src="{{ asset('storage/img-profile/user01.png') }}" alt="avatar" style="border-radius: 50%; width: 35px; height: 35px;">
				@endif
				<h4 class="user-name dropdown-toggle" data-toggle="dropdown">{!! Auth::user()->name !!} <i class="fa fa-angle-down"></i></h4>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Message</a>
					<a class="dropdown-item" href="#">Settings</a>
					<a class="dropdown-item" href="{!! '/admin-logout' !!}">Log Out</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content-wrapper" style="padding: 12px;">
	<!-- Main content -->
	<section class="content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header"style="padding-bottom: 12px;">
							<a href="#" class="btn btn-success btn-add">Add</a>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="employees-table" class="table table-bordered table-hover" style="width: 1043px; ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Address</th>
										<th>Gender</th>
										<th>Old</th>
										<th>Thumbnail</th>
										<th></th>
									</tr>
								</thead>
							</table>
							<input type="hidden" class="get-employee-id" id="get-employee-id" name="get-employee-id">
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
		</div>
		<!-- /.row -->

		<div class="modal fade" id="modal-add" style="z-index: 99999999;">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action=""  data-url="{{ route('employees.store') }}"  id="form-add" method="POST" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Add Employee</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-5">
										<label for="">thumbnail</label>
										<div id="thumbbox-add" style="width: 250px;height: 250px;padding: 20px;">
											<img alt="Thumb image" id="thumbimage_add" style="width: 100%; height: 100%; border-radius: 50%;" src="{{ '/storage/img-profile/user01.png' }}" />
										</div>
										<div id="myfileupload-add">
											<input type="file" id="uploadfile-add" name="ImageUpload-add" onchange="readURL_Add(this);" />
											<!--      Name  mà server request về sẽ là ImageUpload-->
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="">name</label>
											<input type="text" class="form-control name" id="name" name="name">
										</div>
										<div class="form-group">
											<label for="">email</label>
											<input type="email" class="form-control email" id="email" name="email">
										</div>
										<div class="form-group">
											<label for="">password</label>
											<input type="password" class="form-control password" id="password" name="password">
										</div>
										<div class="form-group">
											<label for="">phone</label>
											<input type="number" class="form-control phone" id="phone" name="phone">
										</div>
										<div class="form-group">
											<label for="">address</label>
											<input type="text" class="form-control address" id="address" name="address">
										</div>
										<div class="form-group">
											<label for="">old</label>
											<input type="text" class="form-control old" id="old" name="old">
										</div>
										<div class="form-group my-ip-radio">
											<label for="">gender</label><br>
											<input type="radio" class=" nam-add" id="nam-add" name="gender" checked=""> &nbsp; Nam &nbsp; 
											<input type="radio" class=" nu-add" id="nu-add" name="gender"> &nbsp; Nữ &nbsp;
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_show">
			<div class="modal-dialog" style="max-width:800px;">
				<div class="modal-content" style="min-height: 500px;">
					<div class="modal-header">
						<h4 class="modal-title">Show Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="col-md-5">
									<img src="" id="thumbnail-show" style="width: 200px; height: 200px; border-radius: 12px;">
								</div>
								<div class="col-md-7">
									<h4 style="color:green;">Name: <p id="name-show"></p></h4>
									<h4 style="color:green;">Gender: <p id="gender-show"></p></h4>
									<h4 style="color:green;">Old: <p id="old-show"></p></h4>
									<h4 style="color:green;">Phone: <p id="phone-show"></p></h4>
									<h4 style="color:green;">Address: <p id="address-show"></p></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-edit">
			<div class="modal-dialog">
				<div class="modal-content">

					<form id="form_edit"  method="POST" role="form" enctype="multipart/form-data">
						<!-- enctype="multipart/form-data" -->
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Edit Employee</h4>
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
										<label for="">name</label>
										<input type="text" class="form-control name_edit" id="name_edit" name="name_edit" >
									</div>
									<div class="form-group">
										<label for="">phone</label>
										<input type="number" class="form-control phone_edit" id="phone_edit" name="phone_edit">
									</div>
									<div class="form-group">
										<label for="">old</label>
										<input type="number" class="form-control old_edit" id="old_edit" name="old_edit">
									</div>
									<div class="form-group">
										<label for="">address</label>
										<input type="text" class="form-control address_edit" id="address_edit" name="address_edit">
									</div>
									<div class="form-group">
										<label for="">gender</label><br>
										<input type="radio" class="nam" id="nam" name="gender" checked="checked"> Male &nbsp; &nbsp; &nbsp;
										<input type="radio" class="nu" id="nu" name="gender"> Female
									</div>
									<div class="form-group">
										<input type="hidden" class="user_id_edit" id="user_id_edit" name="user_id_edit">
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

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection;
@section('footer')
<script type="text/javascript"src="js/employee.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
	Dropzone.options.myDropzone = {
		maxFileSize : 4,
		parallelUploads : 10,
		uploadMultiple: true,
		autoProcessQueue : false,
		addRemoveLinks : true,
		init: function() {
			var submitButton = document.querySelector("#addimgpro")
			myDropzone = this;
			submitButton.addEventListener("click", function() {
				myDropzone.processQueue(); 
			});

		},
	};

	function  readURL(input,thumbimage) {
		if  (input.files && input.files[0]) {
			var  reader = new FileReader();
			reader.onload = function (e) {
				$("#thumbimage").attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
		else  { 
			$("#thumbimage").attr('src', input.value);

		}
		$("#thumbimage").show();
		$('.filename').text($("#uploadfile").val());
		$('.Choicefile').css('background', '#C4C4C4');
		$('.Choicefile').css('cursor', 'default');
		$(".removeimg").show();
		$(".Choicefile").unbind('click'); 
	}

	function  readURL_Add(input,thumbimage_add) {
		if  (input.files && input.files[0]) {
			var  reader = new FileReader();
			reader.onload = function (e) {
				$("#thumbimage_add").attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
		else  { 
			$("#thumbimage_add").attr('src', input.value);

		}
		// $("#thumbbox-add").css('display','block');
		// $("#thumbimage_add").css('display','block');
		$('.filename').text($("#uploadfile-add").val());
		$('.Choicefile').css('background', '#C4C4C4');
		$('.Choicefile').css('cursor', 'default');
		$(".removeimg").show();
		$(".Choicefile").unbind('click'); 
	}
</script>
@endsection;