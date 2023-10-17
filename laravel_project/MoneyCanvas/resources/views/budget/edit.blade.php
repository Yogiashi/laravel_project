@extends('layout')
@section('content')
<div class="row">
    <div class="col-12 col-md-5 mt-5 mx-auto">
        <div class="card text-center">
            <h2 class="card-header text-center bg-dark text-light">予算編集</h2>
            <div class="card-body">
                <form action="{{ route('budgetUpdate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $budget->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="month">月</label>
                        <select name="month" id="month" class="form-control">
                            <option value="" selected>選択してください</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $budget->month == $i ? 'selected' : '' }}>
                                    {{ date('n月', mktime(0, 0, 0, $i, 1) )}}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">カテゴリ</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $budget->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">予算</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{ $budget->amount }}">
                        @if ($errors->has('amount'))
                            <div class="text-danger">
                                {{$errors->first('amount')}}
                            </div>
                        @endif
                    </div>
                    <a class="btn btn-secondary mx-2" href="{{route('budgetIndex')}}">キャンセル</a>
                    <button type="submit" class="btn btn-primary">更新する</button>
                </form>
            </div>
        </div>
    </div>   
</div>
@endsection