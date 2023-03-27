@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            パスワード再設定の案内メールを送信しました。<br>
                            (まだパスワード再設定は完了しておりません)<br>
                            届きましたメールに記載されている <br>
                            『パスワード再設定URL』 をクリックし、<br>
                            パスワードの再設定を完了させてください。<br>
                    @else
                            パスワード再設定用の URL を記載したメールを送信します。<br>
                            ご登録されたメールアドレスを入力してください。<br><br>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-10">
                                        <br>    
                                        <button type="submit" class="btn btn-primary">{{ __('送信する') }}</button>
                        @endif
                                        <a class="btn btn-primary" href="{{ route('/') }}">{{ __('トップに戻る') }}</a>
                                    </div>
                                </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
