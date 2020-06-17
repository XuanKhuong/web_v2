<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Component;
use App\Http\Requests\ComponentRequest;
use Illuminate\Support\Facades\Auth;
use App\Image;
use App\Admin;
use App\User;
use DB;

class ComponentController extends Controller
{

	public function index(){
		return view('content-component.index');
	}

	public function getcomponents()
	{
		$components = Component::all();
		return datatables()->of($components)
		->editColumn('thumbnail',function($components){
			return'<img src="'.asset('').'storage/'.$components->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
		})
		->addColumn('action',function($components){
			return '
			
			<div class="dropdown col-lg-6 col-md-4 col-sm-6">
			<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
			Action
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item btn-detail" data-id="'.$components->id.'" href="#">Detail</a>
			<a class="dropdown-item btn-edit" data-id="'.$components->id.'" href="#">Edit</a>
			<a class="dropdown-item btn-delete" data-id="'.$components->id.'" href="#">Delete</a>
			<a class="dropdown-item btn-detail-component" data-id="'.$components->id.'" href="#">Detail Component</a>
			</div>
			</div>

			';
		})
		->rawColumns(['thumbnail','action'])
		->toJson();
	}
 //    public function addtest(PostStoreRequest $request)
 //    {
 //        dd('done');
 //    }

	public function store(ComponentRequest $request)
	{
		$user_id = Auth::id();
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}
		// dd($desc);
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('component_img',$request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			$path = 'component_img/Emptyimages.png';
		}
		$components=Component::create([
			'name' => request('name'),
			'user_id' => $user_id,
			'thumbnail' => $path,
			'description' => $desc,
			'slug' => $request->slug,
		]);
	}

	public function show($id)
	{
		$components = Component::find($id);
		// dd($products);
		return response()->json(['data'=>$components],200);
	}

	public function edit($id)
	{
		$components = Component::find($id);
		return response()->json(['data'=>$components],200);
	}

	public function update(ComponentRequest $request, $id)
	{
  // dd($request->all());
		$user_id = Auth::id();
		$components = Component::find($id);
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('component_img',$request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			$path = $components->thumbnail;
		}
		// dd($path);
		if($request->description != null){
			$desc = $request->description;
		}
		if($request->description == null){
			$desc = 'Chưa có';
		}
		
		$components->name = $request->name;
		$components->description = $request->description;
		$components->slug = $request->slug;
		$components->thumbnail = $path;
		$components->user_id = $user_id;
		$components->save();
	}

	public function destroy($id)
	{
		Component::where('id',$id)->delete();
		return response()->json(['data'=>'removed'],200);
	}
}
