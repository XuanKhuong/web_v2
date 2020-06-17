<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetailProductRequest;
use App\ProductDetail;
use App\Product;
use Auth;
use App\Admin;
use App\Statistical;
use App\User;
use App\Image;
use DB;
use Illuminate\Support\Facades\URL;
class ProductDetailController extends Controller
{


    // public function index(){
    // 	return view('contentProduct.content_detail_product');
    // }

	public function getdetailproducts($id)
	{
        // $detail_product = ProductDetail::all();
		if (Auth::user()->stall_id == 0) {
			$product_details = ProductDetail::where('product_details.manufacturer_id', '=' , $id)
										->orderBy('product_details.id', 'desc')
										->get();
		} else {
			$product_details = ProductDetail::where('product_details.manufacturer_id', '=' , $id)
										->where('product_details.stall_id', Auth::user()->stall_id)
										->orderBy('product_details.id', 'desc')
										->get();
		}
        $STT = 0;
		return datatables()->of($product_details)
		->editColumn('id',function($product_details) use ($STT){
			$STT = $STT + 1;	
			return $STT;
		})
		->editColumn('price',function($product_details){
			return number_format($product_details->price);
		})
		->editColumn('sale_price',function($product_details){
			return number_format($product_details->sale_price);
		})	
		->addColumn('action',function($product_details){
			if (Auth::user()->admin) {
				return '
				<div class="dropdown col-lg-6 col-md-4 col-sm-6">
				<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
				Action
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item btn-show-detail-product" data-route="'.route('admin-detail-products.show',$product_details->id).'" href="#">Detail</a>
				<a class="dropdown-item btn-edit-detail-product" data-route="'.route('admin-detail-products.edit',$product_details->id).'" href="#">Edit</a>
				<a class="dropdown-item btn-delete-detail-product" data-route="'.route('admin-detail-products.destroy',$product_details->id).'" href="#">Delete</a>
				<a class="dropdown-item btn-add-img-detail-product" data-route="'.route('product-up-multi-img',$product_details->id).'" href="#">Add Images</a>
				</div>
				</div>
				';
			}

		})
		->rawColumns(['action'])
		->make(true);
        // ->toJson();
	}

	public function store(DetailProductRequest $request)
	{
        // dd($request->manufacturer_id);
		$user_id = Auth::id();
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}
		// $slug = $slug.'-stall-'.strval(Auth::user()->stall_id);
		// $slug = $slug + Auth::user()->stall_id;
		$checkSlug = ProductDetail::where('slug', '=', $request->slug)
								  ->first();

		// dd($checkSlug);

		if ($checkSlug == null) {
			$product_details=ProductDetail::create([
				'name' => request('name'),
				'user_id' => $user_id,
				'qty' => request('qty'),
				'price' => request('price'),
				'sale_price' => request('sale_price'),
				'product_id' => request('product_id'),
				'manufacturer_id' => $request->manufacturer_id,
				'qty' => request('qty'),
				'description' => $desc,
				'slug' => request('slug'),
				'stall_id' => Auth::user()->stall_id,
			]);
			return response()->json(['err' => false,'message'=>'Thêm mới thành công!'],200);
		} else {
			return response()->json(['err' => true,'message'=>'Tên sản phẩn đã tồn tại!'],200);
		}
		// dd($product_details);
	}

	public function getImages($id){
		$detail_product = ProductDetail::find($id);
		$image = Image::where('product_detail_id',$id)->get();
		$url = URL::to('/') . '/';
		return response()->json(['data'=>$detail_product,'data1'=>$image, 'url' => $url],200);
	} 

	public function postImages(Request $request){
        // dd($request->all());
		$image = $request->file('file');
		foreach ($image as $key => $value){
			$path = $value->storeAs('product_img', $image[$key]->getClientOriginalName());
			$product_detail_id = $request->product_detail_id;
			$imageUpload = Image::create([
				'product_detail_id' => $product_detail_id,
				'thumbnail' =>$path,
			]);
		}
	}

	public function deleteImage($id){
		Image::where('id',$id)->delete();
		return response()->json(['data'=>'removed'],200);
	}

	public function show($id)
	{
		$detail_product = ProductDetail::where('product_details.id', '=', $id)
										->with('images')
										->first();
		$detail_product->url = URL::to('/');
		return response()->json(['data'=>$detail_product],200);
	}

	public function edit($id)
	{
		$detail_product = ProductDetail::find($id);
        //dd($detail_product);
		return response()->json(['data'=>$detail_product],200);
	}

	public function update(DetailProductRequest $request)
	{
		$user_id =Auth::id();
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}

		$checkSlug = ProductDetail::where('id', '!=', $request->id)
								  ->where('slug', '=', $request->slug)
								  ->first();

		if ($checkSlug == null) {
			$detail_product = ProductDetail::where('id',$request->id)->update([
				'name' => $request->name,
				'qty' => $request->qty,
				'slug' => $request->slug,
				'price' => $request->price,
				'description' => $desc,
				'user_id' => $user_id,
				'sale_price' => $request->sale_price,
			]);

			return response()->json(['err' => false,'message'=>'Sửa thành công!']);
		} else {
			return response()->json(['err' => true,'message'=>'Tên sản phẩn đã tồn tại!']);
		}
        // $slug = str_replace(" ","-",$request->name);
		
		// dd($detail_product);
	}

	public function Love(Request $request, $id){
		$detail_product = ProductDetail::where('id',$id)->update([
			'love_product' => request('love_product'),
		]);
		return response()->json(['data'=>$detail_product],200);
	}

	public function destroy($id)
	{
		ProductDetail::where('id',$id)->delete();
		Image::where('product_detail_id',$id)->delete();
		return response()->json(['data'=>'removed'],200);
	}

	//thong ke
	public function statistical(){
		$product_statistics = DB::table('statisticals')
								->select('statisticals.*')
								->where('statisticals.stall_id', Auth::user()->stall_id)
								->orderBy('statisticals.qty_sold', 'desc')
								->take(8)
								->limit(8)
								->get()
								->groupBy(function($date) {
									$month = explode('/', $date->bought_at);
									$sttcMonth = $month['1'].'/'.$month['2'];
						            return $sttcMonth; // grouping by days
						        });
		$sum = 0;
		foreach ($product_statistics as $key => $value) {
			for ($i=0; $i < count($value); $i++) {
				$sum += $value[$i]->qty_sold;
			}
		}

		$sum1 = 0;
		foreach ($product_statistics as $key => $value) {
			for ($i=0; $i < count($value); $i++) {
				$sum1 += $value[$i]->interest;
			}
		}

		// dd($sum);
		return view('content-statistical.index',compact('product_statistics','sum','sum1'));
	}
}
