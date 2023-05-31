@extends('layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>
@section('content')

<script>
    $(function () {
        // 商品カテゴリの変更イベントを検知
        $('#product_categories').on('change', function (){
            // 選択されたカテゴリのIDを取得
            let id = $("#product_categories").val();

            // Ajaxリクエストを送信
            $.ajax({
                type: "GET",
                url: "/products/category",
                data: { "id" : id },
                dataType : "json"
            })
            .done(function(data){ // 成功時の処理
                // 処理内容
            })
            .fail(function (data) {
                // エラー処理
            });
        });

        // 画像アップロードのイベントを検知
        $("[name^='image_']").on('change', function() {
            // csrfをセット
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            // アップロードするファイルのデータ取得
            let fileData = this.files[0];
            // フォームデータを作成する
            let formData = new FormData();
            // フォームデータにアップロードファイルの情報を追加
            formData.append('file', fileData);

            let uncle = $(this).parent().prev();

            // Ajaxリクエストを送信
            $.ajax({
            type: "POST",
            url: "/members/upload",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            })
            .done(function(data){ // 成功時の処理

            console.log(fileData);
            // JSONオブジェクトを受信したら、'upload'キーに対応する値を取得する
            var uploadPath = data.upload;
        
            // 画面に表示するために、適切なHTML要素を作成する
            var imgElement = "<img src='" + uploadPath + "'/>";

            // 作成したHTML要素を、適切な場所に挿入する
        uncle.html(imgElement);

            }).fail(function (data) {
            // error
            alert('ファイルの容量が大きすぎます');
            });
        });
                });
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品編集') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/productlist'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 1000px;">
                        <form method="POST" action="{{ route('members.producteditconfirm') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id" class="text-md-center">{{ __('ID：') }} {{ $product->id }}</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="text-md-center">{{ __('商品名') }}</label>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" required autocomplete="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_categories" class="text-md-center">{{ __('商品カテゴリ') }}</label>

                                <div class="col-md-4">
                                    <select 
                                        id="product_categories"
                                        name="product_categories"
                                        class="form-control {{ $errors->has('product_categories') ? 'is-invalid' : '' }}">
                                        @foreach($product_categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $selected_category ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                        
                                        @error('product_categories')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select 
                                        id="product_subcategories"
                                        name="product_subcategories"
                                        class="form-control {{ $errors->has('product_subcategories') ? 'is-invalid' : '' }}">

                                        @foreach($product_subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $selected_subcategory ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach

                                        @error('product_subcategories')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_image" class="text-md-center">{{ __('商品写真') }}</label>
                                <div class="col-md-4">
                                    
                                    {{ __('写真1') }}
                                    <div id="image_1">
                                        @if($product->image_1)
                                            <img src="/images/{{ $product->image_1 }}" width="200" height="200">
                                        @endif
                                    </div>
                                    <label>
                                        <input type="file" style="display:none;" id="image_1" name="image_1" accept="png, jpeg, ipg, gif" class="form-control @error('image_1') is-invalid @enderror" value="{{ $product->image_1 }}">
                                        {{ __('アップロード') }}
                                        
                                        @error('image_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </label>
                                    
                                    <br>
                                    {{ __('写真2') }}
                                    <div id="image_2">
                                        @if($product->image_2)
                                            <img src="/images/{{ $product->image_2 }}" width="200" height="200">
                                        @endif
                                    </div>
                                    <label>
                                        <input type="file" style="display:none;" id="image_2" name="image_2" accept="png, jpeg, ipg, gif" class="form-control @error('image_2') is-invalid @enderror" value="{{ $product->image_2 }}">
                                        {{ __('アップロード') }}
                                        
                                        @error('image_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </label>

                                    <br>
                                    {{ __('写真3') }}
                                    <div id="image_3">
                                        @if($product->image_3)
                                            <img src="/images/{{ $product->image_3 }}" width="200" height="200">
                                        @endif
                                    </div>

                                    <label>
                                        <input type="file" style="display:none;" id="image_3" name="image_3" accept="png, jpeg, ipg, gif" class="form-control @error('image_3') is-invalid @enderror" value="{{ $product->image_3 }}">
                                        {{ __('アップロード') }}
                                        
                                        @error('image_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </label>

                                    <br>
                                    {{ __('写真4') }}
                                    <div id="image_4">
                                        @if($product->image_4)
                                            <img src="/images/{{ $product->image_4 }}" width="200" height="200">
                                        @endif
                                    </div>

                                    <label>
                                        <input type="file" style="display:none;" id="image_4" name="image_4" accept="png, jpeg, ipg, gif" class="form-control @error('image_4') is-invalid @enderror" value="{{ $product->image_4 }}">
                                        {{ __('アップロード') }}

                                            @error('image_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="product_image1" value="{{ $product->image_1 }}">
                            <input type="hidden" name="product_image2" value="{{ $product->image_2 }}">
                            <input type="hidden" name="product_image3" value="{{ $product->image_3 }}">
                            <input type="hidden" name="product_image4" value="{{ $product->image_4 }}">

                            <div class="form-group">
                                <label for="product_content" class="text-md-center">{{ __('商品の説明') }}</label>
                                    <input id="product_content" type="text" class="form-control @error('product_content') is-invalid @enderror" name="product_content" value="{{ $product->product_content }}" required autocomplete="product_content">

                                    @error('product_content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
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
