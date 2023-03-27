<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use DB;
use App\Member;
use Illuminate\Support\Facades\Hash;

class MembersController extends Controller
{
    // 登録画面の表示
    public function regist()
    {
        return view('regist');
    }

    public function confirm(Request $request)
    {

        //入力値の取得
        $member = new Member($request->all());

        // バリデーション
        $this->validate($request, [
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|confirmed:password|min:8|max:20',
            'email' => 'required|email|unique:members',
        ]);

        //セッションに保存
        $request->session()->put('member', [
            'name_sei' => $request->input('name_sei'),
            'name_mei' => $request->input('name_mei'),
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
        ]);

        // 確認画面の表示
        $name_sei = $request->input('name_sei');
        $name_mei = $request->input('name_mei');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $password_confimation = $request->input('password_confimation');
        $email = $request->input('email');

        return view('confirm', compact('name_sei', 'name_mei', 'nickname', 'gender', 'password', 'email'));
    }

    public function thanks(Request $request)
    {

        //セッションから取得
        $member = $request->session()->get('member');

        // DBインサート
        Member::create([
            'name_sei' => $member['name_sei'],
            'name_mei' => $member['name_mei'],
            'nickname' => $member['nickname'],
            'gender' => $member['gender'],
            'password' => Hash::make($member['password']),
            'email' => $member['email'],
        ]);

        return view('thanks');
    }
}
