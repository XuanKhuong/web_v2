@extends('layouts.layoutWebSale')

@section('header')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">

@endsection

@section('content')

<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Your cart</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Your cart</a>
		</div>
	</div>
</div>
<!-- Page info end -->


<!-- cart section end -->
<section class="cart-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="cart-table">
					<h3>Your Cart</h3>
					<div class="cart-table-warp">
						<table>
							<thead>
								<tr>
									<th class="product-th">Product</th>
									<th class="quy-th">Quantity</th>
									<th class="total-th">Price</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($cart as $val)
								<tr>
									<td class="product-col">
										<img src="{{ asset('/storage').'/'.$val->attributes['img'] }}" alt="">
										<div class="pc-title">
											<h4>{{ $val->name }}</h4>
										</div>
									</td>
									<td class="quy-col">
										<div class="quantity">
											<div class="pro-qty">
												<input type="text" value="1">
											</div>
										</div>
									</td>
									<td class="total-col"><h4>{{ $val->price }}</h4></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="total-cost">
						<h6>Total <span>{{ $total }}</span></h6>
					</div>
				</div>
			</div>
			<div class="col-lg-4 card-right">
				<form class="promo-code-form">
					<input type="text" placeholder="Enter promo code">
					<button>Submit</button>
				</form>
				<a class="site-btn checkout" 
				@if (Auth::check())
				data="1"
				data-id="{{ Auth::user()->id }}"
				@endif
				@if (!(Auth::check()))
				data="0"
				@endif>Proceed to checkout</a>
				<a href="{{ '/' }}" class="site-btn sb-dark">Continue shopping</a>
			</div>
		</div>
	</div>
</section>
<!-- cart section end -->

<!-- Related product section -->
<section class="product-filter-section">
	<div class="container">
		<div class="section-title">
			<h2>ALL PRODUCT <button type="button" class="filter-product" style="background: none; border: none;" value="0"><i class="fa fa-search " style="color: gray;font-size: 41px;padding: 12px;bottom: 27px;"></i></button></h2>
			<input class="form-control" id="seach-product" type="text" placeholder="Search.." style="display: none; box-shadow: 10px 10px 5px grey;">
		</div>
		<ul class="product-filter-menu">
			<li><a class="filter-btn" id="all">All</a></li>
			@foreach ($manufacturer as $man_val)
				<li><a class="filter-btn" id="{{ $man_val->id }}">{{ $man_val->name }}</a></li>
			@endforeach
		</ul>
		<div class="row list-all-product">
			@foreach ($normal_product as $val)
			<div class="col-lg-3 col-sm-6 card-product {{ $val->manufacturer_id }}">
				<div class="product-item">
					<div class="pi-pic">
						<img src="{{ '/storage/'.$val->thumbnail }}" style="width: 264px; height: 409px;" alt="">
						<div class="pi-links">
							<a href="#" data-id="{{ $val->id }}" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
							<button style="box-shadow: 0px 0 32px rgba(0, 0, 0, 0.2);background: white;border-radius: 50%;border:none;padding: 5.2px 9px;cursor: pointer;" value="{{ $val->love_product }}" class="wishlist-btn love-product" data-id="{{ $val->id }}"><i class="flaticon-heart"></i></button>
						</div>
					</div>
					<div class="pi-text">
						<h6>{{ number_format($val->price) }}.VNĐ</h6>
						<p><a href="{{ '/get-detail-product/'.$val->slug }}" style="color: black;">{{ $val->name }}</a> </p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="text-center pt-5">
			<button class="site-btn sb-line sb-dark">LOAD MORE</button>
		</div>
	</div>
</section>
<!-- Related product section end -->

<div class="modal fade" id="cartInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title" id="exampleModalLabel">
					Fill In Your Information
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="well form-horizontal" id="form-bill">
					<fieldset>
						<div class="form-group">
							<label class=" control-label">Full Name</label>
							<div class=" inputGroupContainer">
								<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="name-info" name="name" placeholder="Full Name" class="form-control" required="true" type="text"></div>
							</div>
						</div>
						<div class="form-group">
							<label class=" control-label">Address</label>
							<div class=" inputGroupContainer">
								<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="address-info" name="address" placeholder="Address" class="form-control" required="true" type="text"></div>
							</div>
						</div>
						<div class="form-group">
							<label class=" control-label">Email</label>
							<div class=" inputGroupContainer">
								<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email-info" name="email" placeholder="Email" class="form-control" required="true" type="text"></div>
							</div>
						</div>
						<div class="form-group">
							<label class=" control-label">Phone Number</label>
							<div class=" inputGroupContainer">
								<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span><input id="phone-info" name="phone" placeholder="Phone Number" class="form-control" required="true" type="text"></div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer border-top-0 d-flex justify-content-between">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success get-bill"
				>Send</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')

<script type="text/javascript" src="{{ asset('js/websale.js') }}"></script>

@endsection