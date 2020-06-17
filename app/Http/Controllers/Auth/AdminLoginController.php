<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesAdmins;
use App\Admin;
use Validator;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesAdmins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
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

    // public function postRegister(Request $request){
    // 	$rules = [
    // 		'name' => 'required|min:3|max:255',
    // 		'email' => 'required|email|max:255|unique:users',
    // 		'password' => 'required|min:8'
    // 	];

    // 	$messages = [
    // 		'name.min' => 'tên ít nhất có 3 ký tự',
    // 		'email.required' => 'email là trường bắt buộc!',
    // 		'email.email' => 'không đúng định dạng abc@abc.xyz!',
    // 		'email.unique' => 'email đã tồn tại',
    // 		'password.required' => 'password là trường bắt buộc!',
    // 		'password.min' => 'password quá ngắn!'
    // 	];

    // 	$validator = Validator::make($request->all(),$rules,$messages);

    // 	if ($validator->fails()) {
    // 		return redirect()->back()->withErrors($validator)->withInput();
    // 	}
    // 	else{
    // 		$admin = $this->create($request->all());
    // 		Auth::login($admin);
    // 		return redirect('/admin');
    // 	}

    // }

    public function getLogout(){
        Auth::logout();
        return redirect(\URL::previous());
    }

}
