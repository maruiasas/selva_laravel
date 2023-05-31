@extends('layouts.app', ['authgroup'=>'admin'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('管理画面メインメニュー') }}</div>
                        <p>ようこそ {{ $user->name }} さん</p>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</button>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="height: 300px;">

                    <div class="form-group" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='/admin/members/list'">{{ __('会員一覧') }}</button>
                    </div>

                    <div class="form-group" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='/members/categorylist'">{{ __('商品カテゴリ一覧') }}</button>
                    </div>

                    <div class="form-group" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='/members/productlist'">{{ __('商品一覧') }}</button>
                    </div>

                    <div class="form-group" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='/members/reviewlist'">{{ __('商品レビュー一覧') }}</button>
                    </div>

                </div>
            </div> 
        </div>
    </div>
</div>
@endsection