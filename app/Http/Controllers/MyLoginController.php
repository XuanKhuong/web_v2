<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Auth;
use App\User;
use App\Stall;
use Illuminate\Support\MessageBag;

class MyLoginController extends Controller
{
  public function getLogin(){
   return view('login-form.content-login');
 }

 public function getRegister(){
   return view('login-form.content-register');
 }

 public function getRegisterStall(){
   return view('login-form.content-register-stall');
 }

 protected function create(array $data){
  $data['password'] = bcrypt($data['password']);
  return User::create($data);
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

      if (Auth::check() && Auth::user()->admin) {
        return redirect()->route('admin.info');
      }
      
      if (Auth::check() && Auth::user()->employee) {
        return redirect()->route('employee.info');
      }

      if (Auth::check() && Auth::user()->customer) {
        return redirect()->route('customer.info');
      }

    }
    else{
     $errors = new MessageBag(['errorlogin' => 'Email hoặc password không đúng!']);
     return redirect()->back()->withInput()->withErrors($errors);
   }
 }
}

public function postRegister(Request $request){
  $data = $request->all();
  $rules = [
    'name' => 'required|min:3|max:255',
    'email' => 'required|email|max:255|unique:users',
    'password' => 'required|min:8',
    'stall_name' => 'required|max:255|unique:stalls',
    'phone' => 'digits:10|numeric'
  ];

  $messages = [
    'name.min' => 'tên ít nhất có 3 ký tự',
    'email.required' => 'email là trường bắt buộc!',
    'email.email' => 'không đúng định dạng abc@abc.xyz!',
    'email.unique' => 'email đã tồn tại',
    'password.required' => 'password là trường bắt buộc!',
    'password.min' => 'password quá ngắn!',
    'stall_name.required' => 'Tên gian hàng là trường bắt buộc!',
    'stall_name.max' => 'Tên gian hàng không được quá 255 ký tự!',
    'stall_name.unique' => 'tên gian hàng đã tồn tại',
    'phone.digits' => 'số điện thoại gồm 10 số',
    'phone.numeric' => 'số điện thoại phải là dạng số',
  ];

  $validator = Validator::make($data,$rules,$messages);

  if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput();
  }
  else{
    if ($data['create_stall'] == true) {
      $stall = Stall::create($data);
      $get_stall = Stall::where('stall_name', $data['stall_name'])->first();
      $data['stall_id'] = $get_stall->id;
      $data['admin'] = 1;
    }
    $user = $this->create($data);
    Auth::login($user);
    return redirect('/customer-profile');
  }

}


}
