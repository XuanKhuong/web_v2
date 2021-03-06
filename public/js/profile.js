$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
	$('body').delegate('.edit-info', 'click', function(e){
		e.preventDefault();
		$('#modal-edit').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'get',
			url: $('.edit-info').attr('data-route'),
			success: function(response){
				console.log(response.data.thumbnail);
				$('#id_edit').val(response.data.id);
				$('.name_edit').val(response.data.name);
				$('.email_edit').val(response.data.email);
				$('.phone_edit').val(response.data.phone);
				$('.address_edit').val(response.data.address);
				$('.old_edit').val(response.data.old);
				$('#thumbimage').attr('src','/storage/'+response.data.thumbnail);
				if (response.data.gender == 'Nam' || response.data.gender == 'nam') {
					$('#nam').attr('checked',true);
				}
				if (response.data.gender == 'Nữ' || response.data.gender == 'nữ' || response.data.gender == 'Nu' || response.data.gender == 'nu') {
					$('#nu').attr('checked',true);
				}
				$('.stall_name_edit').val(response.stall.stall_name);
			}
		})
	})

	$('body').delegate('#form_edit','submit', function(e){
		
		// alert($('#email_edit').val());
		
		var id = $('#id_edit').val();
		var gender;
		if(document.getElementById('nam').checked){
			gender = "nam";
		}
		if(document.getElementById('nu').checked){
			gender = "nu";
		}
		e.preventDefault();
		var data = new FormData();
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		data.append( 'name', $('#name_edit').val());
		data.append( 'stall_name', $('#stall_name_edit').val());
		data.append( 'thumbnail', $('#uploadfile')[0].files[0]);
		data.append( 'phone', $('#phone_edit').val());
		data.append( 'address', $('#address_edit').val());
		data.append( 'email', $('#email_edit').val());
		data.append( 'old', $('#old_edit').val());
		data.append( 'gender', gender);
		$.ajax({
			type: 'post',
			url: $('#form_edit').attr('action'),
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
				if (response.errors) {
					toastr.error(response.message);
				} else {
					$('#modal-edit').modal('hide');
					setTimeout(function () {
						window.location.href= "profile";
					},1500);
					toastr.success('save success!');
				}
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