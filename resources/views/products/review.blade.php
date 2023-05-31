@extends('layouts.app')

@section('title')
    商品レビュー一覧
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

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

        <div class="row">
            <div class="col-8 offset-2 bg-white">
                <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">商品レビュー一覧
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
            @if(isset($product->image_1))
                <img src="/images/{{$product->image_1}}" width="150" height="150">
            @endif
        </div>

        <div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
            @if(isset($product->name))
                {{ $product->name }}
            @endif
        </div>

        <div class="text-center text-center pb-3 pt-3" style="font-size: 16px">
            @if(isset($avg_evaluation))
                総合評価 
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                @endfor
                    {{ $avg_evaluation }}
            @endif
        </div>

        <div class="form-group row">
            <table class="table">
                @foreach ($reviews as $review)
                    <tr>
                        <td>
                            @if(isset($review->members->nickname))  
                                {{ $review->members->nickname }}さん
                            @endif
                        </td>
                        <td>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i > $review->evaluation ? 'filled' : '' }}"></i>
                        @endfor
                            {{ $review->evaluation }}
                        </td>
                        <td>
                            {{ __('■商品コメント') }}<br>{{ $review->comment }}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $reviews->links('vendor.pagination.default') }}
        </div>
        
        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='{{ route('products.show', ['id'=>$product->id]) }}'">{{ __('商品詳細に戻る') }}</button>
        </div>    
    </div>
@endsection