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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品レビュー登録確認') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/reviewlist'">{{ __('一覧に戻る') }}</button>
                        </div>
                    </div>
                </div>

                <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
                    @if($product->image_1)
                        <img src="/images/{{$product->image_1}}" width="150" height="150">
                    @endif
                </div>

                <div class="text-center pb-3 pt-3" style="font-size: 20px">
                    {{ __('商品ID:') }}{{ $product_id }}
                </div>

                <div class="text-center pb-3 pt-3" style="font-size: 20px">
                    {{ $product->name }}
                </div>

                <div class="text-center pb-3 pt-3" style="font-size: 20px">
                    総合評価 
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                    @endfor
                        {{ $avg_evaluation }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('members.reviewcomplete') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="product_content" class="col-md-12 col-form-label text-md-center">{{ __('商品ID：') }} {{ __('登録後に自動発番') }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="product_content" class="col-md-12 col-form-label text-md-center">{{ __('商品評価：') }}
                            {{ $post['evaluation'] }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="product_content" class="col-md-12 col-form-label text-md-center">{{ __('商品コメント：') }}
                                {{ $post['comment'] }}</label>
                        </div>

                        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-block btn-primary col-md-4">{{ __('登録完了') }}</button>
                        </div>
                        <input name="product_id" type="hidden" value="{{ $product_id }}">

                        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="history.back();">{{ __('前に戻る') }}</button>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection