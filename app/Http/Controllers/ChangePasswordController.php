<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    // パスワード変更画面
    public function edit()
    {
        return view('passwordform');
    }

    public function change(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'new_password' => 'required|string|min:8|max:20|confirmed',
        ]);
        
        $updateId = Auth::id();

        // パスワードを保存
        $member = Member::find($updateId);
        $member->password = bcrypt($request->new_password);
        $member->save();

        return redirect ('/mypage');
    }
}
