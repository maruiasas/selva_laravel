<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Administer;
use Log;
use Illuminate\Http\Request;

class LoginController extends Controller
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin.login', ['authgroup' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'loginid'   => 'required|string',
            'password' => 'required|min:6'
        ]);
    
        if (Auth::guard('admin')->attempt(['loginid' => $request->loginid, 'password' => $request->password], $request->get('remember'))) {
            Log::info('Admin login success');
            return redirect('admin/home');
        } else {
            Log::error('Admin login failed: invalid loginid or password');
            return back()->withInput($request->only('loginid', 'remember'));
        }
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
