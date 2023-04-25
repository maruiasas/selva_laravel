@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品登録確認画面') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('products.complete') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品名') }} {{ $post['name'] }} </label>
                    </div>

                    <div class="form-group row">
                        <label for="product_categories" class="col-md-7 col-form-label text-md-right">{{ __('商品カテゴリ') }} {{ $post['product_categories'] }} > {{ $post['product_subcategories'] }}</label>
                    </div>

                    <div class="form-group row">
                        <label for="image_1" class="col-md-7 col-form-label text-md-right">{{ __('写真1') }}
                            @if($post['image_1'])
                                <img src="/images/{{ $post['image_1'] }}" width="200" height="200">
                            @endif
                        </label>

                        <label for="image_2" class="col-md-7 col-form-label text-md-right">{{ __('写真2') }}
                            @if($post['image_2'])
                                <img src="/images/{{ $post['image_2'] }}" width="200" height="200">
                            @endif
                        </label>

                        <label for="image_3" class="col-md-7 col-form-label text-md-right">{{ __('写真3') }}
                            @if($post['image_3'])
                                <img src="/images/{{ $post['image_3'] }}" width="200" height="200">
                            @endif      
                        </label>

                        <label for="image_4" class="col-md-7 col-form-label text-md-right">{{ __('写真4') }}
                            @if($post['image_4'])
                                <img src="/images/{{ $post['image_4'] }}" width="200" height="200">
                            @endif
                        </label>
                    </div>

                    <div class="form-group row">
                        <label for="product_content" class="col-md-7 col-form-label text-md-right">{{ __('商品の説明') }} {{ $post['product_content'] }}</label>
                    </div>
                </div>

                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">{{ __('登録完了') }}</button>
                        <button type="button" class="btn btn-block btn-secondary" onclick="history.back()">{{ __('前に戻る') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection