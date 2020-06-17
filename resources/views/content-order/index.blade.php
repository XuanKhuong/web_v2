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
				<div class="col-md-12">
					<label><h3>Tìm kiếm theo trạng thái đơn hàng:</h3></label>
					<form>
						@csrf
						<div class="form-row">
							<div class="col-md-6">
								<select name="status-order" class="form-control" placeholder="Trạng thái đơn hàng">
									<option value="">Select a state...</option>
									<option value="1">Đơn hàng đang giao</option>
									<option value="2">Đơn hàng đã hủy</option>
								</select>
							</div>
							<div class="col-md-2">
								<button class="form-control btn btn-info" id="search-order-status">
									<i class="fa fa-search" aria-hidden="true"></i>
								</button>
							</div>
							<div class="col-md-2">
								<button class="form-control btn btn-warning" id="reset-order">
									<i class="fa fa-refresh" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row" style="margin-top: 12px;">
				<div class="col-xs-12">
					<div class="box">
						<!-- /.box-header -->
						<div class="box-body">
							<table
								@if (Auth::user()->admin)
									data-route="{{ route('admin-getorders.getorders') }}"
								@else 
									data-route="{{ route('customer-getorders.getorders') }}"
								@endif
								id="orders-table" class="table table-bordered table-hover" style="width: 1043px; ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Total</th>
										<th>Status</th>
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

		<div class="modal fade" id="modal_show">
			<div class="modal-dialog" style="max-width:200px;">
				<div class="modal-content" style="min-height: 500px;">
					<div class="modal-header">
						<h4 class="modal-title">Show Order</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<table width="100%">
										<tbody>
											<tr height="100px">
												<td width="20%"><h4 style="color: lightgreen;">Name:</h4></td>
												<td><p id="name-show"></p></td>
											</tr>
											<tr height="100px">
												<td width="20%"><h4 style="color: lightgreen;">Address:</h4></td>
												<td><p id="address-show"></td>
												</tr>
												<tr height="100px">
													<td width="20%"><h4 style="color: lightgreen;">Phone:</h4></td>
													<td><p id="phone-show"></p></td>
												</tr>
												<tr height="100px">
													<td width="20%"><h4 style="color: lightgreen;">Total:</h4></td>
													<td><p id="total-show"></td>
													</tr>
												</tbody>
											</table>
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

				<div class="modal fade" id="modal-detail-order">
					<div class="modal-dialog" style="max-width: 900px;" style="z-index: 1000">
						<div class="modal-content" style="padding: 12px;">
							<div class="box-header"style="padding-bottom: 12px;">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style=" font-size: 2.5rem;">&times;</button>
								<h1 style="text-align: center;">DETAIL PRODUCTS</h1>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<table id="detail-orders-table" class="table table-bordered table-hover" >
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Total</th>
											<th></th>
										</tr>
									</thead>
								</table>
								<input type="hidden" class="get-product-id" id="get-product-id" name="get-product-id">
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="modal_show_detail_order">
					<div class="modal-dialog" style="max-width:200px;">
						<div class="modal-content" style="min-height: 500px;">
							<div class="modal-header">
								<h4 class="modal-title">Show Detail Order</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<table width="100%">
												<tbody>
													<tr height="100px">
														<td width="20%"><h4 style="color: lightgreen;">Name:</h4></td>
														<td><p id="name-show"></p></td>
													</tr>
													<tr height="100px">
														<td width="20%"><h4 style="color: lightgreen;">Quantity:</h4></td>
														<td><p id="qty-show"></td>
														</tr>
														<tr height="100px">
															<td width="20%"><h4 style="color: lightgreen;">Price:</h4></td>
															<td><p id="price-show"></p></td>
														</tr>
														<tr height="100px">
															<td width="20%"><h4 style="color: lightgreen;">Total:</h4></td>
															<td><p id="total-show"></td>
															</tr>
														</tbody>
													</table>
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

					</section>
					<!-- /.content -->
				</div>
				<!-- /.content-wrapper -->
				@endsection;
				@section('footer')
				@if (Auth::user()->admin)
				<script type="text/javascript"src="js/admin-order.js"></script>
				@endif
				@if (Auth::user()->customer)
				<script type="text/javascript"src="js/customer-order.js"></script>
				@endif
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