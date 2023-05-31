@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品カテゴリ登録') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/categorylist'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 1000px;">
                        <form method="POST" action="{{ route('members.categoryconfirm') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id" class="text-md-center">{{ __('商品大カテゴリID：') }} {{ __('登録後に自動発番') }}</label>
                            </div>    

                            <div class="form-group">
                                <label for="categories" class="text-md-center">{{ __('商品大カテゴリ') }}</label>

                                <div class="row">
                                    <div class="col-md-8">
                                        <input id="categories" type="text" class="form-control @error('categories') is-invalid @enderror" name="categories" value="{{ old('categories') }}" required autocomplete="categories">

                                        @error('categories')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>    
                                </div>
                            </div>

                            <div>{{ __('商品小カテゴリ') }}</div>
                            @for($i=1; $i<=10; $i++)
                            @php
                                $subcategories = "subcategories".$i;
                            @endphp

                            <div class="form-group">
                                <label for="subcategories" class="text-md-center"></label>

                                <input type="text" name="{{ $subcategories }}" class="form-control @error($subcategories) is-invalid @enderror" value="{{ old($subcategories) }}">
                                @error($subcategories)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @endfor

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
