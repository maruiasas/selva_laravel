@extends('layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" >
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品一覧') }}</div>
                    @auth
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/register'">{{ __('新規商品登録') }}</button>
                    </div>
                    @endauth
                </div>

                <div class="card-body" style="height: 2050px;">
                    <div class="form-group">

                        <form method="GET" action="{{ route('products.list') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="text-md-right">{{ __('カテゴリ') }}</label>
                                <div class="col-md-5">
                                    <select 
                                        id="product_categories"
                                        name="product_categories"
                                        class="form-control {{ $errors->has('product_categories') ? 'is-invalid' : '' }}"
                                        value="{{ old('product_categories') }}">

                                        @foreach($product_categories as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <select 
                                        id="product_subcategories"
                                        name="product_subcategories"
                                        class="form-control {{ $errors->has('product_subcategories') ? 'is-invalid' : '' }}"
                                        value="{{ old('product_subcategories') }}">
                                        <option value="" class="option"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="box" class="text-md-right">{{ __('フリーワード') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control col-md-7" name="box">
                                </div>
                            </div>

                            <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                                <button type="submit" name="search" class="btn btn-primary col-md-4">{{ __('商品検索') }}</button>
                            </div>
                        </form>

                        <table class="table">
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image_1)
                                        <img src="/images/{{$product->image_1}}" width="150" height="150">
                                    @endif
                                </td>
                                <td>
                                    @if (isset($product->categories))
                                        {{ $product->categories->name }}>{{ $product->subcategories->name }}
                                    @endif
                                </td>
                                <td><a href="{{ route('products.show', ['id'=>$product->id]) }}">{{ $product->name }}</a></td>
                                <td>
                                    @if (isset($product->reviews->first()->avg_evaluation))
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i > $product->reviews->first()->avg_evaluation ? 'filled' : '' }}"></i>
                                        @endfor
                                            {{ $product->reviews->first()->avg_evaluation }}
                                    @endif
                                </td>
                                <td><a href="{{ route('products.show', ['id'=>$product->id]) }}" class="btn btn-primary">詳細</a></td>
                            </tr>
                            @endforeach
                        </table>
                        {{ $products->appends(request()->input())->links('vendor.pagination.default') }}
                    
                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/products/list'">{{ __('トップに戻る') }}</button>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection