@extends('layout')
@section('content')
<div class="row">
    <div class="mt-5 col-md-5 mx-auto">
        <div class="card text-center">
            <h2 class="card-header text-center bg-dark text-light">編集フォーム</h2>
            <div class="card-body">
                <form action="{{ route('update') }}" method="POST">
                @csrf
                    <div class="btn-group btn-group-toggle form-group" data-toggle="buttons" style="width: 300px;">
                        <label class="btn btn-success active">
                            <input type="radio" name="type" id="income" value="収入" {{ old ('type', $record->type) == '収入' ? 'checked' : '' }} class="form-control"> 収入
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="type" id="spending" value="支出" {{ old ('type', $record->type) == '支出' ? 'checked' : '' }} class="form-control"> 支出
                        </label>
                    </div>
                    <input type="hidden" name="id" value="{{ $record->id }}">
                    <div class="form-group">
                        <label for="date">日付</label>
                        <input type="date" name="date" id="date" value="{{ $record->date }}" class="form-control">
                        @if ($errors->has('date'))
                            <div class="text-danger">
                                {{$errors->first('date')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category">カテゴリ</label>
                        <select name="category_id" id="category" size="1" required class="form-control">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id', $category->id) == $category->id) selected @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">金額</label>
                        <input type="number" name="amount" id="amount" value="{{ $record->amount }}" class="form-control">
                        @if ($errors->has('amount'))
                            <div class="text-danger">
                                {{$errors->first('amount')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="note" class="text-top">備考</label>
                        <input type="text" name="note" id="note" value="{{ $record->note }}" class="form-control">
                    </div>
                    <div>
                        <a class="btn btn-secondary mx-2" href="{{route('show', $record->id)}}">キャンセル</a>
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>
@endsection