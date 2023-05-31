@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="col-8 offset-2 bg-white">
                    <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">メールアドレス変更 認証コード入力</div>
                    <form method="POST" action="{{ route('emailcomplete') }}">
                        @csrf

                        <h6>(※メールアドレスの変更はまだ完了していません)
                            <br>
                            変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。
                        </h6>

                        <div class="form-group row">
                            <label for="authCode" class="col-md-4 col-form-label text-md-right">{{ __('認証コード') }}</label>

                            <div class="col-md-4">
                                <input id="authCode" type="text" class="form-control @error('authCode') is-invalid @enderror" name="authCode" value="{{ old('authCode') }}" required autocomplete="authCode">

                                @error('authCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="new_email" value="{{ $new_email }}">
                        <input type="hidden" name="updateId" value="{{ $updateId }}">
                        
                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-12">{{ __('認証コードを送信してメールアドレスの変更を完了する') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
