<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProFileRequest;
use Auth;
use App\Admin;
use App\User;
use DB;
use Validator;
use Illuminate\Support\MessageBag;

class CustomerController extends Controller
{

	public function __construct()
	{
		$this->middleware('customer',['except' => 'getLogout']);
	}

	public function getProFile(){
		$user = User::find(Auth::user()->id);
		return view('content-profile.profile', compact('user'));
	}

	

	public function edit($id){
		$user = User::find(Auth::user()->id);
		return response()->json(['data'=>$user],200);
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
		// return response()->json(['data'=>$user,'data02'=>$admin],200);
		
	}

	public function getLogout(){
		Auth::logout();
		return redirect('/login');
	}
}
