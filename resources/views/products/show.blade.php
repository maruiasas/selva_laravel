@extends('layouts.app')

@section('content')
<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" >

    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 bg-white">
                <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">商品詳細
                    <div class="font-weight-bold text-right border-bottom pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/list'">{{ __('トップに戻る') }}</button>
                    </div>
                </div>

                <div class="form-group row">
                    {{ $category_name }} > {{ $subcategory_name }}
                </div>

                <div class="form-group row">
                    <div class="font-weight-bold pb-3 pt-3" style="font-size: 24px">{{ $product->name }}</div>
                    <label for="updated_at" class="col-md-7 col-form-label"><br>更新日時：{{ date('Ymd', strtotime($product->updated_at)) }}</label>
                </div>

                <div class="form-group row">
                    @if($product->image_1)
                        <img src="/images/{{$product->image_1}}" width="150" height="150">
                    @endif
                    @if($product->image_2)
                        <img src="/images/{{$product->image_2}}" width="150" height="150">
                    @endif
                    @if($product->image_3)    
                        <img src="/images/{{$product->image_3}}" width="150" height="150">
                    @endif
                    @if($product->image_4)
                        <img src="/images/{{$product->image_4}}" width="150" height="150">
                    @endif
                </div>

                <div class="form-group row">
                    <label for="product_content" class="col-md-7 col-form-label">■商品説明<br>{{ $product->product_content }}</label>
                </div>

                <div class="form-group row">
                    <label for="product_content" class="col-md-7 col-form-label">■商品レビュー
                        <br><br>
                        総合評価 
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                        @endfor
                            {{ $avg_evaluation }}
                        <br><br><a href="/products/review/{{$product->id}}">>>レビューを見る</a>
                    </label>
                </div>

                @auth
                <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                    <button type="button" name="review" class="btn btn-primary col-md-8" onclick="location.href='{{ route('products.reviewregist', ['id'=>$product->id]) }}'">{{ __('この商品についてのレビューを登録') }}</button>
                </div>
                @endauth

                <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                    <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="history.back();">{{ __('商品一覧に戻る') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection