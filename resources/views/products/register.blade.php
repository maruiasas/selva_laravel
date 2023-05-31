@extends('layouts.app')

@section('title')
    商品登録
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 bg-white">
                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">商品登録</div>
                <form method="POST" action="{{ route('products.confirm') }}" class="p-5" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('商品名') }}</label>

                        <div class="col-md-4">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_categories" class="col-md-4 col-form-label text-md-right">{{ __('商品カテゴリ') }}</label>

                        <div class="col-md-4">
                            <select 
                                id="product_categories"
                                name="product_categories"
                                class="form-control {{ $errors->has('product_categories') ? 'is-invalid' : '' }}">
                                
                                @foreach($product_categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('product_categories') == $id ? 'selected' : ''}}>{{ $name }}</option>
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

                                @foreach($product_subcategories as $id => $name)
                                    <option value="{{ $id }}" {{ old('product_subcategories') == $id ? 'selected' : ''}}>{{ $name }}</option>
                                @endforeach

                                @error('product_subcategories')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="product_image" class="col-md-4 col-form-label text-md-right">{{ __('商品写真') }}</label>
                        <div class="col-md-4">
                            
                            {{ __('写真1') }}
                            <div id="image_1">
                                <div id="image_1">
                                @if(old('image_1'))
                                    <img src="/images/{{ $imagePath2 }}" width="200" height="200">
                                @endif
                                </div>
                                <label>
                                    <input type="file" style="display:none;" id="image_1" name="image_1" accept="png, jpeg, ipg, gif" class="form-control @error('image_1') is-invalid @enderror" value="{{ old('image_1') }}">
                                    {{ __('アップロード') }}
                                    
                                    @error('image_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                            </div>    
                            
                            <br>
                            {{ __('写真2') }}
                            <div id="image_2">
                                <div id="image_2">
                                @if(isset($imagePath2))
                                    <img src="/images/{{ $imagePath2 }}" width="200" height="200">
                                @endif
                                </div>
                                <label>
                                    <input type="file" style="display:none;" id="image_2" name="image_2" accept="png, jpeg, ipg, gif" class="form-control @error('image_2') is-invalid @enderror" value="{{ old('image_2') }}">
                                    {{ __('アップロード') }}
                                    
                                    @error('image_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                            </div>

                            <br>
                            {{ __('写真3') }}
                            <div id="image_3">
                                <div id="image_3">
                                @if(isset($imagePath3))
                                    <img src="/images/{{ $imagePath3 }}" width="200" height="200">
                                @endif
                                </div>

                                <label>
                                    <input type="file" style="display:none;" id="image_3" name="image_3" accept="png, jpeg, ipg, gif" class="form-control @error('image_3') is-invalid @enderror" value="{{ old('image_3') }}">
                                    {{ __('アップロード') }}
                                    
                                    @error('image_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                            </div>

                            <br>
                            {{ __('写真4') }}
                            <div id="image_4">
                                <div id="image_4">
                                @if(isset($imagePath4))
                                    <img src="/images/{{ $imagePath4 }}" width="200" height="200">
                                @endif
                                </div>

                                <label>
                                    <input type="file" style="display:none;" id="image_4" name="image_4" accept="png, jpeg, ipg, gif" class="form-control @error('image_4') is-invalid @enderror" value="{{ old('image_4') }}">
                                    {{ __('アップロード') }}
                                    
                                    @error('image_4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_content" class="col-md-4 col-form-label text-md-right">{{ __('商品の説明') }}</label>

                        <div class="col-md-4">
                            <input id="product_content" type="text" class="form-control @error('product_content') is-invalid @enderror" name="product_content" value="{{ old('product_content') }}" required autocomplete="product_content">

                            @error('product_content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                        <button type="submit" class="btn btn-primary col-md-4">{{ __('確認画面へ') }}</button>
                    </div>
                    <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
