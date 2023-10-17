@extends('layout')
@section('content')
<div class="row">
    <div class="mt-5 col-md-5 mx-auto">
        <div class="card">
            <h2 class="card-header text-center text-light bg-dark">カテゴリ編集フォーム</h2>
            <div class="card-body text-center">
                <form action="{{ route('categoryUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                    <div class="form-group">
                        <label for="name">カテゴリ</label>
                        <input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{$errors->first('name')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">カラー</label>
                        <input type="color" name="color" id="color" value="{{ $category->color }}">
                    </div>
                    <div>
                        <a class="btn btn-secondary mx-2" href="{{route('categoryNew')}}">キャンセル</a>
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
