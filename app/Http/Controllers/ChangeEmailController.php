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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeMail;

class ChangeEmailController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    // パスワード変更画面
    public function edit()
    {
        return view('emailform');
    }

    // 確認メールの送信
    public function change(Request $request)
    {
    // バリデーション
    $this->validate($request, [
        'new_email' => 'required|string|max:200|email|unique:members,email,NULL,id,deleted_at,NULL',
    ]);

    // 認証コード生成
    $authCode = 112233;

    // ログインしているユーザーを取得
    $updateId = Auth::id();
    $member = Member::find($updateId);

    $new_email = $request->new_email;

    // 認証コードをメールで送信
    Mail::send(new ChangeMail($authCode));

    // 認証コードをDBに保存
    $member->auth_code = $authCode;
    $member->save();
    
    return view('emailconfirm', compact('new_email', 'updateId'));
}

    // 認証コードを照合してメールアドレス変更
    public function complete(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'authCode' => 'required|exists:members,auth_code',
        ]);

        $updateId = $request->updateId;
        $member = Member::find($updateId);
        $member->email = $request->new_email;
        $member->save();

        return redirect('/mypage');
    }
}



