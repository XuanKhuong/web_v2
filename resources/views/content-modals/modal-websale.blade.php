<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title" id="exampleModalLabel">
					Your Shopping Cart
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-image">
					<thead>
						<tr>
							<th scope="col"></th>
							<th scope="col">Product</th>
							<th scope="col">Price</th>
							<th scope="col">Qty</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody class="body-cart">

					</tbody>
				</table> 
				<div class="d-flex justify-content-end">
					<h5>Total: <span class="price text-success all-total"></span></h5>
				</div>
			</div>
			<div class="modal-footer border-top-0 d-flex justify-content-between">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger clear-cart">Clear</button>
				<button type="button" class="btn btn-success checkout"
				@if (Auth::check())
				data="1"
				data-id="{{ Auth::user()->id }}"
				@endif
				@if (!(Auth::check()))
				data="0"
				@endif
				>Checkout</button>
			</div>
		</div>
	</div>
</div>

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