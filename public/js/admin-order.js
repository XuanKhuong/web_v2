$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function loadOrderTable ($status){
	var status;
	if ($("select[name=status-order]").val() != "") {
		status = $("select[name=status-order]").val();
	} else {
		status = null;
	}
	var t = $('#orders-table').DataTable({
		processing: true,
		serverSide: true,
		retrieve: true,
		ajax: {
            type: "POST",
            url: $('#orders-table').data('route'),
            data:  function ( d ) {
            	if ($("select[name=status-order]").val() != "") {
            		d.status = $("select[name=status-order]").val()
            	} else {
            		d.status = null
            	}
            }
        },
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'address', name: 'address'},
		{ data: 'phone', name: 'phone' },
		{ data: 'total', name: 'total' },
		{ data: 'status', name: 'status' },
		{ data: 'action', name: 'action' },
		],
	});

	t.on( 'order.dt search.dt', function () {
		t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
}

function loadOrderPaidTable(){
	var a = $('#orders-paid-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: $('#orders-paid-table').data('route'),
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'address', name: 'address'},
		{ data: 'phone', name: 'phone' },
		{ data: 'total', name: 'total' },
		{ data: 'action', name: 'action' },
		],
		"columnDefs": [ {
			"searchable": false,
			"orderable": false,
			"targets": 0
		} ],
		"order": [[ 1, 'desc' ]]
	});

	a.on( 'order.dt search.dt', function () {
		a.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
}

$(document).ready(function(){
	loadOrderTable();

	loadOrderPaidTable();
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
		url: $(this).data('route'),
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
	if ($(this).hasClass('disabled')) {
		toastr.warning('Đơn hàng này được bạn đặt từ một gian hàng khác, bạn không thể xét trạng thái này cho nó!');
	}
	else {
		e.preventDefault();
		var status = 0;
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: $(this).data('route'),
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
	}
})

$('body').delegate('.btn-shipping', 'click', function(e){
	e.preventDefault();
	var status = 1;
	var id = $(this).attr('data-id');		
	$.ajax({
		type: 'post',
		url: $(this).data('route'),
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
	if ($(this).hasClass('disabled')) {
		toastr.warning('Không thể hủy đơn hàng này do đã quá 1 ngày kể từ lúc tạo đơn hàng!')
	}
	else {
		e.preventDefault();
		var status = 2;
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: $(this).data('route'),
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
	}
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
				type: 'delete',
				url: $(this).data('route'),
				data:{
					_token: $('meta[name="csrf-token"]').attr('content'),
				},
				success: function (response) {
					$('#orders-table').DataTable().ajax.reload();
					swal("Deleted!", "Xóa thành công.", "success");
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
	var c = $('#detail-orders-table').DataTable({
		processing: true,
		serverSide: true,
		destroy: true,
		ajax: $(this).data('route'),
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'qty', name: 'qty' },
		{ data: 'price', name: 'price' },
		{ data: 'total', name: 'total' },
		{ data: 'action', name: 'action' },
		]
	});

	c.on( 'order.dt search.dt', function () {
		c.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
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
		url: $(this).data('route'),
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

$('body').delegate('#search-order-status', 'click', function (e){
	e.preventDefault();
	if ($("select[name=status-order]").val() != "") {
		var status = $("select[name=status-order]").val();
		loadOrderTable(status);
	} else {
		toastr.warning('Bạn chưa chọn trạng thái để tìm kiếm!');
	}
})

