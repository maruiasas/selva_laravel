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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('会員編集') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/members/list'">{{ __('一覧へ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 500px;">
                        <form method="POST" action="{{ route('members.updatecomplete') }}" class="p-5" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id"class="col-md-7 col-form-label text-md-right">{{ __('ID：') }} {{ $post['id'] }}</label>
                            </div>    

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('氏名') }} {{ $post['name_sei'] }} {{ $post['name_mei'] }}</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('ニックネーム') }} {{ $post['nickname'] }}</label>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-md-6 col-form-label text-md-right">{{ __('性別') }} 
                                    @if (( $post['gender'] == "1")) 男性
                                    @else 女性
                                    @endif
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-8 col-form-label text-md-right">{{ __('パスワード') }} セキュリティのため非表示</label>
                                    <input name="password" type="hidden" value="{{ $post['password'] }}">
                            </div>

                                <div class="form-group">
                                    <label for="email" class="col-md-8 col-form-label text-md-right">{{ __('メールアドレス') }} {{ $post['email'] }}</label>
                                </div>

                            <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                                <button type="submit" class="btn btn-primary col-md-4">{{ __('編集完了') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
