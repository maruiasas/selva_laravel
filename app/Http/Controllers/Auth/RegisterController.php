<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // バリデーション
        $data = session()->all();                                       
        return Validator::make($data, [
            'name_sei' => ['required', 'string', 'max:20'],
            'name_mei' => ['required', 'string', 'max:20'],
            'nickname' => ['required', 'string', 'max:10'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'max:20',  'confirmed'],
        ]);
    }

    public function confirm()                                          
    {     
        //  確認画面ビュー
        $request = request();                                          
        $request->validate([                                           
            'name_sei' => ['required', 'string', 'max:20'],
            'name_mei' => ['required', 'string', 'max:20'],
            'nickname' => ['required', 'string', 'max:10'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'max:20',  'confirmed'],
        ]);                                                 
        foreach($request->all() as $key => $val){                      
            $request->session()->put($key, $request->$key);            
        }                                                              
        return view('auth.confirm');                                   
    }

    protected function complete()
    {
        // DBインサート
        $member = session()->all(); 
        Member::create([
            'name_sei' => $member['name_sei'],
            'name_mei' => $member['name_mei'],
            'nickname' => $member['nickname'],
            'gender' => $member['gender'],
            'email' => $member['email'],
            'password' => Hash::make($member['password']),
        ]);
        // 登録完了メール送信
        Mail::send(new RegisterMail());
        return view('auth.complete');   
    }

    protected function home()
    {
    return view('home');   
    }                                
}                                                            