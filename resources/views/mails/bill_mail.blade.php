<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
	<div style="width: 100%; height: 130px; padding: 12px">
		<h3>Tên: {{ $info_user->name }}</h3>
		<h3>Địa Chỉ: {{ $info_user->address }}</h3>
		<h3>Số Điện Thoại: {{ $info_user->phone }}</h3>
	</div>
	<h2 style="width: 100%; text-align: center; color: blue;">ĐƠN HÀNG</h2>
	<div class="table-responsive" align="center" style="width: 100%; margin-top: 5%;">
		<table class="table table-hover" style="width: 100%; border: 1px solid lightgray">
			<thead style="">
				<tr>
					<th>Tên Sản Phẩm</th>
					<th>Số Lượng</th>
					<th>Giá</th>
					<th>Tổng</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($bills as $bill)
				<tr>
					<td style="text-align: center; width: 25%;">{{ $bill->name }}</td>
					<td style="text-align: center; width: 25%;">{{ $bill->quantity }}</td>
					<td style="text-align: center; width: 25%;">{{ $bill->price }}</td>
					<td style="text-align: center; width: 25%;">{{ $bill->price*$bill->quantity }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<h3>Đây là đơn hàng của bạn, đơn hàng sẽ được đợi để quản lý gian hàng xác nhận</h3>
	<h3><strong style="color: red;">Đơn chỉ được hủy trong vòng 1 ngày kể từ lúc tạo đơn hàng này!</strong></h3>
	<div style="width: 100%; padding: 12px; display: flex;">
		<a href="{{ env('APP_URL') }}{{ '/profile' }}" style="padding: 12px; background-color: green; color: white; border-radius: 12px; margin: 0px auto;" align="center">Kiểm tra đơn hàng</a>
	</div>
</body>
</html>




