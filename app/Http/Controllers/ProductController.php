<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductStall;
use App\Image;
use App\Admin;
use App\User;
use DB;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
	public function index()
	{
		$products = Product::select('id', 'name', 'slug')->get();
		return view('content-product.index', compact('products'));
	}

	public function add(Request $request, $id)
	{
		$product->user_id = Auth::user()->$id;
		return response()->json(['data' => $product], 200);
	}

	public function getproducts()
	{
		if (Auth::user()->stall_id == 0) {
			$products = Product::select('products.*')
				->get();
		} else {
			$products = ProductStall::select('products.*')
				->where('product_stalls.stall_id', Auth::user()->stall_id)
				->join('products', 'product_stalls.product_id', '=', 'products.id')
				->get();
		}
		return datatables()->of($products)
			->editColumn('thumbnail', function ($products) {
				return '<img src="' . asset('') . 'storage/' . $products->thumbnail . '" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
			})
			->addColumn('action', function ($products) {
				if (Auth::user()->admin) {
					return '

				<div class="dropdown col-lg-6 col-md-4 col-sm-6">
				<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
				Action
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item btn-detail" data-route="'.URL::to('/').'/admin-products-detail/'.$products->id.'" href="#">Detail</a>
				<a class="dropdown-item btn-edit" data-route="' . route('admin-products.edit', $products->id) . '" href="#">Edit</a>
				<a class="dropdown-item btn-delete" data-route="' . route('admin-products.destroy', $products->id) . '" href="#">Delete</a>
				<a class="dropdown-item btn-manufacturer" data-route="' . route('admin-manufacturers.getmanufacturers', $products->id) . '" data-id="'.$products->id.'" href="#">Manufacturer</a>
				</div>
				</div>

				';
				}
			})
			->rawColumns(['thumbnail', 'action'])
			->toJson();
	}
	//    public function addtest(PostStoreRequest $request)
	//    {
	//        dd('done');
	//    }

	public function store(ProductRequest $request)
	{
		// dd($request['slug']);
		$compare_product = Product::where('slug', $request['slug'])->first();

		if ($compare_product == null) {
			$user_id = Auth::id();
			if ($request->description != null) {
				$desc = $request->description;
			}
			if ($request->description == null) {
				$desc = 'Chưa có';
			}
			if ($request->hasFile('thumbnail')) {
				$path = $request->thumbnail->storeAs('product_img', $request->thumbnail->getClientOriginalName());
			}
			if (!($request->hasFile('thumbnail'))) {
				$path = 'product_img/Emptyimages.png';
			}
			$product = Product::create([
				'name' => request('name'),
				'user_id' => $user_id,
				'thumbnail' => $path,
				'description' => $desc,
				'slug' => request('slug'),
			]);

			$product_stall = ProductStall::create([
				'stall_id' 		=> Auth::user()->stall_id,
				'product_id'	=> $product->id
			]);
		} else {
			$product_stall = ProductStall::create([
				'stall_id' 		=> Auth::user()->stall_id,
				'product_id'	=> $compare_product->id
			]);
		}
	}

	public function getImages($id)
	{
		$product = Product::find($id);
		return response()->json(['data' => $product], 200);
	}

	public function postImages(Request $request)
	{
		$image = $request->file('file');
		foreach ($image as $key => $value) {
			$path = $value->storeAs('product_img', $image[$key]->getClientOriginalName());
			$product_id = $request->productId;
			$imageUpload = Image::create([
				'product_id' => $product_id,
				'thumbnail' => $path,
			]);
		}
	}
	public function show($id)
	{	
		$products = Product::find($id);
		$products->url = URL::to('/');
		return response()->json(['data' => $products], 200);
	}

	public function edit($id)
	{
		$product = Product::find($id);
		return response()->json(['data' => $product], 200);
	}

	public function update(ProductRequest $request)
	{
		$user_id = Auth::id();
		$product = Product::find($request->id);
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('product_img', $request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			$path = $product->thumbnail;
		}
		// dd($path);
		if ($request->description != null) {
			$desc = $request->description;
		}
		if ($request->description == null) {
			$desc = 'Chưa có';
		}

		$product->name = $request->name;
		$product->description = $request->description;
		$product->slug = $request->slug;
		$product->thumbnail = $path;
		$product->user_id = $user_id;
		$product->save();
	}

	public function destroy($id)
	{
		ProductStall::where('product_id', $id)
			->where('stall_id', Auth::user()->stall_id)
			->delete();
		return response()->json(['data' => 'removed'], 200);
	}
}
