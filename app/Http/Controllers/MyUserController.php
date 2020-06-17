<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\CreateEmailReqest;
use App\ProductDetail;
use App\Product;
use Auth;
use App\User;
use App\Admin;
use App\Employee;
use App\Customer;
use App\Image;
use DB;

class MyUserController extends Controller
{
	public function index(){
		return view('content-users.index');
	}

	public function getusers()
	{
		$users = User::all();
		return datatables()->of($users)
		->editColumn('power',function($users){
			if ($users->admin == 1) {
				return'admin';
			}
			if ($users->employee == 1) {
				return'employee';
			}
			if ($users->customer == 1) {
				return'customer';
			}
		})
		->addColumn('action',function($users){
			return '
			
			<div class="dropdown col-lg-6 col-md-4 col-sm-6">
			<button class="btn btn-rounded btn-success dropdown-toggle" type="button" data-toggle="dropdown">
			Action
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item btn-edit" data-id="'.$users->id.'" href="#">Edit</a>
			</div>
			</div>

			';
		})
		->rawColumns(['action','power'])
		->toJson();
	}

	public function edit($id)
	{
		$users=User::find($id);
		return response()->json(['data'=>$users],200);
	}

	public function update(Request $request, $id)
	{
		// dd($request->all());
		$users = User::where('id',$id)->update([
			'admin' => $request->admin,
			'employee' => $request->employee,
			'customer' => $request->customer,
		]);

		return response()->json(['data'=>$users],200);
	}
}
