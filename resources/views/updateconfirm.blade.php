@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員情報変更確認画面') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updatecomplete') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('氏名：') }} {{ $post['name_sei'] }} {{ $post['name_mei'] }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="product_categories" class="col-md-7 col-form-label text-md-right">{{ __('ニックネーム：') }} {{ $post['nickname'] }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-6 col-form-label text-md-right">{{ __('性別：') }} 
                                @if (($post['gender'] === "1")) 男性
                                    @else 女性
                                @endif
                            </label>
                        </div>
                    
                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4">{{ __('変更完了') }}</button>
                        </div>
                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="history.back()">{{ __('前に戻る') }}</button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection