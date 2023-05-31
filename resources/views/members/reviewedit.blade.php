@extends('layouts.app')

@section('content')
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" >

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品レビュー編集') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/reviewlist'">{{ __('一覧に戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 600px;">
                        <form method="POST" action="{{ route('members.revieweditconfirm') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="products" class="text-md-center">{{ __('商品') }}</label>

                                <div class="col-md-4">
                                    <select 
                                        id="products"
                                        name="products"
                                        class="form-control {{ $errors->has('products') ? 'is-invalid' : '' }}">
                                        
                                        @foreach($products as $id => $product)
                                            <option value="{{ $product->id }}" {{ old('products') == $id ? 'selected' : ''}}>{{ $product->name }}</option>
                                        @endforeach
                                        
                                        @error('products')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id" class="text-md-center">{{ __('ID：') }} {{ $review->id }}</label>
                            </div>

                            <div class="form-group">
                                <label for="evaluation" class="col-md-4 col-form-label">{{ __('商品評価') }}</label>

                                <div class="col-md-2">
                                    <select 
                                        id="evaluation"
                                        name="evaluation"
                                        class="form-control {{ $errors->has('evaluation') ? 'is-invalid' : '' }}">
                                        
                                        <option value="">選択</option>
                                        <option value="1" {{ old('evaluation', $review->evaluation) == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('evaluation', $review->evaluation) == 2 ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ old('evaluation', $review->evaluation) == 3 ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ old('evaluation', $review->evaluation) == 4 ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ old('evaluation', $review->evaluation) == 5 ? 'selected' : '' }}>5</option>
                                    </select>

                                    @error('evaluation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-md-4 col-form-label">{{ __('商品コメント') }}</label>

                                <div class="col-md-4">
                                    <textarea id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" required autocomplete="product_content">{{ $review->comment }}</textarea>

                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input name="id" type="hidden" value="{{ $review->id }}">

                            <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                                <button type="submit" class="btn btn-primary col-md-4">{{ __('確認画面へ') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection