@extends('layouts.layoutWebSale')

@section('header')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">
<style type="text/css">
	.pi-text>a:hover{
		color: red;
	}
</style>

@endsection

@section('content')

<!-- Hero section -->
<section class="hero-section">
	<div class="hero-slider owl-carousel">
		<div class="hs-item set-bg" data-setbg="{{ asset('css/css-websale/img/bg.jpg') }}">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-7 text-white">
						<span>New Laps</span>
						<h2>Lorem</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum sus-pendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
						<a href="#" class="site-btn sb-line">DISCOVER</a>
						<a href="#" class="site-btn sb-white">ADD TO CART</a>
					</div>
				</div>
				<div class="offer-card text-white">
					<span>from</span>
					<h2>$29</h2>
					<p>SHOP NOW</p>
				</div>
			</div>
		</div>
		<div class="hs-item set-bg" data-setbg="{{ asset('css/css-websale/img/bg-2.jpg') }}">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-7 text-white">
						<span>New Product</span>
						<h2>Smart Phone | Laptop</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum sus-pendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
						<a href="#" class="site-btn sb-line">DISCOVER</a>
						<a href="#" class="site-btn sb-white">ADD TO CART</a>
					</div>
				</div>
				<div class="offer-card text-white">
					<span>from</span>
					<h2>$29</h2>
					<p>SHOP NOW</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="slide-num-holder" id="snh-1"></div>
	</div>
</section>
<!-- Hero section end -->



<!-- Features section -->
<section class="features-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 p-0 feature">
				<div class="feature-inner">
					<div class="feature-icon">
						<img src="{{ asset('css/css-websale/img/icons/1.png') }}" alt="#">
					</div>
					<h2>Fast Secure Payments</h2>
				</div>
			</div>
			<div class="col-md-4 p-0 feature">
				<div class="feature-inner">
					<div class="feature-icon">
						<img src="{{ asset('css/css-websale/img/icons/2.png') }}" alt="#">
					</div>
					<h2>Premium Products</h2>
				</div>
			</div>
			<div class="col-md-4 p-0 feature">
				<div class="feature-inner">
					<div class="feature-icon">
						<img src="{{ asset('css/css-websale/img/icons/3.png') }}" alt="#">
					</div>
					<h2>Free & fast Delivery</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Features section end -->
<!-- letest product section end -->

<!-- letest product section -->
@if (isset($love_product))
<section class="top-letest-product-section">
	<div class="container">
		<div class="section-title">
			{{-- Our products are preferred --}}
			<h2>SẢN PHẨM BÁN CHẠY</h2>
		</div>
		<div class="product-slider owl-carousel">
			@foreach ($love_product as $val1)
			<div class="product-item">
				<div class="pi-pic" {{-- style="width: 264px; height: 409px;" --}}>
					<img src="{{ asset('/storage').'/'.$val1->thumbnail }}" alt="" style="width: 264px; height: 300px;">
					<div class="pi-links">
						@if($val1->qty > 0)
							<a data-id="{{ $val1->id }}" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
						@endif
						<button style="box-shadow: 0px 0 32px rgba(0, 0, 0, 0.2);background: #ec545438;border-radius: 50%;border:none;padding: 5.2px 9px;cursor: pointer;" class="wishlist-btn love-product" data-id="{{ $val1->id }}"><i class="flaticon-heart"></i></button>
					</div>
				</div>
				<div class="pi-text">
					@if ($val1->price != $val1->sale_price)
					<h6 style="text-decoration: line-through; color: red">{{ number_format($val1->price) }}.VNĐ</h6>
					<h6>{{ number_format($val1->sale_price) }}.VNĐ</h6><br>
					@endif
					@if ($val1->price == $val1->sale_price)
					<h6>{{ number_format($val1->sale_price) }}.VNĐ</h6><br>
					@endif
					<p><a class="get-detail" href="{{ URL::to('/').'/get-detail-product/'.$val1->slug }}" style="color: black;">{{ $val1->name }} @if($val1->qty <= 0)<strong style="color: red;"> (Đã hết) </strong>@endif</a> </p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif

<section class="product-filter-section">
	<div class="container" id="count-product" data-count="{{ count($normal_product) }}">
		@foreach ($normal_product as $key => $val2)
			@if (count($val2['product_dt']) > 0)
			<div class="section-title">
				<h2>{{ $val2['name'] }} <!-- <button type="button" class="filter-product-{{ $key }} filter-product" style="background: none; border: none;" value="0"><i class="fa fa-search " style="color: gray;font-size: 41px;padding: 12px;bottom: 27px;"></i></button> --></h2>
				<!-- <input class="form-control seach-product-{{ $key }} seach-product" id="seach-product" type="text" placeholder="Search.." style="display: none; box-shadow: 10px 10px 5px grey;"> -->
			</div>
			<!-- <ul class="product-filter-menu">
				<li><a class="filter-btn" id="all">All</a></li>
				@foreach ($val2['manu'] as $man_val)
				<li><a class="filter-btn" id="{{ $man_val->id }}">{{ $man_val->name }}</a></li>
				@endforeach
			</ul> -->
			<div class="row list-all-product-{{ $key }}">
				@foreach ($val2['product_dt'] as $val)
				<div class="col-lg-3 col-sm-6 card-product-{{ $key }} {{ $val->manufacturer_id }}" style="margin-bottom: 40px;">
					<div class="product-item">
						<div class="pi-pic">
							<img src="{{ asset('/storage').'/'.$val->thumbnail }}" style="width: 264px; height: 300px;" alt="">
							<div class="pi-links">
								@if($val->qty > 0)
									<a href="#" data-id="{{ $val->id }}" data-stall="{{ $val['stall_id'] }}" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
								@endif
								<button style="box-shadow: 0px 0 32px rgba(0, 0, 0, 0.2);background: white;border-radius: 50%;border:none;padding: 5.2px 9px;cursor: pointer;" class="wishlist-btn love-product" data-id="{{ $val->id }}"><i class="flaticon-heart"></i></button>
							</div>
						</div>
						<div class="pi-text">
							@if ($val->price != $val->sale_price)
							<h6 style="text-decoration: line-through; color: red">{{ number_format($val->price) }}.VNĐ</h6>
							<h6>{{ number_format($val->sale_price) }}.VNĐ</h6><br>
							@endif
							@if ($val->price == $val->sale_price)
							<h6>{{ number_format($val->sale_price) }}.VNĐ</h6><br>
							@endif
							<p><a href="{{ URL::to('/').'/get-detail-product/'.$val->slug }}" style="color: black;">{{ $val->name }}</a> @if($val->qty <= 0) <strong style="color: red;">(Đã hết)</strong>@endif </p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			@endif
		@endforeach
		<div class="text-center pt-5">
			<button class="site-btn sb-line sb-dark">LOAD MORE</button>
		</div>
	</div>
</section>

@include('content-modals.modal-websale')

@endsection

@section('footer')

<script type="text/javascript" src="{{ asset('js/websale.js') }}"></script>

@endsection