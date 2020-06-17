<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProFileRequest;
use App\Http\Requests\CreateEmailReqest;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Auth\AdminLoginController;
use Auth;
use App\Admin;
use App\User;
use DB;
use Validator;
use Illuminate\Support\MessageBag;

class CustomerManagerController extends Controller
{
    
public function index(){
		return view('content-customer.index');
	}

	public function getcustomers()
	{
		$customers = User::where('customer',1)->get();
		// dd($employees);
		return datatables()->of($customers)
		->editColumn('thumbnail',function($customers){
			return'<img src="'.asset('').'storage/'.$customers->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
		})
		->addColumn('action',function($customers){
			return '
			
			<div class="dropdown col-lg-6 col-md-4 col-sm-6">
			<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
			Action
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item btn-detail" data-id="'.$customers->id.'" href="#">Detail</a>
			<a class="dropdown-item btn-edit" data-id="'.$customers->id.'" href="#">Edit</a>
			<a class="dropdown-item btn-delete" data-id="'.$customers->id.'" href="#">Delete</a>
			</div>
			</div>

			';
		})
		->rawColumns(['thumbnail','action'])
		->toJson();
	}

	public function store(CreateEmailReqest $request)
	{
		// dd($desc);
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('user_img',$request->thumbnail->getClientOriginalName());
		}
		if (!($request->hasFile('thumbnail'))) {
			if ($request->gender == 'Nam') {
				$path = 'img-profile/user01.png';
			}
			if ($request->gender == 'Nữ') {
				$path = 'img-profile/user02.jpg';
			}
		}
		$users=User::create([
			'name' => request('name'),
			'thumbnail' => $path,
			'email' => request('email'),
			'phone' => request('phone'),
			'gender' => request('gender'),
			'old' => request('old'),
			'address' => request('address'),
			'password' => bcrypt(request('password')),
			'customer' => request('power'),
		]);
	}

	public function show($id)
	{
		$users = User::find($id);
		return response()->json(['data'=>$users],200);
	}

	public function edit($id)
	{
		$users=User::find($id);
		return response()->json(['data'=>$users],200);
	}

	public function update(UserRequest $request, $id)
	{
		$thumbnail_user = User::find($id);
		if(!($request->hasFile('thumbnail'))){
			if ($thumbnail_user == null) {
				if ($request->gender == 'Nam') {
					$path = 'img-profile/user01.png';
				}
				if ($request->gender == 'Nữ') {
					$path = 'img-profile/user02.jpg';
				}
			}

			if ($thumbnail_user != null) {
				$path = $thumbnail_user->thumbnail;
			}
		}
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('user_img',$request->thumbnail->getClientOriginalName());
		}

		$users = DB::table('users')->where('id',$id)->update([
			'thumbnail' => $path,
			'name' => $request->name,
			'phone' => $request->phone,
			'old' => $request->old,
			'gender' => $request->gender,
			'address' => $request->address,
		]);
	}

	public function destroy($id)
	{
		User::where('id', $id)->delete();
		return response()->json(['data'=>'removed'],200);
	}
}
