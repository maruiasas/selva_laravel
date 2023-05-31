@extends('layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-version/dist/jquery-version.min.js"></script>
<script src="{{ asset('js/my.js') }}"></script>

<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" >
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品レビュー管理') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/'">{{ __('トップに戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 1270px;">
                        <div class="form-group">

                            <table class="table">
                                @foreach($reviews as $review)
                                <tr>
                                    <td>
                                        @if($review->product['image_1'])
                                            <img src="/images/{{$review->product['image_1']}}" width="150" height="150">
                                        @endif
                                    </td>
                                    <td>
                                            {{ $review->product['categories']->name }} > {{ $review->product['subcategories']->name }}
                                        <br><br>
                                            {{ $review->product['name'] }}
                                        <br><br>  
                                            @if($review->evaluation)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star{{ $i > $review->evaluation ? 'filled' : '' }}"></i>
                                                @endfor
                                                    {{ $review->evaluation }}
                                            @endif
                                        <br>
                                            {{ Str::limit($review->comment, 32, '…') }}
                                        <br><br>
                                            <a href="{{ route('reviews.edit', ['id'=>$review->id]) }}" class="btn btn-primary">レビュー編集</a>
                                            <a href="{{ route('reviews.delete', ['id'=>$review->id]) }}" class="btn btn-primary">レビュー削除</a>
                                    </td>
                                </tr>    
                                @endforeach
                            </table>
                            {{ $reviews->links('vendor.pagination.default') }}
                        
                            <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                                <button type="button" class="btn btn-block btn-secondary col-md-4" onclick="location.href='/mypage'">{{ __('マイページに戻る') }}</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection