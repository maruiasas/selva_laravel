@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('マイページ') }}</div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                    </div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</button>
                    </div>
                </div>

                <div class="card-body" style="height: 400px;">
                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('氏名') }} {{ Auth::user()->name_sei }} {{ Auth::user()->name_mei }} </label>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('ニックネーム') }} {{ Auth::user()->nickname }}</label>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-6 col-form-label text-md-right">{{ __('性別') }}
                            @if ((Auth::user()->gender === "1")) 男性
                                @else 女性
                            @endif
                        </label>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-8 col-form-label text-md-right">{{ __('パスワード') }} セキュリティのため非表示</label>
                            <input name="password" type="hidden" value="{{ Auth::user()->password }}">
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-8 col-form-label text-md-right">{{ __('メールアドレス') }} {{ Auth::user()->email }}</label>
                    </div>

                    @auth
                        <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/withdrawal'">{{ __('退会') }}</button>
                        </div>
                    @endauth
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection