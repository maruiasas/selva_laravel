@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="col-8 offset-2 bg-white">
                    <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">パスワード変更</div>
                    <form method="POST" action="{{ route('passwordform') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-4">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード確認') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="new_password_confirmation" value="">

                                @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4">{{ __('パスワードを変更') }}</button>
                        </div>
                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/mypage'">{{ __('マイページに戻る') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
