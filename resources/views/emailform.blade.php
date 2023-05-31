@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="col-8 offset-2 bg-white">
                    <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">メールアドレス変更</div>
                    <form method="GET" action="{{ route('emailconfirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('現在のメールアドレス：') }} </label>
                            <div class="col-md-4">
                                {{ Auth::user()->email }}
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_email" class="col-md-4 col-form-label text-md-right">{{ __('変更後のメールアドレス') }}</label>

                            <div class="col-md-4">
                                <input id="new_email" type="text" class="form-control @error('new_email') is-invalid @enderror" name="new_email" value="{{ old('new_email') }}">

                                @error('new_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4">{{ __('認証メール送信') }}</button>
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
