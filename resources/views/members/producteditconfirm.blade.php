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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品編集確認画面') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('members.producteditcomplete') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="id" class="col-md-7 col-form-label text-md-right">{{ __('ID') }} {{ $post['id'] }} </label>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品名') }} {{ $post['name'] }} </label>
                    </div>

                    <div class="form-group row">
                        <label for="product_categories" class="col-md-7 col-form-label text-md-right">{{ __('商品カテゴリ') }} {{ $category_name }} > {{ $subcategory_name }}</label>
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

                    <input type="hidden" name="id" value="{{ $post['id'] }}">

                    <div class="form-group row">
                        <label for="product_content" class="col-md-7 col-form-label text-md-right">{{ __('商品の説明') }} {{ $post['product_content'] }}</label>
                    </div>
                </div>

                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">{{ __('編集完了') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection