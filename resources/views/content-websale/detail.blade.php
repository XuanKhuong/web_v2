@extends('layouts.layoutWebSale')

@section('header')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">

<style type="text/css">
	.arrow-left {
		width: 0; 
		height: 0; 
		border-top: 0px solid transparent;
		border-bottom: 10px solid transparent; 

		border-right:10px solid #ebebeb; 
		position: absolute;
		top: 10px;
		left: -9px;
	}

	.comments{
		position: relative;
		margin-left: 22px;
		padding: 12px;
		width: auto;
		height: auto;
		background-color: #ebebeb;
		border-radius: 12px;
	}

	/* width */
	::-webkit-scrollbar {
		width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		border-radius: 10px;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
		border-radius: 10px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #ccc; 
	}

	.all-answer-cmt{
		width: 100%;
		height: 100px;
		padding: 0px 30px;
		display: none;
	}

	.ip-answer-cmt{
		width: 50%;
		border-radius: 4px;
		border: 1px solid lightgray;
		padding: 7px;
	}

	.ip-answer{
		width: 100%;
		height: 50px;
		padding: 5px 30px;
		display: none;
	}
</style>

@endsection

@section('content')

<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Detail Product</h4>
		<div class="site-pagination">
			<a href="{{ route('sale-page') }}">Home</a> /
			<a href="#">Detail product</a>
		</div>
	</div>
</div>
<!-- Page info end -->


<!-- product section -->
<section class="product-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="product-pic-zoom">
					<img class="product-big-img" src="{{ asset('/storage').'/'.$image[0]->thumbnail }}" alt="" style="width: 558px; height: 570px;">
				</div>
				<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
					<div class="product-thumbs-track">
						@foreach ($image as $key => $val)
						@if ($key == 0)
						<div class="pt active" data-imgbigurl="{{ asset('/storage').'/'.$val->thumbnail }}"><img src="{{ asset('/storage').'/'.$val->thumbnail }}" alt=""></div>
						@endif
						@if ($key != 0)
						<div class="pt" data-imgbigurl="{{ asset('/storage').'/'.$val->thumbnail }}"><img src="{{ asset('/storage').'/'.$val->thumbnail }}" alt=""></div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-lg-6 product-details">
				<h2 class="p-title">{{ $product->name }}</h2>
				<h3 class="p-price">Price: {{ number_format($product->price) }}.VNĐ</h3>
				<h3 class="p-price">Quantity: 
					@if($product->qty > 0)
						{{ $product->qty }}
					@else
						<strong style="color: red;">Đã bán hết</strong>
					@endif
				</h3>
				<button href="#" data-id="{{ $product->id }}" @if($product->qty <= 0) disabled @endif class="site-btn add-card">Add To Cart</button>
				<div id="accordion" class="accordion-area">
					<div class="panel">
						<div class="panel-header" id="headingOne">
							<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">Description</button>
						</div>
						<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
							<div class="panel-body">
								{{ $product->description }}
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-header" id="headingTwo">
							<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
						</div>
						<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
							<div class="panel-body">
								<img src="./img/cards.png" alt="">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-header" id="headingThree">
							<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
						</div>
						<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
							<div class="panel-body">
								<h4>7 Days Returns</h4>
								<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="social-sharing">
					<a href=""><i class="fa fa-google-plus"></i></a>
					<a href=""><i class="fa fa-pinterest"></i></a>
					<a href=""><i class="fa fa-facebook"></i></a>
					<a href=""><i class="fa fa-twitter"></i></a>
					<a href=""><i class="fa fa-youtube"></i></a>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<p style="font-size: 25px;">Bình luận:</p>
				<div style="height: 300px; padding: 12px; overflow-x: hidden; overflow-y: auto; @if (count($get_comment) < 1)
					  		display: none;
					  @endif" class="all-comment">
					@foreach ($get_comment as $key => $comment)
					<div class="content-comment" style="width: auto; height: auto; padding:12px 0px;">
						<img src="
							@if ($comment->thumbnail == null)
								{{ asset('storage').'/img-profile/user01.png' }}
							@else 
								{{ asset('storage').'/'.$comment->thumbnail }}
							@endif
						" title="{{ $comment->name }}" style="width: 37px; height: 37px; border-radius: 50%;">
						<span style="position: relative;" class="comments"><div class="arrow-left"></div>{{ $comment->content }}</span>
					</div>
					<span style="font-size: 12px;color: #adadad;">
						{{ $comment->name }}
						-
						@if ($product->stall_id == $comment->stall_id)
							<strong style="color: red">shop</strong>
						@endif
					</span>
					@endforeach
				</div>
			</div>

			<div class="col-lg-12 col-md-12" style="margin-top: 5%;">
				<textarea rows="4" style="border-radius: 12px; width: 100%; padding: 12px;" placeholder="Bình luận" id="comment"></textarea>
				@if (Auth::check())
			 		<input type="hidden" name="user_id" class="user_id" id="user_id" value="{{ Auth::user()->id }}">
			 	@endif
				<input type="hidden" name="product_dt_id" class="product_dt_id" id="product_dt_id" value="{{ $product->id }}">
				<input type="hidden" name="product_id" class="product_id" id="product_id" value="{{ $product->product_id }}">
				<a 
				 	@if (!Auth::check())
				 		href="{{ route('login.getLogin') }}" 
						class="btn btn-info text-white"
					@else
						class="btn btn-info text-white send-comment"

						data-user-stall-id="{{ Auth::user()->stall_id }}"
				 	@endif

				 	data-stall-id="{{ $product->stall_id }}"
				>
					Gửi
				</a>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->


<!-- RELATED PRODUCTS section -->
<section class="related-product-section">
	<div class="container">
		<div class="section-title">
			{{-- Our products are preferred --}}
			<h2>OUR PRODUCTS ARE PREFERRED</h2>
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

	@include('content-modals.modal-websale')
</section>
<!-- RELATED PRODUCTS section end -->

@endsection

@section('footer')

<script type="text/javascript" src="{{ asset('js/websale.js') }}"></script>

@endsection