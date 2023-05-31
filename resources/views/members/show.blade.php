@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('会員詳細') }}</div>
                    <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                        <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/members/list'">{{ __('一覧へ戻る') }}</button>
                    </div>
                </div>

                <div class="card-body" style="height: 600px;">
                    <div class="form-group">
                        <label for="id" class="col-md-7 col-form-label text-md-right">{{ __('ID：') }} {{ $member->id }}</label>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('氏名：') }} {{ $member->name_sei }} {{ $member->name_mei }} </label>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('ニックネーム：') }} {{ $member->nickname }}</label>
                    </div>

                    <div class="form-group">
                        <label for="gender" class="col-md-6 col-form-label text-md-right">{{ __('性別：') }}
                            @if (($member->gender == "1")) 男性
                                @else 女性
                            @endif
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-8 col-form-label text-md-right">{{ __('パスワード：') }} セキュリティのため非表示</label>
                            <input name="password" type="hidden" value="{{ $member->password }}">
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-8 col-form-label text-md-right">{{ __('メールアドレス：') }} {{ $member->email }}</label>
                    </div>

                    <div class="form-group" style="display:flex; justify-content:center;">
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.update', ['id' => $member->id]) }}'">{{ __('編集') }}</button>
                        <button type="button" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.withdrawal', ['id' => $member->id]) }}'">{{ __('削除') }}</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection