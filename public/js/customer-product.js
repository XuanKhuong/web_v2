$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	var b = $('#products-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/customer-getproducts',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'thumbnail', name: 'thumbnail' },
		{ data: 'action', name: 'action' },
		],
		"columnDefs": [ {
			"searchable": false,
			"orderable": false,
			"targets": 0
		} ],
		"order": [[ 1, 'asc' ]]
	});

	b.on( 'order.dt search.dt', function () {
		b.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	$('body').delegate('.btn-detail','click', function (e) {
		e.preventDefault();
		// $('#appendimg').html('');
		$('#modal_show').modal('show');
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/customer-products/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					$('#name-show').text(response.data.name);
					$('#description-show').text(response.data.description);
					$('#thumbnail-show').attr('src','/storage/' + response.data.thumbnail)
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})


	$('body').delegate('.btn-manufacturer', 'click', function(e){
		e.preventDefault();
		$('#modal-manufacturer').modal('show');
		var id = $(this).data('id');
		$('#btn-add-manufacturer').attr('data-id', id);
		var b = $('#manufacturers-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/customer-getmanufacturers/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'thumbnail', name: 'thumbnail' },
			{ data: 'action', name: 'action' },
			],
			"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				"targets": 0
			} ],
			"order": [[ 1, 'asc' ]]
		});

		b.on( 'order.dt search.dt', function () {
			b.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();

	})

	$('body').delegate('.btn-detail-manufacturer','click', function (e) {
		e.preventDefault();
		$('#appendimg').html('');
		$('#modal-detail-manufacturer').modal('show');
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/customer-manufacturers/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					$('#name-manufacturer-show').text(response.data.name);
					$('#thumbnail-manufacturer-show').attr('src','storage/'+ response.data.thumbnail)
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$('body').delegate('.btn-detail-product', 'click', function(e){
		e.preventDefault();
		$('#modal-detail-product').modal('show');
		var id = $(this).data('id');
		// alert(id);
		$('#btn-add-detail-product').attr('data-id', id);
		var b = $('#detail-products-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/customer-getdetailproducts/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'qty', name: 'qty' },
			{ data: 'price', name: 'price' },
			{ data: 'sale_price', name: 'sale_price' },
			{ data: 'action', name: 'action' },
			],
			"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				"targets": 0
			} ],
			"order": [[ 1, 'asc' ]]
		});

		b.on( 'order.dt search.dt', function () {
			b.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();

	})

	$('body').delegate('.btn-show-detail-product','click', function (e) {
		e.preventDefault();
		$('#appendimg').html('');
		$('#modal_dtProduct_show').modal('show');
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/customer-detail-products/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					console.log(response);
					$.each(response.data, function(key, value){
						if (value.thumbnail != null) {
							$('#thumbnail-dtProduct-show').attr('src','/storage/' + value.thumbnail)
						}
						else{
							$('#thumbnail-dtProduct-show').attr('src','/storage/product_img/Emptyimages.png')
						}
					})
					//hiển thị dữ liệu được controller trả về vào trong modal
					data = response.data;
					$('#name-dtProduct-show').text(data[0].name);
					$('#quantity-dtProduct-show').text(data[0].quantity);
					$('#price-dtProduct-show').text(data[0].price);
					$('#life-expectancy-dtProduct-show').text(data[0].life_expectancy);
					$('#sale-price-dtProduct-show').text(data[0].sale_price);
					$('#description-dtProduct-show').text(data[0].description);
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$("#modal-add-manufacturer").on('show.bs.modal', function(){
		$('#modal-manufacturer').modal('hide');
	});

	$("#modal-add-manufacturer").on('hide.bs.modal', function(){
		$('#modal-manufacturer').modal('show');
	});

	if (!($("#modal-add-manufacturer").hasClass('in'))) {
		$("#modal-edit-manufacturer").on('show.bs.modal', function(){
			$('#modal-manufacturer').modal('hide');
		});

		$("#modal-edit-manufacturer").on('hide.bs.modal', function(){
			$('#modal-manufacturer').modal('show');
		});
	}

	if (!($("#modal-add-manufacturer").hasClass('in'))) {
		$("#modal-detail-manufacturer").on('show.bs.modal', function(){
			$('#modal-manufacturer').modal('hide');
		});

		$("#modal-detail-manufacturer").on('hide.bs.modal', function(){
			$('#modal-manufacturer').modal('show');
		});
	}

	if (!($("#modal-add-manufacturer").hasClass('in'))) {
		$("#modal-detail-product").on('show.bs.modal', function(){
			$('#modal-manufacturer').modal('hide');
		});

		$("#modal-detail-product").on('hide.bs.modal', function(){
			$('#modal-manufacturer').modal('show');
		});
	}

	if (!($("#modal-manufacturer").hasClass('in')) && !($("#modal-add-manufacturer").hasClass('in')) && !($("#modal-edit-manufacturer").hasClass('in')) && !($("#modal-detail-manufacturer").hasClass('in'))) {
		$("#modal-add-detail-product").on('show.bs.modal', function(){
			$('#modal-detail-product').modal('hide');
		});

		$("#modal-add-detail-product").on('hide.bs.modal', function(){
			$('#modal-detail-product').modal('show');
		});
	}

	if (!($("#modal-manufacturer").hasClass('in')) && !($("#modal-add-manufacturer").hasClass('in')) && !($("#modal-edit-manufacturer").hasClass('in')) && !($("#modal-detail-manufacturer").hasClass('in')) && !($("#modal-add-detail-product").hasClass('in'))) {
		$("#modal-edit-detail-product").on('show.bs.modal', function(){
			$('#modal-detail-product').modal('hide');
		});

		$("#modal-edit-detail-product").on('hide.bs.modal', function(){
			$('#modal-detail-product').modal('show');
		});
	}

	if (!($("#modal-manufacturer").hasClass('in')) && !($("#modal-add-manufacturer").hasClass('in')) && !($("#modal-edit-manufacturer").hasClass('in')) && !($("#modal-detail-manufacturer").hasClass('in')) && !($("#modal-add-detail-product").hasClass('in'))) {
		$("#modal-show-detail-product").on('show.bs.modal', function(){
			$('#modal-detail-product').modal('hide');
		});

		$("#modal-show-detail-product").on('hide.bs.modal', function(){
			$('#modal-detail-product').modal('show');
		});
	}

	if (!($("#modal-manufacturer").hasClass('in')) && !($("#modal-add-manufacturer").hasClass('in')) && !($("#modal-edit-manufacturer").hasClass('in')) && !($("#modal-detail-manufacturer").hasClass('in')) && !($("#modal-add-detail-product").hasClass('in'))) {
		$("#modal-add-img-detail-product").on('show.bs.modal', function(){
			$('#modal-detail-product').modal('hide');
		});

		$("#modal-add-img-detail-product").on('hide.bs.modal', function(){
			$('#modal-detail-product').modal('show');
		});
	}
})

