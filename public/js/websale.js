$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){

	$('body').delegate('.add-card','click',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var stall_id = $(this).attr('data-stall');
		$.ajax({
			type: 'post',
			url: url + '/add-cart/'+id,
			data:{
				stall_id: stall_id
			},
			success: function(response){
				$('.body-cart').children().remove();
				$.each(response.data, function(key, value){
					$('.body-cart').append(`
						<tr class="cart-product-`+value.id+`">
						<td class="w-25">
						<img src="`+url+`/storage/`+value.attributes['img']+`" class="img-fluid img-thumbnail" alt="Sheep" style="width: 157px;height: 110px;">
						</td>
						<td><span class="cart-name">`+value.name+`</span></td>
						<td><span class="cart-price">`+value.price+`</span></td>
						<td class="qty"><input type="text" class="form-control" id="input1" value="`+value.quantity+`" data-id="`+value.id+`"></td>
						<td>
						<a href="#" class="btn btn-danger btn-sm removeOneProduct" data-id="`+value.id+`">
						<i class="fa fa-times"></i>
						</a>
						</td>
						</tr>
						`);
				})
				$('.all-total').text(response.total);
				
			},
			error: function (jq, status, throwE){

			}
		})
		$('#cartModal').modal('show');
	})

	$('body').delegate('.removeOneProduct','click',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var tr_remove = '.cart-product-'+id;
		$.ajax({
			type: 'delete',
			url: url + '/delete-one/'+id,
			success: function(response){
				$('.body-cart').children(tr_remove).remove();
				$('.all-total').text(response.total);
				toastr.success(response.data);
			},
			error: function (jq, status, throwE){

			}
		})
	})

	$('body').delegate('#val_qty','keyup',function(e){
		e.preventDefault();
		console.log($(this).attr('data'));
		if ($(this).val() >= $(this).attr('data')) {
			$(this).val($(this).attr('data'));
		}
		if ($(this).val() < 0) {
			$(this).val(1);
		}
	})

	$('body').delegate('#input1','keyup',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: url + '/update-cart/'+id,
			data: {
				qty: $(this).val(),
			},
			success: function(response){
				$(this).val(response.data);
				$('.all-total').text(response.total);
			},
			error: function (jq, status, throwE){

			}
		})
	})

	$('body').delegate('.clear-cart','click',function(e){
		e.preventDefault();
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
					url: url + '/delete-all-cart',
					data:{
						_token: $('meta[name="csrf-token"]').attr('content'),
					},
					success: function (response) {
						$('.body-cart').children().remove();
						swal("Deleted!", "Xóa thành công.", "success");
					},
					error: function (error) {

					}
				})
			}
		})
	})

	$('body').delegate('.show-cart','click',function(){
		$.ajax({
			type: 'get',
			url: url + '/get-cart',
			success: function(response){
				$('.body-cart').children().remove();
				$.each(response.data, function(key, value){
					$('.body-cart').append(`
						<tr class="cart-product-`+value.id+`">
						<td class="w-25">
						<img src="`+url+`/storage/`+value.attributes['img']+`" class="img-fluid img-thumbnail" alt="Sheep" style="width: 157px;height: 110px;">
						</td>
						<td><span class="cart-name">`+value.name+`</span></td>
						<td><span class="cart-price">`+value.price+`</span></td>
						<td class="qty"><input type="text" class="form-control" id="input1" value="`+value.quantity+`" data-id="`+value.id+`"></td>
						<td>
						<a href="#" class="btn btn-danger btn-sm removeOneProduct" data-id="`+value.id+`">
						<i class="fa fa-times"></i>
						</a>
						</td>
						</tr>
						`);
				})
				$('.all-total').text(response.total);
				
			},
			error: function (jq, status, throwE){

			}
		})
		$('#cartModal').modal('show');
	})

	$('body').delegate('.checkout','click',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'get',
			url: url + '/get-info/'+id,
			success: function(response){
				if (response.error == false) {
					console.log(response.data);
					$('#cartInfo').modal('show');
					$('#name-info').val(response.data[0].name);
					$('#address-info').val(response.data[0].address);
					$('#email-info').val(response.data[0].email);
					$('#phone-info').val(response.data[0].phone);
				} else {
					toastr.warning('Bạn cần đăng nhập để thực hiện việc đặt đơn hàng!');
					setTimeout(function () {
						window.location.href= url + "/login";
					},1500);
				}
			},
			error: function (jq, status, throwE){

			}
		})
	})

	$('#cartInfo').on('show.bs.modal', function(){
		$('#cartModal').modal('hide');
	});

	$('#cartInfo').on('hide.bs.modal', function(){
		$('#cartModal').modal('show');
	});

	var indexScroll = 70;

	$(window).scroll(function(){
		var thisIndex = $(this).scrollTop();
		if (thisIndex > indexScroll) {
			$('.cart-scroll').css({'display':'block'});
		}
		else{
			$('.cart-scroll').css({'display':'none'});
		}
	})

	/*for (var i = 0; i < $('#count-product').attr('data-count'); i++) {
		$(".seach-product-"+ i).on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$(".list-all-product-"+ i +" .card-product-"+ i).filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$('body').delegate('.filter-product-'+ i,'click',function(){
			console.log('.filter-product-'+ i);
			if ($(this).val() == 0) {
				$('.seach-product-'+ i).css({'display':'block'});
				$(this).val(1);
			}
			else{
				$('.seach-product-'+ i).css({'display':'none'});
				$(this).val(0);
			}
		})
	}*/

	$('body').delegate('.filter-btn','click',function(){
		if (this.id == 'all') {
			$('.list-all-product > .card-product').fadeIn(450);
		} else {
			var $el = $('.' + this.id).fadeIn(450);
			$('.list-all-product > .card-product').not($el).hide();
		}
	})

	$('body').delegate('.get-bill','click',function(e){
		$.ajax({
			type: 'post',
			url: url + '/bill',
			data: {
				name: $('#form-bill #name-info').val(),
				address: $('#form-bill #address-info').val(),
				email: $('#form-bill #email-info').val(),
				phone: $('#form-bill #phone-info').val(),
			},
			success: function(response){
				$('.body-cart').children().remove();
				$('.all-total').text(0);
				$('#cartInfo').modal('hide');
				toastr.success('Đơn hàng đã được tạo thành công, hãy kiểm tra email bạn đã đăng ký để xác nhận đơn hàng!');
			},
			error: function (jq, status, throwE){

			}
		})
	})

	$('body').delegate('.send-comment','click',function(e){
		var comment = $('#comment').val();
		var user_id = $('#user_id').val();
		var product_dt_id = $('#product_dt_id').val();
		var product_id = $('#product_id').val();
		var user_stall_id = $(this).attr('data-user-stall-id');
		var stall_id = $(this).attr('data-stall-id');

		if ($('#comment').val() == "") {
			toastr.warning('Bạn chưa nhập nội dung bình luận!');
		}

		else {
			$.ajax({
				type: 'post',
				url: url + '/post-comment',
				data: {
					content: comment,
					user_id: user_id,
					product_dt_id: product_dt_id,
					product_id: product_id,
				},
				success: function(response){
					var old_comment = $('.all-comment').children();
					$('.all-comment').css({'display':'block'});
					if ( user_stall_id == stall_id ) {
						$('.all-comment').html(`

							<div class="content-comment" style="width: auto; height: auto; padding:12px 0px;">
							<img src="`+url+`/storage/`+ response.data.thumbnail +`" title="`+ response.data.name +`" style="width: 37px; height: 37px; border-radius: 50%;">
							<span style="position: relative;" class="comments"><div class="arrow-left"></div>`+ comment +`</span>
							</div>
							<span style="font-size: 12px;color: #adadad;">
							`+ response.data.name +`
							-
							<strong style="color: red">shop</strong>
							&nbsp;&nbsp;
							<button style="border: none; background: none; color: #adadad; cursor: pointer; padding: 0px;">Trả lời</button >
							</span>

							`);
					} else {
						$('.all-comment').html(`

							<div class="content-comment" style="width: auto; height: auto; padding:12px 0px;">
							<img src="`+url+`/storage/`+ response.data.thumbnail +`" title="`+ response.data.name +`" style="width: 37px; height: 37px; border-radius: 50%;">
							<span style="position: relative;" class="comments"><div class="arrow-left"></div>`+ comment +`</span>
							</div>
							<span style="font-size: 12px;color: #adadad;">
							`+ response.data.name +`
							-
							<button style="border: none; background: none; color: #adadad; cursor: pointer; padding: 0px;">Trả lời</button >
							</span>

							`);
					}

					$('.all-comment').append(old_comment);
					$('#comment').val("");
					toastr.success('đăng bình luận thành công!');
				},
				error: function (jq, status, throwE){

				}
			})
		}
	})

	// for (var i = $('.all-comment').attr({'data-num-cmt'}) - 1; i >= 0; i--) {
	// 	$('body').delegate('.btn-answer-cmt-'+i+'', 'click', function(){
	// 		if ($(this).attr('data-flag') == 0) {
	// 			$('.ip-answer-'+i+'').css({'display':'block'});
	// 			$(this).attr({'data-flag':'1'});
	// 		} else {
	// 			$('.ip-answer-'+i+'').css({'display':'none'});
	// 			$(this).attr({'data-flag':'0'});
	// 		}
	// 	});
	// }

	$( ".btn-answer-cmt" ).each(function( index ) {
		$(this).on('click', function(){
			if ($(this).attr('data-flag') == 0) {
				$('.ip-answer-'+index+'').css({'display':'block'});
				$(this).attr({'data-flag':'1'});
			} else {
				$('.ip-answer-'+index+'').css({'display':'none'});
				$(this).attr({'data-flag':'0'});
			}
		});
	});
})