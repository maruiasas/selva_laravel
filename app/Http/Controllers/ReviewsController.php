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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use resources\views\vendor\pagination;
use App\Http\Controllers\Str;

class ReviewsController extends Controller
{
    // 商品レビュー管理
    public function list()
    {   
        $reviews = Review::with('product')->paginate(5);

        return view('reviews.master')->with('reviews', $reviews);
    }

    // 商品レビュー編集
    public function edit($id)
    {   
        $review = Review::find($id);

        $reviews = Review::where('product_id', $review->product_id)->get();
        $avg_evaluation = ceil($reviews->avg('evaluation'));

        return view('reviews.edit', compact('avg_evaluation', 'review'));
    }

    public function confirm(Request $request)
    {
        $product_id = $request->product_id;
        $review_id = $request->id;

        $product = Product::find($product_id);
        $reviews = Review::where('product_id', $product_id)->get();
        $avg_evaluation = ceil($reviews->avg('evaluation'));

        // バリデーション
        $this->validate($request, [
            'evaluation' => 'required|in:1,2,3,4,5',
            'comment' => 'required|max:500',
        ]);

        //セッションに保存
        $request->session()->put('review', [
            'evaluation' => $request->input('evaluation'),
            'comment' => $request->input('comment'),
        ]);

        // 確認画面の表示
        $evaluation = $request->input('evaluation');
        $comment = $request->input('comment');
        
        $post = [];
        $post['evaluation'] =  $request->input('evaluation');
        $post['comment'] =  $request->input('comment');

        return view('reviews.confirm', compact('post', 'avg_evaluation', 'product', 'product_id', 'review_id'));
    }

    public function update(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $update_review = $request->session()->get('review');
        $review_id = $request->review_id;
        
        // 更新処理
        $review = Review::find($review_id);
        $review->evaluation = $update_review['evaluation'];
        $review->comment = $update_review['comment'];
        $review->save();

        return redirect('/review/master');
    }

    // 削除画面
    public function delete($id)
    {
        $review = Review::find($id);

        $reviews = Review::where('product_id', $review->product_id)->get();
        $avg_evaluation = ceil($reviews->avg('evaluation'));

        return view('reviews.delete', compact('avg_evaluation', 'review', 'id'));
    }

    // 削除実行
    public function deletecomplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $delete_review = $request->session()->get('review');
        
        Review::find($request->id)->delete();

        return redirect('/review/master');
    }
}
