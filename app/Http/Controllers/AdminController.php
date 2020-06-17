<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProFileRequest;
use Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Admin;
use App\User;
use App\Stall;
use DB;
use Validator;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin',['except' => 'getLogout']);
	}

	public function getProFile(){
		$user = User::find(Auth::user()->id);
		$stall = Stall::select('stall_name')->where('id', Auth::user()->stall_id)->first();
		return view('content-profile.profile', compact('user', 'stall'));
	}

	

	public function edit($id){
		$user = User::find(Auth::user()->id);
		$stall = Stall::select('stall_name')->where('id', Auth::user()->stall_id)->first();
		return response()->json(['data'=>$user, 'stall'=>$stall],200);
	}

	public function update(ProFileRequest $request, $id)
	{
		
		if(!($request->hasFile('thumbnail'))){
			$path = Auth::user()->thumbnail;
		}
		if ($request->hasFile('thumbnail')) {
			$path = $request->thumbnail->storeAs('user_img',$request->thumbnail->getClientOriginalName());
		}
		$user = DB::table('users')->where('id',$id)->update([
			'name' => request('name'),
			'email' => request('email'),
			'thumbnail' => $path,
			'phone' => request('phone'),
			'address' => request('address'),
			'old' => request('old'),
			'gender' => request('gender'),
		]);

		$old_stall_name = Stall::where('id', '!=',Auth::user()->stall_id)
								->where('stall_name', $request['stall_name'])
								->first();

		if (empty($old_stall_name)) {
			Stall::where('id', Auth::user()->stall_id)->update([
				'stall_name' => $request['stall_name']
			]);
		} else {
			return response()->json(['errors'=>true, 'message'=>'Tên gian hàng đã tồn tại']);
		}
		// return response()->json(['data'=>$user,'data02'=>$admin],200);
		
	}

	public function getLogout(){
		Auth::logout();
		return redirect('/login');
	}

}
