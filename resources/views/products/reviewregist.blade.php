@extends('layouts.app')

@section('title')
    商品レビュー登録
@endsection

@section('content')
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" >

    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2 bg-white">
            <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">商品レビュー登録
                <div class="font-weight-bold text-right border-bottom pb-3 pt-3" style="font-size: 12px">
                    <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/list'">{{ __('トップに戻る') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
            @if($product->image_1)
                <img src="/images/{{$product->image_1}}" width="150" height="150">
            @endif
    </div>

    <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">{{ $product->name }}</div>

    <div class="text-center text-center pb-3 pt-3" style="font-size: 16px">
        総合評価 
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
        @endfor
            {{ $avg_evaluation }}
    </div>

    <form method="POST" action="/review/confirm" class="p-5" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }} ">
        <div class="form-group row">
            <label for="evaluation" class="col-md-4 col-form-label text-md-right">{{ __('商品評価') }}</label>

            <div class="col-md-2">
                <select 
                    id="evaluation"
                    name="evaluation"
                    class="form-control {{ $errors->has('evaluation') ? 'is-invalid' : '' }}"
                    value="">
                    <option value="">選択</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>

                    @error('evaluation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('商品コメント') }}</label>

            <div class="col-md-4">
                <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{ old('comment') }}" required autocomplete="product_content">

                @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
            <button type="submit" class="btn btn-block btn-secondary col-md-4">{{ __('商品レビュー登録確認') }}</button>
        </div>

        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="history.back();">{{ __('商品詳細に戻る') }}</button>
        </div>
    </form>
@endsection