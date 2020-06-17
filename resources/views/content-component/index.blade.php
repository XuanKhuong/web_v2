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
					<li><span>Media Object</span></li>
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
							<table id="components-table" class="table table-bordered table-hover" style="width: 1043px; ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Description</th>
										<th>Thumbnail</th>
										<th></th>
									</tr>
								</thead>
							</table>
							<input type="hidden" class="get-component-id" id="get-component-id" name="get-component-id">
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
					<form action=""  data-url="{{ route('admin-components.store') }}"  id="form-add" method="POST" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Add Component</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="">name</label>
								<input type="text" class="form-control name" id="name" name="name">
							</div>
							<div class="form-group">
								<label for="">thumbnail</label>
								<img src="" id="profile-img-tag" width="200px" style="display: none;"/>
								<input type="file" class="form-control thumbnail" id="thumbnail" name="thumbnail">
							</div>
							<div class="form-group">
								<label for="">description</label>
								<input type="text" class="form-control description" id="description" name="description">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control slug" id="slug" name="slug">
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
						<h4 class="modal-title">Show Component</h4>
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
									<h4 style="color:green;">Description: <p id="description-show"></p></h4>
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
							<h4 class="modal-title">Edit Component</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<input type="hidden" name="id_edit" id="id_edit" class="id_edit">
							</div>
							<div class="form-group">
								<label for="">name</label>
								<input type="text" class="form-control name_edit" id="name_edit" name="name_edit">
							</div>
							<div class="form-group">
								<label for="">thumbnail</label>
								<img src="" id="edit-profile-img-tag" width="200px" style="display: none;"/>
								<input type="file" class="form-control thumbnail_edit" id="thumbnail_edit" name="thumbnail_edit">
							</div>
							<div class="form-group">
								<label for="">description</label>
								<input type="text" class="form-control description_edit" id="description_edit" name="description_edit">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control slug_edit" id="slug_edit" name="slug_edit">
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

		<div class="modal fade" id="modal-detail-component">
			<div class="modal-dialog" style="max-width: 900px;" style="z-index: 1000">
				<div class="modal-content" style="padding: 12px;">
					<div class="box-header"style="padding-bottom: 12px;">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style=" font-size: 2.5rem;">&times;</button>
						<h1 style="text-align: center;">DETAIL COMPONENT</h1>
						<a href="#" class="btn btn-success btn-add-detail-component" id="btn-add-detail-component" data-id="">Add</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="detail-components-table" class="table table-bordered table-hover" >
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Quantity</th>
									<th>Price</th>
									<th>Life Expectancy</th>
									<th>Sale Price</th>
									<th></th>
								</tr>
							</thead>
						</table>
						<input type="hidden" class="get-component-id" id="get-component-id" name="get-component-id">
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-add-detail-component" style="z-index: 99999999999999;">
			<div class="modal-dialog">
				<div class="modal-content">
					<form  data-url="{{ route('admin-detail-components.store') }}"  id="form-add-detail-component" method="POST" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Add Detail Component</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="">name</label>
								<input type="text" class="form-control name-detail-component" id="name-detail-component" name="name-detail-component">
							</div>
							<div class="form-group">
								<label for="">quantity</label>
								<input type="number" class="form-control quantity-detail-component" id="quantity-detail-component" name="quantity-detail-component">
							</div>
							<div class="form-group">
								<label for="">price</label><br>
								<input type="number" class="form-control price-detail-component" id="price-detail-component" name="price-detail-component">
							</div>
							<div class="form-group">
								<label for="">sale price</label><br>
								<input type="number" class="form-control sale-price-detail-component" id="sale-price-detail-component" name="sale-price-detail-component">
							</div>
							<div class="form-group">
								<label for="">description</label><br>
								<input type="text" class="form-control description-detail-component" id="description-detail-component" name="description-detail-component">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control slug-detail-component" id="slug-detail-component" name="slug-detail-component">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control component-id-detail-component" id="component-id-detail-component" name="component-id-detail-component">
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

		<div class="modal fade" id="modal-edit-detail-component">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="form-edit-detail-component" method="POST" role="form">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Edit Detail Component</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<input type="hidden" class="form-control edit-id-detail-component" id="edit-id-detail-component" name="edit-id-detail-component">
							</div>
							<div class="form-group">
								<label for="">name</label>
								<input type="text" class="form-control edit-name-detail-component" id="edit-name-detail-component" name="edit-name-detail-component">
							</div>
							<div class="form-group">
								<label for="">quantity</label>
								<input type="number" class="form-control edit-quantity-detail-component" id="edit-quantity-detail-component" name="edit-quantity-detail-component">
							</div>
							<div class="form-group">
								<label for="">price</label><br>
								<input type="number" class="form-control edit-price-detail-component" id="edit-price-detail-component" name="edit-price-detail-component">
							</div>
							<div class="form-group">
								<label for="">sale price</label><br>
								<input type="number" class="form-control edit-sale-price-detail-component" id="edit-sale-price-detail-component" name="edit-sale-price-detail-component">
							</div>
							<div class="form-group">
								<label for="">description</label>
								<input type="text" class="form-control edit-description-detail-component" id="edit-description-detail-component" name="edit-description-detail-component">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control edit-slug-detail-component" id="edit-slug-detail-component" name="edit-slug-detail-component">
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control edit-component-id-detail-component" id="edit-component-id-detail-component" name="edit-component-id-detail-component">
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

		<div class="modal fade" id="modal_dtComponent_show" style="z-index: 99999999">
			<div class="modal-dialog" style="max-width: 700px;">
				<div class="modal-content" style="min-height: 500px;">
					<div class="modal-header">
						<h4 class="modal-title">Show Detail Component</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="col-md-5">
									<img src="" id="thumbnail-dtComponent-show" style="width: 248px; height: 248px; border-radius: 12px;">
								</div>
								<div class="col-md-7">
									<h4 style="color:green;">Name: <p id="name-dtComponent-show"></p></h4>
									<h4 style="color:green;">Quantity: <p id="quantity-dtComponent-show"></p></h4>
									<h4 style="color:green;">Price: <p id="price-dtComponent-show"></p></h4>
									<h4 style="color:green;">Sale Price: <p id="sale-price-dtComponent-show"></p></h4>
									<h4 style="color:green;">Description: <p id="description-dtComponent-show"></p></h4>
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
		
		<div class="modal fade" id="modal_add_img">
			<div class="modal-dialog">
				<div class="modal-content" style="min-height: 500px;">
					<div class="modal-header">
						<h4 class="modal-title">Add Images</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" style="text-align: center;">
						<form action="{{ asset('/admin-components-upload-img/store') }}" class="dropzone" id="myDropzone">
							@csrf;
							<div class="fallback">
								<input name="file" type="file" multiple />
							</div>
							<input name="component_detail_id" id="component_detail_id" type="hidden" />
						</form><br>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" id="addimgpro">Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection;
@section('footer')
<script type="text/javascript"src="js/component.js"></script>
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

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
                $('#profile-img-tag').css('display','block');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#thumbnail").change(function(){
        readURL(this);
    });

    function readURL_edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#edit-profile-img-tag').attr('src', e.target.result);
                $('#edit-profile-img-tag').css('display','block');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#thumbnail_edit").change(function(){
        readURL(this);
    });
</script>
@endsection;