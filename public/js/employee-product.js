$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	var b = $('#products-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/employee-getproducts',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'description', name: 'description' },
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
		console.log($('#thumbnail')[0].files[0]);
		$.ajax({
			//sử dụng phương thức post
			type: 'post',
			url: url,
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				console.log(response.data);
				$('#modal-add').modal('hide');
				$('#products-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				console.log(jq);
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
				url: "/employee-products/"+id,
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
			url: 'employee-products/' + id + '/edit',
			success: function(response){
				console.log(response.data);
				$('#id_edit').val(response.data.id);
				$('.description_edit').val(response.data.description);
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				$('.name_edit').val(response.data.name);
				$('.slug_edit').val(response.data.slug);
			}
		})
	})

	$('body').delegate('#form_edit','submit', function(e){
		e.preventDefault();

		var id = $('#id_edit').val();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name_edit').val());
		data.append( 'thumbnail', $('#thumbnail_edit')[0].files[0]);
		data.append( 'description', $('#description_edit').val());
		data.append( 'slug', $('#slug_edit').val());
		// alert(id);
		$.ajax({
			type: 'post',
			url: 'employee-products/'+id,
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				console.log(response.data);
				$('#modal-edit').modal('hide');
				$('#products-table').DataTable().ajax.reload();
				toastr.success('save success!');
				// setTimeout(function () {
				// 	window.location.href= "post";
				// },1500);
			},
			error: function (jq, status, throwE){
				console.log(jq);
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
			title: "Đừng xóa em?",
			text: "Anh sẽ không gặp lại em nữa đâu!!",
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
					type: 'delete',
					url: 'employee-products/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#products-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
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
		var b = $('#manufacturers-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/employee-getmanufacturers/'+id,
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
				console.log(jq);
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
			url: 'employee-manufacturers/' + id + '/edit',
			success: function(response){
				console.log(response.data);
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
		$.ajax({
			type: 'post',
			url: '/employee-manufacturers/'+id,
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				// //ẩn modal add đi
				// console.log(response.data.slug);
				$('#modal-edit-manufacturer').modal('hide');
				$('#manufacturers-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				console.log(jq);
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
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/employee-manufacturers/"+id,
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

		var id = $(this).data('id');
		swal({
			title: "Đừng xóa em?",
			text: "Anh sẽ không gặp lại em nữa đâu!!",
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
					type: 'delete',
					url: 'employee-manufacturers/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#manufacturers-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
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
		var id = $(this).data('id');
		// alert(id);
		$('#btn-add-detail-product').attr('data-id', id);
		var b = $('#detail-products-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/employee-getdetailproducts/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'qty', name: 'qty' },
			{ data: 'price', name: 'price' },
			{ data: 'sale_price', name: 'sale_price' },
			{ data: 'description', name: 'description' },
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

	$('body').delegate('.btn-add-detail-product','click', function(e){
		$('#modal-add-detail-product').modal('show');
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#name-detail-product').keyup(function(){
			var data = $('#name-detail-product').val()
			$('#slug-detail-product').val(slug(data));
		});
		$('#manufacturer-id-detail-product').val($('#btn-add-detail-product').data('id'));
	})

	$('#form-add-detail-product').submit(function(e){
		var manufacturer_id = $('#btn-add-detail-product').data('id');
		// alert(product_id);
		var url = $(this).attr('data-url');

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
			},
			success: function (response) {
				$('#modal-add-detail-product').modal('hide');
				$('#detail-products-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				console.log(jq);
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
			url: 'employee-detail-products/' + id + '/edit',
			success: function(response){
				console.log(response.data);
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
			url: '/employee-detail-products/'+id,
			data: {
				name: $('.edit-name-detail-product').val(),
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				qty: $('.edit-quantity-detail-product').val(),
				price: $('.edit-price-detail-product').val(),
				sale_price: $('.edit-sale-price-detail-product').val(),
				product_id: $('.edit-product-id-detail-product').val(),
				slug: $('.edit-slug-detail-product').val(),
				description: $('.edit-description-detail-product').val(),
			},
			success: function(response){
				// //ẩn modal add đi
				// console.log(response.data.slug);
				$('#modal-edit-detail-product').modal('hide');
				$('#detail-products-table').DataTable().ajax.reload();
				toastr.success('save success!');
			},
			error: function (jq, status, throwE){
				console.log(jq);
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
				url: "/employee-detail-products/"+id,
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

	$('body').delegate('.btn-delete-detail-product','click',function(e){
		e.preventDefault();

		var id = $(this).data('id');
		swal({
			title: "Đừng xóa em?",
			text: "Anh sẽ không gặp lại em nữa đâu!!",
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
					type: 'delete',
					url: 'employee-detail-products/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#detail-products-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
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
			url: 'employee-img/'+id,
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
		var id = $(this).data('id');
		var count = 1;
		$.ajax({
			type: 'get',
			url: '/employee-upload-img/' + id,
			success: function(response){
				console.log(response.data);
				$('.div-all-img').remove('div');
				$.each(response.data1, function(key, value){//
					$('#show-img-products').append(
						`
						<div class="div-all-img index-img-`+value.id+`">
						<button type="button" data-id="`+value.id+`" class="remove-img" style="position: absolute;z-index: 2;right: -7px;top: -5px;background: none;border:none;"><img src="/storage/icon/close.png" style="width:22px;"></button>
						<img src="/storage/`+ value.thumbnail +`" style="position: relative;z-index: 1;" class="thumbnail-show">
						</div>
						`);
				})
				$('#product_detail_id').val(response.data.id);
			}
		})
	})
})

