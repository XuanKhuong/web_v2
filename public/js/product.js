$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
	var t = $('#products-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: $('#products-table').attr('data-route'),
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
		}],
	});

	t.on( 'order.dt search.dt', function () {
		t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	$('.btn-add').click(function(){
		$('#modal-add').modal('show')
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#name').keyup(function(){
			var data = $('#name').val()
			$('#slug').val(slug(data));
		});
	})

	$('#form-add').submit(function(e){
		var url = $(this).attr('data-url');
		e.preventDefault();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name').val());
		data.append( 'thumbnail', $('#thumbnail')[0].files[0]);
		data.append( 'description', $('#description').val());
		data.append( 'slug', $('#slug').val());
		$.ajax({
			//sử dụng phương thức post
			type: 'post',
			url: url,
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				
				$('#modal-add').modal('hide');
				$('#products-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
	})

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
				url: $(this).attr('data-route'),
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					$('#name-show').text(response.data.name);
					$('#description-show').text(response.data.description);
					$('#thumbnail-show').attr('src', response.data.url + '/storage/' + response.data.thumbnail)
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$('body').delegate('.btn-edit', 'click', function (e) {
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#name_edit').keyup(function(){
			var data = $('#name_edit').val()
			$('#slug_edit').val(slug(data));
		});
		e.preventDefault();
		$('#modal-edit').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: $(this).attr('data-route'),
			success: function(response){
				$('#id_edit').val(response.data.id);
				$('.description_edit').val(response.data.description);
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				$('.name_edit').val(response.data.name);
				$('.slug_edit').val(response.data.slug);
				$('.id_edit').val(response.data.id);
			}
		})
	})

	$('body').delegate('#form_edit','submit', function(e){
		e.preventDefault();

		var id = $('#id_edit').val();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'id', $('#id_edit').val());
		data.append( 'name', $('#name_edit').val());
		data.append( 'thumbnail', $('#thumbnail_edit')[0].files[0]);
		data.append( 'description', $('#description_edit').val());
		data.append( 'slug', $('#slug_edit').val());
		// alert(id);
		$.ajax({
			type: 'post',
			url: $(this).attr('action'),
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#products-table').DataTable().ajax.reload();
				toastr.success('save success!');
				// setTimeout(function () {
				// 	window.location.href= "post";
				// },1500);
			},
			error: function (jq, status, throwE){
				
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
	})

	$('body').delegate('.btn-delete','click',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		swal({
			title: "Delete",
			text: "Bạn có chắc chắn muốn xóa?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Có",
			cancelButtonText: "Không",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: 'get',
					url: $(this).attr('data-route'),
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#products-table').DataTable().ajax.reload();
						swal("Deleted!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.btn-manufacturer', 'click', function(e){
		e.preventDefault();
		$('#modal-manufacturer').modal('show');
		var id = $(this).data('id');
		$('#btn-add-manufacturer').attr('data-id', id);
		$('#get-product-id-manu').val(id);
		var b = $('#manufacturers-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: $(this).attr('data-route'),
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

	$('body').delegate('.btn-add-manufacturer','click', function(e){
		$('#modal-add-manufacturer').modal('show');
	})

	$('#form-add-manfacturer').submit(function(e){
		var product_id = $('#btn-add-manufacturer').data('id');
		var url = $(this).attr('data-url');

		// alert(product_id);
		e.preventDefault();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name-manufacturer').val());
		data.append( 'thumbnail', $('#uploadfile')[0].files[0]);
		data.append( 'product_id', product_id);
		$.ajax({
			//sử dụng phương thức post
			type: 'post',
			url: url,
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				$('#modal-add-manufacturer').modal('hide');
				$('#manufacturers-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
	})

	$('body').delegate('.btn-edit-manufacturer', 'click', function (e) {
		e.preventDefault();
		$('#modal-edit-manufacturer').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: $(this).attr('data-route'),
			success: function(response){
				$('#edit-id-manufacturer').val(response.data.id);
				$('.edit-name-manufacturer').val(response.data.name);
				$('#edit-thumbimage').attr('src','storage/'+ response.data.thumbnail)
				$('.edit-product-id-manufacturer').val(response.data.product_id);
			}
		})


	})

	$('body').delegate('#form-edit-manufacturer','submit', function(e){
		e.preventDefault();
		var id = $('#edit-id-manufacturer').val();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#edit-name-manufacturer').val());
		data.append( 'thumbnail', $('#edit-uploadfile')[0].files[0]);
		data.append( 'product_id', $('#edit-product-id-manufacturer').val());
		data.append( 'id', $('#edit-id-manufacturer').val());
		$.ajax({
			type: 'post',
			url: $(this).attr('action'),
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				$('#modal-edit-manufacturer').modal('hide');
				$('#manufacturers-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
	})

	$('body').delegate('.btn-detail-manufacturer','click', function (e) {
		e.preventDefault();
		$('#appendimg').html('');
		$('#modal-detail-manufacturer').modal('show');
		var id = $(this).attr('data-id');
		
		$.ajax({
			//sử dụng phương thức get
			type: 'get',
			url: $(this).attr('data-route'),
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

	$('body').delegate('.btn-delete-manufacturer','click',function(e){
		e.preventDefault();
		var url = $(this).attr('data-route');
		var id = $(this).data('id');
		swal({
			title: "Delete",
			text: "Bạn có chắc chắn muốn xóa?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Có",
			cancelButtonText: "Không",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: 'get',
					url: url,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#manufacturers-table').DataTable().ajax.reload();
						swal("Deleted!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.btn-detail-product', 'click', function(e){
		e.preventDefault();
		$('#modal-detail-product').modal('show');
		var url = $(this).attr('data-route');
		var id = $(this).attr('data-id');
		// alert(id);
		$('#btn-add-detail-product').attr('data-id', id);
		$('#get-product-id-dt').val($('#get-product-id-manu').val());
		var a = $('#detail-products-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: url,
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
		});

		a.on( 'order.dt search.dt', function () {
			a.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();

	})

	$('body').delegate('.btn-add-detail-product','click', function(e){
		$('#modal-add-detail-product').modal('show');
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '') + '-stall-' + $('.detail-product-stall-id').val();
			return $slug.toLowerCase();
		}
		$('#name-detail-product').keyup(function(){
			var data = $('#name-detail-product').val()
			$('#slug-detail-product').val(slug(data));
		});
		$('#manufacturer-id-detail-product').val($('#btn-add-detail-product').data('id'));
		$('#detail-product-product-id').val($('#get-product-id-dt').val());
	})

	$('#form-add-detail-product').submit(function(e){
		var manufacturer_id = $('#btn-add-detail-product').data('id');
		// alert(product_id);
		var url = $(this).attr('action');

		// alert(product_id);
		e.preventDefault();
		$.ajax({
			//sử dụng phương thức post
			type: 'post',
			url: url,
			data: {
				name: $('#name-detail-product').val(),
				qty: $('#quantity-detail-product').val(),
				price: $('#price-detail-product').val(),
				sale_price: $('#sale-price-detail-product').val(),
				slug: $('#slug-detail-product').val(),
				description: $('#description-detail-product').val(),
				manufacturer_id: $('#manufacturer-id-detail-product').val(),
				product_id: $('#detail-product-product-id').val(),
			},
			success: function (response) {
				if (response.err == false) {
					$('#modal-add-detail-product').modal('hide');
					$('#form-add-detail-product')[0].reset();
					$('#detail-products-table').DataTable().ajax.reload(null, false);
					toastr.success('save success!');
				} else {
					toastr.error(response.message);
				}
			},
			error: function (jq, status, throwE){
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
	})



	$('body').delegate('.btn-edit-detail-product', 'click', function (e) {
		e.preventDefault();
		$('#modal-edit-detail-product').modal('show');
		var id = $(this).data('id');
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#edit-name-detail-product').keyup(function(){
			var data = $('#edit-name-detail-product').val()
			$('#edit-slug-detail-product').val(slug(data));
		});
		$.ajax({
			type: 'get',
			url: $(this).attr('data-route'),
			success: function(response){
				
				$('#edit-id-detail-product').val(response.data.id);
				$('.edit-name-detail-product').val(response.data.name);
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				$('.edit-quantity-detail-product').val(response.data.qty);
				$('.edit-price-detail-product').val(response.data.price);
				$('.edit-sale-price-detail-product').val(response.data.sale_price);
				$('.edit-slug-detail-product').val(response.data.slug);
				$('.edit-description-detail-product').val(response.data.description);
				$('.edit-product-id-detail-product').val(response.data.product_id);
			}
		})


	})

	$('body').delegate('#form-edit-detail-product','submit', function(e){
		var url = $(this).attr('data-url');
		e.preventDefault();
		var id = $('#edit-id-detail-product').val();
		$.ajax({
			type: 'post',
			url: $(this).attr('action'),
			data: {
				name: $('.edit-name-detail-product').val(),
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				qty: $('.edit-quantity-detail-product').val(),
				price: $('.edit-price-detail-product').val(),
				sale_price: $('.edit-sale-price-detail-product').val(),
				product_id: $('.edit-product-id-detail-product').val(),
				slug: $('.edit-slug-detail-product').val(),
				description: $('.edit-description-detail-product').val(),
				id: $('.edit-id-detail-product').val(),
			},
			success: function(response){
				// //ẩn modal add đi
				// console.log(response.data.slug);
				if (response.err == false) {
					$('#modal-edit-detail-product').modal('hide');
					$('#detail-products-table').DataTable().ajax.reload();
					toastr.success('save success!');
				} else {
					toastr.error(response.message);
				}
			},
			error: function (jq, status, throwE){
				
				jQuery.each(jq.responseJSON.errors, function(key, value){
					toastr.error(value);
				})
			}
		})
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
				url: $(this).attr('data-route'),
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					//hiển thị dữ liệu được controller trả về vào trong modal
					// console.log(baseUrl);
					data = response.data;
					$('#name-dtProduct-show').text(data.name);
					$('#quantity-dtProduct-show').text(data.quantity);
					$('#price-dtProduct-show').text(data.price);
					$('#life-expectancy-dtProduct-show').text(data.life_expectancy);
					$('#sale-price-dtProduct-show').text(data.sale_price);
					$('#description-dtProduct-show').text(data.description);
					if (data.images.thumbnail != null) {
						$('#thumbnail-dtProduct-show').attr('src',data.url + '/storage/' + data.images.thumbnail)
					}
					else{
						$('#thumbnail-dtProduct-show').attr('src',data.url + '/storage/product_img/Emptyimages.jpg')
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$('body').delegate('.btn-delete-detail-product','click',function(e){
		e.preventDefault();

		var url = $(this).data('route');
		swal({
			title: "Delete",
			text: "Bạn có chắc chắn muốn xóa?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Có",
			cancelButtonText: "Không",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: 'get',
					url: url,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#detail-products-table').DataTable().ajax.reload();
						swal("Deleted!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.remove-img','click',function(e){
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'delete',
			url: $(this).data('route'),
			data:{
				_token: $('meta[name="csrf-token"]').attr('content'),
			},
			success: function (response) {
				$('.index-img-'+id+'').remove('div');
				$('#detail-products-table').DataTable().ajax.reload();
				toastr.success('Xóa thành công!');
			},
			error: function (error) {

			}
		})
	})

	$('body').delegate('.btn-add-img-detail-product', 'click', function(e){
		$('#myDropzone')[0].reset();
		$('#modal_add_img').modal('show');
		var count = 1;
		$.ajax({
			type: 'get',
			url: $(this).data('route'),
			success: function(response){
				
				$('.div-all-img').remove('div');
				$.each(response.data1, function(key, value){//
					$('#show-img-products').append(
						`
						<div class="div-all-img index-img-`+value.id+`">
						<button type="button" data-id="`+value.id+`" data-route="`+response.url+ 'admin-img/' +value.id+`" class="remove-img" style="position: absolute;z-index: 2;right: -7px;top: -5px;background: none;border:none;"><img src="`+response.url+`storage/icon/close.png" style="width:22px;"></button>
						<img src=" `+ response.url +`storage/`+ value.thumbnail +`" style="position: relative;z-index: 1;" class="thumbnail-show">
						</div>
						`);
				})
				$('#product_detail_id').val(response.data.id);
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

