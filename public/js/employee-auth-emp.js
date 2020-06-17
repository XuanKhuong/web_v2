$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	var b = $('#employees-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/getemployees',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'phone', name: 'phone' },
		{ data: 'address', name: 'address'},
		{ data: 'gender', name: 'gender' },
		{ data: 'old', name: 'old' },
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
		$('#modal-add').modal('show');
	})


	$('#form-add').submit(function(e){
		var url = $(this).attr('data-url');
		e.preventDefault();
		var gender;
		if(document.getElementById('nam-add').checked){
			gender = "Nam";
		}
		if(document.getElementById('nu-add').checked){
			gender = "Nữ";
		}

		var power = 1;
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name').val());
		data.append( 'thumbnail', $('#uploadfile-add')[0].files[0]);
		data.append( 'email', $('#email').val());
		data.append( 'phone', $('#phone').val());
		data.append( 'address', $('#address').val());
		data.append( 'old', $('#old').val());
		data.append( 'gender', gender);
		data.append( 'power', power);
		data.append( 'password', $('#password').val());
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
				$('#employees-table').DataTable().ajax.reload();
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
				url: "/employees/"+id,
				//nếu thực hiện thành công thì chạy vào success
				success: function (response) {
					$('#name-show').text(response.data.name);
					$('#phone-show').text(response.data.phone);
					$('#gender-show').text(response.data.gender);
					$('#old-show').text(response.data.old);
					$('#address-show').text(response.data.address);
					if (response.data.thumbnail != null) {
						$('#thumbnail-show').attr('src','/storage/' + response.data.thumbnail)
					}
					if (response.data.thumbnail == null) {
						if (response.data.gender == 'Nữ') {
							$('#thumbnail-show').attr('src','/storage/img-profile/user02.jpg')
						}
						if (response.data.gender == 'Nam') {
							$('#thumbnail-show').attr('src','/storage/img-profile/user01.png')
						}
					}
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
			url: 'employees/' + id + '/edit',
			success: function(response){
				console.log(response.data);
				$('#id_edit').val(response.data.id);
				$('.name_edit').val(response.data.name);
				$('.phone_edit').val(response.data.phone);
				$('.address_edit').val(response.data.address);
				$('.old_edit').val(response.data.old);
				$('.user_id_edit').val(response.data.user_id);
				if (response.data.thumbnail != null) {
					$('#thumbimage').attr('src','/storage/'+response.data.thumbnail);
				}
				if (response.data.thumbnail == null) {
					if (response.data.gender == 'Nữ') {
						$('#thumbimage').attr('src','/storage/img-profile/user02.jpg')
					}
					if (response.data.gender == 'Nam') {
						$('#thumbimage').attr('src','/storage/img-profile/user01.png')
					}
				}
				
				if (response.data.gender == 'Nam' || response.data.gender == 'nam') {
					$('#nam').attr('checked',true);
				}
				if (response.data.gender == 'Nữ' || response.data.gender == 'nữ' || response.data.gender == 'Nu' || response.data.gender == 'nu') {
					$('#nu').attr('checked',true);
				}
			}
		})
	})

	$('body').delegate('#form_edit','submit', function(e){
		
		// alert($('#email_edit').val());
		
		var id = $('#id_edit').val();
		var gender;
		if(document.getElementById('nam').checked){
			gender = "Nam";
		}
		if(document.getElementById('nu').checked){
			gender = "Nữ";
		}
		e.preventDefault();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name_edit').val());
		data.append( 'thumbnail', $('#uploadfile')[0].files[0]);
		data.append( 'phone', $('#phone_edit').val());
		data.append( 'address', $('#address_edit').val());
		data.append( 'old', $('#old_edit').val());
		data.append( 'user_id', $('#user_id_edit').val());
		data.append( 'gender', gender);
		$.ajax({
			type: 'post',
			url: 'employees/'+id,
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#employees-table').DataTable().ajax.reload();
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
					url: 'employees/'+id,
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('#employees-table').DataTable().ajax.reload();
						swal("Thôi xong!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
		
	})
})

