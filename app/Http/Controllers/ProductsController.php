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
        $subcategory = new ProductSubCategory;
        $sub_categories = $subcategory->getLists()->prepend('選択', '');

        return view('products.register', ['product_categories' => $categories, 'product_subcategories' => $sub_categories]);
    }

    // 小カテゴリの表示
    public function CategoryAjax(Request $request)
    {
        $category_id = $request->id;
        $subcategory_list = ProductSubcategory::where('product_category_id', $category_id)->get()->toArray();
    
        return response()->json($subcategory_list);
    }    

    // 確認画面へ
    public function ProductConfirm(Request $request)                                      
    {   
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'product_content' => 'required|max:500',
            'product_categories' => 'required',
            'product_subcategories' => 'required',
            'image_1' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_2' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_3' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_4' => 'max:10240|mimes:jpg,jpeg,png,gif',
        ]);
        if ($validator->fails()) {
            $category = new ProductCategory;
            $categories = $category->getLists()->prepend('選択', '');
            $subcategory = new ProductSubCategory;
            $sub_categories = $subcategory->getLists()->prepend('選択', '');
        
            $image_1_tmp = $request->file('image_1');
            $imagePath1 = $image_1_tmp->getClientOriginalName();
            $sessionData = [
                'product_categories' => $categories,
                'product_subcategories' => $sub_categories,
                'image_1' => $imagePath1,
            ];
            $request->session()->put('formData', $sessionData);
        
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // // マッキー試行↓
        $image_1_tmp = $request->file('image_1');
        $image_2_tmp = $request->file('image_2');
        $image_3_tmp = $request->file('image_3');
        $image_4_tmp = $request->file('image_4');


        //セッションに保存
        // $request->session()->put('product', [
        //     'name' => $request->input('name'),
        //     'product_content' => $request->input('product_content'),
        //     'product_categories' => $request->input('product_categories'),
        //     'product_subcategories' => $request->input('product_subcategories'),
        //     'image_1' => $image_1_tmp ? $image_1_tmp->getClientOriginalName() : '',
        //     'image_2' => $image_2_tmp ? $image_2_tmp->getClientOriginalName() : '',
        //     'image_3' => $image_3_tmp ? $image_3_tmp->getClientOriginalName() : '',
        //     'image_4' => $image_4_tmp ? $image_4_tmp->getClientOriginalName() : '',
        // ]);

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
        $product_subcategory_id = intval($products['product_subcategories']);

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

    // 管理画面
    // 商品カテゴリ一覧・検索
    public function categorylist(Request $request)
    {
        // 検索QUERY
        $query = ProductCategory::query();
        
        // 検索条件取得
        $id = $request->input('id');
        $box = $request->input('box');

        $query->when($id, function ($q, $id) {
            return $q->where('id', $id);
        })
        ->when($box, function ($q, $box) {
            return $q->where(function ($q) use ($box) {
                $q->where('name', 'LIKE', "%{$box}%")
                    ->orWhereHas('subcategories', function ($q) use ($box) {
                        $q->where('name', 'LIKE', "%{$box}%");
                    });
            });
        });
        
         // ソート処理
        $query->sortable();

        // 検索結果
        $categories = $query->orderBy('id', 'desc')->paginate(10);

        return view('members.categorylist')->with('categories', $categories);
    }

    // カテゴリ登録画面
    public function CategoryForm(Request $request)
    {
        return view('members.categoryregister');
    }

     // カテゴリ登録確認画面へ
     public function CategorysConfirm(Request $request)
     {
        // バリデーション
        $this->validate($request, [
            'categories' => 'required|max:20',
            'subcategories1' => 'required_without_all:subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories2' => 'required_without_all:subcategories1,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories3' => 'required_without_all:subcategories1,subcategories2,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories4' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories5' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories6' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories7' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories8' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories9,subcategories10|max:20',
            'subcategories9' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories10|max:20',
            'subcategories10' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9|max:20',
        ]);

        // 確認画面の表示        
        $post = $request->all();
        $subcategories = [];
        
        // subcategoriesをループで配列に格納する
        foreach ($post as $key => $value) {
            if (strpos($key, 'subcategories') !== false) {
                $subcategories[] = $value;
            }
        }
        
        // カテゴリ情報とsubcategoriesの配列をセッションに保存
        $request->session()->put('category', [
            'categories' => $post['categories'],
            'subcategories' => $subcategories
        ]);

        return view('members.categoryconfirm', compact('post'));
}

    // カテゴリ登録完了画面へ
    public function CategoryComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $category = $request->session()->get('category');

        // 大カテゴリDBインサート
        $productCategory = ProductCategory::create([
        'name' => $category['categories'],
        ]);
        // 新しいレコードのIDを取得する
        $newCategoryId = $productCategory->id;

        $subcategories = $category['subcategories'];

        // 小カテゴリDBインサート
        foreach ($subcategories as $subcategory) {
        if (!empty($subcategory)) {
            ProductSubcategory::create([
                'product_category_id' => $newCategoryId,
                'name' => $subcategory,
            ]);
            }
        }
        return redirect('members/categorylist');
    }

    // 編集画面の表示
    public function CategoryUpdate($id)
    {
        $category = ProductCategory::find($id);
        $subcategory = ProductSubcategory::where('product_category_id', $id)->get();

        return view('members.categoryedit', compact('category', 'subcategory'));
    }
    
    // 編集画面の表示
    public function CategoryUpdateConfirm(Request $request)
    {
        $update_id = $request->update_id;

        // バリデーション
        $this->validate($request, [
            'categories' => 'required|max:20',
            'subcategories1' => 'required_without_all:subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories2' => 'required_without_all:subcategories1,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories3' => 'required_without_all:subcategories1,subcategories2,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories4' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories5' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories6,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories6' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories7,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories7' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories8,subcategories9,subcategories10|max:20',
            'subcategories8' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories9,subcategories10|max:20',
            'subcategories9' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories10|max:20',
            'subcategories10' => 'required_without_all:subcategories1,subcategories2,subcategories3,subcategories4,subcategories5,subcategories6,subcategories7,subcategories8,subcategories9|max:20',
        ]);

        // 確認画面の表示        
        $post = $request->all();
        $subcategories = [];
        
        // subcategoriesをループで配列に格納する
        foreach ($post as $key => $value) {
            if (strpos($key, 'subcategories') !== false) {
                $subcategories[] = $value;
            }
        }
        
        // カテゴリ情報とsubcategoriesの配列をセッションに保存
        $request->session()->put('category', [
            'categories' => $post['categories'],
            'subcategories' => $subcategories
        ]);

        return view('members.categoryeditconfirm', compact('post', 'update_id'));
    }

    public function CategoryUpdateComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
            
        //セッションから取得
        $update_category = $request->session()->get('category');
        $update_id = $request->update_id;
    
        // 大カテゴリ編集
        $category = ProductCategory::find($update_id);
        $category->name = $update_category['categories'];
        $category->save();
        
        $subcategories = $update_category['subcategories'];

        // 小カテゴリ編集
        // 既存のサブカテゴリを物理削除
        ProductSubcategory::where('product_category_id', $update_id)->delete();

        // 新たにサブカテゴリを登録
        foreach ($subcategories as $index => $sub) {
            if (!empty($sub)) {
                $subcategory = new ProductSubcategory();
                $subcategory->product_category_id = $update_id;
                $subcategory->name = $sub;
                $subcategory->save();
            }
        }

        return redirect('members/categorylist');
    }

    // 商品大カテゴリ詳細画面の表示
    public function categoryshow($id)
    {
        $category = ProductCategory::find($id);
        $category_name = $category->name;

        $subcategories = ProductSubcategory::where('product_category_id', $id)->get();

        return view('members.categoryshow', compact('category', 'subcategories'));
    }

    // 削除実行
    public function CategoryWithdrawal($id)
    {
        $category = ProductCategory::find($id);
        $category->delete();

        $subcategories = ProductSubcategory::where('product_category_id', $id)->get();
        foreach ($subcategories as $subcategory) {
            $subcategory->delete();
        }

        return redirect('/members/categorylist');
    }

    // 商品一覧・検索
    public function ProductView(Request $request)
    {
        // 検索QUERY
        $query = Product::query();
        
        // 検索条件取得
        $id = $request->input('id');
        $box = $request->input('box');

        $query->when($id, function ($q, $id) {
            return $q->where('id', $id);
        })
        ->when($box, function ($q, $box) {
            return $q->where(function ($q) use ($box) {
                $q->where('name', 'LIKE', "%{$box}%")
                  ->orWhere('product_content', 'LIKE', "%{$box}%");
            });
        });
        
         // ソート処理
        $query->sortable();

        // 検索結果
        $products = $query->orderBy('id', 'desc')->paginate(10);

        return view('members.productlist')->with('products', $products);
    }

    // 登録画面の表示
    public function ProductsForm()
    {        
        $category = new ProductCategory;
        $categories = $category->getLists()->prepend('選択', '');
        $subcategory = new ProductSubCategory;
        $sub_categories = $subcategory->getLists()->prepend('選択', '');

        return view('members.productregister', ['product_categories' => $categories, 'product_subcategories' => $sub_categories]);
    }

    public function uploadAjax(Request $request)
    {
        // ファイル名を取得
        $files = $request->file('file');
        $fileName = $files->getClientOriginalName();
    
        // デバッグ用のログ文
        Log::info('ファイル名: ' . $fileName);
    
        // ファイルを特定のディレクトリに保存(←これをしないと表示できない)
        $files->move(public_path('images'), $fileName);
    
        // デバッグ用のログ文
        Log::info('ファイルが保存されました');
    
        // ファイルへのパスを返す
        return response()->json(['upload' => '/images/' . $fileName]);
    }

    // 確認画面へ
    public function ProductsConfirm(Request $request)                                      
    {   
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'product_content' => 'required|max:500',
            'product_categories' => 'required',
            'product_subcategories' => 'required',
            'image_1' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_2' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_3' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_4' => 'max:10240|mimes:jpg,jpeg,png,gif',
        ]);
        if ($validator->fails()) {
            $category = new ProductCategory;
            $categories = $category->getLists()->prepend('選択', '');
            $subcategory = new ProductSubCategory;
            $sub_categories = $subcategory->getLists()->prepend('選択', '');
        
            $image_1_tmp = $request->file('image_1');
            $imagePath1 = $image_1_tmp->getClientOriginalName();
            $sessionData = [
                'product_categories' => $categories,
                'product_subcategories' => $sub_categories,
                'image_1' => $imagePath1,
            ];
            $request->session()->put('formData', $sessionData);
        
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // // マッキー試行↓
        $image_1_tmp = $request->file('image_1');
        $image_2_tmp = $request->file('image_2');
        $image_3_tmp = $request->file('image_3');
        $image_4_tmp = $request->file('image_4');

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

        $products = ProductSubcategory::find($product_subcategories);
        $product_subname = $products->name;
        
        $post = [];
        $post['name'] =  $request->input('name');
        $post['product_content'] =  $request->input('product_content');
        $post['product_categories'] =  $request->input('product_categories');
        $post['product_subcategories'] =  $request->input('product_subcategories');
        $post['image_1'] =  $image_1_tmp ? $image_1_tmp->getClientOriginalName() : '';
        $post['image_2'] =  $image_2_tmp ? $image_2_tmp->getClientOriginalName() : '';
        $post['image_3'] =  $image_3_tmp ? $image_3_tmp->getClientOriginalName() : '';
        $post['image_4'] =  $image_4_tmp ? $image_4_tmp->getClientOriginalName() : '';

        $request->session()->put('product', $post);

        return view('members.productconfirm', compact('post', 'product_name', 'product_subname'));
    }

    // 登録へ
    public function ProductsComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
        
        //セッションから取得
        $products = $request->session()->get('product');

        $product_categories = $products['product_categories'];
        $product_category_id = intval($products['product_categories']);

        $product_subcategories = $products['product_subcategories'];
        $product_subcategory_id = intval($products['product_subcategories']);

        // DBインサート
        Product::create([
        'member_id' => 2,
        'name' => $products['name'],
        'product_content' => $products['product_content'],
        'product_category_id' => $product_category_id,
        'product_subcategory_id' => $product_subcategory_id,
        'image_1' => $products['image_1'],
        'image_2' => $products['image_2'],
        'image_3' => $products['image_3'],
        'image_4' => $products['image_4'],
        ]);

        return redirect('/members/productlist');
    }

    // 商品編集画面の表示
    public function ProductUpdate($id)
    {
        $product = Product::find($id);
        $product_categories = ProductCategory::all();
        $selected_category = $product->product_category_id;
        $product_subcategories = ProductSubcategory::all();
        $selected_subcategory = $product->product_subcategory_id;

        // 商品カテゴリのAjax URLを取得
        $ajax_url = ('/members/category');

        return view('members.productedit', compact('product', 'product_categories', 'selected_category', 'product_subcategories', 'selected_subcategory', 'ajax_url'));
    }
    
    // 商品編集画面の確認へ
    public function ProductUpdateConfirm(Request $request)
    {
        $update_id = $request->id;

        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'product_content' => 'required|max:500',
            'product_categories' => 'required',
            'product_subcategories' => 'required',
            'image_1' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_2' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_3' => 'max:10240|mimes:jpg,jpeg,png,gif',
            'image_4' => 'max:10240|mimes:jpg,jpeg,png,gif',
        ]);

        if($request->file('image_1')){
            $imagePath1 = $request->file('image_1')->getClientOriginalName();
        } else {
            $imagePath1 = $request->input('product_image1');
        }

        if($request->file('image_2')){
            $imagePath2 = $request->file('image_2')->getClientOriginalName();
        } else {
            $imagePath2 = $request->input('product_image2');
        }

        if($request->file('image_3')){
            $imagePath3 = $request->file('image_3')->getClientOriginalName();
        } else {
            $imagePath3 = $request->input('product_image3');
        }

        if($request->file('image_4')){
            $imagePath4 = $request->file('image_4')->getClientOriginalName();
        } else {
            $imagePath4 = $request->input('product_image4');
        }

        // 確認画面の表示
        $name = $request->input('name');
        $product_content = $request->input('product_content');
        $product_categories = $request->input('product_categories');
        $product_subcategories = $request->input('product_subcategories');

        $category = ProductCategory::find($product_categories);
        $category_name = $category->name;

        $subcategory = ProductSubcategory::find($product_subcategories);
        $subcategory_name = $subcategory->name;
        
        $post = [];
        $post['id'] = $update_id;
        $post['name'] = $request->input('name');
        $post['product_content'] = $request->input('product_content');
        $post['product_categories'] = $request->input('product_categories');
        $post['product_subcategories'] = $request->input('product_subcategories');
        $post['image_1'] = $imagePath1;
        $post['image_2'] = $imagePath2;
        $post['image_3'] = $imagePath3;
        $post['image_4'] = $imagePath4;

        $request->session()->put('product', $post);

        return view('members.producteditconfirm', compact('post', 'category_name', 'subcategory_name'));
    }

    public function ProductUpdateComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
            
        //セッションから取得
        $update_product = $request->session()->get('product');
        $update_id = $request->id;
    
        // 編集
        $product = Product::find($update_id);

        $product->name = $update_product['name'];
        $product->product_content = $update_product['product_content'];
        $product->product_category_id = $update_product['product_categories'];
        $product->product_subcategory_id = $update_product['product_subcategories'];
        $product->image_1 = $update_product['image_1'];
        $product->image_2 = $update_product['image_2'];
        $product->image_3 = $update_product['image_3'];
        $product->image_4 = $update_product['image_4'];
        $product->save();
    
        return redirect('/members/productlist');
    }

    // 商品詳細画面の表示
    public function ProductShow($id)
    {
        // 商品の部分
        $product = Product::find($id);
        $category = ProductCategory::where('id', $product->product_category_id)->get();
        $subcategory = ProductSubcategory::where('id', $product->product_subcategory_id)->get();

        // レビュー
        $review = Review::where('product_id', $id)->get();
        $avg_evaluation = ceil($review->avg('evaluation'));
        $reviews = Review::where('product_id', $id)->paginate(5);

        return view('members.productshow', compact('product', 'category', 'subcategory', 'avg_evaluation', 'reviews'));
    }

    // 削除実行
    public function ProductWithdrawal($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/members/productlist');
    }

    // レビュー一覧・検索
    public function ReviewView(Request $request)
    {
        // 検索QUERY
        $query = Review::query();
        
        // 検索条件取得
        $id = $request->input('id');
        $box = $request->input('box');

        $query->when($id, function ($q, $id) {
            return $q->where('id', $id);
        })
        ->when($box, function ($q, $box) {
            return $q->where(function ($q) use ($box) {
                $q->where('comment', 'LIKE', "%{$box}%");
            });
        });

        // ソート処理
        $query->sortable();

        // 検索結果
        $reviews = $query->orderBy('id', 'desc')->paginate(10);

        return view('members.reviewlist')->with('reviews', $reviews);
    }

    // 商品レビュー登録
    public function ReviewsForm()
    {
        $products = Product::all();
        return view('members.reviewregister', ['products' => $products]);
    }

    // 商品レビュー確認画面へ
    public function ReviewsConfirm(Request $request)
    {
    $product_id = $request->products;
    $product = Product::find($product_id);
    $review = Review::where('product_id', $product_id)->get();
    $avg_evaluation = ceil($review->avg('evaluation'));

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

    return view('members.reviewconfirm', compact('post', 'avg_evaluation', 'product', 'product_id', 'review'));
    }

    // 商品レビュー登録完了画面へ
    public function ReviewsComplete(Request $request)
    {
        //セッションから取得
        $product_id = $request->product_id;
        $review = $request->session()->get('review');

        $userId = 2;

        // DBインサート
        Review::create([
        'member_id' => $userId,
        'product_id' => $product_id,
        'evaluation' => $review['evaluation'],
        'comment' => $review['comment'],
        ]);

        return redirect('/members/reviewlist');
    }

    // 商品レビュー編集画面
    public function ReviewUpdate($id)
    {
        $review = Review::find($id);
        $products = Product::where('id', $review->product_id)->get();

        return view('members.reviewedit', compact('review', 'products'));
    }

    // 確認画面の表示
    public function ReviewUpdateConfirm(Request $request)
    {
        $update_id = $request->id;
        $product = Product::where('id', $request->products)->first();
        $review = Review::where('product_id', $request->products)->get();
        $avg_evaluation = ceil($review->avg('evaluation'));
        
        // バリデーション
        $this->validate($request, [
            'evaluation' => 'required|in:1,2,3,4,5',
            'comment' => 'required|max:500',
        ]);

        // 確認画面の表示        
        $post = $request->all();
        
        // セッションに保存
        $request->session()->put('review', [
            'id' => $update_id,
            'product_id' => $product->id,
            'evaluation' => $post['evaluation'],
            'comment' => $post['comment'],
        ]);

        return view('members.revieweditconfirm', compact('post', 'update_id', 'product', 'avg_evaluation'));
    }

    public function ReviewUpdateComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();
            
        //セッションから取得
        $update_review = $request->session()->get('review');
        // セッションから編集対象のレビューIDを取得;
        $update_id = $update_review['id'];
    
        // 編集対象のレビューを取得
        $review = Review::find($update_id);

        // レビューの編集
        $review->evaluation = $update_review['evaluation'];
        $review->comment = $update_review['comment'];
        $review->product_id = $update_review['product_id'];
        $review->save();

        return redirect('/members/reviewlist');
    }                                                      

    // 商品レビュー詳細画面の表示
    public function ReviewShow($id)
    {
        $review = Review::where('id', $id)->first();
        $product = Product::where('id', $review->product_id)->first();
        $avg_evaluation = ceil($review->avg('evaluation'));

        return view('members.reviewshow', compact('product', 'avg_evaluation', 'review'));
    }

    // 削除実行
    public function ReviewWithdrawal($id)
    {
        $review = Review::find($id);
        $review->delete();

        return redirect('/members/reviewlist');
    }
}