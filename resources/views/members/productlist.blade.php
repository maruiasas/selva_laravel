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
                    <div class="font-weight-bold text-left" style="font-size: 24px">{{ __('商品一覧') }}</div>
                        <div class="font-weight-bold text-right pb-3 pt-3" style="font-size: 12px">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/admin/home'">{{ __('トップへ戻る') }}</button>
                        </div>
                    </div>

                    <div class="card-body" style="height: 1500px;">

                        <div class="form-group" style="display:flex; ">
                            <button type="button" class="btn btn-primary col-md-2" onclick="location.href='/members/productregister'">{{ __('商品登録') }}</button>
                        </div>

                        <div class="form-group">

                            <form method="GET" action="{{ route('members.productlist') }}" class="p-5" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="id" class="text-md-center">{{ __('ID') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control col-md-5" name="id">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="box" class="text-md-center">{{ __('フリーワード') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control col-md-7" name="box">
                                    </div>
                                </div>

                                <div class="form-group mb-0 mt-5" style="display:flex; justify-content:center;">
                                    <button type="submit" name="search" class="btn btn-primary col-md-4">{{ __('検索する') }}</button>
                                </div>
                            </form>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>@sortablelink('id', 'ID')</th>
                                        <th>商品名</th>
                                        <th>@sortablelink('created_at', '登録日時')</th>
                                        <th>編集</th>
                                        <th>詳細</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            @if($product->id)
                                                {{ $product->id }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($product->name))
                                            <a href="{{ route('members.productshow', ['id'=>$product->id]) }}">{{ $product->name }}</a>
                                            @endif
                                        </td>    
                                        <td>
                                            @if($product->created_at)
                                                {{ $product->created_at->format('Y/m/d') }}
                                            @endif
                                        </td>
                                        <td><a href="{{ route('members.productedit', ['id'=>$product->id]) }}" class="btn btn-primary">編集</a></td>
                                        <td><a href="{{ route('members.productshow', ['id'=>$product->id]) }}" class="btn btn-primary">詳細</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->appends(request()->input())->links('vendor.pagination.default') }}
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection