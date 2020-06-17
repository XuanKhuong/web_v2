@extends('layouts.layoutAdmin')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('css/css-admin/myCss.css') }}">
<style type="text/css">
	.progress{
		cursor: pointer;
	}
</style>

@endsection

@section('content')

<div class="main-content-inner">
	<!-- bar chart start -->
	<div class="row">
		<div class="col-lg-12 mt-5">
			<div class="card">
				<div class="card-body">
					<h2>Sản phẩm bán chạy</h2><p>({{ $sum.' sản phẩm/năm' }})</p><br>
					@foreach ($product_statistics as $key1 => $val1)
					<h3>Thống kê tháng: {{ $key1 }}</h3>
					@for ($i = 0; $i < count($val1); $i++)
					<p>{{ $val1[$i]->name }} - đã bán: {{ $val1[$i]->qty_sold }} chiếc - chiếm: {{ round(($val1[$i]->qty_sold/$sum)*100, 2) }}% tổng sản phẩm đã bán</p>
					<div class="progress" title="{{ round(($val1[$i]->qty_sold/$sum)*100, 2) }}%" data-toggle="tooltip">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ round(($val1[$i]->qty_sold/$sum)*100, 2) }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ round(($val1[$i]->qty_sold/$sum)*100, 2) }}%" >
							{{ round(($val1[$i]->qty_sold/$sum)*100, 2) }}%
						</div>
					</div>
					@endfor
					<br>
					<hr>
					<br>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 mt-5">
			<div class="card">
				<div class="card-body">
					<h2>Doanh Thu</h2><p>({{ number_format($sum1).'.VNĐ/năm' }})</p><br>
					@foreach ($product_statistics as $key1 => $val1)
					<h3>Thống kê tháng: {{ $key1 }}</h3>
					@for ($i = 0; $i < count($val1); $i++)
					<p>{{ $val1[$i]->name }} - {{ number_format($val1[$i]->interest).'.VNĐ' }} - chiếm: {{ round(($val1[$i]->interest/$sum1)*100, 2) }}% tổng thu nhập</p>
					<div class="progress" title="{{ round(($val1[$i]->interest/$sum1)*100, 2) }}%" data-toggle="tooltip">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ round(($val1[$i]->interest/$sum1)*100, 2) }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ round(($val1[$i]->interest/$sum1)*100, 2) }}%">
							{{ round(($val1[$i]->interest/$sum1)*100, 2) }}%
						</div>
					</div>
					@endfor
					<br>
					<hr>
					<br>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<!-- bar chart end -->
</div>

@endsection;
@section('footer')
@if (Auth::user()->admin)
<script type="text/javascript"src="js/product.js"></script>
@endif
@if (Auth::user()->employee)
<script type="text/javascript" src="js/employee-product.js"></script>
@endif
@if (Auth::user()->customer)
<script type="text/javascript" src="js/customer-product.js"></script>
@endif
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});
</script>
@endsection;