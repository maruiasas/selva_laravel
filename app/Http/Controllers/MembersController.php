<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use App\Review;
use App\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use resources\views\vendor\pagination;

class MembersController extends Controller
{
    // マイページ
    public function mypage()                                          
    {     
        return view('mypage');
    }

    // 退会ページへ
    public function withdrawal()                                          
    {     
        return view('withdrawal');
    }

    // 退会実行
    public function destroy()
    {
        $userId = Auth::id();

        $user = Member::find($userId);
        $user->delete();
        return redirect('/');
    }

    public function update()
    {
        return view('update'); 
    }

    public function updateconfirm(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
        ]);

        //セッションに保存
        $request->session()->put('member', [
            'name_sei' => $request->input('name_sei'),
            'name_mei' => $request->input('name_mei'),
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
        ]);

        // 確認画面の表示
        $name_sei = $request->input('name_sei');
        $name_mei = $request->input('name_mei');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');
        
        $post = [];
        $post['name_sei'] =  $request->input('name_sei');
        $post['name_mei'] =  $request->input('name_mei');
        $post['nickname'] =  $request->input('nickname');
        $post['gender'] =  $request->input('gender');

        return view('updateconfirm', compact('post')); 
    }
    
    public function updatecomplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $update_member = $request->session()->get('member');
        $updateId = Auth::id();
        
        // 更新処理
        $member = Member::find($updateId);
        $member->name_sei = $update_member['name_sei'];
        $member->name_mei = $update_member['name_mei'];
        $member->nickname = $update_member['nickname'];
        $member->gender = $update_member['gender'];
        $member->save();
        
        return redirect('/mypage');
    }

    // 会員一覧
    public function memberslist(Request $request)
    {   
        // 検索QUERY
        $query = Member::query();
        
    // 検索条件取得
    $id = $request->input('id');
    $gender = $request->input('gender');
    $box = $request->input('box');

    if ($id) {
        $query->where('id', $id);
    }

    if ($gender) {
        $query->whereIn('gender', $gender);
    }

    if ($box) {
        $query->where(function ($q) use ($box) {
            $q->where('name_sei', 'LIKE', "%{$box}%")
                ->orWhere('name_mei', 'LIKE', "%{$box}%")
                ->orWhere('email', 'LIKE', "%{$box}%");
        });
    }

    // ソート処理
    $query->sortable();

    // 検索結果
    $members = $query->orderBy('id', 'desc')->paginate(10);

    return view('members.list')->with('members', $members);
}

    // 会員登録画面の表示
    public function MemberForm()
    {        
        return view('members.register');
    }

    // 確認画面へ
    public function MemberConfirm(Request $request)                                      
    {   
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name_sei' => 'required|string|max:20',
            'name_mei' => 'required|string|max:20',
            'nickname' => 'required|string|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|string|max:200||email|unique:members,email,NULL,id,deleted_at,NULL',
            'email' => 'required|string|min:8|max:20|confirmed',
        ]);

        // 確認画面の表示   
        $post = [];
        $post['name_sei'] =  $request->input('name_sei');
        $post['name_mei'] =  $request->input('name_mei');
        $post['nickname'] =  $request->input('nickname');
        $post['gender'] =  $request->input('gender');
        $post['password'] =  $request->input('password');
        $post['email'] =  $request->input('email');

        // セッションに保存
        $request->session()->put('member', $post);

        return view('members.confirm', compact('post'));
    }

    // 登録へ
    public function MemberComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $members = $request->session()->get('member');

        // DBインサート
        Member::create([
        'name_sei' => $members['name_sei'],
        'name_mei' => $members['name_mei'],
        'nickname' => $members['name_mei'],
        'gender' => $members['gender'],
        'password' => Hash::make($members['password']),
        'email' => $members['email'],
        ]);

        return redirect('/admin/members/list');
    }

    // 会員編集
    public function MemberUpdate($id)
    {
        $member = Member::find($id);
        return view('members.update', compact('member')); 
    }

    public function MemberUpdateConfirm(Request $request)
    {
        // バリデーション
        $id = $request->input('id');
        $member = Member::find($id);

            $this->validate($request, [
                'name_sei' => 'required|max:20',
                'name_mei' => 'required|max:20',
                'nickname' => 'required|max:10',
                'gender' => 'required|in:1,2',
            ]);

            if($request->input('email') != $member->email)
            {
                $this->validate($request, [
                    'email' => 'required|string|max:200|email|unique:members,email,NULL,id,deleted_at,NULL',
            ]);
            }

            if($request->input('password') != $member->password)
            {
                $this->validate($request, [
                    'password' => 'required|string|min:8|max:20|confirmed',
            ]);
            }

        // 確認画面の表示
        $post = [];
        $post['id'] =  $request->input('id');
        $post['name_sei'] =  $request->input('name_sei');
        $post['name_mei'] =  $request->input('name_mei');
        $post['nickname'] =  $request->input('nickname');
        $post['gender'] =  $request->input('gender');
        $post['password'] =  $request->input('password');
        $post['email'] =  $request->input('email');

         // セッションに保存
         $request->session()->put('member', $post);

        return view('members.updateconfirm', compact('post')); 
    }
    
    public function MemberUpdateComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $edit_member = $request->session()->get('member');
        $editId = $edit_member['id'];
        
        // 更新処理
        $member = Member::find($editId);
        $member->name_sei = $edit_member['name_sei'];
        $member->name_mei = $edit_member['name_mei'];
        $member->nickname = $edit_member['nickname'];
        $member->gender = $edit_member['gender'];
        $member->password = Hash::make($edit_member['password']);
        $member->email = $edit_member['email'];
        $member->save();
        
        return redirect('/admin/members/list');
    }

    // 詳細画面の表示
    public function MemberShow($id)
    {
        $member = Member::find($id);

        return view('members.show', compact('member')); 
    }

    // 削除実行
    public function MemberWithdrawal($id)
    {
        $user = Member::find($id);
        $user->delete();
        return redirect('/admin/members/list');
    }

        // 画像アップロード
        public function uploadAjax(Request $request)
        {
            // ファイル名を取得
            $files = $request->file('file');
            $fileName = $files->getClientOriginalName();
    
            // ファイルを特定のディレクトリに保存(←これをしないと表示できない)
            $files->move(public_path('images'), $fileName);
    
            // ファイルへのパスを返す
            return response()->json(['upload' => '/images/' . $fileName]);
        }
}
