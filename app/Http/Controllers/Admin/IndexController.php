<?php

namespace App\Http\Controllers\Admin;

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

class IndexController extends Controller
{
    // 登録画面の表示
    public function index()
    {        
        $user = Auth::guard('admin')->user();
        return view('admin.index', compact('user'));
    }
}                                                            