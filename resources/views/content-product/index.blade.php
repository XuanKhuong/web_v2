@extends('layouts.layoutAdmin')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">

@endsection

@section('content')

<div class="content-wrapper" style="padding: 12px;">
	<!-- Main content -->
	<section class="content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						@if (Auth::user()->admin)
						<div class="box-header"style="padding-bottom: 12px;">
							<a href="#" class="btn btn-success btn-add">Add</a>
						</div>
						@endif
						<!-- /.box-header -->
						<div class="box-body">
							<table id="products-table" data-route="{{ route('admin-products.getproducts') }}" class="table table-bordered table-hover" style="width: 1043px; ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Thumbnail</th>
										<th></th>
									</tr>
								</thead>
							</table>
							<input type="hidden" class="get-product-id" id="get-product-id" name="get-product-id">
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
					<form action=""
					@if (Auth::user()->admin)
					data-url="{{ route('admin-products.store') }}"
					@endif
					id="form-add" method="POST" role="form" enctype="multipart/form-data">
					@csrf
					<div class="modal-header">
						<h4 class="modal-title">Add Product</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="">name</label>
							<input type="text" list="list-name" class="form-control name" id="name" name="name" autocomplete="off"/>
							<datalist id="list-name">
								@foreach($products as $key => $product)
									<option value="{{ $product['name'] }}"></option>
								@endforeach
							</datalist>
						</div>
						<div class="form-group">
							<label for="">thumbnail</label>
							<input type="file" class="form-control thumbnail" id="thumbnail" name="thumbnail">
						</div>
						<div class="form-group">
							<label for="">description</label>
							<input type="text" class="form-control description" id="description" name="description">
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control slug" id="slug" name="slug">
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control product-id-detail-product" id="product-id-detail-product" name="product-id-detail-product" value="">
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
					<h4 class="modal-title">Show Product</h4>
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

				<form action="{{ route('admin-products.update') }}" id="form_edit"  method="POST" role="form" enctype="multipart/form-data">
					<!-- enctype="multipart/form-data" -->
					@csrf
					<div class="modal-header">
						<h4 class="modal-title">Edit Product</h4>
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

	{{-- manufacture --}}
	<div class="modal fade" id="modal-manufacturer">
		<div class="modal-dialog" style="max-width: 900px;" style="z-index: 1000">
			<div class="modal-content" style="padding: 12px;">
				<div class="box-header"style="padding-bottom: 12px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style=" font-size: 2.5rem;">&times;</button>
					<h1 style="text-align: center;">NHÀ SẢN XUẤT</h1>
					@if (Auth::user()->admin)
					<a data-route="{{ route('admin-manufacturers.create') }}" class="btn btn-success btn-add-manufacturer" id="btn-add-manufacturer" data-id="">Add</a>
					@endif
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="manufacturers-table" class="table table-bordered table-hover" >
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Thumbnail</th>
								<th></th>
							</tr>
						</thead>
					</table>
					<input type="hidden" class="get-product-id-manu" id="get-product-id-manu" name="get-product-id-manu" value="">
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-add-manufacturer" style="z-index: 99999999999999;">
		<div class="modal-dialog">
			<div class="modal-content">
				<form
				@if (Auth::user()->admin)
				data-url="{{ route('admin-manufacturers.store') }}"
				@endif
				id="form-add-manfacturer" method="POST" role="form" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Add Manfacturer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">name</label>
						<input type="text" class="form-control name-manufacturer" id="name-manufacturer" name="name-manufacturer">
					</div>
					<div class="form-group">
						<label for="">thumbnail</label>
						<div id="thumbbox" style="width: 250px;height: 250px;margin-top: 5%;margin-bottom: 5%;margin-left: 5%;">
							<img alt="Thumb image" id="thumbimage" style="width: 100%; height: 100%;" src="{{ asset('storage/product_img/Emptyimages.jpg') }}" />
						</div>
						<div id="myfileupload">
							<input type="file" id="uploadfile" name="ImageUpload" onchange="readURL(this);" />
							<!--      Name  mà server request về sẽ là ImageUpload-->
						</div>
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control product-id-manufacturer" id="product-id-manufacturer" name="product-id-manufacturer">
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

<div class="modal fade" id="modal-edit-manufacturer">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('admin-manufacturers.update') }}" id="form-edit-manufacturer" method="POST" role="form" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Manufacturer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" class="form-control edit-id-manufacturer" id="edit-id-manufacturer" name="edit-id-manufacturer">
					</div>
					<div class="form-group">
						<label for="">name</label>
						<input type="text" class="form-control edit-name-manufacturer" id="edit-name-manufacturer" name="edit-name-manufacturer">
					</div>
					<div class="form-group">
						<label for="">thumbnail</label>
						<div id="thumbbox" style="width: 250px;height: 250px;margin-top: 5%;margin-bottom: 5%;margin-left: 5%;">
							<img alt="Thumb image" id="edit-thumbimage" style="width: 100%; height: 100%;" src="{{ '/storage/product_img/Emptyimages.png' }}" />
						</div>
						<div id="myfileupload">
							<input type="file" id="edit-uploadfile" name="edit-ImageUpload" onchange="edit_readURL(this);" />
							<!--      Name  mà server request về sẽ là ImageUpload-->
						</div>
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control edit-product-id-manufacturer" id="edit-product-id-manufacturer" name="edit-product-id-manufacturer">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Edit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-detail-manufacturer" style="z-index: 99999999">
	<div class="modal-dialog" style="max-width: 700px;">
		<div class="modal-content" style="min-height: 500px;">
			<div class="modal-header">
				<h4 class="modal-title">Show Manfacturer</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<img src="" id="thumbnail-manufacturer-show" style="width: 248px; height: 248px; border-radius: 12px;">
						</div>
						<div class="col-md-7">
							<h4 style="color:green;">Name: <h4 style="margin-left: 5%;" id="name-manufacturer-show"></h4></h4>
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

{{-- detail product --}}
<div class="modal fade" id="modal-detail-product">
	<div class="modal-dialog" style="max-width: 900px;" style="z-index: 1000">
		<div class="modal-content" style="padding: 12px;">
			<div class="box-header"style="padding-bottom: 12px;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style=" font-size: 2.5rem;">&times;</button>
				<h1 style="text-align: center;">CHI TIẾT SẢN PHẨM</h1>
				@if (Auth::user()->admin)
				<a href="#" class="btn btn-success btn-add-detail-product" id="btn-add-detail-product" data-id="">Add</a>
				@endif
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="detail-products-table" class="table table-bordered table-hover" >
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Sale Price</th>
							<th></th>
						</tr>
					</thead>
				</table>
				<input type="hidden" class="get-product-id-dt" id="get-product-id-dt" name="get-product-id-dt">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-add-detail-product" style="z-index: 99999;">
	<div class="modal-dialog">
		<div class="modal-content">
			<form
			@if (Auth::user()->admin)
			action="{{ route('admin-detail-products.store') }}"
			@endif
			id="form-add-detail-product" method="POST" role="form" enctype="multipart/form-data">
			@csrf
			<div class="modal-header">
				<h4 class="modal-title">Add Detail Product</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="">name</label>
					<input type="text" class="form-control name-detail-product" id="name-detail-product" name="name-detail-product">
				</div>
				<div class="form-group">
					<label for="">quantity</label>
					<input type="number" class="form-control quantity-detail-product" id="quantity-detail-product" name="quantity-detail-product">
				</div>
				<div class="form-group">
					<label for="">price</label><br>
					<input type="number" class="form-control price-detail-product" id="price-detail-product" name="price-detail-product">
				</div>
				<div class="form-group">
					<label for="">sale price</label><br>
					<input type="number" class="form-control sale-price-detail-product" id="sale-price-detail-product" name="sale-price-detail-product">
				</div>
				<div class="form-group">
					<label for="">description</label><br>
					<input type="text" class="form-control description-detail-product" id="description-detail-product" name="description-detail-product">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control slug-detail-product" id="slug-detail-product" name="slug-detail-product">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control product-id-detail-product" id="product-id-detail-product" name="product-id-detail-product">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control manufacturer-id-detail-product" id="manufacturer-id-detail-product" name="manufacturer-id-detail-product">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control detail-product-product-id" id="detail-product-product-id" name="detail-product-product-id">
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control detail-product-stall-id" id="detail-product-stall-id" name="detail-product-stall-id" value="{{ Auth::user()->stall_id }}">
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

<div class="modal fade" id="modal-edit-detail-product">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('admin-detail-products.update') }}" id="form-edit-detail-product" method="POST" role="form">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Detail Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" class="form-control edit-id-detail-product" id="edit-id-detail-product" name="edit-id-detail-product">
					</div>
					<div class="form-group">
						<label for="">name</label>
						<input type="text" class="form-control edit-name-detail-product" id="edit-name-detail-product" name="edit-name-detail-product">
					</div>
					<div class="form-group">
						<label for="">quantity</label>
						<input type="number" class="form-control edit-quantity-detail-product" id="edit-quantity-detail-product" name="edit-quantity-detail-product">
					</div>
					<div class="form-group">
						<label for="">price</label><br>
						<input type="number" class="form-control edit-price-detail-product" id="edit-price-detail-product" name="edit-price-detail-product">
					</div>
					<div class="form-group">
						<label for="">sale price</label><br>
						<input type="number" class="form-control edit-sale-price-detail-product" id="edit-sale-price-detail-product" name="edit-sale-price-detail-product">
					</div>
					<div class="form-group">
						<label for="">description</label>
						<input type="text" class="form-control edit-description-detail-product" id="edit-description-detail-product" name="edit-description-detail-product">
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control edit-slug-detail-product" id="edit-slug-detail-product" name="edit-slug-detail-product">
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control edit-product-id-detail-product" id="edit-product-id-detail-product" name="edit-product-id-detail-product">
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

<div class="modal fade" id="modal_dtProduct_show" style="z-index: 99999999">
	<div class="modal-dialog" style="max-width: 700px;">
		<div class="modal-content" style="min-height: 500px;">
			<div class="modal-header">
				<h4 class="modal-title">Show Detail Product</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<img src="" id="thumbnail-dtProduct-show" style="width: 248px; height: 248px; border-radius: 12px;">
						</div>
						<div class="col-md-7">
							<h4 style="color:green;">Name: <p id="name-dtProduct-show"></p></h4>
							<h4 style="color:green;">Quantity: <p id="quantity-dtProduct-show"></p></h4>
							<h4 style="color:green;">Price: <p id="price-dtProduct-show"></p></h4>
							<h4 style="color:green;">Sale Price: <p id="sale-price-dtProduct-show"></p></h4>
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

@if (Auth::user()->admin)
<div class="modal fade" id="modal_add_img">
	<div class="modal-dialog">
		<div class="modal-content" style="min-height: 500px;">
			<div class="modal-header">
				<h4 class="modal-title">Add Images</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12 p-0">
							<form
							@if (Auth::user()->admin)
							action="{{ asset('/admin-upload-img/store') }}"
							@endif
							class="dropzone" id="myDropzone">
							@csrf;
							<div class="fallback">
								<input name="file" type="file" multiple />
							</div>
							<input name="product_detail_id" id="product_detail_id" type="hidden" />
						</form><br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 p-0">
						<div id="show-img-products" style="width: 500px; min-height: 200px; padding:12px; margin: 0px auto;">
							
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="addimgpro">Add</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
@endif

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection;
@section('footer')
@if (Auth::user()->admin)
<script type="text/javascript"src="js/product.js"></script>
@endif
@if (Auth::user()->customer)
<script type="text/javascript" src="js/customer-product.js"></script>
@endif
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@if (Auth::user()->admin || Auth::user()->employee)
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
	$(document).ready(function () {
		$(".Choicefile").bind('click', function  () { 
			$("#uploadfile").click();

		});
		$(".removeimg").click(function () {
			$("#thumbimage").attr('src', '').hide();
			$("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
			$(".removeimg").hide();
			$(".Choicefile").bind('click', function  () {
				$("#uploadfile").click();
			});
			$('.Choicefile').css('background','#0877D8');
			$('.Choicefile').css('cursor', 'pointer');
			$(".filename").text("");
		});
	})

	function  edit_readURL(input,thumbimage) {
		if  (input.files && input.files[0]) { 
			var  reader = new FileReader();
			reader.onload = function (e) {
				$("#edit-thumbimage").attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
		else  {
			$("#edit-thumbimage").attr('src', input.value);
		}
		$("#edit-thumbimage").show();
		$('.filename').text($("#edit-uploadfile").val());
		$('.Choicefile').css('background', '#C4C4C4');
		$('.Choicefile').css('cursor', 'default');
		$(".removeimg").show();
		$(".Choicefile").unbind('click'); 

	}
</script>
@endif
@endsection;