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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品レビュー削除確認') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                        </div>
                    </div>
                </div>

                <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
                    @if($review->product->image_1)
                        <img src="/images/{{$review->product->image_1}}" width="150" height="150">
                    @endif
                </div>

                <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
                    {{ $review->product->name }}
                </div>

                <div class="text-center pb-3 pt-3" style="font-size: 20px">
                    総合評価 
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                    @endfor
                        {{ $avg_evaluation }}
                </div>

                <form method="POST" action="/review/deletecomplete" class="p-5" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $id }}">
                        <div class="form-group row">
                            <label for="product_content" class="col-md-6 col-form-label text-md-right">{{ __('商品評価：') }}
                                {{ $review->evaluation }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="product_content" class="col-md-8 col-form-label text-md-right">{{ __('商品コメント：') }}
                                {{ $review->comment }}</label>
                        </div>

                    <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                        <button type="submit" class="btn btn-primary col-md-4">{{ __('レビューを削除する') }}</button>
                    </div>

                    <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/review/master'">{{ __('前に戻る') }}</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>    
</div>    
@endsection