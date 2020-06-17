$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
	$('#users-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/admin-getusers',
		columns: [
		{ data: 'id', name: 'id' },
		{ data: 'name', name: 'name' },
		{ data: 'email', name: 'email' },
		{ data: 'power', name: 'power' },
		{ data: 'action', name: 'action' },
		]
	});

	$('body').delegate('.btn-edit', 'click', function (e) {
		e.preventDefault();
		$('#modal-edit').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: 'admin-users/' + id + '/edit',
			success: function(response){
				console.log(response.data);
				$('#id_edit').val(response.data.id);

				if (response.data.admin == 1) {
					$('#admin_edit').attr('checked',true);
				}
				if (response.data.employee == 1) {
					$('#employee_edit').attr('checked',true);
				}
				if (response.data.customer == 1) {
					$('#customer_edit').attr('checked',true);
				}
			}
		})
	})

	$('body').delegate('#form_edit','submit', function(e){
		
		// alert($('#email_edit').val());
		
		var id = $('#id_edit').val();
		
		var admin;
		var employee;
		var customer;
		if(document.getElementById('admin_edit').checked){
			admin = 1;
			employee = 0;
			customer = 0;
		}
		if(document.getElementById('employee_edit').checked){
			admin = 0;
			employee = 1;
			customer = 0;
		}
		if(document.getElementById('customer_edit').checked){
			admin = 0;
			employee = 0;
			customer = 1;
		}
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'admin-users/'+id,
			data: {
				admin: admin,
				employee: employee,
				customer: customer,
			},
			success: function(response){
				$('#modal-edit').modal('hide');
				$('#users-table').DataTable().ajax.reload();
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
})

