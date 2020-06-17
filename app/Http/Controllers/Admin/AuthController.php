<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
	protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('guest')->except('logout');
    }

    public function getLogin(){
    	return view('admin.login');
    }

    protected function create(array $data){
    	return Admin::create([
    		'name' => $data['name'],
    		'email' => $data['email'],
    		'password' => bcrypt($data['password']),
    	]);
    }

    public function postLogin(Request $request){
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	];

    	$messages = [
    		'email.required' => 'email là trường bắt buộc!',
    		'email.email' => 'không đúng định dạng abc@abc.xyz!',
    		'password.required' => 'password là trường bắt buộc!',
    		'password.min' => 'password quá ngắn!'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);

    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	}
    	else{
    		$email = $request->input('email');
    		$password = $request->input('password');

    		if (Auth::attempt(['email' => $email, 'password' => $password], $request->has['remember'])) {
    			return redirect('/admin');
    		}
    		else{
    			$errors = new MessageBag(['errorlogin' => 'Email hoặc password không đúng!']);
    			return redirect()->back()->withInput()->withErrors($errors);
    		}
    	}
    }

    public function getLogout(){
    	Auth::logout();
    	return redirect(\URL::previous());
    }
}
