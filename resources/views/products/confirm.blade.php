@extends('layouts.app')

@section('title')
    商品登録確認画面
@endsection

@section('content')
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
                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">商品登録確認画面</div>
                <form method="POST" action="{{ route('products.confirm') }}" class="p-5" enctype="multipart/form-data">
                    @csrf

                    {{-- 商品名 --}}
                    <div class="form-group mt-3">
                        <label for="name">商品名 {{ __(session()->get('name_sei'))}} {{session()->get('name_mei')}} </label>
                    </div>

                    {{-- 商品カテゴリ --}}
                    <div class="form-group mt-3">
                        <label for="product_category_id">商品カテゴリ {{ __(session()->get('name_sei'))}} </label>
                        <label for="product_subcategory_id"> {{ __(session()->get('name_sei'))}} </label>
                    </div>

                    {{-- 商品写真 --}}
                    <div>商品写真</div>
                    <span class="item-image-form image-picker">
                        <input type="hidden" name="image_1" class="d-none" accept="image/png,image/jpeg,image/gif" id="item-image" />
                        <label for="item-image" class="d-inline-block" role="button">
                            <img src="/images/item-image-default.png" style="object-fit: cover; width: 300px; height: 300px;">
                        </label>
                    </span>

                    <span class="item-image-form image-picker">
                        <input type="hidden" name="image_2" class="d-none" accept="image/png,image/jpeg,image/gif" id="item-image" />
                        <label for="item-image" class="d-inline-block" role="button">
                            <img src="/images/item-image-default.png" style="object-fit: cover; width: 300px; height: 300px;">
                        </label>
                    </span>

                    <span class="item-image-form image-picker">
                        <input type="hidden" name="image_3" class="d-none" accept="image/png,image/jpeg,image/gif" id="item-image" />
                        <label for="item-image" class="d-inline-block" role="button">
                            <img src="/images/item-image-default.png" style="object-fit: cover; width: 300px; height: 300px;">
                        </label>
                    </span>

                    <span class="item-image-form image-picker">
                        <input type="hidden" name="image_4" class="d-none" accept="image/png,image/jpeg,image/gif" id="item-image" />
                        <label for="item-image" class="d-inline-block" role="button">
                            <img src="/images/item-image-default.png" style="object-fit: cover; width: 300px; height: 300px;">
                        </label>
                    </span>
                    <!-- @error('item-image')
                        <div style="color: #E4342E;" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror -->

                    {{-- 商品の説明 --}}
                    <div class="form-group mt-3">
                        <label for="description">商品の説明</label>
                        <textarea id="product_content" class="form-control @error('description') is-invalid @enderror" name="product_content" required autocomplete="description" autofocus>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-0 mt-3">
                        <button type="submit" class="btn btn-block btn-secondary">確認画面へ</button>
                        <button type="button" class="btn btn-block btn-secondary" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection