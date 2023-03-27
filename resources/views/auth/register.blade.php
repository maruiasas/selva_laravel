@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('会員情報登録') }}</div>

                <div class="card-body" style="height: 600px;">
                    <form method="POST" action="{{ route('confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                            <div class="col-md-4">
                                姓<input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror" name="name_sei" value="{{ old('name_sei') }}" required autocomplete="name_sei" autofocus>
                                名<input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror" name="name_mei" value="{{ old('name_mei') }}" required autocomplete="name_mei" autofocus>

                                @error('name_sei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @error('name_mei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('ニックネーム') }}</label>

                            <div class="col-md-4">
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname">

                                @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('性別') }}</label>

                            <div class="col-md-4">
                                <input id="gender" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="1">男性
                                <input id="gender" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="2">女性
                                
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード確認') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="new-email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-6">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('確認画面へ') }}</button>
                                <button type="button" class="btn btn-primary" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
