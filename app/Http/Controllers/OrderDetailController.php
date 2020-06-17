<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetailProductRequest;
use App\ProductDetail;
use App\OrderDetail;
use App\Product;
use Auth;
use App\Admin;
use App\User;
use App\Image;
use DB;

class OrderDetailController extends Controller
{
	public function getdetailorders($id)
	{
		$order_details = OrderDetail::where('order_id', $id)
							->get();
		return datatables()->of($order_details)
        // ->editColumn('thumbnail',function($post){
        //     return'<img src="'.asset('').'storage/'.$post->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
        // })
        ->editColumn('price',function($order_details){
            return number_format($order_details->price);
        })
        ->editColumn('total',function($order_details){
            return number_format($order_details->total);
        })
		->addColumn('action',function($order_details){
				return '
				<div class="dropdown col-lg-6 col-md-4 col-sm-6">
				<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
				Action
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item btn-show-detail-order" data-route="'.route('admin-detail-orders.show', $order_details->id).'" data-id="'.$order_details->id.'" href="#">Detail</a>
				</div>
				</div>
				';

		})
		->rawColumns(['action'])
		->make(true);
        // ->toJson();
	}

	
	public function show($id)
	{
		$detail_order = OrderDetail::find($id);
		return response()->json(['data'=>$detail_order],200);
	}

}
