$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	var b = $('#orders-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/employee-getorders',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'address', name: 'address'},
		{ data: 'phone', name: 'phone' },
		{ data: 'total', name: 'total' },
		{ data: 'status', name: 'status' },
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

	$('#orders-paid-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/employee-getorders-paid',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'address', name: 'address'},
		{ data: 'phone', name: 'phone' },
		{ data: 'total', name: 'total' },
		{ data: 'status', name: 'status' },
		{ data: 'action', name: 'action' },
		]
	});

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
				url: "/employee-orders/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					console.log(response.data);
					$('#name-show').text(response.data.name);
					$('#phone-show').text(response.data.phone);
					$('#total-show').text(response.data.total);
					$('#address-show').text(response.data.address);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})

	$('body').delegate('.btn-paid', 'click', function(e){
		e.preventDefault();
		var status = 0;
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: 'employee-orders/'+id,
			data: {
				status: status,
			},
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#orders-table').DataTable().ajax.reload();
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

	$('body').delegate('.btn-shipping', 'click', function(e){
		e.preventDefault();
		var status = 1;
		var id = $(this).attr('data-id');		
		$.ajax({
			type: 'post',
			url: 'employee-orders/'+id,
			data: {
				status: status,
			},
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#orders-table').DataTable().ajax.reload();
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

	$('body').delegate('.btn-remove-order', 'click', function(e){
		e.preventDefault();
		var status = 2;
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: 'employee-orders/'+id,
			data: {
				status: status,
			},
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#orders-table').DataTable().ajax.reload();
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
					url: 'employee-orders/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#orders-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})

	$('body').delegate('.btn-order-detail', 'click', function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		$('#modal-detail-order').modal('show');
		var b = $('#detail-orders-table').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '/employee-getdetailorders/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'qty', name: 'qty' },
			{ data: 'price', name: 'price' },
			{ data: 'total', name: 'total' },
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

	$('body').delegate('.btn-show-detail-order','click', function (e) {
		e.preventDefault();
		// $('#appendimg').html('');
		$('#modal_show_detail_order').modal('show');
			//lấy dữ liệu từ attribute data-url lưu vào biến url
			// var url=$(this).attr('href');
			var id = $(this).attr('data-id');
			
			$.ajax({
				//sử dụng phương thức get
				type: 'get',
				url: "/employee-detail-orders/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					console.log(response.data);
					$('#modal_show_detail_order #name-show').text(response.data.name);
					$('#modal_show_detail_order #qty-show').text(response.data.qty);
					$('#modal_show_detail_order #total-show').text(response.data.total);
					$('#modal_show_detail_order #price-show').text(response.data.price);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})
})

