$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	$('#components-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/admin-getcomponents',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'description', name: 'description' },
		{ data: 'thumbnail', name: 'thumbnail' },
		{ data: 'action', name: 'action' },
		]
	});

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
				console.log(response.data);
				$('#modal-add').modal('hide');
				$('#components-table').DataTable().ajax.reload();
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
				url: "/admin-components/"+id,
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
		
		e.preventDefault();
		$('#modal-edit').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: 'admin-components/' + id + '/edit',
			success: function(response){
				console.log(response.data);
				$('#id_edit').val(response.data.id);
				$('.description_edit').val(response.data.description);
				$('#edit-profile-img-tag').attr('src',"storage/"+response.data.thumbnail);
				$('#edit-profile-img-tag').css('display','block');
				$('.name_edit').val(response.data.name);
				$('#slug_edit').val(response.data.slug);
			}
		})

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
			url: 'admin-components/'+id,
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				console.log(response.data);
				$('#modal-edit').modal('hide');
				$('#components-table').DataTable().ajax.reload();
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
					url: 'admin-components/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#components-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.btn-detail-component', 'click', function(e){
		e.preventDefault();
		$('#modal-detail-component').modal('show');
		var id = $(this).data('id');
		// alert(id);
		$('#btn-add-detail-component').attr('data-id', id);
		$('#detail-components-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/getdetailcomponents/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'qty', name: 'qty' },
			{ data: 'price', name: 'price' },
			{ data: 'sale_price', name: 'sale_price' },
			{ data: 'description', name: 'description' },
			{ data: 'action', name: 'action' },
			]
		});

	})

	$('body').delegate('.btn-add-detail-component','click', function(e){
		$('#modal-add-detail-component').modal('show');
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#name-detail-component').keyup(function(){
			var data = $('#name-detail-component').val()
			$('#slug-detail-component').val(slug(data));
		});
		var component_id = $('#btn-add-detail-component').data('id');
	})

	$('#form-add-detail-component').submit(function(e){
		var component_id = $('#btn-add-detail-component').data('id');
		// alert(product_id);
		var url = $(this).attr('data-url');

		// alert(product_id);
		e.preventDefault();
		$.ajax({
			//sử dụng phương thức post
			type: 'post',
			url: url,
			data: {
				name: $('#name-detail-component').val(),
				qty: $('#quantity-detail-component').val(),
				price: $('#price-detail-component').val(),
				sale_price: $('#sale-price-detail-component').val(),
				slug: $('#slug-detail-component').val(),
				description: $('#description-detail-component').val(),
				component_id: component_id,
			},
			success: function (response) {
				$('#modal-add-detail-component').modal('hide');
				$('#detail-components-table').DataTable().ajax.reload();
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

	$('body').delegate('.btn-edit-detail-component', 'click', function (e) {
		e.preventDefault();
		$('#modal-edit-detail-component').modal('show');
		$('#edit-profile-img-tag').css('display','block');
		var id = $(this).data('id');
		function slug(str){
			var $slug = '';
			var trimmed = $.trim(str);
			$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
			return $slug.toLowerCase();
		}
		$('#edit-name-detail-component').keyup(function(){
			var data = $('#edit-name-detail-component').val()
			$('#edit-slug-detail-component').val(slug(data));
		});
		$.ajax({
			type: 'get',
			url: 'admin-detail-components/' + id + '/edit',
			success: function(response){
				console.log(response.data);
				$('#edit-id-detail-component').val(response.data.id);
				$('.edit-name-detail-component').val(response.data.name);
				$('#edit-profile-img-tag').attr('src',response.data.thumbnail);
				$('.edit-quantity-detail-component').val(response.data.qty);
				$('.edit-price-detail-component').val(response.data.price);
				$('.edit-sale-price-detail-component').val(response.data.sale_price);
				$('.edit-slug-detail-component').val(response.data.slug);
				$('.edit-description-detail-component').val(response.data.description);
				$('.edit-component-id-detail-component').val(response.data.product_id);
			}
		})


	})

	$('body').delegate('#form-edit-detail-component','submit', function(e){
		var url = $(this).attr('data-url');
		e.preventDefault();
		var id = $('#edit-id-detail-component').val();
		$.ajax({
			type: 'post',
			url: '/admin-detail-components/'+id,
			data: {
				name: $('.edit-name-detail-component').val(),
				// $('.img-edit').append('<img src="/storage/'+response.data.thumbnail+'" style="width: 100px; height: 100px; border-radius: 12px;">')
				qty: $('.edit-quantity-detail-component').val(),
				price: $('.edit-price-detail-component').val(),
				sale_price: $('.edit-sale-price-detail-component').val(),
				product_id: $('.edit-component-id-detail-component').val(),
				slug: $('.edit-slug-detail-component').val(),
				description: $('.edit-description-detail-component').val(),
			},
			success: function(response){
				// //ẩn modal add đi
				// console.log(response.data.slug);
				$('#modal-edit-detail-component').modal('hide');
				$('#detail-components-table').DataTable().ajax.reload();
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

	$('body').delegate('.btn-show-detail-component','click', function (e) {
		e.preventDefault();
		$('#appendimg').html('');
		$('#modal_dtComponent_show').modal('show');
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/admin-detail-components/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					console.log(response);
					$.each(response.data, function(key, value){
						$('#thumbnail-dtComponent-show').attr('src','/storage/' + value.thumbnail)
					})
					//hiển thị dữ liệu được controller trả về vào trong modal
					data = response.data;
					$('#name-dtComponent-show').text(data[0].name);
					$('#quantity-dtComponent-show').text(data[0].quantity);
					$('#price-dtComponent-show').text(data[0].price);
					$('#life-expectancy-dtComponent-show').text(data[0].life_expectancy);
					$('#sale-price-dtComponent-show').text(data[0].sale_price);
					$('#description-dtComponent-show').text(data[0].description);
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$('body').delegate('.btn-delete-detail-component','click',function(e){
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
					url: 'admin-detail-components/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#detail-components-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.btn-add-img-detail-component', 'click', function(e){
		$('#modal_add_img').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: '/admin-components-upload-img/' + id,
			success: function(response){
				console.log(response.data);
				$('#component_detail_id').val(response.data.id);
			}
		})
	})

})

