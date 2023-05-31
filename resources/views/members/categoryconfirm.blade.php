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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品カテゴリ登録確認') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/members/list'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 800px;">
                        <form method="POST" action="{{ route('members.categorycomplete') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id"class="col-md-7 col-form-label text-md-right">{{ __('商品大カテゴリID') }} {{ __('登録後に自動発番') }}</label>
                            </div>    

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品大カテゴリ') }} {{ $post['categories'] }}</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品小カテゴリ') }} {{ $post['subcategories1'] }}</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories2']){{ $post['subcategories2'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories3']){{ $post['subcategories3'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories4']){{ $post['subcategories4'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories5']){{ $post['subcategories5'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories6']){{ $post['subcategories6'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories7']){{ $post['subcategories7'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories8']){{ $post['subcategories8'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories9']){{ $post['subcategories9'] }}@endif</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">@if($post['subcategories10']){{ $post['subcategories10'] }}@endif</label>
                            </div>

                            <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                                <button type="submit" class="btn btn-primary col-md-4">{{ __('登録完了') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
