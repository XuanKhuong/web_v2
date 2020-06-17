<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetailProductRequest;
use App\DetailComponent;
use App\Component;
use Auth;
use App\Admin;
use App\User;
use App\Image;
use DB;

class ComponentDetailController extends Controller
{
    public function getdetailcomponents($id)
	{
        // $detail_product = ProductDetail::all();
		$component_details = DetailComponent::where('component_details.component_id', '=' , $id)->get();
        // dd($detail_product);
		return datatables()->of($component_details)	
        // ->editColumn('thumbnail',function($post){
        //     return'<img src="'.asset('').'storage/'.$post->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
        // })
		->addColumn('action',function($component_details){
			return '
			<div class="dropdown col-lg-6 col-md-4 col-sm-6">
			<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
			Action
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item btn-show-detail-component" data-id="'.$component_details->id.'" href="#">Detail</a>
			<a class="dropdown-item btn-edit-detail-component" data-id="'.$component_details->id.'" href="#">Edit</a>
			<a class="dropdown-item btn-delete-detail-component" data-id="'.$component_details->id.'" href="#">Delete</a>
			<a class="dropdown-item btn-add-img-detail-component" data-id="'.$component_details->id.'" href="#">Add Images</a>
			</div>
			</div>
			';

		})
		->rawColumns(['action'])
		->make(true);
        // ->toJson();
	}

	public function store(DetailProductRequest $request)
	{
        // dd($request->all());
		$user_id = Auth::id();
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}
		$product_details=DetailComponent::create([
			'name' => request('name'),
			'user_id' => $user_id,
			'qty' => request('qty'),
			'price' => request('price'),
			'sale_price' => request('sale_price'),
			'component_id' => request('component_id'),
			'qty' => request('qty'),
			'description' => $desc,
			'slug' => request('slug'),
		]);
	}

	public function getImages($id){
		$component_details = DetailComponent::find($id);
		return response()->json(['data'=>$component_details],200);
	} 

	public function postImages(Request $request){
        // dd($request->all());
		$image = $request->file('file');
		foreach ($image as $key => $value){
			$path = $value->storeAs('product_img', $image[$key]->getClientOriginalName());
			$component_detail_id = $request->component_detail_id;
			$imageUpload = Image::create([
				'component_detail_id' => $component_detail_id,
				'thumbnail' =>$path,
			]);
			// dd($imageUpload);
		}
	}
	public function show($id)
	{
		$component_detail=DetailComponent::join('images', 'images.component_detail_id', '=', 'component_details.id')
		->select('component_details.*', 'images.thumbnail', 'component_details.id as component_id', 'images.id as image_id')
		->where('component_details.id', '=', $id)
		->first();
		dd($component_detail);
		return response()->json(['data'=>$component_detail],200);
	}

	public function edit($id)
	{
		$component_details = DetailComponent::find($id);
        //dd($detail_product);
		return response()->json(['data'=>$component_details],200);
	}

	public function update(DetailProductRequest $request, $id)
	{
        $user_id =Auth::id();
		$component_details = DetailComponent::find($id);
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}
        // $slug = str_replace(" ","-",$request->name);
		$component_details->name = $request->name;
		$component_details->qty = $request->qty;
		$component_details->slug = $request->slug;
		$component_details->price = $request->price;
		$component_details->description = $desc;
		$component_details->component_id = $request->component_id;
		$component_details->user_id = $user_id;
		$component_details->sale_price = $request->sale_price;
		$component_details->save();
		// dd($detail_product);
	}

	public function destroy($id)
	{
		DetailComponent::where('id',$id)->delete();
		return response()->json(['data'=>'removed'],200);
	}
}
