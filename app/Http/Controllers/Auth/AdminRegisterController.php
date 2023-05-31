<?php
namespace App\Http\Controllers\Auth;

use App\Administer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Http\Request;


class AdminRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Administer::create([
            'name' => $data['name'],
            'loginid' => $data['loginid'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        // $this->validator($request->all())->validate();
        $admin = $this->create($request->all());
        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.home');
    }
}
