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

		@include('commons.chat')
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

	@include('commons.chat_processing')

</body>
</html>
