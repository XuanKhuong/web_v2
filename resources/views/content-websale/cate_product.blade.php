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

<!-- Category section -->
<section class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 order-2 order-lg-1">
				<div class="filter-widget mb-0">
					<h2 class="fw-title">refine by</h2>
					<div class="price-range-wrap">
						<h4>Price</h4>
                        <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="10" data-max="270">
							<div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
							<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;">
							</span>
							<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;">
							</span>
						</div>
						<div class="range-slider">
                            <div class="price-input">
                                <input type="text" id="minamount">
                                <input type="text" id="maxamount">
                            </div>
                        </div>
                    </div>
				</div>
			</div>

			<div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
				<div class="row list-all-product">
					@foreach ($normal_products as $normal_product)
					<div class="col-lg-4 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ asset('/storage').'/'.$normal_product->thumbnail }}" alt="" style="width: 264px; height: 300px;">
								<div class="pi-links">
									<a data-id="{{ $normal_product->id }}" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
									<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
								</div>
							</div>
							<div class="pi-text">
								@if ($normal_product->price != $normal_product->sale_price)
								<h6 style="text-decoration: line-through; color: red">{{ number_format($normal_product->price) }}.VNĐ</h6>
								<h6>{{ number_format($normal_product->sale_price) }}.VNĐ</h6><br>
								@endif
								@if ($normal_product->price == $normal_product->sale_price)
								<h6>{{ number_format($normal_product->sale_price) }}.VNĐ</h6><br>
								@endif
								<p><a class="get-detail" href="{{ URL::to('/').'/get-detail-product/'.$normal_product->slug }}" style="color: black;">{{ $normal_product->name }}</a> </p>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	@include('content-modals.modal-websale')
</section>
<!-- Category section end -->

@endsection

@section('footer')

<script type="text/javascript" src="{{ asset('js/websale.js') }}"></script>

@endsection