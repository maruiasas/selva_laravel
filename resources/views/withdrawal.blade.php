@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                    </div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</button>
                    </div>
                </div>

                <div class="card-body" style="height: 300px;">
                    <h5>退会します。よろしいですか？</h5>

                    <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/mypage'">{{ __('マイページに戻る') }}</button>
                    </div>
                    <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/destroy'">{{ __('退会する') }}</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection