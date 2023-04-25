@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    @Auth
                    ようこそ {{ Auth::user()->name_sei }} {{ Auth::user()->name_mei }} 様
                    @endif

                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/list'">{{ __('商品一覧') }}</a>
                    </div>
                    @guest
                        @if (Route::has('register'))
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='{{ route('register') }}'">{{ __('新規会員登録') }}</a>
                        </div>
                        @endif
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='{{ route('login') }}'">{{ __('ログイン') }}</a>
                    </div>
                    @else
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/products/register'">{{ __('新規商品登録') }}</button>
                    </div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/mypage'">{{ __('マイページ') }}</button>
                    </div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</button>
                    </div>
                    @endguest
                </div>
            </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
