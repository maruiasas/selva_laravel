@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="col-8 offset-2 bg-white">
                    <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">会員情報変更</div>
                    <form method="POST" action="{{ route('updateconfirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                            <div class="col-md-4">
                                姓<input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror" name="name_sei" value="{{ Auth::user()->name_sei }}" required autocomplete="name_sei" autofocus>
                                名<input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror" name="name_mei" value="{{ Auth::user()->name_mei }}" required autocomplete="name_mei" autofocus>

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
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ Auth::user()->nickname }}" required autocomplete="nickname">

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
                                <input id="gender" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="1" {{ (Auth::user()->gender == '1') ? 'checked' : '' }}>男性
                                <input id="gender" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="2" {{ (Auth::user()->gender == "2") ? 'checked' : '' }}>女性
                                
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4">{{ __('確認画面へ') }}</button>
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
@endsection
