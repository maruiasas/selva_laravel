@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員情報確認画面') }}</div>
                    <div class="form-group row">
                        <label for="text" class="col-md-8 col-form-label text-md-right">{{ __('会員登録が完了しました。') }}</label>
                    </div>

                    <div class="card-body">
                    <form method="POST" action="{{ route('home') }}">
                        @csrf
                        <div class="form-group row mb-6">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('トップに戻る') }}
                                </button>
                            </div>
                        </div>          
                    </form>
                    </div>
@endsection