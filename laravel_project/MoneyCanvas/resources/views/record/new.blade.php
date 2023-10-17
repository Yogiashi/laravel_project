@extends('layout')
@section('content')
<div class="row">
    <div class="mt-5 col-md-5 mx-auto">
        <div class="card">
            <h2 class="card-header text-center bg-dark text-light">記録フォーム</h2>
            <div class="card-body text-center">
                <form action="{{ route('create') }}" method="POST">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="btn-group btn-group-toggle form-group" data-toggle="buttons" style="width: 300px;">
                        <label class="btn btn-success active">
                            <input type="radio" name="type" id="income" value="収入" {{ old ('type') == '収入' ? 'checked' : '' }} class="form-control"> 収入
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="type" id="spending" value="支出" {{ old ('type') == '支出' ? 'checked' : '' }} class="form-control"> 支出
                        </label>
                    </div>
                    @if ($errors->has('type'))
                        <div class="text-danger mb-3">
                            {{$errors->first('type')}}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="date">日付 (必須)</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-control">
                        @if ($errors->has('date'))
                            <div class="text-danger">
                                {{$errors->first('date')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category">カテゴリ (必須)</label>
                        <select name="category_id" id="category" size="1" class="form-control">
                            <option value="" selected>選択してください</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">
                                {{$errors->first('category_id')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="amount">金額 (必須)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="form-control" placeholder="半角で入力してください">
                        @if ($errors->has('amount'))
                            <div class="text-danger">
                                {{$errors->first('amount')}}
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="note" class="text-top">備考</label>
                        <input type="text" name="note" id="note" value="{{ old('note') }}" class="form-control">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">記録する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection