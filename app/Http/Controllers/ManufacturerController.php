<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ManufacturerRequest;
use Illuminate\Support\Facades\Auth;
use App\Manufacturer;
use App\ManufacturerStall;
use App\Product;
use App\Image;
use App\Admin;
use App\User;
use DB;

class ManufacturerController extends Controller
{
	public function getmanufacturers($id)
	{
		if (Auth::user()->stall_id == 0) {
			$manufacturers = Manufacturer::select('manufacturers.*')
								->where('manufacturers.product_id', $id)
								->get();
		} else {
			$manufacturers = ManufacturerStall::select('manufacturers.*')
								->join('manufacturers', 'manufacturer_stalls.manufacturer_id', '=', 'manufacturers.id')
								->where('manufacturers.product_id', $id)
								->where('manufacturer_stalls.stall_id', Auth::user()->stall_id)
								->get();
		}
		return datatables()->of($manufacturers)
		->editColumn('thumbnail',function($manufacturers){
			return'<img src="'.asset('').'storage/'.$manufacturers->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
		})
		->addColumn('action',function($manufacturers){
			if (Auth::user()->admin) {
				return '

				<div class="dropdown col-lg-6 col-md-4 col-sm-6">
				<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
				Action
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item btn-detail-manufacturer" data-route="'.route("admin-manufacturers.show",$manufacturers->id).'" href="#">Detail</a>
				<a class="dropdown-item btn-edit-manufacturer" data-route="'.route("admin-manufacturers.edit",$manufacturers->id).'" href="#">Edit</a>
				<a class="dropdown-item btn-delete-manufacturer" data-route="'.route("admin-manufacturers.destroy",$manufacturers->id).'" href="#">Delete</a>
				<a class="dropdown-item btn-detail-product" data-route="'.route('admin-getdetailproducts.getdetailproducts',$manufacturers->id).'" data-id="'.$manufacturers->id.'" href="#">Detail Product</a>
				</div>
				</div>

				';
			}
		})
		->rawColumns(['thumbnail','action'])
		->toJson();
	}
 //    public function addtest(PostStoreRequest $request)
 //    {
 //        dd('done');
 //    }

	public function store(ManufacturerRequest $request)
	{
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('Manufacturer_img',$request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			$path = 'product_img/Emptyimages.jpg';
		}
		$manufacturers=Manufacturer::create([
			'name' => request('name'),
			'thumbnail' => $path,
			'product_id' => request('product_id'),
		]);

		$manufacturer_stall = ManufacturerStall::create([
			'stall_id' 			=> Auth::user()->stall_id,
			'manufacturer_id'	=> $manufacturers->id
		]);
	}

	public function show($id)
	{
		$manufacturers = Manufacturer::find($id);
		// dd($products);
		return response()->json(['data'=>$manufacturers],200);
	}

	public function edit($id)
	{
		$manufacturers = Manufacturer::find($id);
		return response()->json(['data'=>$manufacturers],200);
	}

	public function update(ManufacturerRequest $request)
	{
		$manufacturers = Manufacturer::find($request->id);
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('Manufacturer_img',$request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			$path = $manufacturers->thumbnail;
		}
		
		$manufacturers->name = $request->name;
		$manufacturers->thumbnail = $path;
		$manufacturers->product_id = $request->product_id;
		$manufacturers->save();
	}

	public function destroy($id)
	{
		Manufacturer::where('id',$id)->delete();
		ManufacturerStall::where('manufacturer_id',$id)
						->where('stall_id', Auth::user()->stall_id)
						->delete();
		return response()->json(['data'=>'removed'],200);
	}
}
