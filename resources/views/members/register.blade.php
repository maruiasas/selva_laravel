@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('会員登録') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/members/list'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 800px;">
                        <form method="POST" action="{{ route('members.confirm') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id" class="text-md-center">{{ __('ID：') }} {{ __('登録後に自動発番') }}</label>
                            </div>    

                            <div class="form-group">
                                <label for="name" class="text-md-center">{{ __('氏名') }}</label>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror" name="name_sei" value="{{ old('name_sei') }}" required autocomplete="name_sei">
                                        @error('name_sei')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror" name="name_mei" value="{{ old('name_mei') }}" required autocomplete="name_mei">
                                        @error('name_mei')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="nickname" class="text-md-center">{{ __('ニックネーム') }}</label>

                                <div class="row">
                                    <div class="col-md-5">
                                        <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname">

                                        @error('nickname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="text-md-center">{{ __('性別') }}</label>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-check form-check-inline">
                                            <input id="male" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}>男性
                                            <input id="female" type="radio" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="new-gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>女性
                                        
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-md-center">{{ __('パスワード') }}</label>

                                <div class="row">
                                    <div class="col-md-7">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                                        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="text-md-center">{{ __('パスワード確認') }}</label>

                                <div class="row">
                                    <div class="col-md-7">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-md-center">{{ __('メールアドレス') }}</label>

                                <div class="row">
                                    <div class="col-md-7">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="new-email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>    
                                </div>
                            </div>

                            <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                                <button type="submit" class="btn btn-primary col-md-4">{{ __('確認画面へ') }}</button>
                            </div>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
