@extends('layouts.app')

@section('content')
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <div class="container">

    <div class="row">
        <div class="col-8 offset-2 bg-white">
            <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">商品レビュー登録完了
                <div class="font-weight-bold text-right border-bottom pb-3 pt-3" style="font-size: 12px">
                    <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/list'">{{ __('トップに戻る') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <h4>商品レビューの登録が完了しました。</h4>
    </div>

    @auth
    <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
        <button type="submit" class="btn btn-primary col-md-8" onclick="location.href='{{ route('products.review', ['id'=>$product_id]) }}'">{{ __('商品レビュー一覧へ') }}</button>
    </div>
    @endauth
    
    <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
        <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='{{ route('products.show', ['id'=>$product_id]) }}'">{{ __('商品詳細に戻る') }}</button>
    </div> 
@endsection