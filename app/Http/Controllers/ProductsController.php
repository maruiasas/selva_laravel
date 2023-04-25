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

class ProductsController extends Controller
{
    // 登録画面の表示
    public function ProductForm()
    {        
        $category = new ProductCategory;
        $categories = $category->getLists()->prepend('選択', '');

        // エラー時に画像を取得
        $imagePath1 = session('imagePath1');
        $imagePath2 = session('imagePath2');
        $imagePath3 = session('imagePath3');
        $imagePath4 = session('imagePath4');
        session()->forget('imagePath1');
        session()->forget('imagePath2');
        session()->forget('imagePath3');
        session()->forget('imagePath4');

        return view('products.register', ['product_categories' => $categories], compact('imagePath1', 'imagePath2', 'imagePath3', 'imagePath4'));
    }

    // 小カテゴリの表示
    public function ProductCategoryAjax(Request $request)
    {
        $category_id = $request->id;
        $subcategory_list = ProductSubcategory::where('product_category_id', $category_id)->get()->toArray();

        return($subcategory_list);
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

    // 確認画面へ
    public function ProductConfirm(Request $request)                                      
    {   
        // バリデーション
        $this->validate($request, [
            'name' => 'required|max:100',
            'product_content' => 'required|max:500',
            'product_categories' => 'required',
            'product_subcategories' => 'required',
            'image_1' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_2' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_3' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_4' => 'max:10240|mimes:jpg,jpeg,png,gif',
        ]);

        // // マッキー試行↓
        $image_1_tmp = $request->file('image_1');
        $image_2_tmp = $request->file('image_2');
        $image_3_tmp = $request->file('image_3');
        $image_4_tmp = $request->file('image_4');

        //セッションに保存
        $request->session()->put('product', [
            'name' => $request->input('name'),
            'product_content' => $request->input('product_content'),
            'product_categories' => $request->input('product_categories'),
            'product_subcategories' => $request->input('product_subcategories'),
            'image_1' => $image_1_tmp ? $image_1_tmp->getClientOriginalName() : '',
            'image_2' => $image_2_tmp ? $image_2_tmp->getClientOriginalName() : '',
            'image_3' => $image_3_tmp ? $image_3_tmp->getClientOriginalName() : '',
            'image_4' => $image_4_tmp ? $image_4_tmp->getClientOriginalName() : '',
        ]);

        // 確認画面の表示
        $name = $request->input('name');
        $product_content = $request->input('product_content');
        $product_categories = $request->input('product_categories');
        $product_subcategories = $request->input('product_subcategories');
        $image_1 = $request->input('image_1');
        $image_2 = $request->input('image_2');
        $image_3 = $request->input('image_3');
        $image_4 = $request->input('image_4');

        $product = ProductCategory::find($product_categories);
        $product_name = $product->name;
        
        $post = [];
        $post['name'] =  $request->input('name');
        $post['product_content'] =  $request->input('product_content');
        $post['product_categories'] =  $product_name;
        $post['product_subcategories'] =  $request->input('product_subcategories');
        $post['image_1'] =  $image_1_tmp ? $image_1_tmp->getClientOriginalName() : '';
        $post['image_2'] =  $image_2_tmp ? $image_2_tmp->getClientOriginalName() : '';
        $post['image_3'] =  $image_3_tmp ? $image_3_tmp->getClientOriginalName() : '';
        $post['image_4'] =  $image_4_tmp ? $image_4_tmp->getClientOriginalName() : '';

        // 画像エラー時にセッションを渡す
        $imagePath1 = $image_1_tmp ? $image_1_tmp->getClientOriginalName() : '';
        $imagePath2 = $image_2_tmp ? $image_2_tmp->getClientOriginalName() : '';
        $imagePath3 = $image_3_tmp ? $image_3_tmp->getClientOriginalName() : '';
        $imagePath4 = $image_4_tmp ? $image_4_tmp->getClientOriginalName() : '';
        session(['imagePath1' => $imagePath1]);
        session(['imagePath2' => $imagePath2]);
        session(['imagePath3' => $imagePath3]);
        session(['imagePath4' => $imagePath4]);

        return view('products.confirm', compact('post'));
    }

    // 登録へ
    public function ProductComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();

        //セッションから取得
        $products = $request->session()->get('product');

        $product_categories = $products['product_categories'];
        $product_category_id = intval($products['product_categories']);

        $product_subcategories = $products['product_subcategories'];
        $product_sub = ProductSubcategory::where('name', $product_subcategories)->get('id');
        $product_subcategory_id = json_decode($product_sub)[0]->id;

        $userId = Auth::id();

        // DBインサート
        Product::create([
        'member_id' => $userId,
        'name' => $products['name'],
        'product_content' => $products['product_content'],
        'product_category_id' => $product_category_id,
        'product_subcategory_id' => $product_subcategory_id,
        'image_1' => $products['image_1'],
        'image_2' => $products['image_2'],
        'image_3' => $products['image_3'],
        'image_4' => $products['image_4'],
        ]);

        return redirect('/products/list');
    }

    // 一覧表示
    public function productlist(Request $request)
    {   
        // カテゴリ選択
        $category = new ProductCategory;
        $categories = $category->getLists()->prepend('選択', '');

        //大カテゴリ取得
        $product_categories = $request->input('product_categories');

        // 小カテゴリ取得
        $product_subcategories = $request->input('product_subcategories');
        $product_subcategories = $request['product_subcategories'];
        if(isset($product_subcategories)){
            $product_sub = ProductSubcategory::where('name', $product_subcategories)->get('id');
            $product_subcategory_id = json_decode($product_sub)[0]->id;
        }

        // フリーワード取得
        $box = $request->input('box');
        
        // 検索QUERY
        $query = Product::query();
        
        // 「カテゴリ」検索
        if(!empty($product_categories) && !empty($product_subcategory_id)){
            $query->where(function($query) use ($product_categories, $product_subcategory_id){
                $query->where('product_category_id', 'LIKE', "%{$product_categories}%")
                ->where('product_subcategory_id', 'LIKE', "%{$product_subcategory_id}%");
            });
        } elseif (!empty($product_categories)) {
            $query->where('product_category_id', 'LIKE', "%{$product_categories}%");
        } elseif (!empty($product_subcategory_id)) {
            $query->where('product_subcategory_id', 'LIKE', "%{$product_subcategory_id}%");
        }

        // 「商品名」「商品説明」検索
        if(!empty($box)) {
            $query->where(function ($query) use ($box) {
                $query->where('name', 'LIKE', "%{$box}%")
                    ->orWhere('product_content', 'LIKE', "%{$box}%");
            });
        }

        // 総合評価
        $products = $query->with(['reviews' => function ($query) {
            $query->select('product_id', DB::raw('CEIL(AVG(evaluation)) as avg_evaluation'))
                  ->groupBy('product_id');
        }])->orderBy('id', 'desc')->paginate(10);

        return view('products.list', ['product_categories' => $categories])->with('products', $products);
    }

    // 詳細画面の表示
    public function show($id)
    {
        $product = Product::find($id);

        $product_category = ProductCategory::find($product['product_category_id']);
        $category_name = $product_category->name;

        $product_subcategory = ProductSubcategory::find($product['product_subcategory_id']);
        $subcategory_name = $product_subcategory->name;

        // レビュー
        $reviews = Review::where('product_id', $id)->get();
        $avg_evaluation = ceil($reviews->avg('evaluation'));

        return view('products.show', compact('product', 'category_name', 'subcategory_name', 'avg_evaluation'));
    }

    // 商品レビュー一覧
    public function review($product_id)
    {
        $product = Product::find($product_id);
        $review = Review::where('product_id', $product_id)->get();
        $avg_evaluation = ceil(Review::where('product_id', $product_id)->avg('evaluation'));
        $reviews = Review::where('product_id', $product_id)->paginate(5);

        return view('products.review', compact('reviews', 'product', 'avg_evaluation'));
    }

    // 商品レビュー登録
    public function reviewregist($product_id)
    {
        $product = Product::find($product_id);
        $reviews = Review::where('product_id', $product_id)->get();
        $avg_evaluation = ceil($reviews->avg('evaluation'));

        return view('products.reviewregist', compact('product', 'avg_evaluation', 'product_id'));
    }

    // 商品レビュー確認画面へ
    public function reviewconfirm(Request $request)
    {

    $product_id = $request->product_id;
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

    return view('products.reviewconfirm', compact('post', 'avg_evaluation', 'product', 'product_id'));
}

    // 商品レビュー登録完了画面へ
    public function reviewcomplete(Request $request)
    {
        //セッションから取得
        $product_id = $request->product_id;
        $review = $request->session()->get('review');

        $userId = Auth::id();

        // DBインサート
        Review::create([
        'member_id' => $userId,
        'product_id' => $product_id,
        'evaluation' => $review['evaluation'],
        'comment' => $review['comment'],
        ]);

        return view('products.reviewcomplete', compact('product_id'));
    }

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
}                                                            