<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Product;
use App\Image;
use App\ProductDetail;
use App\Manufacturer;
use App\Order;
use App\OrderStall;
use App\OrderDetail;
use App\Comment;
use App\User;
use App\Statistical;
use Auth;
use Cart;
use DB;
use Mail;

class WebSaleController extends Controller
{
	public function index(){
		$normal_product = Product::select('name', 'id', 'stall_id')->get();

		foreach ($normal_product as $product) {
			$product->product_dt = ProductDetail::select('product_details.*', 
																'images.thumbnail')
											->join('images','images.product_detail_id','=','product_details.id')
											->where('product_details.product_id', $product['id'])
											->groupBy('product_details.id')
											->get();

			$product->manu = Manufacturer::where('product_id', $product['id'])->get();
		}
		// dd($normal_product);
		// top 8 sản phẩm bán chạy nhất trong năm 
		$date = getdate();
		$thisYear = $date['year'];
		// $get_month_and_year = Statistical::

		$love_product = DB::table('statisticals')
		->select('product_details.*', 'images.thumbnail')
		->join('images','images.product_detail_id','=','statisticals.product_detail_id')
		->join('product_details','product_details.id','=','statisticals.product_detail_id')
		->whereYear('statisticals.created_at', '=', $thisYear)
		->groupBy('product_details.id')
		->orderBy('product_details.qty_sold', 'desc')
		->take(8)
		->limit(8)
		->get();

		$cate_products = WebSaleController::getMenu();

		// foreach ($cate_products as $cate) {
		// 	dd(sizeof($cate['manufacturer_products']));
		// }
		$manufacturer = Manufacturer::all();

		return view('content-websale.index', compact('normal_product','love_product','manufacturer', 'cate_products'));
	}

	public function getInfo($id){
		if (Auth::check()) {
			// dd('ddd');
			$user_id = Auth::id();
			$user = User::where('id',$user_id)->get();
			// dd($user);
			return response()->json(['error' => false ,'data'=>$user]);
		}
		else {
			return response()->json(['error' => true]);
		}

	}

	public function getMenu (){
		$cate_products = Product::select('name', 'id')->get();

		foreach ($cate_products as $cate_product) {
			$cate_product['manufacturer_products'] = manufacturer::select('id', 'name', 'thumbnail', 'product_id')
														->where('product_id', $cate_product->id)
														->get();

			foreach ($cate_product['manufacturer_products'] as $dt_product) {
				// dd($dt_product->id);
				$dt_product['products'] = ProductDetail::select('name', 'id', 'manufacturer_id', 'slug', 'product_id')
									->where('manufacturer_id', $dt_product->id)
									->get();
				// dd($dt_product['product_id']);
			}
		}

		return $cate_products;
	}

	public function detail($slug){
		$cate_products = WebSaleController::getMenu();
		$product = DB::table('product_details')
		->where('slug','=',$slug)
		->first();
		$image = Image::where('product_detail_id','=',$product->id)
		->get();
		$love_product = DB::table('product_details')
		->join('images','images.product_detail_id','=','product_details.id')
		->select('product_details.*', 'images.thumbnail')
		->groupBy('product_details.id')
		->orderBy('product_details.qty_sold', 'desc')
		->take(8)
		->limit(8)
		->get();

		$get_comment = WebSaleController::getComment($product->id, $product->product_id);

		return view('content-websale.detail', compact('product','image','love_product', 'cate_products', 'get_comment'));
	}

	public function getCart(){
		$content = Cart::getContent();
		$total = Cart::getTotal();
		return response()->json(['data'=>$content,'total'=>$total],200);
	}

	public function cartPage(){
		$cate_products = WebSaleController::getMenu();
		$cart = Cart::getContent();
		$total = Cart::getTotal();
		$normal_product = DB::table('product_details')
		->join('images','images.product_detail_id','=','product_details.id')
		->select('product_details.*', 'images.thumbnail')
		->groupBy('product_details.id')
		->get();
		$manufacturer = Manufacturer::all();
		return view('content-websale.cart',compact('cart','total','normal_product','manufacturer'));
	}

	public function addToCart(Request $request, $id){
		$content2 = Cart::getContent();
		$rowId = $id;
		$content1 = Cart::get($rowId);
		if ($content1 != null) {
			foreach ($content2 as $key => $value) {
				$content1->quantity = 1;
				Cart::update($rowId, array(
					'quantity' => $content1->quantity,
				));
			}
			
		}
		else{
			$add_product = DB::table('product_details')->where('id',$id)->first();
				// dd($add_product);
			$add_product->images = Image::where('product_detail_id', $add_product->id)->select('thumbnail')->first();
			Cart::add(array('id' => $id,'name' => $add_product->name,'quantity' => 1,'price' => $add_product->price,'attributes' => array('img' => $add_product->images->thumbnail, 'stall_id' => $add_product->stall_id)));
			
		}
		$content = Cart::getContent();
		// dd($content);
		$total = Cart::getTotal();
		return response()->json(['data'=>$content,'total'=>$total],200);
	}

	public function deleteOneProduct($id){
		$rowId = $id;
		Cart::remove($rowId);
		$total = Cart::getTotal();
		return response()->json(['data'=>'removed','total'=>$total],200);
	}

	public function updateCart(Request $request, $id){
		// dd($request);
		$rowId = $id;
		Cart::remove($rowId);
		$add_product = DB::table('product_details')->where('id',$id)->first();
				// dd($add_product);
		$add_product->images = Image::where('product_detail_id', $add_product->id)->select('thumbnail')->first();
		Cart::add(array('id' => $id,'name' => $add_product->name,'quantity' => $request->qty,'price' => $add_product->price,'attributes' => array('img' => $add_product->images->thumbnail, 'stall_id' => $add_product->stall_id)));
		$content1 = Cart::getContent();

		// dd($content1);
		foreach ($content1 as $key => $value) {
			if ($value->id == $id) {
				$qty = $value->quantity;
			}
		}
		$total = Cart::getTotal();
		return response()->json(['data'=>$qty,'total'=>$total],200);
	}

	public function deleteAll(){
		Cart::clear();
		return response()->json(['data'=>'removed'],200);
	}

	public function bill(Request $request){
		// dd(env('MAIL_USERNAME'));
		$date = getdate();
		$today = $date['mday'].'/'.$date['mon'].'/'.$date['year'];
		$total = Cart::getTotal();
		if (Auth::check()) {
			$content_carts = Cart::getContent();
			$order = Order::create([
				'name' => $request->name,
				'address' => $request->address,
				'phone' => $request->phone,
				'customer_id' => Auth::user()->id,
				'total' => $total,
			]);

			foreach ($content_carts as $key => $content_cart) {
				$order_stalls = OrderStall::where('order_id', $order['id'])
										->where('stall_id', $content_cart['attributes']['stall_id'])
										->where('created_at', '!=', date("Y-m-d h:i:s"))
										->first();
				// dd($order_stalls);
				if ($order_stalls == null) {
					// dd('here');
					$order_stalls = OrderStall::create([
						'order_id' => $order['id'],
						'stall_id' => $content_cart['attributes']['stall_id'],
					]);

					// dd($order_stalls);
				}

				// dd('out');
			}

			$get_order = Order::where('customer_id',Auth::user()->id)->latest()->first();

			foreach (Cart::getContent() as $key => $value) {
				// dd($value['attributes']['stall_id']);
				// dd($order['id']);
				$order_detail = OrderDetail::create([
					'name' => $value->name,
					'qty' => $value->quantity,
					'price' => $value->price,
					'total' => $value->price*$value->quantity,
					'order_id' => $order['id'],
					'stall_id' => $value['attributes']['stall_id'],
				]);

				// dd($order_detail);
				$get_product_details = ProductDetail::where('id',$value->id)->get();
				$product_details = ProductDetail::where('id',$value->id)->update([
					'qty' => $get_product_details[0]->qty - $value->quantity,
					'qty_sold' => $get_product_details[0]->qty_sold + $value->quantity
				]);
				$statistical = Statistical::where('bought_at','=',$today)
										->where('product_detail_id','=',$value->id)
										->where('stall_id', $content_cart['attributes']['stall_id'])
										->first();
				// dd($statistical);
				if ($statistical != null) {
					$statistical = Statistical::where('bought_at','=',$today)->where('product_detail_id','=',$value->id)->update([
						'qty_sold' => $get_product_details[0]->qty_sold + $value->quantity,
						'interest' => $statistical->interest+(($value->price - $get_product_details[0]->cost)*$value->quantity),
					]);
				}
				else{
					// dd($content_cart['attributes']['stall_id']);
					$statistical = Statistical::create([
						'name' => $value->name,
						'qty_sold' => $get_product_details[0]->qty_sold + $value->quantity,
						'interest' => ($value->price - $get_product_details[0]->cost)*$value->quantity,
						'bought_at' => $today,
						'product_detail_id' => $value->id,
						'stall_id' => $content_cart['attributes']['stall_id']
					]);
				}
			}

			//gửi mail
			$data = ['info_user' => $order, 'bills' => $content_carts];
			Mail::send('mails.bill_mail', $data, function($msg) use ($request){
				// dd($order);
				$msg->from(env('MAIL_USERNAME'), 'WEB BÁN HÀNG');
				$msg->to($request->email, $request->name)->subject('Tạo đơn hàng thành công');
			});
		}
		else{
			return redirect('/login');
		}
		Cart::clear();
		return response()->json(['data'=>'success'],200);
	}

	public function getManufacturerProduct($id, $product_id){

		$cate_products = WebSaleController::getMenu();

		$normal_products = DB::table('product_details')
		->join('images','images.product_detail_id','=','product_details.id')
		->where('product_details.manufacturer_id', $id)
		->where('product_details.product_id', $product_id)
		->select('product_details.*', 'images.thumbnail')
		->groupBy('product_details.id')
		->get();

		return view('content-websale.cate_product', compact('cate_products', 'normal_products'));
	}

	public function postComment(CommentRequest $request) {
		// dd($request);
		$comment = Comment::create([
			'content' => $request->content,
			'user_id' => $request->user_id,
			'product_dt_id' => $request->product_dt_id,
			'product_id' => $request->product_id,
		]);

		$get_user = User::select('users.thumbnail', 'users.name')
							->where('id', $request->user_id)
							->first();

		return response()->json(['data' => $get_user], 200);
	}

	public function getComment($product_dt_id, $product_id){
		$get_comment = Comment::select('comments.*', 'users.thumbnail', 'users.name', 'users.stall_id')
							->join('users', 'comments.user_id', '=', 'users.id')
							->where('product_dt_id', $product_dt_id)
							->where('product_id', $product_id)
							->orderBy('comments.id', 'DESC')
							->get();
		return $get_comment;
	}
}
