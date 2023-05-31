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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品レビュー詳細') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/home'">{{ __('トップへ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 800px;">

                        <div class="form-group">
                                <label for="image_1" class="col-md-7 col-form-label text-md-right">
                                    @if(isset($product->image_1))
                                        <img src="/images/{{$product->image_1}}" width="150" height="150">
                                    @endif
                                </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="id" class="col-md-7 col-form-label text-md-right">{{ __('商品ID：') }} 
                                @if(isset($product->id))
                                    {{ $product->id }}
                                @endif
                            </label>
                        </div>    

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">
                                @if(isset($product->name))
                                    {{ $product->name }}
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('総合評価') }}
                                @if(isset($avg_evaluation))
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i > $avg_evaluation ? 'filled' : '' }}"></i>
                                    @endfor
                                        {{ $avg_evaluation }}
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品レビューID') }}<br>{{ $review->id }}</label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品評価') }}<br>{{ $review->evaluation }}</label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-7 col-form-label text-md-right">{{ __('商品コメント') }}<br>{{ $review->comment }}</label>
                        </div>

                        <div class="form-group mb-5 mt-5" style="display:flex; justify-content:center;">
                            <button type="submit" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.reviewedit', ['id'=>$review->id]) }}'">{{ __('編集') }}</button>
                            <button type="submit" class="btn btn-primary col-md-4" onclick="location.href='{{ route('members.reviewwithdrawal', ['id'=>$review->id]) }}'">{{ __('削除') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
