@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員情報確認画面') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('complete') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('氏名') }} {{ __(session()->get('name_sei'))}} {{session()->get('name_mei')}}</label>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-7 col-form-label text-md-right">ニックネーム {{ __(session()->get('nickname'))}}</label>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-6 col-form-label text-md-right">{{ __('性別') }} 
                            @if ((session()->get('gender') === "1")) 男性
                            @else 女性
                            @endif
                        </label>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-8 col-form-label text-md-right">{{ __('パスワード') }} セキュリティのため非表示</label>
                            <input name="password" type="hidden" value="{{session()->get('password')}}">
                    </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-8 col-form-label text-md-right">{{ __('メールアドレス') }} {{ __(session()->get('email'))}}</label>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('登録完了') }}</button>
                                <button type="button" onclick="history.back()">{{ __('前に戻る') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
