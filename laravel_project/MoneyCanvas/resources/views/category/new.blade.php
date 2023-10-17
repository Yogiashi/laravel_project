@extends('layout')
@section('content')
<div class="row">
    <div class="col-12 col-md-5 mt-5 mx-auto">
        <div class="card text-center">
            <h2 class="card-header bg-dark text-white">カテゴリ登録</h2>
            <div class="card-body">
                <form action="{{ route('categoryCreate') }}" method="POST" >
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group mt-3">
                    <label for="name" class="mr-2">カテゴリ名 (必須)</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="食費、家賃...">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{$errors->first('name')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">カラー</label>
                        <input type="color" name="color" id="color">
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">登録する</button>
                </form>
            </div>
        </div>
    </div>   
</div>
<div class="row">
    <div class="col-6 mx-auto">
        <div class="mt-5">
             @include('category.index', ['categories' => $categories])
        </div>
    </div>
</div>
@endsection