<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\OrderStall;
use App\Image;
use App\Admin;
use App\User;
use DB;
use DateTime;

class OrderController extends Controller
{
	public function index(){
		return view('content-order.index');
	}

	public function paid(){
		return view('content-order.bill_paid');
	}

	public function add(Request $request, $id){
		$product->user_id = Auth::user()->$id;
		return response()->json(['data'=>$product],200);
	}

	public function getorderspaid(){
		if (Auth::user()->admin) {
			$orders = Order::select('orders.*')
							->join('order_stalls', 'orders.id', '=', 'order_stalls.order_id')
							->where('orders.status','=',0)
							->where(function($query){
								$query->where('order_stalls.stall_id', Auth::user()->stall_id)
									  ->orWhere('orders.customer_id', Auth::id());
							})
							->orderBy('orders.id', 'desc')
							->get();
		}
		if (Auth::user()->customer) {
			$customer_id = Auth::user()->id;
			$orders = Order::select('orders.*')
							->where('customer_id',$customer_id)
							->where('status','=',0)
							->orderBy('orders.id', 'desc')
							->get();
		}

		$STT = 0;
		return datatables()->of($orders)
		->editColumn('id',function($orders) use ($STT){
			$STT = $STT + 1;
            return $STT;
        })
		->editColumn('total',function($orders){
            return number_format($orders->total);
        })
		->addColumn('action',function($orders){
				if (Auth::user()->admin) {
					return '
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('admin-orders.show',$orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('admin-getdetailorders.getdetailorders',$orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>

					';
				} else {
					return '
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('customer-orders.show',$orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('customer-getdetailorders.getdetailorders',$orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>

					';
				}
		})
		->rawColumns(['status','action'])
		->toJson();
	}

	public function getorders(Request $request)
	{
		$orders = Order::select('orders.*');
		
		if ($request->status == null) {
			if (Auth::user()->admin) {

				$orders = $orders->where('orders.status','!=',0)
								->join('order_stalls', 'orders.id', '=', 'order_stalls.order_id')
								->where(function($query){
									$query->where('order_stalls.stall_id', Auth::user()->stall_id)
									->orWhere('orders.customer_id', Auth::id());
								});

			} else if (Auth::user()->customer) {
				// dd('dd');
				$customer_id = Auth::user()->id;
				$orders = $orders->where('customer_id',$customer_id)
								->where('status','!=',0);
			}

		} else {
			if (Auth::user()->admin) {

				$orders = $orders->where('orders.status','=', $request->status)
								->join('order_stalls', 'orders.id', '=', 'order_stalls.order_id')
								->where(function($query){
									$query->where('order_stalls.stall_id', Auth::user()->stall_id)
									->orWhere('orders.customer_id', Auth::id());
								});
								
			} else if (Auth::user()->customer) {
				$customer_id = Auth::user()->id;
				$orders = $orders->where('customer_id',$customer_id)
								->where('status','=', $request->status);
			}
		}

		$orders->orderBy('orders.id', 'desc')->get();

		// dd($orders);
		$STT = 0;
		return datatables()->of($orders)
		->editColumn('id',function($orders) use ($STT){
			$STT = $STT + 1;
            return $STT;
        })
		->editColumn('total',function($orders){
            return number_format($orders->total);
        })
		->editColumn('status',function($orders){
			$date = new DateTime(date("Y-m-d h:i:s"));
			$date_minus = $date->diff($orders['created_at'], "Y-m-d");
			$format = $date_minus->format('%R%a');

			$cancellation_time = ltrim($format, '+');
			if ($orders->customer_id != Auth::user()->id) {
				if ($orders->status == 1) {
					if (intval($cancellation_time) >= 1) {
						return'
						<button type="button" class="btn-paid" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order disabled" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-remove-order.png" style="width:30px; height:30px;"></button>
						';
					}

					else {
						return'
						<button type="button" class="btn-paid" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-remove-order.png" style="width:30px; height:30px;"></button>
						';
					}
				}

				if ($orders->status == 2) {
					if (intval($cancellation_time) >= 1) {
						return'
						<button type="button" class="btn-paid" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order disabled" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;">
						<img src="'.asset('').'storage/icon/removed-order.png" style="width:30px; height:30px;">
						<input type="hidden" value="'.$orders->status.'" id="stt">
						</button>
						';
					}

					else {
						return'
						<button type="button" class="btn-paid" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order" data-route="'.route('admin-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;">
						<img src="'.asset('').'storage/icon/removed-order.png" style="width:30px; height:30px;">
						<input type="hidden" value="'.$orders->status.'" id="stt">
						</button>
						';
					}
				}
			} 

			else {
				if ($orders->status == 1) {
					if (intval($cancellation_time) >= 1) {
						return'
						<button type="button" class="btn-paid disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-remove-order.png" style="width:30px; height:30px;"></button>
						';
					}

					else {
						return'
						<button type="button" class="btn-paid disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-remove-order.png" style="width:30px; height:30px;"></button>
						';
					}
				}

				if ($orders->status == 2) {
					if (intval($cancellation_time) >= 1) {
						return'
						<button type="button" class="btn-paid disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;">
						<img src="'.asset('').'storage/icon/removed-order.png" style="width:30px; height:30px;">
						<input type="hidden" value="'.$orders->status.'" id="stt">
						</button>
						';
					}

					else {
						return'
						<button type="button" class="btn-paid disabled" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-paid.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-shipping" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;"><img src="'.asset('').'storage/icon/no-shipping.png" style="width:30px; height:30px;"></button>
						<button type="button" class="btn-remove-order" data-route="'.route('customer-orders.update', $orders->id).'" data-id="'.$orders->id.'" style="padding: 8px;background: none;border: none;">
						<img src="'.asset('').'storage/icon/removed-order.png" style="width:30px; height:30px;">
						<input type="hidden" value="'.$orders->status.'" id="stt">
						</button>
						';
					}
				}
			}
		})
		->addColumn('action',function($orders){
			if (Auth::user()->admin) {
				if ($orders->status != 2) {
					return '
	
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('admin-orders.show', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('admin-getdetailorders.getdetailorders', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>
	
					';
				}
	
				else{
					return '
	
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('admin-orders.show', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-delete" data-route="'.route('admin-orders.destroy', $orders->id).'" data-id="'.$orders->id.'" href="#">Delete</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('admin-getdetailorders.getdetailorders', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>
	
					';
				}
			} else {
				if ($orders->status != 2) {
					return '
	
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('customer-orders.show', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('customer-getdetailorders.getdetailorders', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>
	
					';
				}
	
				else{
					return '
	
					<div class="dropdown col-lg-6 col-md-4 col-sm-6">
					<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					Action
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item btn-detail" data-route="'.route('customer-orders.show', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail</a>
					<a class="dropdown-item btn-delete" data-route="'.route('customer-orders.destroy', $orders->id).'" data-id="'.$orders->id.'" href="#">Delete</a>
					<a class="dropdown-item btn-order-detail" data-route="'.route('customer-getdetailorders.getdetailorders', $orders->id).'" data-id="'.$orders->id.'" href="#">Detail Order</a>
					</div>
					</div>
	
					';
				}
			}
		})
		->rawColumns(['status','action'])
		->toJson();
	}
 //    public function addtest(PostStoreRequest $request)
 //    {
 //        dd('done');
 //    }
 //    
	public function show($id)
	{
		$orders = Order::find($id);
		// dd($products);
		return response()->json(['data'=>$orders],200);
	}

	public function update(Request $request, $id)
	{
		// dd($id);
		$user_id = Auth::id();
		// $order = Order::find($id);

		$orders = Order::where('id',$id)->update([
			'employee_id' => $user_id,
			'status' => $request->status,
		]);
	}

	public function destroy($id)
	{
		Order::where('id',$id)->delete();
		OrderDetail::where('order_id',$id)->delete();
		return response()->json(['data'=>'removed'],200);
	}
}
