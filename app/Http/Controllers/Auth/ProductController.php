<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ProductController extends Controller
{
    public function ProductForm()
     {
        return view('products.register');
     }

     public function ProductConfirm()
     {
        return view('products.confirm');
     }
}

