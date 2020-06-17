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

class EmployeeManagerController extends Controller
{

	public function index(){
		return view('content-employee.index');
	}

	public function getemployees()
	{
		$employees = User::where('employee',1)->where('stall_id', Auth::user()->stall_id)->get();
		// dd($employees);
		return datatables()->of($employees)
		->editColumn('thumbnail',function($employees){
			return'<img src="'.asset('').'storage/'.$employees->thumbnail.'" alt="" style="width: 50px; height: 50px; border-radius: 12px;">';
		})
		->addColumn('action',function($employees){
			return '
			
			<div class="dropdown col-lg-6 col-md-4 col-sm-6">
			<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
			Action
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item btn-detail" data-id="'.$employees->id.'" href="#">Detail</a>
			<a class="dropdown-item btn-edit" data-id="'.$employees->id.'" href="#">Edit</a>
			<a class="dropdown-item btn-delete" data-id="'.$employees->id.'" href="#">Delete</a>
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
			'employee' => request('power'),
			'stall_id' => Auth::user()->stall_id,
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
