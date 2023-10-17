@extends('layout')
@section('content')
<div class="row">
    <div class="col-12 col-md-5 mt-5 mx-auto">
        <div class="card text-center">
            <h2 class="card-header text-center bg-dark text-white">予算作成</h2>
            <div class="card-body">
            <form action="{{ route('budgetCreate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="month">月 (必須)</label>
                        <select name="month" id="month" class="form-control">
                        <option value="" selected>選択してください</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>
                                {{ date('n月', mktime(0, 0, 0, $i, 1) )}}
                            </option>
                        @endfor
                        </select>
                        @if ($errors->has('month'))
                            <div class="text-danger">
                                {{$errors->first('month')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="category_id">カテゴリ (必須)</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" selected>選択してください</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">
                                {{$errors->first('category_id')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="amount">予算 (必須)</label>
                        <input type="text" name="amount" id="amount" class="form-control" placeholder="半角で入力してください">
                        @if ($errors->has('amount'))
                            <div class="text-danger">
                                {{$errors->first('amount')}}
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">登録する</button>
                </form>
            </div>
        </div>
    </div>   
</div>
@endsection