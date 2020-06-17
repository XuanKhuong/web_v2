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
					<li><span>Role Users</span></li>
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
						<!-- /.box-header -->
						<div class="box-body">
							<table id="users-table" class="table table-bordered table-hover" style="width: 1043px; ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Power</th>
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

		<div class="modal fade" id="modal-edit">
			<div class="modal-dialog">
				<div class="modal-content">

					<form id="form_edit"  method="POST" role="form" enctype="multipart/form-data">
						<!-- enctype="multipart/form-data" -->
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Edit Power</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="hidden" name="id_edit" id="id_edit" class="id_edit" >
									</div>
									<div class="form-group my-ip-radio">
										<label for="">power</label><br>
										<input type="radio" class=" admin_edit" id="admin_edit" name="power"> &nbsp; Admin &nbsp; 
										<input type="radio" class=" employee_edit" id="employee_edit" name="power"> &nbsp; Employee &nbsp;
										<input type="radio" class=" customer_edit" id="customer_edit" name="power" checked=""> &nbsp; Customer &nbsp;
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
<script type="text/javascript"src="js/user.js"></script>
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