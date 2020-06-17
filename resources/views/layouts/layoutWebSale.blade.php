<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Star</title>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content=" Divisima | eCommerce Template">
	<meta name="keywords" content="divisima, eCommerce, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="IALyImchqCQ04gcF8nCdqJ7ECAc4w2qBAoItPhSfVxU" />
	<!-- Favicon -->
	<link href="{{ asset('css/css-websale/img/favicon.ico') }}" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/flaticon.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/slicknav.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/jquery-ui.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/owl.carousel.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/animate.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/css-websale/css/style.css') }}"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	@yield('header')
	<style type="text/css">
		/* width */
		::-webkit-scrollbar {
		  width: 0px;
		}

		img {
			object-fit: cover;
		}
	</style>

	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section -->
	<header class="header-section">
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 text-center text-lg-left">
						<!-- logo -->
						<a href="./index.html" class="site-logo">
							<img src="{{ asset('css/css-websale/img/logo.png') }}" alt="">
						</a>
					</div>
					<div class="col-xl-6 col-lg-5">
						<form class="header-search-form">
							<input type="text" id="myInput" placeholder="Search on divisima ....">
							<button><i class="flaticon-search"></i></button>
						</form>
					</div>
					<div class="col-xl-4 col-lg-5">
						<div class="user-panel">
							@if (!(Auth::check()))
							<div class="up-item">
								<i class="flaticon-profile"></i>
							<a href="{{ route('login.getLogin') }}">Login</a>
							</div>
							@endif
							@if (Auth::check() && Auth::user()->admin)
							<div class="up-item">
								<i class="flaticon-profile"></i>
								<a href="{{ route('admin.info') }}">Account</a>
							</div>
							@endif

							@if (Auth::check() && Auth::user()->customer)
							<div class="up-item">
								<i class="flaticon-profile"></i>
								<a href="{{ route('customer.info') }}">Account</a>
							</div>
							@endif
							<div class="up-item" style="cursor: pointer;">
								<div class="shopping-card">
									<i class="flaticon-bag"></i>
								</div>
								<a class="show-cart">Shopping Cart</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<nav class="main-navbar">
			<div class="container">
				<!-- menu -->
				<ul class="main-menu">
					<li><a href="{{ asset('/') }}">Trang chủ</a></li>
					@foreach ($cate_products as $cate_product)
					<li><a href="#">{{ $cate_product->name }}</a>
						@if (sizeof($cate_product['manufacturer_products']) != 0)
						<ul class="sub-menu">
							@foreach ($cate_product['manufacturer_products'] as $manufacturer_product)
							<li>
								<a href="{{ route('product.getManufacturerProduct', ['id' => $manufacturer_product['id'], 'product_id' => $manufacturer_product['product_id']]) }}">
									@if (!empty($manufacturer_product->thumbnail))
									<img src="{{ asset('/storage').'/'.$manufacturer_product->thumbnail }}" style="width: 36px; height: 36px; border-radius: 12px;">
									@endif
									&nbsp&nbsp&nbsp&nbsp
									{{ $manufacturer_product->name }}
								</a>
							</li>
							@endforeach
						</ul>
						@endif
					</li>
					@endforeach
				</ul>
			</div>
		</nav>
	</header>
	<!-- Header section end -->

	@yield('content')

	<!-- Product filter section -->
	
	<!-- Product filter section end -->


	<!-- Banner section -->
	<section class="banner-section">
		<div class="container">
			<div class="banner set-bg" data-setbg="{{ asset('css/css-websale/img/banner-bg.jpg') }}">
				<div class="tag-new">NEW</div>
				<span>New Arrivals</span>
				<h2>STRIPED SHIRTS</h2>
				<a href="#" class="site-btn">SHOP NOW</a>
			</div>
		</div>
	</section>
	<!-- Banner section end  -->


	<!-- Footer section -->
	<section class="footer-section">
		<div class="container">
			<div class="footer-logo text-center">
				<a href="index.html"><img src="{{ asset('css/css-websale/img/logo-light.png') }}" alt=""></a>
			</div>
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget about-widget">
						<h2>About</h2>
						<p>Donec vitae purus nunc. Morbi faucibus erat sit amet congue mattis. Nullam frin-gilla faucibus urna, id dapibus erat iaculis ut. Integer ac sem.</p>
						<img src="{{ asset('css/css-websale/img/cards.png') }}" alt="">
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget about-widget">
						<h2>Questions</h2>
						<ul>
							<li><a href="">About Us</a></li>
							<li><a href="">Track Orders</a></li>
							<li><a href="">Returns</a></li>
							<li><a href="">Jobs</a></li>
							<li><a href="">Shipping</a></li>
							<li><a href="">Blog</a></li>
						</ul>
						<ul>
							<li><a href="">Partners</a></li>
							<li><a href="">Bloggers</a></li>
							<li><a href="">Support</a></li>
							<li><a href="">Terms of Use</a></li>
							<li><a href="">Press</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget about-widget">
						<h2>Questions</h2>
						<div class="fw-latest-post-widget">
							<div class="lp-item">
								<div class="lp-thumb set-bg" data-setbg="{{ asset('css/css-websale/img/blog-thumbs/1.jpg') }}"></div>
								<div class="lp-content">
									<h6>what shoes to wear</h6>
									<span>Oct 21, 2018</span>
									<a href="#" class="readmore">Read More</a>
								</div>
							</div>
							<div class="lp-item">
								<div class="lp-thumb set-bg" data-setbg="{{ asset('css/css-websale/img/blog-thumbs/2.jpg') }}"></div>
								<div class="lp-content">
									<h6>trends this year</h6>
									<span>Oct 21, 2018</span>
									<a href="#" class="readmore">Read More</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget contact-widget">
						<h2>Questions</h2>
						<div class="con-info">
							<span>C.</span>
							<p>Your Company Ltd </p>
						</div>
						<div class="con-info">
							<span>B.</span>
							<p>1481 Creekside Lane  Avila Beach, CA 93424, P.O. BOX 68 </p>
						</div>
						<div class="con-info">
							<span>T.</span>
							<p>+53 345 7953 32453</p>
						</div>
						<div class="con-info">
							<span>E.</span>
							<p>office@youremail.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="social-links-warp">
			<div class="container">
				<div class="social-links">
					<a href="" class="instagram"><i class="fa fa-instagram"></i><span>instagram</span></a>
					<a href="" class="google-plus"><i class="fa fa-google-plus"></i><span>g+plus</span></a>
					<a href="" class="pinterest"><i class="fa fa-pinterest"></i><span>pinterest</span></a>
					<a href="" class="facebook"><i class="fa fa-facebook"></i><span>facebook</span></a>
					<a href="" class="twitter"><i class="fa fa-twitter"></i><span>twitter</span></a>
					<a href="" class="youtube"><i class="fa fa-youtube"></i><span>youtube</span></a>
					<a href="" class="tumblr"><i class="fa fa-tumblr-square"></i><span>tumblr</span></a>
				</div>

				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --> 
				<p class="text-white text-center mt-5">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

			</div>
		</div>
		<i class="fa fa-opencart cart-scroll show-cart" style="color: gray;font-size: 41px;padding: 12px;bottom: 27px;position: fixed;right: 20px; display: none;"></i>

		<div class="khung-ban-chat" style="background-color: white;position: fixed;right: 456px;width: 327px;bottom: 0px;height: auto;border-top-left-radius: 12px;border-right: 1px solid lightgray; z-index: 999999; border: 1px solid lightgray;" >
			<div class="body-chat" id="body-chat-partner" style="width: 100%; height: 438px; padding: 0px 12px;overflow: auto; display: none;">
				
			</div>
		</div>
		<div class="khung-chat" style="background-color: white;position: fixed;right: 129px;width: 327px;bottom: 0px;height: auto; border-top-right-radius: 12px; border-top-left-radius: 12px; z-index: 999999; border: 1px solid lightgray;"> 
			<button class="header-chat btn btn-info" style="width: 100%; border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;border-top-right-radius: 9.5px;border-top-left-radius: 9.5px;" data-flag="0" 
			@if (Auth::check())
			data-route="{{ route('chatPartner', Auth::user()->id) }}"
			@endif
			data-id="@if(Auth::check()){{ Auth::user()->id }}@endif">Chat </button>
			<div class="body-chat" id="body-chat" data-chat="" style="width: 100%; height: 400px; padding: 12px;display: none;"> 
				<div class="container" id="all-message" style="width: 100%; height: 80%;overflow: auto;">
				</div>
				<div class="container" style="width: 100%;height: 20%;padding-top: 2%;border-top: 1px solid lightgray;">
					<form action="" method="post" class="row">
						@csrf
						<input type="hidden" name="user_id" id="user_id" @if(Auth::check()) value="{{ Auth::user()->id }}" @endif>
						<input type="hidden" name="stall_manager_id" id="partner_id">
						<div class="col-md-9 col-sm-9" style="padding: 0px;">
							<textarea cols="30" rows="3" id="content" disabled="disabled">

							</textarea>
						</div>
						<div class="col-md-2 col-sm-2">
							<button type="submit" class="btn btn-info" id="testSubmit">
								Send
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer section end -->



	<!--====== Javascripts & Jquery ======-->
	<script src="{{ asset('css/css-websale/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/jquery.slicknav.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/jquery.nicescroll.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('css/css-websale/js/main.js') }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/Myglobal.js') }}"></script>
	<script src='{{ asset("js/app.js") }}'></script>
	@yield('footer')

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var url = "{{ URL::to('/') . '/' }}";

		$('.header-chat').on('click', function(e){
			e.preventDefault();

			if ($(this).attr('data-flag') == 0) {
				if ($(this).attr('data-id') != "") {
					$.ajax({
						url: $(this).data('route'),
						type: 'GET',
						data: {
							"user_id": $(this).attr('data-id'),
						},
						success: function(response){
							$("#body-chat-partner").children().remove();
							$('#body-chat-partner').html(`
								<div class="row">
									<div style="width: 100%;height: 38px;border-bottom: 1px solid lightgray;text-align: center;padding: 8px;">
										<p style="text-align: center;vertical-align: middle;"> Cuộc trò chuyện </p>
									</div>
								</div>
							`);

							$.each(response.data, function(key, value){
								$.each(value, function(key, value){
									$('#body-chat-partner').append(`
										<div class="row content-partner" style="margin-top: 12px;"> 
											<div class="col-md-3">
												<img src="`+url+`storage/`+value.thumbnail+`" alt="placeholder+image" style="width:50px;height:50px;border-radius:50%;">
											</div>
											<div class="col-md-9"> 
												<a data-chat="`+value.chat_id+`" data-partner="`+value.partner_id+`" class="reply-mess btn" style="background-color: lightgray; padding: 12px; border-radius: 12px; text-align: left; border: none;">
													`+value.name+`
												</a>
											</div>
										</div>
									`);
								})
							});
						},
						error:  function(response){
							console.log(response.message);
						}
					})
				} else {
					toastr.warning('Bạn chưa đăng nhập để bắt đầu cuộc trò chuyện!');
				}
				$('.body-chat').css({'display':'block'});
				$('button.header-chat').css({'border-top-left-radius':'0px'});
				$(this).attr({'data-flag':'1'});
			} else {
				$('.body-chat').css({'display':'none'});
				$('button.header-chat').css({'border-top-left-radius':'9.5px'});
				$(this).attr({'data-flag':'0'});
			}
		});

		$('body').delegate('.reply-mess', 'click', function(e){
			e.preventDefault();
			var name_partner = $(this).html();
			$('button.header-chat').html($.trim(name_partner));
			$('#content').removeAttr('disabled');
			$('#body-chat').attr({'data-chat': $(this).attr('data-chat')});
			$('#partner_id').val($(this).attr('data-partner'));
			$.ajax({
				type: 'GET',
				url: url + 'getMess/' + $(this).attr('data-chat'),
				success: function(response){
					$("#all-message").children().remove();
					// setTimeout(function(){
						$.each(response.data, function(key, value){
							@if (Auth::check()) {
								if (value.sender_id == {{ Auth::user()->id }}) {
									$('#all-message').append(`
										<div class="row"> 
											<div style="float: right; width: 100%;"> 
												<p class="mess" style="background-color: lightblue; padding: 12px;text-align: right; width: auto;max-width: 233px; float: right;border-radius: 12px;">
													`+value.content+`
												</p>
											</div>
										</div>
									`);
								} else {
									$('#all-message').append(`
										<div class="row"> 
											<div style="float: left; width: 100%;"> 
												<p class="mess" style="background-color: lightgray; padding: 12px;text-align: left; width: auto;max-width: 233px; float: left;border-radius: 12px;">
													`+value.content+`
												</p>
											</div>
										</div>
									`);
								}
							}
							@endif
						});
						updateScroll();
					// }, 500);

				},
				error:  function(response){
					console.log(response.message);
				}
			})
		});

		$('#testSubmit').on('click', function (e){
			e.preventDefault();
			console.log("join ajax");
			$.ajax({
				url: url + '/sendMess',
				type: 'POST',
				data: {
                	"content": $('#content').val(),
                	"user_id": $('#user_id').val(),
                	"partner_id": $('#partner_id').val(),
                	"chat_id": $('#body-chat').attr('data-chat')
	            },
	            success: function(data){
					console.log(data)
	            	// $('#content').val('');
	            	updateScroll();
	            },
	            error:  function(error){
	            	console.log(error);
	            }
	        })
		})

		function updateScroll(){
			var element = document.getElementById("all-message");
			element.scrollTop = element.scrollHeight;
		}

		/* var socket = io(window.location.hostname + ":6001");

		socket.on('myweb_database_test:message', function(data){
			console.log('ok');
		}); */

		
	</script>

</body>
</html>
