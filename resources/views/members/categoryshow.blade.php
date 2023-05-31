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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品カテゴリ詳細') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/categorylist'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 800px;">
                        <div class="form-group">
                            <label for="id"class="col-md-7 col-form-label text-md-right">{{ __('商品大カテゴリID：') }} {{ $category->id }}</label>
                        </div>    

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品大カテゴリ：') }} {{ $category->name }}</label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品小カテゴリ：') }}                                @foreach($subcategories as $subcategory)
                                {{ $subcategory->name }}<br>
                            @endforeach</lavel>
                        </div>

                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.categoryedit', ['id'=>$category->id]) }}'">{{ __('編集') }}</button>
                            <button type="submit" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.categorywithdrawal', ['id'=>$category->id]) }}'">{{ __('削除') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
