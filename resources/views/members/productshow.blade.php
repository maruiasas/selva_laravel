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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品詳細') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/productlist'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 1800px;">
                        <div class="form-group">
                            <label for="id" class="col-md-7 col-form-label text-md-right">{{ __('商品ID：') }} {{ $product->id }}</label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品名：') }} {{ $product->name }}</label>
                        </div>

                        <div class="form-group">
                            <label for="categories" class="col-md-7 col-form-label text-md-right">{{ __('商品カテゴリ：') }} {{ $product->categories->name }} > {{ $product->subcategories->name }}</label>
                        </div>

                        <div class="form-group">
                            <label for="image_1" class="col-md-7 col-form-label text-md-right">{{ __('商品写真1：') }}
                                @if($product->image_1)
                                    <img src="/images/{{$product->image_1}}" width="150" height="150">
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="image_2" class="col-md-7 col-form-label text-md-right">{{ __('商品写真2：') }}
                                @if($product->image_2)
                                    <img src="/images/{{$product->image_2}}" width="150" height="150">
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="image_3" class="col-md-7 col-form-label text-md-right">{{ __('商品写真3：') }}
                                @if($product->image_3)
                                    <img src="/images/{{$product->image_3}}" width="150" height="150">
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="image_4" class="col-md-7 col-form-label text-md-right">{{ __('商品写真4：') }}
                                @if($product->image_4)
                                    <img src="/images/{{$product->image_4}}" width="150" height="150">
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="product_content" class="col-md-8 col-form-label text-md-right">{{ __('商品説明：') }} {{ $product->product_content }}</label>
                        </div>

                        <div class="font-weight-bold text-center" style="font-size: 24px">{{ __('総合評価') }}
                            @if(isset($avg_evaluation))
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                                @endfor
                                    {{ $avg_evaluation }}
                            @endif
                        </div>

                        <br><br>

                        <div class="form-group">
                            <table class="table">
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>
                                            {{ __('商品レビューID') }}<br>{{ $review->id }}
                                        </td>
                                        <td>
                                            @if(isset($review->members->nickname))  
                                                <a href="{{ route('members.show', ['id' => $review->members->id]) }}">{{ $review->members->nickname }}</a>さん
                                            @endif
                                        </td>
                                        <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i > $review->evaluation ? 'filled' : '' }}"></i>
                                        @endfor
                                            {{ $review->evaluation }}
                                        </td>
                                        <td>
                                            {{ __('商品コメント') }}<br>{{ $review->comment }}
                                        </td>
                                        <td>
                                        <button type="button" class="btn btn-secondary col-md-8" onclick="location.href='{{ route('members.reviewshow', ['id' => $review->id]) }}'">{{ __('商品レビュー詳細') }}</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $reviews->links('vendor.pagination.default') }}
                        </div>

                        <br><br>

                        <div class="form-group" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.productedit', ['id' => $product->id]) }}'">{{ __('編集') }}</button>
                            <button type="button" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.productwithdrawal', ['id' => $product->id]) }}'">{{ __('削除') }}</button>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection